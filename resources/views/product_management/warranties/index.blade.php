@extends('adminlte::page')

@section('title', 'Warranty List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Warranty List</h1>
        <a href="{{ route('warranties.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New Warranty
        </a>
    </div>
@stop

@section('content')
    {{-- Card Table --}}
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped m-0 text-sm bg-white">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th style="width: 50px;">SL</th>
                            <th>Warranty Name</th>
                            <th>Duration Type</th>
                            <th>Day Count</th>
                            <th>Description</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($warranties as $warranty)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $warranty->name }}</td>
                                <td class="text-capitalize">{{ $warranty->duration_type }}</td>
                                <td>{{ $warranty->day_count }}</td>
                                <td>{{ $warranty->description ?? '-' }}</td>
                                <td class="d-flex justify-content-center gap-1">
                                    {{-- Show --}}
                                    <a href="{{ route('warranties.show', $warranty->id) }}"
                                        class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('warranties.edit', $warranty->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('warranties.destroy', $warranty->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this warranty?');">
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
                                <td colspan="6" class="text-center text-muted py-4">No warranty found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
