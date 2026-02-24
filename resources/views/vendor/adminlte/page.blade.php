@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/logor.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!-- Toast Image Editor -->
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.min.css">

    <!-- Start of animation pop up notifcation -->
    <style>
        .animate-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .brand-link {
            text-decoration: none !important;
        }

        .brand-link span {
            text-decoration: none !important;
        }

        .normal-link {
            transition: all 0.2s ease-in-out;
        }

        .normal-link:hover {
            background-color: #f3e5f5;
            /* light purple hover */
            color: #5300b7;
            /* keep readable */
            text-decoration: none;
        }
    </style>
    <!-- End of animation pop up notifcation -->
@stop

<!-- start of language auto-translate -->
@if (session('app_locale') === 'bn')
    <script>
        document.addEventListener("DOMContentLoaded", async () => {

            async function freeGoogleTranslate(text) {
                const url =
                    "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=bn&dt=t&q=" +
                    encodeURIComponent(text);

                const res = await fetch(url);
                const data = await res.json();

                return data[0][0][0]; // translated text
            }

            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);

            let node;
            while (node = walker.nextNode()) {
                let original = node.nodeValue.trim();
                if (original.length < 2) continue;

                const translated = await freeGoogleTranslate(original);
                node.nodeValue = translated;
            }

        });
    </script>
@endif
<!-- end of language auto-translate -->


