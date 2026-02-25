@extends('adminlte::page')

@section('title', 'Admin Activity Logs')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Admin Activity Logs</h3>
    </div>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped table-hover text-nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Model</th>
                        <th>Details</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $activity->causer?->name ?? 'System' }}
                            </td>

                            <td>
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

                            <td>
                                {{ class_basename($activity->subject_type) }}
                            </td>

                            <td style="max-width:250px;">
                                <div style="max-height:80px; overflow:auto; font-size:12px;">
                                    {{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}
                                </div>
                            </td>

                            <td>
                                {{ $activity->created_at->format('d M Y') }}
                            </td>

                            <td>
                                {{ $activity->created_at->format('h:i A') }}
                            </td>
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
