@extends('layouts.app')

@section('content')

<!-- Login Section -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Title -->
            <h2 class="text-center mb-4 fw-bold">
                🔐 Login to Your Account
            </h2>

            <!-- Card -->
            <div class="card shadow-lg border-0 rounded-4 px-4 pt-4 pb-2">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end fw-semibold">
                                {{ __('📧 Email Address') }}
                            </label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control shadow-sm @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end fw-semibold">
                                {{ __('🔒 Password') }}
                            </label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control shadow-sm @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('🔁 Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button + Register Link -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary shadow-sm px-4">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('register'))
                                    <a class="btn btn-link" href="{{ route('register') }}">
                                        {{ __("Don't have an account? Register") }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Optionally add a bottom image/banner -->
            <!-- <div class="text-center mt-4">
                <img src="{{ asset('images/login-illustration.png') }}" class="img-fluid" alt="Login Illustration">
            </div> -->

        </div>
    </div>
</div>

@endsection
