  <section class="profile-info-card profile-reveal">
      <div class="profile-card-heading">
          <div class="profile-card-heading-icon account">
              <i class="fas fa-id-card"></i>
          </div>

          <div>
              <h5>Account Information</h5>
              <p>Basic information about your account.</p>
          </div>
      </div>

      <div class="profile-information-grid">
          <div class="profile-information-item">
              <span class="profile-field-label">Account Name</span>
              <strong>{{ $user->name }}</strong>
          </div>

          @if ($user->created_at)
              <div class="profile-information-item">
                  <span class="profile-field-label">Member Since</span>
                  <strong>
                      {{ $user->created_at->format('d M Y') }}
                  </strong>
              </div>
          @endif

          @if ($user->created_at)
              <div class="profile-information-item">
                  <span class="profile-field-label">Account Created</span>
                  <strong>
                      {{ $user->created_at->diffForHumans() }}
                  </strong>
              </div>
          @endif
      </div>
  </section>
