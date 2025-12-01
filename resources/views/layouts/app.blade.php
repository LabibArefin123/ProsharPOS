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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">



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
    </style>


    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS + dependencies -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Animation duration
            easing: 'ease-in-out', // Easing style
            once: true, // Only animate once
        });
    </script>
    <script>
        $(document).ready(function() {
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                var target = this.hash;
                $('html, body').animate({
                    scrollTop: $(target).offset().top
                }, 800);
            });
        });

        function changeBackground(color) {
            document.getElementById('features').style.transition = "background 1.5s ease-in-out";
            document.getElementById('features').style.background =
                `radial-gradient(circle at center, ${color} 0%, #f8f9fa 80%)`;
        }
    </script>

</body>

</html>
