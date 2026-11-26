<section class="profile-edit-card profile-edit-reveal">
    <div class="profile-edit-section-heading">
        <div class="profile-edit-section-icon personal">
            <i class="fas fa-user"></i>
        </div>

        <div>
            <h5>Personal Information</h5>
            <p>Update your name and account identity.</p>
        </div>
    </div>

    <div class="profile-edit-fields-grid">
        <div class="profile-edit-field">
            <label for="name">
                Full Name <span>*</span>
            </label>

            <div class="profile-edit-input-wrapper">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}"
                    placeholder="Enter your full name" autocomplete="name">
            </div>

            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-edit-field">
            <label for="username">
                Username <span>*</span>
            </label>

            <div class="profile-edit-input-wrapper">
                <i class="fas fa-at input-icon"></i>
                <input type="text" name="username" id="username"
                    class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username', $user->username) }}" placeholder="Enter your username"
                    autocomplete="username">
            </div>

            @error('username')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-edit-field full-width">
            <label for="email">
                Email Address <span>*</span>
            </label>

            <div class="profile-edit-input-wrapper">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                    placeholder="Enter your email address" autocomplete="email">
            </div>

            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

    </div>
</section>
