@extends('adminlte::page')

@section('title', 'View Purchase Return')

@section('content_header')
    <h3>View Purchase Return - {{ $purchaseReturn->purchase->reference_no }}</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label><strong>Date</strong></label>
                    <input type="date" class="form-control" value="{{ $purchaseReturn->return_date }}" readonly>
                </div>

                <div class="col-md-4">
                    <label><strong>Reference</strong></label>
                    <input type="text" class="form-control" value="{{ $purchaseReturn->reference_no }}" readonly>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Return Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseReturn->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>৳{{ number_format($item->unit_price, 2) }}</td>
                            <td>৳{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <h5>Total: ৳{{ number_format($purchaseReturn->total_amount, 2) }}</h5>
            </div>

            <a href="{{ route('purchase_returns.index') }}" class="btn btn-secondary mt-3">Back</a>

        </div>
    </div>
@stop
