<x-sidebar.overlay />

<aside class="fixed inset-y-0 z-20 flex flex-col py-4 space-y-6 transition-all transform shadow-lg bg-telekom-darkblue dark:bg-dark-eval-1" 
        :class="{
            'translate-x-0 w-64': isSidebarOpen || isSidebarHovered,
            '-translate-x-full w-64 md:w-16 md:translate-x-0': !isSidebarOpen && !isSidebarHovered,
        }" 
        style="transition-property: width, transform; transition-duration: 150ms; z-index: 150;"
        @mouseenter="handleSidebarHover(true)" @mouseleave="handleSidebarHover(false)"
>
    <x-sidebar.header />

    <x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('admin.dashboard') }}" :isActive="request()->routeIs('admin.dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    
    <x-sidebar.link title="Företag" href="{{ route('admin.company.index') }}" :isActive="request()->routeIs('admin.company.index') || request()->routeIs('admin.company.*')">
        <x-slot name="icon">
            <x-icon name="briefcase" class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    
    <x-sidebar.link title="Planer" href="{{ route('admin.plans.index') }}" :isActive="request()->routeIs('admin.plans.index') || request()->routeIs('admin.plans.*')">
        <x-slot name="icon">
            <x-icon name="document" class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    
    <x-sidebar.link title="Profil" href="{{ route('admin.profile.show') }}" :isActive="request()->routeIs('admin.profile.show')">
        <x-slot name="icon">
            <x-heroicon-s-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
   
    <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-sidebar.link title="Logga Ut" href="route('logout')" onclick="event.preventDefault();
            this.closest('form').submit();"  >
            <x-slot name="icon">
                <x-heroicon-o-logout class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
            
        </form>

    {{-- Examples --}}

    {{-- <x-sidebar.link title="Insikter & Trender" href="{{ route('insikter') }}" :isActive="request()->routeIs('insikter')" /> --}}
        
    {{-- <x-sidebar.dropdown title="Buttons" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink title="Text button" href="{{ route('buttons.text') }}"
            :active="request()->routeIs('buttons.text')" />
        <x-sidebar.sublink title="Icon button" href="{{ route('buttons.icon') }}"
            :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}"
            :active="request()->routeIs('buttons.text-icon')" />
    </x-sidebar.dropdown> --}}
       
</x-perfect-scrollbar>
    
    <x-sidebar.footer />
</aside>