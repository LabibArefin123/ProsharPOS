  {{-- Main Section: Product + Cart --}}
  <div class="row">
      {{-- Product Grid --}}
      <div class="col-md-6">
          <div class="card shadow mb-4">
              <div class="card-header bg-success text-white">
                  <h5 class="mb-0">📦 Products</h5>
              </div>
              <div class="card-body row">
                  @foreach ($products as $product)
                      <div class="col-md-4 mb-3">
                          <div class="card product-card border h-100" data-id="{{ $product->id }}"
                              data-name="{{ $product->name }}" data-price="{{ $product->purchase_price }}"
                              data-image="{{ asset($product->image) }}">
                              <img src="{{ asset($product->image) }}" class="card-img-top p-2"
                                  style="height:160px; object-fit:contain;" alt="{{ $product->name }}">
                              <div class="card-body p-2 text-center">
                                  <h6 class="font-weight-bold mb-1">{{ $product->name }}</h6>
                                  <p class="mb-1">৳{{ $product->purchase_price }}</p>
                                  <button type="button"
                                      class="btn btn-outline-primary btn-sm add-to-invoice">Add</button>
                              </div>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
      </div>

      {{-- Cart Summary --}}
      <div class="col-md-6">
          <div class="card shadow mb-4">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0">🛒 Invoice Cart</h5>
              </div>
              <div class="card-body p-3">
                  <table class="table table-sm table-bordered" id="invoice-cart">
                      <thead class="thead-light">
                          <tr>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Qty</th>
                              <th>Disc.</th>
                              <th>Amt</th>
                              <th>BDT</th>
                              <th>❌</th>
                          </tr>
                      </thead>
                      <tbody></tbody>
                  </table>

                  <div class="mb-2">
                      <strong>Subtotal:</strong> <span id="sub-total">0</span><br>
                      <strong>Subtotal (BDT):</strong> <span id="sub-total-bdt">0</span>
                  </div>

                  <div class="form-group mb-2">
                      <label>Discount Type</label>
                      <select id="discount-type" name="discount_type" class="form-control">
                          <option value="percentage">Percentage</option>
                          <option value="flat">Flat</option>
                      </select>
                  </div>

                  <div id="discount-section">
                      <div id="percent-section">
                          <label>Discount (%)</label>
                          <input type="number" name="discount_percent" id="discount-percent" class="form-control">
                          <p class="mt-2 mb-0">Discount Amount: <span id="discount-amount">0</span></p>
                          <p>Total After Discount: <span id="total-after-discount">0</span></p>
                      </div>
                      <div id="flat-section" style="display:none;">
                          <label>Flat Discount</label>
                          <input type="number" name="flat_discount" id="flat-discount" class="form-control">
                          <p class="mt-2 mb-0">Total After Discount: <span id="flat-total">0</span></p>
                      </div>
                  </div>

                  <input type="hidden" name="items" id="invoice-items">
                  <button type="submit" class="btn btn-success btn-block mt-3">💾 Submit Invoice</button>
              </div>
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const cartTable = document.querySelector('#invoice-cart tbody');
          const itemsInput = document.getElementById('invoice-items');
          const discountType = document.getElementById('discount-type');
          const percentSection = document.getElementById('percent-section');
          const flatSection = document.getElementById('flat-section');
          const discountPercent = document.getElementById('discount-percent');
          const flatDiscount = document.getElementById('flat-discount');
          const discountAmountDisplay = document.getElementById('discount-amount');
          const totalAfterDiscountDisplay = document.getElementById('total-after-discount');
          const flatTotalDisplay = document.getElementById('flat-total');
          const subTotalDisplay = document.getElementById('sub-total');
          const subTotalBDTDisplay = document.getElementById('sub-total-bdt');

          let cartItems = [];

          // Add product to cart
          document.querySelectorAll('.add-to-invoice').forEach(button => {
              button.addEventListener('click', function() {
                  const card = this.closest('.product-card');
                  const id = card.dataset.id;
                  const name = card.dataset.name;
                  const price = parseFloat(card.dataset.price);

                  const existing = cartItems.find(item => item.id === id);
                  if (existing) {
                      existing.qty += 1;
                  } else {
                      cartItems.push({
                          id,
                          name,
                          price,
                          qty: 1,
                          discount: 0
                      });
                  }

                  renderCart();
              });
          });

          // Render cart table
          function renderCart() {
              cartTable.innerHTML = '';
              let subTotal = 0;

              cartItems.forEach((item, index) => {
                  const amount = item.qty * item.price - item.discount;
                  subTotal += amount;

                  const row = document.createElement('tr');
                  row.innerHTML = `
                <td>${item.name}</td>
                <td>৳${item.price.toFixed(2)}</td>
                <td><input type="number" min="1" value="${item.qty}" data-index="${index}" class="form-control form-control-sm qty-input"></td>
                <td><input type="number" min="0" value="${item.discount}" data-index="${index}" class="form-control form-control-sm disc-input"></td>
                <td>৳${(item.qty * item.price).toFixed(2)}</td>
                <td>৳${amount.toFixed(2)}</td>
                <td><button type="button" data-index="${index}" class="btn btn-danger btn-sm remove-btn">✕</button></td>
            `;
                  cartTable.appendChild(row);
              });

              subTotalDisplay.innerText = subTotal.toFixed(2);
              subTotalBDTDisplay.innerText = subTotal.toFixed(2);
              updateDiscounts();
              itemsInput.value = JSON.stringify(cartItems);
          }

          // Qty, discount, remove handlers
          cartTable.addEventListener('input', function(e) {
              const index = e.target.dataset.index;
              if (e.target.classList.contains('qty-input')) {
                  cartItems[index].qty = parseInt(e.target.value);
              } else if (e.target.classList.contains('disc-input')) {
                  cartItems[index].discount = parseFloat(e.target.value);
              }
              renderCart();
          });

          cartTable.addEventListener('click', function(e) {
              if (e.target.classList.contains('remove-btn')) {
                  cartItems.splice(e.target.dataset.index, 1);
                  renderCart();
              }
          });

          // Discount toggle
          discountType.addEventListener('change', function() {
              if (this.value === 'percentage') {
                  percentSection.style.display = 'block';
                  flatSection.style.display = 'none';
              } else {
                  percentSection.style.display = 'none';
                  flatSection.style.display = 'block';
              }
              updateDiscounts();
          });

          discountPercent.addEventListener('input', updateDiscounts);
          flatDiscount.addEventListener('input', updateDiscounts);

          function updateDiscounts() {
              const subTotal = cartItems.reduce((sum, item) => sum + (item.qty * item.price - item.discount), 0);

              if (discountType.value === 'percentage') {
                  const percent = parseFloat(discountPercent.value) || 0;
                  const amount = subTotal * (percent / 100);
                  discountAmountDisplay.innerText = amount.toFixed(2);
                  totalAfterDiscountDisplay.innerText = (subTotal - amount).toFixed(2);
              } else {
                  const flat = parseFloat(flatDiscount.value) || 0;
                  flatTotalDisplay.innerText = (subTotal - flat).toFixed(2);
              }
          }
      });
  </script>
