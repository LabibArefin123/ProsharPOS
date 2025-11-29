@extends('adminlte::page')

@section('title', 'Branch List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Branch List</h1>
        <a href="{{ route('branches.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Branch
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover table-striped text-sm m-0">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th>SL</th>
                        <th>Name</th>
                        <th>Balance</th>
                        <th>City</th>
                        <th>Post Code</th>
                        <th>Phone</th>
                        <th>Alternate Phone</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($branches as $branch)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $branch->name }}</td>
                            <td>৳{{ number_format($branch->balance, 2) }}</td>
                            <td>{{ $branch->city ?? '-' }}</td>
                            <td>{{ $branch->post_code ?? '-' }}</td>
                            <td>{{ $branch->phone_number ?? '-' }}</td>
                            <td>{{ $branch->alternate_number ?? '-' }}</td>
                            <td>{{ $branch->email ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('branches.show', $branch->id) }}" class="btn btn-sm btn-info"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-sm btn-primary"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('branches.destroy', $branch->id) }}" method="POST"
                                    class="d-inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">No branches found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end me-3">
                {{ $branches->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
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
