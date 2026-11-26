<section class="profile-edit-card profile-edit-reveal">
    <div class="profile-edit-section-heading">
        <div class="profile-edit-section-icon picture">
            <i class="fas fa-image"></i>
        </div>

        <div>
            <h5>Profile Picture</h5>
            <p>Choose a professional image for your account.</p>
        </div>
    </div>

    <div class="profile-picture-upload">
        <div class="profile-picture-preview">
            <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('uploads/images/default.jpg') }}"
                id="profileImagePreviewSecondary" alt="Profile preview">
        </div>

        <div class="profile-picture-upload-content">

            <label for="profile_picture" class="profile-picture-upload-btn">
                <i class="fas fa-cloud-upload-alt"></i>
                Choose Image
            </label>

            <input type="file" name="profile_picture" id="profile_picture"
                class="d-none @error('profile_picture') is-invalid @enderror"
                accept="image/jpeg,image/png,image/jpg,image/webp">

            <p>JPG, JPEG, PNG or WEBP. Follow your server's upload size limit.</p>

            <span id="profileImageFileName">
                No new image selected
            </span>

            @error('profile_picture')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</section>
