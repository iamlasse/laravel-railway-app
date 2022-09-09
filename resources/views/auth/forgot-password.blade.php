<x-guest-layout>
       <x-auth-card>
        <div class="mb-4 text-sm text-tkteal-600 dark:text-tkteal-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="grid gap-6">
                <!-- Email Address -->
                <div class="space-y-2">
                    <x-label for="email" :value="__('Email')" />
                    <x-input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-mail aria-hidden="true" class="w-5 h-5" />
                        </x-slot>
                        <x-input withicon id="email" class="block w-full" type="email" name="email"
                            :value="old('email')" required autofocus placeholder="{{ __('Email') }}" />
                    </x-input-with-icon-wrapper>
                </div>

                <div class="space-y-4">
                    <x-button primary type="submit" class="justify-center w-full bg-tkteal-600 text-tkblue-500 hover:bg-tkorange-500 hover:text-tkblue-500">
                        {{ __('Reset Password') }}
                    </x-button>
                    <x-button flat primary href="http://telekomkollen.se" class="text-center w-full hover:text-tkblue-500">
                        {{ __('Jag vill skapa ett konto') }}
                    </x-button>
                </div>

            </div>
        </form>
        <x-slot name="footer">
            <a class="text-white underline" href="{{route('login')}}">{{__('Back to login')}}</a>
        </x-slot>
    </x-auth-card>
</x-guest-layout>