@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Product</h1>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Product Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        {{-- Product Name --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product/Parts Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}">
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="">Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Brand --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Brand</label>
                                <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                    <option value="">Select</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Origin --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Origin</label>
                                <input type="text" name="origin"
                                    class="form-control @error('origin') is-invalid @enderror"
                                    value="{{ old('origin', $product->origin) }}">
                                @error('origin')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{-- Unit --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                                    <option value="">Select</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }} ({{ $unit->short_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Part Number --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Part Number</label>
                                <input type="text" name="part_number"
                                    class="form-control @error('part_number') is-invalid @enderror"
                                    value="{{ old('part_number', $product->part_number) }}">
                                @error('part_number')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Type / Model --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Type / Model</label>
                                <input type="text" name="type_model"
                                    class="form-control @error('type_model') is-invalid @enderror"
                                    value="{{ old('type_model', $product->type_model) }}">
                                @error('type_model')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Rack --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rack</label>
                                <input type="text" name="rack_number"
                                    class="form-control @error('rack_number') is-invalid @enderror"
                                    value="{{ old('rack_number', $product->rack_number) }}">
                                @error('rack_number')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Box --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Box</label>
                                <input type="text" name="box_number"
                                    class="form-control @error('box_number') is-invalid @enderror"
                                    value="{{ old('box_number', $product->box_number) }}">
                                @error('box_number')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

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
                                            value="{{ old('maintenance_charge', $product->maintenance_charge) }}"></td>
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

                    <hr>

                    <div class="row">
                        {{-- Image --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Upload Image</label>
                                <input type="file" name="image" class="form-control-file">
                                @if ($product->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($product->image) }}" alt="Product Image" width="120"
                                            class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Using Place --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Using Place</label>
                                <input type="text" name="using_place" class="form-control"
                                    value="{{ old('using_place', $product->using_place) }}">
                            </div>
                        </div>

                        {{-- Warranty --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Warranty</label>
                                <select name="warranty_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($warranties as $warranty)
                                        <option value="{{ $warranty->id }}"
                                            {{ old('warranty_id', $product->warranty_id) == $warranty->id ? 'selected' : '' }}>
                                            {{ $warranty->name }} ({{ $warranty->day_count }}
                                            {{ $warranty->duration_type }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                </div> <!-- /.card-body -->

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('purchase_price').addEventListener('input', function() {
            let purchase = parseFloat(this.value) || 0;
            document.getElementById('handling_charge').value = (purchase * 0.05).toFixed(2);
            document.getElementById('maintenance_charge').value = (purchase * 0.03).toFixed(2);
        });
    </script>
@endsection
