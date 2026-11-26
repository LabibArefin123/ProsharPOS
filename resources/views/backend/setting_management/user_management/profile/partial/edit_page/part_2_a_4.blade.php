 <section class="profile-edit-card profile-edit-reveal">
     <div class="profile-edit-section-heading">
         <div class="profile-edit-section-icon security">
             <i class="fas fa-lock"></i>
         </div>

         <div>
             <h5>Change Password</h5>
             <p>Leave these fields empty if you don't want to change your password.</p>
         </div>
     </div>

     <div class="profile-password-notice">
         <i class="fas fa-info-circle"></i>
         Your current password is to change your password.
     </div>

     <div class="profile-edit-fields-grid">
         <div class="profile-edit-field full-width">
             <label for="current_password">Current Password</label>
             <div class="profile-password-input">
                 <input type="password" name="current_password" id="current_password"
                     class="form-control @error('current_password') is-invalid @enderror"
                     placeholder="Enter your current password" autocomplete="current-password">

                 <button type="button" class="toggle-password" data-target="current_password"
                     aria-label="Show current password">
                     <i class="fas fa-eye"></i>
                 </button>
             </div>

             @error('current_password')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

         <div class="profile-edit-field">
             <label for="new_password">New Password</label>
             <div class="profile-password-input">
                 <input type="password" name="new_password" id="new_password"
                     class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter new password"
                     autocomplete="new-password">

                 <button type="button" class="toggle-password" data-target="new_password"
                     aria-label="Show new password">
                     <i class="fas fa-eye"></i>
                 </button>
             </div>

             @error('new_password')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror

             <div class="profile-password-strength" id="passwordStrengthWrapper">
                 <div class="profile-password-strength-track">
                     <span id="passwordStrengthBar"></span>
                 </div>
                 <small id="passwordStrengthText">Password strength</small>
             </div>
         </div>

         <div class="profile-edit-field">
             <label for="confirm_password">Confirm New Password</label>

             <div class="profile-password-input">
                 <input type="password" name="confirm_password" id="confirm_password"
                     class="form-control @error('confirm_password') is-invalid @enderror"
                     placeholder="Confirm new password" autocomplete="new-password">

                 <button type="button" class="toggle-password" data-target="confirm_password"
                     aria-label="Show confirmation password">
                     <i class="fas fa-eye"></i>
                 </button>
             </div>

             @error('confirm_password')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror

             <small class="profile-password-match" id="passwordMatchText"></small>
         </div>
     </div>
 </section>
