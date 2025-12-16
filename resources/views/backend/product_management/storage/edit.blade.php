@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Product</h3>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                    data-confirm="edit">
                    @csrf
                    @method('PUT')

                    @include('backend.product_management.products.partial_edit.part_1')
                    @include('backend.product_management.products.partial_edit.part_2')

                    <hr>

                    {{-- Price & Stock --}}
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
                                    <td><input type="number" name="purchase_price" id="purchase_price" class="form-control"
                                            value="{{ old('purchase_price', $product->purchase_price) }}"></td>
                                    <td><input type="number" name="handling_charge" id="handling_charge"
                                            class="form-control bg-light" readonly
                                            value="{{ old('handling_charge', $product->handling_charge) }}"></td>
                                    <td><input type="number" name="maintenance_charge" id="maintenance_charge"
                                            class="form-control bg-light" readonly
                                            value="{{ old('maintenance_charge', $product->maintenance_charge) }}">
                                    </td>
                                    <td><input type="number" name="sell_price" id="sell_price" class="form-control"
                                            value="{{ old('sell_price', $product->sell_price) }}"></td>
                                    <td><input type="number" name="stock_quantity" class="form-control"
                                            value="{{ old('stock_quantity', $product->stock_quantity) }}"></td>
                                    <td><input type="number" name="alert_quantity" class="form-control"
                                            value="{{ old('alert_quantity', $product->alert_quantity) }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @include('backend.product_management.products.partial_edit.part_3')
                    @include('backend.product_management.products.partial_edit.part_4')
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Upload Image</label>
                            <input type="file" name="image" class="form-control-file">

                        </div>
                        <div class="form-group col-md-6">
                            <label>Current Image</label>
                            <div class="mt-2">
                                <img src="{{ asset($product->image ?: 'images/default.jpg') }}" alt="Product Image"
                                    width="120" class="img-thumbnail">
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('purchase_price').addEventListener('input', function() {
            let purchase = parseFloat(this.value) || 0;
            document.getElementById('handling_charge').value = (purchase * 0.05).toFixed(2);
            document.getElementById('maintenance_charge').value = (purchase * 0.03).toFixed(2);
        });
    </script>
@endsection
