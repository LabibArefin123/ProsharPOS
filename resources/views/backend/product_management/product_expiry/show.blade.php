@extends('adminlte::page')

@section('title', 'Product Expiry Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Product Expiry Details</h3>
        <div>
            <a href="{{ route('product_expirys.index') }}" class="btn btn-secondary btn-sm">
                Back
            </a>
            <a href="{{ route('product_expirys.edit', $productExpiry->id) }}" class="btn btn-primary btn-sm">

                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
@stop


@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Product</th>
                    <td>{{ $productExpiry->product->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Storage Rack</th>
                    <td>{{ $productExpiry->storage->rack_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Expired Quantity</th>
                    <td>{{ $productExpiry->expired_qty }}</td>
                </tr>
                <tr>
                    <th>Solution</th>
                    <td>{{ $productExpiry->error_solution ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{{ $productExpiry->expiry_description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td>{{ $productExpiry->expiry_note ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Image</th>

                    <td>

                        @if ($productExpiry->expiry_image)
                            <img src="{{ asset($productExpiry->expiry_image) }}" width="150" class="img-thumbnail">
                        @else
                            No Image
                        @endif

                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $productExpiry->created_at->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
