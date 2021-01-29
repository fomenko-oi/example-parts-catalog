<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}"/>
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}"/>
    <link rel="mask-icon" href="{{ asset('images/favicon/safari-pinned-tab.svg') }}" color="#262626"/>
    <meta name="msapplication-TileColor" content="#262626"/>
    <meta name="theme-color" content="#ffffff"/>
    <title>@yield('title', 'Japan Logistic')</title>
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        window.app_variables = {
            lang: '{{ LaravelLocalization::getCurrentLocale() }}',
            convert_rate: {{ config_variable('yen_rub_currency', 1.432) }},
            convert_rub_rate: {{ getOppositeRate() }},
            convert_price_rate: {{ LaravelLocalization::getCurrentLocale() === "ru" ? getOppositeRate() : getOppositeUsdRate() }},
            currency: '{{ LaravelLocalization::getCurrentLocale() === "ru" ? "rub" : "usd" }}',
            currencyLabel: '{{ LaravelLocalization::getCurrentLocale() === "ru" ? "₽" : "$" }}',
            currencySymbols: @json(\App\Model\Deposit\Entity\Refill\Currency::getCurrencySymbols())
        };
        window.routes = {
            simple_search: '{{ route('simple_search') }}'
        }
    </script>

    <script>
        window.delivery_data = @json($deliveryData);
    </script>

    <style>
        .price_request:hover {
            cursor: pointer;
        }
    </style>

    @yield('styles')
</head>
<body>
@include('layout._segments.header')
<main id="app">
    @section('breadcrumbs', Breadcrumbs::render())
    @yield('breadcrumbs')

    <section class="@yield('app_section_class')">
        <div class="container">
            @yield('content')
        </div>
    </section>
</main>
<!--.popups-->
{{--...--}}
<!--include ./_popups-->
@include('layout._segments.footer')

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/swiper.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<!--script(src='https://www.google.com/recaptcha/api.js' async defer)-->
<script src="{{ asset('js/gsap.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/jquery.ui.touch-punch.js') }}"></script>
<script src="{{ asset('js/calc.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts')
</body>
</html>
