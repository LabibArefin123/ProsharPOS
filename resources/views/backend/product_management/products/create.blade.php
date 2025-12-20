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
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" data-confirm="create">
                @csrf
                @include('backend.product_management.products.partial_create.part_1')
                @include('backend.product_management.products.partial_create.part_2')

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
                                        class="form-control bg-light" readonly value="{{ old('maintenance_charge') }}">
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
                @include('backend.product_management.products.partial_create.part_3')
                @include('backend.product_management.products.partial_create.part_4')

                {{-- Description --}}
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror">
                    @error('image')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Status --}}


        </div> <!-- /.card-body -->


    </div>
    <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
    </form>




    <script>
        document.getElementById('purchase_price').addEventListener('input', function() {
            let purchase = parseFloat(this.value) || 0;
            document.getElementById('handling_charge').value = (purchase * 0.05).toFixed(2);
            document.getElementById('maintenance_charge').value = (purchase * 0.03).toFixed(2);
        });
    </script>
@endsection
