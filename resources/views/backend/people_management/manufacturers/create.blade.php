@extends('adminlte::page')

@section('title', 'Add Manufacturer')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Manufacturer</h3>
        <a href="{{ route('manufacturers.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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

    <div class="card p-4">

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('manufacturers.store') }}" method="POST" data-confirm="create">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                    <input type="number" name="phone" id="phone"
                        class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="country ">Country <span class="text-danger">*</span></label>
                    <input type="text" name="country" id="country"
                        class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}">
                    @error('country')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="location ">Location <span class="text-danger">*</span></label>
                    <input type="text" name="location" id="location"
                        class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                    @error('location')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
@endsection
