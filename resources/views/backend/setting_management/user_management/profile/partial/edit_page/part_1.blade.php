<section class="profile-edit-hero profile-edit-reveal">
    <div class="profile-edit-hero-decoration"></div>
    <div class="profile-edit-hero-content">
        <div class="profile-edit-avatar-wrapper">
            <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('uploads/images/default.jpg') }}"
                id="profileImagePreview" class="profile-edit-avatar" alt="Current profile picture">

            <span class="profile-edit-avatar-badge">
                <i class="fas fa-camera"></i>
            </span>
        </div>

        <div class="profile-edit-hero-info">
            <span class="profile-edit-hero-label">
                <i class="fas fa-shield-alt"></i>
                PROFILE SETTINGS
            </span>

            <h2>{{ $user->name }}</h2>

            <p>
                <i class="fas fa-at"></i>
                {{ $user->username ?: 'Username not provided' }}
            </p>

            <span class="profile-edit-hero-hint">
                Update your information to keep your account current.
            </span>
        </div>
    </div>
</section>
