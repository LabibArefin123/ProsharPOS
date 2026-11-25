 <div class="profile-edit-card">
     <div class="profile-edit-card-header">
         <div class="profile-edit-card-icon">
             <i class="fas fa-user-edit"></i>
         </div>

         <div>
             <h4>Personal Information</h4>
             <p>Keep your profile information accurate and up to date.</p>
         </div>
     </div>

     <div class="profile-edit-card-body">
         <div class="row">
             <div class="col-md-6">
                 <div class="profile-edit-form-group">
                     <label for="name">
                         Full Name <span class="required-mark">*</span>
                     </label>

                     <div class="profile-edit-input-group">
                         <span class="profile-edit-input-icon">
                             <i class="fas fa-user"></i>
                         </span>

                         <input type="text" name="name" id="name"
                             class="form-control @error('name') is-invalid @enderror"
                             value="{{ old('name', $user->name) }}" placeholder="Enter your full name" maxlength="255"
                             autocomplete="name">
                     </div>

                     @error('name')
                         <div class="profile-edit-error">{{ $message }}</div>
                     @enderror
                 </div>
             </div>

             {{-- Username --}}
             <div class="col-md-6">
                 <div class="profile-edit-form-group">
                     <label for="username">
                         Username <span class="required-mark">*</span>
                     </label>

                     <div class="profile-edit-input-group">
                         <span class="profile-edit-input-icon">
                             <i class="fas fa-at"></i>
                         </span>

                         <input type="text" name="username" id="username"
                             class="form-control @error('username') is-invalid @enderror"
                             value="{{ old('username', $user->username) }}" placeholder="Enter your username"
                             maxlength="255" autocomplete="username">
                     </div>

                     @error('username')
                         <div class="profile-edit-error">{{ $message }}</div>
                     @enderror
                 </div>
             </div>

             {{-- Email --}}
             <div class="col-md-6">
                 <div class="profile-edit-form-group">
                     <label for="email">
                         Email Address <span class="required-mark">*</span>
                     </label>

                     <div class="profile-edit-input-group">
                         <span class="profile-edit-input-icon">
                             <i class="fas fa-envelope"></i>
                         </span>

                         <input type="email" name="email" id="email"
                             class="form-control @error('email') is-invalid @enderror"
                             value="{{ old('email', $user->email) }}" placeholder="Enter your email address"
                             maxlength="255" autocomplete="email">
                     </div>

                     @error('email')
                         <div class="profile-edit-error">{{ $message }}</div>
                     @enderror
                 </div>
             </div>

             {{-- Phone --}}
             <div class="col-md-6">
                 <div class="profile-edit-form-group">
                     <label for="phone">Phone Number</label>

                     <div class="profile-edit-input-group">
                         <span class="profile-edit-input-icon">
                             <i class="fas fa-phone-alt"></i>
                         </span>

                         <input type="tel" name="phone" id="phone"
                             class="form-control @error('phone') is-invalid @enderror"
                             value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone number"
                             maxlength="30" autocomplete="tel">
                     </div>

                     @error('phone')
                         <div class="profile-edit-error">{{ $message }}</div>
                     @enderror
                 </div>
             </div>

         </div>

         <div class="profile-edit-required-note">
             <span class="required-mark">*</span>
             Required fields
         </div>

     </div>

     {{-- Form Footer --}}
     <div class="profile-edit-card-footer">

         <a href="{{ url()->previous() }}" class="profile-edit-cancel-btn" id="cancelProfileBtn">
             <i class="fas fa-times"></i>
             Cancel
         </a>

         <button type="submit" class="profile-edit-save-btn" id="updateProfileBtn">
             <i class="fas fa-save"></i>
             <span>Save Changes</span>
         </button>

     </div>

 </div>
