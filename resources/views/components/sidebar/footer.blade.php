<div class="px-3 flex-shrink-0 z-50">
    <!-- <x-button 
        type="button" 
        iconOnly 
        variant="secondary" 
        x-show="!isSidebarOpen"
        @click="isSidebarOpen = !isSidebarOpen"
        srText="Toggle sidebar"
    >
        <x-icons.menu-fold-left x-show="isSidebarOpen" class="w-6 h-6" />
        <x-icons.menu-fold-right x-show="!isSidebarOpen" class="w-6 h-6" />
    </x-button> -->

     <!-- Toggle button -->
     <x-button srText="Toggle sidebar" flat xs class="outline-none text-white focus:outline-none ring-0 p-0 ring-transparent"
        @click="isSidebarOpen = !isSidebarOpen">
        <x-icons.menu-fold-right x-show="!isSidebarOpen" aria-hidden="true" class="hidden w-6 h-6 lg:block text-white" />
        <x-icons.menu-fold-left x-show="isSidebarOpen" aria-hidden="true" class="hidden w-6 h-6 lg:block text-white" />
        <x-heroicon-o-x aria-hidden="true" class="w-6 h-6 lg:hidden" />
    </x-button>
</div>
