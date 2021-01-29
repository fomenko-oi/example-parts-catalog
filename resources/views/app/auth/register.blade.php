@extends('layout.app')

@section('breadcrumbs', '')

@section('content')
    <div class="login">
        <form class="login__form" action="{{ route('register') }}" method="POST">
            @csrf

            <div class="login__form__title">{{ __('Sign Up') }}</div>
            <div class="login__form__desc">@lang('auth.sign_in.description')</div>
            <div class="login__form__subtitle">{{ __('Personal data') }}</div>

            <div class="login__form__field">
                <label for="name">{{ __('Last name First name') }}</label>
                <input name="name" id="name" type="text" placeholder="" class="@error('name') is-invalid @enderror" value="{{ old('name') }}">

                @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" placeholder="" class="@error('email') is-invalid @enderror" value="{{ old('email') }}">
                <span>{{ __('will be used as login') }}</span>

                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field">
                <label for="phone">{{ __('Phone') }}</label>
                <input id="phone" name="phone" type="tel" placeholder="+7(999) 999-99-99" class="@error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                <span>{{ __('city code required') }}</span>

                @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__subtitle">{{ __('Address') }}</div>
            <div class="login__form__desc">{{ __('Required for mail to your address') }}</div>

            <fragment>
                <country-component :countries='@json($countries)' />
            </fragment>

            <div class="login__form__field">
                <label for="address">{{ __('Address') }}</label>
                <input id="address" name="address" type="text" placeholder="" class="@error('address') is-invalid @enderror" value="{{ old('address') }}">

                @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field login__form__field--half">
                <label for="postcode">{{ __('Postcode') }}</label>
                <input id="postcode" name="postcode" type="text" placeholder="XXXXXX" maxlength="6" class="@error('postcode') is-invalid @enderror" autocomplete="postcode" value="{{ old('postcode') }}">

                @error('postcode')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="form-check">
                <input name="accepted" id="register" type="checkbox" class="@error('accepted') is-invalid @enderror" {{ old('accepted') ? 'checked' : '' }}>
                <label for="register"><span></span><em>{{ __('I\'m agree') }} <a href="/" target="_blank">{{ __('service rules') }}</a></em></label>

                @error('accepted')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
            <input type="submit" value="{{ __('Sign Up') }}">
        </form>
        <div class="login__img"><img src="{{ asset('images/registration.svg') }}" loading="lazy" alt="alt"></div>
    </div>
@endsection
