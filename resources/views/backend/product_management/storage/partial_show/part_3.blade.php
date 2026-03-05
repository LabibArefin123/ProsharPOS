 {{-- Start of Supplier Part --}}
 <div class="col-md-4 form-group">
     <strong>Supplier Name:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->supplier->name }}" readonly>
 </div>
 
 <div class="col-md-4 form-group">
     <strong>Supplier's Email:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->supplier->email }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Supplier's Phone:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->supplier->phone_number }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Supplier's Company Name:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->supplier->company_name }}" readonly>
 </div>

 <div class="col-md-4 form-group">
     <strong>Supplier's License Number:</strong>
     <input type="text" id="name" class="form-control" value="{{ $storage->supplier->license_number }}"
         readonly>
 </div>
 {{-- End of Supplier Part --}}
