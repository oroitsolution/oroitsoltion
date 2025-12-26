<?php

namespace App\Http\Controllers\user\kyc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Carbon\Carbon;
use App\Models\Kyc;
use App\Models\User;

class UserkycController extends Controller
{
    public function view_kycForm()
    {
        $user = Auth::user();
      return view('user.kyc.kyc',compact( 'user'));
    }

    public function store_kyc(Request $request)
{
    $validated = $request->validate([
        'aadhaar_front' => 'required|image|mimes:jpg,jpeg,png',
        'aadhaar_back'  => 'required|image|mimes:jpg,jpeg,png',
        'pan_file'      => 'required|image|mimes:jpg,jpeg,png',

        'aadhaar_number'=> 'required|string|size:12',
        'pan_number'    => 'required|string|max:10',

        'ifsc'          => 'required|string|max:15',
        'bank_name'     => 'required|string|max:255',
        'account_number'=> 'required|string|max:30',
        'account_name'  => 'required|string|max:255',

        'selfie'        => 'required|image',
    ]);

    // Save files & data here...

    return response()->json([
        'success' => true,
        'message' => 'KYC submitted successfully and is under review'
    ]);
}


}
