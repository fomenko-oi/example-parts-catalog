@extends('layout.app')

@section('app_section_class', 'account')

@php
    /** @var \App\Model\Auth\Entity\User $user */
    /** @var \App\Model\Order\Entity\Order[] $orders */
@endphp

@section('content')
    @include('app.cabinet._segments._menu', ['page' => 'orders'])

    <div class="account__content">
        @include('app.cabinet._segments._alerts')

        <cabinet-orders-component :orders='@json(\App\Http\Resources\User\Order\OrderResource::collection($orders))' />
    </div>
@endsection
