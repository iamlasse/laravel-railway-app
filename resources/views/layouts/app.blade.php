<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', optional(company())->name) ?? '' }}</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <!-- Styles -->
    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">

    @livewireStyles

    <script>
        function initFreshChat() {
            window.fcWidget.init({
                token: "cff10e8d-68e7-4387-a10d-835b1e277732",
                host: "https://wchat.eu.freshchat.com"
            });
        }

        function initialize(i, t) {
            var e;
            i.getElementById(t) ? initFreshChat() : ((e = i.createElement("script")).id = t, e.async = !0, e.src =
                "https://wchat.eu.freshchat.com/js/widget.js", e.onload = initFreshChat, i.head.appendChild(e))
        }

        function initiateCall() {
            initialize(document, "Freshdesk Messaging-js-sdk")
        }
        window.addEventListener ? window.addEventListener("load", initiateCall, !1) : window.attachEvent("load",
            initiateCall, !1);
    </script>


</head>

<body class="font-sans antialiased">

    <div x-data="mainState" :class="{ dark: isDarkMode }" @resize.window="handleWindowResize" x-cloak>
        <x-banner />

        <div class="min-h-screen text-gray-900 bg-tkorange-200 dark:bg-telekom-lightorange dark:text-tkblue-500">
            <!-- Sidebar -->
            <x-sidebar.sidebar />

            <!-- Page Wrapper -->
            <div class="flex flex-col min-h-screen"
                :class="{ 
                    'lg:ml-64': isSidebarOpen,
                    'md:ml-16': !isSidebarOpen
                }"
                style="transition-property: margin; transition-duration: 150ms;">

                <x-navigation-menu />

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="text-white bg-tkblue-500">
                        <div class="p-4 sm:p-6">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="">
                    {{ $slot }}
                </main>

                <!-- Page Footer -->
                <x-footer />
            </div>
        </div>
    </div>
    <livewire:livewire-ui-modal />
    <x-dialog z-index="z-50" blur="md" align="center" />
    @livewireScripts
    @wireUiScripts

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script>
        window.notyf = new Notyf({
            duration: 3000,
        });
    </script>
    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.onPageExpired((response, message) => {
                console.log('Page expired')
                window.$wireui.dialog({
                    title: '{{ __('Page Expired') }}',
                    description: '{{ __('Reload the page to continue') }}',
                    icon: 'clock',
                    iconBackground: 'primary',
                    iconColor: 'dark',
                    close: {
                        label: '{{ __('Reload page') }}',
                        color: 'info',
                    },
                    onDismiss:  () =>  window.location.reload(),
                    onClose:  () =>  window.location.reload()
                })
            })
        })
    </script>
    @stack('modals')
    @stack('scripts')
</body>

</html>