 <!-- Start of Login / Logout -->
 <script>
     document.addEventListener("DOMContentLoaded", function() {

         // ✅ 1️⃣ Logout Confirmation
         const logoutButton = document.querySelector('a[href="#"][onclick*="logout-form"]');
         const logoutForm = document.getElementById('logout-form');

         if (logoutButton && logoutForm) {
             logoutButton.removeAttribute('onclick');
             logoutButton.addEventListener('click', function(e) {
                 e.preventDefault();
                 Swal.fire({
                     title: 'Are you sure you want to log out?',
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes, log out',
                     cancelButtonText: 'Cancel'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         // Slight delay to ensure session flash persists properly
                         setTimeout(() => logoutForm.submit(), 200);
                     }
                 });
             });
         }

         // ✅ 2️⃣ Show alerts based on session (AFTER page reload)
         @if (session()->has('login_success'))
             setTimeout(() => {
                 Swal.fire({
                     icon: 'success',
                     title: 'Welcome back!',
                     text: '{{ session('login_success') }}',
                     timer: 2500,
                     showConfirmButton: false
                 });
             }, 300);
         @endif

         @if (session()->has('logout_success'))
             setTimeout(() => {
                 Swal.fire({
                     icon: 'info',
                     title: 'Logged Out',
                     text: '{{ session('logout_success') }}',
                     confirmButtonColor: '#3085d6',
                     confirmButtonText: 'OK'
                 });
             }, 300);
         @endif

         // ✅ 3️⃣ Invalid Login Alert (Optional)
         @if (session()->has('login_error'))
             setTimeout(() => {
                 Swal.fire({
                     icon: 'error',
                     title: 'Login Failed',
                     text: '{{ session('login_error') }}',
                     confirmButtonColor: '#d33'
                 });
             }, 300);
         @endif
     });
 </script>
 <!-- End of Login / Logout -->
