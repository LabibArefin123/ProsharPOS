@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Category</h3>
        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
                        <strong>Whoops!</strong> Please fix the following errors:
                        <ul class="mb-0 mt-2 pl-3">
                            @foreach ($errors->all() as $error)
                                <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('categories.update', $category->id) }}" method="POST" data-confirm="edit">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter category name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                                class="form-control @error('slug') is-invalid @enderror" placeholder="Enter slug">
                            @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="">
                                    Select Status
                                </option>
                                <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description">{{ old('description', $category->description) }}</textarea>
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
