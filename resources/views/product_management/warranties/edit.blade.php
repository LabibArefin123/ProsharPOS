@extends('adminlte::page')

@section('title', 'Edit Warranty')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Warranty</h3>
        <a href="{{ route('warranties.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop


@section('content')
    <div class="container">
        <div class="card shadow-lg">
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

                <form action="{{ route('warranties.update', $warranty->id) }}" method="POST" data-confirm="edit">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Warranty Name</label> <span class="text-danger">*</span>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $warranty->name) }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="duration_type">Duration Type</label> <span class="text-danger">*</span>
                            <select name="duration_type" id="duration_type" class="form-control">
                                <option value="days"
                                    {{ old('duration_type', $warranty->duration_type) == 'days' ? 'selected' : '' }}>Days
                                </option>
                                <option value="months"
                                    {{ old('duration_type', $warranty->duration_type) == 'months' ? 'selected' : '' }}>
                                    Months
                                </option>
                                <option value="years"
                                    {{ old('duration_type', $warranty->duration_type) == 'years' ? 'selected' : '' }}>Years
                                </option>
                            </select>
                            @error('duration_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="day_count">Day Count</label> <span class="text-danger">*</span>
                            <input type="number" name="day_count" id="day_count" class="form-control"
                                value="{{ old('day_count', $warranty->day_count) }}">
                            @error('day_count')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description (Optional)</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $warranty->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
