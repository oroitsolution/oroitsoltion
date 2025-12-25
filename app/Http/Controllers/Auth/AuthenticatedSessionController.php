<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
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
    
    public function store(LoginRequest $request)
    {
        
        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        // Prevent session fixation
        $request->session()->regenerate();

        $user = Auth::user();
        
        // ✅ Correct role-based redirect
        if ($user->role_id == 1) {
            $redirectTo = route('superadmin.dashboard');
        } else {
            $redirectTo = route('user.dashboard');
        }

        // ✅ AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect_to' => $redirectTo,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

        // ✅ Normal form submit
        return redirect()->intended($redirectTo);
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
