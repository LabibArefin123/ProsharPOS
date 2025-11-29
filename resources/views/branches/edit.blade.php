@extends('adminlte::page')

@section('title', 'Edit Branch')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Branch</h1>
@endsection

@section('content')
    <div class="card p-4">
        {{-- Top error summary --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input:
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('branches.update', $branch->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Branch Name --}}
                <div class="form-group col-md-6">
                    <label for="name">Branch Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $branch->name) }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Balance --}}
                <div class="form-group col-md-6">
                    <label for="balance">Balance</label>
                    <input type="number" step="0.01" name="balance" id="balance"
                        class="form-control @error('balance') is-invalid @enderror"
                        value="{{ old('balance', $branch->balance) }}">
                    @error('balance')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- City --}}
                <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city"
                        class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $branch->city) }}">
                    @error('city')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Post Code --}}
                <div class="form-group col-md-6">
                    <label for="post_code">Post Code</label>
                    <input type="text" name="post_code" id="post_code"
                        class="form-control @error('post_code') is-invalid @enderror"
                        value="{{ old('post_code', $branch->post_code) }}">
                    @error('post_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="form-group col-md-6">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $branch->address) }}</textarea>
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Phone Number --}}
                <div class="form-group col-md-6">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number"
                        class="form-control @error('phone_number') is-invalid @enderror"
                        value="{{ old('phone_number', $branch->phone_number) }}">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Alternate Phone --}}
                <div class="form-group col-md-6">
                    <label for="alternate_number">Alternate Phone Number</label>
                    <input type="text" name="alternate_number" id="alternate_number"
                        class="form-control @error('alternate_number') is-invalid @enderror"
                        value="{{ old('alternate_number', $branch->alternate_number) }}">
                    @error('alternate_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $branch->email) }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Branch</button>
            <a href="{{ route('branches.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection
