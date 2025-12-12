@extends('adminlte::page')

@section('title', 'Category List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Category List</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
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
                            <th style="width: 40px;">SL</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->description ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $category->status ? 'badge-success' : 'badge-danger' }}">
                                        {{ $category->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="d-flex">
                                    {{-- Show --}}
                                    <a href="{{ route('categories.show', $category->id) }}"
                                        class="btn btn-sm btn-outline-info me-2" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="triggerDeleteModal('{{ route('categories.destroy', $category->id) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
