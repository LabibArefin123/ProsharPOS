@extends('adminlte::page')

@section('title', 'Bank Deposit List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Bank Deposit List</h3>

        <a href="{{ route('bank_deposits.create') }}" class="btn btn-success btn-sm d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New
        </a>
    </div>
@stop

@section('content')
    {{-- Config for JS --}}
    <div id="bulkConfig" data-delete="{{ route('bank_deposits.bulkDelete') }}" data-export="{{ route('products.bulkExport') }}"
        data-token="{{ csrf_token() }}" class="d-none">
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <div id="bulkActionBar" class="card shadow-sm border-danger d-none mb-3">
                <div class="card-body d-flex align-items-center">
                    <!-- Left side -->
                    <div>
                        <strong>
                            <span id="selectedCount">0</span> bank deposits selected
                        </strong>
                    </div>

                    <!-- Right side buttons -->
                    <div class="d-flex gap-2 ms-auto">
                        <button id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </button>

                        <button id="bulkExportBtn" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export
                        </button>

                        <button id="bulkCancelBtn" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>SL</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Bank Balance</th>
                        <th>Bank Balance (in Dollar)</th>
                        <th>Amount (BDT)</th>
                        <th>Amount (USD)</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $deposit)
                        <tr>
                            <td>
                                <input type="checkbox" class="depositCheckbox" value="{{ $deposit->id }}">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $deposit->user->name }}</td>
                            <td>{{ $deposit->user->email }}</td>
                            <td>{{ number_format($deposit->adjusted_balance, 2) }} Tk</td>
                            <td>{{ '$' . $deposit->bankBalance->balance_in_dollars ?? '0.00' }}</td>
                            <td>৳{{ number_format($deposit->amount, 2) }}</td>
                            <td>${{ number_format($deposit->amount_in_dollar, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $deposit->deposit_method)) }}</td>
                            <td>{{ $deposit->reference_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($deposit->deposit_date)->format('d F Y') }}</td>
                            <td>
                                <a href="{{ route('bank_deposits.show', $deposit->id) }}"
                                    class="btn btn-info btn-sm">View</a>
                                @role('admin')
                                    <a href="{{ route('bank_deposits.edit', $deposit->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>

                                    <form action="{{ route('bank_deposits.destroy', $deposit->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                @endrole

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No deposits found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
    <script src="{{ asset('js/backend/financial_management/bank_deposit/index_page/select_delete.js') }}"></script>
@stop
