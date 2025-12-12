@extends('adminlte::page')

@section('title', 'System Information')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">System Information</h1>

        <a href="{{ route('system_informations.create') }}"
            class="btn btn-success btn-sm d-flex align-items-center gap-2 shadow-sm rounded-pill px-3 py-2">

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
                viewBox="0 0 16 16">
                <path
                    d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM4 8a.5.5 0 0 1 .5-.5H7.5V4a.5.5 0 0 1 1 0V7.5H11.5a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V8.5H4.5A.5.5 0 0 1 4 8z" />
            </svg>

            <span>Add New</span>
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-striped table-hover text-nowrap text-center" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Slogan</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->slogan ?? '—' }}</td>

                                <td>
                                    @if ($item->photo)
                                        <img src="{{ asset('upload/system_information/' . $item->photo) }}" width="50"
                                            height="50" class="rounded shadow-sm" style="object-fit: cover;">
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('system_informations.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <a href="{{ route('system_informations.show', $item->id) }}"
                                        class="btn btn-secondary btn-sm">
                                        Show
                                    </a>

                                    <button class="btn btn-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('system_informations.destroy', $item->id) }}')">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@stop
