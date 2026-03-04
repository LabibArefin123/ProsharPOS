@extends('adminlte::page')

@section('title', 'Purchase Monthly Report')

@section('content')
    <h3 class="text-center mb-3">Purchase Monthly Report</h3>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #ddd;">
                <th>#</th>
                <th>Purchase Date</th>
                <th>Reference No</th>
                <th>Supplier</th>
                <th>Total Items</th>
                <th>Total Quantity</th>
                <th>Total Amount</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d F Y') }}</td>
                    <td>{{ $purchase->reference_no ?? 'N/A' }}</td>
                    <td>{{ $purchase->supplier?->name }}</td>
                    <td>{{ $purchase->items->count() }}</td>
                    <td>{{ $purchase->items->sum('quantity') }}</td>
                    <td>{{ number_format($purchase->total_amount, 2) }}</td>
                    <td>{{ $purchase->note }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight:bold;">
                <td colspan="4" class="text-end">Total</td>
                <td>{{ $purchases->sum(fn($p) => $p->items->count()) }}</td>
                <td>{{ $purchases->sum(fn($p) => $p->items->sum('quantity')) }}</td>
                <td>{{ number_format($purchases->sum('total_amount'), 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
@stop
