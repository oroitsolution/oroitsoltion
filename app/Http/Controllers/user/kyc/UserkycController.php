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
        $kycdata = Kyc::where('userid', $user->id)->first();
        return view('user.kyc.kyc',compact( 'user', 'kycdata'));
    }

    public function send_otp(Request $request)
    {
        $request->validate([
            'adhar_number' => ['required', 'digits:12'],
        ]);
          
            $aadharno = $request->adhar_number;
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api.quickekyc.com/api/v1/aadhaar-v2/generate-otp', [
                'key'       =>'2d9b2569-90a0-4960-ad0b-b798a8cf6ec0',
                'id_number' => $aadharno,
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP service unavailable. Please try later.',
                ], 500);
            }

            $data = $response->json();
            
            if (isset($data['status']) && strtoupper($data['status']) === 'SUCCESS') {

                return response()->json([
                    'status' =>'SUCCESS',
                    'success' => true,
                    'otpbox' => 'SHW990',
                    'aadharno' =>$aadharno,
                    'data'    => $data,
                ]);
            }

            return response()->json([
                'success' => false,
                'aadharno' =>$aadharno,
                'message' => $data['message'] ?? 'Failed to send OTP',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while sending OTP',
            ], 500);
        }
    }

    public function verify_otp(Request $request)
    {
        $requestId = $request->input('requestid');
        $otp = $request->input('otp');
        $aadharno = $request->input(key: 'aadharno');
        $user = Auth::user();

        // If the OTP is a predefined test value
        if ($otp === '981900') {
            return response()->json([
                'status' => 'success',
                'data' => 'Test OTP verified successfully.'
            ]);
        }
    
        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.quickekyc.com/api/v1/aadhaar-v2/submit-otp', [
            'key' => '2d9b2569-90a0-4960-ad0b-b798a8cf6ec0',
            'request_id' => $requestId,
            'otp' => $otp,
        ]);
    
        // Handle the response
        if ($response->successful()) {
            
            $apiResponse = $response->json();

            // Main Aadhaar data
            $aadhaarData = $apiResponse['data']['data'] ?? [];

            // Store KYC
            $kycdata = Kyc::create([
                'userid'        => $user->id,
                'adhar_number'  => $aadharno,
                'add_data'      => $apiResponse,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            return response()->json([
                'success'     => true,
                'status'      => 'SUCCESS',
                'message'     => 'Aadhaar verified successfully',
            ],200);
            
        } else {
            return response()->json([ 'status' => 'error','message' => 'OTP verification failed.', 'details' => $response->body()], 500);
        }
    }

    public function store_kyc(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'adhar_front' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'adhar_back'  => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'pan_card'    => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'chaque'      => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'gst_img'     => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'company_pan_card'  => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'address_proof'=> 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'shopphoto'    => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'electricbill' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',

            'adhar_number'=> 'required|string|size:12',
            'pan_number'    => 'required|string|max:10',

            'gst'           => 'required|string|max:60',
            'account_type'  => 'required|string|max:60',
            'cin_number'    => 'required|string|max:50',
            'ifsc_code'     => 'required|string|max:15',
            'bank_name'     => 'required|string|max:255',
            'account_number'=> 'required|string|max:30',
            'account_name'  => 'required|string|max:255',
        ]);

            $user = Auth::user();
            $kycdata = Kyc::where('userid', $user->id)->first();

            if (!$kycdata) {
                return response()->json([
                    'success' => false,
                    'message' => 'KYC record not found'
                ], 404);
            }

            $documents = [];
            $docFields = [
                'adhar_front',
                'adhar_back',
                'pan_card',
                'chaque',
                'gst_img',
                'company_pan_card',
                'address_proof',
                'shopphoto',
                'electricbill',
            ];

            foreach ($docFields as $field) {

                if ($request->hasFile($field)) {

                    $file = $request->file($field);

                    $filename = 'OROITSOLUTION_' . date('Y-m-d') . '_' . $field . '.' . $file->getClientOriginalExtension();

                    $file->storeAs('kyc_documents', $filename, 'public');

                    $documents[$field] = $filename;
                }
            }

            $kycdata->update([

                'account_type'   => strtoupper($validated['account_type']),
                'address'        => $user->address,
                'pan_number'     => strtoupper($validated['pan_number']),
                'gst'            => strtoupper($validated['gst']),
                'cin_number'     => strtoupper($validated['cin_number']),
                'ifsc_code'      => strtoupper($validated['ifsc_code']),
                'bank_name'      => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'account_name'   => $validated['account_name'],
                'document'      => json_encode($documents),
                'updated_at'     => now(),
            ]);


            // Save files & data here...

            return response()->json([
                'success' => true,
                'message' => 'KYC submitted successfully and is under review'
            ]);
        }


}
