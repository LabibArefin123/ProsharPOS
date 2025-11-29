@extends('adminlte::page')

@section('title', 'View Brand')

@section('content_header')
    <h1>Brand Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- Brand Name --}}
                <div class="form-group col-md-6">
                    <label>Brand Name:</label>
                    <input type="text" class="form-control" value="{{ $brand->name }}" readonly>
                </div>

                {{-- Category --}}
                <div class="form-group col-md-6">
                    <label>Category:</label>
                    <input type="text" class="form-control" value="{{ $brand->category->name ?? '-' }}" readonly>
                </div>

                {{-- Description --}}
                <div class="form-group col-md-12">
                    <label>Description:</label>
                    <textarea class="form-control" rows="3" readonly>{{ $brand->description }}</textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>

                <div>
                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline-block"
                        onsubmit="return confirm('Are you sure you want to delete this brand?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
