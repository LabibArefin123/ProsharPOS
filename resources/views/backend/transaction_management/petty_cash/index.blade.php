@extends('adminlte::page')

@section('title', 'Petty Cash List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Petty Cash List</h3>
        <a href="{{ route('petty_cashes.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
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
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Reference No</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        {{-- <th>User</th> --}}
                        <th>Status</th>
                        <th width="140px">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($petty_cashes as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->reference_no ?? '-' }}</td>
                            <td class="text-capitalize">
                                <span class="badge bg-info">{{ $row->type }}</span>
                            </td>
                            <td>{{ $row->item_name }}</td>
                            <td>{{ number_format($row->amount, 2) }} BDT</td>
                            <td>
                                <span class="badge bg-secondary text-capitalize">{{ $row->payment_method ?? 'N/A' }}</span>
                            </td>
                            {{-- <td>{{ $row->usersData->name }}</td> --}}
                            <td>
                                <span
                                    class="badge 
                                        @if ($row->status == 'approved') bg-success 
                                        @elseif($row->status == 'pending') bg-warning 
                                        @else bg-danger @endif text-capitalize">
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('petty_cashes.show', $row->id) }}" class="btn btn-sm btn-info">View</a>

                                <a href="{{ route('petty_cashes.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('petty_cashes.destroy', $row->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
