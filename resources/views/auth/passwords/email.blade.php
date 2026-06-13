@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="auth-centered-page">
    <div class="auth-card">

        <div class="auth-card-logo">
            <a href="{{ url('/') }}">XPlore<span class="accent">Jogja</span></a>
        </div>

        <div class="auth-form-header">
            <h1 class="auth-form-title">Lupa Password?</h1>
            <p class="auth-form-subtitle">Masukkan email kamu, kami kirim link reset</p>
        </div>

        @if (session('status'))
            <div class="auth-alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
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

            <button type="submit" class="btn-auth-primary">
                {{ __('Send Password Reset Link') }}
            </button>

        </form>

        <div class="auth-link-center">
            <a href="{{ url('/login') }}">← Kembali ke Login</a>
        </div>

    </div>
</div>
@endsection
