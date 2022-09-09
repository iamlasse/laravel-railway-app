<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'K UI') }}</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

   @livewireStyles
</head>

<body>
    <div class="font-sans antialiased" x-data="mainState" :class="{dark: isDarkMode}" x-cloak>
        <div class="w-screen min-w-full min-h-screen bg-tkblue-500">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
     <!-- Scripts -->
     @stack('scripts')
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>