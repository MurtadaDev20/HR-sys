<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HR Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
    {{-- <script src="https://openfpcdn.io/fingerprintjs/v3"></script> --}}

    <style>
        .mobile-menu {
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
            opacity: 0;
            visibility: hidden;
        }
        .mobile-menu.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
        }
    </style>
    <livewire:styles />
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    @include('body.nav')

    <!-- Main Content -->
    @yield('content')
    <!-- Footer -->
    <livewire:scripts />
</body>
</html>
