@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Country\Country $country */
@endphp

@section('content')
    <div class="content-heading">
        New Region for country {{ $country->name }}
    </div>

    {{ Breadcrumbs::render('admin.countries.regions.create', $country) }}

    <div class="card">
        <div class="card-body">
            <h4>New Region for country {{ $country->name }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.countries.regions.store', $country) }}" >
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

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
