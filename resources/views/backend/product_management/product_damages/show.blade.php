@extends('adminlte::page')

@section('title', 'Product Damage Details')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <h3>Product Damage Details</h3>

        <div>

            <a href="{{ route('product_damages.index') }}" class="btn btn-sm btn-secondary">
                Back
            </a>

            <a href="{{ route('product_damages.edit', $damage->id) }}" class="btn btn-sm btn-primary">
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
                    <td>{{ $damage->product->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Storage Rack</th>
                    <td>{{ $damage->storage->rack_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Storage Box</th>
                    <td>{{ $damage->storage->box_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Damage Quantity</th>
                    <td>{{ $damage->damage_qty }}</td>
                </tr>
                <tr>
                    <th>Damage Solution</th>
                    <td>{{ $damage->damage_solution ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $damage->damage_description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td>{{ $damage->damage_note ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Damage Image</th>
                    <td>
                        @if ($damage->damage_image)
                            <img src="{{ asset($damage->damage_image) }}" width="150" class="img-thumbnail">
                        @else
                            No Image
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $damage->created_at->format('d M Y') }}</td>
                </tr>

            </table>
        </div>
    </div>
@stop
