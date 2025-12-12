@extends('adminlte::page')

@section('title', 'Edit Division')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Division</h3>
        <a href="{{ route('divisions.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
                <form action="{{ route('divisions.update', $division->id) }}" method="POST" data-confirm="edit">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="branch_id" class="form-label">
                                <strong>Branch</strong> <span class="text-danger">*</span>
                            </label>
                            <select name="branch_id" id="branch_id"
                                class="form-control @error('branch_id') is-invalid @enderror">
                                <option value="">-- Select Branch --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ old('branch_id', $division->branch_id) == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="div_code"><strong>Division</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="div_code" id="div_code"
                                class="form-control @error('div_code') is-invalid @enderror"
                                value="{{ old('div_code', $division->div_code) }}">
                            @error('div_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="col-md-6 form-group">
                            <label for="name"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $division->name) }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6 form-group">
                            <label for="phone"><strong>Phone</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $division->phone) }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="email"><strong>Email</strong> <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $division->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="address"><strong>Address</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address', $division->address) }}">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="contact_person"><strong>Contact Person</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="contact_person" id="contact_person"
                                class="form-control @error('contact_person') is-invalid @enderror"
                                value="{{ old('contact_person', $division->contact_person) }}">
                            @error('contact_person')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="contact_phone"><strong>Contact Phone</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" id="contact_phone"
                                class="form-control @error('contact_phone') is-invalid @enderror"
                                value="{{ old('contact_phone', $division->contact_phone) }}">
                            @error('contact_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
