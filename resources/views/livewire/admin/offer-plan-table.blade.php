<div class="mt-6 mb-6 offer-table" x-data="{ 
        selectedPlanId: @entangle('selectedPlanId'), 
        selectedRow: @entangle('selectedRow'), 
        offerId: {{ $this->offer->id }}, 
        editField: @entangle('editField'),
        updateField: (field, value) => {
            console.log('Selected Row', this.selectedRow)
            console.log('Update field', field)
            console.log('Update value', value)
            $wire.updatePlan(field, value)
        },
        resetField: (e) => {
            console.log('Reset Fields', e)
            this.selectedPlanId = null;
            this.selectedRow = [];
        },
        setField: function(planId, field) {
            $wire.selectPlanFieldToEdit(planId, field);
            $nextTick(() => { 
                document.getElementById(field + '_' + planId).focus(); 
                document.getElementById(field + '_' + planId).select(); 
                console.log('Set field', planId, field, this.selectedRow)
            })
        }
    }">
    
    <x-table>
        <x-slot name="head">
            <x-table.heading class="px-6 text-left" multi-column>
                {{ __('telekom.plan.name') }}
            </x-table.heading>
            <x-table.heading class="px-6" multi-column>
                {{ __('telekom.plan.data') }}
            </x-table.heading>
            <x-table.heading class="px-6" multi-column>
                {{ __('telekom.plan.price_org') }}
            </x-table.heading>
            <x-table.heading class="px-6" multi-column>
                {{ __('telekom.plan.price_new') }}
            </x-table.heading>
            <x-table.heading class="px-6" multi-column>
                {{ __('telekom.plan.amount') }}
            </x-table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse ($this->planRows as $plan)
                
                <x-table.row wire:key="plan-{{ $plan->plan_id }}">
                    <x-table.cell class="w-80">
                        <div class="text-left cell">
                            {{ $plan->name }}
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="text-center cell">
                            
                            @unless($plan->data === 500 || $plan->data == 0)
                                {{ $plan->data }} Gb
                            @else
                                ~
                            @endunless
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="text-center cell">
                            {{ $plan->price }} Kr.
                        </div>
                    </x-table.cell>
                    <x-table.cell class="w-40">
                        <div class="flex flex-row items-center justify-center w-full px-2 text-center transition-colors rounded-lg cell"
                            :class="{'bg-green-100': flash, 'border border-blue-300': showEdit }" x-data="{ showEdit: false, flash: false, model: {{json_encode($plan)}} }">
                            <input x-show="showEdit" x-bind:id="'price_new_' + model.plan_id" tabindex="{{ $loop->index }}" type="text"
                                class="w-16 px-2 py-1 text-center border-0 border-opacity-0 max-w-30 focus:outline-none focus:border-0 active:border-0 active:outline-none"
                                x-model="model.price_new" 
                                @keydown.enter="updateField('price_new', model.price_new); showEdit = false; flash = true; setTimeout(() => flash = false, 1000)"
                                x-on:keyup.tab.prevent="updateField('price_new', model.price_new); showEdit = false; flash = true; setTimeout(() => flash = false, 1000)" 
                                x-on:keyup.escape="resetField(); showEdit = false"
                                x-on:click.away="showEdit = false"
                                x-on:blur="showEdit = false" />

                            <span class="flex items-center space-x-2"
                                x-on:click.prevent="setField(model.plan_id, 'price_new'); showEdit = true;"
                                x-show="!showEdit">@unless(is_null($plan->price_new)){{ $plan->price_new  }} Kr.  @endunless
                                <x-heroicon-s-pencil class="w-3 h-3 ml-2 cursor-pointer" />
                            </span>
                          
                            <button x-show="showEdit"><x-heroicon-s-check-circle class="w-4 h-4 ml-2 text-green-500 cursor-pointer" /></button>
                        </div>
                    </x-table.cell>
                    <x-table.cell class="w-40">
                        <div class="flex flex-row items-center justify-center w-full px-2 text-center transition-colors rounded-lg cell" >
                            {{ $plan->subscriptions_count ?? 0 }}
                        </div>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>

                </x-table.row>
            @endforelse
            @forelse ($this->vaxelPlanRows as $vaxelPlan)
                <x-table.row wire:key="plan-{{ $vaxelPlan->plan_id }}">
                    <x-table.cell class="w-80">
                        {{ $vaxelPlan->name }}
                    </x-table.cell>
                    <x-table.cell>
                        <div class="text-center cell">
                            ~
                        </div>
                    </x-table.cell>
                    
                    <x-table.cell>
                        <div class="text-center cell">
                        {{ $vaxelPlan->price }} Kr.
                        </div>
                    </x-table.cell>
                    
                    <x-table.cell class="w-40">
                        <div class="flex flex-row items-center justify-center w-full px-2 text-center transition-colors rounded-lg cell"
                            :class="{'bg-green-100': flash, 'border border-blue-300': showEdit }" x-data="{ showEdit: false, flash: false, model: {{json_encode($vaxelPlan)}} }">
                            <input x-show="showEdit" x-bind:id="'price_new_' + model.vaxel_plan_id" tabindex="{{ $loop->index }}" type="text"
                                class="w-16 px-2 py-1 text-center border-0 border-opacity-0 max-w-30 focus:outline-none focus:border-0 active:border-0 active:outline-none"
                                x-model="model.price_new" 
                                @keydown.enter="updateField('price_new', model.price_new); showEdit = false; flash = true; setTimeout(() => flash = false, 1000)"
                                x-on:keyup.tab.prevent="updateField('price_new', model.price_new); showEdit = false; flash = true; setTimeout(() => flash = false, 1000)" 
                                x-on:keyup.escape="resetField(); showEdit = false"
                                x-on:click.away="showEdit = false"
                                x-on:blur="showEdit = false" />

                            <span class="flex items-center space-x-2"
                                x-on:click.prevent="setField(model.vaxel_plan_id, 'price_new'); showEdit = true;"
                                x-show="!showEdit">@unless(is_null($vaxelPlan->price_new)){{ $vaxelPlan->price_new  }} Kr.  @endunless
                                <x-heroicon-s-pencil class="w-3 h-3 ml-2 cursor-pointer" />
                            </span>
                          
                            <button x-show="showEdit"><x-heroicon-s-check-circle class="w-4 h-4 ml-2 text-green-500 cursor-pointer" /></button>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex flex-row items-center justify-center w-full px-2 text-center transition-colors rounded-lg cell" >
                        {{ $vaxelPlan->subscriptions_count }}
                        </div>
                    </x-table.cell>
                    
                </x-table.row>
            @empty
                
            @endforelse
        </x-slot>
    </x-table>

</div>
