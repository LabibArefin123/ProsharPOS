@extends('adminlte::page')

@section('title', 'Category Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Category Details</h3>
        <div>
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ $category->name }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Slug</label>
                        <input type="text" class="form-control" value="{{ $category->slug }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <input type="text" class="form-control" value="{{ $category->status }}" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea class="form-control" rows="3" readonly>{{ $category->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
