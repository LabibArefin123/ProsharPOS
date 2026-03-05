 {{-- Start of Product Part --}}
 <div class="row ">
     <div class="col-md-4 form-group">
         <strong>Product Name:</strong>
         <p class="form-control">
             {{ $storage->product->name }}
         </p>
     </div>

     <div class="col-md-4 form-group">
         <strong>SKU:</strong>
         <p class="form-control">
             {{ $storage->product->sku }}
         </p>
     </div>

     <div class="col-md-4 form-group">
         <strong>Part Number</strong>
          <input type="text" id="name" class="form-control" value="{{ $storage->product->part_number }}" readonly>
     </div>

     <div class="col-md-4 form-group">
         <strong>Type / Model</strong>
         <input type="text" id="name" class="form-control" value="{{ $storage->product->type_model }}" readonly>
     </div>

     <div class="col-md-4 form-group">
         <strong>Origin</strong>
         <input type="text" id="name" class="form-control" value="{{ $storage->product->origin }}" readonly>
     </div>

     <div class="col-md-4 form-group">
         <strong>Using Place</strong>
         <input type="text" id="name" class="form-control" value="{{ $storage->product->using_place }}" readonly>
     </div>
 </div>
 {{-- End of Product Part --}}