@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">
        <!-- start of modal validation -->
        {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/backend/admin/logo.JPG') }}"> --}}
        <div class="modal fade" id="backConfirmModal" tabindex="-1" role="dialog" aria-labelledby="backConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <!-- Animated Circle Icon -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce" width="50" height="50"
                            fill="#FFC107" viewBox="0 0 16 16">
                            <path
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-12a.905.905 0 0 1 .9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 3.995A.905.905 0 0 1 8 3zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z" />
                        </svg>
                    </div>

                    <!-- Modal Message -->
                    <div class="modal-body mb-3">
                        Please fill up the required fields before leaving the page. Do you want to leave?
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Stay</button>
                        <a href="#" class="btn btn-danger leave-page">Leave</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of modal animation -->

        <!-- start of create animation model -->
        <div class="modal fade" id="createConfirmModal" tabindex="-1" aria-labelledby="createConfirmLabel"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-4">

                    <!-- Close (X) Button -->
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                    <!-- Icon -->
                    <div class="mb-3 mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#28A745"
                            viewBox="0 0 16 16">
                            <path
                                d="M16 2a2 2 0 0 1-2 2h-1v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4H2a2 2 0 0 1 0-4h12a2 2 0 0 1 2 2zM5 4v10h6V4H5zm3 7.5a.5.5 0 0 1-.374-.832l1.5-1.5a.5.5 0 1 1 .707.707L8.707 10.5l1.126 1.126a.5.5 0 1 1-.707.707l-1.5-1.5A.5.5 0 0 1 8 11.5z" />
                        </svg>
                    </div>

                    <!-- Message -->
                    <div class="modal-body mb-3">
                        Are you sure you want to <strong>create</strong> this record?
                    </div>

                    <!-- Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2 border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-success">
                            Confirm
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of create animation model -->

        <!-- start of edit animation model -->
        <div class="modal fade" id="editConfirmModal" tabindex="-1" role="dialog" aria-labelledby="editConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <!-- Close (X) Button -->
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                    <!-- Animated Pencil Icon -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#17A2B8"
                            viewBox="0 0 16 16">
                            <path
                                d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.193 9.193a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l9.193-9.193zM11.207 2L3.5 9.707l-.793 2.121 2.121-.793L13.293 3 11.207 2z" />
                        </svg>
                    </div>

                    <!-- Message -->
                    <div class="modal-body mb-3">
                        Are you sure you want to <strong>update</strong> this record?
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Confirm</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of edit animation model -->

        <!-- start of delete animation model -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <!-- Close (X) Button -->
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                    
                    <!-- Animated Warning Icon -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce" width="50" height="50"
                            fill="#DC3545" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1 1 0 0 0-1.964 0L.165 13.233A1 1 0 0 0 1 14.5h14a1 1 0 0 0 .835-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z" />
                        </svg>
                    </div>

                    <!-- Message -->
                    <div class="modal-body mb-3">
                        Are you sure you want to <strong>delete</strong> this record? <br>
                        This action cannot be undone.
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="deleteForm" method="POST" action="#">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        {{-- Preloader Animation (fullscreen mode) --}}
        @if ($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if (!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @include('frontend.layouts.footer')
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    {{-- Jquery table format --}}
    <!-- Start of Login / Logout -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            console.log('JS LOADED');

            @if (session()->has('login_success'))
                console.log('LOGIN SUCCESS SESSION:', "{{ session('login_success') }}");
                Swal.fire({
                    icon: 'success',
                    title: 'Welcome back!',
                    text: "{{ session('login_success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            @if (session()->has('login_error'))
                console.log('LOGIN ERROR SESSION:', "{{ session('login_error') }}");
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: "{{ session('login_error') }}"
                });
            @endif

            @if (session()->has('logout_success'))
                console.log('LOGOUT SESSION:', "{{ session('logout_success') }}");
                Swal.fire({
                    icon: 'info',
                    title: 'Logged Out',
                    text: "{{ session('logout_success') }}"
                });
            @endif

        });
    </script>

    <!-- End of Login / Logout -->

    {{-- start of bangla-date --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // English → Bangla number map
            const engToBan = {
                '0': '০',
                '1': '১',
                '2': '২',
                '3': '৩',
                '4': '৪',
                '5': '৫',
                '6': '৬',
                '7': '৭',
                '8': '৮',
                '9': '৯'
            };

            // Month map (English → Bangla)
            const months = {
                'January': 'জানুয়ারি',
                'February': 'ফেব্রুয়ারি',
                'March': 'মার্চ',
                'April': 'এপ্রিল',
                'May': 'মে',
                'June': 'জুন',
                'July': 'জুলাই',
                'August': 'আগস্ট',
                'September': 'সেপ্টেম্বর',
                'October': 'অক্টোবর',
                'November': 'নভেম্বর',
                'December': 'ডিসেম্বর'
            };

            function convertToBanglaDate(text) {
                if (!text) return text;

                // Replace English numbers → Bangla
                let converted = text.replace(/[0-9]/g, d => engToBan[d]);

                // Replace English months → Bangla months
                for (const [en, bn] of Object.entries(months)) {
                    converted = converted.replace(en, bn);
                }

                return converted;
            }

            // Apply conversion to all elements with .bangla-date
            document.querySelectorAll(".bangla-date").forEach(function(el) {
                el.innerText = convertToBanglaDate(el.innerText.trim());
            });
        });
    </script>
    {{-- end of bangla-date --}}

    {{-- start of validation --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let isDirty = false;
            let lastBackHref = null;

            // Track changes on all forms
            document.querySelectorAll("form").forEach(form => {
                form.querySelectorAll("input, textarea, select").forEach(input => {
                    input.addEventListener("change", () => {
                        isDirty = true;
                    });
                });

                // Reset dirty flag on submit
                form.addEventListener("submit", () => {
                    isDirty = false;
                });
            });

            // Handle all back buttons
            document.querySelectorAll(".back-btn").forEach(btn => {
                btn.addEventListener("click", function(e) {
                    const href = btn.getAttribute("href");
                    if (isDirty) {
                        e.preventDefault();
                        lastBackHref = href; // save the target URL
                        $('#backConfirmModal').modal('show');
                    } else {
                        window.location.href = href;
                    }
                });
            });

            // Leave page from modal
            const leaveBtn = document.querySelector("#backConfirmModal .leave-page");
            leaveBtn.addEventListener("click", function() {
                if (lastBackHref) {
                    isDirty = false;
                    window.location.href = lastBackHref; // go to correct index page dynamically
                }
            });

            // Warn user if leaving by browser navigation
            window.addEventListener("beforeunload", function(e) {
                if (isDirty) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        });
    </script>
    {{-- end of validation --}}

    <!-- start of image editor -->
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.min.js"></script>
    <!--end of image editor -->

    <!-- start of image function for toast editor code -->
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('iconInput');
            const preview = document.getElementById('imagePreview');
            const iconDataInput = document.getElementById('iconData');

            // Create modal container for the editor (you can style this with CSS)
            let editorModal = document.createElement('div');
            editorModal.id = 'editorModal';
            editorModal.style.position = 'fixed';
            editorModal.style.top = '0';
            editorModal.style.left = '0';
            editorModal.style.width = '100vw';
            editorModal.style.height = '100vh';
            editorModal.style.backgroundColor = 'rgba(0,0,0,0.7)';
            editorModal.style.display = 'none';
            editorModal.style.justifyContent = 'center';
            editorModal.style.alignItems = 'center';
            editorModal.style.zIndex = '9999';

            // Inner container for editor and buttons
            editorModal.innerHTML = `
                    <div style="width: 80vw; height: 80vh; background: white; position: relative; display: flex; flex-direction: column;">
                    <div id="tuiImageEditorContainer" style="flex-grow: 1;"></div>
                    <div style="padding: 10px; text-align: right;">
                        <button id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
                        <button id="applyEditBtn" class="btn btn-primary">Apply</button>
                    </div>
                    </div>
                    `;

            document.body.appendChild(editorModal);

            let imageEditor = null;

            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Show modal
                    editorModal.style.display = 'flex';

                    // Initialize editor or reset if already exists
                    if (imageEditor) {
                        imageEditor.destroy();
                        imageEditor = null;
                    }

                    imageEditor = new tui.ImageEditor(document.getElementById(
                        'tuiImageEditorContainer'), {
                        includeUI: {
                            loadImage: {
                                path: e.target.result,
                                name: file.name,
                            },
                            theme: {}, // default theme
                            menu: [
                                'crop', 'resize', 'flip', 'rotate',
                                'draw', 'shape', 'icon', 'text', 'mask', 'filter'
                            ],
                            initMenu: 'crop',
                            menuBarPosition: 'bottom',
                        },
                        cssMaxWidth: 700,
                        cssMaxHeight: 500,
                        selectionStyle: {
                            cornerSize: 20,
                            rotatingPointOffset: 70,
                        },
                    });

                    // Remove the default "Download" button from UI
                    setTimeout(() => {
                        const downloadBtn = document.querySelector(
                            '.tui-image-editor-download-btn');
                        if (downloadBtn) {
                            downloadBtn.style.display = 'none';
                        }
                    }, 500);

                };
                reader.readAsDataURL(file);
            });

            // Cancel button closes modal, clears input, no change
            document.getElementById('cancelEditBtn').addEventListener('click', () => {
                editorModal.style.display = 'none';
                if (imageEditor) {
                    imageEditor.destroy();
                    imageEditor = null;
                }
                input.value = '';
            });

            // Apply button gets edited image and updates preview + hidden input
            document.getElementById('applyEditBtn').addEventListener('click', () => {
                if (!imageEditor) return;

                // Get dataURL (base64) of edited image
                const dataURL = imageEditor.toDataURL();

                // Set hidden input value and preview src
                iconDataInput.value = dataURL;
                preview.src = dataURL;

                // Close modal and destroy editor instance
                editorModal.style.display = 'none';
                imageEditor.destroy();
                imageEditor = null;
            });
        });
    </script> --}}
    <!-- end of image function for toast editor code -->

    <!-- start of image preview section -->
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('iconInput');
            const preview = document.getElementById('imagePreview');
            const iconDataInput = document.getElementById('iconData');
            const MAX_WIDTH = 800;
            const MAX_HEIGHT = 800;

            // Resize image and remove background (white) before preview and submit
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        // Create canvas to resize and remove background
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        // Calculate new dimensions preserving aspect ratio
                        if (width > height) {
                            if (width > MAX_WIDTH) {
                                height *= MAX_WIDTH / width;
                                width = MAX_WIDTH;
                            }
                        } else {
                            if (height > MAX_HEIGHT) {
                                width *= MAX_HEIGHT / height;
                                height = MAX_HEIGHT;
                            }
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');

                        // Draw white background (or transparent)
                        ctx.clearRect(0, 0, width, height);
                        // Optional: Remove white background by setting pixels with white color to transparent
                        ctx.drawImage(img, 0, 0, width, height);

                        // You can add image background removal here if you want (complex)
                        // For now we just resize

                        // Update preview image src
                        preview.src = canvas.toDataURL(file.type);

                        // Convert to Blob and then to Base64 to put in hidden input
                        canvas.toBlob(function(blob) {
                            const reader2 = new FileReader();
                            reader2.onloadend = function() {
                                iconDataInput.value = reader2
                                    .result; // base64 string to send in form
                            };
                            reader2.readAsDataURL(blob);
                        }, file.type, 0.9);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });

            // Smart description formatting (paste and blur)
            const textarea = document.getElementById('description');

            function smartFormat(text) {
                text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
                let lines = text.split('\n');
                lines = lines.map(line => line.trim());

                let cleanedLines = [];
                let emptyCount = 0;
                for (let line of lines) {
                    if (line === '') {
                        emptyCount++;
                        if (emptyCount <= 1) cleanedLines.push(line);
                    } else {
                        emptyCount = 0;
                        cleanedLines.push(line);
                    }
                }

                cleanedLines = cleanedLines.map(line => {
                    if (/^[-*•]\s+/.test(line)) {
                        line = line.replace(/^([-*•])\s+/, '• ');
                        line = line[0] + line.slice(1).replace(/^\w/, c => c.toUpperCase());
                    } else if (/^\d+\.\s+/.test(line)) {
                        line = line.replace(/^(\d+\.\s+)(\w)/, (m, p1, p2) => p1 + p2.toUpperCase());
                    } else {
                        line = line.replace(/^\w/, c => c.toUpperCase());
                    }
                    line = line
                        .replace(/(^|[\s(\[{<])'/g, "$1‘")
                        .replace(/'/g, "’")
                        .replace(/(^|[\s(\[{<])"/g, "$1“")
                        .replace(/"/g, "”");
                    return line;
                });

                return cleanedLines.join('\n');
            }

            textarea.addEventListener('paste', function(e) {
                e.preventDefault();
                let pasteText = (e.clipboardData || window.clipboardData).getData('text');
                let formattedText = smartFormat(pasteText);
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const textBefore = textarea.value.substring(0, start);
                const textAfter = textarea.value.substring(end);
                textarea.value = textBefore + formattedText + textAfter;
                const cursorPos = start + formattedText.length;
                textarea.selectionStart = textarea.selectionEnd = cursorPos;
            });

            textarea.addEventListener('blur', function() {
                textarea.value = smartFormat(textarea.value);
            });
        });
    </script> --}}
    <!-- end of of image preview section -->

    <!-- start of notification toaster notification -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ session('warning') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: "{{ session('info') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
    <!-- end of notification toaster notification -->
    <!-- start of action reminder notification -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let pendingAction = null;

            // ✅ CREATE CONFIRMATION HANDLER
            document.querySelectorAll('form[data-confirm="create"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.dataset.confirmed) {
                        e.preventDefault();
                        pendingAction = form;
                        $('#createConfirmModal').modal('show');
                    }
                });
            });

            // ✅ EDIT CONFIRMATION HANDLER
            document.querySelectorAll('form[data-confirm="edit"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.dataset.confirmed) {
                        e.preventDefault();
                        pendingAction = form;
                        $('#editConfirmModal').modal('show');
                    }
                });
            });

            // ✅ DELETE CONFIRMATION HANDLER
            window.triggerDeleteModal = function(url) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                $('#deleteConfirmModal').modal('show');
            };

            // ✅ ON MODAL CONFIRM CLICKS
            document.querySelectorAll('#createConfirmModal .btn-success, #editConfirmModal .btn-info').forEach(
                button => {
                    button.addEventListener('click', function() {
                        if (pendingAction) {
                            pendingAction.dataset.confirmed = true;
                            pendingAction.submit();
                            pendingAction = null;
                        }
                    });
                });
        });
    </script>
    <!-- end of action reminder notification -->

    <!-- start of delete confirmation script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userRole = "{{ Auth::user()->getRoleNames()->first() }}";

            // Hide all delete buttons for unauthorized roles
            if (userRole !== 'admin' && userRole !== 'it_support') {
                document.querySelectorAll('button.btn-danger.btn-sm').forEach(button => {
                    // Optional: Hide the whole form instead of just the button
                    const form = button.closest('form');
                    if (form) {
                        form.remove();
                    } else {
                        button.remove();
                    }
                });
                return; // Stop execution for unauthorized users
            }

            // Only admin & it_support can delete
            window.triggerDeleteModal = function(actionUrl) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This record will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = actionUrl;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');
                        const csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = csrfToken;

                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';

                        form.appendChild(csrfField);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };
        });
    </script>
    <!-- end of delete confirmation script -->

    <!-- start of data table format table -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable();
        });
    </script>
    <!-- end of data table format table -->

    <!-- start of date input validation -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const dateInputs = document.querySelectorAll('input[type="date"]');

            dateInputs.forEach(input => {
                // Trigger on typing AND leaving field
                input.addEventListener('blur', validateDate);
                input.addEventListener('input', validateDate);
            });

            function validateDate(e) {
                const element = e.target;
                const value = element.value;

                if (!value) return;

                const [yearStr, monthStr, dayStr] = value.split("-");
                const year = parseInt(yearStr);
                const month = parseInt(monthStr);
                const day = parseInt(dayStr);

                // YEAR CHECK
                if (!/^\d{4}$/.test(yearStr) || year >= 2100 || year <= 0) {
                    return showError(element, "Year must be a valid 4-digit number less than 2100.");
                }

                // MONTH CHECK
                if (month < 1 || month > 12) {
                    return showError(element, "Invalid month selected.");
                }

                // FEBRUARY CHECKS
                if (month === 2) {
                    const isLeap = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);

                    if (day > 29) {
                        return showError(element, "February never has 30 or 31 days.");
                    }

                    if (day === 29 && !isLeap) {
                        return showError(
                            element,
                            `This year (${year}) is not a leap year. February has only 28 days.`
                        );
                    }
                }

                // GENERAL MONTH CHECK
                const maxDays = new Date(year, month, 0).getDate();
                if (day < 1 || day > maxDays) {
                    return showError(
                        element,
                        `${monthName(month)} ${year} has only ${maxDays} days.`
                    );
                }
            }

            function showError(element, message) {
                element.value = "";

                Swal.fire({
                    icon: "error",
                    title: "Invalid Date",
                    text: message,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            }

            function monthName(month) {
                return [
                    "", "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ][month];
            }
        });
    </script>

    <!-- end of date input validation -->
    <!-- start of manual search -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector(".navbar-search-block input.form-control-navbar");

            if (!searchInput) return;

            // Result dropdown
            const resultBox = document.createElement("div");
            resultBox.style.position = "absolute";
            resultBox.style.top = "40px";
            resultBox.style.left = "0";
            resultBox.style.width = "100%";
            resultBox.style.maxHeight = "250px";
            resultBox.style.overflowY = "auto";
            resultBox.style.background = "#ffffff";
            resultBox.style.border = "1px solid #ddd";
            resultBox.style.borderRadius = "6px";
            resultBox.style.boxShadow = "0 4px 8px rgba(0,0,0,0.08)";
            resultBox.style.zIndex = "99999";
            resultBox.style.display = "none";
            resultBox.style.color = "#000";

            const parentGroup = searchInput.closest(".input-group");
            parentGroup.style.position = "relative";
            parentGroup.appendChild(resultBox);

            let timer = null;

            searchInput.addEventListener("keyup", function() {
                const query = this.value.trim();
                clearTimeout(timer);

                if (query.length < 2) {
                    resultBox.style.display = "none";
                    return;
                }

                timer = setTimeout(() => {
                    fetch(`/notifications/search?adminlteSearch=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                        .then(data => {

                            if (!Array.isArray(data) || data.length === 0) {
                                resultBox.innerHTML = `
                            <div class="p-2 text-muted" style="color:#555;">No results found</div>`;
                            } else {
                                resultBox.innerHTML = data.map(v => `
                            <div class="search-item"
                                style="
                                    padding:8px 12px;
                                    cursor:pointer;
                                    display:flex;
                                    justify-content:space-between;
                                    align-items:center;
                                    border-bottom:1px solid #f1f1f1;
                                    color:#000;
                                "
                                onmouseover="this.style.background='#f7f7f7'"
                                onmouseout="this.style.background='#fff'"
                                onclick="window.location='/${v.type}/${v.id}'">
                                
                                <span style="font-size:14px; font-weight:500;">
                                    ${v.name}
                                </span>

                                <span style="
                                    font-size:11px;
                                    background:#e6f0ff;
                                    color:#000;
                                    padding:2px 6px;
                                    border-radius:4px;
                                ">
                                    ${v.type.toUpperCase()}
                                </span>
                            </div>
                        `).join("");
                            }
                            resultBox.style.display = "block";
                        });
                }, 300);
            });

            // Close when clicking outside
            document.addEventListener("click", function(e) {
                if (!resultBox.contains(e.target) && e.target !== searchInput) {
                    resultBox.style.display = "none";
                }
            });
        });
    </script>
    <!-- end of manual search -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@section('plugins.Datatables', true)
@stop
