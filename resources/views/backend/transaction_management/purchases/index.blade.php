@extends('adminlte::page')

@section('title', 'Purchase List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Purchase List</h3>
        <a href="{{ route('purchases.create') }}" class="btn btn-sm btn-success">
            Add Purchase
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Reference</th>
                        <th>Total Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>{{ $purchase->purchase_date }}</td>
                            <td>{{ $purchase->reference_no }}</td>
                            <td>৳{{ number_format($purchase->total_amount, 2) }}</td>
                            <td>
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-info">View</a>

                                <a href="{{ route('purchases.edit', $purchase->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('purchase_returns.createP', $purchase->id) }}"
                                    class="btn btn-sm btn-warning">
                                    Return
                                </a>
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
