<div class="card setting-section-card" id="ui">
    <div class="card-header">
        <button class="setting-section-header w-100 border-0 bg-transparent" type="button" data-bs-toggle="collapse"
            data-bs-toggle="collapse" data-bs-target="#uiSettings" role="button" aria-expanded="false"
            aria-controls="uiSettings">

            <div class="setting-section-title">
                <span class="setting-section-label">APPEARANCE & EXPERIENCE</span>
                <h5>UI Settings</h5>
                <p>Personalize the appearance and navigation of your workspace.</p>
            </div>

            <span class="setting-collapse-icon">
                <i class="fas fa-chevron-down"></i>
            </span>
        </button>
    </div>

    <div id="uiSettings" class="collapse" aria-labelledby="uiHeading" data-bs-parent="#settingsAccordion">

        <div class="card-body">

            <ul class="list-group setting-list">

                <li class="list-group-item">
                    <a href="{{ route('settings.theme') }}" class="setting-item-link">

                        <span class="setting-item-icon ui-icon">
                            <i class="fas fa-palette"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Theme Mode</strong>
                            <small>Customize the interface with Light, Dark or custom colors.</small>
                        </span>

                        <span class="setting-item-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </li>

                <li class="list-group-item setting-info-item">
                    <span class="setting-item-icon ui-icon">
                        <i class="fas fa-columns"></i>
                    </span>

                    <span class="setting-item-content">
                        <strong>Sidebar Settings</strong>
                        <small>Configure sidebar default collapse behavior and icon visibility.</small>
                    </span>
                </li>

            </ul>

        </div>
    </div>
</div>
