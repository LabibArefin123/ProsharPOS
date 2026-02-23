@extends('adminlte::page')

@section('title', 'Edit Storage')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Storage</h3>
        <a href="{{ route('storages.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('storages.update', $storage->id) }}" method="POST" enctype="multipart/form-data"
                data-confirm="edit">
                @csrf
                @method('PUT')
                @include('backend.product_management.storage.partial_edit.part_1')
                @include('backend.product_management.storage.partial_edit.part_2')
                @include('backend.product_management.storage.partial_edit.part_3')
                @include('backend.product_management.storage.partial_edit.part_4')
                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="image_path"
                        class="form-control-file @error('image_path') is-invalid @enderror">
                    @error('image_path')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
        </div>
    </div>
    <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
    </form>

    <script src="{{ asset('js/backend/storage/product_load.js') }}"></script> {{--  Product load  JS --}}
    <script src="{{ asset('js/backend/storage/supplier_load.js') }}"></script> {{--  Supplier load  JS --}}
    <script src="{{ asset('js/backend/storage/manufacture_load.js') }}"></script> {{--  Manufacture load  JS --}}
@endsection
