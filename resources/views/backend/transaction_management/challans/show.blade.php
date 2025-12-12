@extends('adminlte::page')

@section('title', 'Challan Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Challan Details</h1>

        <div>
            <a href="{{ route('challans.edit', $challan->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('challans.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">

        {{-- Main Challan Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Challan Information</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <label>Challan No:</label>
                        <p class="form-control">{{ $challan->challan_no }}</p>
                    </div>

                    <div class="col-md-6">
                        <label>Challan Date:</label>
                        <p class="form-control">{{ \Carbon\Carbon::parse($challan->challan_date)->format('d F Y') }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Valid Until:</label>
                        <p class="form-control">{{ \Carbon\Carbon::parse($challan->valid_until)->format('d F Y') }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Challan Reference:</label>
                        <p class="form-control">{{ $challan->challan_ref }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Challan Out Reference:</label>
                        <p class="form-control">{{ $challan->out_ref ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Challan Document:</label>

                        @php
                            $doc = $challan->challan_doc ?? null;
                            $path = public_path('uploads/files/challans/' . $doc);
                        @endphp

                        @if ($doc && file_exists($path))
                            <p class="form-control">
                                <a href="{{ asset('uploads/files/challans/' . $doc) }}" target="_blank"
                                    class="text-primary fw-bold">
                                    📄 View Document
                                </a>
                            </p>
                        @else
                            <p class="form-control text-danger fw-bold">No file found</p>
                        @endif
                    </div>


                    <div class="col-md-6">
                        <label>Supplier Name:</label>
                        <p class="form-control">{{ $challan->supplier?->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label>Supplier Email:</label>
                        <p class="form-control">{{ $challan->supplier?->email ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label>Supplier Phone:</label>
                        <p class="form-control">{{ $challan->supplier?->phone_number ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label>Supplier Location:</label>
                        <p class="form-control">{{ $challan->supplier?->location ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Branch Name:</label>
                        <p class="form-control">{{ $challan->branch?->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Branch Code:</label>
                        <p class="form-control">{{ $challan->branch?->branch_code ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Branch Phone:</label>
                        <p class="form-control">{{ $challan->branch?->phone ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label>Branch Location:</label>
                        <p class="form-control">{{ $challan->branch?->address ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Note:</label>
                        <p class="form-control">{{ $challan->note ?? 'N/A' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Items Section --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Challan Items</h5>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th class="text-center">Total Qty</th>
                            <th class="text-center">Bill Qty</th>
                            <th class="text-center">Unbill Qty</th>
                            <th class="text-center">FOC Qty</th>
                            <th class="text-center">Warranty</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($challan->citems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product?->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $item->challan_total }}</td>
                                <td class="text-center">{{ $item->challan_bill }}</td>
                                <td class="text-center">{{ $item->challan_unbill }}</td>
                                <td class="text-center">{{ $item->challan_foc }}</td>
                                <td class="text-center">{{ $item->warranty?->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>


        {{-- Summary Section --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Quantity Summary</h5>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-3">
                        <label>Total Qty:</label>
                        <p class="form-control">{{ $challan->citems->sum('challan_total') }}</p>
                    </div>

                    <div class="col-md-3">
                        <label>Bill Qty:</label>
                        <p class="form-control">{{ $challan->citems->sum('challan_bill') }}</p>
                    </div>

                    <div class="col-md-3">
                        <label>Unbill Qty:</label>
                        <p class="form-control">{{ $challan->citems->sum('challan_unbill') }}</p>
                    </div>

                    <div class="col-md-3">
                        <label>FOC Qty:</label>
                        <p class="form-control">{{ $challan->citems->sum('challan_foc') }}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
@stop
