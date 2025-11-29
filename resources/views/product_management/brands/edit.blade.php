@extends('adminlte::page')

@section('title', 'Edit Brand')

@section('content_header')
    <h1>Edit Brand</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Please fix the following issues:
                    <ul class="mb-0 mt-2 pl-3">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('brands.update', $brand->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Brand Name --}}
                    <div class="form-group col-md-6">
                        <label for="name">Brand Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $brand->name) }}"
                            class="form-control" placeholder="Enter brand name">
                    </div>

                    {{-- Category --}}
                    <div class="form-group col-md-6">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $brand->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description (optional, full width) --}}
                    <div class="form-group col-md-12">
                        <label for="description">Description (Optional)</label>
                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description">{{ old('description', $brand->description) }}</textarea>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to list
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Brand
                    </button>
                </div>
            </form>

        </div>
    </div>

@stop
