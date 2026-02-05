<?php

namespace App\Http\Controllers\admin\Payout;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DB;

class PayoutController extends Controller implements HasMiddleware
{

    public static function  middleware():array
    {
        return [
            new Middleware('permission:view payout', only:['index']),
            new Middleware('permission:refund payout payment', only:['refund']),
            
        ];
    }


     public function index(Request $request){
        
        $query = DB::table('payout_payment')
            ->leftJoin('users', 'users.id', '=', 'payout_payment.merchant_id')
            ->select('payout_payment.*', 'users.name as merchantname');

        // 🔍 Key Based Search
        if ($request->key && $request->search_data) {
            if (in_array($request->key, ['trx_id','utr', 'account_number'])) {
                $query->where("payout_payment.{$request->key}", 'LIKE', '%' . $request->search_data . '%');
            }
        }
        // 📅 Date Based Filter (only when key not selected)
        else {
            if ($request->start_date) {
                $query->where('payout_payment.created_at', '>=', $request->start_date . ' 00:00:00');
            }

            if ($request->end_date) {
                $query->where('payout_payment.created_at', '<=', $request->end_date . ' 23:59:59');
            }
        }

        // Status Filter
        if ($request->status && in_array($request->status, ['success', 'pending', 'failed','Refunded'])) {
            $query->where('payout_payment.status', $request->status);
        }

        $data = $query->orderBy('payout_payment.id', 'DESC')->paginate(20);
        return view('admin.payout.index',compact('data'));
    }

     public function refund(Request $request){
        $query = DB::table('payout_payment')
        ->leftJoin('users', 'users.id', '=', 'payout_payment.merchant_id')
        ->whereIn('payout_payment.status', ['FAILED', 'failed'])
        ->select('payout_payment.*', 'users.name as merchantname');

        $data = $query->orderBy('payout_payment.id', 'DESC')->get();
         return view('admin.payout.refund',compact('data'));
     }

 
    public function payoutcheck(Request $request)
    {
        $request->validate([
            'trxid'    => 'required|string',
            'systemid' => 'required|string',
        ]);

        $postData = [
            "token"          => "79Jk2BHqojrpGKTTpWpnFNJR5Mq5dU",
            "transaction_id" => $request->trxid,
            "external_ref"   => $request->systemid
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://dashboard.shreefintechsolutions.com/api/payout/v2/get-report-status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            return response()->json([
                'success' => false,
                'error'   => $error
            ], 500);
        }

        curl_close($curl);

        // ✅ Convert JSON response to array
        $responseData = json_decode($response, true);
       
        // Update DB
        DB::table('payout_payment')
            ->where('systemid', $request->systemid)
            ->where('cus_trx_id', $request->trxid)
            ->where('status','!=','refunded')
            ->update([
                'utr'    => $responseData['utr_no'] ?? null,
                'status' => $responseData['status_text'] ?? 'pending',
                'response_data' => $responseData,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'api_response' => $responseData
        ]);
    }


    public function refundSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer'
        ]);

        
        // Transaction start
        DB::beginTransaction();

        try {
            // Get all selected payout records
            $payouts = DB::table('payout_payment')
                ->whereIn('id', $request->ids)
                ->get();

            foreach ($payouts as $payout) {
                $refundAmount = $payout->amount + $payout->usercharges;
               
                
                DB::table('payout_payment')
                    ->where('id', $payout->id)
                    ->update([
                        'status' => 'Refunded',
                        'refund_amount' => $refundAmount
                    ]);


                DB::table('users')->where('id', $payout->merchant_id)->increment('wallet_amount', $refundAmount);
                    
                    
                $callbackurl = DB::table("clints")->where('user_id', $payout->merchant_id)->first();
                   
                $updatedPayout= DB::table('payout_payment')->where('id', $payout->id)
                ->select('systemid','trx_id','cus_trx_id','utr','txn_type','pymt_type','status','account_number','amount','refund_amount')->first();
                
                 try {
                        Http::post($callbackurl->payout_url, (array) $updatedPayout);
                    } catch (\Exception $e) {
                        // Log error but don't break response
                        \Log::error('Callback failed: ' . $e->getMessage());
                    }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Selected payments refunded successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Refund failed: ' . $e->getMessage()
            ], 500);
        }
    }



}
