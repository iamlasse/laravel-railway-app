<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Senaste beställning') }}
        </h2>
    </x-slot>


    <div class="mx-auto max-w-7xl">
        <div class="py-6 m-2">
            <x-partials.steps.steps current="5" />
        </div>
        
        <div class="m-2 mt-6 order-summary">
            <h2 class="text-2xl font-semibold text-tkblue-500">{{ company()->name }}'s senaste beställning</h2>
            <x-company.order-table :plans="$order->data" :total="$order->total" />
        </div>
    </div>

</x-app-layout>
