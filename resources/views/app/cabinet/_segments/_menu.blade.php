<div class="catalog__menu">
    <div class="catalog__menu__regions">
        <a class="{{ $page === 'personal' ? 'active' : '' }}" href="{{ route('cabinet.personal') }}">{{ __('Personal data') }}</a>
        <a class="{{ $page === 'orders' ? 'active' : '' }}" href="{{ route('cabinet.orders') }}">{{ __('My orders') }}</a>
        <a class="{{ $page === 'payments' ? 'active' : '' }}" href="{{ route('cabinet.payments') }}">{{ __('My payments') }}</a>
        <a class="{{ $page === 'deposit' ? 'active' : '' }}" href="{{ route('cabinet.deposit') }}">{{ __('Deposit') }}</a>
        <a href="{{ route('cabinet.logout') }}">{{ __('Logout') }}</a>
    </div>
</div>
