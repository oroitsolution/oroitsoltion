<?php

namespace App\Http\Controllers\user;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\ApiJsonResponse;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kyc;
use App\Models\Clints;
use App\Models\additionlBankAccount;

class UserdashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $totalpayinbalance = DB::table('payins')->where('status','success')->sum('amount');
        return view('user.userdashboard',compact( 'user','totalpayinbalance'));
    }

    // ----------------Profile -----------------------/ # 
    public function view_profile(){
        $user = Auth::user();
        $additionbank = additionlBankAccount::where('user_id' , $user->id)->get();
        $clintdata = Clints::where('user_id', $user->id)->first();
        $kycdata = Kyc::where('userid', $user->id)->first();
        return view('user.profile',compact( 'user','additionbank','kycdata' , 'clintdata'));
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'userid' => ['required', 'exists:users,id'],
            'current_password' => ['required'],
            
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // Uppercase
                'regex:/[a-z]/',      // Lowercase
                'regex:/[0-9]/',      // Number
                'regex:/[@$!%*#?&]/', // Special character
                'confirmed',
            ],
        ], [
            'new_password.min'       => 'Password must be at least 8 characters.',
            'new_password.confirmed'=> 'New password and confirm password do not match.',
            'new_password.regex'    => 'Password must contain uppercase, lowercase, number and special character.',
        ]);

        // ✅ Fetch user safely
        $user = User::find($validated['userid']);

        // ✅ Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        // ✅ Prevent same password reuse
        if (Hash::check($validated['new_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'New password must be different from the current password.',
            ], 422);
        }

        // ✅ Update password
        $user->update([
            'password' => Hash::make($validated['new_password']),
            'show_password' => $validated['new_password'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }

    public function regenerateSecret(Request $request)
    {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $secret = 'ORO-' . strtoupper(Str::random(16)) . '-' . time();
            $secret2 = 'ORO-' . strtoupper(bin2hex(random_bytes(16)));
            
        
            $updated = Clints::where('user_id', $request->user_id)
            ->update([
                'secret_id' => $secret,
                'updated_at' => Carbon::now(),
            ]);

                if ($updated > 0) {
                    return response()->json([
                        'success'    => true,
                        'message'   =>"Secret Key Genrated",
                        'secret_key'=> $secret
                    ]);
                }
            return response()->json([
                'success' => false,
                'message' => 'Unable to update secret key'
            ], 500);
    }

    public function update_settings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'field'   => 'required|in:ipaddress,payin_url,payout_url',
            'value'   => 'required|string|max:255',
        ]);

        // Find or create record
        $setting = Clints::updateOrCreate(
            ['user_id' => $request->user_id],
            [$request->field => $request->value]
        );

        return response()->json([
            'success' => true,
            'data'    => $setting,
            'message' => ucfirst(str_replace('_', ' ', $request->field)) . ' updated successfully'
        ]);
    }
    //End Setting Update 
    
    // Store Addition bank account 
    public function additional_data(Request $request)
    {

        $request->validate([
            'bank_name'           => 'required|string|max:255',
            'ifsc_code'           => 'required|string|max:20',
            'account_name'        => 'required|string|max:255',
            'account_number'      => 'required|string|max:50',
            'aadhar_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'aadhar_back'  => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'pan_card'      => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'gst'           => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $documents = [];

        foreach (['aadhar_front', 'aadhar_back', 'pan_card', 'gst'] as $doc) {
            if ($request->hasFile($doc)) {
                $documents[$doc] = $request->file($doc)
                    ->store('bank-documents', 'public');
            }
        }

        $bankAccount = additionlBankAccount::create([
            'user_id'              => Auth::id(),
            'bank_name'            => $request->bank_name,
            'ifsc_code'            => $request->ifsc_code,
            'account_holder_name'  => $request->account_name,
            'account_number'       => $request->account_number,
            'status'               => 'PENDDING',
            'documents'            => $documents
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bank account saved successfully',
            'data'    => $bankAccount
        ]);
    }

}
