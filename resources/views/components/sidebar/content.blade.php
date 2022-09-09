<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('company.dashboard') }}" :isActive="request()->routeIs('company.dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    {{-- Examples --}}

    <x-sidebar.link title="Insikter & trender" href="{{ route('company.insikter') }}" :isActive="request()->routeIs('company.insikter')" >
        <x-slot name="icon">
            <x-heroicon-o-document-report class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Prisförslag" href="{{ route('company.offers') }}" :isActive="request()->routeIs('company.offers') || request()->routeIs('company.adjust')" >
        <x-slot name="icon">
            <x-telekom-kronor class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Min Profil" href="{{ route('profile.show') }}" :isActive="request()->routeIs('profile.show')" >
        <x-slot name="icon">
            <x-heroicon-o-user-circle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
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