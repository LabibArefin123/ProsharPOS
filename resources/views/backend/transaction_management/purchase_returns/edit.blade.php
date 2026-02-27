@extends('adminlte::page')

@section('title', 'Edit Purchase Return')

@section('content_header')
    <h3>Edit Purchase Return - {{ $purchaseReturn->purchase->reference_no }}</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('purchase_returns.update', $purchaseReturn->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="return_date" class="form-control"
                            value="{{ $purchaseReturn->return_date }}">
                    </div>

                    <div class="col-md-4">
                        <label>Reference</label>
                        <input type="text" name="reference_no" class="form-control"
                            value="{{ $purchaseReturn->reference_no }}">
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Purchased Qty</th>
                            <th>Return Qty</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseReturn->purchase->items as $item)
                            @php
                                $returnedItem = $purchaseReturn->items->where('product_id', $item->product_id)->first();
                            @endphp

                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <input type="number" name="quantity[{{ $item->id }}]"
                                        value="{{ $returnedItem->quantity ?? 0 }}" max="{{ $item->quantity }}"
                                        min="0" class="form-control">
                                </td>
                                <td>৳{{ number_format($item->unit_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button class="btn btn-danger mt-3">
                    Update Return
                </button>

            </form>

        </div>
    </div>
@stop
