 <div class="user-form-section">
     <div class="user-form-section-heading">
         <i class="fas fa-id-card"></i>
         <div>
             <h6>Personal Information</h6>
             <p>Enter the new user's basic account information.</p>
         </div>
     </div>

     <div class="row">

         <div class="form-group col-md-6">
             <label for="name">Full Name <span>*</span></label>
             <div class="user-input-wrapper">
                 <i class="fas fa-user"></i>
                 <input type="text" id="name" name="name"
                     class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                     placeholder="Enter full name">
             </div>
             @error('name')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

         <div class="form-group col-md-6">
             <label for="role">Assign Role <span>*</span></label>
             <div class="user-input-wrapper">
                 <i class="fas fa-user-shield"></i>
                 <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                     <option value="">Select Role</option>
                     @foreach ($roles as $role)
                         <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                             {{ ucfirst($role->name) }}
                         </option>
                     @endforeach
                 </select>
             </div>
             @error('role')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

         <div class="form-group col-md-6">
             <label for="username">Username <span>*</span></label>
             <div class="user-input-wrapper">
                 <i class="fas fa-at"></i>
                 <input type="text" id="username" name="username"
                     class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}"
                     placeholder="Choose a username">
             </div>
             @error('username')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

         <div class="form-group col-md-6">
             <label for="email">Email Address <span>*</span></label>
             <div class="user-input-wrapper">
                 <i class="fas fa-envelope"></i>
                 <input type="email" id="email" name="email"
                     class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                     placeholder="Enter email address">
             </div>
             @error('email')
                 <div class="invalid-feedback d-block">{{ $message }}</div>
             @enderror
         </div>

     </div>
 </div>
