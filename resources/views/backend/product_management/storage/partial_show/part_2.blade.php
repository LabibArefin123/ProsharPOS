 <div class="col-md-4 form-group">
     <strong>Rack Number:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->rack_number }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Rack Label:</strong>
     <input type="text" id="name" class="form-control" value=" {{ $storage->rack_no }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Rack Location:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->rack_location }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Box Number :</strong>
     <input type="text" id="name" class="form-control" value=" {{ $storage->box_number }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Box Label:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->box_no }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Box Location:</strong>
     <input type="text" id="name" class="form-control" value=" {{ $storage->box_location }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Alert Quantity:</strong>
     <input type="text" id="name" class="form-control" value=" {{ $storage->alert_quantity }}" readonly>
 </div>

     <div class="col-md-12">

         <table class="table table-bordered table-sm text-center">
             <thead class="table-light">
                 <tr>
                     <th style="width:50%">Product Image</th>
                     <th style="width:50%">Product Barcode</th>
                 </tr>
             </thead>

             <tbody>
                 <tr>

                     <!-- PRODUCT IMAGE -->
                     <td>

                         @if ($storage->image_path)
                             <img src="{{ asset($storage->image_path) }}" class="img-fluid img-thumbnail"
                                 style="max-height:120px;">
                         @else
                             <span class="text-muted small">No Image</span>
                         @endif

                     </td>


                     <!-- BARCODE -->
                     <td>

                         @if ($storage->barcode_path)
                             <img src="{{ asset($storage->barcode_path) }}" class="img-fluid" style="max-height:80px;">

                             <div class="mt-1">
                                 <small class="text-muted">
                                     {{ $storage->barcode }}
                                 </small>
                             </div>
                         @else
                             <span class="text-muted small">No Barcode</span>
                         @endif

                     </td>

                 </tr>
             </tbody>
         </table>

     </div>

     <!-- STOCK QUANTITY -->
     <div class="col-md-4 form-group">
         <strong>Stock Quantity:</strong>
         <p class="form-control">
             {{ $storage->stock_quantity }}
         </p>
     </div>


     <!-- MIN STOCK -->
     <div class="col-md-4 form-group">
         <strong>Minimum Stock Level:</strong>
         <p class="form-control">
             {{ $storage->minimum_stock_level }}
         </p>
     </div>


     <!-- MAX STOCK -->
     <div class="col-md-4 form-group">
         <strong>Maximum Stock Level:</strong>
         <p class="form-control">
             {{ $storage->maximum_stock_level }}
         </p>
     </div>
