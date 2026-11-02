{{-- SYSTEM PROBLEM MODAL --}}
<div id="problemModal" class="problem-modal">
    <div class="problem-modal-content problem-report-modal">

        {{-- Modal Header --}}
        <div class="problem-modal-header">
            <div>
                <span class="problem-header-label">SUPPORT CENTER</span>
                <h5>Report a System Problem</h5>
                <p>Tell us what happened. We'll look into it.</p>
            </div>

            <button type="button"
                class="close-btn"
                onclick="closeProblemModal()">
                &times;
            </button>
        </div>

        <form
            id="problemReportForm"
            method="POST"
            action="{{ route('system_problem.store') }}"
            enctype="multipart/form-data">

            @csrf

            <div class="problem-report-grid">

                {{-- LEFT: FORM --}}
                <div class="problem-form-column">

                    <div class="problem-section-heading">
                        <span class="problem-section-number">01</span>
                        <div>
                            <h6>Problem details</h6>
                            <p>Describe the issue you're experiencing.</p>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="problem-field">
                        <label for="problem_title">
                            Problem Title <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="problem_title"
                            id="problem_title"
                            class="form-control"
                            placeholder="Example: Login not working"
                            maxlength="150"
                            required>

                        <small class="problem-field-hint">
                            Keep the title short and clear.
                        </small>

                        <div class="problem-error" data-error="problem_title"></div>
                    </div>

                    {{-- Description --}}
                    <div class="problem-field">
                        <label for="problem_description">
                            Describe the Problem <span>*</span>
                        </label>

                        <textarea
                            name="problem_description"
                            id="problem_description"
                            class="form-control"
                            rows="5"
                            maxlength="5000"
                            placeholder="Explain what happened, what you expected, and what you actually experienced..."
                            required></textarea>

                        <div class="problem-description-footer">
                            <small>Provide as much detail as possible.</small>
                            <small>
                                <span id="problemDescriptionCount">0</span>/5000
                            </small>
                        </div>

                        <div class="problem-error" data-error="problem_description"></div>
                    </div>

                    {{-- Priority --}}
                    <div class="problem-field">
                        <label for="problem_status">
                            Priority Level <span>*</span>
                        </label>

                        <select
                            name="status"
                            id="problem_status"
                            class="form-control"
                            required>

                            <option value="low">Low - Minor issue</option>
                            <option value="medium" selected>Medium - Normal issue</option>
                            <option value="high">High - Important issue</option>
                            <option value="critical">Critical - Urgent issue</option>
                        </select>

                        <div class="problem-error" data-error="status"></div>
                    </div>

                    <div class="problem-form-note">
                        <i class="fas fa-shield-alt"></i>
                        Your report and attachments will be stored securely.
                    </div>

                </div>

                {{-- RIGHT: FILE UPLOAD --}}
                <div class="problem-upload-column">

                    <div class="problem-section-heading">
                        <span class="problem-section-number">02</span>
                        <div>
                            <h6>Attachments</h6>
                            <p>Upload screenshots or supporting documents.</p>
                        </div>
                    </div>

                    {{-- Upload Area --}}
                    <label for="problem_attachments" class="problem-upload-zone">
                        <div class="problem-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>

                        <h6>Choose images or PDF files</h6>

                        <p>
                            Click to browse or select multiple files
                        </p>

                        <span>
                            JPG, PNG, WEBP, PDF
                        </span>

                        <input
                            type="file"
                            id="problem_attachments"
                            name="attachments[]"
                            accept=".jpg,.jpeg,.png,.webp,.pdf,image/jpeg,image/png,image/webp,application/pdf"
                            multiple
                            hidden>
                    </label>

                    <div class="problem-upload-rules">
                        <div>
                            <i class="far fa-image"></i>
                            <span>Images: Maximum 5 MB each</span>
                        </div>

                        <div>
                            <i class="far fa-file-pdf"></i>
                            <span>PDF: Maximum 10 MB each</span>
                        </div>

                        <div>
                            <i class="fas fa-ruler-combined"></i>
                            <span>Images: 300 × 200 to 5000 × 5000 px</span>
                        </div>

                        <div>
                            <i class="fas fa-paperclip"></i>
                            <span>Maximum 8 attachments</span>
                        </div>
                    </div>

                    {{-- Preview --}}
                    <div class="problem-preview-section">
                        <div class="problem-preview-heading">
                            <h6>Selected files</h6>
                            <span id="problemFileCount">0 files</span>
                        </div>

                        <div id="problemFilePreview" class="problem-file-preview">
                            <div class="problem-empty-files">
                                <i class="far fa-folder-open"></i>
                                <p>No attachments selected</p>
                            </div>
                        </div>
                    </div>

                    {{-- Progress --}}
                    <div class="problem-progress-section" id="problemProgressSection">

                        <div class="problem-progress-heading">
                            <h6>Upload progress</h6>
                            <span id="problemProgressPercent">0%</span>
                        </div>

                        <div class="problem-progress-track">
                            <div
                                id="problemProgressBar"
                                class="problem-progress-bar">
                            </div>
                        </div>

                        <div class="problem-progress-info">
                            <span id="problemProgressStatus">Waiting for upload</span>
                            <span id="problemProgressSize">0 / 0 MB</span>
                        </div>

                        <div id="problemProgressList" class="problem-progress-list">
                        </div>
                    </div>

                    <div class="problem-error" data-error="attachments"></div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="problem-modal-footer">

                <div class="problem-footer-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Fields marked with * are required.</span>
                </div>

                <div class="problem-footer-actions">
                    <button
                        type="button"
                        class="problem-cancel-btn"
                        onclick="closeProblemModal()">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        id="problemSubmitButton"
                        class="problem-submit-btn">

                        <i class="fas fa-paper-plane"></i>
                        <span>Submit Problem</span>
                    </button>
                </div>

            </div>

            <div id="problemFormMessage" class="problem-form-message"></div>

        </form>
    </div>
</div>