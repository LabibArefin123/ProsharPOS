 <section class="profile-hero profile-reveal">
     <div class="profile-hero-decoration"></div>
     <div class="profile-hero-content">
         <div class="profile-avatar-wrapper">
             <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('uploads/images/default.jpg') }}"
                 class="profile-avatar" alt="{{ $user->name }}"
                 onerror="this.onerror=null;this.src='{{ asset('uploads/images/default.jpg') }}';">

             <span class="profile-avatar-status" title="Account profile"></span>
         </div>

         <div class="profile-hero-info">
             <span class="profile-account-label">
                 <i class="fas fa-shield-alt"></i>
                 ACCOUNT PROFILE
             </span>

             <h2>{{ $user->name }}</h2>

             <p>
                 <i class="fas fa-at"></i>
                 {{ $user->username ?: 'Username not provided' }}
             </p>

             <div class="profile-hero-tags">
                 <span>
                     <i class="fas fa-user-check"></i>
                     Personal Account
                 </span>

                 <span>
                     <i class="fas fa-envelope"></i>
                     {{ $user->email }}
                 </span>
             </div>
         </div>

         <div class="profile-hero-action">
             <a href="{{ route('user_profile_edit') }}" class="profile-hero-edit" id="heroEditProfileBtn">
                 <i class="fas fa-edit"></i>
                 Edit Details
             </a>
         </div>
     </div>

     <div class="profile-hero-footer">
         <div>
             <span class="profile-footer-label">Profile overview</span>
             <strong>Your account information</strong>
         </div>

         <div class="profile-completion">
             <div class="profile-completion-info">
                 <span>Profile completion</span>
                 <strong>{{ $profileCompletion }}%</strong>
             </div>

             <div class="profile-progress-track">
                 <div class="profile-progress-bar" data-progress="{{ $profileCompletion }}">
                 </div>
             </div>
         </div>
     </div>
 </section>
