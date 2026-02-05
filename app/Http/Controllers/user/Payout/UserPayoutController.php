<?php

namespace App\Http\Controllers\user\Payout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Traits\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use App\Models\Kyc;
use App\Models\User;
use App\Models\Clints;
use App\Models\PayoutPayment;

class UserPayoutController extends Controller
{
    public function userpayoutdata(Request $request){
        
        $query = DB::table("payout_payment")->leftJoin("payouts",  "payouts.id", "=", "payout_payment.payout_id")->where("payout_payment.merchant_id", Auth::user()->id);
        
         if ($request->key && $request->search_data) {
            if (in_array($request->key, ['trx_id','cus_trx_id', 'utr', 'account_number'])) {
                $query->where("payout_payment.{$request->key}", 'LIKE', '%' . $request->search_data . '%');
            }
        }

        // Filter by start_date
        if ($request->start_date) {
            $query->whereRaw(
                "STR_TO_DATE(payout_payment.txnRcvdTimeStamp, '%d-%m-%Y %H:%i:%s.%f') >= ?",
                [$request->start_date . " 00:00:00"]
            );
        }

        // Filter by end_date
        if ($request->end_date) {
            $query->whereRaw(
                "STR_TO_DATE(payout_payment.txnRcvdTimeStamp, '%d-%m-%Y %H:%i:%s.%f') <= ?",
                [$request->end_date . " 23:59:59"]
            );
        }

        if (
            $request->status &&
            in_array($request->status, ["pending", "success", "failed", "Refunded"])
        ) {
            $query->where("status", $request->status);
        }

        $data = $query->orderBy("payout_payment.id", "DESC")->paginate(100);


         return view('user.payout.payoutdata',compact('data'));
     }

     
public function slip($cus_trx_id)
{
    // Get payout record
    $payout = PayoutPayment::where('cus_trx_id', $cus_trx_id)
        ->where('merchant_id', auth()->id())
        ->first();

    if (!$payout) {
        return response()->json([
            'success' => false,
            'message' => 'Transaction not found'
        ], 404);
    }

    // API payload
    $postData = [
        "token"          => "79Jk2BHqojrpGKTTpWpnFNJR5Mq5dU",
        "transaction_id" => $payout->cus_trx_id,
        "external_ref"   => $payout->systemid
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://dashboard.shreefintechsolutions.com/api/payout/v2/get-report-status',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
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

    // Decode API response
    $responseData = json_decode($response, true);

    $status = $responseData['status_text'] ?? 'pending';
    $utr    = $responseData['utr_no'] ?? null;

    // Update DB (if not refunded)
    DB::table('payout_payment')
        ->where('systemid', $payout->systemid)
        ->where('cus_trx_id', $payout->cus_trx_id)
        ->where('status', '!=', 'refunded')
        ->update([
            'utr'           => $utr,
            'status'        => $status,
            'response_data' => json_encode($responseData),
        ]);

    // Refresh payout data
    $payout->refresh();

    return response()->json([
        'success'    => true,
        'trx_id'     => $payout->trx_id,
        'cus_trx_id' => $payout->cus_trx_id,
        'amount'     => $payout->amount,
        'status'     => $payout->status,
        'utr'        => $payout->utr,
        'created_at' => $payout->created_at,
        'api_response' => $responseData
    ]);
}

}
