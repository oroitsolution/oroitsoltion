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
        $user = Auth::user();
        $payoutdata = PayoutPayment::with('user')
        ->where('merchant_id', auth()->id())
        ->get();

         return view('user.payout.payoutdata',compact('payoutdata'));
     }

     

        public function slip($cus_trx_id)
    {
        $payout = PayoutPayment::where('cus_trx_id', $cus_trx_id)
            ->where('merchant_id', auth()->id()) // security
            ->first();

        if (!$payout) {
            return response()->json([
                'message' => 'Payout not found'
            ], 404);
        }

        return response()->json([
            'trx_id'     => $payout->trx_id,
            'cus_trx_id' => $payout->cus_trx_id,
            'amount'     => $payout->amount,
            'status'     => $payout->status,
            'utr'        => $payout->utr,
            'created_at'=> $payout->created_at,
        ]);
    }
}
