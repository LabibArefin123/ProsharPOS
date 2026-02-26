@extends('adminlte::page')

@section('title', 'Card Payments')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Card Payment List</h3>
        <a href="{{ route('bank_cards.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
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
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Ref</th>
                        <th>Bank</th>
                        <th>Card Type</th>
                        <th>Card Holder</th>
                        <th>Last 4</th>
                        <th>Amount (৳)</th>
                        <th>Amount ($)</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cards as $card)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $card->reference_no }}</td>
                            <td>{{ $card->bankBalance->name ?? 'N/A' }}</td>
                            <td>{{ $card->card_type }}</td>
                            <td>{{ $card->card_holder_name }}</td>
                            <td>{{ $card->card_last_four }}</td>
                            <td>৳{{ number_format($card->amount, 2) }}</td>
                            <td>${{ number_format($card->amount_in_dollar ?? 0, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($card->payment_date)->format('d F Y') }}</td>
                            <td>
                                <a href="{{ route('bank_cards.edit', $card->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('bank_cards.show', $card->id) }}" class="btn btn-sm btn-primary">Show</a>
                                <form action="{{ route('bank_cards.destroy', $card->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No card payments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
