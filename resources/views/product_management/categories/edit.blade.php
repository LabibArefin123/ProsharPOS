@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Category</h1>
@stop

@section('content')
    <div class="card">
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

            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                            class="form-control" placeholder="Enter category name">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                            class="form-control" placeholder="Enter slug">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description">{{ old('description', $category->description) }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
