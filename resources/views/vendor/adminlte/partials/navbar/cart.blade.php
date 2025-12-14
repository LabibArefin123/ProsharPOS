<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-shopping-cart"></i>
        @if($cartCount > 0)
            <span class="badge badge-danger navbar-badge">
                {{ $cartCount }}
            </span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        <span class="dropdown-header">
            {{ $cartCount }} Pending Invoices
        </span>

        <div class="dropdown-divider"></div>

        @forelse($cartInvoices ?? [] as $invoice)
            @foreach($invoice->invoiceItems as $item)
                <a href="#" class="dropdown-item d-flex align-items-center">
                    <!-- Left: Image -->
                    <img src="{{ asset('images/default.jpg') }}"
                         class="img-size-50 mr-3 img-circle">

                    <!-- Middle -->
                    <div class="flex-fill">
                        <h6 class="mb-0">{{ $item->product->name ?? 'Item' }}</h6>
                        <small class="text-muted">
                            x{{ $item->quantity }}
                        </small>
                    </div>

                    <!-- Right -->
                    <span class="text-bold text-primary">
                        ৳{{ number_format($item->price * $item->quantity, 2) }}
                    </span>
                </a>
            @endforeach
            <div class="dropdown-divider"></div>
        @empty
            <span class="dropdown-item text-center text-muted">
                No items in cart
            </span>
        @endforelse

        <a href="{{ route('cart.index') }}"
           class="dropdown-item dropdown-footer">
            View Cart
        </a>
    </div>
</li>
