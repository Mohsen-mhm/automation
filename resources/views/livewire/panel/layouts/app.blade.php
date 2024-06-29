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

<body dir="rtl" class="bg-gray-100 flex flex-col justify-start min-h-screen">
<x-loader/>
<livewire:panel.layouts.header/>

<div class="bg-gray-100 flex justify-start min-h-screen">
    <livewire:panel.layouts.menu/>
    <livewire:panel.layouts.toggle/>

    {{ $slot }}
</div>

<script src="/assets/js/tailwind/tailwind.min.js"></script>
<script src="/assets/js/flowbite/flowbite.min.js"></script>
@livewireScripts
@livewireChartsScripts
<script src="/assets/js/custom.js"></script>
</body>

</html>
