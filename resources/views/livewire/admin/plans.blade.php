<x-slot name="menu_header">
    <h1 class="text-2xl font-bold text-tkteal-500">Planer</h1>
</x-slot>
<div class="flex flex-col mt-8">
    <div class="w-full py-6 mx-auto max-w-7xl sm:space-y-16">
        @foreach ($plans as $key => $operatorPlans)
        <div class="mb-6">
        
            @php
                $operator = operators()->where('id', $key)->first();
            @endphp
            <header class="flex flex-row items-center justify-between mb-3">
                <div class="left">
                    <img src="{{ asset($operator['logo']) }}" class="w-auto h-8" />
                </div>
                <div class="right">
                    {{-- <x-button primary icon="plus" class="font-semibold text-tkblue-500" wire:click="$emit('openModal', 'admin.plans.create-plan', {{json_encode(['operator' => $operator])}})">
                        {{ __('Ny Plan')}}
                    </x-button> --}}
                </div>
            </header>
            <x-table>
                <x-slot:head>
                    <x-table.heading class="px-6 text-left">
                        {{ __('Name') }}
                    </x-table.heading>
                    <x-table.heading class="px-6 text-left">
                        {{ __('Data') }}
                    </x-table.heading>
                    <x-table.heading class="px-6 text-left">
                        {{ __('Price') }}
                    </x-table.heading>
                    <x-table.heading>
                        
                    </x-table.heading>
                </x-slot:head>
                <x-slot:body>
                    @foreach ($operatorPlans as $plan)
                    <x-table.row>
                        <x-table.cell>
                            <span class="inline-flex space-x-2 text-sm leading-5 text-left truncate">
                                <p class="truncate text-cool-gray-600">
                                    {{ $plan->name }}
                                </p>
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="inline-flex space-x-2 text-sm leading-5 text-center truncate">
                                <p class="truncate text-cool-gray-600">
                                    {{ $plan->data }} GB
                                </p>
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="inline-flex space-x-2 text-sm leading-5 text-center truncate">
                                <p class="truncate text-cool-gray-600">
                                    {{ $plan->price }} Kr
                                </p>
                            </span>
                        </x-table.cell>
                        <x-table.cell class="text-right">
                            <span class="inline-flex text-right">
                                <x-button flat sm label="Edit" wire:click.prevent="$emit('openModal', 'admin.plans.update-plan', {{ json_encode(['planId' => $plan->id])}})" />
                            </span>
                        </x-table.cell>
                    </x-table.row>
                    @endforeach
                </x-slot:body>
            </x-table>
        </div>
        @endforeach
    </div>
    @push('scripts')
        <script>
            window.addEventListener('saved', event => {
                window.notyf.success({
                    message: `${event.detail.message}`
                })
            })
        </script>
    @endpush
</div>
