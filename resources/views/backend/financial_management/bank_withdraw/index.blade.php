@extends('adminlte::page')

@section('title', 'Bank Withdraw List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Bank Withdraw List</h3>
        <a href="{{ route('bank_withdraws.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i> Add Withdraw
        </a>
    </div>
@stop

@section('content')
    {{-- Config for JS --}}
    <div id="bulkConfig" data-delete="{{ route('bank_withdraws.bulkDelete') }}"
        data-export="{{ route('products.bulkExport') }}" data-token="{{ csrf_token() }}" class="d-none">
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <div id="bulkActionBar" class="card shadow-sm border-danger d-none mb-3">
                <div class="card-body d-flex align-items-center">
                    <!-- Left side -->
                    <div>
                        <strong>
                            <span id="selectedCount">0</span> bank withdraws selected
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
                <thead class="table-dark">
                    <tr class="text-center">
                        @role('admin')
                            <th width="40">
                                <input type="checkbox" id="selectAll">
                            </th>
                        @endrole
                        <th>#</th>
                        <th>User</th>
                        <th>Withdraw Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Reference</th>
                        <th>Note</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($withdraws as $with)
                        <tr class="text-center">
                            @role('admin')
                                <td>
                                    <input type="checkbox" class="depositCheckbox" value="{{ $with->id }}">
                                </td>
                            @endrole
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $with->user->name }}</td>
                            <td class="text-danger">৳{{ number_format($with->amount, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $with->withdraw_method)) }}</td>
                            <td>{{ \Carbon\Carbon::parse($with->withdraw_date)->format('d M Y') }}</td>
                            <td>{{ $with->reference_no }}</td>
                            <td>{{ $with->note }}</td>
                            <td>
                                <a href="{{ route('bank_withdraws.show', $with->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @role('admin')
                                    <a href="{{ route('bank_withdraws.edit', $with->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('bank_withdraws.destroy', $with->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            @endrole
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No withdraws found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('js/backend/financial_management/bank_withdraw/index_page/select_delete.js') }}"></script>
@stop
