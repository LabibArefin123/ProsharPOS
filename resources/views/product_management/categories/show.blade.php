@extends('adminlte::page')

@section('title', 'Category Details')

@section('content_header')
    <h1 class="m-0 text-dark">Category Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $category->slug }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $category->description ?? '-' }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
@stop
