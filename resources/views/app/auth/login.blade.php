@extends('layout.app')

@section('breadcrumbs', '')

@section('content')
    <div class="login">
        <form class="login__form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="login__form__title">{{ __('auth.login_button') }}</div>
            <div class="login__form__desc">{{ __('auth.sign_in.message') }}</div>

            <div class="login__form__field">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus/>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="login__form__field">
                <label for="enterPass">{{ __('Password') }}</label>
                <input type="password" placeholder="" id="enterPass" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
                <div class="eye" data-action="see-password" data-toggle="enterPass"></div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check login__form__field--half">
                <input id="register" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                <label for="register"><span></span><em>{{ __('Remember Me') }}</em></label>
            </div>

            <a class="login__form__link" href="{{ route('password.request') }}">{{ __('Reset Password') }}</a>

            <input type="submit" value="{{ __('Login') }}"/>

            <div class="login__form__enter">
                {{ __('Don\'t have account') }}?
                <a class='login__form__link' href="{{ route('register') }}">{{ __('Sign Up') }}</a>
            </div>
        </form>

        <div class="login__img"><img src="{{ asset('images/signin.svg') }}" loading="lazy" alt="alt"/></div>
    </div>
@endsection
