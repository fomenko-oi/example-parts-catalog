@extends('layout.admin')

@php
/** @var \App\Entity\Common\Config[] $configs */
@endphp

@section('content')
    <div class="content-heading">
        Configs
        <a class="btn btn-primary ml-auto" href="{{ route('admin.configs.create') }}">
            <em class="fa fa-plus-circle fa-fw mr-1"></em>
            New param
        </a>
    </div>

    {{ Breadcrumbs::render('admin.configs.index') }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Autoload</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($configs as $config)
                            <tr>
                                <td>{{ $config->name }}</td>
                                <td>{{ $config->key }}</td>
                                <td>{{ $config->value }}</td>
                                <td>{{ $config->autoload ? 'Yes' : 'No' }}</td>
                                <td>
                                    <form action="{{ route('admin.configs.remove', $config) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-xs btn-danger">
                                            <em class="fa-1x mr-1 ml-1 fas fa-trash-alt"></em>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.configs.edit', $config) }}" class="btn btn-xs btn-success d-inline-block">
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
