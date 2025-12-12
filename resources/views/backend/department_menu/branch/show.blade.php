@extends('adminlte::page')

<<<<<<< HEAD
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
=======
@section('title', 'Guard Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Guard Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('guards.edit', $guard->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('guards.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Go Back
>>>>>>> cff8a03f022a6d12b5854c44afbd78917bd8cfc9
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
<<<<<<< HEAD

                    {{-- Branch Code --}}
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Branch Code</strong></label>
                        <input type="text" class="form-control" value="{{ $branch->branch_code }}" readonly>
=======
                    {{-- Guard ID --}}
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Guard ID</strong></label>
                        <input type="text" class="form-control" value="{{ $guard->guard_id }}" readonly>
>>>>>>> cff8a03f022a6d12b5854c44afbd78917bd8cfc9
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Name</strong></label>
<<<<<<< HEAD
                        <input type="text" class="form-control" value="{{ $branch->name }}" readonly>
=======
                        <input type="text" class="form-control" value="{{ $guard->name }}" readonly>
>>>>>>> cff8a03f022a6d12b5854c44afbd78917bd8cfc9
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Phone</strong></label>
<<<<<<< HEAD
                        <input type="text" class="form-control" value="{{ $branch->phone }}" readonly>
=======
                        <input type="text" class="form-control" value="{{ $guard->phone }}" readonly>
>>>>>>> cff8a03f022a6d12b5854c44afbd78917bd8cfc9
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Email</strong></label>
<<<<<<< HEAD
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
=======
                        <input type="text" class="form-control" value="{{ $guard->email ?? 'N/A' }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Address</strong></label>
                        <input type="text" class="form-control" value="{{ $guard->address }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Contact Person</strong></label>
                        <input type="text" class="form-control" value="{{ $guard->contact_person }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Contact Phone</strong></label>
                        <input type="text" class="form-control" value="{{ $guard->contact_phone }}" readonly>
>>>>>>> cff8a03f022a6d12b5854c44afbd78917bd8cfc9
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
