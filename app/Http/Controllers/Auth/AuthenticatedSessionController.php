<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function otpForm(): View
    {
        return view('auth.otp.otpScreen');
    }

    /**
     * Handle an incoming authentication request.
     */

    // public function store(LoginRequest $request): RedirectResponse { 
    //     $request->authenticate(); 
    //     $request->session()->regenerate(); 
    //     $user = Auth::user(); 
    //     if ($user->role_id == 1) { 
    //         return redirect()->intended(route('dashboard', false)); 
    //     } 
    //     return redirect()->intended(route('user.dashboard', absolute: false)); 
    // }

    // public function store(LoginRequest $request)
    // {
    //     if (!Auth::validate($request->only('email', 'password'))) {
    //         return response()->json([
    //             'message' => 'Invalid email or password'
    //         ], 401);
    //     }

    //     // 🔹 Step 1: Manually validate credentials
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'message' => 'Invalid email or password',
    //         ], 401);
    //     }

    //     // 🔹 Step 2: OTP REQUIRED FOR NON-ADMIN
    //     if ($user->role_id != 1) {

    //         $otp = rand(100000, 999999);

    //         $user->update([
    //             'otp' => $otp,
    //             'otp_expires_at' => Carbon::now()->addMinutes(5),
    //         ]);

    //         Mail::to($user->email)->send(new LoginOtpMail($otp));

    //         session([
    //             'otp_user_id' => $user->id
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'otp_required' => true,
    //             'message' => 'OTP sent to your email',
    //             'redirect_to' => route('otp.form'),
    //         ]);
    //     }

    //     // 🔹 Step 3: ADMIN DIRECT LOGIN
    //     Auth::login($user);
    //     $request->session()->regenerate();

    //     return response()->json([
    //         'success' => true,
    //         'otp_required' => false,
    //         'message' => 'Login successful',
    //         'redirect_to' => route('superadmin.dashboard'),
    //         'user' => [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //             'email' => $user->email,
    //         ],
    //     ]);
    // }

    public function store(LoginRequest $request)
    {
        // 1️⃣ Validate credentials (NO LOGIN YET)
        if (!Auth::validate($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        // 2️⃣ OTP for NON-ADMIN
        if ($user->role_id != 1) {

            $otp = random_int(100000, 999999);

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new LoginOtpMail($otp));

            session([
                'otp_user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'otp_required' => true,
                'expired_time' => Carbon::now()->addMinutes(5)->timestamp, 
                'message' => 'OTP sent to your email',
                'redirect_to' => route('otp.form'),
            ]);
        }

        // 3️⃣ ADMIN DIRECT LOGIN
        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'otp_required' => false,
            'message' => 'Admin login successful',
            'redirect_to' => route('superadmin.dashboard'),
            'user' => [
                'id' => $user->id,
                'role_id' => $user->role_id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'otp' => 'required'
    //     ]);

    //     $user = User::find(session('otp_user_id'));

    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'Session expired'
    //         ], 401);
    //     }

    //     if (
    //         $user->otp !== $request->otp ||
    //         now()->gt($user->otp_expires_at)
    //     ) {
    //         return response()->json([
    //             'message' => 'Invalid or expired OTP'
    //         ], 422);
    //     }

    //     // Clear OTP
    //     $user->update([
    //         'otp' => null,
    //         'otp_expires_at' => null
    //     ]);

    //     // FINAL LOGIN
    //     Auth::login($user);
    //     session()->forget('otp_user_id');

    //     $request->session()->regenerate();

    //     if ($user->role_id == 1) {
    //         $redirectTo = route('superadmin.dashboard');
    //     } else {
    //         $redirectTo = route('user.dashboard');
    //     }


    //     return response()->json([
    //         'success' => true,
    //         'message' => 'OTP verified successfully',
    //         'redirect_to' => $redirectTo,
    //         'user' => [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //             'email' => $user->email,
    //         ],
    //     ]);
    // }


    // public function verifyOtp(Request $request)
    // {
    //    $request->validate([
    //         'otp' => 'required|digits:6'
    //     ]);

    //     $userId = User::find(session('otp_user_id'));

    //     if (!$userId) {
    //         return response()->json([
    //             'message' => 'Session expired. Please login again.'
    //         ], 401);
    //     }

    //     $user = User::find($userId);

    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'User not found.'
    //         ], 401);
    //     }


    //     // ❌ OTP mismatch
    //     if ( $user->otp !== $request->otp) {
    //         return response()->json([
    //             'message' => 'Invalid OTP'
    //         ], 422);
    //     }
    //     // ❌ OTP expired
    //     if (now()->gt($user->otp_expires_at)) {
    //         return response()->json([
    //             'errors' => [
    //                 'otp' => ['OTP has expired']
    //             ]
    //         ], 422);
    //     }


    //     // Clear OTP
    //     $user->update([
    //         'otp' => null,
    //         'otp_expires_at' => null
    //     ]);

    //     // FINAL LOGIN
    //     Auth::login($user);
    //     session()->forget('otp_user_id');
    //     $request->session()->regenerate();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'OTP verified successfully',
    //         'redirect_to' => route('user.dashboard'),
    //         'user' => $user,
    //     ]);
    // }

    public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6'
    ]);

    // ✅ FIX #1: Get user ID from session (not User model)
    $userId = session('otp_user_id');
    
    if (!$userId) {
        return response()->json([
            'message' => 'Session expired. Please login again.'
        ], 401);
    }

    // ✅ FIX #2: Now find the user by ID
    $user = User::find($userId);
   
    if (!$user) {
        return response()->json([
            'message' => 'User not found.'
        ], 401);
    }

    // ❌ OTP mismatch
    if ($user->otp !== $request->otp) {
        return response()->json([
            'message' => 'Invalid OTP',
            'errors' => [
                'otp' => ['Invalid OTP code']
            ]
        ], 422);
    }

    // ❌ OTP expired
    if (now()->gt($user->otp_expires_at)) {
        return response()->json([
            'message' => 'OTP has expired',
            'errors' => [
                'otp' => ['OTP has expired. Please request a new one.']
            ]
        ], 422);
    }

    // ✅ Clear OTP
    $user->update([
        'otp' => null,
        'otp_expires_at' => null
    ]);

    // ✅ FINAL LOGIN
    Auth::login($user);
    session()->forget('otp_user_id');
    $request->session()->regenerate();

    return response()->json([
        'success' => true,
        'message' => 'OTP verified successfully',
        'redirect_to' => route('user.dashboard'),
        'data' =>$user,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]
    ]);
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
