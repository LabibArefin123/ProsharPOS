<div class="card setting-section-card" id="system">

    <div class="card-header">
        <button class="setting-section-header w-100 border-0 bg-transparent" type="button" data-bs-toggle="collapse"
            data-bs-toggle="collapse" data-bs-target="#systemSettings" role="button" aria-expanded="false"
            aria-controls="systemSettings">

            <div class="setting-section-title">
                <span class="setting-section-label">GENERAL CONFIGURATION</span>
                <h5>System Settings</h5>
                <p>Configure language, regional preferences and system time.</p>
            </div>

            <span class="setting-collapse-icon">
                <i class="fas fa-chevron-down"></i>
            </span>
        </button>
    </div>

    <div id="systemSettings" class="collapse" aria-labelledby="systemHeading" data-bs-parent="#settingsAccordion">

        <div class="card-body">

            <ul class="list-group setting-list">

                <li class="list-group-item">
                    <a href="{{ route('settings.language') }}" class="setting-item-link">

                        <span class="setting-item-icon system-icon">
                            <i class="fas fa-language"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Language Settings</strong>
                            <small>Change the system language, such as Bangla or English.</small>
                        </span>

                        <span class="setting-item-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </li>

                <li class="list-group-item">
                    <a href="{{ route('settings.datetime') }}" class="setting-item-link">

                        <span class="setting-item-icon system-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Date & Time Settings</strong>
                            <small>Configure timezone, date format and time format.</small>
                        </span>

                        <span class="setting-item-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </li>

            </ul>

        </div>
    </div>
</div>
