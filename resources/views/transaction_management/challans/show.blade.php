@extends('adminlte::page')

@section('title', 'View Challan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Challan Details</h1>
        <a href="{{ route('challans.index') }}" class="btn btn-info btn-sm">
            <i class="fas fa-back-arrow"></i> Back to Challan
        </a>
    </div>
@endsection
@section('content')
    <div class="card shadow-lg rounded-lg">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <strong><i class="fas fa-hashtag"></i> Challan No:</strong> {{ $challan->challan_no }}
            </div>
           
        </div>

        <div class="card-body">
            <div class="row mb-4 align-items-start">
                {{-- Customer Info --}}
                <div class="col-md-4">
                    <h5 class="mb-3"><i class="fas fa-user"></i> Customer Info</h5>
                    <ul class="list-unstyled">
                        <li><strong>Name:</strong> {{ $challan->customer->name }}</li>
                        <li><strong>Email:</strong> {{ $challan->customer->email }}</li>
                        <li><strong>Phone:</strong> {{ $challan->customer->phone_number }}</li>
                        <li><strong>Location:</strong> {{ $challan->customer->location }}</li>
                    </ul>
                </div>

                {{-- Challan Info --}}
                <div class="col-md-4">
                    <h5 class="mb-3"><i class="fas fa-info-circle"></i> Challan Info</h5>
                    <ul class="list-unstyled">
                        <li><strong>Date:</strong> {{ $challan->challan_date }}</li>
                        <li><strong>Status:</strong> 
                            <span class="badge bg-{{ $challan->status === 'bill' ? 'success' : ($challan->status === 'unbill' ? 'warning' : 'danger') }}">
                                {{ ucfirst($challan->status) }}
                            </span>
                        </li>
                        <li><strong>Created By:</strong> {{ $challan->creator->name ?? 'N/A' }}</li>
                    </ul>
                </div>

                {{-- Product Photo --}}
                <div class="col-md-4 text-end">
                    <h5 class="mb-3"><i class="fas fa-image"></i> Product Photo</h5>
                    @if ($challan->product && $challan->product->image)
                        <img src="{{ asset('storage/' . $challan->product->image) }}" 
                             alt="Product Image"
                             class="img-thumbnail shadow-sm"
                             style="max-height: 100px; width: auto;">
                    @else
                        <span class="text-muted">No product photo available</span>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5><i class="fas fa-box-open"></i> Product Info</h5>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th width="35%">Product Name</th>
                            <td>{{ $challan->product->name }}</td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{ $challan->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Warranty</th>
                            <td>{{ $challan->warranty->name ?? 'None' }}</td>
                        </tr>
                        <tr>
                            <th>Serial No</th>
                            <td>{{ $challan->serial_no ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5><i class="fas fa-sticky-note"></i> Note</h5>
                    <div class="alert alert-info">
                        {{ $challan->note ?? 'No note provided.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
