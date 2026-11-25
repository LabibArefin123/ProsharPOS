 @extends('adminlte::page')

 @section('title', 'User Profile')

 @section('adminlte_css')
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_base.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_header.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_info.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_transactions.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/profile_page/profile_responsive.css') }}">
 @stop

 @section('content_header')
     @include('backend.setting_management.profile_page.partial_page.show_page.header_part')
 @stop

 @section('content')
     <div class="container-fluid profile-page">
         {{-- Profile Overview --}}
         @include('backend.setting_management.profile_page.partial_page.show_page.part_1')
         @include('backend.setting_management.profile_page.partial_page.show_page.part_2')

         {{-- Financial Overview --}}
         @include('backend.setting_management.profile_page.partial_page.show_page.part_3')

         {{-- Recent Transactions Section --}}
         {{-- Recent Transactions Header Part --}}
         @include('backend.setting_management.profile_page.partial_page.show_page.part_4a')
         {{-- Recent Transactions Table Part --}}
         @include('backend.setting_management.profile_page.partial_page.show_page.part_4b')
         <div class="profile-footer">
             <i class="fas fa-lock"></i>
             Your account information is securely managed by ProsharPOS.
         </div>
     </div>
 @stop



 @section('js')
     <script>
         $(document).ready(function() {
             $('#editProfileBtn').on('click', function(e) {
                 e.preventDefault();

                 Swal.fire({
                     title: 'Edit Your Profile?',
                     text: 'Would you like to update your account information?',
                     icon: 'question',
                     showCancelButton: true,
                     confirmButtonText: 'Yes, Edit Profile',
                     cancelButtonText: 'Cancel',
                     confirmButtonColor: '#d69e36',
                     cancelButtonColor: '#64748b',
                     reverseButtons: true
                 }).then((result) => {
                     if (result.isConfirmed) {
                         window.location.href = "{{ route('user_profile_edit') }}";
                     }
                 });
             });
         });
     </script>
 @stop
