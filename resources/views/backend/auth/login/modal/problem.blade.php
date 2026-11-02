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

            <button type="button" class="close-btn" onclick="closeProblemModal()">
                &times;
            </button>
        </div>

        <form id="problemReportForm"
              method="POST"
              action="{{ route('system_problem.store') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="problem-report-grid">

                {{-- LEFT: FORM DETAILS --}}
                <div class="problem-form-column">

                    <div class="problem-section-heading">
                        <span class="problem-section-number">01</span>
                        <div>
                            <h6>Problem details</h6>
                            <p>Describe the issue you're experiencing.</p>
                        </div>
                    </div>

                    {{-- Problem Title --}}
                    <div class="problem-field">
                        <label for="problem_title">
                            Problem Title <span>*</span>
                        </label>

                        <input type="text"
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

                    {{-- Problem Description --}}
                    <div class="problem-field problem-description-field">

                        <label for="problemDescriptionEditor">
                            Describe the Problem <span>*</span>
                        </label>

                        {{-- Description Editor --}}
                        <div class="problem-description-editor-wrapper">

                            {{-- Editor Toolbar --}}
                            <div class="problem-description-toolbar"
                                 role="toolbar"
                                 aria-label="Description formatting toolbar">

                                <div class="problem-toolbar-group">

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="bold"
                                            title="Bold"
                                            aria-label="Bold">
                                        <i class="fas fa-bold"></i>
                                    </button>

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="italic"
                                            title="Italic"
                                            aria-label="Italic">
                                        <i class="fas fa-italic"></i>
                                    </button>

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="underline"
                                            title="Underline"
                                            aria-label="Underline">
                                        <i class="fas fa-underline"></i>
                                    </button>

                                </div>

                                <span class="problem-toolbar-divider"></span>

                                <div class="problem-toolbar-group">

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="insertUnorderedList"
                                            title="Bulleted list"
                                            aria-label="Bulleted list">
                                        <i class="fas fa-list-ul"></i>
                                    </button>

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="insertOrderedList"
                                            title="Numbered list"
                                            aria-label="Numbered list">
                                        <i class="fas fa-list-ol"></i>
                                    </button>

                                </div>

                                <span class="problem-toolbar-divider"></span>

                                <div class="problem-toolbar-group">

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="justifyLeft"
                                            title="Align left"
                                            aria-label="Align left">
                                        <i class="fas fa-align-left"></i>
                                    </button>

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="justifyCenter"
                                            title="Align center"
                                            aria-label="Align center">
                                        <i class="fas fa-align-center"></i>
                                    </button>

                                    <button type="button"
                                            class="problem-toolbar-btn"
                                            data-command="justifyRight"
                                            title="Align right"
                                            aria-label="Align right">
                                        <i class="fas fa-align-right"></i>
                                    </button>

                                </div>

                            </div>

                            {{-- Content Editable Area --}}
                            <div id="problemDescriptionEditor"
                                 class="problem-description-editor"
                                 contenteditable="true"
                                 role="textbox"
                                 aria-multiline="true"
                                 aria-label="Describe the problem"
                                 data-placeholder="Explain what happened, what you expected, and what you actually experienced..."
                                 data-max-words="500"
                                 data-max-characters="5000"></div>

                            {{-- Hidden Field Submitted to Laravel --}}
                            <textarea name="problem_description"
                                      id="problem_description"
                                      class="problem-description-hidden"
                                      hidden
                                      required></textarea>

                        </div>

                        {{-- Description Counter --}}
                        <div class="problem-description-footer">

                            <small class="problem-description-hint">
                                <i class="fas fa-lightbulb"></i>
                                Explain the issue clearly. Avoid including sensitive information.
                            </small>

                            <div class="problem-description-counter">
                                <span>
                                    <strong id="problemDescriptionWordCount">0</strong>
                                    /500 words
                                </span>

                                <span>
                                    <strong id="problemDescriptionCount">0</strong>
                                    /5000 characters
                                </span>
                            </div>

                        </div>

                        <div class="problem-error"
                             data-error="problem_description"></div>

                    </div>

                    {{-- Priority --}}
                    <div class="problem-field">
                        <label for="problem_status">
                            Priority Level <span>*</span>
                        </label>

                        <select name="status"
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

                    {{-- Security Note --}}
                    <div class="problem-form-note">
                        <i class="fas fa-shield-alt"></i>
                        <span>
                            Your report and attachments will be stored securely.
                        </span>
                    </div>

                </div>

                {{-- RIGHT: ATTACHMENTS --}}
                <div class="problem-upload-column">

                    {{-- Scrollable Upload Content --}}
                    <div class="problem-upload-scroll">

                        <div class="problem-section-heading">
                            <span class="problem-section-number">02</span>
                            <div>
                                <h6>Attachments</h6>
                                <p>Upload screenshots or supporting documents.</p>
                            </div>
                        </div>

                        {{-- Upload Area --}}
                        <label for="problem_attachments"
                               class="problem-upload-zone">

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

                            <input type="file"
                                   id="problem_attachments"
                                   name="attachments[]"
                                   accept=".jpg,.jpeg,.png,.webp,.pdf,image/jpeg,image/png,image/webp,application/pdf"
                                   multiple
                                   hidden>
                        </label>

                        {{-- Upload Rules --}}
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

                        {{-- Selected Files Preview --}}
                        <div class="problem-preview-section">

                            <div class="problem-preview-heading">
                                <h6>Selected files</h6>
                                <span id="problemFileCount">0 files</span>
                            </div>

                            <div id="problemFilePreview"
                                 class="problem-file-preview">

                                <div class="problem-empty-files">
                                    <i class="far fa-folder-open"></i>
                                    <p>No attachments selected</p>
                                </div>

                            </div>

                        </div>

                        {{-- Upload Progress --}}
                        <div class="problem-progress-section"
                             id="problemProgressSection">

                            <div class="problem-progress-heading">
                                <h6>Upload progress</h6>
                                <span id="problemProgressPercent">0%</span>
                            </div>

                            <div class="problem-progress-track">
                                <div id="problemProgressBar"
                                     class="problem-progress-bar">
                                </div>
                            </div>

                            <div class="problem-progress-info">
                                <span id="problemProgressStatus">
                                    Waiting for upload
                                </span>

                                <span id="problemProgressSize">
                                    0 / 0 MB
                                </span>
                            </div>

                            <div id="problemProgressList"
                                 class="problem-progress-list">
                            </div>

                        </div>

                        <div class="problem-error"
                             data-error="attachments"></div>

                    </div>

                    {{-- RIGHT COLUMN FOOTER --}}
                    <div class="problem-upload-footer">

                        <div class="problem-footer-info">
                            <i class="fas fa-info-circle"></i>
                            <span>Fields marked with * are required.</span>
                        </div>

                        <div class="problem-footer-actions">

                            <button type="button"
                                    class="problem-cancel-btn"
                                    onclick="closeProblemModal()">
                                Cancel
                            </button>

                            <button type="submit"
                                    id="problemSubmitButton"
                                    class="problem-submit-btn">

                                <i class="fas fa-paper-plane"></i>

                                <span>Submit Problem</span>

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Form Message --}}
            <div id="problemFormMessage"
                 class="problem-form-message">
            </div>

        </form>

    </div>
</div>