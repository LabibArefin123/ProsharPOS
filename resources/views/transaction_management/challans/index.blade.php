@extends('adminlte::page')

@section('title', 'Challan List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Challan List</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('challans.create') }}" class="btn btn-primary btn-sm">
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
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Challan No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Branch</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($challans as $challan)
                            <tr>
                                <td>{{ $challan->id }}</td>
                                <td>{{ $challan->challan_no }}</td>
                                <td>{{ $challan->challan_date }}</td>
                                <td>{{ $challan->customer?->name }}</td>
                                <td>{{ $challan->product?->name }}</td>
                                <td>{{ $challan->branch?->name }}</td>
                                <td>{{ $challan->quantity }}</td>
                                <td>{{ ucfirst($challan->status) }}</td>
                                <td>
                                    <a href="{{ route('challans.edit', $challan->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('challans.destroy', $challan->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="triggerDeleteModal('{{ route('challans.destroy', $challan->id) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('challans.show', $challan->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No challans found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
