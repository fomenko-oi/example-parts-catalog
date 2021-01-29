@component('mail::message')
# {!! $header !!}

{!! $body !!}

@component('mail::button', ['url' => $link['url']])
{{ $link['text'] }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
