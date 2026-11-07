@role('admin|manager|accountant')
    <div class="profile-section-heading">
        <div>
            <h4>Financial Overview</h4>
            <p>Your current account balances</p>
        </div>
    </div>

    <div class="row profile-balance-row">

        <div class="col-md-6 mb-3">
            <div class="profile-balance-card balance-bdt">
                <div class="profile-balance-content">
                    <span>Bank Balance (BDT)</span>
                    <h3>৳{{ number_format($bankBalance->balance, 2) }}</h3>
                    <small>Bangladeshi Taka</small>
                </div>
                <div class="profile-balance-icon">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="profile-balance-card balance-usd">
                <div class="profile-balance-content">
                    <span>Bank Balance (USD)</span>
                    <h3>${{ number_format($bankBalance->balance_in_dollars, 2) }}</h3>
                    <small>United States Dollar</small>
                </div>
                <div class="profile-balance-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

    </div>
@endrole
