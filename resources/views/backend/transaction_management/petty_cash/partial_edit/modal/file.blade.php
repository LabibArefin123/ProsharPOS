 <div class="modal fade" id="attachmentModalEdit" tabindex="-1">
     <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">

             <div class="modal-header">
                 <h5 class="modal-title">Update Attachment</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal">
                 </button>
             </div>

             <div class="modal-body">
                 <div class="row align-items-center">

                     <!-- LEFT SIDE (Progress Section) -->
                     <div class="col-md-5 text-center border-end">

                         <div class="position-relative d-inline-block mt-3">
                             <svg width="160" height="160">
                                 <circle cx="80" cy="80" r="70" stroke="#eee" stroke-width="10"
                                     fill="none" />

                                 <circle id="progressCircleEdit" cx="80" cy="80" r="70" stroke="#0d6efd"
                                     stroke-width="10" fill="none" stroke-dasharray="440" stroke-dashoffset="440"
                                     transform="rotate(-90 80 80)" />
                             </svg>

                             <div id="progressTextEdit"
                                 style="position:absolute;
                                        top:50%;
                                        left:50%;
                                        transform:translate(-50%,-50%);
                                        font-size:22px;
                                        font-weight:bold;">
                                 0%
                             </div>
                         </div>

                         <div class="mt-4" id="fileInfoEdit">
                             [ Only PDF allowed | Max 5MB ]
                         </div>

                         <button class="btn btn-success mt-3" id="chooseFileBtnEdit">
                             Choose PDF
                         </button>

                     </div>

                     <!-- RIGHT SIDE (PDF Preview) -->
                     <div class="col-md-7">

                         <div
                             style="height:400px;
                                    overflow-y:auto;
                                    border:1px solid #ddd;
                                    border-radius:8px;
                                    padding:10px;">

                             <div id="previewAreaEdit" class="text-muted text-center">
                                 PDF preview will appear here
                             </div>

                         </div>

                     </div>

                 </div>
             </div>

         </div>
     </div>
 </div>
