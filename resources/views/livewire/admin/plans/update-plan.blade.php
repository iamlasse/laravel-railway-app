<x-modal-layout>
    <x-slot:header>
        <div class="flex justify-between" >
            <h3 class="text-white">Uppdatera Prisplan</h3>
        </div>
    </x-slot:header>
    <x-slot:body>
        <form @submit.prevent="updatePlan" class="space-y-4">
            @csrf

            <x-input label="Namn" wire:model.defer='plan.name' />
            <x-textarea label="Beskrivning" placeholder="Frivilligt..." wire:model='plan.description' />

            <x-input type="number" label="Data (GB)" wire:model.defer='plan.data' />
            <x-inputs.currency prefix="Kr" label="Pris" wire:model.defer='plan.price' />
            
        </form>
    </x-slot:body>
    <x-slot:footer>
        <div class="mt-4">
            <x-button  wire:click.prevent="$emit('closeModal')" type="submit" gray md rounded class="font-semibold text-white">Avbryt</x-button>
        <x-button spinner="updatePlan" wire:click.prevent='updatePlan' type="submit" primary md rounded class="font-semibold text-tkblue-500">Uppdatera</x-button>
        </div>
    </x-slot:footer>
</x-modal-layout>