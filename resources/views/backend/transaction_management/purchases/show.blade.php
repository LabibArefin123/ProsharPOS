@extends('adminlte::page')

@section('title', 'View Purchase')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Purchase Details</h3>
        <div>
            <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Supplier:</strong><br>
                    {{ $purchase->supplier->name }}
                </div>

                <div class="col-md-6">
                    <strong>Purchase Date:</strong><br>
                    {{ $purchase->purchase_date }}
                </div>

                <div class="col-md-6">
                    <strong>Reference:</strong><br>
                    {{ $purchase->reference_no ?? '-' }}
                </div>

                <div class="col-md-12">
                    <strong>Note:</strong><br>
                    {{ $purchase->note ?? '-' }}
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Purchased Items</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Unit Price</th>
                        <th class="text-center">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">৳{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-center">৳{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-3">
                <h5><strong>Total Amount: ৳{{ number_format($purchase->total_amount, 2) }}</strong></h5>
            </div>

        </div>
    </div>
@stop
