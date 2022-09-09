<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="left">
                <h2 class="text-xl font-semibold leading-tight">
                    {{ __('Insikter & trender') }}
                </h2>
                <h3 class="text-white">Mätperiod {{ optional(company()->period_starts_at)->format('d M y') }}-{{ optional(company()->period_ends_at)->format('d M y') }}</h3>
            </div>
            <div class="flex space-x-2">
                @if (company()->hasVaxelOperator())
                    <div class="flex flex-col items-stretch justify-between text-xl bg-white rounded-lg ">
                        @php
                            $operator = company()->getVaxelOperator();
                        @endphp
                       <div class="flex items-center justify-center flex-1 p-4">
                        <img src="{{ asset($operator['logo']) }}" width="100" height="40"
                        style="max-height: 30px; object-fit:contain" alt="" />
                       </div>

                        <div class="pb-1 text-center bg-indigo-500 rounded-b-lg">
                            <small class="text-xs font-semibold text-center text-white">Växel</small>
                        </div>
                    </div>
                @endif
                @if (company()->hasCurrentOffer())
                    <div class="flex flex-col items-stretch justify-between text-xl bg-white rounded-lg ">
                        @php
                            $operator = company()->currentOffer->getOperator();
                        @endphp
                       <div class="flex items-center justify-center flex-1 p-4">
                        <img src="{{ asset($operator['logo']) }}" width="100" height="40"
                        style="max-height: 30px; object-fit:contain" alt="" />
                       </div>

                        <div class="pb-1 text-center bg-indigo-500 rounded-b-lg">
                            <small class="text-xs font-semibold text-center text-white">Operatör</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="px-4 py-6 mx-auto 2xl:px-0 max-w-7xl">

        <x-partials.steps.steps current="2" />

    </div>
    {{-- <div class="inline-block w-16 overflow-hidden">
            <div class="origin-top-left transform -rotate-45 bg-black h-11 w-11"></div>
           </div> --}}

    <div class="p-2 px-4 mx-auto mb-24 2xl:px-0 lg:max-w-7xl sm:mb-auto">
        <div class="flex flex-col items-stretch bg-white shadow-md rounded-xl">
            @if (company()->currentOffer)
                <x-company.subscription-counters :company-data="$companyData" />


                <div class="flex flex-col p-6 md:flex-row md:space-x-4 ">
                    <div class="w-full overflow-hidden overflow-x-auto sm:w-2/3 md:w-3/6 lg:w-4/6 xl:w-3/4 sm:px-0">
                        <livewire:subscriptions-table :model='company()'
                            :hide="['create', 'actions.edit', 'actions.plans', 'filters', 'new_plan']" />
                    </div>

                    <div class="w-full mt-6 summary sm:mt-0 sm:w-1/3 md:w-3/6 lg:w-2/6 xl:w-1/4">
                        <div class="relative summary-box">
                            <livewire:company.summary :company-data="$companyData" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-button primary lg rounded class="w-full bg-tkteal-500 dark:bg-tkteal-500">
                            <a href="{{ route('company.offers')}}" class="flex items-center justify-center w-full h-full text-tkblue-500">
                                {{ __('Gå till prisförslag')}}
                                <x-heroicon-s-arrow-right class="w-4 h-4 ml-2" />
                            </a>
                        </x-button>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-center">
                    <h3>Det finns ingen data ännu, kontakta din representant</h3>
                </div>
            @endif


        </div>

    </div>

    </div>
</x-app-layout>
