@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Page Title -->
            <h2 class="text-center mb-4 fw-bold">
                📝 Create Your Account
            </h2>

            <!-- Registration Card -->
            <div class="card shadow-lg border-0 rounded-4 px-4 pt-4 pb-2">
                <div class="card-body">
                    <!-- Display general errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="register-form">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-semibold">
                                {{ __('👤 Full Name') }}
                            </label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end fw-semibold">
                                {{ __('📧 Email Address') }}
                            </label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control shadow-sm @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end fw-semibold">
                                {{ __('✅ Confirm Password') }}
                            </label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control shadow-sm"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-success shadow-sm px-4" id="register-btn">
                                    {{ __('Register') }}
                                </button>

                                @if (Route::has('login'))
                                    <a class="btn btn-link" href="{{ route('login') }}">
                                        {{ __('Already have an account? Login') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Optional: Add bottom image or promotion -->
            <div class="text-center mt-4">
                <img src="{{ asset('images/signup-illustration.png') }}" class="img-fluid rounded shadow" alt="Signup Illustration" >
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('register-btn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission triggered');
            
            // Disable button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Registering...';
            
            // Re-enable button after 5 seconds in case of issues
            setTimeout(function() {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '{{ __("Register") }}';
            }, 5000);
        });
    }
});
</script>
@endsection