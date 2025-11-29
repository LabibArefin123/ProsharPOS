@extends('adminlte::page')

@section('title', 'Category List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Category List</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create New
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header table-responsive p-0">
            <table class="table table-bordered table-hover mb-0" style="background-color: #fff;">
                <thead class="thead-light text-center">
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
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
@stop
@section('js')
    @if (session('success') || session('error') || session('warning') || session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                @if (session('success'))
                    Toast.fire({
                        icon: 'success',
                        title: @json(session('success'))
                    });
                @elseif (session('error'))
                    Toast.fire({
                        icon: 'error',
                        title: @json(session('error'))
                    });
                @elseif (session('warning'))
                    Toast.fire({
                        icon: 'warning',
                        title: @json(session('warning'))
                    });
                @elseif (session('info'))
                    Toast.fire({
                        icon: 'info',
                        title: @json(session('info'))
                    });
                @endif
            });
        </script>
    @endif
@endsection
