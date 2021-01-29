@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Country\Country $country */
/** @var \App\Model\Delivery\Entity\Country\CountryRegion $region */
/** @var \App\Model\Delivery\Entity\Country\City[] $cities */
@endphp

@section('content')
    <div class="content-heading">
        Region <b> {{ $region->name }}</b>

        <a class="btn btn-primary ml-auto" href="{{ route('admin.countries.regions.cities.create', [$country, $region]) }}">
            <em class="fa fa-plus-circle fa-fw mr-1"></em>
            New city
        </a>
    </div>

    {{ Breadcrumbs::render('admin.countries.regions.show', $country, $region) }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($cities as $city)
                            <tr>
                                <td>{{ $city->name }}</td>
                                <td>
                                    <form action="{{ route('admin.countries.regions.cities.remove', [$country, $region, $city]) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-xs btn-danger">
                                            <em class="fa-1x mr-1 ml-1 fas fa-trash-alt"></em>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.countries.regions.cities.edit', [$country, $region, $city]) }}" class="btn btn-xs btn-success d-inline-block">
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
