@extends('layouts.auth')

@section('title', 'Konfirmasi Password')

@section('content')
<div class="auth-centered-page">
    <div class="auth-card">

        <div class="auth-card-logo">
            <a href="{{ url('/') }}">XPlore<span class="accent">Jogja</span></a>
        </div>

        <div class="auth-form-header">
            <h1 class="auth-form-title">Konfirmasi Password</h1>
            <p class="auth-form-subtitle">Mohon konfirmasi password kamu untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="auth-form-group">
                <label for="password" class="auth-label">{{ __('Password') }}</label>
                <input id="password" type="password"
                    class="auth-input @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                @error('password')
                    <span class="auth-error-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-auth-primary">
                {{ __('Confirm Password') }}
            </button>

            @if (Route::has('password.request'))
                <div class="auth-forgot-wrap">
                    <a class="auth-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif

        </form>

    </div>
</div>
@endsection
