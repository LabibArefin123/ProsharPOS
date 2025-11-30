@extends('adminlte::page')

@section('title', 'Organizations')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1>Organizations</h1>
        <a href="{{ route('organizations.create') }}" class="btn btn-success btn-sm">
            + Add Organization
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 60px;" class="text-center">SL</th>
                            <th>Organization Name</th>
                            <th style="width: 160px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($organizations as $key => $organization)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $organization->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('organizations.edit', $organization->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </a>
                                        <a href="{{ route('organizations.show', $organization->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Show
                                        </a>
                                        <form action="{{ route('organizations.destroy', $organization->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="triggerDeleteModal('{{ route('organizations.destroy', $organization->id) }}')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No organizations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
