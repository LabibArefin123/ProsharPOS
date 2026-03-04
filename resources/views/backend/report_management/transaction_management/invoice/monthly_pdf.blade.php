<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Monthly Report</title>
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

        table,
        th,
        td {
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
    <h3>
        Invoice Monthly Report
    </h3>
    {{-- <h3>
        Invoice Monthly Report - {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
    </h3> --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice ID</th>
                <th>Invoice Date</th>
                <th>Customer</th>
                <th>Total Items</th>
                <th>Total Quantity</th>
                <th>Total Amount</th>
            </tr>
        </thead>

        <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $invoice->invoice_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d F Y') }}</td>
                    <td>{{ $invoice->customer?->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $invoice->invoiceItems->count() }}</td>
                    <td class="text-center">{{ $invoice->invoiceItems->sum('quantity') }}</td>
                    <td class="text-right">{{ number_format($invoice->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No invoices found</td>
                </tr>
            @endforelse
        </tbody>

        @if ($invoices->count())
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total</td>

                    <td class="text-center">
                        {{ $invoices->sum(fn($i) => $i->invoiceItems->count()) }}
                    </td>

                    <td class="text-center">
                        {{ $invoices->sum(fn($i) => $i->invoiceItems->sum('quantity')) }}
                    </td>

                    <td class="text-right">
                        {{ number_format($invoices->sum('total'), 2) }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
</body>

</html>
