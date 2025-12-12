@extends('adminlte::page')

@section('title', 'Invoice Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Invoice Details</h3>

        <div>
            <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
@stop

@section('content')

    {{-- Customer & Branch Info --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Customer & Branch Details</h5>
        </div>

        <div class="card-body">

            {{-- Customer Section --}}
            <h6 class="fw-bold text-primary mb-3">Customer Information</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="fw-bold">Customer Name</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->customer->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Email</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->customer->email ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Phone</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->customer->phone_number ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Location</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->customer->location ?? 'N/A' }}</div>
                </div>
            </div>

            <hr class="my-4">

            {{-- Branch Section --}}
            <h6 class="fw-bold text-primary mb-3">Branch Information</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="fw-bold">Branch Name</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->branch->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Branch Code</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->branch->branch_code ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Phone</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->branch->phone ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Address</label>
                    <div class="border rounded p-2 bg-light">{{ $invoice->branch->address ?? 'N/A' }}</div>
                </div>
            </div>

        </div>
    </div>


    {{-- Invoice Info --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Invoice Information</h5>
        </div>

        <div class="card-body row g-3">
            <div class="col-md-4">
                <label class="fw-bold">Invoice ID</label>
                <div class="border rounded p-2 bg-light">{{ $invoice->invoice_id }}</div>
            </div>

            <div class="col-md-4">
                <label class="fw-bold">Invoice Date</label>
                <div class="border rounded p-2 bg-light">{{ $invoice->invoice_date }}</div>
            </div>

            <div class="col-md-4">
                <label class="fw-bold">Status</label>
                <div class="border rounded p-2 bg-light">
                    @if ($invoice->status == 1)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- Invoice Items --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Invoice Items</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        {{-- <th>Discount</th> --}}
                        <th>Total Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($invoice->invoiceItems ?? [] as $item)
                        @php
                            $image = $item->product->image
                                ? asset('uploads/images/product/' . $item->product->image)
                                : asset('images/default.jpg');
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <img src="{{ $image }}" class="img-fluid product-show-img"
                                    style="width:60px; height:60px; object-fit:cover; cursor:pointer;">
                            </td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>৳{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            {{-- <td>৳{{ number_format($item->discount, 2) }}</td> --}}
                            <td>৳{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals Section --}}
            <div class="mt-4 text-end">
                <p class="mb-1"><strong>Subtotal:</strong> ৳{{ number_format($invoice->sub_total, 2) }}</p>
                <p class="mb-1"><strong>Discount:</strong> ৳{{ number_format($invoice->discount_value, 2) }}</p>
                <h5><strong>Total:</strong> ৳{{ number_format($invoice->total, 2) }}</h5>
            </div>
        </div>
    </div>

    {{-- Modal for Zoom --}}
    <div class="modal fade" id="showImageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content text-center p-3">
                <img id="show-zoomed-image" class="img-fluid" style="max-height:600px;">
                <p id="show-zoomed-name" class="fw-bold mt-2"></p>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showImages = document.querySelectorAll(".product-show-img");

            showImages.forEach(img => {
                img.addEventListener("click", () => {
                    document.getElementById("show-zoomed-image").src = img.src;
                    const nameCell = img.closest("tr").querySelector("td:nth-child(2)");
                    document.getElementById("show-zoomed-name").innerText = nameCell ? nameCell
                        .innerText : '';
                    new bootstrap.Modal(document.getElementById("showImageModal")).show();
                });
            });
        });
    </script>


@stop
