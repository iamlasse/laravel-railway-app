<x-form-section submit="updatePassword">
    <x-slot name="title">
        <span class="text-tkblue-500 dark:text-tkblue-500">{{ __('Update Password') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-tkblue-500 dark:text-tkblue-500">{{ __('Ensure your account is using a long, random password to stay secure.') }}</span>
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
            <x-jet-input id="current_password" type="password" class="block w-full px-3 py-2 mt-1" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('New Password') }}" />
            <x-jet-input id="password" type="password" class="block w-full px-3 py-2 mt-1" wire:model.defer="state.password" autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-jet-input id="password_confirmation" type="password" class="block w-full px-3 py-2 mt-1" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3 text-white" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-jet-button class="bg-tkteal-500 text-tkblue-500 hover:bg-tkblue-500 hover:text-white">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-form-section>
