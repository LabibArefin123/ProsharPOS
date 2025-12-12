@extends('adminlte::page')

@section('title', 'Edit Brand')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Brand</h3>
        <a href="{{ route('brands.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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

    <div class="container">
        <div class="card shadow-lg">
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
                <form action="{{ route('brands.update', $brand->id) }}" method="POST" data-confirm="edit">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Brand Name --}}
                        <div class="form-group col-md-6">
                            <label for="name">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $brand->name) }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter brand name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div class="form-group col-md-6">
                            <label for="category_id">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $brand->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Description (optional, full width) --}}
                        <div class="form-group col-md-12">
                            <label for="description">Description (Optional)</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description">{{ old('description', $brand->description) }}</textarea>
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
