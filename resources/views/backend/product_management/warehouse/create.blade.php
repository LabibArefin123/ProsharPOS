@extends('adminlte::page')

@section('title', 'Add Warehouse')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Warehouse</h3>

        <a href="{{ route('warehouses.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop


@section('content')

    <div class="card shadow-lg">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Warehouse Name --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Warehouse Name *</strong></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter Warehouse Name" required>
                    </div>

                    {{-- Warehouse Code --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Warehouse Code *</strong></label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code') }}" placeholder="Ex: WH-001" required>
                    </div>

                    {{-- Location --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Location</strong></label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}"
                            placeholder="Warehouse Location">
                    </div>

                    {{-- Manager --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Manager</strong></label>
                        <input type="text" name="manager" class="form-control" value="{{ old('manager') }}"
                            placeholder="Warehouse Manager Name">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Status</strong></label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') === 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Warehouse
                    </button>
                </div>

            </form>

        </div>
    </div>

@stop
