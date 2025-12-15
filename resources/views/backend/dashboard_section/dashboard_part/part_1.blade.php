{{-- TOTAL INVOICE --}}
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-primary text-white shadow-sm dashboard-box">
        <div class="inner">
            <h3>{{ $total_invoices }}</h3>
            <p>Total Invoice</p>
        </div>
        <div class="icon">
            <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <a href="{{ route('invoices.index') }}" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

{{-- SALES AMOUNT --}}
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-success text-white shadow-sm dashboard-box">
        <div class="inner">
            <h3>{{ $salesAmount }} Tk</h3>
            <p>Sales Amount</p>
        </div>
        <div class="icon">
            <i class="fas fa-cash-register"></i>
        </div>
        <a href="#" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

{{-- RECEIVE AMOUNT --}}
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-indigo text-white shadow-sm dashboard-box">
        <div class="inner">
            <h3>{{ $receiveAmount }} Tk</h3>
            <p>Receive Amount</p>
        </div>
        <div class="icon">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
        <a href="#" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

{{-- DUE AMOUNT --}}
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-danger text-white shadow-sm dashboard-box">
        <div class="inner">
            <h3>{{ $dueAmount }} Tk</h3>
            <p>Due Amount</p>
        </div>
        <div class="icon">
            <i class="fas fa-hourglass-end"></i>
        </div>
        <a href="#" class="small-box-footer">
            More Info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
