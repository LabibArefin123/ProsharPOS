<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-orange text-white shadow-sm dashboard-box">

        <div class="inner">
            <h3>{{ $totalPettyCashReceive }} Tk</h3>
            <p>Petty Cash Receive</p>
        </div>

        <div class="icon">
            <i class="fas fa-coins"></i>
        </div>

        <!-- Hidden Details -->
        <div class="pending-float">
            <strong>Pending:</strong> {{ $totalPettyCashReceivePending }}<br>
            <strong>Approved:</strong>{{ $totalPettyCashReceiveApproved }}<br>
            <strong>Rejected:</strong> {{ $totalPettyCashReceiveRejected }}
        </div>

        <a href="{{ route('petty_cashes.index') }}" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-lime text-white shadow-sm dashboard-box">

        <div class="inner">
            <h3>{{ $totalPettyCashExpense }} Tk</h3>
            <p>Petty Cash Expense</p>
        </div>

        <div class="icon">
            <i class="fas fa-wallet"></i>
        </div>

        <div class="pending-float">
            <strong>Pending:</strong> {{ $totalPettyCashExpensePending }}<br>
            <strong>Approved:</strong> {{ $totalPettyCashExpenseApproved }}<br>
            <strong>Rejected:</strong> {{ $totalPettyCashExpenseRejected }}
        </div>

        <a href="{{ route('petty_cashes.index') }}" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-warning text-white shadow-sm dashboard-box">

        <div class="inner">
            <h3>${{ $totalPettyCashDollarReceive }}</h3>
            <p>Petty Cash Dollar Receive</p>
        </div>

        <div class="icon">
            <i class="fas fa-dollar-sign"></i>
        </div>

        <div class="pending-float">
            <strong>Pending:</strong> {{ $totalPettyCashDollarReceivePending }}<br>
            <strong>Approved:</strong> {{ $totalPettyCashDollarReceiveApproved }}<br>
            <strong>Rejected:</strong> {{ $totalPettyCashDollarReceiveRejected }}
        </div>

        <a href="{{ route('petty_cashes.index') }}" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-pink text-white shadow-sm dashboard-box">

        <div class="inner">
            <h3>${{ $totalPettyCashDollarExpense }}</h3>
            <p>Petty Cash Dollar Expense</p>
        </div>

        <div class="icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>

        <div class="pending-float">
            <strong>Pending:</strong> {{ $totalPettyCashDollarExpensePending }}<br>
            <strong>Approved:</strong> {{ $totalPettyCashDollarExpenseApproved }}<br>
            <strong>Rejected:</strong> {{ $totalPettyCashDollarExpenseRejected }}
        </div>

        <a href="{{ route('petty_cashes.index') }}" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<style>
.pending-float {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.85);
    color: #fff;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    line-height: 1.6;
    display: none;
    z-index: 10;
    min-width: 160px;
}

.pending-hover:hover .pending-float {
    display: block;
}
</style>
