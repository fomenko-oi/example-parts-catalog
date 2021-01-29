@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Country\Country[] $countries */
@endphp

@section('content')
    <div class="content-heading">
        Countries
        <a class="btn btn-primary ml-auto" href="{{ route('admin.countries.create') }}">
            <em class="fa fa-plus-circle fa-fw mr-1"></em>
            New country
        </a>
    </div>

    {{ Breadcrumbs::render('admin.countries.index') }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Name RU</th>
                            <th>Regions Count</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.countries.show', $country) }}">{{ $country->name }}</a>
                                </td>
                                <td>{{ $country->name_ru }}</td>
                                <td style="width: 7%">{{ $country->regions_count }}</td>
                                <td>
                                    <form action="{{ route('admin.countries.destroy', $country) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-xs btn-danger">
                                            <em class="fa-1x mr-1 ml-1 fas fa-trash-alt"></em>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-xs btn-success d-inline-block">
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
