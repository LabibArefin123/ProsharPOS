 <div class="user-form-section">
     <div class="user-form-section-heading">
         <i class="fas fa-address-book"></i>
         <div>
             <h6>Contact Information</h6>
             <p>Provide the user's contact information.</p>
         </div>
     </div>

     <div class="row">
         <div class="form-group col-md-6">
             <label for="phone">Phone Number <span>*</span></label>
             <div class="user-input-wrapper">
                 <i class="fas fa-phone"></i>
                 <input type="text" id="phone" name="phone"
                     class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                     placeholder="Enter phone number">
             </div>
             @error('phone')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

         <div class="form-group col-md-6">
             <label for="phone_2">Alternative Phone <small>(Optional)</small></label>
             <div class="user-input-wrapper">
                 <i class="fas fa-mobile-alt"></i>
                 <input type="text" id="phone_2" name="phone_2"
                     class="form-control @error('phone_2') is-invalid @enderror" value="{{ old('phone_2') }}"
                     placeholder="Enter alternative phone">
             </div>
             @error('phone_2')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

     </div>
 </div>
