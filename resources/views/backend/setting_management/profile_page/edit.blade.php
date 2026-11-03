 @extends('adminlte::page')

 @section('title', 'Edit User Profile')

 @section('content_header')
     <div class="profile-edit-page-heading">
         <div>
             <span class="profile-edit-eyebrow">ACCOUNT SETTINGS</span>
             <h1 class="profile-edit-page-title">Edit Profile</h1>
             <p class="profile-edit-page-subtitle">
                 Update your personal information and account details.
             </p>
         </div>

         <a href="{{ url()->previous() }}" class="profile-edit-back-btn" id="backProfileBtn">
             <i class="fas fa-arrow-left"></i>
             <span>Go Back</span>
         </a>
     </div>
 @stop

 @section('content')

     <div class="container-fluid profile-edit-page">

         <form action="{{ route('user_profile_update') }}" method="POST" enctype="multipart/form-data"
             id="profileUpdateForm">

             @csrf
             @method('PUT')

             {{-- Profile Edit Header --}}
             <div class="profile-edit-hero">
                 <div class="profile-edit-hero-decoration"></div>

                 <div class="profile-edit-hero-content">

                     <div class="profile-edit-avatar-wrapper">
                         <img src="{{ $user->adminlte_image() }}" alt="{{ $user->name }}" class="profile-edit-avatar"
                             id="profileAvatarPreview">
                     </div>

                     <div class="profile-edit-hero-info">
                         <span>
                             <i class="fas fa-user-circle"></i>
                             PROFILE INFORMATION
                         </span>

                         <h3>{{ $user->name }}</h3>

                         <p>
                             {{ $user->email }}
                         </p>

                         <small>
                             <i class="fas fa-shield-alt"></i>
                             Update your account information securely.
                         </small>
                     </div>

                 </div>
             </div>

             {{-- Form Card --}}
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

                         {{-- Full Name --}}
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
                                         value="{{ old('name', $user->name) }}" placeholder="Enter your full name"
                                         maxlength="255" autocomplete="name">
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

         </form>

         {{-- Security Note --}}
         <div class="profile-edit-security-note">
             <i class="fas fa-lock"></i>
             <span>Your personal information is protected by ProsharPOS.</span>
         </div>

     </div>

 @stop

 @section('css')
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_base.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_header.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_form.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_avatar.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_responsive.css') }}">
 @stop

 @section('js')
     <script>
         $(document).ready(function() {

             const form = document.getElementById('profileUpdateForm');
             const submitButton = document.getElementById('updateProfileBtn');

             if (!form) return;

             let formSubmitted = false;

             // Track changes in form fields.
             const originalFormData = new FormData(form);

             function hasFormChanged() {
                 const currentFormData = new FormData(form);

                 for (const [key, value] of currentFormData.entries()) {
                     if (key === '_token' || key === '_method') {
                         continue;
                     }

                     if (value instanceof File) {
                         if (value.name) return true;
                         continue;
                     }

                     if (value !== originalFormData.get(key)) {
                         return true;
                     }
                 }

                 return false;
             }

             // Unsaved changes warning.
             window.addEventListener('beforeunload', function(e) {
                 if (!formSubmitted && hasFormChanged()) {
                     e.preventDefault();
                     e.returnValue = '';
                 }
             });

             // Confirm profile update.
             form.addEventListener('submit', function(e) {
                 if (formSubmitted) return;

                 e.preventDefault();

                 Swal.fire({
                     title: 'Save Profile Changes?',
                     text: 'Are you sure you want to update your profile information?',
                     icon: 'question',
                     showCancelButton: true,
                     confirmButtonText: 'Yes, Save Changes',
                     cancelButtonText: 'Continue Editing',
                     confirmButtonColor: '#c99b42',
                     cancelButtonColor: '#64748b',
                     reverseButtons: true
                 }).then(function(result) {

                     if (result.isConfirmed) {
                         formSubmitted = true;
                         submitButton.disabled = true;

                         submitButton.innerHTML =
                             '<i class="fas fa-spinner fa-spin"></i> Updating...';

                         form.submit();
                     }

                 });
             });

             // Warn before going back when there are unsaved changes.
             $('#backProfileBtn, #cancelProfileBtn').on('click', function(e) {
                 if (!hasFormChanged()) return;

                 e.preventDefault();

                 const destination = $(this).attr('href');

                 Swal.fire({
                     title: 'Discard Changes?',
                     text: 'You have unsaved profile changes. Do you want to leave this page?',
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonText: 'Yes, Leave',
                     cancelButtonText: 'Stay Here',
                     confirmButtonColor: '#dc3545',
                     cancelButtonColor: '#64748b',
                     reverseButtons: true
                 }).then(function(result) {
                     if (result.isConfirmed) {
                         formSubmitted = true;
                         window.location.href = destination;
                     }
                 });
             });

         });
     </script>
 @stop
