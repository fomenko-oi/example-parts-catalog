<div class="{{ $class }}">
    <div class="header__top__language-current">
        <img src="{{ asset('images/flag-'.LaravelLocalization::getCurrentLocale().'.png') }}" alt="alt"/>
    </div>

    <div class="header__top__language-popup">
        <a href="{{ LaravelLocalization::getLocalizedURL('en') }}">
            <div class="header__top__language-one">
                <img src="{{ asset('images/flag-en.png') }}" alt="alt"/>
                en
            </div>
        </a>

        <a href="{{ LaravelLocalization::getLocalizedURL('ru') }}">
            <div class="header__top__language-one">
                <img src="{{ asset('images/flag-ru.png') }}" alt="alt"/>
                ru
            </div>
        </a>
    </div>
</div>
