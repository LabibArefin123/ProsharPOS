@extends('adminlte::page')

@section('title', 'Product Damages')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Product Damage List</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('product_damages.create') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-plus"></i> Create New
            </a>
        </div>
    </div>
@stop


@section('content')
    <div class="card shadow-sm border-left-danger">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="bg-danger text-white">
                    <tr>

                        <th>#</th>
                        <th>Product</th>
                        <th>Storage</th>
                        <th>Damage Qty</th>
                        <th>Solution</th>
                        <th>Image</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($damages as $damage)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $damage->product->name ?? '-' }}</td>
                            <td>
                                Rack: {{ $damage->storage->rack_number ?? '-' }}
                                <br>
                                Box: {{ $damage->storage->box_number ?? '-' }}
                            </td>
                            <td>{{ $damage->damage_qty }}</td>
                            <td>{{ $damage->damage_solution ?? '-' }}</td>
                            <td>
                                @if ($damage->damage_image)
                                    <img src="{{ asset($damage->damage_image) }}" width="50" class="img-thumbnail">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('product_damages.edit', $damage->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('product_damages.show', $damage->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('product_damages.destroy', $damage->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this damage record?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
