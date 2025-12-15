  <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="small-box bg-warning text-white shadow-sm dashboard-box">
          <div class="inner">
              <h3>{{ $total_challans }}</h3>
              <p>Total Challan</p>
          </div>
          <div class="icon">
              <i class="fas fa-truck-loading"></i>
          </div>
          <a href="{{ route('challans.index') }}" class="small-box-footer">
              More Info <i class="fas fa-arrow-circle-right"></i>
          </a>
      </div>
  </div>

  {{-- CHALLAN UNBILLED --}}
  <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="small-box bg-pink text-white shadow-sm dashboard-box">
          <div class="inner">
              <h3>{{ $total_challan_unbill }}</h3>
              <p>Challan Unbilled</p>
          </div>
          <div class="icon">
              <i class="fas fa-ban"></i>
          </div>
          <a href="{{ route('challans.index') }}" class="small-box-footer">
              More Info <i class="fas fa-arrow-circle-right"></i>
          </a>
      </div>
  </div>

  {{-- CHALLAN BILLED --}}
  <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="small-box bg-info text-white shadow-sm dashboard-box">
          <div class="inner">
              <h3>{{ $total_challan_bill }}</h3>
              <p>Challan Billed</p>
          </div>
          <div class="icon">
              <i class="fas fa-file-invoice"></i>
          </div>
          <a href="{{ route('challans.index') }}" class="small-box-footer">
              More Info <i class="fas fa-arrow-circle-right"></i>
          </a>
      </div>
  </div>

  {{-- CHALLAN FOC --}}
  <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="small-box bg-purple text-white shadow-sm dashboard-box">
          <div class="inner">
              <h3>{{ $total_challan_foc }}</h3>
              <p>Challan FOC</p>
          </div>
          <div class="icon">
              <i class="fas fa-gift"></i>
          </div>
          <a href="{{ route('challans.index') }}" class="small-box-footer">
              More Info <i class="fas fa-arrow-circle-right"></i>
          </a>
      </div>
  </div>
