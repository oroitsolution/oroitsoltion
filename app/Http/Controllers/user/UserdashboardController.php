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

class UserdashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        
        return view('user.userdashboard',compact( 'user'));
    }

    // ----------------Profile -----------------------/ # 
    public function view_profile(){
        $user = Auth::user();
        $clintdata = Clints::where('user_id', $user->id)->first();
        $kycdata = Kyc::where('userid', $user->id)->first();
        return view('user.profile',compact( 'user','kycdata' , 'clintdata'));
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

                // ❗ update() returns number of rows affected
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


}
