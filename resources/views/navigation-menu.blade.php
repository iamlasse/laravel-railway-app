<div>
    <nav aria-label="secondary" x-data="{ open: false }" 
        class="sticky top-0 z-10 flex flex-wrap items-center justify-between px-4 py-4 transition-transform duration-500 bg-white sm:px-6 dark:bg-dark-eval-1"
        :class="{
            '-translate-y-full': scrollingDown,
            'translate-y-0': scrollingUp,
        }"
    >
        
            <div class="flex-1 w-full company-name">
                @if(Auth::user()->isCompanyUser())
                <h3 class="font-bold">{{ optional(company())->name ?? '' }}</h3>
                @else
                <h3 class="font-bold">Admin</h3>
                @endif
            </div>

        <div class="flex items-center gap-4">
            <x-button type="button" class="hidden md:inline-flex" iconOnly variant="secondary" srText="Toggle dark mode"
                @click="toggleTheme">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
            </x-button>
            <!-- <x-button type="button" class="md:hidden" iconOnly variant="secondary" srText="Toggle dark mode"
                @click="toggleTheme">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
            </x-button> -->
            @if (Auth::user()->isCompanyUser())
                
            <div class="flex items-center space-x-2 rep">
                
                <img class="object-cover w-8 h-8 rounded-md" src="{{ company()->rep->profile_photo_url }}" alt="{{ company()->rep->name }}" />
                <div class="flex-col hidden sm:flex details ">
                    <span class="text-sm">{{ company()->rep->name }}</span>
                    <small class="text-xs">{{ company()->rep->email }}</small>
                </div>
            </div>
            @else
            <div class="flex items-center space-x-2 rep">
                
                <img class="object-cover w-8 h-8 rounded-md" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                <div class="flex-col hidden details sm:flex">
                    <span class="text-sm">{{ Auth::user()->name }}</span>
                    <small class="text-xs ">{{ Auth::user()->email }}</small>
                </div>
            </div>
            @endif
            
        </div>

        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" x-show="false">
            <div class="flex justify-between h-16">
                
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    
                   
                </div>

                <!-- Hamburger -->
                <div class="flex items-center -mr-2 sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" x-show="false">
            <div class="pt-2 pb-3 space-y-1">
                <x-jet-responsive-nav-link href="{{ route('company.dashboard') }}" :active="request()->routeIs('company.dashboard')">
                    {{ __('Dashboard') }}
                </x-jet-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="flex-shrink-0 mr-3">
                            <img class="object-cover w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-jet-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-jet-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-jet-responsive-nav-link>
                    </form>

                    <!-- Team Management -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                            {{ __('Team Settings') }}
                        </x-jet-responsive-nav-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-jet-responsive-nav-link>
                        @endcan

                        <div class="border-t border-gray-200"></div>

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile bottom bar -->
    <div class="fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 transition-transform duration-500 bg-white sm:px-6 md:hidden dark:bg-dark-eval-1"
        :class="{
            'translate-y-full': scrollingDown,
            'translate-y-0': scrollingUp,
        }" style="z-index: 100;">
        <x-button type="button" iconOnly variant="secondary" srText="Open main menu"
            @click="isSidebarOpen = !isSidebarOpen">
            <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true" class="w-6 h-6" />
            <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true" class="w-6 h-6" />
        </x-button>
        

        <a href="{{ route('company.dashboard') }}">
            <x-application-logo aria-hidden="true" class="w-10 h-10" />
            <span class="sr-only">{{ config('app.name') }}</span>
        </a>

        <x-button type="button" iconOnly variant="secondary" srText="Search">
            <x-heroicon-o-search aria-hidden="true" class="w-6 h-6" />
        </x-button>
    </div>
</div>
