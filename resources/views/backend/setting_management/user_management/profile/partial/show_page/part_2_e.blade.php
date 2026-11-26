<section class="profile-sidebar-card profile-reveal">
    <div class="profile-sidebar-heading">
        <i class="fas fa-bolt"></i>
        <h5>Quick Actions</h5>
    </div>

    <div class="profile-quick-actions">
        <a href="{{ route('user_profile_edit') }}" class="profile-quick-action" id="quickEditProfileBtn">
            <span class="profile-quick-icon edit">
                <i class="fas fa-user-edit"></i>
            </span>

            <span>
                <strong>Edit Profile</strong>
                <small>Update personal details</small>
            </span>

            <i class="fas fa-chevron-right"></i>
        </a>

        <a href="{{ route('user_profile_edit') }}" class="profile-quick-action">
            <span class="profile-quick-icon security">
                <i class="fas fa-lock"></i>
            </span>

            <span>
                <strong>Account Security</strong>
                <small>Manage your account details</small>
            </span>

            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
</section>
