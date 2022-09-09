<div>
    <form wire:submit.prevent="createSubscription">
        <x-errors />
        {{ $this->form }}
        
        <div class="flex justify-end mt-6 space-x-2">
            <x-button mdgray onclick="Livewire.emit('closeModal')">
                {{ __('Cancel') }}
            </x-button>
            <x-button spinner="createSubscription" type="submit" primary md class="font-semibold text-tkblue-500">
                Skapa abonnemang
            </x-button>
        </div>
    </form>
</div>
