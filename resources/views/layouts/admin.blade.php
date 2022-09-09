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
    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }

    </style>

    @if (app()->environment('production'))
        <link rel="stylesheet" href="{{ url(asset('css/app.css')) }}">
    @else
        <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    @livewireStyles
</head>

<body class="font-sans antialiased">
    

    <div x-data="mainState" :class="{ dark: isDarkMode }" @resize.window="handleWindowResize" x-cloak>
        

        <div class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
            <!-- Sidebar -->
            <x-sidebar.admin-sidebar />

            <!-- Page Wrapper -->
            <div class="flex flex-col min-h-screen"
                :class="{ 
                'lg:ml-64': isSidebarOpen,
                'md:ml-16': !isSidebarOpen
            }"
                style="transition-property: margin; transition-duration: 150ms;">
                <x-navigation-menu />
                
                
                <!-- Page Heading -->
                @if (isset($menu_header))
                    <header class="text-white bg-tkblue-500">
                        <div class="flex items-center justify-start p-4 sm:p-6">
                            {{ $menu_header }}
                        </div>
                    </header>
                @endif
                @if (isset($actions))
                    <div class="px-4 sm:px-6 lg:px-4">
                        <div class="flex items-center justify-end my-4 space-x-2 xl:px-12">
                            {{ $actions }}
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="flex flex-col flex-auto bg-tkblue-500">
                    <main class="flex-auto px-4 shadow-lg bg-tkorange-200 sm:px-6 lg:px-4 rounded-t-xl">
                        <x-banner />
                        {{ $slot }}
                    </main>
                    <x-footer />
                </div>

                <!-- Page Footer -->
            </div>
        </div>
        
    </div>
    <x-dialog z-index="z-50" blur="md" align="center" />
    <livewire:livewire-ui-modal />
    @stack('modals')

    <livewire:scripts />
    <wireui:scripts />
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @stack('scripts')
    
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script>
        window.notyf = new Notyf({
            duration: 3000,
        });
    </script>
</body>

</html>
