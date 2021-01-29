@extends('layout.app')

@section('app_section_class', 'offer')

@php
/** @var \App\Model\Delivery\Entity\Delivery\DeliveryMethod[] $deliveryMethods */
/** @var \App\Model\Cart\Service\CartItem[] $items */
/** @var \App\Model\Cart\Service\Cart $cart */
/** @var \App\Model\Auth\Entity\User $user */
/** @var \App\Model\Auth\Entity\Address\Address $address */
@endphp

@section('content')
    <order-checkout-component
        :delivery-methods='@json($deliveryMethods)'
        :payment-types='@json($paymentTypes)'
        :countries='@json($countries)'
        :cart='@json(new \App\Http\Resources\User\Cart\CartResource($cart))'
        :address='@json($address)'
        :user='@json($user)'
    />
@endsection
