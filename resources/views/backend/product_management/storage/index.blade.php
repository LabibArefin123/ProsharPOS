@extends('adminlte::page')

@section('title', 'Storage List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Storage List</h1>
        <a href="{{ route('storages.create') }}" class="btn btn-success btn-sm">
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
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Manufacturer Name</th>
                        <th>Stock Quantity</th>
                        <th>Alert Quantity</th>
                        <th>Rack</th>
                        <th>Rack No</th>
                        <th>Rack Location</th>
                        <th>Box</th>
                        <th>Box No</th>
                        <th>Box Location</th>
                        <th>Supplied By</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($storages as $store)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($store->image_path ?? 'images/default.jpg') }}" alt="{{ $store->name }}"
                                    class="img-thumbnail" style="width: 60px; height: 60px;">
                            </td>
                            <td>{{ $store->product->name ?? '-' }}</td>
                            <td>{{ $store->manufacturer->name ?? '-' }}</td>
                            <td>{{ $store->stock_quantity }}</td>
                            <td>{{ $store->alert_quantity }}</td>
                            <td>{{ $store->rack_number }}</td>
                            <td>{{ $store->rack_no }}</td>
                            <td>{{ $store->rack_location }}</td>
                            <td>{{ $store->box_number }}</td>
                            <td>{{ $store->box_no }}</td>
                            <td>{{ $store->box_location }}</td>
                            <td>{{ $store->supplier->name ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $store->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $store->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('storages.edit', $store->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('storages.show', $store->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('storages.destroy', $store->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('storages.destroy', $store->id) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center text-muted py-3">No storage found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
