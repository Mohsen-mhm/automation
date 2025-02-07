<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.png">
    <title>{{ env('APP_NAME', 'سامانه متمرکز گلخانه های برخط کشور ایران') }}</title>
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/flowbite/flowbite.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">

</head>

<body dir="rtl" class="bg-gray-100 flex items-center justify-start w-full">
<x-loader/>
<div class="flex w-full h-screen overflow-hidden"
     x-data="{ page: 'ecommerce', 'stickyMenu': false, 'sidebarToggle': false }">
    <div class="bg-[#013328]">
        <livewire:layouts.menu/>
    </div>
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        <livewire:layouts.header/>
        <main>
            <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<script src="/assets/js/tailwind/tailwind.min.js"></script>
<script src="/assets/js/flowbite/flowbite.min.js"></script>
@livewireScripts
<script src="/assets/js/custom.js"></script>
</body>

</html>
