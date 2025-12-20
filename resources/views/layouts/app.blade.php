<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SmartCart - Modern E-Commerce')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased" x-data="cart">
    <!-- Notification Component -->
    <div x-data="{ show: false, message: '', type: 'success' }"
        @notification.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
        x-show="show" x-transition class="fixed top-4 right-4 z-50 max-w-sm">
        <div :class="{
            'bg-green-500': type === 'success',
            'bg-red-500': type === 'error',
            'bg-blue-500': type === 'info'
        }"
            class="text-white px-6 py-4 rounded-lg shadow-lg">
            <p x-text="message"></p>
        </div>
    </div>

    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Cart Sidebar -->
    @include('components.cart-sidebar')

    <!-- Product Quick View Modal -->
    @include('components.product-modal')

    @stack('scripts')
</body>

</html>
