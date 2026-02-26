@extends('adminlte::page')

@section('title', 'Sales Return Flow Diagram')

@section('content_header')
    <h3 class="text-danger"><i class="fas fa-project-diagram"></i> Sales Return Flow Diagram</h3>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-body">

            @forelse($salesReturns as $return)
                <div class="flow-diagram mt-3 p-3 border rounded bg-light">
                    <h6>Return No: <strong>{{ $return->return_no }}</strong> | Invoice:
                        <strong>{{ $return->invoice->invoice_id ?? '-' }}</strong></h6>

                    <div class="diagram-container">
                        <div class="diagram-box">
                            Customer Bought: {{ $return->items->sum('quantity') }} Items<br>
                            Payment: ৳{{ number_format($return->invoice->paid_amount ?? 0, 2) }}
                        </div>
                        <div class="arrow">↓</div>
                        <div class="diagram-box">
                            Stock: -{{ $return->items->sum('quantity') }} (sold)<br>
                            Invoice: {{ $return->items->sum('quantity') }} Items
                        </div>
                        <div class="arrow">↓</div>
                        <div class="diagram-box">
                            Customer Returned: {{ $return->items->sum('quantity') }} Items<br>
                            Stock: +{{ $return->items->sum('quantity') }} (returned)<br>
                            Refund:
                            <span class="{{ $return->refund_method === 'cash' ? 'text-danger' : 'text-success' }}">
                                ৳{{ number_format($return->sub_total, 2) }}
                            </span><br>
                            @if ($return->refund_method === 'adjust_due')
                                Invoice Adjusted: -৳{{ number_format($return->sub_total, 2) }}
                            @endif
                        </div>
                        <div class="arrow">↓</div>
                        <div class="diagram-box">
                            Updated Payment & Invoice
                        </div>
                    </div>
                </div>
            @empty
                <p>No sales returns found.</p>
            @endforelse

        </div>
    </div>
@stop

@section('css')
    <style>
        .diagram-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .diagram-box {
            background-color: #f8f9fa;
            border: 2px solid #dc3545;
            border-radius: 10px;
            padding: 15px 20px;
            width: 300px;
            margin-bottom: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            font-weight: bold;
        }

        .arrow {
            font-size: 24px;
            margin: 5px 0;
            color: #dc3545;
        }
    </style>
@stop
