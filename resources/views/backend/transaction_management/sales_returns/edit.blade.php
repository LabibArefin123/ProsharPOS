@extends('adminlte::page')

@section('title', 'Edit Sales Return')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0 text-danger">
            <i class="fas fa-undo"></i> Edit Sales Return
        </h3>

        <a href="{{ route('sales_returns.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Something went wrong:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales_returns.update', $salesReturn->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Invoice</label>
                        <input type="text" class="form-control" value="{{ $salesReturn->invoice?->invoice_id }}"
                            disabled>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Customer</label>
                        <input type="text" class="form-control" value="{{ $salesReturn->customer?->name }}" disabled>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Branch</label>
                        <input type="text" class="form-control" value="{{ $salesReturn->branch?->name }}" disabled>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Return Date</label>
                        <input type="date" name="return_date" class="form-control"
                            value="{{ $salesReturn->return_date }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Refund Method</label>
                        <select name="refund_method" class="form-control">
                            <option value="cash" {{ $salesReturn->refund_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ $salesReturn->refund_method == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="bkash" {{ $salesReturn->refund_method == 'bkash' ? 'selected' : '' }}>bKash</option>
                            <option value="nagad" {{ $salesReturn->refund_method == 'nagad' ? 'selected' : '' }}>Nagad</option>
                            <option value="adjust_due" {{ $salesReturn->refund_method == 'adjust_due' ? 'selected' : '' }}>Adjust
                                Due</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="2">{{ $salesReturn->note }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="card shadow mb-4">
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
                        @foreach ($salesReturn->items as $item)
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
                    <h5>Total Return:
                        <span class="text-danger">
                            {{ number_format($salesReturn->total_return_amount, 2) }}
                        </span>
                    </h5>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-save"></i> Update Return
            </button>
        </div>

    </form>

@stop
