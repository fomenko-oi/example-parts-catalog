@extends('layout.admin')

@php
/** @var \App\Entity\Common\Config $config */
@endphp
@section('content')
    <div class="content-heading">
        Updating param {{ $config->name }}
    </div>

    {{ Breadcrumbs::render('admin.configs.edit', $config) }}

    <div class="card">
        <div class="card-body">
            <h4>Updating param {{ $config->name }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.configs.updated', $config) }}" >
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $config->name }}" required>

                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="key" class="col-form-label">Key *</label>
                            <input id="key" type="text" class="form-control @error('key') is-invalid @enderror" name="key" value="{{ $config->key }}">

                            @error('key')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="value" class="col-form-label">Value</label>
                            <input id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="value" value="{{ $config->value }}">

                            @error('value')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="autoload" class="col-form-label">Autoload</label>
                            <input id="autoload" type="checkbox" class="@error('autoload') is-invalid @enderror" name="autoload" {{ $config->autoload ? 'checked' : '' }} value="1">

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
