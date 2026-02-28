@extends('adminlte::page')

@section('title', 'Supplier Payments')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Supplier Payment Tracking List</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('supplier_payments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create New
            </a>
        </div>
    </div>
@stop


@section('content')
    <div class="card shadow-sm border-left-danger">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>#</th>
                        <th>Payment No</th>
                        <th>Supplier</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $key => $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->payment_no }}</td>
                            <td>{{ $payment->supplier->name ?? '-' }}</td>
                            <td>৳{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_date->format('d M Y') }}</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td class="text-center">
                                <a href="{{ route('supplier_payments.edit', $payment->id) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('supplier_payments.show', $payment->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('supplier_payments.destroy', $payment->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure to delete this data?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
