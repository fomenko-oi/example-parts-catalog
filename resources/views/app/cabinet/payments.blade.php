@extends('layout.app')

@section('app_section_class', 'account')

@php
    /** @var \App\Model\Auth\Entity\User $user */
    /** @var \App\Model\Deposit\Entity\Refill\Refill[] $payments */
@endphp

@section('content')
    @include('app.cabinet._segments._menu', ['page' => 'payments'])

    <div class="account__content">
        @include('app.cabinet._segments._alerts')

        <cabinet-user-payments :payments='@json(\App\Http\Resources\User\Refill\RefillResource::collection($payments))' />
    </div>
@endsection
