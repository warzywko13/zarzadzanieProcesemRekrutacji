@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="bg-primary rounded" id="login-panel">
                <h1 class="h1 text-center py-4">{{ __('Zaloguj') }}</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <input
                                id="email"
                                type="email"
                                placeholder="{{ __('E-mail') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}"
                                required autocomplete="email"
                                autofocus
                            >

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center mb-5">
                        <div class="col-md-10">
                            <input
                                id="password"
                                type="password"
                                placeholder="{{ __('Hasło') }}"
                                class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row px-4">
                        <div class="d-flex justify-content-center gap-4 my-5">
                            <button type="submit" class="btn btn-primary w-50">
                                {{ __('Zaloguj') }}
                            </button>
                            <a href="{{ route('register') }}" class="btn btn-primary w-50">
                                {{ __('Zarejestruj') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
