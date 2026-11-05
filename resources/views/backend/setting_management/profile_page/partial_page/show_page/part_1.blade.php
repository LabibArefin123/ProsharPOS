  <div class="profile-hero">
      <div class="profile-hero-decoration"></div>

      <div class="profile-hero-content">
          <div class="profile-avatar-wrapper">
              <img src="{{ $user->adminlte_image() }}" class="profile-avatar" alt="{{ $user->name }}">
              <span class="profile-avatar-status"></span>
          </div>

          <div class="profile-hero-details">
              <span class="profile-welcome-label">
                  <i class="fas fa-shield-alt"></i>
                  PROSHARPOS ACCOUNT
              </span>

              <h2>{{ $user->name }}</h2>

              <p>
                  <i class="fas fa-envelope"></i>
                  {{ $user->email }}
              </p>

              <div class="profile-hero-badges">
                  <span class="profile-role-badge">
                      <i class="fas fa-user-tag"></i>
                      {{ $user->getRoleNames()->first() ?? 'No Role Assigned' }}
                  </span>

                  <span class="profile-member-badge">
                      <i class="fas fa-check-circle"></i>
                      Account Information
                  </span>
              </div>
          </div>
      </div>
  </div>
