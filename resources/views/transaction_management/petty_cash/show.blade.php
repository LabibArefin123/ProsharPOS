@extends('adminlte::page')

@section('title', 'Petty Cash Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Petty Cash Details</h3>

        <a href="{{ route('petty_cashes.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="25%">Reference No</th>
                            <td>{{ $petty_cash->reference_no ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td class="text-capitalize">{{ $petty_cash->type }}</td>
                        </tr>
                        <tr>
                            <th>Reference Type</th>
                            <td>{{ $petty_cash->reference_type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Item Name</th>
                            <td>{{ $petty_cash->item_name }}</td>
                        </tr>
                        <tr>
                            <th>Amount (BDT)</th>
                            <td>{{ number_format($petty_cash->amount, 2) }} BDT</td>
                        </tr>
                        <tr>
                            <th>Amount (USD)</th>
                            <td>{{ $petty_cash->amount_in_dollar ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Exchange Rate</th>
                            <td>{{ $petty_cash->exchange_rate ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Currency</th>
                            <td>{{ $petty_cash->currency }}</td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td class="text-capitalize">{{ $petty_cash->payment_method ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bank Balance</th>
                            <td>
                                @if ($petty_cash->bankBalance)
                                    {{ $petty_cash->bankBalance->user->name }} — {{ $petty_cash->bankBalance->balance }}
                                    BDT
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $petty_cash->supplier->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $petty_cash->customer->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $petty_cash->category ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{ $petty_cash->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td class="text-capitalize">{{ $petty_cash->status }}</td>
                        </tr>
                        <tr>
                            <th>Attachment</th>
                            <td>
                                @if ($petty_cash->attachment)
                                    <a href="{{ asset('uploads/petty_cash/' . $petty_cash->attachment) }}" target="_blank">
                                        View File
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td>{{ $petty_cash->note ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <a href="{{ route('petty_cashes.edit', $petty_cash->id) }}" class="btn btn-primary">Edit</a>
                </div>

            </div>
        </div>
    </div>
@stop
