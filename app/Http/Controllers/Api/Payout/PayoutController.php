<?php

namespace App\Http\Controllers\Api\Payout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Freeze;
use App\Models\Charge;
use App\Jobs\MoneyDashpayoutJob;

class PayoutController extends Controller
{
   public function payoutdata(Request $request){
        $clientdata = $request->get('auth_user');
        $clientUrl  = $clientdata->payin_url ?? null;

        if (!$clientUrl) {
            return response()->json([
                'success' => false,
                'message' => 'Payout Callback URL not found.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($clientdata->user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }
       

        $rules = [
                'amount'         => 'required|numeric|max:200000',
                'account_number' => 'required|string|max:255',
                'ifsc_code'      => 'required|string|max:20',
                'account_name'   => 'required|string|max:255',
                'trxid'          => 'required|string|unique:payout_payment,cus_trx_id',
            ];
                
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        
            $validated = $validator->validated();
            $ifsc = strtoupper($validated['ifsc_code']);

            try {
                $ifscApiResponse = file_get_contents("https://ifsc.razorpay.com/{$ifsc}");
                $ifscData = json_decode($ifscApiResponse, true);
        
                if (!isset($ifscData['BANK'])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unable to fetch bank details from IFSC.'
                    ], Response::HTTP_BAD_REQUEST);
                }
                $bankName = $ifscData['BANK'];
            } catch (\Throwable $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unable to fetch IFSC details: ' . $e->getMessage()
                ], Response::HTTP_BAD_REQUEST);
            }

            $amount = (int) $validated['amount'];
            
            $chargeSlabs = Charge::where('type', 'payout')->where('user_id', $user->id)->get();
            $appliedCharge = 0;
        
            foreach ($chargeSlabs as $slab) {
                if ($amount >= $slab->start_range && $amount <= $slab->end_range) {
                    $appliedCharge = $slab->charge_type === 'fixed'
                        ? $slab->charges
                        : ($amount * $slab->charges) / 100;
                    break;
                }
            }
        
            $finalAmount = $amount + $appliedCharge;
            $payoutPaymentId = null;
            $currentWalletBalance = 0;
            
           

            try {
                    DB::transaction(function () use ($user, $validated, $appliedCharge, $amount, $finalAmount, &$payoutPaymentId, $bankName, &$currentWalletBalance) {
            
                        $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            
                        if ($lockedUser->wallet_amount < $finalAmount) {
                            throw new \Exception('Insufficient Wallet Balance. Please Recharge.');
                        }
            
                        $freezeamount = Freeze::where("user_id", $lockedUser->id)->first();
                        if ($freezeamount) {
                            $availableBalance = $lockedUser->wallet_amount - ($freezeamount->amount ?? 0);
                            if ($availableBalance < $finalAmount) {
                                throw new \Exception("Your Wallet Balance {$freezeamount->amount} Lien.");
                            }
                        }
            
                        // Deduct balance
                        $lockedUser->wallet_amount -= $finalAmount;
                        $lockedUser->save();
            
                        $currentWalletBalance = $lockedUser->wallet_amount;
                       
                      
                        // Insert payout record as PENDING
                        $payoutPaymentId = DB::table("payout_payment")->insertGetId([
                            'cus_trx_id'         => $validated["trxid"],
                            "name"               => $validated["account_name"],
                            "account_number"     => $validated["account_number"],
                            "amount"             => $amount,
                            "ifsc"               => strtoupper($validated["ifsc_code"]),
                            "status"             => 'PENDING',
                            "usercharges"       => $appliedCharge,
                            "merchant_id"       => $lockedUser->id,
                            "payment_source"     => "Api",
                            "payouttype"        => 'Money',
                            "lastwallet_balance"=> $currentWalletBalance,
                            "txnRcvdTimeStamp"  => now()->format('d-m-Y H:i:s.v'),
                            "created_at"  => now(),
                        ]);
                    }, 5);

                     $clientRefno = "OROPAPUOT" . now()->format("ymdHis") . rand(1000, 9999999);
                     $payload = [
                        "apiToken"        => 'f062d2a0c3580ea3f52b0aad4919906c',
                        "associateId"     => '5116',
                        "paymentMode"     => 'IMPS',
                        "latitude"        => '27.802',
                        "longitude"       => '75.036',
                        "agentTransactionId" => $clientRefno,
                    ];

                    $update = DB::table('payout_payment')->where('id', $payoutPaymentId)->update([ 'trx_id' => $clientRefno]);
                     MoneyDashpayoutJob::dispatch(
                        $payoutPaymentId,
                        $payload,
                        $user->id,
                        $finalAmount
                    );

          
        }catch (\Exception $e) 
            {
                return response()->json([
                    "status" => "error",
                    "message" => $e->getMessage()
                ], 500);
            }
   }
}
