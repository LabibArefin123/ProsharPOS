@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>User Profile</h1>
        <a href="{{ route('user_profile_show') }}" class="btn btn-warning" id="editProfileBtn">
            <i class="fas fa-edit me-1"></i> Edit Profile
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Profile Card -->
        <div class="card shadow-sm">
            <div class="card-body row align-items-center">
                <!-- Profile Image -->
                <div class="col-md-3 text-center">
                    <img src="{{ $user->adminlte_image() }}" class="rounded-circle img-fluid shadow" alt="Profile Picture"
                        style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <!-- User Info -->
                <div class="col-md-9">
                    <h4 class="mb-3">{{ $user->name }}</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2"><strong>Username:</strong> {{ $user->username }}</div>
                        <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $user->email }}</div>
                        <div class="col-md-6 mb-2"><strong>Phone:</strong> {{ $user->phone ?? 'Not Provided' }}</div>
                        <div class="col-md-6 mb-2">
                            <strong>Role:</strong>
                            {{ $user->getRoleNames()->first() ?? 'No Role Assigned' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Current Bank Balance (BDT):</strong> ৳{{ number_format($bankBalance->balance, 2) }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Current Bank Balance (USD):</strong>
                            ${{ number_format($bankBalance->balance_in_dollars, 2) }}
                        </div>
                    </div>
                </div>

                {{-- Transaction History --}}
                <h5 class="mt-4 mb-2">Last 5 Transactions</h5>

                @if ($transactions->isEmpty())
                    <div class="text-center text-muted">No recent transactions</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>SL</th>
                                    <th>Description</th>
                                    <th>Date & Time</th>
                                    <th>Type</th>
                                    <th>Amount (BDT)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $tx)
                                    @php
                                        switch ($tx->type) {
                                            case 'deposit':
                                                $sign = '+';
                                                $color = 'text-success';
                                                $label = 'Deposit';
                                                break;
                                            case 'withdraw':
                                                $sign = '-';
                                                $color = 'text-danger';
                                                $label = 'Withdraw';
                                                break;
                                            case 'payment':
                                                $sign = '-';
                                                $color = 'text-danger';
                                                $label = 'Customer Payment';
                                                break;
                                            default:
                                                $sign = '';
                                                $color = 'text-dark';
                                                $label = ucfirst($tx->type);
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tx->description }}</td>
                                        <td>{{ \Carbon\Carbon::parse($tx->date)->format('d M Y h:i A') }}</td>
                                        <td class="{{ $color }}">{{ $label }}</td>
                                        <td class="{{ $color }}">{{ $sign }}
                                            ৳{{ number_format($tx->amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Edit Profile Confirmation
        document.getElementById('editProfileBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to edit your profile?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, edit it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('user_profile_edit') }}";
                }
            });
        });
    </script>
@endsection
