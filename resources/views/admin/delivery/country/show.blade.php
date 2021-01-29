@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Country\Country] $country */
/** @var \App\Model\Delivery\Entity\Country\CountryRegion[] $regions */
@endphp

@section('content')
    <div class="content-heading">
        Country {{ $country->name }}
        <a class="btn btn-primary ml-auto" href="{{ route('admin.countries.regions.create', $country) }}">
            <em class="fa fa-plus-circle fa-fw mr-1"></em>
            New region
        </a>
    </div>

    {{ Breadcrumbs::render('admin.countries.show', $country) }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            {{--<th>Name RU</th>--}}
                            <th>Cities Count</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($regions as $region)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.countries.regions.show', [$country, $region]) }}">{{ $region->name }}</a>
                                </td>
                                {{--<td>{{ $region->name_ru }}</td>--}}
                                <td style="width: 7%">{{ $region->cities_count }}</td>
                                <td>
                                    <form action="{{ route('admin.countries.regions.destroy', [$country, $region]) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" class="d-inline-block">
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
