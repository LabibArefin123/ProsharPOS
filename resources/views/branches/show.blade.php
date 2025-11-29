@extends('adminlte::page')

@section('title', 'Branch Details')

@section('content_header')
    <h1 class="m-0 text-dark">Branch Details</h1>
@endsection

@section('content')
    <div class="card p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <strong>Branch Name:</strong> {{ $branch->name }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Balance:</strong> ৳{{ number_format($branch->balance, 2) }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>City:</strong> {{ $branch->city ?? '-' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Post Code:</strong> {{ $branch->post_code ?? '-' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Address:</strong> {{ $branch->address ?? '-' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Phone Number:</strong> {{ $branch->phone_number ?? '-' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Alternate Number:</strong> {{ $branch->alternate_number ?? '-' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Email:</strong> {{ $branch->email ?? '-' }}
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('branches.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection
