<?php

namespace App\Http\Controllers\admin\Payin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Payin;

class PayinController extends Controller
{
    public function payinstatus(Request $request)
    {
        $transactionId = $request->transactionid;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://moneydashtechsol.in/api/v1/payin/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'txn_id' => $transactionId
            ]),
            CURLOPT_HTTPHEADER => [
                'X-API-KEY: api_qXspRnNqHzOARWWBLLbRw8IOY25xlEPXpqmuRZtb',
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            curl_close($curl);
            return response()->json([
                'success' => false,
                'message' => 'Curl Error: ' . curl_error($curl)
            ], 500);
        }

        curl_close($curl);

        // Decode JSON response
        $data = json_decode($response, true);
      dd($data);
        if (!isset($data['data'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API response',
                'response' => $data
            ], 400);
        }

        DB::table('payins')
            ->where('systemgenerateid', $transactionId)
            ->update([
                'status' => $data['data']['gateway_response']['status'] ?? null,
                'amount' => (int) ($data['data']['gateway_response']['amount'] ?? 0),
                'utr'    => $data['data']['gateway_response']['rrn'] ?? ''

            ]);

        return response()->json([
            'success' => true,
            'message' => 'Payin status updated successfully',
            'utr'     => $data['data']['gateway_response']['rrn'],
            'txnStatus' => $data['data']['gateway_response']['status']
        ]);
    }


    public function payindata(Request $request)
    {
    
        $query = DB::table('payins')
            ->leftJoin('users', 'users.id', '=', 'payins.user_id')
            ->select('payins.*','users.name as merchantname');
        
         if ($request->key && $request->search_data) {

            if (in_array($request->key, ['systemgenerateid','utr', 'order_id'])) {
                $query->where("payins.{$request->key}", 'LIKE', '%' . $request->search_data . '%');
            }
        }
        
        if ($request->filled('start_date')) {
        $query->where('payins.created_at', '>=', $request->start_date . ' 00:00:00');
        }
    
        if ($request->filled('end_date')) {
            $query->where('payins.created_at', '<=', $request->end_date . ' 23:59:59');
        }
    
        if (
            $request->filled('status') &&
            in_array($request->status, ['success', 'pending', 'failed','rejected'])
        ) {
            $query->where('payins.status', $request->status);
        }
        
        $data = $query->orderBy('payins.id', 'DESC')->paginate(100);
       
        return view('admin.payin.payindata',compact('data'));
    }

     public function settlementdata()
    {
        $data = DB::table('settlements')
            ->leftJoin('users', 'users.id', '=', 'settlements.user_id')
            ->select(
                'settlements.*',
                'users.name as merchantname'
            )
            ->orderBy('settlements.id', 'DESC')
            ->paginate(20);
    
        return view('admin.payin.settlement', compact('data'));
    }

    public function settleapproved(Request $request)
    {
       
        // âœ… Correct validation keys
        $request->validate([
            'user_id'    => 'required|integer|exists:users,id',
            'amount'     => 'required|numeric|min:1',
            'charges'    => 'nullable|numeric|min:0',
            'settletype' => 'required|in:wallet,account',
        ]);

        DB::beginTransaction();

        try {

            $amount        = (float) $request->amount;
            $charges       = (float) ($request->charges ?? 0);
            $finalAmount   = $amount - $charges;

            if ($finalAmount <= 0) {
                return back()->withErrors(['amount' => 'Final amount must be greater than zero']);
            }

        
            $user = User::lockForUpdate()->findOrFail($request->user_id);

        
            if ($request->settletype === 'wallet') {

                $user->increment('wallet_amount', $finalAmount);
                $walletBalance = $user->wallet_amount;

            } else {
                // Account settlement (wallet change nahi)
                $walletBalance = $user->wallet_amount;
            }

            
            DB::table('settlements')->insert([
                'user_id'        => $request->user_id,
                'oldamount'      => $request->settleoldamount,
                'amount'         => $amount,
                'charges'        => $charges,
                'final_amount'   => $finalAmount,
                'wallet_balance' => $walletBalance,
                'type'           => $request->settletype,
                'status'         => 'success',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Settlement created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getUsersForSettlement()
    {
       
        $userdata = DB::table('payins')
            ->leftJoin('users', 'users.id', '=', 'payins.user_id')
            ->where('payins.status', 'success')
            ->select(
                'payins.user_id',
                'users.name as merchantname',
                DB::raw('SUM(payins.amount) as total_amount')
            )
            ->groupBy('payins.user_id', 'users.name')
            ->get();
            
    
        foreach ($userdata as $row) {
    
            $currentbalance = DB::table('payins')
                ->where('status', 'success')
                ->where('user_id', $row->user_id)
                ->sum('amount');
                
    
            $settlebalance = DB::table('settlements')
                ->where('user_id', $row->user_id)
                ->whereIn('status', ['success', 'Pending'])
                ->sum('amount');
     
            $row->settlementamount = $currentbalance - $settlebalance;
    
            $row->charges = DB::table('charges')
                ->where('user_id', $row->user_id)
                ->where('type', 'payin')
                ->first(); // ðŸ‘ˆ single charge
                
        }
    
        
        return response()->json($userdata);
    }




   

}
