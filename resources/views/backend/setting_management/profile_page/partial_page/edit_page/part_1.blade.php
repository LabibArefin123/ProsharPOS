<div class="profile-edit-hero">
    <div class="profile-edit-hero-decoration"></div>
    <div class="profile-edit-hero-content">
        <div class="profile-edit-avatar-wrapper">
            <img src="{{ $user->adminlte_image() }}" alt="{{ $user->name }}" class="profile-edit-avatar"
                id="profileAvatarPreview">
        </div>

        <div class="profile-edit-hero-info">
            <span>
                <i class="fas fa-user-circle"></i>
                PROFILE INFORMATION
            </span>

            <h3>{{ $user->name }}</h3>
            <p> {{ $user->email }} </p>

            <small>
                <i class="fas fa-shield-alt"></i>
                Update your account information securely.
            </small>
        </div>
    </div>
</div>
