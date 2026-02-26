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
                        @php
                            $invoiceData = $invoices->mapWithKeys(function ($invoice) {
                                return [
                                    $invoice->id => [
                                        'customer_id' => $invoice->customer_id,
                                        'branch_id' => $invoice->branch_id,
                                        'items' => $invoice->invoiceItems
                                            ->map(function ($item) {
                                                return [
                                                    'product_id' => $item->product_id,
                                                    'product_name' => optional($item->product)->name,
                                                    'quantity' => $item->quantity,
                                                    'price' => $item->price,
                                                ];
                                            })
                                            ->values(),
                                    ],
                                ];
                            });
                        @endphp
                        <select name="invoice_id" id="invoiceSelect" class="form-control" required>
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
                        <select name="customer_id" id="customerSelect" class="form-control" required>
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
                        <select name="branch_id" id="branchSelect" class="form-control" required>
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
                            <th>Item Name</th>
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
        const invoiceData = @json($invoiceData);
        const invoiceSelect = document.getElementById('invoiceSelect');
        const customerSelect = document.getElementById('customerSelect');
        const branchSelect = document.getElementById('branchSelect');
        const tableBody = document.querySelector('#returnTable tbody');

        invoiceSelect.addEventListener('change', function() {

            let invoiceId = this.value;

            items = [];
            tableBody.innerHTML = '';

            if (!invoiceId || !invoiceData[invoiceId]) {
                customerSelect.value = '';
                branchSelect.value = '';
                updateHiddenInput();
                return;
            }

            let data = invoiceData[invoiceId];

            // Auto set customer & branch
            customerSelect.value = data.customer_id ?? '';
            branchSelect.value = data.branch_id ?? '';

            data.items.forEach((item, index) => {

                let subtotal = item.quantity * item.price;

                let row = `
            <tr>
                <td>
                    ${item.product_name}
                </td>
                <td>
                    <input type="number" 
                        class="form-control quantity"
                        value="${item.quantity}"
                        min="1"
                        data-index="${index}">
                </td>
                <td>
                    <input type="number" 
                        class="form-control price"
                        value="${item.price}"
                        step="0.01"
                        data-index="${index}">
                </td>
                <td class="subtotal">
                    ${subtotal.toFixed(2)}
                </td>
                <td>
                    <button type="button" 
                        class="btn btn-sm btn-danger removeRow"
                        data-index="${index}">
                        X
                    </button>
                </td>
            </tr>
        `;

                tableBody.insertAdjacentHTML('beforeend', row);

                items.push({
                    product_id: item.product_id,
                    product_name: item.product_name,
                    quantity: item.quantity,
                    price: item.price
                });
            });

            updateHiddenInput();
        });


        // 🔥 Update quantity or price
        document.addEventListener('input', function(e) {

            if (!e.target.classList.contains('quantity') &&
                !e.target.classList.contains('price')) return;

            let index = e.target.getAttribute('data-index');
            let row = e.target.closest('tr');

            let qty = parseFloat(row.querySelector('.quantity').value) || 0;
            let price = parseFloat(row.querySelector('.price').value) || 0;

            row.querySelector('.subtotal').innerText = (qty * price).toFixed(2);

            items[index].quantity = qty;
            items[index].price = price;

            updateHiddenInput();
        });


        // 🔥 Remove row (with reindex fix)
        document.addEventListener('click', function(e) {

            if (!e.target.classList.contains('removeRow')) return;

            let index = e.target.getAttribute('data-index');

            items.splice(index, 1);
            e.target.closest('tr').remove();

            reIndexRows();
            updateHiddenInput();
        });


        // 🔥 Re-index rows after delete (IMPORTANT FIX)
        function reIndexRows() {
            document.querySelectorAll('#returnTable tbody tr').forEach((row, i) => {
                row.querySelector('.quantity').setAttribute('data-index', i);
                row.querySelector('.price').setAttribute('data-index', i);
                row.querySelector('.removeRow').setAttribute('data-index', i);
            });
        }


        // 🔥 Update hidden JSON + total
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
