@role('manager|cashier')
    <li class="nav-item dropdown">
        <a class="nav-link position-relative" data-toggle="dropdown" href="#">
            <i class="fas fa-shopping-cart"></i>

            @if ($cartCount > 0)
                <span class="badge badge-danger navbar-badge">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">

            <span class="dropdown-header font-weight-bold">
                🛒 {{ $cartCount }} Pending Sales
            </span>

            <div class="dropdown-divider"></div>

            @forelse($cartInvoices ?? [] as $invoice)
                <div class="dropdown-item">

                    {{-- TOP --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>#{{ $invoice->invoice_id }}</strong>

                        <span class="badge badge-warning">
                            Draft
                        </span>
                    </div>

                    {{-- CUSTOMER --}}
                    <small class="text-muted">
                        {{ $invoice->customer->name ?? 'Walk-in Customer' }}
                    </small>

                    {{-- ITEMS --}}
                    <div class="mt-1 small text-muted">
                        {{ $invoice->invoiceItems->count() }} items
                    </div>

                    {{-- TOTAL --}}
                    <div class="d-flex justify-content-between mt-1">
                        <span>Total:</span>
                        <strong class="text-primary">
                            ৳{{ number_format($invoice->total, 2) }}
                        </strong>
                    </div>

                    {{-- ACTION --}}
                    <div class="mt-2 text-right">
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-xs btn-success">
                            Continue
                        </a>
                    </div>

                </div>

                <div class="dropdown-divider"></div>

            @empty
                <span class="dropdown-item text-center text-muted">
                    No pending sales
                </span>
            @endforelse

            {{-- FOOTER --}}
            <a href="{{ route('cart.index') }}" class="dropdown-item dropdown-footer text-center font-weight-bold">
                View All Cart
            </a>

        </div>
    </li>
@endrole
