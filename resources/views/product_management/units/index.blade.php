@extends('adminlte::page')

@section('title', 'Unit List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Unit List</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('units.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create New
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow">
        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">All Units</h3>
        </div>

        {{-- Table --}}
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover mb-0" style="background-color: #fff;">
                <thead class="thead-light text-center">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>Created By</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->short_name }}</td>
                            <td>{{ $unit->createdBy->name ?? 'N/A' }}</td>
                            <td class="d-flex justify-content-center gap-1">
                                {{-- Show --}}
                                <a href="{{ route('units.show', $unit->id) }}" class="btn btn-sm btn-outline-info"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-outline-primary"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="d-inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this unit?');">
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
                            <td colspan="5" class="text-center text-muted py-4">No units found.</td>
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
