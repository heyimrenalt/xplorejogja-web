@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
<div class="auth-centered-page">
    <div class="auth-card">

        <div class="auth-card-logo">
            <a href="{{ url('/') }}">XPlore<span class="accent">Jogja</span></a>
        </div>

        <div class="auth-form-header">
            <h1 class="auth-form-title">Bergabung dengan XPloreJogja</h1>
            <p class="auth-form-subtitle">Buat akun untuk eksplor wisata Jogja</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="auth-form-group">
                <label for="name" class="auth-label">{{ __('Name') }}</label>
                <input id="name" type="text"
                    class="auth-input @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}"
                    required autocomplete="name" autofocus>
                @error('name')
                    <span class="auth-error-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="email" class="auth-label">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                    class="auth-input @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}"
                    required autocomplete="email">
                @error('email')
                    <span class="auth-error-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password" class="auth-label">{{ __('Password') }}</label>
                <input id="password" type="password"
                    class="auth-input @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">
                @error('password')
                    <span class="auth-error-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password-confirm" class="auth-label">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password"
                    class="auth-input"
                    name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn-auth-primary">
                {{ __('Register') }}
            </button>

        </form>

        <div class="auth-link-center">
            Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a>
        </div>

    </div>
</div>
@endsection
