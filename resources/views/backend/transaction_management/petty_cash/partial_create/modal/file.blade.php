  <div class="modal fade" id="attachmentModal" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title">Upload Attachment</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                  <div class="row">

                      <!-- LEFT SIDE (Upload + Progress) -->
                      <div class="col-md-6 text-center">

                          <!-- Circle Progress -->
                          <div class="position-relative d-inline-block mt-3">
                              <svg width="150" height="150">
                                  <circle cx="75" cy="75" r="65" stroke="#eee" stroke-width="10"
                                      fill="none" />
                                  <circle id="progressCircle" cx="75" cy="75" r="65" stroke="#007bff"
                                      stroke-width="10" fill="none" stroke-dasharray="408" stroke-dashoffset="408"
                                      transform="rotate(-90 75 75)" />
                              </svg>
                              <div id="progressText"
                                  style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
                                 font-size:20px; font-weight:bold;">
                                  0%
                              </div>
                          </div>

                          <!-- File Info -->
                          <div class="mt-3">
                              <p id="fileInfo">[ No file selected ]</p>
                          </div>

                          <button class="btn btn-success mt-2" id="chooseFileBtn">
                              Choose File
                          </button>

                      </div>

                      <!-- RIGHT SIDE (Preview) -->
                      <div class="col-md-6">
                          <div style="height:300px; overflow-y:auto; border:1px solid #ddd; padding:10px;">
                              <div id="previewArea" class="text-center text-muted">
                                  Preview will appear here
                              </div>
                          </div>
                      </div>

                  </div>
              </div>

          </div>
      </div>
  </div>
