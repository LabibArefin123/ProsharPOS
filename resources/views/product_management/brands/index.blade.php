@extends('adminlte::page')

@section('title', 'Brand List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Brand List</h1>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-success btn-sm">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
            <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create New
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-bordered table-striped">
                <thead class="thead-light">
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
