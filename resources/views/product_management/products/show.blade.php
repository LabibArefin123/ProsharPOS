@extends('adminlte::page')

@section('title', 'Product Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Product Details</h3>
        <div>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop


@section('content')
    <div class="container-fluid">
        <div class="card card-primary shadow-sm">
            <div class="card-body">
                {{-- Top Info --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Product/Parts Name:</strong>
                        <p class="form-control">{{ $product->name }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Category:</strong>
                        <p class="form-control">{{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Brand:</strong>
                        <p class="form-control">{{ $product->brand->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Origin:</strong>
                        <p class="form-control">{{ $product->origin ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-2">
                        <strong>Unit:</strong>
                        <p class="form-control">{{ $product->unit->name ?? 'N/A' }} ({{ $product->unit->short_name ?? '' }})
                        </p>
                    </div>
                    <div class="col-md-2">
                        <strong>Part Number:</strong>
                        <p class="form-control">{{ $product->part_number ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>Type / Model:</strong>
                        <p class="form-control">{{ $product->type_model ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Rack:</strong>
                        <p class="form-control">{{ $product->rack_number ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Box:</strong>
                        <p class="form-control">{{ $product->box_number ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr>

                {{-- Price & Stock --}}
                <h5 class="mb-3">Price & Stock</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>Purchase Price</th>
                                <th>Handling Charge (%)</th>
                                <th>Office Maintenance (%)</th>
                                <th>Selling Price</th>
                                <th>Stock Quantity</th>
                                <th>Alert Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ number_format($product->purchase_price, 2) }}</td>
                                <td>{{ number_format($product->handling_charge, 2) }}</td>
                                <td>{{ number_format($product->maintenance_charge, 2) }}</td>
                                <td>{{ number_format($product->sell_price, 2) }}</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>{{ $product->alert_quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr>

                {{-- Extra Info --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div>
                            <strong>Status:</strong>
                            @if ($product->status == 1)
                                <p class="form-control">Active</p>
                            @else
                                <p class="form-control">Inactive</p>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-4">
                        <strong>Using Place:</strong>
                        <p class="form-control">{{ $product->using_place ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Warranty:</strong>
                        <p class="form-control">
                            @if ($product->warranty)
                                {{ $product->warranty->name }} ({{ $product->warranty->day_count }}
                                {{ $product->warranty->duration_type }})
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Image:</strong><br>
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}" alt="Product Image" width="150"
                            class="img-thumbnail mt-2">
                    @else
                        <p class="form-control">No Image</p>
                    @endif

                </div>
                <div class="mb-3">
                    <strong>Description:</strong>
                    <p class="form-control">{{ $product->description ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
