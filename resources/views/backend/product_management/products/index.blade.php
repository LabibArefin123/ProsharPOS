@extends('adminlte::page')

@section('title', 'Product List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">

        <h1 class="m-0 text-dark">Product List</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>

        </div>

    </div>
@endsection

@section('content')

    {{-- Config for JS --}}
    <div id="bulkConfig" data-delete="{{ route('products.bulkDelete') }}" data-export="{{ route('products.bulkExport') }}"
        data-token="{{ csrf_token() }}" class="d-none">
    </div>

    <div class="card">
        <div class="card-body">

            <!-- Filter Form -->
            <form method="GET" action="{{ route('products.index') }}" class="row g-3 mb-3">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Product Name"
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="sku" class="form-control" placeholder="SKU"
                        value="{{ request('sku') }}">
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach (\App\Models\Category::orderBy('name', 'asc')->get() as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="brand_id" class="form-select">
                        <option value="">All Brands</option>
                        @foreach (\App\Models\Brand::orderBy('name', 'asc')->get() as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>

            <div id="bulkActionBar" class="card shadow-sm border-danger d-none mb-3">
                <div class="card-body d-flex align-items-center">
                    <!-- Left side -->
                    <div>
                        <strong>
                            <span id="selectedCount">0</span> products selected
                        </strong>
                    </div>

                    <!-- Right side buttons -->
                    <div class="d-flex gap-2 ms-auto">
                        <button id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </button>

                        <button id="bulkExportBtn" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export
                        </button>

                        <button id="bulkCancelBtn" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            @role('admin')
                                <th width="40">
                                    <input type="checkbox" id="selectAll">
                                </th>
                            @endrole
                            <th>#</th>
                            <th>Image</th>
                            <th>Part Number</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Type/Model</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Origin</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                @role('admin')
                                    <td>
                                        <input type="checkbox" class="productCheckbox" value="{{ $product->id }}">
                                    </td>
                                @endrole
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                        alt="{{ $product->name }}" class="img-thumbnail"
                                        style="width: 60px; height: 60px;">
                                </td>
                                <td>{{ $product->part_number }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku ?? '-' }}</td>
                                <td>{{ $product->type_model }}</td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                <td>{{ $product->origin }}</td>
                                <td>
                                    <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="triggerDeleteModal('{{ route('products.destroy', $product->id) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center text-muted py-3">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/backend/product_management/product/index_page/select_delete.js') }}"></script>
@endsection
