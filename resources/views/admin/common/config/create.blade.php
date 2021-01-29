@extends('layout.admin')

@php
@endphp
@section('content')
    <div class="content-heading">
        New config param
    </div>

    {{ Breadcrumbs::render('admin.configs.create') }}

    <div class="card">
        <div class="card-body">
            <h4>New config param</h4>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.configs.store') }}" >
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="key" class="col-form-label">Key *</label>
                            <input id="key" type="text" class="form-control @error('key') is-invalid @enderror" name="key" value="{{ old('key') }}">

                            @error('key')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="value" class="col-form-label">Value</label>
                            <input id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}">

                            @error('value')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="autoload" class="col-form-label">Autoload</label>
                            <input id="autoload" type="checkbox" class="@error('autoload') is-invalid @enderror" name="autoload" {{ old('autoload') === 1 ? 'checked' : '' }} value="1">

                            @error('autoload')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
