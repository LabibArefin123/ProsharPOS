@extends('adminlte::page')

@section('title', 'Sales Return List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-danger">
            <i class="fas fa-undo"></i> Sales Return List
        </h1>

        <a href="{{ route('sales_returns.create') }}" class="btn btn-danger btn-sm">
            <i class="fas fa-plus"></i> Create New Return
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-left-danger">
        <div class="card-body table-responsive">

            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>#</th>
                        <th>Return No</th>
                        <th>Invoice No</th>
                        <th>Customer</th>
                        <th>Branch</th>
                        <th>Return Date</th>
                        <th>Total Amount</th>
                        <th>Refund Method</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($returns as $return)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="badge badge-danger">
                                    {{ $return->return_no }}
                                </span>
                            </td>

                            <td>
                                {{ $return->invoice?->invoice_id ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $return->customer?->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $return->branch?->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($return->return_date)->format('d F Y') }}
                            </td>

                            <td class="text-danger font-weight-bold">
                                {{ number_format($return->total_return_amount, 2) }}
                            </td>

                            <td>
                                <span class="badge badge-secondary">
                                    {{ ucfirst($return->refund_method) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-success">
                                    {{ $return->status ?? 'Completed' }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('sales_returns.edit', $return->id) }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('sales_returns.show', $return->id) }}"
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="triggerDeleteModal('{{ route('sales_returns.destroy', $return->id) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                No sales returns found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
@stop