{{-- LOGIN BRANDING PANEL --}}
<div class="col-lg-6 login-brand-panel">
    <div class="brand-panel-content">
        {{-- Logo and Brand --}}
        <div class="brand-header">
            <div class="brand-logo-wrapper">
                <img src="{{ asset('uploads/images/logor.png') }}"
                     alt="ProsharPOS Logo"
                     class="brand-logo">
            </div>

            <h1 class="brand-title"> {{ $systemInfo->name ?? 'ProsharPOS' }}  </h1>

            <p class="brand-subtitle"> Your Business, Smarter Every Day. </p>

            <div class="brand-divider"></div>

            <p class="brand-description">
                Bangladesh's smart POS, inventory and business management
                solution. Everything you need to run your business with confidence.
            </p>
        </div>
        {{-- Features --}}
        <div class="brand-features">
            <div class="brand-feature">
                <span class="brand-feature-icon">
                    <i class="fas fa-file-invoice"></i>
                </span>
                <span>Challan, Invoice & Payments</span>
            </div>

            <div class="brand-feature">
                <span class="brand-feature-icon">
                    <i class="fas fa-boxes"></i>
                </span>
                <span>Product & Inventory Management</span>
            </div>

            <div class="brand-feature">
                <span class="brand-feature-icon">
                    <i class="fas fa-warehouse"></i>
                </span>
                <span>Stock, Storage & Warranty</span>
            </div>

            <div class="brand-feature">
                <span class="brand-feature-icon">
                    <i class="fas fa-wallet"></i>
                </span>
                <span>Petty Cash & Expense Tracking</span>
            </div>

            <div class="brand-feature">
                <span class="brand-feature-icon">
                    <i class="fas fa-chart-pie"></i>
                </span>
                <span>Reports & Business Analytics</span>
            </div>

            <div class="brand-feature">
                <span class="brand-feature-icon">
                    <i class="fas fa-users"></i>
                </span>
                <span>Customer & Supplier Management</span>
            </div>

            <div class="brand-feature">
                <span class="brand-feature-icon">
                    <i class="fas fa-user-shield"></i>
                </span>
                <span>Roles, Permissions & Security</span>
            </div>

        </div>

        {{-- Trust Message --}}
        <div class="brand-bottom">

            <div class="brand-bottom-icon">
                <i class="fas fa-store"></i>
            </div>

            <div>
                <h6>Built for Growing Businesses</h6>
                <p>
                    Retail · Wholesale · Distribution
                </p>
            </div>
        </div>
    </div>
</div>
