@extends('adminlte::page')

@section('title', 'Newsletter Subscribers')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Newsletter Subscribers</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th>Email</th>
                            <th>Subscribed At</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>
                                    {{ $subscriber->subscribed_at ? \Carbon\Carbon::parse($subscriber->subscribed_at)->format('d M Y, h:i A') : '-' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No newsletter subscribers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
