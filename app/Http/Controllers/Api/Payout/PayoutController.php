<?php

namespace App\Http\Controllers\Api\Payout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Freeze;
use App\Models\Charge;
use App\Jobs\ShreepayoutJob;
use App\Models\Kyc;
use App\Models\Clints;
use App\Models\PayoutPayment;

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
                $branch = $ifscData['BRANCH'];
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
                            "status"             => 'pending',
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
                        "token"       => "79Jk2BHqojrpGKTTpWpnFNJR5Mq5dU",
                        "request_id"  => $validated["trxid"],
                        "bene_account"=> $validated["account_number"],
                        "bene_ifsc"   => strtoupper($validated["ifsc_code"]),
                        "bene_name"   => $validated["account_name"],
                        "amount"      => $amount,
                        "currency"=> "INR",
                        "narration"=> "Vendor Payment",
                        "payment_mode"=> "IMPS",
                        "bank_name"=> $bankName,
                        "bank_branch"=> $branch
                    ];


                    $update = DB::table('payout_payment')->where('id', $payoutPaymentId)->update([ 'trx_id' => $clientRefno]);
                     ShreepayoutJob::dispatch(
                        $payoutPaymentId,
                        $payload,
                        $user->id,
                        $finalAmount
                    );

                    $paymentData = DB::table('payout_payment')->where('id', $payoutPaymentId)->select('systemid','trx_id','cus_trx_id','utr','txn_type','pymt_type','status','account_number','amount')->first();
                    $payloaddata = (array) $paymentData;
                    return response()->json([
                        "status" => "success.",
                        "message" => "Payout processed successfully.",
                        "data"    => $payloaddata,
                    ]);
          
        }catch (\Exception $e) 
            {
                return response()->json([
                    "status" => "error",
                    "message" => $e->getMessage()
                ], 500);
            }
   }
                    
        // ------------------------------------------------------------------------------------------//
        //------------------------Check Status API--------------------------------------------------//

        public function check_status(Request $request)
        {
            // ✅ Validation
            $validator = Validator::make($request->all(), [
                'apiRefNum' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'data'   => [
                        'resultCode'    => '422',
                        'resultStatus'  => 'Validation Failed',
                        'resultMessage' => $validator->errors()->first(),
                        'errors'        => $validator->errors(),
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $orderId = $request->apiRefNum;

            // ✅ Fetch transaction
            $txn21 = DB::table('payout_payment')
                    ->where('trx_id', $orderId)
                    ->first();

            $txn = PayoutPayment::where('trx_id', $orderId)->first();

            //  Not found
            if (!$txn) {
                return response()->json([
                    'status'   => 'error',
                    'order_id'=> $orderId,
                    'data'     => [
                        'resultCode'    => '404',
                        'resultStatus'  => 'Failed',
                        'resultMessage' => 'Invalid Order ID',
                        'data'          => []
                    ]
                ], Response::HTTP_NOT_FOUND);
            }

            // ✅ Success response (PRO FORMAT)
            return response()->json([
                'status'    => 'success',
                'order_id' => $orderId,
                'data'      => [
                    'resultCode'    => '200',
                    'resultStatus'  => ucfirst($txn->status),
                    'resultMessage' => 'Transaction ' . ucfirst($txn->status),
                    'data'          => [
                        [
                            'TransactionId'   => $txn->trx_id,
                            'CustomerRefNo'   => $txn->cus_trx_id ?? '',
                            'TransactionDate'=> Carbon::parse($txn->updated_at)
                                                        ->format('m/d/Y h:i:s A'),
                            'TxnStatus'       => $txn->status,
                            'Amount'          => (float) $txn->amount,
                            'UTR'             => $txn->utr ?? 'N/A',
                            'Remarks'         => $txn->remark ?? 'N/A',
                        ]
                    ]
                ]
            ], Response::HTTP_OK);
        }


        public function checkStatus($orderId)
        {
            $txn = PayoutPayment::where('trx_id', $orderId)->first();

            if (!$txn) {
                return response()->json([
                    'status' => 'error',
                    'order_id' => $orderId,
                    'data' => [
                        'resultCode' => '404',
                        'resultStatus' => 'Failed',
                        'resultMessage' => 'Transaction not found',
                        'data' => []
                    ]
                ], Response::HTTP_NOT_FOUND);
            }
                    
            return response()->json([
                'status' => 'success',
                'order_id' => $orderId,
                'data' => [
                    'resultCode' => '200',
                    'resultStatus' => ucfirst($txn->status),
                    'resultMessage' => 'Transaction ' . ucfirst($txn->status),
                    'data' => [
                        [
                            'TransactionId'   => $txn->trx_id,
                            'CustomerRefNo'   => $txn->cus_trx_id ?? '',
                            'TransactionDate'=> Carbon::parse($txn->updated_at)
                                                    ->format('m/d/Y h:i:s A'),
                            'TxnStatus'       => $txn->status,
                            'rrn'             => $txn->utr ?? '',
                            'PayerName'       => $txn->name ?? '',
                            'Amount'          => (float) $txn->amount,
                           
                        ]
                    ]
                ]
            ], Response::HTTP_OK);
        }




}
