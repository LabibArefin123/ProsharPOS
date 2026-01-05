<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ProsharPOS - Expanding Horizons') }}</title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/icon.JPG') }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

    <style>
        .hover-bounce:hover {
            animation: bounce 0.5s;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            color: #fff;
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-10px);
            }

            50% {
                transform: translateY(0px);
            }

            70% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .feature-box {
            cursor: pointer;
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .feature-box:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        #notificationBell .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.75rem;
            padding: 3px 6px;
            border-radius: 50%;
        }

        .navbar-nav .nav-item .nav-link {
            position: relative;
            color: #333;
            font-size: 16px;
            padding: 10px 15px;
            text-decoration: none;
            overflow: hidden;
        }

        /* Parallelogram background effect */
        .navbar-nav .nav-item .nav-link::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #42beee;
            transform: skewX(-20deg);
            transform-origin: bottom left;
            transition: transform 0.3s ease, width 0.3s ease;
            z-index: -1;
            /* Ensure it stays behind the text */
            width: 0;
        }

        /* Hover effect */
        .navbar-nav .nav-item .nav-link:hover::after {
            width: 100%;
            transform: skewX(0deg);
            /* No skew on hover, making it appear like a smooth background expansion */
        }

        /* Hover text color change */
        .navbar-nav .nav-item .nav-link:hover {
            color: white;
        }
    </style>


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS + dependencies -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Animation duration
            easing: 'ease-in-out', // Easing style
            once: true, // Only animate once
        });
    </script>

    {{-- Start of second --}}
    @if (!request()->is('login'))
        <script>
            function updateDateTime() {
                const now = new Date();

                const options = {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true,
                };

                const formatted = now.toLocaleString('en-US', options);

                const dateTimeEl = document.getElementById('currentDateTime');
                if (dateTimeEl) {
                    dateTimeEl.textContent = formatted;
                }
            }

            // Run immediately
            updateDateTime();

            // Update every second
            setInterval(updateDateTime, 1000);
        </script>
    @endif

    {{-- End of second --}}

</body>

</html>
