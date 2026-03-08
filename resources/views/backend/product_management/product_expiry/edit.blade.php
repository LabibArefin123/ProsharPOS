@extends('adminlte::page')

@section('title', 'Edit Product Expiry')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Edit Product Expiry</h3>
        <a href="{{ route('products_expirys.index') }}" class="btn btn-sm btn-secondary">
            Back
        </a>
    </div>
@stop


@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products_expirys.update', $productExpiry->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3">
                        <label>Select Storage</label>
                        <select name="storage_id" class="form-control">
                            @foreach ($storages as $storage)
                                <option value="{{ $storage->id }}"
                                    {{ $productExpiry->storage_id == $storage->id ? 'selected' : '' }}>

                                    {{ $storage->product->name ?? '-' }}
                                    (Stock: {{ $storage->stock_quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Expired Quantity</label>
                        <input type="number" name="expired_qty" class="form-control"
                            value="{{ $productExpiry->expired_qty }}">
                    </div>
                    <div class="col-md-3">
                        <label>Solution</label>
                        <input type="text" name="error_solution" class="form-control"
                            value="{{ $productExpiry->error_solution }}">
                    </div>
                    <div class="col-md-3">
                        <label>Upload Image</label>
                        <input type="file" name="expiry_image" class="form-control">

                        @if ($productExpiry->expiry_image)
                            <div class="mt-2">
                                <img src="{{ asset($productExpiry->expiry_image) }}" width="80" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>Description</label>
                        <textarea name="expiry_description" class="form-control">
                        {{ $productExpiry->expiry_description }}
                        </textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>Note</label>
                        <textarea name="expiry_note" class="form-control">
                            {{ $productExpiry->expiry_note }}
                            </textarea>
                    </div>

                </div>
                <div class="text-end mt-3">

                    <a href="{{ route('products_expirys.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>

                </div>
            </form>
        </div>
    </div>
@stop
