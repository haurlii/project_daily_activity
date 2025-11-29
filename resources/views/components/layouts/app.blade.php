<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="icon" href="{{ asset('assets/images/logo/logo-circle-blue.svg') }}" type="image/svg+xml">
        <title>
            {{ $title }}
        </title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Outfit:wght@100..900&display=swap"
            rel="stylesheet">


        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>

    <body
        x-data="{ page: '{{ $title }}', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
        x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
        :class="{'dark bg-gray-900': darkMode === true}">
        <!-- ===== Preloader Start ===== -->
        <x-partials.preloader />
        <!-- ===== Preloader End ===== -->

        <!-- ===== Page Wrapper Start ===== -->
        <div class="flex h-screen overflow-hidden">
            <!-- ===== Sidebar Start ===== -->
            <x-partials.sidebar />
            <!-- ===== Sidebar End ===== -->

            <!-- ===== Content Area Start ===== -->
            <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
                <!-- Small Device Overlay Start -->
                <x-partials.overlay />
                <!-- Small Device Overlay End -->

                <!-- ===== Header Start ===== -->
                <x-partials.navbar :title="$title" />
                <!-- ===== Header End ===== -->

                <!-- ===== Main Content Start ===== -->
                <main>
                    {{ $slot }}
                </main>
                <!-- ===== Main Content End ===== -->
            </div>
            <!-- ===== Content Area End ===== -->
        </div>
        <!-- ===== Page Wrapper End ===== -->
        @stack('scripts')
        @vite('resources/js/app.js')
    </body>

</html>