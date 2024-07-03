<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="font-sans leading-none text-gray-700 text-xs antialiased">
    @inertia
</body>

</html>
