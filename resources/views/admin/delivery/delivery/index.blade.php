@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Delivery\DeliveryMethod[] $methods */
@endphp

@section('content')
    <div class="content-heading">
        Configs
        <a class="btn btn-primary ml-auto" href="{{ route('admin.delivery_methods.create') }}">
            <em class="fa fa-plus-circle fa-fw mr-1"></em>
            New delivery method
        </a>
    </div>

    {{ Breadcrumbs::render('admin.delivery_methods.index') }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Name Ru</th>
                            <th>Key</th>
                            <th>Min weight</th>
                            <th>Max weight</th>
                            <th>Sort</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($methods as $method)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.delivery_methods.show', $method) }}">{{ $method->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.delivery_methods.show', $method) }}">{{ $method->name_ru }}</a>
                                </td>
                                <td>{{ $method->key }}</td>
                                <td>{{ $method->min_weight }}</td>
                                <td>{{ $method->max_weight }}</td>
                                <td>{{ $method->sort }}</td>
                                <td>
                                    <form action="{{ route('admin.delivery_methods.destroy', $method) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-xs btn-danger">
                                            <em class="fa-1x mr-1 ml-1 fas fa-trash-alt"></em>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.delivery_methods.edit', $method) }}" class="btn btn-xs btn-success d-inline-block">
                                        <em class="fa-1x mr-1 ml-1 fas fa-edit"></em>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')@endsection
@section('scripts')@endsection
