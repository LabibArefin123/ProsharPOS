  <div class="modal fade" id="imageUploadModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

              <div class="modal-header bg-info">
                  <h5 class="modal-title">Upload Storage Image</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                  <div class="row">

                      {{-- LEFT: Circular Progress & Status --}}
                      <div class="col-md-5 border-right text-center">
                          <svg id="progressCircle" width="120" height="120">
                              <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10"
                                  fill="none"></circle>
                              <circle id="progressCircleBar" cx="60" cy="60" r="50" stroke="#17a2b8"
                                  stroke-width="10" fill="none" stroke-dasharray="314" stroke-dashoffset="314"
                                  transform="rotate(-90 60 60)"></circle>
                              <text x="60" y="65" text-anchor="middle" font-size="14" fill="#000"
                                  id="progressText">0%</text>
                          </svg>

                          <div class="mt-3">
                              <p><strong>Status:</strong></p>
                              <div id="uploadStatus" class="text-muted">Waiting for image...</div>
                              <hr>
                              <p><strong>Image Info:</strong></p>
                              <small>
                                  Size: <span id="imageSize">-</span><br>
                                  Format: <span id="imageFormat">-</span><br>
                                  Dimension: <span id="imageDimension">-</span>
                              </small>
                          </div>
                      </div>

                      {{-- RIGHT: File Input + Preview --}}
                      <div class="col-md-7 text-center">
                          <input type="file" name="image_file" id="imageInput" class="form-control-file mb-3"
                              accept="image/*">
                          <div id="previewContainer" style="min-height:150px;">
                              <img id="imagePreview" src="#" alt="Preview"
                                  class="img-fluid img-thumbnail d-none">
                          </div>
                      </div>

                  </div>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-success" id="useImageBtn" data-dismiss="modal">Use This
                      Image</button>
              </div>

          </div>
      </div>
  </div>
