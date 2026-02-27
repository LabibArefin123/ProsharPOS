@extends('adminlte::page')

@section('title', 'Purchase Returns')

@section('content_header')
    <h3>Purchase Returns</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Supplier</th>
                        <th>Purchase Ref</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($returns as $return)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $return->supplier->name }}</td>
                            <td>{{ $return->purchase->reference_no }}</td>
                            <td>{{ $return->return_date }}</td>
                            <td>৳{{ number_format($return->total_amount, 2) }}</td>
                            <td>
                                <a href="{{ route('purchase_returns.show', $return->id) }}"
                                    class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('purchase_returns.edit', $return->id) }}"
                                    class="btn btn-sm btn-info">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
