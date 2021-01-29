@extends('layout.admin')
@section('content')
    <div class="content-heading">
        <div>
            Dashboard
            <small data-localize="dashboard.WELCOME">@lang('default.dashboard.WELCOME')</small>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/sparkline.js') }}"></script>
    <script src="{{ asset('/js/easypiechart.js') }}"></script>
    <script src="{{ asset('/js/flot.js') }}"></script>
@endsection
