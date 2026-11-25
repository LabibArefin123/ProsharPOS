  <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="font-weight-bold">🧾 POS Terminal</h3>
      <div class="d-flex align-items-center">
          <input type="text" id="search-product" class="form-control mr-3" style="width:250px"
              placeholder="🔍 Search product...">

          {{-- 🛒 CART BUTTON --}}
          <div style="position: relative;">
              <button class="btn btn-dark" id="open-cart">
                  🛒 Cart
              </button>

              {{-- 🔴 BADGE --}}
              <span id="cart-count"
                  style="
                    position:absolute;
                    top:-8px;
                    right:-8px;
                    background:red;
                    color:white;
                    border-radius:50%;
                    padding:2px 6px;
                    font-size:12px;
                    display:none;
                  ">
                  0
              </span>
          </div>
      </div>
  </div>
