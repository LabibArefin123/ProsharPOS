@extends('adminlte::page')

@section('title', 'Edit Warranty')

@section('content_header')
    <h1>Edit Warranty</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Warranty</h3>
        </div>
        <div class="card-body">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warranties.update', $warranty->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Warranty Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $warranty->name) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="duration_type">Duration Type</label>
                        <select name="duration_type" id="duration_type" class="form-control">
                            <option value="days"
                                {{ old('duration_type', $warranty->duration_type) == 'days' ? 'selected' : '' }}>Days
                            </option>
                            <option value="months"
                                {{ old('duration_type', $warranty->duration_type) == 'months' ? 'selected' : '' }}>Months
                            </option>
                            <option value="years"
                                {{ old('duration_type', $warranty->duration_type) == 'years' ? 'selected' : '' }}>Years
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="day_count">Day Count</label>
                        <input type="number" name="day_count" id="day_count" class="form-control"
                            value="{{ old('day_count', $warranty->day_count) }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">Description (Optional)</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $warranty->description) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('warranties.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Warranty
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
