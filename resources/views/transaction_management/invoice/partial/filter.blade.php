 {{-- Filter Section --}}
 <div class="card mb-4 shadow">
     <div class="card-header bg-info text-white">
         <h5 class="mb-0">Product Filters</h5>
     </div>
     <div class="card-body row">
         <div class="form-group col-md-3">
             <label>Product Name</label>
             <input type="text" id="filter-name" class="form-control" placeholder="Filter by Product Name">
         </div>
         <div class="form-group col-md-3">
             <label>Product</label>
             <select id="filter-product" class="form-control">
                 <option value="">Filter by Product</option>
                 @foreach ($products as $product)
                     <option value="{{ $product->id }}">{{ $product->name }}</option>
                 @endforeach
             </select>
         </div>
         <div class="form-group col-md-2">
             <label>Category</label>
             <select id="filter-category" class="form-control">
                 <option value="">All</option>
                 @foreach ($products->pluck('category.name')->unique() as $category)
                     <option>{{ $category }}</option>
                 @endforeach
             </select>
         </div>
         <div class="form-group col-md-2">
             <label>Brand</label>
             <select id="filter-brand" class="form-control">
                 <option value="">All</option>
                 @foreach ($products->pluck('brand.name')->unique() as $brand)
                     <option>{{ $brand }}</option>
                 @endforeach
             </select>
         </div>
         <div class="form-group col-md-2">
             <label>Branch</label>
             <select name="branch_id" class="form-control" required>
                 @foreach ($branches as $branch)
                     <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                 @endforeach
             </select>
         </div>
     </div>
 </div>
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const customerSelect = document.getElementById('customer_id');
         const customerEmail = document.getElementById('customer_email');
         const customerPhone = document.getElementById('customer_phone');
         const customerLocation = document.getElementById('customer_location');

         customerSelect.addEventListener('change', function() {
             const selectedCustomer = @json($customersData).find(c => c.id == this.value);
             if (selectedCustomer) {
                 customerEmail.value = selectedCustomer.email;
                 customerPhone.value = selectedCustomer.phone;
                 customerLocation.value = selectedCustomer.location;
             } else {
                 customerEmail.value = '';
                 customerPhone.value = '';
                 customerLocation.value = '';
             }
         });
     });
 </script>
