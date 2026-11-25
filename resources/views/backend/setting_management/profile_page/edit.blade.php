 @extends('adminlte::page')

 @section('title', 'Edit User Profile')

 @section('adminlte_css')
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_base.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_header.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_form.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_avatar.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/edit_responsive.css') }}">
 @stop

 @section('content_header')
     @include('backend.setting_management.profile_page.partial_page.edit_page.header_part')
 @stop

 @section('content')
     <div class="container-fluid profile-edit-page">
         <form action="{{ route('user_profile_update') }}" method="POST" enctype="multipart/form-data" id="profileUpdateForm">
             @csrf
             @method('PUT')
             {{-- Profile Edit Header --}}
             @include('backend.setting_management.profile_page.partial_page.edit_page.part_1')
             {{-- Form Card --}}
             @include('backend.setting_management.profile_page.partial_page.edit_page.part_2')
         </form>

         {{-- Security Note --}}
         <div class="profile-edit-security-note">
             <i class="fas fa-lock"></i>
             <span>Your personal information is protected by ProsharPOS.</span>
         </div>
     </div>
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
