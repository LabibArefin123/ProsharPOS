@extends('adminlte::page')

@section('title', 'Edit Product Damage')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Product Damage</h3>

        <a href="{{ route('products_damages.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">

            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>
@stop


@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products_damages.update', $productDamage->id) }}" method="POST"
                enctype="multipart/form-data" data-confirm="update">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Storage</label>
                        <select name="storage_id" class="form-control">

                            <option value="">-- Select Product Storage --</option>

                            @foreach ($storages as $storage)
                                <option value="{{ $storage->id }}"
                                    {{ old('storage_id', $productDamage->storage_id) == $storage->id ? 'selected' : '' }}>

                                    {{ $storage->product->name ?? 'Product' }}
                                    (Stock: {{ $storage->stock_quantity }})
                                </option>
                            @endforeach

                        </select>

                        @error('storage_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Damage Quantity</label>

                        <input type="number" name="damage_qty" class="form-control" min="1"
                            value="{{ old('damage_qty', $productDamage->damage_qty) }}">

                        @error('damage_qty')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Damage Image</label>
                        <input type="file" name="damage_image" class="form-control">
                        @if ($productDamage->damage_image)
                            <div class="mt-2">
                                <img src="{{ asset($productDamage->damage_image) }}" width="80" class="img-thumbnail">
                            </div>
                        @endif
                        @error('damage_image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Damage Solution</label>

                        <input type="text" name="damage_solution" class="form-control"
                            value="{{ old('damage_solution', $productDamage->damage_solution) }}">

                        @error('damage_solution')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Damage Description</label>

                        <textarea name="damage_description" class="form-control" rows="3">{{ old('damage_description', $productDamage->damage_description) }}</textarea>

                        @error('damage_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Damage Note</label>

                        <textarea name="damage_note" class="form-control" rows="3">{{ old('damage_note', $productDamage->damage_note) }}</textarea>

                        @error('damage_note')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="text-end">

                    <a href="{{ route('products_damages.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Damage
                    </button>

                </div>
            </form>
        </div>
    </div>

@stop
