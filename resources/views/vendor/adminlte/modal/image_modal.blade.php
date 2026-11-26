{{-- GLOBAL IMAGE VIEW MODAL --}}
<div class="modal fade" id="global_image" tabindex="-1" aria-labelledby="globalImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered global-image-dialog">
        <div class="modal-content global-image-modal-content">
            {{-- TOOLBAR --}}
            <div class="global-image-toolbar">

                <div class="global-image-toolbar-left">
                    <span class="global-image-toolbar-label">
                        <i class="fas fa-image"></i>
                        IMAGE VIEWER
                    </span>
                </div>

                <div class="global-image-toolbar-actions">

                    <button type="button" class="global-image-info-btn" id="globalImageInfoToggle"
                        aria-label="Show image information" aria-expanded="false" title="Image information">
                        <i class="fas fa-info"></i>
                    </button>

                    <button type="button" class="global-image-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>

                </div>

            </div>

            {{-- MODAL BODY --}}
            <div class="global-image-layout">

                {{-- IMAGE VIEW --}}
                <div class="global-image-main">

                    <div class="global-image-wrapper">

                        <div class="global-image-loading" id="globalImageLoading">
                            <span class="global-image-spinner"></span>
                            <span>Loading image...</span>
                        </div>

                        <div class="global-image-error" id="globalImageError">
                            <i class="fas fa-image"></i>
                            <span>Unable to load this image.</span>
                        </div>

                        <img src="" alt="Image Preview" id="globalImagePreview" class="global-image-preview">

                    </div>

                    <div class="global-image-caption" id="globalImageCaption"></div>

                </div>

                {{-- INFORMATION PANEL --}}
                <aside class="global-image-info-panel" id="globalImageInfoPanel" aria-hidden="true">

                    <div class="global-image-info-header">
                        <div>
                            <span class="global-image-info-eyebrow">
                                IMAGE DETAILS
                            </span>
                            <h5>Properties</h5>
                        </div>

                        <button type="button" class="global-image-info-close" id="globalImageInfoClose"
                            aria-label="Close image information">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="global-image-info-body">

                        <div class="global-image-info-preview">
                            <img src="" id="globalImageInfoThumbnail" alt="Image thumbnail">
                        </div>

                        <div class="global-image-info-item">
                            <span class="global-image-info-label">
                                File name
                            </span>
                            <strong id="globalImageInfoName">—</strong>
                        </div>

                        <div class="global-image-info-item">
                            <span class="global-image-info-label">
                                Image type
                            </span>
                            <strong id="globalImageInfoType">—</strong>
                        </div>

                        <div class="global-image-info-item">
                            <span class="global-image-info-label">
                                Dimensions
                            </span>
                            <strong id="globalImageInfoDimensions">—</strong>
                        </div>

                        <div class="global-image-info-item">
                            <span class="global-image-info-label">
                                Orientation
                            </span>
                            <strong id="globalImageInfoOrientation">—</strong>
                        </div>

                        <div class="global-image-info-item">
                            <span class="global-image-info-label">
                                Aspect ratio
                            </span>
                            <strong id="globalImageInfoRatio">—</strong>
                        </div>

                        <div class="global-image-info-item">
                            <span class="global-image-info-label">
                                File size
                            </span>
                            <strong id="globalImageInfoSize">Checking...</strong>
                        </div>

                        <div class="global-image-info-path">
                            <span class="global-image-info-label">
                                Image path
                            </span>

                            <div class="global-image-path-value">
                                <code id="globalImageInfoPath">—</code>

                                <button type="button" id="globalImageCopyPath" title="Copy image path"
                                    aria-label="Copy image path">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</div>
