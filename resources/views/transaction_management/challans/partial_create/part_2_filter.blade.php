 {{-- Start of Filter form --}}
 <div class="card mb-4 shadow-sm">
     <div class="card-header bg-secondary text-white">
         <strong>🔎 Product Filters</strong>
     </div>
     <div class="card-body row g-3">
         <div class="col-md-3">
             <label>Search by Name</label>
             <input type="text" placeholder="Enter product name..." class="form-control" id="filter-name">
         </div>
         <div class="col-md-3">
             <label>Product</label>
             <select id="filter-product" class="form-control">
                 <option value="">All Products</option>
                 @foreach ($products as $product)
                     <option value="{{ $product->id }}">{{ $product->name }}</option>
                 @endforeach
             </select>
         </div>
         <div class="col-md-2">
             <label>Category</label>
             <select id="filter-category" class="form-control">
                 <option value="">All Categories</option>
                 @foreach ($products->pluck('category.name')->unique() as $category)
                     <option>{{ $category }}</option>
                 @endforeach
             </select>
         </div>
         <div class="col-md-2">
             <label>Brand</label>
             <select id="filter-brand" class="form-control">
                 <option value="">All Brands</option>
                 @foreach ($products->pluck('brand.name')->unique() as $brand)
                     <option>{{ $brand }}</option>
                 @endforeach
             </select>
         </div>
         <div class="col-md-2">
             <label>Branch</label>
             <select name="branch_id" class="form-control" required>
                 @foreach ($branches as $branch)
                     <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                 @endforeach
             </select>
         </div>
     </div>
 </div>
 {{-- End of Filter form --}}
