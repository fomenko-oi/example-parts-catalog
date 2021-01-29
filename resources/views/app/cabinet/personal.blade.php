@extends('layout.app')

@section('app_section_class', 'account')

@php
/** @var \App\Model\Auth\Entity\User $user */
/** @var \App\Model\Auth\Entity\Address\Address $address */
@endphp

@section('content')
    @include('app.cabinet._segments._menu', ['page' => 'personal'])

    <div class="account__content">
        @include('app.cabinet._segments._alerts')

        <form class="login__form" action="{{ route('cabinet.personal.update') }}" method="POST" id="profile-settings-form">
            @csrf
            @method('PUT')

            <div class="login__form__subtitle">{{ __('Personal info') }}</div>
            <div class="login__form__field">
                <label for="name">{{ __('Last name First name') }}</label>
                <input name="name" id="name" type="text" placeholder="" class="@error('name') is-invalid @enderror" value="{{ $user->name }}">

                @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" placeholder="" class="@error('email') is-invalid @enderror" value="{{ $user->email }}">

                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field">
                <label for="phone">{{ __('Phone') }}</label>
                <input id="phone" name="phone" type="tel" placeholder="+7(999) 999-99-99" class="@error('phone') is-invalid @enderror" value="{{ $user->phone }}">
                <span>{{ __('city code required') }}</span>

                @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="account__change-pass">{{ __('Change password') }}</div>
            <div class="login__form__field account__change">
                <label for="old_password">{{ __('Old password') }}</label>
                <input id="old_password" name="old_password" type="password" placeholder="" class="@error('old_password') is-invalid @enderror">
                <div class="eye" data-action="see-password" data-toggle="old_password"></div>

                @error('old_password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field account__change">
                <label for="new_password">{{ __('New password') }}</label>
                <input name="new_password" type="password" placeholder="" id="new_password" class="@error('new_password') is-invalid @enderror">
                <div class="eye" data-action="see-password" data-toggle="new_password"></div>

                @error('new_password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field account__change">
                <label for="new_password_confirm">{{ __('Repeat new password') }}</label>
                <input id="new_password_confirm" name="new_password_confirm" type="password" placeholder="">
                <div class="eye" data-action="see-password" data-toggle="new_password_confirm"></div>
            </div>

            <div class="login__form__subtitle">{{ __('Address') }}</div>
            <div class="login__form__desc">{{ __('Required for mail to your address') }}</div>

            <fragment>
                <country-component
                    :countries='@json($countries)'
                    default-country="{{ old('country_id', $address->country_id) }}"
                    default-region="{{ old('region_id', $address->region_id) }}"
                    default-city="{{ old('city_id', $address->city_id) }}"
                />
            </fragment>

            <div class="login__form__field">
                <label for="address">{{ __('Address') }}</label>
                <input id="address" name="address" type="text" placeholder="" class="@error('address') is-invalid @enderror" value="{{ $address->address }}">

                @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <div class="login__form__field login__form__field--half">
                <label for="postcode">{{ __('Postcode') }}</label>
                <input id="postcode" name="postcode" type="text" placeholder="XXXXXX" maxlength="6" class="@error('postcode') is-invalid @enderror" autocomplete="postcode" value="{{ $address->postcode }}">

                @error('postcode')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

            <input type="submit" value="{{ __('Save changes') }}">
        </form>
    </div>
@endsection
