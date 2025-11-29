@extends('adminlte::page')

@section('title', 'Add User Category')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New User Category</h3>
        <a href="{{ route('user_categories.index') }}"
            class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('user_categories.store') }}" method="POST" data-confirm="create">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="category_name"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="category_name" id="category_name"
                                class="form-control @error('category_name') is-invalid @enderror"
                                value="{{ old('category_name') }}" placeholder="Enter buiding name">
                            @error('category_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="category_name_in_bangla"><strong>Name in Bangla</label>
                            <input type="text" name="category_name_in_bangla" id="category_name_in_bangla"
                                class="form-control @error('category_name_in_bangla') is-invalid @enderror"
                                value="{{ old('category_name_in_bangla') }}" placeholder="Enter building name in bangla">
                            @error('category_name_in_bangla')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="description"><strong>Description</strong></label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
