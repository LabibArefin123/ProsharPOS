@extends('adminlte::page')

@section('title', 'View Category')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Category Details</h3>
        <div>
            <a href="{{ route('user_categories.edit', $userCategory->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('user_categories.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Category Name</strong></label>
                        <input type="text" class="form-control" value="{{ $userCategory->category_name }}" readonly>
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Category Name (in Bangla)</strong></label>
                        <input type="text" class="form-control" value="{{ $userCategory->category_name_in_bangla }}"
                            readonly>
                    </div>


                    <div class="col-md-12 form-group">
                        <label><strong>Description</strong></label>
                        <textarea class="form-control" rows="3" readonly>{{ $userCategory->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
