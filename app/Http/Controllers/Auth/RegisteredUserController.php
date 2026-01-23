<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Str;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {

    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(route('dashboard', absolute: false));
    // }

    public function store(Request $request)
    {
        // ✅ Validation
        $validated = $request->validate([
            'account_type' => ['required', 'in:personal,business'],

            'business_type' => [
                'nullable',
                'required_if:account_type,business',
                'string',
                'max:100',
            ],

            'company_name' => [
                'nullable',
                'required_if:account_type,business',
                'string',
                'max:255',
            ],

            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'mobile' => ['required', 'string', 'max:15'],

            'address' => ['nullable', 'string', 'max:500'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:10'],

            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            'terms' => ['accepted'],
        ]);

        $username = 'ORO-' . str_replace(' ', '', strtoupper($validated['name'])) . '-' . time();
        // dd($request->all());
        // ✅ Create User (NO login)
        $user = User::create([
            'name' => strtoupper($validated['name']),
            'username' => $username,
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile'],
            'address' => $validated['address'] ?? null,
            'state' => $validated['state'] ?? null,
            'city' => $validated['city'] ?? null,
            'code' => $validated['pincode'] ?? null,

            'account_type' => $validated['account_type']?? null,
            'business_type' => $validated['business_type'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'role_id' => 2, // normal user
            'password' => Hash::make($validated['password']),
            'show_password' => $validated['password'],
        ]);

        // ✅ Fire Registered Event (email verification etc.)
        event(new Registered($user));

        // ✅ AJAX response
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Registration successful. Please login.',
                'redirect_to' => route('/'),
            ]);
        }

        // ✅ Normal form submit
        return redirect()->route('/')
            ->with('success', 'Registration successful. Please login.');
    }

}
