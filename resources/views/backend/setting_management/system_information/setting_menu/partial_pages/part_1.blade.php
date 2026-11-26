<div class="card setting-section-card" id="security">

    <div class="card-header">
        <button class="setting-section-header w-100 border-0 bg-transparent" type="button" data-bs-toggle="collapse"
            data-bs-target="#securitySettings" aria-expanded="true" aria-controls="securitySettings">
            <div class="setting-section-title">
                <span class="setting-section-label">ACCOUNT PROTECTION</span>
                <h5>Security Settings</h5>
                <p>Manage authentication and account security policies</p>
            </div>

            <span class="setting-collapse-icon" aria-hidden="true">
                <i class="fas fa-chevron-down"></i>
            </span>
        </button>
    </div>

    <div id="securitySettings" class="collapse show" aria-labelledby="securityHeading"
        data-bs-parent="#settingsAccordion">

        <div class="card-body">

            <ul class="list-group setting-list">

                <li class="list-group-item">
                    <a href="{{ route('settings.2fa') }}" class="setting-item-link">

                        <span class="setting-item-icon security-icon">
                            <i class="fas fa-shield-alt"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Two-Factor Authentication (2FA)</strong>
                            <small>Enable or disable 2FA and choose Email, SMS or App verification.</small>
                        </span>

                        <span class="setting-item-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </li>

                <li class="list-group-item">
                    <a href="{{ route('settings.password_policy') }}" class="setting-item-link">

                        <span class="setting-item-icon security-icon">
                            <i class="fas fa-key"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Password Policy</strong>
                            <small>Configure minimum length, symbols, numbers and password expiry.</small>
                        </span>

                        <span class="setting-item-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </li>

                <li class="list-group-item">
                    <a href="{{ route('settings.timeout') }}" class="setting-item-link">

                        <span class="setting-item-icon security-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Session Timeout / Auto Logout</strong>
                            <small>Automatically log out users after a period of inactivity.</small>
                        </span>

                        <span class="setting-item-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </li>

                <li class="list-group-item setting-info-item">
                    <span class="setting-item-icon security-icon">
                        <i class="fas fa-network-wired"></i>
                    </span>

                    <span class="setting-item-content">
                        <strong>IP Whitelist <span class="setting-optional-label">Optional</span></strong>
                        <small>Allow only specified IP addresses to access the admin panel.</small>
                    </span>

                    <span class="setting-coming-soon">Optional</span>
                </li>

            </ul>

        </div>
    </div>
</div>
