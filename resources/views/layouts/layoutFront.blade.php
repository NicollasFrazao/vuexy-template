<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}" data-template="front">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel')) | {{ config('variables.templateName', 'Vuexy') }}</title>

    <meta name="description" content="{{ config('variables.templateDescription', '') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">

    <!-- Core CSS -->
    @vite(['resources/css/core.css', 'resources/css/theme-default.css', 'resources/css/demo.css'])

    <!-- Vendors CSS -->
    @stack('vendor-styles')

    <!-- Page CSS -->
    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Front Navbar -->
    @include('layouts.sections.navbar.navbar-front')
    <!-- / Front Navbar -->

    <!-- Sections -->
    @yield('content')
    <!-- / Sections -->

    <!-- Front Footer -->
    @include('layouts.sections.footer.footer-front')
    <!-- / Front Footer -->

    <!-- Core JS -->
    @vite(['resources/js/app.js', 'resources/js/template.js'])

    <!-- Vendors JS -->
    @stack('vendor-scripts')

    <!-- Page JS -->
    @stack('scripts')
</body>
</html>
