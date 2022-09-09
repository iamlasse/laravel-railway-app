<div class="flex items-center justify-between flex-shrink-0 px-3 transition-all">
    <!-- Logo -->
    <a href="{{ Auth::user()->isCompanyUser() ? route('company.dashboard') : route('admin.dashboard') }}" class="inline-flex items-center gap-2">
    <x-application-icon aria-hidden="true" class="hidden w-10 h-10 text-white lg:block" x-show="!isSidebarOpen && !isSidebarHovered" />
    <x-application-logo aria-hidden="true" class="h-10 delay-150 w-90 lg:block" x-show="isSidebarOpen || isSidebarHovered" />
        <span class="sr-only">Telekom Kollen Logo</span>
    </a>
</div>