@extends('adminlte::page')

@section('title', 'Bank Balance List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Bank Balance List</h3>
        <a href="{{ route('bank_balances.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-plus" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            <th>SL</th>
                            <th>User</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Balance (BDT)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($balances as $balance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $balance->user->name ?? 'N/A' }}</td>
                                <td>{{ $balance->user->username ?? 'N/A' }}</td>
                                <td>{{ $balance->user->email ?? 'N/A' }}</td>
                                <td>৳{{ number_format($balance->balance, 2) }}</td>
                                <td>
                                    <a href="{{ route('bank_balances.show', $balance->id) }}"
                                        class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('bank_balances.edit', $balance->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('bank_balances.destroy', $balance->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure to delete this balance?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Bank Balances found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
