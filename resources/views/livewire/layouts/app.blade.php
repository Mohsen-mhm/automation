<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.png">
    <title>{{ env('APP_NAME', 'سامانه متمرکز گلخانه های برخط کشور ایران') }}</title>

    @if (\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
        <link rel="stylesheet" href="assets/css/leaflet/leaflet.css"/>
        <script src="assets/js/leaflet/leaflet.js"></script>
        <link rel="stylesheet" href="assets/css/leaflet/Control.Geocoder.css"/>
        <script src="assets/js/leaflet/Control.Geocoder.js"></script>
    @endif
    <link rel="stylesheet" href="/assets/css/flowbite/flowbite.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">

</head>

<body dir="rtl" class="bg-gray-100 flex items-center justify-start w-screen h-screen">
<x-loader/>
<livewire:layouts.menu/>

{{ $slot }}

<livewire:layouts.sidebar/>
<livewire:layouts.toggle/>

<script src="/assets/js/tailwind/tailwind.min.js"></script>
<script src="/assets/js/flowbite/flowbite.min.js"></script>
@livewireScripts
<link rel="stylesheet" href="/assets/js/custom.js">
</body>

</html>
