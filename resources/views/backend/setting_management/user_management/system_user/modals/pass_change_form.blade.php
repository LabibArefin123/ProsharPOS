     <form method="POST" id="changePasswordForm">
         @csrf
         <div class="modal-body">
             {{-- USER PROFILE --}}
             <div class="password-user-profile">
                 <img src="{{ asset('uploads/images/default.jpg') }}" id="modalUserPicture" class="password-user-avatar"
                     alt="User Profile">

                 <div class="password-user-info">
                     <h5 id="modalUserName">User Name</h5>

                     <span class="password-user-role">
                         <i class="fas fa-user-circle"></i>
                         System User
                     </span>

                     <div class="password-user-meta">
                         <span>
                             <i class="fas fa-at"></i>
                             <span id="modalUserUsername">Username</span>
                         </span>

                         <span>
                             <i class="fas fa-envelope"></i>
                             <span id="modalUserEmail">Email</span>
                         </span>
                     </div>

                 </div>

             </div>

             <div class="password-modal-divider"></div>

             <div class="password-section-heading">
                 <i class="fas fa-lock"></i>
                 <span>New Login Credentials</span>
             </div>

             {{-- NEW PASSWORD --}}
             <div class="form-group password-form-group">

                 <label for="password">New Password</label>

                 <div class="input-group password-input-group">

                     <input type="password" name="password" id="password" class="form-control"
                         placeholder="Enter new password" autocomplete="new-password">

                     <div class="input-group-append">
                         <button type="button" class="input-group-text toggle-password" data-target="password"
                             aria-label="Show password">
                             <i class="fas fa-eye"></i>
                         </button>
                     </div>
                 </div>
             </div>

             {{-- CONFIRM PASSWORD --}}
             <div class="form-group password-form-group mb-0">
                 <label for="password_confirmation">Confirm Password</label>
                 <div class="input-group password-input-group">

                     <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                         placeholder="Confirm new password" autocomplete="new-password">

                     <div class="input-group-append">
                         <button type="button" class="input-group-text toggle-password"
                             data-target="password_confirmation" aria-label="Show password">
                             <i class="fas fa-eye"></i>
                         </button>
                     </div>
                 </div>
             </div>
         </div>

         <div class="password-modal-footer">
             <button type="button" class="btn password-cancel-btn" data-dismiss="modal">
                 Cancel
             </button>

             <button type="submit" class="btn password-update-btn">
                 <i class="fas fa-key"></i>
                 Update Password
             </button>
         </div>
     </form>
