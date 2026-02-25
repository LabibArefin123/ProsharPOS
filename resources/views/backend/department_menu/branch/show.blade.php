@extends('adminlte::page')

@section('title', 'Branch Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Branch Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('branches.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">

                {{-- Branch Code --}}
                <div class="col-md-6 form-group mb-3">
                    <label><strong>Branch Code</strong></label>
                    <input type="text" class="form-control" value="{{ $branch->branch_code }}" readonly>
                </div>

                {{-- Name --}}
                <div class="col-md-6 form-group mb-3">
                    <label><strong>Name</strong></label>
                    <input type="text" class="form-control" value="{{ $branch->name }}" readonly>
                </div>

                {{-- Phone --}}
                <div class="col-md-6 form-group mb-3">
                    <label><strong>Phone</strong></label>
                    <input type="text" class="form-control" value="{{ $branch->phone }}" readonly>
                </div>

                {{-- Email --}}
                <div class="col-md-6 form-group mb-3">
                    <label><strong>Email</strong></label>
                    <input type="email" class="form-control" value="{{ $branch->email ?? 'N/A' }}" readonly>
                </div>

                {{-- Address --}}
                <div class="col-md-6 form-group mb-3">
                    <label><strong>Address</strong></label>
                    <input type="text" class="form-control" value="{{ $branch->address }}" readonly>
                </div>

                {{-- Contact Person --}}
                <div class="col-md-6 form-group mb-3">
                    <label><strong>Contact Person</strong></label>
                    <input type="text" class="form-control" value="{{ $branch->contact_person }}" readonly>
                </div>

                {{-- Contact Phone --}}
                <div class="col-md-6 form-group mb-3">
                    <label><strong>Contact Phone</strong></label>
                    <input type="text" class="form-control" value="{{ $branch->contact_phone }}" readonly>
                </div>

            </div>
        </div>
    </div>
@stop
