@extends('adminlte::page')

@section('title', 'Edit Storage')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Storage</h3>
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
                <form action="{{ route('storages.update', $storage->id) }}" method="POST" enctype="multipart/form-data"
                    data-confirm="edit">
                    @csrf
                    @method('PUT')
                    @include('backend.product_management.storage.partial_edit.part_1')
                    @include('backend.product_management.storage.partial_edit.part_2')
                    @include('backend.product_management.storage.partial_edit.part_3')
                    @include('backend.product_management.storage.partial_edit.part_4')
                    <div class="form-group">
                        <label>Upload Image</label>
                        <input type="file" name="image_path"
                            class="form-control-file @error('image_path') is-invalid @enderror">
                        @error('image_path')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
        </form>

    </div>
    {{-- Start of product load auto --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('product_id');

            function fillProduct() {
                const selected = select.options[select.selectedIndex];
                if (!selected || !selected.value) return;

                document.getElementById('sku').value = selected.dataset.sku || '';
                document.getElementById('part_number').value = selected.dataset.part_number || '';
                document.getElementById('type_model').value = selected.dataset.type_model || '';
                document.getElementById('origin').value = selected.dataset.origin || '';
                document.getElementById('using_place').value = selected.dataset.using_place || '';
            }

            // Change event
            select.addEventListener('change', fillProduct);

            // ✅ FORCE load for edit + old()
            window.requestAnimationFrame(fillProduct);
        });
    </script>
    {{-- End of product load auto --}}
    {{-- Start of supplier load auto --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('supplier_id');
            if (!select) return;

            function fillSupplier() {
                const selected = select.options[select.selectedIndex];
                if (!selected || !selected.value) return;

                document.getElementById('supplier_location').value = selected.dataset.location || '';
                document.getElementById('supplier_email').value = selected.dataset.email || '';
                document.getElementById('supplier_phone_number').value = selected.dataset.phone || '';
                document.getElementById('supplier_license_no').value = selected.dataset.license || '';
            }

            select.addEventListener('change', fillSupplier);

            // ✅ Force load for edit + old()
            window.requestAnimationFrame(fillSupplier);
        });
    </script>
    {{-- End of supplier load auto --}}
    {{-- Start of manufacturer load auto --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const manufacturerSelect = document.getElementById('manufacturer_id');

            function loadManufacturerData() {
                const selected = manufacturerSelect.querySelector('option:checked');
                if (!selected) return;

                document.getElementById('country').value = selected.dataset.country || '';
                document.getElementById('location').value = selected.dataset.location || '';
                document.getElementById('email').value = selected.dataset.email || '';
                document.getElementById('phone').value = selected.dataset.phone || '';
            }

            manufacturerSelect.addEventListener('change', loadManufacturerData);

            // ✅ Delay trigger so old()/edit value is applied
            setTimeout(loadManufacturerData, 0);
        });
    </script>
    {{-- End of manufacturer load auto --}}

@endsection
