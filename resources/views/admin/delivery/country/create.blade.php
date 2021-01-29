@extends('layout.admin')

@section('content')
    <div class="content-heading">
        New Country
    </div>

    {{ Breadcrumbs::render('admin.countries.create') }}

    <div class="card">
        <div class="card-body">
            <h4>New Country</h4>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.countries.store') }}" >
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="name_ru" class="col-form-label">Name RU</label>
                            <input id="name_ru" class="form-control @error('name_ru') is-invalid @enderror" name="name_ru" value="{{ old('name_ru') }}">

                            @error('name_ru')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
