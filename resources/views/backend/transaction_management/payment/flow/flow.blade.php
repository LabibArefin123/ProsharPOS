 @if ($payment->payment_type === 'return' && $payment->invoice->salesReturns->isNotEmpty())
     <div class="flow-diagram mt-3 p-3 border rounded bg-light">
         <div class="diagram-header">
             <strong>View Return Flow &raquo;</strong>
         </div>
         <div class="diagram-content mt-2">
             @foreach ($payment->invoice->salesReturns as $return)
                 <h6>Return No: <strong>{{ $return->return_no }}</strong> | Invoice:
                     <strong>{{ $return->invoice->invoice_id }}</strong>
                 </h6>

                 <div class="diagram-container">
                     <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                         title="Bought: {{ $return->items->sum('quantity') }}<br>
                                                Payment: ৳{{ number_format($return->invoice->paid_amount ?? 0, 2) }}">
                         Customer Bought: {{ $return->items->sum('quantity') }} Items<br>
                         Payment: ৳{{ number_format($return->invoice->paid_amount ?? 0, 2) }}
                     </div>
                     <div class="arrow">↓</div>
                     <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                         title="Stock reduced by {{ $return->items->sum('quantity') }}<br>
                                                Invoice items: {{ $return->items->sum('quantity') }}">
                         Stock: -{{ $return->items->sum('quantity') }} (sold)<br>
                         Invoice: {{ $return->items->sum('quantity') }} Items
                     </div>
                     <div class="arrow">↓</div>
                     <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                         title="Returned: {{ $return->items->sum('quantity') }}<br>
                                                Refund: ৳{{ number_format($return->sub_total, 2) }}<br>
                                                @if ($return->refund_method === 'adjust_due')
Invoice Adjusted: -৳{{ number_format($return->sub_total, 2) }}
@endif">
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
                     <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                         title="Payment and Invoice updated">
                         Updated Payment & Invoice
                     </div>
                 </div>
             @endforeach
         </div>
     </div>
 @endif
