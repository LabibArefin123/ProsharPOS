@extends('adminlte::page')

@section('title', 'Challan List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Challan List</h1>
        <a href="{{ route('challans.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Challan
        </a>
    </div>
@endsection


@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif



    <table class="table table-bordered table-striped">
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
                        <a href="{{ route('challans.edit', $challan->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('challans.destroy', $challan->id) }}" method="POST"
                            style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>

                        <a href="{{ route('challans.show', $challan->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No challans found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@stop
