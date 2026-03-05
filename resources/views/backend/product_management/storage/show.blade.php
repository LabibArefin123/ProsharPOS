@extends('adminlte::page')

@section('title', 'Storage Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Storage Details</h3>
        <div>
            <a href="{{ route('storages.edit', $storage->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('storages.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            @include('backend.product_management.storage.partial_show.part_1')

            {{-- Start of Storage Part --}}
            <div class="row ">
                @include('backend.product_management.storage.partial_show.part_2')
                @include('backend.product_management.storage.partial_show.part_3')
                <div class="width=100"></div>
                @include('backend.product_management.storage.partial_show.part_4')

            </div>
        </div>
        {{-- End of Storage Part --}}

    </div>
@endsection
