@extends('adminlte::page')

@section('title', 'Division Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Division Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('divisions.edit', $division->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('divisions.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
<<<<<<< HEAD
        <div class="card">
=======
        <div class="card shadow-lg">
>>>>>>> cff8a03f022a6d12b5854c44afbd78917bd8cfc9
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Branch Name</strong></label>
                        <input type="text" class="form-control" value="{{ $division->branch->name }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Division Code</strong></label>
                        <input type="text" class="form-control" value="{{ $division->div_code }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Name</strong></label>
                        <input type="text" class="form-control" value="{{ $division->name }}" readonly>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Phone</strong></label>
                        <input type="text" class="form-control" value="{{ $division->phone }}" readonly>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Email</strong></label>
                        <input type="text" class="form-control" value="{{ $division->email ?? 'N/A' }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Address</strong></label>
                        <input type="text" class="form-control" value="{{ $division->address }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Contact Person</strong></label>
                        <input type="text" class="form-control" value="{{ $division->contact_person }}" readonly>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label><strong>Contact Phone</strong></label>
                        <input type="text" class="form-control" value="{{ $division->contact_phone }}" readonly>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
