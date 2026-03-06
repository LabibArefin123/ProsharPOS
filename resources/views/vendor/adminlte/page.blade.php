@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/logor.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <!-- start of confirm modal validation -->
        @include('vendor.adminlte.modal.confirm_modal')
        <!-- start of create animation model -->
        @include('vendor.adminlte.modal.create_modal')
        <!-- start of edit animation model -->
        @include('vendor.adminlte.modal.edit_modal')
        <!-- start of delete animation model -->
        @include('vendor.adminlte.modal.delete_modal')
        @include('sweetalert::alert')

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
        });
    </script>

    <!-- End of Login / Logout -->
    <script src="{{ asset('js/backend/custom_adminlte/time clock.js') }}"></script>{{-- bangla-date js --}}
    <script src="{{ asset('js/backend/custom_adminlte/validation.js') }}"></script>{{-- validation js --}}
    <script src="{{ asset('js/backend/custom_adminlte/delete_confirmation.js') }}"></script>{{-- delete confirmation js --}}
    <script src="{{ asset('js/backend/custom_adminlte/date-input-validation.js') }}"></script>{{-- date input validation js --}}
    {{-- image function for toast editor js --}}
    {{-- <script src="{{ asset('js/backend/custom_adminlte/toast-image-editor.js') }}"></script> --}}
    {{-- image preview js --}}
    {{-- <script src="{{ asset('js/backend/custom_adminlte/image-preview.js') }}"></script> --}}
    <script src="{{ asset('js/backend/custom_adminlte/action-reminder.js') }}"></script>{{-- action reminder notification js --}}
    <script src="{{ asset('js/backend/custom_adminlte/manual_search.js') }}"></script>{{-- manual search js --}}
    <script src="{{ asset('js/backend/custom_adminlte/sweet_notifications.js') }}"></script>{{-- notification toaster js --}}
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.min.js"></script>

    <!-- start of data table format table -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable();
        });
    </script>
    <script>
        window.userRole = "{{ Auth::user()->getRoleNames()->first() ?? '' }}";
        window.sweetAlertData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info'))
        };
    </script>
    <!-- end of data table format table -->

    <!-- start of manual search -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

@section('plugins.Datatables', true)
@stop
