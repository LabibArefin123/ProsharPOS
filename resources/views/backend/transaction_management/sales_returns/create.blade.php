@extends('adminlte::page')

@section('title', 'Create Sales Return')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0 text-danger">
            <i class="fas fa-undo"></i> Create Sales Return
        </h3>

        <a href="{{ route('sales_returns.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Something went wrong:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales_returns.store') }}" method="POST" id="returnForm">
        @csrf

        <div class="card shadow mb-4">
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Invoice</label>
                        <select name="invoice_id" class="form-control" required>
                            <option value="">Select Invoice</option>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->id }}">
                                    {{ $invoice->invoice_id }} - {{ $invoice->customer?->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Customer</label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Branch</label>
                        <select name="branch_id" class="form-control" required>
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Return Date</label>
                        <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Refund Method</label>
                        <select name="refund_method" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="bkash">bKash</option>
                            <option value="nagad">Nagad</option>
                            <option value="adjust_due">Adjust Due</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="2"></textarea>
                    </div>

                </div>
            </div>
        </div>

        {{-- Product Cart Area --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-danger text-white">
                <strong>Return Products</strong>
            </div>

            <div class="card-body">
                <table class="table table-bordered" id="returnTable">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- JS will append rows --}}
                    </tbody>
                </table>

                <div class="text-right mt-3">
                    <h5>Total Return Amount:
                        <span class="text-danger" id="totalAmount">0.00</span>
                    </h5>
                </div>
            </div>
        </div>

        <input type="hidden" name="items" id="itemsInput">

        <div class="text-right">
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-save"></i> Save Return
            </button>
        </div>

    </form>

    <script>
        let items = [];

        function updateHiddenInput() {
            document.getElementById('itemsInput').value = JSON.stringify(items);

            let total = 0;
            items.forEach(item => {
                total += item.quantity * item.price;
            });

            document.getElementById('totalAmount').innerText = total.toFixed(2);
        }
    </script>

@stop
