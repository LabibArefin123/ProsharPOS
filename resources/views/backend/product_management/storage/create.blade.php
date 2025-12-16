@extends('adminlte::page')

@section('title', 'Add Storage')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Storage</h3>
        <a href="{{ route('storages.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
                <form action="{{ route('storages.store') }}" method="POST" enctype="multipart/form-data"
                    data-confirm="create">
                    @csrf
                    @include('backend.product_management.storage.partial_create.part_1')
                    @include('backend.product_management.storage.partial_create.part_2')
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
            </div>


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
    {{-- Start of product load auto --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('product_id');

            productSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];

                document.getElementById('sku').value = selected.dataset.sku || '';
                document.getElementById('part_number').value = selected.dataset.part_number || '';
                document.getElementById('type_model').value = selected.dataset.type_model || '';
                document.getElementById('origin').value = selected.dataset.origin || '';
                document.getElementById('using_place').value = selected.dataset.using_place || '';
            });

            // Trigger change on page load (for edit page)
            if (productSelect.value) {
                productSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
    {{-- End of product load auto --}}
@endsection
