<?php

namespace App\Http\Controllers\user\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Charge;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class PaymentController extends Controller
{
     public function getBankData(Request $request)
    {
        $ifsc = strtoupper($request->ifsc); // Convert IFSC to uppercase
        $url = "https://ifsc.razorpay.com/" . $ifsc;

        // Fetch API response
        $response = @file_get_contents($url); // Use @ to suppress warnings if the request fails

        if ($response === false) {
            return response()->json(['error' => 'Invalid IFSC Code or API error'], 400);
        }

        $ifscData = json_decode($response, true);

        if (!$ifscData || isset($ifscData['error'])) {
            return response()->json(['error' => 'Invalid IFSC Code'], 400);
        }
    
        return response()->json($ifscData);
    }

    public function index(){
        $user = Auth::user();
        return view('user.payment.sendpayment',compact( 'user'));
    }

     public function show(): JsonResponse
    {
      
        try {
            $payoutData = DB::table('payment')->where('user_id',Auth::user()->id)->get();
    
            if ($payoutData->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No payout data found.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payout data retrieved successfully.',
                'data' => $payoutData
            ], 200);

        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching payout data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendpayment(Request $request)
    {
    
        $rules = [
            'ifsc_code'      => 'required|string|max:15',
            'bank_name'      => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'account_name'   => 'required|string|max:255',
            'amount'         => 'required|numeric|min:100|max:200000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user   = Auth::user();
        $amount = (float) $request->amount;

        // ✅ Fetch charge slabs
        $chargeSlabs = Charge::where('type', 'payout')
            ->where('user_id', $user->id)
            ->get([
                'start_range as start',
                'end_range as end',
                'charge_type as type',
                'charges as charge'
            ]);

        // ✅ Calculate charge
        $appliedCharge = 0;
        foreach ($chargeSlabs as $slab) {
            if ($amount >= $slab->start && $amount <= $slab->end) {
                $appliedCharge = $slab->type === 'fixed'
                    ? (float) $slab->charge
                    : ($amount * $slab->charge) / 100;
                break;
            }
        }

        $finalAmount = $amount + $appliedCharge;

        // ✅ Wallet balance check
        if ((float) $user->wallet_amount < $finalAmount) {
            return response()->json([
                'status' => 'error',
                'walletmessage' => 'Insufficient Wallet Balance. Please Recharge.',
            ], JsonResponse::HTTP_CONFLICT);
        }

        DB::beginTransaction();
        try {

            // ✅ Insert payout request
            $payoutId = DB::table('payment')->insertGetId([
                'user_id'        => $user->id,
                'account_number' => $request->account_number,
                'bank_name'      => $request->bank_name,
                'ifsc_code'      => $request->ifsc_code,
                'account_name'   => $request->account_name,
                'amount'         => $amount,
                'charges'         => $appliedCharge,
                'status'         => 'pending',
                'created_at'     => now(),
            ]);

            // ✅ Deduct wallet amount
            DB::table('users')
                ->where('id', $user->id)
                ->decrement('wallet_amount', $finalAmount);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Payout request successfully submitted',
                'data'    => [
                    'payout_id'   => $payoutId,
                    'amount'      => $amount,
                    'charge'      => $appliedCharge,
                    'total'       => $finalAmount
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
