@extends('adminlte::page')

@section('title', 'Warranty List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Warranty List</h1>
        <a href="{{ route('warranties.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
@stop

@section('content')
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
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
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="triggerDeleteModal('{{ route('warranties.destroy', $warranty->id) }}')">
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
@stop
