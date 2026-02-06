<?php

namespace App\Http\Controllers\user\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Charge;
use App\Models\Payout;
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
            'ifsc_code'       => 'required|string|max:15',
            'bank_name'       => 'required|string|max:255',
            'account_number'  => 'required|string|max:20',
            'account_name'    => 'required|string|max:255',
            'amount'           => 'required|numeric|min:100|max:200000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $user       = Auth::user();
        $isNew = empty($request->id);
        $amount     = (float) $validated['amount'];

        $chargeSlabs = Charge::where('type', 'payout')->where('user_id', $user->id)->get(['start_range as start', 'end_range as end', 'charge_type as type', 'charges as charge']);

        $ifsc = strtoupper($validated['ifsc_code']);

        try {
            $ifscData = json_decode(file_get_contents("https://ifsc.razorpay.com/{$ifsc}"), true);

            if (!isset($ifscData['BANK'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid IFSC Code'
                ], 400);
            }

            $bankName = $ifscData['BANK'];
            $branch   = $ifscData['BRANCH'];
        } 
        catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'IFSC API error: ' . $e->getMessage()
            ], 400);
        }

       
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

        if ($user->wallet_amount < $finalAmount) {
            return response()->json([
                'status' => 'error',
                'walletmessage' => 'Insufficient Wallet Balance',
            ], 409);
        }

        if ($isNew) {
                $exists = Payout::where("account_number",$validated["account_number"])->where("ifsc_code", $validated["ifsc_code"])->exists();

                if ($exists) {
                    return response()->json(
                        [
                            "status" => "error",
                            "message" => "Beneficiary account already exists",
                        ],
                        JsonResponse::HTTP_CONFLICT
                    );
                }
            }

        DB::beginTransaction();
        try {

            $lockedUser = User::lockForUpdate()->find($user->id);
            $currentWalletBalance = $lockedUser->wallet_amount;

            if ($currentWalletBalance < $finalAmount) {
                throw new \Exception("Wallet changed, insufficient balance");
            }

            $lockedUser->decrement('wallet_amount', $finalAmount);

            // ✅ Client Ref No
            $clientRefno = "OROWEB" . now()->format("ymdHis") . rand(1000, 9999999);

            // ✅ API Payload
            $payload = [
                "token"         => "79Jk2BHqojrpGKTTpWpnFNJR5Mq5dU",
                "request_id"    => $clientRefno,
                "bene_account"  => $validated["account_number"],
                "bene_ifsc"     => $ifsc,
                "bene_name"     => $validated["account_name"],
                "amount"        => $amount,
                "currency"      => "INR",
                "narration"      => "Vendor Payment",
                "payment_mode"   => "IMPS",
                "bank_name"      => $bankName,
                "bank_branch"    => $branch
            ];

            $url = "https://dashboard.shreefintechsolutions.com/api/payout/v2/transaction";
            $response = Http::timeout(90)->post($url, $payload);

            if (!$response->successful()) {
                throw new \Exception("ORO API failed");
            }

            $responseData = $response->json();

            if (data_get($responseData, 'message') == 'Insufficient payout wallet balance') {
                $lockedUser->increment('wallet_amount', $finalAmount);
                DB::commit();

                return response()->json([
                    "status" => false,
                    "message" => "Request Rejected"
                ]);
            }

            $payout = Payout::updateOrCreate(
                ['id' => $request->id],
                [
                    "bank_name"       => $bankName,
                    "ifsc_code"       => $ifsc,
                    "account_number"  => $validated["account_number"],
                    "account_name"    => $validated["account_name"],
                    "user_id"         => $user->id,
                ]
            );

            DB::table("payout_payment")->insert([
                'cus_trx_id'          => $clientRefno,
                'systemid'            => data_get($responseData, 'response.CBX_API_REF_NO'),
                'name'                => $validated["account_name"],
                'account_number'      => $validated["account_number"],
                'amount'              => $amount,
                'ifsc'                => $ifsc,
                'status'              => 'pending',
                'usercharges'         => $appliedCharge,
                'merchant_id'         => $lockedUser->id,
                'payment_source'      => "Web",
                'payouttype'           => 'Money',
                'lastwallet_balance'   => $currentWalletBalance,
                'txnRcvdTimeStamp'     => now()->format('d-m-Y H:i:s.v'),
                'created_at'           => now(),
            ]);

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "Payout request successfully submitted",
                "data" => $payout
            ]);

        } 
        catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

}
