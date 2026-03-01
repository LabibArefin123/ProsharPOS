<!DOCTYPE html>
<html>

<head>
    <title>Challan Monthly Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <h2>Challan Monthly Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Challan No</th>
                <th>Date</th>
                <th>Supplier</th>
                <th>Branch</th>
                <th>Total</th>
                <th>Bill</th>
                <th>Unbill</th>
                <th>FOC</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($challans as $challan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $challan->challan_no }}</td>
                    <td>{{ \Carbon\Carbon::parse($challan->challan_date)->format('d F Y') }}</td>
                    <td>{{ $challan->supplier?->name }}</td>
                    <td>{{ $challan->branch?->name }}</td>
                    <td>{{ $challan->citems->sum('challan_total') }}</td>
                    <td>{{ $challan->citems->sum('challan_bill') }}</td>
                    <td>{{ $challan->citems->sum('challan_unbill') }}</td>
                    <td>{{ $challan->citems->sum('challan_foc') }}</td>
                    <td>{{ $challan->challan_type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
