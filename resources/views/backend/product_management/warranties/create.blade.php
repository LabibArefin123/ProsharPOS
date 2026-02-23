@extends('adminlte::page')

@section('title', 'Add Warranty')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Warranty</h3>
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
    <div class="card shadow-lg">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warranties.store') }}" method="POST" data-confirm="create">
                @csrf
                <div class="row">

                    {{-- Warranty Name --}}
                    <div class="form-group col-md-6">
                        <label for="name">Warranty Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="E.g. Service 1 Year">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Duration Type --}}
                    <div class="form-group col-md-6">
                        <label for="duration_type">Duration Type <span class="text-danger">*</span></label>
                        <select name="duration_type" id="duration_type"
                            class="form-control @error('duration_type') is-invalid @enderror">
                            <option value="">-- Select Duration Type --</option>
                            <option value="days" {{ old('duration_type') == 'days' ? 'selected' : '' }}>Days</option>
                            <option value="months" {{ old('duration_type') == 'months' ? 'selected' : '' }}>Months
                            </option>
                            <option value="years" {{ old('duration_type') == 'years' ? 'selected' : '' }}>Years
                            </option>
                        </select>
                        @error('duration_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Day Count --}}
                    <div class="form-group col-md-6">
                        <label for="day_count">Day Count <span class="text-danger">*</span></label>
                        <input type="number" name="day_count" id="day_count"
                            class="form-control @error('day_count') is-invalid @enderror" value="{{ old('day_count') }}"
                            placeholder="E.g. 365">
                        @error('day_count')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group col-md-12">
                        <label for="description">Description (Optional)</label>
                        <textarea name="description" id="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror" placeholder="Optional">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
@stop
