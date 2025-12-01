@extends('adminlte::page')

@section('title', 'Add Product')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Product</h3>
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
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    data-confirm="create">
                    @csrf
                    <div class="row">

                        {{-- Product Name --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product/Parts Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter product name" value="{{ old('name') }}">
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
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                                    placeholder="Country of Origin" value="{{ old('origin') }}">
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
                                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
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
                                    value="{{ old('part_number') }}">
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
                                    value="{{ old('type_model') }}">
                                @error('type_model')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Rack Number (numeric only) --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rack</label>
                                <input type="number" name="rack_number"
                                    class="form-control @error('rack_number') is-invalid @enderror"
                                    value="{{ old('rack_number') }}">
                                @error('rack_number')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Box Number --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Box</label>
                                <input type="number" name="box_number"
                                    class="form-control @error('box_number') is-invalid @enderror"
                                    value="{{ old('box_number') }}">
                                @error('box_number')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Price & Stock Table --}}
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
                                    <td>
                                        <input type="number" name="purchase_price" id="purchase_price"
                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                            value="{{ old('purchase_price') }}">
                                        @error('purchase_price')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="handling_charge" id="handling_charge"
                                            class="form-control bg-light" readonly value="{{ old('handling_charge') }}">
                                    </td>
                                    <td>
                                        <input type="number" name="maintenance_charge" id="maintenance_charge"
                                            class="form-control bg-light" readonly
                                            value="{{ old('maintenance_charge') }}">
                                    </td>
                                    <td>
                                        <input type="number" name="sell_price" id="sell_price"
                                            class="form-control @error('sell_price') is-invalid @enderror"
                                            value="{{ old('sell_price') }}">
                                        @error('sell_price')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="stock_quantity"
                                            class="form-control @error('stock_quantity') is-invalid @enderror"
                                            value="{{ old('stock_quantity') }}">
                                        @error('stock_quantity')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="alert_quantity"
                                            class="form-control @error('alert_quantity') is-invalid @enderror"
                                            value="{{ old('alert_quantity') }}">
                                        @error('alert_quantity')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    {{-- File, Place, Warranty --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Upload Image</label>
                                <input type="file" name="image"
                                    class="form-control-file @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Using Place</label>
                                <input type="text" name="using_place"
                                    class="form-control @error('using_place') is-invalid @enderror"
                                    value="{{ old('using_place') }}">
                                @error('using_place')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Warranty</label>
                                <select name="warranty_id"
                                    class="form-control @error('warranty_id') is-invalid @enderror">
                                    <option value="">Select</option>
                                    @foreach ($warranties as $warranty)
                                        <option value="{{ $warranty->id }}"
                                            {{ old('warranty_id') == $warranty->id ? 'selected' : '' }}>
                                            {{ $warranty->name }} ({{ $warranty->day_count }}
                                            {{ $warranty->duration_type }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('warranty_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

            </div> <!-- /.card-body -->


        </div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">Save</button>
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
