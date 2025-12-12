@extends('adminlte::page')

@section('title', 'Add Branch')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Branch</h3>
        <a href="{{ route('branches.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('branches.store') }}" method="POST" data-confirm="create">
                    @csrf
                    <div class="row">
                        {{-- Guard ID --}}
                        <div class="col-md-6 form-group">
                            <label for="branch_code"><strong>Branch Code</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="branch_code" id="branch_code"
                                class="form-control @error('branch_code') is-invalid @enderror"
                                value="{{ old('branch_code') }}" placeholder="Enter Branch Code">
                            @error('branch_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="col-md-6 form-group">
                            <label for="name"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Enter branch name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6 form-group">
                            <label for="phone"><strong>Phone</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                placeholder="Enter phone number">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="email"><strong>Email</strong></label>
                            <input type="text" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="Enter email (optional)">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="address"><strong>Address</strong></label>
                            <input type="text" name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}"
                                placeholder="Enter address (optional)">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="contact_person"><strong>Contact Person</strong></label>
                            <input type="text" name="contact_person" id="contact_person"
                                class="form-control @error('contact_person') is-invalid @enderror"
                                value="{{ old('contact_person') }}">
                            @error('contact_person')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="contact_phone"><strong>Contact Phone</strong></label>
                            <input type="number" name="contact_phone" id="contact_phone"
                                class="form-control @error('contact_phone') is-invalid @enderror"
                                value="{{ old('contact_phone') }}" placeholder="">
                            @error('contact_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
