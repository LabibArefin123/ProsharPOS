@extends('adminlte::page')

@section('title', 'Brand List')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Brand List</h1>
        <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
@stop
@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th>Brand Name</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->category->name ?? '-' }}</td>
                                <td>{{ $brand->description }}</td>
                                <td>{{ $brand->createdBy->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    {{-- Show --}}
                                    <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-info btn-sm me-1"
                                        title="View">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary btn-sm me-1"
                                        title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST"
                                        class="d-inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this brand?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">No brands found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
