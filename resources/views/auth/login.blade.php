@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg bg-dark text-white">
                <div class="card-header bg-secondary text-white text-center py-4">
                    <h3 class="mb-0">{{ __('Login') }}</h3>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control bg-dark text-white @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Mot de passe -->
                        <div class="row mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control bg-dark text-white @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="row mb-4">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de connexion -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link text-white" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles personnalisés pour le dark mode -->
<style>
    body {
        background-color: #121212;
        color: #ffffff;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        background-color: #1e1e1e;
    }

    .card-header {
        background-color: #333333;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #444;
        padding: 10px;
        transition: border-color 0.3s ease;
        background-color: #333;
        color: #ffffff;
    }

    .form-control:focus {
        border-color: #ff6f61;
        box-shadow: 0 0 5px rgba(255, 111, 97, 0.5);
        background-color: #444;
    }

    .btn-primary {
        background-color: #ff6f61;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #e65a50;
    }

    .invalid-feedback {
        color: #ff6f61;
        font-size: 0.9rem;
    }

    .row {
        margin-bottom: 1.5rem;
    }

    label {
        font-weight: 500;
        color: #ffffff;
    }

    .form-check-input {
        background-color: #333;
        border-color: #444;
    }

    .form-check-input:checked {
        background-color: #ff6f61;
        border-color: #ff6f61;
    }

    .form-check-label {
        color: #ffffff;
    }

    .btn-link {
        color: #ff6f61;
        text-decoration: none;
    }

    .btn-link:hover {
        color: #e65a50;
        text-decoration: underline;
    }
</style>
@endsection