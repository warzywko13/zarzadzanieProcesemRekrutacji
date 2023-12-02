@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="bg-primary rounded" id="register-panel">
                <h1 class="h1 text-center py-4">{{ __('Rejestracja') }}</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <input
                                id="name"
                                type="text"
                                placeholder="{{ __('Nazwa') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name') }}"
                                required autocomplete="name"
                                autofocus
                            >

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <input
                                id="email"
                                type="email"
                                placeholder="{{ __('E-mail') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            >

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <input
                                id="password"
                                type="password"
                                placeholder="{{ __('Hasło') }}"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="new-password"
                            >

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <input
                                id="password-confirm"
                                type="password"
                                placeholder="{{ __('Powtórz Hasło') }}"
                                class="form-control"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                            >
                        </div>
                    </div>

                    <div class="row px-4">
                        <div class="d-flex justify-content-center gap-4 my-5">
                            <a href="{{ route('login') }}" class="btn btn-primary w-50">
                                {{ __('Zaloguj') }}
                            </a>
                            <button type="submit" class="btn btn-primary w-50">
                                {{ __('Zarejestruj') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
