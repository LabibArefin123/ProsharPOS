<div class="card setting-section-card" id="logs">

    <div class="card-header">
        <button class="setting-section-header w-100 border-0 bg-transparent" type="button" data-bs-toggle="collapse"
            data-bs-toggle="collapse" data-bs-target="#logSettings" role="button" aria-expanded="false"
            aria-controls="logSettings">

            <div class="setting-section-title">
                <span class="setting-section-label">MONITORING & DIAGNOSTICS</span>
                <h5>Log & Debug Settings</h5>
                <p>Review application errors and monitor system activity.</p>
            </div>

            <span class="setting-collapse-icon">
                <i class="fas fa-chevron-down"></i>
            </span>
        </button>
    </div>

    <div id="logSettings" class="collapse" aria-labelledby="logsHeading" data-bs-parent="#settingsAccordion">

        <div class="card-body">

            <ul class="list-group setting-list">

                <li class="list-group-item">
                    <a href="{{ route('settings.logs') }}" class="setting-item-link">

                        <span class="setting-item-icon logs-icon">
                            <i class="fas fa-file-alt"></i>
                        </span>

                        <span class="setting-item-content">
                            <strong>Error Log Viewer</strong>
                            <small>View, download and clear application error logs.</small>
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
