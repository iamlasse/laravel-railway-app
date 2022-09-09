<x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Welcome :Name', ['name' => auth()->user()->name]) }}
        </h2>
        {{-- <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-jetstream" variant="black"
                class="items-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Star on Github</span>
            </x-button> --}}
    </div>
</x-slot>

<div class="px-4 py-6 mx-auto max-w-7xl">

    <x-partials.steps.steps current="1" />

</div>


    <div class="px-4 mx-auto mt-12 mb-24 sm:mb-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col space-y-6 sm:space-y-0 sm:space-x-10 cols sm:flex-row">
            <div class="w-full overflow-hidden sm:w-3/5">
                <h3 class="mb-6 text-3xl font-bold text-tkblue-600">Hej och välkommen till Telekomkollen!</h3>

                <p>
                    Vad kul att vi fått förtroendet att kostnadsfritt visualisera och optimera ditt företags telefoni.
                    Härifrån kan du ta del av era insikter och trender, benchmarka befintlig lösning eller känna dig nöjd med ditt nuvarande val. 
                    
                    <br/>
                    <br/>
                    Genom att optimera ert avtal ser besparingen ut att bli 
                     <span
                        class="font-bold {{ $this->totalSavingsOrOverpaid > 0 ? 'text-tkteal-700' : 'text-tkorange-700' }}">{{ number_format($this->totalSavingsOrOverpaid) }}
                        Kr.</span>
                </p>




            </div>

            <div class="w-full sm:w-2/5">
                <div class="flex flex-col items-center justify-center space-y-8 rep-box">
                    <h3 class="text-xl font-semibold">Din personliga rådgivare</h3>
                    <img class="object-cover w-20 h-20 rounded-md shadow-sm"
                        src="{{ company()->rep->profile_photo_url }}" alt="{{ company()->rep->name }}" />
                    <div class="text-center rep-info">
                        {{-- <small>Hur kan jag hjalpa?</small> --}}
                        <h4 class="font-semibold">{{ company()->rep->name }}</h4>

                        <br />

                        <div class="flex justify-center space-x-4 actions">
                            <div class="chat">
                                <a href="tel:{{ company()->rep->phone }}">
                                    <x-heroicon-s-phone class="w-6 h-6 text-tkblue-600" />
                                </a>
                            </div>
                            
                            <div class="email">
                                <a href="mailto:{{ company()->rep->email }}">
                                    <x-heroicon-o-mail class="w-6 h-6 text-tkblue-600" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col mt-10 space-y-6 sm:flex-row sm:space-y-0 sm:space-x-10 cols-2">
            <div class="w-full sm:w-4/6 left">
                @if (company()->hasCurrentOffer() && company()->hasSubscriptions())
                    <div class="px-8 py-6 bg-white shadow-sm rounded-xl">
                        <h4 class="mb-4 text-xl font-bold text-tkblue-600">Optimera & betala rätt för det du faktiskt
                            använder</h4>
                        <div class="flex flex-col cols sm:flex-row">
                            <div class="flex flex-col w-full space-y-4 sm:w-3/6 left">
                                <img src="{{ asset('images/sim-card.svg') }}" alt="Sim Card" width="334"
                                    height="197" />
                                <div class="pb-6 content">
                                    <div class="relative h-5 sm:h-3">
                                        <span
                                            class="absolute inset-0 flex items-center justify-end h-2 text-right bg-gray-200 rounded-lg"></span>
                                        <span
                                            class="absolute inset-0 flex items-center justify-end h-2 text-right rounded-lg bg-tkorange-500"
                                            style="width: {{ (max(toGB($company->total_usage), 1) / max($company->total_data, toGB($company->total_usage))) * 100 }}%">

                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-semibold">Dataförbrukning</span>
                                        <small
                                            class="mr-1 font-bold text-tkblue-600">{{ number_format(toGB($company->total_usage), 1) }}
                                            GB / {{ $company->total_data }} GB</small>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-3/6 right">
                                <div class="flex flex-col items-center justify-center h-full sm:pb-20">
                                    <h3
                                        class="text-3xl font-bold {{ $this->totalSavingsOrOverpaid > 0 ? 'text-tkteal-700' : 'text-tkorange-700' }}">
                                        {{ number_format($this->totalSavingsOrOverpaid) }} Kr.</h3>
                                    <span class="text-sm font-bold">Möjlig överdebitering</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="w-full sm:w-2/5 right">
                <div class="px-6 py-5 bg-white shadow-sm rounded-xl">
                    <div class="flex flex-col space-y-4">
                        @unless(company()->hasOrder())
                            <h4 class="text-3xl font-bold">Nästa steg</h4>
                            <p>Under instikter & trender får du medvetenhet genom datadrivna insikter, som analys och
                                statistik. Under prisförslag
                            </p>

                            <div class="items-stretch space-y-4 buttons">

                                <x-button
                                    href="{{ route('company.insikter') }}"
                                    label="Insikter & trender"
                                    class="w-full font-semibold dark:bg-tkteal-500 hover:bg-tkblue-500 hover:text-white text-tkblue-500"
                                    primary lg rounded />
                                    
                                
                                <x-button
                                href="{{ route('company.offers') }}"
                                label="Prisförslag"
                                    class="w-full font-semibold bg-tkblue-500 dark:bg-tkblue-500 hover:bg-tkblue-500 hover:text-white"
                                    primary lg rounded />
                                @if (company()->orderInProgress())
                                    <x-button
                                    href="{{ route('company.order') }}"
                                    label="Fortsätt beställning"
                                        class="w-full font-semibold bg-tkblue-500 dark:bg-tkblue-500 hover:bg-tkblue-500 hover:text-white"
                                        primary lg rounded />
                                @endif

                            </div>
                        @else
                            <h4 class="text-3xl font-bold">Se senaste beställning</h4>
                            <x-button class="w-full font-semibold bg-tkteal-500 dark:bg-tkblue-500 dark:text-tkteal-500 dark:font-semibold dark:hover:bg-tkteal-500 dark:hover:text-tkblue-500 text-tkblue-500 hover:bg-tkorange-500 hover:text-tkblue-500"
                                primary lg rounded>
                                <a href="{{ route('company.order.summary') }}" class="block w-full">Gå dit nu</a>
                            </x-button>

                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>


