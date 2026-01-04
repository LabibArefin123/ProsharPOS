 <!-- RIGHT SIDE : LOGIN -->
 <div class="col-lg-6">
     <div class="p-4 p-md-5">

         <h4 class="fw-bold mb-1">Welcome Back</h4>
         <p class="text-muted small mb-4">
             Login to manage your business smarter
         </p>

         {{-- Error --}}
         @if (session('error'))
             <div class="alert alert-danger small">
                 <i class="fas fa-circle-exclamation me-1"></i>
                 {{ session('error') }}
             </div>
         @endif

         <form method="POST" action="{{ route('login') }}">
             @csrf

             <!-- Login -->
             <div class="mb-3">
                 <label class="form-label fw-semibold small">Email / Username</label>
                 <div class="input-group input-group-lg shadow-sm">
                     <span class="input-group-text bg-white border-end-0">
                         <i class="fas fa-user text-muted"></i>
                     </span>
                     <input type="text" name="login"
                         class="form-control border-start-0 @error('login') is-invalid @enderror"
                         placeholder="Enter email or username" value="{{ old('login') }}" required autofocus>
                 </div>
                 @error('login')
                     <div class="text-danger small mt-1">{{ $message }}</div>
                 @enderror
             </div>

             <!-- Password -->
             <div class="mb-4">
                 <label class="form-label fw-semibold small">Password</label>
                 <div class="input-group input-group-lg shadow-sm">
                     <span class="input-group-text bg-white border-end-0">
                         <i class="fas fa-lock text-muted"></i>
                     </span>
                     <input type="password" name="password"
                         class="form-control border-start-0 @error('password') is-invalid @enderror"
                         placeholder="Enter password" required>
                 </div>
                 @error('password')
                     <div class="text-danger small mt-1">{{ $message }}</div>
                 @enderror
             </div>

             <!-- Actions -->
             <div class="d-flex justify-content-between align-items-center">
                 <button type="submit" class="btn btn-success btn-lg rounded-pill px-4 shadow">
                     <i class="fas fa-sign-in-alt me-1"></i> Login
                 </button>

                 @if (Route::has('password.request'))
                     <a href="#" id="forgotPasswordLink" class="small fw-semibold text-decoration-none">
                         Forgot Password?
                     </a>
                 @endif
             </div>
         </form>

         <!-- Helpdesk -->
         <div class="row g-2 mt-4">
             <div class="col-6">
                 <div class="card border-0 shadow-sm text-center">
                     <div class="card-body py-2">
                         <a href="#" id="callHelpdesk" class="small text-decoration-none">
                             📞 01776197999
                         </a>
                     </div>
                 </div>
             </div>
             <div class="col-6">
                 <div class="card border-0 shadow-sm text-center">
                     <div class="card-body py-2">
                         <a href="#" id="emailHelpdesk" class="small text-decoration-none">
                             📧 Email Support
                         </a>
                     </div>
                 </div>
             </div>
         </div>

     </div>
 </div>
