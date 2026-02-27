@extends('adminlte::page')

@section('title', 'Return Purchase')

@section('content_header')
    <h3>Return Purchase - {{ $purchase->reference_no }}</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('purchase_returns.storeP', $purchase->id) }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Reference</label>
                        <input type="text" name="reference_no" class="form-control">
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
                        @foreach ($purchase->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <input type="number" name="quantity[{{ $item->id }}]" max="{{ $item->quantity }}"
                                        min="0" class="form-control">
                                </td>
                                <td>৳{{ number_format($item->unit_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button class="btn btn-danger mt-3">Submit Return</button>

            </form>

        </div>
    </div>
@stop
