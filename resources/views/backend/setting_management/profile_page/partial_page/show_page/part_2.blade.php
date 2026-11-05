{{-- Account Information --}}
<div class="profile-section-heading">
    <div>
        <h4>Account Information</h4>
        <p>Your personal and account details</p>
    </div>
</div>

<div class="row profile-info-row">

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="profile-info-card">
            <div class="profile-info-icon icon-blue">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info-content">
                <span>Username</span>
                <h5>{{ $user->username ?? 'Not Provided' }}</h5>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="profile-info-card">
            <div class="profile-info-icon icon-purple">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="profile-info-content">
                <span>Email Address</span>
                <h5>{{ $user->email }}</h5>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="profile-info-card">
            <div class="profile-info-icon icon-green">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div class="profile-info-content">
                <span>Phone Number</span>
                <h5>{{ $user->phone ?? 'Not Provided' }}</h5>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="profile-info-card">
            <div class="profile-info-icon icon-orange">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="profile-info-content">
                <span>Account Role</span>
                <h5>{{ $user->getRoleNames()->first() ?? 'No Role Assigned' }}</h5>
            </div>
        </div>
    </div>

</div>
