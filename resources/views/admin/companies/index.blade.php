<x-admin-layout>
    <x-slot name="menu_header">
        <h1 class="text-2xl font-bold text-tkteal-500">Företag</h1>
    </x-slot>
    <div class="p-6 companies-tables">
        <livewire:admin.company-table :companies="$companies" wire:key="company-table" />
    </div>
</x-admin-layout>