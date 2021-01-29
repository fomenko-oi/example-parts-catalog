@extends('layout.app')

@section('app_section_class', 'basket')

@php
/** @var \App\Model\Delivery\Entity\Delivery\DeliveryMethod[] $deliveryMethods */
/** @var \App\Model\Cart\Service\CartItem[] $items */
/** @var \App\Model\Cart\Service\Cart $cart */
@endphp

@section('content')
    <div class="basket__title">{{ __('Cart') }}</div>

    <cart-component :items='@json($cartItems)' :delivery-methods='@json($deliveryMethods)' >
        @csrf
    </cart-component>
@endsection
