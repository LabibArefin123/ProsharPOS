<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Daily Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h3 {
            text-align: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #eaeaea;
            text-align: center;
            padding: 6px;
        }
        td {
            padding: 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h3>Purchase Daily Report</h3>

    <table>
        <thead>
            <tr>
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
            @forelse ($purchases as $purchase)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d F Y') }}</td>
                    <td>{{ $purchase->reference_no ?? 'N/A' }}</td>
                    <td>{{ $purchase->supplier?->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $purchase->items->count() }}</td>
                    <td class="text-center">{{ $purchase->items->sum('quantity') }}</td>
                    <td class="text-right">{{ number_format($purchase->total_amount, 2) }}</td>
                    <td>{{ $purchase->note ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No purchases found</td>
                </tr>
            @endforelse
        </tbody>

        @if($purchases->count())
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-center">
                        {{ $purchases->sum(fn($p) => $p->items->count()) }}
                    </td>
                    <td class="text-center">
                        {{ $purchases->sum(fn($p) => $p->items->sum('quantity')) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($purchases->sum('total_amount'), 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>

</body>
</html>