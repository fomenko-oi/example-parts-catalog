<footer class="footer">
    <div class="arrow-up">
        <svg class="icon icon-up ">
            <use xlink:href="{{ asset('images/sprite-inline.svg#up') }}"></use>
        </svg>
        <p>{{ __('To top') }}</p>
    </div>
    <div class="container">
        <div class="footer__top">
            <div class="footer__top__logo"><a class="logo" href="/"><img src="{{ asset('images/Logo.svg') }}" alt="alt"/></a>
                <div class="desc">{{ __('One of the best transport companies in Russia, which organizes cargo transportation on the territory of the Russian Federation.') }}</div>
            </div>
            <div class="footer__top__block">
                <div class="phone">
                    <svg class="icon icon-number ">
                        <use xlink:href="{{ asset('images/sprite-inline.svg#number') }}"></use>
                    </svg>
                    <a href="tel:{{ config_variable('phone', '06-4560-4071') }}">{{ config_variable('phone', '06-4560-4071') }}</a> {{ __('Phone in Moscow') }}
                </div>
                <div class="mail">
                    <svg class="icon icon-dog ">
                        <use xlink:href="{{ asset('images/sprite-inline.svg#dog') }}"></use>
                    </svg>
                    <a href="mailto: {{ config_variable('email', 'support@japanlogistic.com') }}">{{ config_variable('email', 'support@japanlogistic.com') }}</a>
                </div>

                @include('layout._segments._lang_switch', ['class' => 'footer__top__language'])
            </div>
        </div>

        <div class="footer__middle">
            <div class="footer__middle__menu">
                <a href="javascript:void(0)" target="_blank">{{ __('Catalogue') }}</a>
                <a href="javascript:void(0)" target="_blank">{{ __('Yahoo auction') }}</a>
                <a href="javascript:void(0)" target="_blank">{{ __('Details') }}</a>
                <a href="javascript:void(0)" target="_blank">{{ __('About company') }}</a>
                <a href="javascript:void(0)" target="_blank">{{ __('Help') }}</a>
                <a href="javascript:void(0)" target="_blank">{{ __('Blog') }}</a>
                <a href="javascript:void(0)" target="_blank">{{ __('Contacts') }}</a>
            </div>

            <div class="footer__middle__banks">
                <img src="{{ asset('images/master.svg') }}" alt="alt"/>
                <img src="{{ asset('images/visa.svg') }}" alt="alt"/>
                <img src="{{ asset('images/sber.svg') }}" alt="alt"/>
                <img src="{{ asset('images/alfa.svg') }}" alt="alt"/>
            </div>
        </div>

        <div class="footer__bottom">
            <p>2020 © {{ config_variable('copyright', 'Japan logistic.') }}</p>
            <a href="https://polyarix.com/" target="_blank">{{ __('Developed in') }} Polyarix.</a>
        </div>
    </div>
</footer>
