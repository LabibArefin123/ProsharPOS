@extends('adminlte::page')

@section('title', 'Add Customer')

@section('content_header')
    <h1 class="m-0 text-dark">Add New Customer</h1>
@endsection

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

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control"
                        value="{{ old('phone_number') }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="location">Location <span class="text-danger">*</span></label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-auto">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Customer
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
