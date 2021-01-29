@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Delivery\DeliveryMethod $delivery */
/** @var \App\Model\Delivery\Entity\Region\Region $region */
/** @var \App\Model\Delivery\Entity\Country\Country[] $countries */
@endphp

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-heading">
        Updating <b>{{ $region->name }}</b>
    </div>

    {{ Breadcrumbs::render('admin.delivery_methods.regions.edit', $delivery, $region) }}

    <div class="card">
        <div class="card-body">
            <h4>Updating <b>{{ $region->name }}</b></h4>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.delivery_methods.regions.update', [$delivery, $region]) }}" >
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $region->name }}" required>

                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <p class="my-2"><label for="countries">Countries</label></p>
                            <select name="countries[]" class="form-control" id="countries" multiple="multiple">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ in_array($country->id, $selectedCountryIds) ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
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

@section('scripts')
    <script>
        window.jQuery = $;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#countries').select2({
                tags: false
            });
        });
    </script>
@endsection

