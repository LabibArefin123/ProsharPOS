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
                @include('backend.product_management.products.partial_create.part_3')
                @include('backend.product_management.products.partial_create.part_4')
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
        </div>
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
