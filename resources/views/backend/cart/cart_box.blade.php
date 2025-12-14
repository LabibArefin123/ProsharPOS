<div class="card shadow-sm" style="max-height: 400px; overflow-y: auto; min-width: 400px; width: 400px;">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="fas fa-shopping-cart"></i>
            Pending Items
        </h5>
    </div>

    <div class="card-body">

        @forelse($cartInvoices as $invoice)
            @foreach ($invoice->invoiceItems as $item)
                <div class="d-flex align-items-center border-bottom py-2">

                    <!-- Left: Image -->
                    <img src="{{ asset('images/default.jpg') }}" class="img-size-50 me-3 rounded">

                    <!-- Middle: Name + Qty -->
                    <div class="flex-fill">
                        <strong>{{ $item->product->name ?? 'Item' }}</strong><br>
                        <small class="text-muted">x{{ $item->quantity }}</small>
                    </div>

                    <!-- Right: Price -->
                    <div class="text-end text-success fw-bold">
                        ৳{{ number_format($item->price * $item->quantity, 2) }}
                    </div>

                </div>
            @endforeach
        @empty
            <p class="text-center text-muted mb-0">
                Cart is empty
            </p>
        @endforelse

    </div>
</div>
