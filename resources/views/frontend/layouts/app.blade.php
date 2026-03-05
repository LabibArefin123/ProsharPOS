<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ProsharPOS - Expanding Horizons') }}</title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/logor.png') }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <!-- Custom Styles -->
    
    <!-- Scripts -->

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/frontend/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/welcome_page/custom_improvement.css') }}">
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
