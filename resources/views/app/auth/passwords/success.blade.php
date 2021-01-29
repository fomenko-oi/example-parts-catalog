@extends('layout.app')

@section('breadcrumbs', '')

@section('content')
    <div class="login">
        <div class="text">
            <div class="text__title">Проверьте почту</div>
            <p>Вам выслан новый пароль на почту {{ $email }}</p>
        </div>
    </div>
@endsection
