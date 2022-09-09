<div class="flex flex-col items-stretch min-h-screen px-4 mx-auto 2xl:px-0 max-w-7xl bg-grey-lighter mb-28 sm:mb-auto">
    <section class="mb-8 sm:h-72 text-grey-darker">
        <div
            class="flex flex-col flex-wrap w-full mt-6 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 offers-boxes">
            @foreach ($offers as $offer)
                @php
                    // FIXME: Filter offers in controller.
                    $total = $this->getTotals($offer->id)['new'];
                    $perMonth = $total;
                @endphp
                @if($total > 0)
                <div
                    class="relative flex flex-col flex-wrap w-full p-6 text-center bg-white shadow-sm transition-all {{ $offer->id == $selectedOffer->id ? 'border-4 border-tkblue-300' : 'border-4 border-transparent' }} sm:h-66 sm:w-40 sm:flex-1 rounded-xl">
                    @if ($offer->is_recommended)
                        <div class="absolute left-0 flex justify-center w-full -top-4">
                            <div
                            class="z-10 flex items-center px-4 py-1 space-x-2 shadow-md bg-tkblue-300 rounded-3xl">
                            <x-heroicon-s-thumb-up class="w-6 h-6 text-tkorange-500" />
                            <small class="text-xs font-semibold text-tkorange-500">{{ __('Best choice' )}}</small>
                        </div>
                        </div>
                    @endif
                    <div class="flex items-center justify-center flex-1 logo">
                        <img src="{{ asset($offer->getOperator()['logo']) }}" alt="Operator Image" srcset="">
                    </div>
                    <div class="mt-6 price">
                        <p class="font-semibold text-tkblue-500">
                            {{ number_format($perMonth, 0) }} Kr
                        </p>
                        <small>Per månad</small>
                    </div>

                    <div class="flex flex-col mt-6 space-y-2 ">
                        @if ($selectedOffer->id === $offer->id)
                            <x-button sm wire:click="setAdjust({{ $offer->id }})"
                                class="flex items-center w-full text-center rounded-full text-tkblue-500 dark:text-tkblue-500 bg-tkorange-500 hover:bg-tkblue-500 dark:bg-tkorange-500 hover:text-white">
                                <div class="flex items-center justify-center w-full font-bold text-center ">
                                    <x-heroicon-o-pencil class="w-4 h-4 mr-1" /> Anpassa</div>
                            </x-button>
                        @else
                            <div class="h-9"></div>
                        @endif
                        <x-jet-button wire:click="setCompare({{ $offer->id }})"
                            class="flex items-center w-full text-center rounded-full bg-tkteal-500 hover:bg-tkblue-500 hover:text-white text-tkblue-500">
                            <div class="w-full font-bold text-cente">Jämför</div>
                        </x-jet-button>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </section>
    <section class="flex flex-col items-center justify-center px-4 py-2 pb-20 bg-white border-2 border-gray-300 border-dashed rounded-lg sm:pb-10 sm:pb-auto"
        style="min-height: 32rem">
        <div class="flex flex-col items-stretch w-full min-h-full compare-offer">
            <div class="min-h-full sm:p-6 ">
                @unless($selectedOffer)
                    <div class="flex items-center justify-center h-full empty">
                        <h2>Klicka på jämför för att få översikt över de olika priser</h2>
                    </div>
                @else
                    <section class="flex flex-col items-stretch justify-between w-full sm:flex-row offer">
                        <div class="flex flex-col items-stretch flex-1 flex-grow mb-6 sm:w-1/2">
                            <div class="justify-start sm:w-1/2 sm:w-full sm:mb-6 logo">
                                <div class="flex">
                                    <div class="p-4 bg-white rounded-lg">
                                        <img src="{{ asset($selectedOffer->getOperator()['logo']) }}" alt="Operator Image"
                                    srcset="">
                                    </div>
                                   
                                </div>
                                <div class="lg:pr-10">
                                    <p class="mt-4 text-tkblue-500">Här nedan kan du se sammanställd månadskostnad idag och imorgon. I grafen nere till höger ser du dataförbrukning vs nyttjad vilken är viktig då det styr månadskostnaden per abonnemang.</p>
                                </div>
                            </div>

                            <div class="flex h-56 p-6 pt-6 mt-6 mb-10 space-x-4 sm:mb-auto text-tkblue-500">
                                <div class="w-20 sm:w-32">
                                    <div class="relative h-full">
                                        <div
                                            class="absolute bottom-0 w-20 h-full transition-all duration-700 ease-in-out transform bg-tkblue-500 sm:left-6 rounded-t-md">
                                        </div>
                                    </div>
                                    <div class="text-center label">
                                        <span class="text-xs font-semibold">Idag</span>
                                    </div>
                                    <div class="mt-4 -ml-4 text-lg font-bold text-center sm:ml-0 w-28 sm:w-auto">
                                        {{ number_format($this->original_total, 0) }} Kr.
                                    </div>
                                </div>
                                <div class="w-20 sm:w-32">
                                    <div class="relative h-full">
                                        <div class="absolute bottom-0 w-20 h-full transition-all duration-700 ease-in-out transform  @if ($this->selected_totals['new'] > $this->original_total) bg-tkorange-600 @else bg-tkteal-500 @endif sm:left-6 rounded-t-md"
                                            style="height: {{ (max($this->selected_totals['new'], 1) / $this->original_total) * 100 }}%; max-height: 110%">
                                            @if ($this->selected_totals['new'] > $this->original_total)
                                                <div class="flex justify-center -mt-6">
                                                    <x-heroicon-s-arrow-up class="w-6 h-6 text-tkorange-600" />
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>

                                    <div class="text-center label">
                                        <span class="text-xs font-semibold">Imorgon</span>
                                    </div>
                                    <div class="mt-4 -ml-4 text-lg font-bold text-center sm:ml-0 w-28 sm:w-auto">
                                        {{ number_format($this->selected_totals['new'], 0) }} Kr.
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="flex flex-col items-stretch justify-start sm:mt-0 sm:w-1/2 right">
                            <div class="flex flex-col items-center justify-center gap-4 py-4 mb-4 border border-gray-400 border-dashed rounded-lg sm:space-x-4 sm:flex-row text-tkblue-500">
                                <small class="flex items-center text-xs font-semibold">
                                    <x-telekom-kronor class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" /> Senast förhandlade pris {{company()->created_at->format('d M Y')}}</small>
                                @if(company()->hasOfferExpiration())
                                <small class="flex items-center text-xs font-semibold">
                                    <x-heroicon-o-clock class="w-4 h-4 mr-2" />Förslaget utgår {{ company()->offer_ends_at->diffForHumans()}}
                                </small>
                                @endif
                                
                            </div>
                            
                            <x-company.details-totals :totals="$this->selectedOfferTotals" :data="$this->selectedOfferData" />
                            {{-- <div
                                class="flex flex-col items-center p-6 space-y-4 text-center shadow-sm transition-all {{ $this->total_saved > 0 ? 'bg-tkteal-200' : 'bg-tkorange-200' }} sm:p-12 rounded-xl">
                                <div class="header">
                                    <h4 class="text-sm font-semibold text-tkblue-500">
                                        Besparing mot idag sett över hela avtalstiden 24m
                                    </h4>
                                </div>
                                <div class="percent">
                                    <h2
                                        class="text-5xl font-bold {{ $this->total_percent_saved > 0 ? 'text-tkteal-700' : 'text-tkorange-700' }}">
                                        @if ($this->total_percent_saved > 100)
                                            -
                                        @endif{{ number_format($this->total_percent_saved, 0) }} %
                                    </h2>
                                </div>
                                <div class="w-full h-1 py-2 border-b border-gray-200 border-dashed divider"></div>
                                <div class="total">
                                    <h2
                                        class="text-3xl font-bold {{ $this->total_saved > 0 ? 'text-tkteal-700' : 'text-tkorange-700' }}">
                                        {{ number_format($this->total_saved, 0) }}Kr.</h2>
                                </div>
                            </div> --}}
                            <div class="flex flex-col h-20 mt-6 sm:h-36 stacks text-tkblue-500">
                                <h4 class="mb-6 font-semibold sm:mb-8">Förändring data förbrukning</h4>

                                <div class="relative sm:h-6">
                                    <div class="absolute w-full h-5 rounded-l-lg bg-tkteal-300">
                                        <div
                                            class="absolute right-0 w-1 h-10 border-r border-gray-600 border-dashed -top-5 ">
                                        </div>
                                        <div class="absolute right-0 flex flex-col w-56 mr-2 -mt-1 text-right -top-5 ">
                                            <small class="text-xs">Betalar idag</small>
                                                <small class="mt-2 font-semibold text-tkblue-500">{{ company()->total_data }} GB</small>
                                        </div>
                                        
                                    </div>
                                    @php
                                        $usage_level = company()->getTotalUsageLevel();
                                        
                                    @endphp
                                    {{-- @dump(company()->total_usage / 1000, company()->total_data) --}}
                                    <div class="absolute h-5 bg-gradient-to-r {{ company()->getUsageClass() }} rounded-l-lg"
                                        style="width: {{ (max(toGB(company()->total_usage), 1) / max(company()->total_data, toGB(company()->total_usage))) * 100 }}%">
                                        <div class="absolute right-0 w-1 h-10 border-r border-gray-600 border-dashed -top-5 ">
                                            <div class="relative flex flex-col w-56  -mt-1 @if('high' == $usage_level) text-right transform -translate-x-full -mr-3 @else ml-2 @endif">
                                                <small class="text-xs">Nyttjar idag</small>
                                                <small class="mt-2 font-semibold text-tkblue-500">{{ number_format(toGB(company()->total_usage), 0) }} GB</small>
                                            </div>
                                        </div>
                                        {{-- <div class="absolute right-0 bg-green-500">
                                            csdcsd
                                        </div> --}}
                                    </div>
                                </div>

                                <div></div>

                                <div class="relative w-full mt-6 sm:h-6 sm:mt-2">
                                    <div style="width: {{ ($this->selected_totals['data'] / company()->total_data) * 100 }}%; max-width: 100%;"
                                        class="absolute h-5 transition-all duration-700 ease-in-out @if($this->selected_totals['data'] > company()->total_data) bg-tkteal-500 @else bg-tkblue-500 @endif rounded-l-lg">
                                        <div class="absolute right-0 w-1 h-10 border-r border-gray-600 border-dashed ">
                                        </div>
                                        <span class="absolute right-0 w-40 pr-2 text-right -bottom-6">
                                            <small>{{ __('Bästa optimering') }}</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="mt-12 rounded-md " :class="show ? 'shadow-md' : 'shadow-sm'" x-data="{show: true, toggle(){ this.show = !this.show} }">
                        <div >
                            <header class="flex items-center justify-between p-4 cursor-pointer bg-tkteal-200 rounded-t-md" @click.prevent="toggle">
                                <h3 class="text-lg font-semibold text-tkblue-500"">Uträkning</h3>
                                <x-heroicon-o-chevron-down class="w-6 h-6 ml-2" x-show="!show" />
                                <x-heroicon-o-chevron-up class="w-6 h-6 ml-2" x-show="show" />
                            </header>
                            <div class="w-full p-3" x-show="show" 
                            x-transition.opacity.origin.top >
                                <x-company.order-table :plans="$this->selectedOfferPlans" :total="$this->selectedOfferTotal" />
                                
                                    <div class="mt-4"><small >Alla kostnader visas exkl. moms</small></div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="mt-6 comments">
                            @if (company()->extra)
                                <h3 class="text-lg font-bold text-tkblue-500">{{ __('Övriga kommentarer') }}</h3>

                                <div class="p-4 mt-2 bg-gray-100 rounded-lg text-tkblue-500">
                                    {{ company()->extra }}
                                </div>
                            @endif
                        </div>
                        
                    </section>
                @endunless
               
            </div>
        </div>
    </section>
    <section class="flex flex-col justify-end gap-4 p-6 sm:space-x-4 sm:gap-0 sm:flex-row">
        <x-button lg icon="pencil" wire:click="setAdjust({{ $this->selectedOffer->id }})"
            class="flex items-center text-center rounded-full text-tkblue-500 dark:text-tkblue-500 bg-tkorange-500 hover:bg-tkblue-500 dark:bg-tkorange-500 hover:text-white">
            <div class="w-full font-bold text-center ">Anpassa</div>
        </x-button>
        <x-button lg primary wire:click.prevent="startOrder" class="flex items-center text-center rounded-full text-tkblue-500 bg-tkteal-500 hover:bg-tkblue-500 hover:text-white" right-icon="arrow-right" >
            <div class="font-bold text-center "> {{ __('Beställ abonnemang') }}</div>
        </x-button>
    </section>
</div>
