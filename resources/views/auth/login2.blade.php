@extends('frontlayout.app')

@section('content')

<style>
    .login-container {
        max-width: 420px;
        margin: 60px auto;
        padding: 35px 30px;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.08);
    }

    .login-title {
        text-align: center;
        font-size: 26px;
        font-weight: 700;
        color: #222;
    }

    .login-subtext {
        text-align: center;
        font-size: 14px;
        color: #666;
        margin-bottom: 25px;
    }

    .btn-login {
        width: 100%;
        background: #0066ff;
        border: none;
        padding: 12px 0;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-login:hover {
        background: #004fcc;
    }

    .forgot-link {
        font-size: 14px;
        color: #555;
    }

    .forgot-link:hover {
        color: #000;
        text-decoration: underline;
    }

    .text-remember {
        color: #333 !important;
    }
</style>

<div class="login-container">

    <h2 class="login-title">Login</h2>
    <p class="login-subtext">Access your account securely</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="text-start">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div class="mt-4 text-start">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 text-start">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ms-2 text-sm text-remember">
                    {{ __('Remember me') }}
                </span>
            </label>
        </div>

        <!-- Login Button -->
        <button class="btn-login">{{ __('Log in') }}</button>

        <!-- Forgot Password -->
        <div class="mt-3 text-end">
            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

    </form>

</div>

@endsection


@push('js')


<script>



</script>

@endpush