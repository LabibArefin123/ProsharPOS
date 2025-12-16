@extends('adminlte::page')

@section('title', 'Product List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Product List</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Part Number</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Type/Model</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Origin</th>
                        <th>Stock Quantity</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($product->image ?? 'images/default.jpg') }}" alt="{{ $product->name }}"
                                    class="img-thumbnail" style="width: 60px; height: 60px;">
                            </td>

                            <td>{{ $product->part_number }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku ?? "-" }}</td>
                            <td>{{ $product->type_model }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>{{ $product->origin }}</td>
                            <td>{{ $product->stock_quantity }}</td>
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
                            <td colspan="12" class="text-center text-muted py-3">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
