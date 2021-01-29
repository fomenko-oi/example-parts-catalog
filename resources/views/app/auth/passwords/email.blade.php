@extends('layout.app')

@section('breadcrumbs', '')

@section('content')
    <div class="login">
        <form class="login__form" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="login__form__title">{{ __('Password recovery') }}</div>
            <div class="login__form__desc">{{ __('Enter login, the instruction will come to the specified address') }}</div>
            <div class="login__form__field">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" placeholder="" class="@error('email') is-invalid @enderror" value="{{ old('email') }}">

                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
            <input type="submit" value="{{ __('Send') }}">
        </form>
        <div class="login__img login__img--pass"><img src="{{ asset('images/password.svg') }}" loading="lazy" alt="alt"></div>
    </div>
@endsection
