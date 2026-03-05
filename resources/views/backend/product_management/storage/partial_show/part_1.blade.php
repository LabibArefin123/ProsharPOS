 {{-- Start of Product Part --}}
 <div class="row ">
     <div class="col-md-4">
         <strong>Product Name:</strong>
         <p class="form-control">
             {{ $storage->product->name }}
         </p>
     </div>

     <div class="col-md-4">
         <strong>SKU:</strong>
         <p class="form-control">
             {{ $storage->product->sku }}
         </p>
     </div>

     <div class="col-md-4">
         <strong>Part Number</strong>
         <p class="form-control">
             {{ $storage->product->part_number }}
         </p>
     </div>

     <div class="col-md-4">
         <strong>Type / Model</strong>
         <p class="form-control">
             {{ $storage->product->type_model }}
         </p>
     </div>

     <div class="col-md-4">
         <strong>Origin</strong>
         <p class="form-control">
             {{ $storage->product->origin }}
         </p>
     </div>

     <div class="col-md-4">
         <strong>Using Place</strong>
         <p class="form-control">
             {{ $storage->product->using_place }}
         </p>
     </div>
 </div>
 {{-- End of Product Part --}}
