@extends('adminlte::page')

@section('title', 'Department Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Department Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('departments.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group ">
                        <label><strong>Branch Name</strong></label>
                        <input type="text" class="form-control" value="{{ $department->branch->name }}" readonly>
                    </div>

                    <div class="col-md-6 form-group ">
                        <label><strong>Division Name</strong></label>
                        <input type="text" class="form-control" value="{{ $department->division->name }}" readonly>
                    </div>

                    <div class="col-md-6 form-group ">
                        <label><strong>Department Code</strong></label>
                        <input type="text" class="form-control" value="{{ $department->dept_code }}" readonly>
                    </div>

                    <div class="col-md-6 form-group ">
                        <label><strong>Name</strong></label>
                        <input type="text" class="form-control" value="{{ $department->name }}" readonly>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 form-group ">
                        <label><strong>Phone</strong></label>
                        <input type="text" class="form-control" value="{{ $department->phone }}" readonly>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 form-group ">
                        <label><strong>Email</strong></label>
                        <input type="text" class="form-control" value="{{ $department->email ?? 'N/A' }}" readonly>
                    </div>

                    <div class="col-md-6 form-group ">
                        <label><strong>Address</strong></label>
                        <input type="text" class="form-control" value="{{ $department->address }}" readonly>
                    </div>

                    <div class="col-md-6 form-group ">
                        <label><strong>Contact Person</strong></label>
                        <input type="text" class="form-control" value="{{ $department->contact_person }}" readonly>
                    </div>

                    <div class="col-md-6 form-group ">
                        <label><strong>Contact Phone</strong></label>
                        <input type="text" class="form-control" value="{{ $department->contact_phone }}" readonly>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
