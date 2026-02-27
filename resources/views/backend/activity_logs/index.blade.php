@extends('adminlte::page')

@section('title', 'Admin Activity Logs')

@section('content_header')
    <h3 class="mb-0">Admin Audit Logs</h3>
@stop

@section('content')

    {{-- 🔥 STATISTICS CARDS --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>{{ $activities->total() }}</h4>
                    <p>Total Activities</p>
                </div>
                <div class="icon">
                    <i class="fas fa-history"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔎 FILTER SECTION --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <label>User</label>
                    <select name="user_id" class="form-control">
                        <option value="">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Model</label>
                    <select name="model" class="form-control">
                        <option value="">All</option>
                        <option value="App\Models\Payment" {{ request('model') == 'App\Models\Payment' ? 'selected' : '' }}>
                            Payment
                        </option>
                        <option value="App\Models\Invoice" {{ request('model') == 'App\Models\Invoice' ? 'selected' : '' }}>
                            Invoice
                        </option>
                        <option value="App\Models\BankDeposit" {{ request('model') == 'App\Models\BankDeposit' ? 'selected' : '' }}>
                            Bank Deposit
                        </option>
                        <option value="App\Models\BankWithdraw" {{ request('model') == 'App\Models\BankWithdraw' ? 'selected' : '' }}>
                            Bank Withdraw
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>From</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-2">
                    <label>To</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-2">
                    <label>Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Action..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-12 text-end mt-2">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('activity_log.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- 📋 TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Action</th>
                        <th class="text-center">Model</th>
                        <th>Details</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Time</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="text-center">{{ $activity->causer?->name ?? 'System' }}</td>

                            <td class="text-center">
                                @if ($activity->description == 'created')
                                    <span class="badge bg-success">Created</span>
                                @elseif($activity->description == 'updated')
                                    <span class="badge bg-warning">Updated</span>
                                @elseif($activity->description == 'deleted')
                                    <span class="badge bg-danger">Deleted</span>
                                @else
                                    <span class="badge bg-info">
                                        {{ ucfirst($activity->description) }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">{{ class_basename($activity->subject_type) }}</td>

                            <td style="max-width:250px;">
                                <div style="max-height:80px; overflow:auto; font-size:12px;">
                                    {{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}
                                </div>
                            </td>

                            <td class="text-center">{{ $activity->created_at->format('d M Y') }}</td>
                            <td class="text-center">{{ $activity->created_at->format('h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="mt-3">
                {{ $activities->links() }}
            </div>

        </div>
    </div>

@stop
