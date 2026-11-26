 <div class="user-form-section">
     <div class="user-form-section-heading">
         <i class="fas fa-shield-alt"></i>
         <div>
             <h6>Account Security</h6>
             <p>Create a secure password for the new account.</p>
         </div>
     </div>

     <div class="row">

         <div class="form-group col-md-6">
             <label for="password">Password <span>*</span></label>
             <div class="user-input-wrapper user-password-wrapper">
                 <i class="fas fa-lock"></i>
                 <input type="password" id="password" name="password"
                     class="form-control @error('password') is-invalid @enderror" placeholder="Enter password"
                     autocomplete="new-password">
                 <button type="button" class="user-password-toggle" data-target="password" aria-label="Show password">
                     <i class="fas fa-eye"></i>
                 </button>
             </div>
             @error('password')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
             <small class="user-field-hint">Minimum 6 characters.</small>
         </div>

         <div class="form-group col-md-6">
             <label for="password_confirmation">Confirm Password <span>*</span></label>
             <div class="user-input-wrapper user-password-wrapper">
                 <i class="fas fa-lock"></i>
                 <input type="password" id="password_confirmation" name="password_confirmation"
                     class="form-control @error('password_confirmation') is-invalid @enderror"
                     placeholder="Confirm password" autocomplete="new-password">
                 <button type="button" class="user-password-toggle" data-target="password_confirmation"
                     aria-label="Show password">
                     <i class="fas fa-eye"></i>
                 </button>
             </div>
             @error('password_confirmation')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

     </div>
 </div>
