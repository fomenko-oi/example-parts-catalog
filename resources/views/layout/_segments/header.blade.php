<header class="header">
    <div class="container"><a class="header__logo" href="{{ LaravelLocalization::localizeUrl('/') }}"><img src="{{ asset('images/Logo.svg') }}" alt="alt"/></a>
        <div class="header__content">
            <div class="header__top">
                <div class="header__top__search__btn">
                    <svg class="icon icon-search ">
                        <use xlink:href="{{ asset('images/sprite-inline.svg#search') }}"></use>
                    </svg>
                </div>
                <div class="header__top__search" style="z-index: 2">
                    <form action="{{ LaravelLocalization::localizeUrl(route('search')) }}" style="display: none" id="invisible_search_form">
                        <input type="hidden" name="q" id="invisible_search_value">
                    </form>

                    <input class="header__top__search-input" placeholder="{{ __('Detail search') }}" id="detail_search_main"/>
                    <button class="header__top__search-submit"><span>{{ __('Find') }}</span>
                        <svg class="icon icon-search ">
                            <use xlink:href="{{ asset('images/sprite-inline.svg#search') }}"></use>
                        </svg>
                    </button>

                    <div class="header__top__search-result"></div>
                </div>
                <div class="header__top__pagin">
                    @guest
                        <a class="header__top__enter" href="{{ route('login') }}">
                            <svg class="icon icon-enter ">
                                <use xlink:href="{{ asset('images/sprite-inline.svg#enter') }}"></use>
                            </svg>
                            {{ __('Sign In') }}
                        </a>
                    @endguest

                    @auth
                        <a class="header__top__enter" href="{{ route('cabinet.personal') }}">{{ __('Personal Cabinet') }}</a>
                    @endauth

                    <div class="header__top__valute">
                        {{--<span class='yen'>101</span> = <span class='rub'>65</span>--}}
                        @if(LaravelLocalization::getCurrentLocale() === 'ru')
                            <span class='yen'>{{ (toYen(config_variable('currency_compare_value', 100))) }}</span> =
                            <span class='rub'>{{ config_variable('currency_compare_value', 100) }}</span>
                        @else
                            <span class='yen'>{{ (toDollarYenDirect(config_variable('currency_compare_usd_value', 10))) }}</span> =
                            <span class='dollar'>{{ config_variable('currency_compare_usd_value', 10) }}</span>
                        @endif
                    </div>

                    @include('layout._segments._lang_switch', ['class' => 'header__top__language'])
                </div>
            </div>
            <div class="header__bottom">
                <div class="header__bottom__menu">
                    <a href="javascript:void(0)" target="_blank">{{ __('Catalogue') }}</a>
                    <a href="javascript:void(0)" target="_blank">{{ __('Yahoo auction') }}</a>
                    <a href="javascript:void(0)" target="_blank">{{ __('Details') }}</a>
                    <a href="javascript:void(0)" target="_blank">{{ __('About company') }}</a>
                    <a href="javascript:void(0)" target="_blank">{{ __('Help') }}</a>
                    <a href="javascript:void(0)" target="_blank">{{ __('Blog') }}</a>
                    <a href="javascript:void(0)" target="_blank">{{ __('Contacts') }}</a>

                    @if(Auth::check() && Auth::user()->getRole()->isAdmin())
                        <a href="{{ route('admin.catalog') }}" target="_blank">{{ __('Admin') }}</a>
                    @endif
                </div>

                <a class="header__bottom__basket" href="{{ LaravelLocalization::localizeUrl(route('cart')) }}">
                    <svg class="icon icon-basket ">
                        <use xlink:href="{{ asset('images/sprite-inline.svg#basket') }}"></use>
                    </svg>
                    <p>{{ __('Cart') }}</p>
                    <span id="cart_amount_count">{{ $cart->getAmount() }}</span></a>
                </a>
                <div class="header__bottom__burger"><i></i></div>
            </div>
        </div>
    </div>
</header>
