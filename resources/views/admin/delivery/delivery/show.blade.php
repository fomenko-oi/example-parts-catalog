@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Delivery\DeliveryMethod $delivery */
/** @var \App\Model\Delivery\Entity\Region\Region[] $regions */
@endphp

@section('content')
    <div class="content-heading">
        Delivery <b>{{ $delivery->name }}</b>

        <a class="btn btn-primary ml-auto" href="{{ route('admin.delivery_methods.regions.create', [$delivery]) }}">
            <em class="fa fa-plus-circle fa-fw mr-1"></em>
            New region
        </a>
    </div>

    {{ Breadcrumbs::render('admin.delivery_methods.show', $delivery) }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Countries count</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($regions as $region)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.delivery_methods.regions.show', [$delivery, $region]) }}">
                                        {{ $region->name }}
                                    </a>
                                </td>
                                <td>{{ $region->countries_count }}</td>
                                <td>
                                    <form action="{{ route('admin.delivery_methods.regions.destroy', [$delivery, $region]) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-xs btn-danger">
                                            <em class="fa-1x mr-1 ml-1 fas fa-trash-alt"></em>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.delivery_methods.regions.edit', [$delivery, $region]) }}" class="btn btn-xs btn-success d-inline-block">
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
