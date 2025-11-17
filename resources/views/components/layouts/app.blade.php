<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="shortcut icon" href="{{asset('images/cs.png')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/theme-light.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/theme-dark.css') }}">

    @stack('css')
    @livewireStyles

</head>

<body>

    <div id="app">
        <livewire:atom.sidebar />

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            {{ $slot }}
        </div>
    </div>

    <script src="{{asset('mazer/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('mazer/assets/compiled/js/app.js')}}"></script>
    <script src="{{asset('mazer/assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('mazer/assets/static/js/pages/dashboard.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('js')
    @stack('scripts')
    @livewireScripts <!-- <- Tambahkan ini -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleDark = document.getElementById('toggle-dark');
            if (!toggleDark) return;

            const currentTheme = localStorage.getItem('theme') || 'light';
            document.body.classList.toggle('theme-dark', currentTheme === 'dark');
            document.body.classList.toggle('theme-light', currentTheme === 'light');
            toggleDark.checked = currentTheme === 'dark';

            toggleDark.addEventListener('change', function() {
                const isDark = this.checked;
                document.body.classList.toggle('theme-dark', isDark);
                document.body.classList.toggle('theme-light', !isDark);
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });
        });
    </script>

</body>
</html>
