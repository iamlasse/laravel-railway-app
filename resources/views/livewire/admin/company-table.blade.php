<div class="mx-auto max-w-7xl">
    <div class="grid mb-4 actions justify-items-end">
        <x-button primary class="font-semibold text-tkblue-500" wire:click="$emit('openModal', 'admin.create-company-modal')">
            Nytt företag
        </x-button>
        
    </div>
    <x-table>
        <!-- Head -->
        <x-slot name="head">
            <x-table.heading class="w-8 ">
                <x-input.checkbox wire:model="selectPage" />
            </x-table.heading>
            <x-table.heading sortable class="w-64" wire:click="sortBy('name')"
                :direction="$sorts['name'] ?? null">
                <p>Företag</p>
            </x-table.heading>
            <x-table.heading class="justify-end w-12">
                <p class="text-right">Abonnemang</p>
            </x-table.heading>

            <x-table.heading sortable class="flex justify-end" wire:click="sortBy('rep_id')"
                :direction="$sorts['rep_id'] ?? null">
                <p>Representant</p>
            </x-table.heading>
        </x-slot>

        <!-- Body -->
        <x-slot name="body">
            @forelse ($companies as $company)
                <x-table.row>
                    <x-table.cell class="pr-0">
                        <x-input.checkbox wire:model="selected" value="{{ $company->id }}" />
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex flex-col items-left">
                            <a href="{{ route('admin.company.edit', ['company' => $company]) }}"
                                class="text-sm font-semibold">{{ $company->name }}</a>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex flex-col items-center">
                            {{ $company->subscriptions()->count() }}
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex flex-col items-end">
                            {{ $company->rep->name }}
                        </div>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row></x-table.row>
            @endforelse
        </x-slot>
    </x-table>

    @if ($companies->hasPages())
        <div class="mt-4 pagination">
            {{ $companies->links() }}
        </div>
    @endif
</div>
