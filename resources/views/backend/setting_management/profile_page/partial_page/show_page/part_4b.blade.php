 <div class="profile-transaction-card">

     @if ($transactions->isEmpty())

         <div class="profile-empty-state">
             <div class="profile-empty-icon">
                 <i class="fas fa-receipt"></i>
             </div>
             <h5>No Transactions Found</h5>
             <p>Your recent financial activities will appear here.</p>
         </div>
     @else
         <div class="table-responsive">
             <table class="table profile-transaction-table">

                 <thead>
                     <tr>
                         <th>SL</th>
                         <th>Description</th>
                         <th>Date & Time</th>
                         <th>Transaction Type</th>
                         <th class="text-right">Amount (BDT)</th>
                     </tr>
                 </thead>

                 <tbody>
                     @foreach ($transactions as $tx)
                         @php
                             switch ($tx->type) {
                                 case 'deposit':
                                     $sign = '+';
                                     $color = 'success';
                                     $label = 'Deposit';
                                     $icon = 'fa-arrow-down';
                                     break;

                                 case 'withdraw':
                                     $sign = '-';
                                     $color = 'danger';
                                     $label = 'Withdraw';
                                     $icon = 'fa-arrow-up';
                                     break;

                                 case 'payment':
                                     $sign = '-';
                                     $color = 'danger';
                                     $label = 'Customer Payment';
                                     $icon = 'fa-money-bill-wave';
                                     break;

                                 case 'purchase':
                                     $sign = '-';
                                     $color = 'warning';
                                     $label = 'Purchase';
                                     $icon = 'fa-shopping-cart';
                                     break;

                                 case 'purchase_return':
                                     $sign = '+';
                                     $color = 'primary';
                                     $label = 'Purchase Return';
                                     $icon = 'fa-undo';
                                     break;

                                 case 'supplier_payment':
                                     $sign = '-';
                                     $color = 'warning';
                                     $label = 'Supplier Payment';
                                     $icon = 'fa-truck';
                                     break;

                                 default:
                                     $sign = '';
                                     $color = 'secondary';
                                     $label = ucfirst(str_replace('_', ' ', $tx->type));
                                     $icon = 'fa-exchange-alt';
                             }
                         @endphp

                         <tr>
                             <td>
                                 <span class="profile-transaction-number">
                                     {{ $loop->iteration }}
                                 </span>
                             </td>

                             <td>
                                 <div class="profile-transaction-description">
                                     <strong>{{ $tx->description ?: 'Transaction' }}</strong>
                                 </div>
                             </td>

                             <td>
                                 <div class="profile-transaction-date">
                                     <strong>
                                         {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                                     </strong>
                                     <small>
                                         {{ \Carbon\Carbon::parse($tx->created_at)->format('h:i A') }}
                                     </small>
                                 </div>
                             </td>

                             <td>
                                 <span class="profile-transaction-badge badge-{{ $color }}">
                                     <i class="fas {{ $icon }}"></i>
                                     {{ $label }}
                                 </span>
                             </td>

                             <td class="text-right">
                                 <span class="profile-transaction-amount amount-{{ $color }}">
                                     {{ $sign }}৳{{ number_format($tx->amount, 2) }}
                                 </span>
                             </td>
                         </tr>
                     @endforeach
                 </tbody>

             </table>
         </div>

     @endif

 </div>
