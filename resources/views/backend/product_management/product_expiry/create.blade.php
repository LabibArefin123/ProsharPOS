@extends('adminlte::page')

@section('title', 'Create Product Expiry')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Create Product Expiry</h3>
        <a href="{{ route('products_expirys.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop


@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products_expirys.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>Select Storage</label>
                        <select name="storage_id" class="form-control">
                            <option value="">Select Storage</option>

                            @foreach ($storages as $storage)
                                <option value="{{ $storage->id }}">

                                    {{ $storage->product->name ?? '-' }}
                                    (Stock: {{ $storage->stock_quantity }})
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Expired Quantity</label>
                        <input type="number" name="expired_qty" class="form-control" min="1">
                    </div>
                    <div class="col-md-3">
                        <label>Solution</label>
                        <input type="text" name="error_solution" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Upload Image</label>
                        <input type="file" name="expiry_image" class="form-control">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>Description</label>
                        <textarea name="expiry_description" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>Note</label>
                        <textarea name="expiry_note" class="form-control"></textarea>
                    </div>

                </div>
                <div class="text-end mt-3">

                    <a href="{{ route('products_expirys.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button class="btn btn-success">
                        <i class="fas fa-save"></i> Save Expiry
                    </button>

                </div>

            </form>
        </div>
    </div>
@stop
