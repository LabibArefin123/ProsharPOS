 <section class="profile-sidebar-card profile-reveal">
     <div class="profile-sidebar-heading">
         <i class="fas fa-chart-pie"></i>
         <h5>Profile Strength</h5>
     </div>

     <div class="profile-strength-content">
         <div class="profile-strength-circle" data-completion="{{ $profileCompletion }}">
             <div class="profile-strength-inner">
                 <strong>{{ $profileCompletion }}%</strong>
                 <span>Complete</span>
             </div>
         </div>

         <p>
             @if ($profileCompletion === 100)
                 Excellent! Your profile information is complete.
             @elseif ($profileCompletion >= 70)
                 Your profile looks good. Complete the remaining details.
             @else
                 Add more information to make your profile complete.
             @endif
         </p>
     </div>

     <div class="profile-completion-checklist">
         <div class="{{ filled($user->name) ? 'completed' : '' }}">
             <i class="fas {{ filled($user->name) ? 'fa-check-circle' : 'fa-circle' }}"></i>
             Full name
         </div>

         <div class="{{ filled($user->username) ? 'completed' : '' }}">
             <i class="fas {{ filled($user->username) ? 'fa-check-circle' : 'fa-circle' }}"></i>
             Username
         </div>

         <div class="{{ filled($user->email) ? 'completed' : '' }}">
             <i class="fas {{ filled($user->email) ? 'fa-check-circle' : 'fa-circle' }}"></i>
             Email address
         </div>

         <div class="{{ filled($user->phone) ? 'completed' : '' }}">
             <i class="fas {{ filled($user->phone) ? 'fa-check-circle' : 'fa-circle' }}"></i>
             Phone number
         </div>

         <div class="{{ filled($user->phone_2) ? 'completed' : '' }}">
             <i class="fas {{ filled($user->phone_2) ? 'fa-check-circle' : 'fa-circle' }}"></i>
             Alternative phone
         </div>

         <div class="{{ filled($user->profile_picture) ? 'completed' : '' }}">
             <i class="fas {{ filled($user->profile_picture) ? 'fa-check-circle' : 'fa-circle' }}"></i>
             Profile picture
         </div>

     </div>

 </section>
