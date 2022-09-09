<x-guest-layout>
    <x-auth-card>
        <div class="pt-12">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <a href="{{ route('home') }}">
                    <x-application-logo class="w-auto h-16 mx-auto text-indigo-600" />
                </a>
        
                <h2 class="mt-6 text-3xl font-extrabold leading-9 text-center text-gray-900">
                    Sign in to your account
                </h2>
                @if (Route::has('register'))
                    <p class="mt-2 text-sm leading-5 text-center text-gray-600 max-w">
                        Or
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 transition duration-150 ease-in-out hover:text-indigo-500 focus:outline-none focus:underline">
                            create a new account
                        </a>
                    </p>
                @endif
            </div>
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
                    @if (session('message'))
                        <span>{{ session('message') }}</span>
                    @endif
                    <form wire:submit.prevent="authenticate">
                    @if ($usePhone ?? '')
                        <div>
                            
                            <label for="phone" class="block text-sm font-medium leading-5 text-gray-700">
                                <span class="flex justify-between">
                                    
                                    <span>Phone Number</span>
                                    <span wire:click="$set('usePhone', false)">Use Email</span>
                                    
                                    
                                </span>
                            </label>
        
                            <div class="mt-1 rounded-md shadow-sm">
                                <input wire:model.lazy="phone" id="phone" name="phone" type="phone" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
                            </div>
        
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div>
                            <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                                <span class="flex justify-between">
                                    <span>Email address</span>
        
                                
                                    <span wire:click="$set('usePhone', true)">Use Phone</span>
                                </span>
                                
                            </label>
        
                            <div class="mt-1 rounded-md shadow-sm">
                                <input wire:model.lazy="email" id="email" name="email" type="email" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
                            </div>
        
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                        <div class="mt-6">
                            <span class="block w-full rounded-md shadow-sm">
                                <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700">
                                    Sign in
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>