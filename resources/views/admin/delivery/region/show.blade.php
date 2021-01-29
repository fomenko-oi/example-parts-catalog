@extends('layout.admin')

@php
/** @var \App\Model\Delivery\Entity\Delivery\DeliveryMethod $delivery */
/** @var \App\Model\Delivery\Entity\Region\Region $region */
@endphp

@section('content')
    <div class="content-heading">
        Region {{ $region->name }}
    </div>

    {{ Breadcrumbs::render('admin.delivery_methods.regions.show', $delivery, $region) }}

    <div class="card">
        <div class="card-header">
            <div class="float-right">
                <div class="row">
                    <div class="col-md-3">
                        <form action="{{ route('admin.delivery_methods.regions.prices.export', [$delivery, $region]) }}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-success" value="Export">
                        </form>
                    </div>

                    <div class="col-md-7 offset-md-2">
                        @error('file')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <form action="{{ route('admin.delivery_methods.regions.prices.import', [$delivery, $region]) }}" method="POST" class="d-inline-block" title="import" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-8">
                                    <input
                                        name="file"
                                        id="exported_file"
                                        class="form-control filestyle"
                                        type="file"
                                        data-classbutton="btn btn-secondary"
                                        data-classinput="form-control inline"
                                        data-icon="&lt;span class='fa fa-upload mr-2'&gt;&lt;/span&gt;"
                                    />
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary" disabled id="submit_import_btn">
                                        Import
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <h4>Prices</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.delivery_methods.regions.ranges', [$delivery, $region]) }}" method="POST">
                @method('PUT')
                @csrf

                <price-ranges-component :ranges='@json($ranges)' />
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach($countries as $country)
                    <div class="col-md-3 list-group-item">
                        {{ $country->name }}

                        <form action="{{ route('admin.delivery_methods.regions.ranges.remove', [$delivery, $region, $country]) }}" method="POST" class="float-right" onsubmit="return confirm('Are you sure want to delete?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-xs btn-danger">
                                <em class="fa-1x mr-1 ml-1 fas fa-trash-alt"></em>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('styles')@endsection
@section('scripts')
    <script src="{{ asset('js/forms.js') }}"></script>

    <script>
        $('#exported_file').change(function(e) {
            var $el = $('#exported_file');

            if(e.target.files.length > 0) {
                $('#submit_import_btn').attr('disabled', false)
            } else {
                $('#submit_import_btn').attr('disabled', true)
            }
        })
    </script>
@endsection
