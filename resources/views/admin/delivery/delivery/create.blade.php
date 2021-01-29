@extends('layout.admin')

@php
@endphp
@section('content')
    <div class="content-heading">
        New delivery method
    </div>

    {{ Breadcrumbs::render('admin.delivery_methods.create') }}

    <div class="card">
        <div class="card-body">
            <h4>New delivery method</h4>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.delivery_methods.store') }}" >
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="name_ru" class="col-form-label">Name Ru</label>
                            <input id="name_ru" class="form-control @error('name_ru') is-invalid @enderror" name="name_ru" value="{{ old('name_ru') }}">

                            @error('name_ru')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="key" class="col-form-label">Key</label>
                            <input id="key" class="form-control @error('key') is-invalid @enderror" name="key" value="{{ old('key') }}" required>

                            @error('key')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_weight" class="col-form-label">Min weight</label>
                                    <input id="min_weight" type="number" step="0.1" class="form-control @error('min_weight') is-invalid @enderror" name="min_weight" value="{{ old('min_weight') }}">

                                    @error('min_weight')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_weight" class="col-form-label">Max weight</label>
                                    <input id="max_weight" type="number" step="0.1" class="form-control @error('max_weight') is-invalid @enderror" name="max_weight" value="{{ old('max_weight') }}">

                                    @error('max_weight')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sort" class="col-form-label">Sort</label>
                            <input id="sort" type="number" class="form-control @error('sort') is-invalid @enderror" name="sort" value="{{ old('sort', $sort) }}">

                            @error('sort')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
