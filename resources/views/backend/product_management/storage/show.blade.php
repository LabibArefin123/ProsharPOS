@extends('adminlte::page')

@section('title', 'Storage Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Storage Details</h3>
        <div>
            <a href="{{ route('storages.edit', $storage->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('storages.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop


@section('content')
    <div class="card card-primary shadow-sm">
        <div class="card-body">
            {{-- Start of Product Part --}}
            <div class="row ">
                <div class="col-md-4">
                    <strong>Product Name:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->product->name }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>SKU:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->product->sku }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Part Number</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->product->part_number }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Type / Model</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->product->type_model }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Origin</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->product->origin }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Using Place</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->product->using_place }}
                    </p>
                </div>
            </div>
            {{-- End of Product Part --}}

            {{-- Start of Storage Part --}}
            <div class="row ">
                <div class="col-md-4">
                    <strong>Rack :</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->rack_number }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Rack Label:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->rack_no }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Rack Location:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->rack_location }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Box :</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->box_number }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Box Label:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->box_no }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Box Location:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->box_location }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Alert Quantity:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->alert_quantity }}
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Stock Quantity:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->stock_quantity }}
                    </p>
                </div>
            </div>
            {{-- End of Storage Part --}}

            {{-- Start of Manufacture Part --}}
            <div class="row">
                <div class="col-md-4">
                    <strong>Manufacturer Name:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->manufacturer->name ?? 'N/A' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <strong>Country:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->manufacturer->country ?? 'N/A' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <strong>Location:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->manufacturer->location ?? 'N/A' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <strong>Email:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->manufacturer->email ?? 'N/A' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <strong>Phone:</strong>
                    <p class="form-control" style="white-space: normal; word-wrap: break-word;">
                        {{ $storage->manufacturer->phone ?? 'N/A' }}
                    </p>
                </div>
            </div>
            {{-- End of Manufacture Part --}}
        </div>
    </div>
@endsection
