<section class="profile-info-card profile-reveal">
    <div class="profile-card-heading">
        <div class="profile-card-heading-icon contact">
            <i class="fas fa-address-book"></i>
        </div>

        <div>
            <h5>Contact Information</h5>
            <p>Your registered contact details.</p>
        </div>
    </div>

    <div class="profile-information-grid">
        <div class="profile-information-item">
            <span class="profile-field-label">Primary Phone</span>
            <div class="profile-copy-value">
                <strong> {{ $user->phone ?: 'Not Provided' }} </strong>

                @if ($user->phone)
                    <button type="button" class="profile-copy-btn" data-copy="{{ $user->phone }}" title="Copy phone">
                        <i class="far fa-copy"></i>
                    </button>
                @endif
            </div>
        </div>

        <div class="profile-information-item">
            <span class="profile-field-label">Alternative Phone</span>
            <div class="profile-copy-value">
                <strong> {{ $user->phone_2 ?: 'Not Provided' }}</strong>
                @if ($user->phone_2)
                    <button type="button" class="profile-copy-btn" data-copy="{{ $user->phone_2 }}"
                        title="Copy alternative phone">
                        <i class="far fa-copy"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</section>
