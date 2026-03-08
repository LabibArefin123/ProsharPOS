@extends('adminlte::page')

@section('title', 'Edit Warehouse')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Warehouse</h3>

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


            <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Warehouse Name --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Warehouse Name *</strong></label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $warehouse->name) }}" required>
                    </div>

                    {{-- Warehouse Code --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Warehouse Code *</strong></label>
                        <input type="text" name="code" class="form-control"
                            value="{{ old('code', $warehouse->code) }}" required>
                    </div>

                    {{-- Location --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Location</strong></label>
                        <input type="text" name="location" class="form-control"
                            value="{{ old('location', $warehouse->location) }}">
                    </div>

                    {{-- Manager --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Manager</strong></label>
                        <input type="text" name="manager" class="form-control"
                            value="{{ old('manager', $warehouse->manager) }}">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Status</strong></label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $warehouse->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $warehouse->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Warehouse
                    </button>
                </div>

            </form>

        </div>
    </div>

@stop
