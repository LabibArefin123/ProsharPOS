<div class="card setting-section-card" id="backup">

    <div class="card-header">
        <button class="setting-section-header w-100 border-0 bg-transparent" type="button" data-bs-toggle="collapse"
            data-bs-toggle="collapse" data-bs-target="#backupSettings" role="button" aria-expanded="false"
            aria-controls="backupSettings">

            <div class="setting-section-title">
                <span class="setting-section-label">DATA & SYSTEM HEALTH</span>
                <h5>Backup & Maintenance</h5>
                <p>Protect your data and manage system availability.</p>
            </div>

            <span class="setting-collapse-icon">
                <i class="fas fa-chevron-down"></i>
            </span>
        </button>
    </div>

    <div id="backupSettings" class="collapse" aria-labelledby="backupHeading" data-bs-parent="#settingsAccordion">

        <div class="card-body">

            <ul class="list-group setting-list">

                <li class="list-group-item">
                    <a href="{{ route('settings.database.backup') }}" class="setting-item-link">

                        <span class="setting-item-icon backup-icon">
                            <i class="fas fa-database"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>System Backup</strong>
                            <small>Create, download and schedule automatic database backups.</small>
                        </span>

                        <span class="setting-item-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </li>

                <li class="list-group-item">
                    <a href="{{ route('settings.maintenance') }}" class="setting-item-link">

                        <span class="setting-item-icon backup-icon">
                            <i class="fas fa-tools"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Maintenance Mode</strong>
                            <small>Enable or disable maintenance mode and configure a custom message.</small>
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
