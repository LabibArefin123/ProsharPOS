@extends('adminlte::page')

@section('title', 'Edit Customer')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Customer</h3>
        <a href="{{ route('customers.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('customers.update', $customer->id) }}" method="POST" data-confirm="edit">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter customer name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" value="{{ old('email', $customer->email) }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter customer email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone_number">Phone number <span class="text-danger">*</span></label>
                        <input type="number" name="phone_number" id="phone_number"
                            value="{{ old('phone_number', $customer->phone_number) }}"
                            class="form-control @error('phone_number') is-invalid @enderror"
                            placeholder="Enter customer name">
                        @error('phone_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="location">Location <span class="text-danger">*</span></label>
                        <input type="text" name="location" id="location"
                            value="{{ old('location', $customer->location) }}"
                            class="form-control @error('location') is-invalid @enderror"
                            placeholder="Enter customer location">
                        @error('location')
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
@stop
