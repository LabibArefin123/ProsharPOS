 @extends('adminlte::page')

 @section('title', 'User Profile')

 @section('content_header')
     <div class="profile-page-heading">
         <div>
             <span class="profile-eyebrow">ACCOUNT MANAGEMENT</span>
             <h1 class="profile-page-title">My Profile</h1>
             <p class="profile-page-subtitle">
                 Manage your personal information and monitor your account activity.
             </p>
         </div>

         <a href="{{ route('user_profile_edit') }}" class="btn btn-warning profile-edit-btn" id="editProfileBtn">
             <i class="fas fa-user-edit"></i>
             <span>Edit Profile</span>
         </a>

     </div>
 @stop

 @section('content')

     <div class="container-fluid profile-page">

         {{-- Profile Overview --}}
         <div class="profile-hero">
             <div class="profile-hero-decoration"></div>

             <div class="profile-hero-content">

                 <div class="profile-avatar-wrapper">
                     <img src="{{ $user->adminlte_image() }}" class="profile-avatar" alt="{{ $user->name }}">

                     <span class="profile-avatar-status"></span>
                 </div>

                 <div class="profile-hero-details">
                     <span class="profile-welcome-label">
                         <i class="fas fa-shield-alt"></i>
                         PROSHARPOS ACCOUNT
                     </span>

                     <h2>{{ $user->name }}</h2>

                     <p>
                         <i class="fas fa-envelope"></i>
                         {{ $user->email }}
                     </p>

                     <div class="profile-hero-badges">
                         <span class="profile-role-badge">
                             <i class="fas fa-user-tag"></i>
                             {{ $user->getRoleNames()->first() ?? 'No Role Assigned' }}
                         </span>

                         <span class="profile-member-badge">
                             <i class="fas fa-check-circle"></i>
                             Account Information
                         </span>
                     </div>
                 </div>

             </div>
         </div>

         {{-- Account Information --}}
         <div class="profile-section-heading">
             <div>
                 <h4>Account Information</h4>
                 <p>Your personal and account details</p>
             </div>
         </div>

         <div class="row profile-info-row">

             <div class="col-xl-3 col-md-6 mb-3">
                 <div class="profile-info-card">
                     <div class="profile-info-icon icon-blue">
                         <i class="fas fa-user"></i>
                     </div>
                     <div class="profile-info-content">
                         <span>Username</span>
                         <h5>{{ $user->username ?? 'Not Provided' }}</h5>
                     </div>
                 </div>
             </div>

             <div class="col-xl-3 col-md-6 mb-3">
                 <div class="profile-info-card">
                     <div class="profile-info-icon icon-purple">
                         <i class="fas fa-envelope"></i>
                     </div>
                     <div class="profile-info-content">
                         <span>Email Address</span>
                         <h5>{{ $user->email }}</h5>
                     </div>
                 </div>
             </div>

             <div class="col-xl-3 col-md-6 mb-3">
                 <div class="profile-info-card">
                     <div class="profile-info-icon icon-green">
                         <i class="fas fa-phone-alt"></i>
                     </div>
                     <div class="profile-info-content">
                         <span>Phone Number</span>
                         <h5>{{ $user->phone ?? 'Not Provided' }}</h5>
                     </div>
                 </div>
             </div>

             <div class="col-xl-3 col-md-6 mb-3">
                 <div class="profile-info-card">
                     <div class="profile-info-icon icon-orange">
                         <i class="fas fa-user-shield"></i>
                     </div>
                     <div class="profile-info-content">
                         <span>Account Role</span>
                         <h5>{{ $user->getRoleNames()->first() ?? 'No Role Assigned' }}</h5>
                     </div>
                 </div>
             </div>

         </div>

         {{-- Financial Overview --}}
         @role('admin|manager|accountant')
             <div class="profile-section-heading">
                 <div>
                     <h4>Financial Overview</h4>
                     <p>Your current account balances</p>
                 </div>
             </div>

             <div class="row profile-balance-row">

                 <div class="col-md-6 mb-3">
                     <div class="profile-balance-card balance-bdt">
                         <div class="profile-balance-content">
                             <span>Bank Balance (BDT)</span>
                             <h3>৳{{ number_format($bankBalance->balance, 2) }}</h3>
                             <small>Bangladeshi Taka</small>
                         </div>
                         <div class="profile-balance-icon">
                             <i class="fas fa-wallet"></i>
                         </div>
                     </div>
                 </div>

                 <div class="col-md-6 mb-3">
                     <div class="profile-balance-card balance-usd">
                         <div class="profile-balance-content">
                             <span>Bank Balance (USD)</span>
                             <h3>${{ number_format($bankBalance->balance_in_dollars, 2) }}</h3>
                             <small>United States Dollar</small>
                         </div>
                         <div class="profile-balance-icon">
                             <i class="fas fa-dollar-sign"></i>
                         </div>
                     </div>
                 </div>

             </div>
         @endrole

         {{-- Recent Transactions --}}
         <div class="profile-section-heading profile-transaction-heading">
             <div>
                 <h4>Recent Transactions</h4>
                 <p>Your latest 5 financial activities</p>
             </div>

             <a href="{{ route('payments.history') }}" class="profile-view-all-btn">
                 View All Transactions
                 <i class="fas fa-arrow-right"></i>
             </a>
         </div>

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

         <div class="profile-footer">
             <i class="fas fa-lock"></i>
             Your account information is securely managed by ProsharPOS.
         </div>

     </div>

 @stop

 @section('css')
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_base.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_header.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_info.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_transactions.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_responsive.css') }}">
 @stop

 @section('js')
     <script>
         $(document).ready(function() {
             $('#editProfileBtn').on('click', function(e) {
                 e.preventDefault();

                 Swal.fire({
                     title: 'Edit Your Profile?',
                     text: 'Would you like to update your account information?',
                     icon: 'question',
                     showCancelButton: true,
                     confirmButtonText: 'Yes, Edit Profile',
                     cancelButtonText: 'Cancel',
                     confirmButtonColor: '#d69e36',
                     cancelButtonColor: '#64748b',
                     reverseButtons: true
                 }).then((result) => {
                     if (result.isConfirmed) {
                         window.location.href = "{{ route('user_profile_edit') }}";
                     }
                 });
             });
         });
     </script>
 @stop
