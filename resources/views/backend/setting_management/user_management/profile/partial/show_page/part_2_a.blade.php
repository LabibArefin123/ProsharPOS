 <section class="profile-info-card profile-reveal">
     <div class="profile-card-heading">
         <div class="profile-card-heading-icon personal">
             <i class="fas fa-user"></i>
         </div>

         <div>
             <h5>Personal Information</h5>
             <p>Your basic account identity details.</p>
         </div>
     </div>

     <div class="profile-information-grid">

         <div class="profile-information-item">
             <span class="profile-field-label">Full Name</span>
             <strong>{{ $user->name ?: 'Not Provided' }}</strong>
         </div>

         <div class="profile-information-item">
             <span class="profile-field-label">Username</span>
             <strong>{{ $user->username ?: 'Not Provided' }}</strong>
         </div>

         <div class="profile-information-item">
             <span class="profile-field-label">Email Address</span>
             <div class="profile-copy-value">
                 <strong>{{ $user->email ?: 'Not Provided' }}</strong>

                 @if ($user->email)
                     <button type="button" class="profile-copy-btn" data-copy="{{ $user->email }}" title="Copy email">
                         <i class="far fa-copy"></i>
                     </button>
                 @endif
             </div>
         </div>
     </div>
 </section>
