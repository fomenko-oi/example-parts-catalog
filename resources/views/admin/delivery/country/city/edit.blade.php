@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Country\Country $country */
/** @var \App\Model\Delivery\Entity\Country\CountryRegion $region */
/** @var \App\Model\Delivery\Entity\Country\City $city */
@endphp

@section('content')
    <div class="content-heading">
        Updating city {{ $city->name }}
    </div>

    {{ Breadcrumbs::render('admin.countries.regions.cities.edit', $country, $region, $city) }}

    <div class="card">
        <div class="card-body">
            <h4>Updating city {{ $city->name }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.countries.regions.cities.update', [$country, $region, $city]) }}" >
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $city->name }}" required>

                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')@endsection
@section('scripts')@endsection
