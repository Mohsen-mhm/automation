<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.png">
    <title>{{ env('APP_NAME', 'سامانه متمرکز گلخانه های برخط کشور ایران') }}</title>
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/flowbite/flowbite.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f3f3f3 100%);
        }

        .modern-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body dir="rtl" class="bg-gray-50 transition-colors duration-300">
<x-loader/>

<!-- Header -->
<livewire:panel.layouts.header/>

<!-- Main Layout -->
<div class="flex min-h-screen pt-16">
    <!-- Sidebar -->
    <livewire:panel.layouts.menu/>

    <!-- Main Content -->
    <main class="flex-1 overflow-hidden">
        <div class="h-full overflow-y-auto md:mr-72">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="/assets/js/tailwind/tailwind.min.js"></script>
<script src="/assets/js/flowbite/flowbite.min.js"></script>
@livewireScripts
@livewireChartsScripts
<script src="/assets/js/custom.js"></script>

<script>
    // Modern interactions
    document.addEventListener('DOMContentLoaded', function () {
        // Smooth transitions
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.3s ease-in-out';
        setTimeout(() => {
            document.body.style.opacity = '1';
        }, 100);
    });
</script>
</body>
</html>
