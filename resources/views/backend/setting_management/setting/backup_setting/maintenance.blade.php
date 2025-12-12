@extends('adminlte::page')

@section('title', 'Maintenance Mode')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Maintenance Mode</h3>
        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147
                                    4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                                    0 0 1 0-.708l5-5a.5.5 0 0 1
                                    .708.708L2.707 7.5H14.5A.5.5
                                    0 0 1 15 8z" />
            </svg>
            Go Back
        </a>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('settings.maintenance.update') }}" method="POST">
                        @csrf

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_maintenance" value="1"
                                {{ $user->is_maintenance ?? 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Enable Maintenance Mode</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Custom Message</label>
                            <textarea name="maintenance_message" class="form-control" rows="3" placeholder="Enter maintenance message">{{ $user->maintenance_message ?? '' }}</textarea>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">
                                Save
                            </button>
                        </div>

                    </form>

                    <small class="text-muted d-block mt-2">
                        When enabled, users will see the maintenance message when visiting the site.
                    </small>
                </div>
            </div>
        </div>
    </div>
@stop
