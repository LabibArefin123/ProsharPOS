@extends('adminlte::page')

@section('title', 'Return Invoice')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Return Invoice</h1>
        <a href="{{ route('invoice-return.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0">
                Invoice #{{ $invoice->invoice_id }}
            </h5>
        </div>

        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-4">
                    <strong>Customer:</strong><br>
                    {{ $invoice->customer->name ?? 'N/A' }}
                </div>

                <div class="col-md-4">
                    <strong>Branch:</strong><br>
                    {{ $invoice->branch->name ?? 'N/A' }}
                </div>

                <div class="col-md-4">
                    <strong>Date:</strong><br>
                    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Invoice Items</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->invoiceItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>৳{{ number_format($item->price, 2) }}</td>
                                <td>৳{{ number_format($item->quantity * $item->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-3">
                <h4>Total: ৳{{ number_format($invoice->total, 2) }}</h4>
            </div>

            <hr>

            <form action="{{ route('invoice-return.store', $invoice->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Return Reason</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="Enter return reason (optional)"></textarea>
                </div>

                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="fas fa-undo"></i> Confirm Return
                </button>
            </form>

        </div>
    </div>

@endsection
