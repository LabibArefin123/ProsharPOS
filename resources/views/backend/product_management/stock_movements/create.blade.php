@extends('adminlte::page')

@section('title', 'Add Stock Movement')

@section('content')

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Add Stock Movement</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('stock_movements.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-4">
                        <label>Product Storage</label>
                        <select name="storage_id" class="form-control" >

                            <option value="">Select Storage</option>

                            @foreach ($storages as $storage)
                                <option value="{{ $storage->id }}">
                                    {{ $storage->product->name ?? 'Product' }}
                                    (Stock: {{ $storage->stock_quantity }})
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Movement Type</label>
                        <select name="movement_type" class="form-control" >

                            <option value="IN">Stock IN</option>
                            <option value="OUT">Stock OUT</option>
                            <option value="ADJUSTMENT">Adjustment</option>

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" >
                    </div>

                    <div class="col-md-6 mt-3">
                        <label>Reference No</label>
                        <input type="text" name="reference_no" class="form-control">
                    </div>

                    <div class="col-md-6 mt-3">
                        <label>Note</label>
                        <input type="text" name="note" class="form-control">
                    </div>

                </div>

                <br>

                <button class="btn btn-success">
                    Save Movement
                </button>

            </form>

        </div>
    </div>

@endsection
