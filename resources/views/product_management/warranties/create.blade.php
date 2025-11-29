@extends('adminlte::page')

@section('title', 'Add Warranty')

@section('content_header')
    <h1>Add New Warranty</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Warranty</h3>
        </div>
        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warranties.store') }}" method="POST">
                @csrf
                <div class="row">

                    {{-- Warranty Name --}}
                    <div class="form-group col-md-6">
                        <label for="name">Warranty Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                            placeholder="E.g. Service 1 Year">
                    </div>

                    {{-- Duration Type --}}
                    <div class="form-group col-md-6">
                        <label for="duration_type">Duration Type <span class="text-danger">*</span></label>
                        <select name="duration_type" id="duration_type" class="form-control">
                            <option value="">-- Select Duration Type --</option>
                            <option value="days" {{ old('duration_type') == 'days' ? 'selected' : '' }}>Days</option>
                            <option value="months" {{ old('duration_type') == 'months' ? 'selected' : '' }}>Months</option>
                            <option value="years" {{ old('duration_type') == 'years' ? 'selected' : '' }}>Years</option>
                        </select>
                    </div>

                    {{-- Day Count --}}
                    <div class="form-group col-md-6">
                        <label for="day_count">Day Count <span class="text-danger">*</span></label>
                        <input type="number" name="day_count" id="day_count" class="form-control"
                            value="{{ old('day_count') }}" placeholder="E.g. 365">
                    </div>

                    {{-- Description --}}
                    <div class="form-group col-md-12">
                        <label for="description">Description (Optional)</label>
                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Optional">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('warranties.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Create
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
