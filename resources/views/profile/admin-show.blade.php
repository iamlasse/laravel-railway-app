<x-admin-layout>
    <x-slot name="menu_header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="md:p-12">
        <div class="grid gap-6 lg:grid-cols-4" x-data="{ selectedTab: 'profileSetteings' }">
            <!-- Current Profile Photo -->
            <div class="flex flex-col items-center gap-2 lg:col-span-1">
                <div class="flex flex-col items-center justify-center mb-6">
                    <img src="{{ optional(auth()->user())->profile_photo_url }}" alt="{{ optional(auth()->user())->name }}"
                        class="object-cover w-32 h-32 rounded-full">
                        <div class="mt-6">
                            <p class="text-base font-semibold">{{ optional(auth()->user())->name }}</p>
                        </div>
                </div>
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <button 
                        @click="selectedTab = 'profileSetteings'" 
                        class="block w-full max-w-xs px-4 py-2 text-left text-gray-600 transition-colors rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200" 
                        :class="{
                            'bg-telekom-darkblue text-yellow-500 hover:text-yellow-500 dark:text-yellow-500 dark:hover:text-yellow-500': selectedTab == 'profileSetteings',
                        }">
                        {{ __('telekom.profile.settings') }}
                    </button>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <button 
                        @click="selectedTab = 'updatePassword'" 
                        class="block w-full max-w-xs px-4 py-2 text-left text-gray-600 transition-colors rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200" 
                        :class="{
                            'bg-telekom-darkblue text-yellow-500 hover:text-yellow-500 dark:text-yellow-500 dark:hover:text-yellow-500': selectedTab == 'updatePassword',
                        }">
                        {{ __('telekom.profile.update-password') }}
                    </button>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <button 
                        @click="selectedTab = 'twoFactorAuth'" 
                        class="block w-full max-w-xs px-4 py-2 text-left text-gray-600 transition-colors rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200" 
                        :class="{
                            'bg-telekom-darkblue text-yellow-500 hover:text-yellow-500 dark:text-yellow-500 dark:hover:text-yellow-500': selectedTab == 'twoFactorAuth',
                        }">
                        {{ __('telekom.profile.auth') }}
                    </button>
                @endif

                <button 
                    @click="selectedTab = 'browserSessions'" 
                    class="block w-full max-w-xs px-4 py-2 text-left text-gray-600 transition-colors rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200" 
                    :class="{
                        'bg-telekom-darkblue text-yellow-500 hover:text-yellow-500 dark:text-yellow-500 dark:hover:text-yellow-500': selectedTab == 'browserSessions',
                    }">
                    {{ __('Browser Sessions') }}
                </button>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <button 
                            @click="selectedTab = 'deleteProfiles'" 
                            class="block w-full max-w-xs px-4 py-2 text-left text-gray-600 transition-colors rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200" 
                            :class="{
                                'bg-telekom-darkblue text-yellow-500 hover:text-yellow-500 dark:text-yellow-500 dark:hover:text-yellow-500': selectedTab == 'deleteProfiles',
                            }">
                            {{ __('Delete Account') }}
                        </button>
                    @endif
            </div>
            
            <div class="lg:col-span-3">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div x-show="selectedTab == 'profileSetteings'">
                        @livewire('admin.profile.update-profile-information-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div x-show="selectedTab == 'updatePassword'" class="mt-10 sm:mt-0">
                        @livewire('profile.update-password-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div x-show="selectedTab == 'twoFactorAuth'">
                        @livewire('profile.two-factor-authentication-form')
                    </div>
                @endif

                <div x-show="selectedTab == 'browserSessions'">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div x-show="selectedTab == 'deleteProfiles'">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>