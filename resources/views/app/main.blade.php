@extends('layout.app')

@section('app_section_class', 'home')

@section('content')
    <div class="home__blocks">
        @foreach($list as $item)
            <a class="home__one" href="{{ LaravelLocalization::localizeUrl(route('catalog.category', $item->category)) }}">
                <div class="home__one__picture">
                    <img src="{{ asset($item->category->getImage()) }}" alt="alt" loading="lazy"/>
                </div>
                <div class="home__one__title">{{ translated_category_name($item->category) }}</div>
                <div class="home__one__category">
                    @foreach($item->brands as $brand)
                        <span>{{ $brand->name }}</span>
                    @endforeach
                </div>

                @if(count($item->brands) > 2)
                    <div class="home__one__more">{{ __('More') }}</div>
                @endif
            </a>
        @endforeach
    </div>
@endsection
