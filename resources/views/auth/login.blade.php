@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<div class="auth-split-screen">

    {{-- ===== Left Panel: Tugu Image + Brand ===== --}}
    <div class="auth-split-left">
        <div class="auth-split-left-content">
            <div class="auth-brand-logo">XPlore<span class="accent">Jogja</span></div>
            <div class="auth-brand-tagline">Jelajahi Keindahan Yogyakarta</div>
            <div class="auth-split-divider"></div>
            <div class="auth-split-left-cta">
                <p>Belum punya akun?</p>
                <a href="{{ url('/register') }}" class="btn-outline-white">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    {{-- ===== Right Panel: Login Form ===== --}}
    <div class="auth-split-right">
        <div class="auth-split-form-wrap">

            <div class="auth-form-header">
                <h1 class="auth-form-title">Selamat Datang Kembali!</h1>
                <p class="auth-form-subtitle">Masuk ke akun XPloreJogja kamu</p>
            </div>

            @if (session('success'))
                <div class="auth-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-form-group">
                    <label for="email" class="auth-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email"
                        class="auth-input @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}"
                        required autocomplete="email" autofocus>
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
                        name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="auth-error-msg" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="auth-checkbox-group">
                    <input class="auth-checkbox" type="checkbox"
                        name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="auth-checkbox-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="btn-auth-primary">
                    {{ __('Login') }}
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

</div>
@endsection
