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
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>#</th>
                        <th>User</th>
                        <th>Balance Before</th>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $with->user->name }}</td>
                            <td>৳{{ number_format($with->bankBalance->balance, 2) }}</td>
                            <td class="text-danger">৳{{ number_format($with->amount, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $with->withdraw_method)) }}</td>
                            <td>{{ \Carbon\Carbon::parse($with->withdraw_date)->format('d M Y') }}</td>
                            <td>{{ $with->reference_no }}</td>
                            <td>{{ $with->note }}</td>
                            <td>
                                <a href="{{ route('bank_withdraws.show', $with->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>

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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No withdraws found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
