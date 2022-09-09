<div class="flex flex-col mt-6 mb-12 space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0 top"
    x-data="{ showSaveButton: @entangle('showSaveButton'), disabled: @entangle('disabled'), flash: false  }">
    <div class="sm:w-4/6">
        <x-toggle-box class="flex-grow" show="true">
            <x-slot name="title">
                Ifylles av kundansvarig
            </x-slot>


            <div class="flex flex-col w-full space-y-2 sm:space-x-10 sm:space-y-0 sm:flex-row fields">
                <div class="w-full sm:w-3/5 left">
                        <x-select
                        label="Välj Kundansvarig"
                        placeholder="Välj Kundansvarig"
                        wire:model.lazy="companyRep"
                    >
                        @foreach ($reps as $rep)
                            <x-select.user-option :img="$rep->profile_photo_url" :label="$rep->name" :value="$rep->id" />
                        @endforeach
                    </x-select>

                    <div class="pt-2 border-t sm:mt-8 border-telekom-300">
                        <h4 class="mb-4 font-semibold text-md">Välj period för datainsamling</h4>
                        <div class="flex flex-col space-y-4">
                            <div>
                                <span class="flex items-center justify-between">
                                    <small class="font-semibold">Startdatum</small>
                                    <small class="text-xs">{{optional($company->period_starts_at)->format('Y-m-d') ?? ''}}</small>
                                </span>
                                <x-datetime-picker 
                                    without-time 
                                    placeholder="Start datum"
                                    display-format="YYYY-MM-DD"
                                    wire:model.lazy="companyEditForm.period_starts_at" />
                            </div>
                            <div>
                                <span class="flex items-center justify-between">
                                    <small class="font-semibold">Slutdatum</small>
                                    <small class="text-xs">{{optional($company->period_ends_at)->format('Y-m-d') ?? ''}}</small>
                                </span>
                                <x-datetime-picker 
                                    without-time  
                                    placeholder="Slut datum"
                                    display-format="YYYY-MM-DD"
                                    wire:model.lazy="companyEditForm.period_ends_at" :min="$company->period_starts_at" />
                            </div>
        
                        </div>
                        <div class="flex items-center justify-end mt-2 action">
                            <x-button class="font-semibold text-tkblue-500" :disabled="!$this->isDatesDirty()" primary wire:click.prevent="saveCompanyDates" spinner="saveCompanyDates">Spara period</x-button>
                        </div>
                    </div>
                </div>
                
                <div class="w-full sm:w2/5 right">
                    <div class="flex justify-end mb-4" x-show="showSaveButton">

                        <div class="flex space-x-2 ">
                            <span x-show="flash" x-transition.duration.300ms
                                class="p-2 text-xs font-semibold transition-all duration-300 rounded-lg opacity-50 bg-telekom-100 ">Sparad...</span>
                            <x-button primary
                                class="ml-2 font-semibold transition-all duration-300 text-tkblue-500 disabled:cursor-not-allowed"
                                spinner="saveCompanyDetails" wire:click="saveCompanyDetails"
                                x-on:click="setTimeout(() => { flash = true; }, 500); setTimeout(() => { flash = false; showSaveButton = false }, 1500)"
                                x-bind:disabled="disabled">
                                Spara
                            </x-button>
                        </div>
                    </div>
                    <div class="space-y-4 flex-flex-col">
                        <div class="flex flex-col p-4 bg-white rounded-lg shadow-sm today">
                            <h4 class="mb-2 font-semibold">{{ __('Fasta kostnader idag per månad') }}</h4>

                            <div class="w-full mt-0 sm:w-48">

                                <div class="flex">
                                    <x-inputs.currency id="current_monthly_cost" prefix="Kr" precision="0"
                                        wire:model.lazy="companyEditForm.current_monthly_cost" />
                                </div>
                            </div>

                        </div>
                        <div class="flex flex-col p-4 bg-white rounded-lg shadow-sm today">
                            <h4 class="mb-2 font-semibold">{{ __('Rörliga kostnader idag per månad') }}</h4>

                            <div class="w-full mt-0 sm:w-48">

                                <div class="flex">
                                    <x-inputs.currency id="current_monthly_cost" prefix="Kr" precision="0"
                                        wire:model.lazy="companyEditForm.current_monthly_flex_cost" />
                                </div>
                            </div>

                        </div>
                        <div class="flex flex-col p-4 bg-white rounded-lg shadow-sm overpaid">
                            <h4 class="mb-2 font-semibold">{{ __('Överdebitering') }}</h4>
                            <div class="w-48">

                                <div class="flex">
                                    <x-inputs.currency precision="0" prefix="Kr"
                                        wire:model.lazy="companyEditForm.over_paying" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-toggle-box>
    </div>
    <div class="sm:w-2/6">
        <x-toggle-box show="true">
            <x-slot name="title">
                Övrigt
            </x-slot>
            <livewire:admin.company-extra-field :company="$company" :extra="$company->extra" :wire:key="$company->id" />
        </x-toggle-box>
    </div>
</div>
