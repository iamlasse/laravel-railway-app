<x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Beställ abonnemang') }}
        </h2>
        <h3 class="p-3 text-xl font-semibold bg-white rounded-lg">

            @if (company()->hasSelectedOperator())
                @php
                    $operator = operators()
                        ->where('id', company()->selected_operator)
                        ->first();
                @endphp
                <img src="{{ asset($operator['logo']) }}" width="100" height="40"
                    style="max-height: 30px; object-fit:contain" alt="">
            @endif
        </h3>
    </div>
</x-slot>

<div class="px-4 py-6 mx-auto 2xl:px-0 max-w-7xl">

    <x-partials.steps.steps current="4" />

</div>

@if (company()->hasSubscriptions())
        <div class="flex flex-col px-4 mx-auto space-y-4 sm:mb-auto 2xl:px-0 betsall max-w-7xl">
            <div class="details">
                <div class="p-6 bg-white rounded-lg shadow-sm box-1" x-data="{ showDetails: true }">
                    <div class="flex items-center justify-between cursor-pointer" @click="showDetails = !showDetails">
                        <h4 class="text-xl font-bold tracking-tight text-tkblue-600" x-show="!showDetails">Visa Detaljer</h4>
                        <h4 class="text-xl font-bold tracking-tight text-tkblue-600" x-show="showDetails">Göm Detaljer</h4>
                        <x-heroicon-s-chevron-down class="w-10 h-10 ml-3 text-tkteal-500" x-show="!showDetails" />
                        <x-heroicon-s-chevron-up class="w-10 h-10 ml-3 text-tkteal-500" x-show="showDetails" />
                    </div>

                    <div x-show="showDetails" class="flex flex-col details">
                        <x-company.details-totals :totals="$totals" :data="$offer_data" />
                        
                        <x-company.order-table :plans="$plans" :total="$total" />

                        <div class="mt-6 comments">
                            @if (company()->extra)
                                <h3 class="text-lg font-bold text-tkblue-500">{{ __('Övriga kommentarer') }}</h3>

                                <div class="p-4 mt-2 bg-gray-200 rounded-lg text-tkblue-500">
                                    {{ company()->extra }}
                                </div>
                            @endif
                            <small>Alla kostnader visas exkl. moms</small>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm box-2">

                </div>
            </div>
        </div>
    @endif

    <livewire:company.order-form />

