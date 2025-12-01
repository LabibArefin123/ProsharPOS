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
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr class="text-center">
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
                                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="triggerDeleteModal('{{ route('units.destroy', $unit->id) }}')">
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
    </div>
@stop
