@extends('adminlte::page')

@section('title', 'Sales Return Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0 text-danger">
            <i class="fas fa-file-invoice"></i> Sales Return Details
        </h3>

        <a href="{{ route('sales_returns.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')

    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Return No:</strong><br>
                    <span class="badge badge-danger">{{ $return->return_no }}</span>
                </div>

                <div class="col-md-3">
                    <strong>Invoice:</strong><br>
                    {{ $return->invoice?->invoice_id }}
                </div>

                <div class="col-md-3">
                    <strong>Customer:</strong><br>
                    {{ $return->customer?->name }}
                </div>

                <div class="col-md-3">
                    <strong>Date:</strong><br>
                    {{ \Carbon\Carbon::parse($return->return_date)->format('d F Y') }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Refund Method:</strong><br>
                    <span class="badge badge-secondary">
                        {{ ucfirst($return->refund_method) }}
                    </span>
                </div>

                <div class="col-md-3">
                    <strong>Created By:</strong><br>
                    {{ $return->createdBy?->name }}
                </div>

                <div class="col-md-6">
                    <strong>Note:</strong><br>
                    {{ $return->note ?? 'N/A' }}
                </div>
            </div>

        </div>
    </div>

    {{-- Items --}}
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <strong>Returned Products</strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($return->items as $item)
                        <tr>
                            <td>{{ $item->product?->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td class="text-danger font-weight-bold">
                                {{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-3">
                <h4>Total Return Amount:
                    <span class="text-danger">
                        {{ number_format($return->total_return_amount, 2) }}
                    </span>
                </h4>
            </div>
        </div>
    </div>

@stop
