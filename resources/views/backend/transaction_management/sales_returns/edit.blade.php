@extends('adminlte::page')

@section('title', 'Edit Sales Return')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0 text-danger">
            <i class="fas fa-undo"></i> Edit Sales Return
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

    <form action="{{ route('sales_returns.update', $salesReturn->id) }}" method="POST" id="returnForm">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">

                    {{-- Invoice --}}
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

                            // Prepare sales return items for JS safely
                            $salesReturnItems = $salesReturn->items->map(function ($item) {
                                return [
                                    'product_id' => $item->product_id,
                                    'product_name' => optional($item->product)->name ?? 'N/A',
                                    'quantity' => $item->quantity,
                                    'price' => $item->price,
                                ];
                            });
                        @endphp
                        <select name="invoice_id" id="invoiceSelect" class="form-control" required>
                            <option value="">Select Invoice</option>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->id }}"
                                    {{ $salesReturn->invoice_id == $invoice->id ? 'selected' : '' }}>
                                    {{ $invoice->invoice_id }} - {{ $invoice->customer?->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Customer --}}
                    <div class="col-md-4 mb-3">
                        <label>Customer</label>
                        <select name="customer_id" id="customerSelect" class="form-control" required>
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $salesReturn->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Branch --}}
                    <div class="col-md-4 mb-3">
                        <label>Branch</label>
                        <select name="branch_id" id="branchSelect" class="form-control" required>
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ $salesReturn->branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Return Date --}}
                    <div class="col-md-4 mb-3">
                        <label>Return Date</label>
                        <input type="date" name="return_date" class="form-control"
                            value="{{ old('return_date', date('Y-m-d', strtotime($salesReturn->return_date))) }}" required>
                    </div>

                    {{-- Refund Method --}}
                    <div class="col-md-4 mb-3">
                        <label>Refund Method</label>
                        <select name="refund_method" class="form-control">
                            @php
                                $methods = ['cash', 'card', 'bkash', 'nagad', 'adjust_due'];
                            @endphp
                            @foreach ($methods as $method)
                                <option value="{{ $method }}"
                                    {{ $salesReturn->refund_method == $method ? 'selected' : '' }}>
                                    {{ ucfirst($method) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Note --}}
                    <div class="col-md-12 mb-3">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="2">{{ old('note', $salesReturn->note) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        {{-- Product Cart --}}
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
                        {{-- JS appends rows --}}
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
                <i class="fas fa-save"></i> Update Return
            </button>
        </div>
    </form>

    <script>
        let items = [];
        const invoiceData = @json($invoiceData);
        const salesReturnItems = @json($salesReturnItems);
        const invoiceSelect = document.getElementById('invoiceSelect');
        const customerSelect = document.getElementById('customerSelect');
        const branchSelect = document.getElementById('branchSelect');
        const tableBody = document.querySelector('#returnTable tbody');

        // 🔹 Load existing items
        window.addEventListener('DOMContentLoaded', () => {
            if (salesReturnItems.length > 0) {
                items = salesReturnItems.map((item, index) => {
                    let row = `
                <tr>
                    <td>${item.product_name}</td>
                    <td><input type="number" class="form-control quantity" value="${item.quantity}" min="1" data-index="${index}"></td>
                    <td><input type="number" class="form-control price" value="${item.price}" step="0.01" data-index="${index}"></td>
                    <td class="subtotal">${(item.quantity * item.price).toFixed(2)}</td>
                    <td><button type="button" class="btn btn-sm btn-danger removeRow" data-index="${index}">X</button></td>
                </tr>
                `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                    return item;
                });
                updateHiddenInput();
            }
        });

        // 🔹 Update hidden JSON + total
        function updateHiddenInput() {
            document.getElementById('itemsInput').value = JSON.stringify(items);
            let total = items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            document.getElementById('totalAmount').innerText = total.toFixed(2);
        }

        // 🔹 Invoice change reload
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
            customerSelect.value = data.customer_id ?? '';
            branchSelect.value = data.branch_id ?? '';

            data.items.forEach((item, index) => {
                let row = `
            <tr>
                <td>${item.product_name}</td>
                <td><input type="number" class="form-control quantity" value="${item.quantity}" min="1" data-index="${index}"></td>
                <td><input type="number" class="form-control price" value="${item.price}" step="0.01" data-index="${index}"></td>
                <td class="subtotal">${(item.quantity * item.price).toFixed(2)}</td>
                <td><button type="button" class="btn btn-sm btn-danger removeRow" data-index="${index}">X</button></td>
            </tr>
            `;
                tableBody.insertAdjacentHTML('beforeend', row);
                items.push(item);
            });

            updateHiddenInput();
        });

        // 🔹 Quantity / Price change
        document.addEventListener('input', function(e) {
            if (!e.target.classList.contains('quantity') && !e.target.classList.contains('price')) return;
            let index = e.target.getAttribute('data-index');
            let row = e.target.closest('tr');
            let qty = parseFloat(row.querySelector('.quantity').value) || 0;
            let price = parseFloat(row.querySelector('.price').value) || 0;
            row.querySelector('.subtotal').innerText = (qty * price).toFixed(2);
            items[index].quantity = qty;
            items[index].price = price;
            updateHiddenInput();
        });

        // 🔹 Remove row
        document.addEventListener('click', function(e) {
            if (!e.target.classList.contains('removeRow')) return;
            let index = e.target.getAttribute('data-index');
            items.splice(index, 1);
            e.target.closest('tr').remove();
            reIndexRows();
            updateHiddenInput();
        });

        function reIndexRows() {
            document.querySelectorAll('#returnTable tbody tr').forEach((row, i) => {
                row.querySelector('.quantity').setAttribute('data-index', i);
                row.querySelector('.price').setAttribute('data-index', i);
                row.querySelector('.removeRow').setAttribute('data-index', i);
            });
        }
    </script>
@stop
