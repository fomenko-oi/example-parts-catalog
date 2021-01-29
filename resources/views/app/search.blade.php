@extends('layout.app')

@section('app_section_class', 'search')

@section('styles')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="search__title">{{ __('Detail search') }}</div>
    <div class="text">
        <p>@lang('search.text1')</p>
        <p>@lang('search.text2')</p>
        <p>@lang('search.text3')</p>
    </div>
    <div class="search__block">
        <div class="search__block__title">{{ __('Find item') }}</div>
        <p>{{ __('Enter part number or model') }}</p>
        <div class="search__block__field">
            <input class="search__block__field-input" placeholder="{{ __('For example') }}: 13568-19145" value="{{ request('q') }}" min="3"/>
            <button class="search__block__field-submit"><span>{{ __('Find') }}</span>
                <svg class="icon icon-search ">
                    <use xlink:href="{{ asset('images/sprite-inline.svg#search') }}"></use>
                </svg>
            </button>

            <div class="search__block__field-result"></div>
        </div>
    </div>

    @if(request('q') && strlen(request('q')) > 2)
        <div class="search__results">
            <div class="search__title">{{ __('Search results') }} ({{ count($details) }})</div>

            @if(count($details) > 0)
                @include('app.catalog.detail.table_list', ['details' => $details, 'cart' => $cart])
            @else
                <div class="search__results__table">
                    <table class="table">
                        <tbody>
                        <tr style="display: none">
                            <th>{{ __('Nothing found') }}</th>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: center;">{{ __('Nothing found') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        var searchHandler = function() {
            var query = $('.search__block__field-input').val();

            if(query.length < 3) {
                $('#invisible_search_value').focus();
                return false;
            }

            $('#invisible_search_value').val(query)
            $('#invisible_search_form').submit()
        };

        $('.search__block__field-submit').click(searchHandler);

        $('input.search__block__field-input').keydown(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                searchHandler();
            }
        })
    </script>
@endsection
