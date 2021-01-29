@php /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */ @endphp
@if ($paginator->hasPages())
    <div class="pagination">
        @if (!$paginator->onFirstPage())
            <a class="first" href="{{ $paginator->url(1) }}">
                <svg class="icon icon-pagin-last ">
                    <use xlink:href="{{ asset('images/sprite-inline.svg#pagin-last') }}"></use>
                </svg>
            </a>
            <a class="prev" href="{{ $paginator->previousPageUrl() }}">
                <svg class="icon icon-pagin-prev ">
                    <use xlink:href="{{ asset('images/sprite-inline.svg#pagin-prev') }}"></use>
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="disabled" href="javascript:void(0)" aria-disabled="true"> {{ $element }}</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="current" href="javascript:void(0)"> {{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="next" href="{{ $paginator->nextPageUrl() }}">
                <svg class="icon icon-pagin-prev ">
                    <use xlink:href="{{ asset('images/sprite-inline.svg#pagin-prev') }}"></use>
                </svg>
            </a>

            <a class="last" href="{{ $paginator->url($paginator->lastPage()) }}">
                <svg class="icon icon-pagin-last ">
                    <use xlink:href="{{ asset('images/sprite-inline.svg#pagin-last') }}"></use>
                </svg>
            </a>
        @endif
    </div>
@endif
