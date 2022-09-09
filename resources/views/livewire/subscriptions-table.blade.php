<div class="subscriptions--wrapper">
    <div class="px-5 pt-0 sm:px-0">
        <!-- Top Bar -->
        <div class="flex justify-between px-4 py-4 pb-4">
            <div class="flex items-center w-2/4 space-x-4">
                @unless(in_array('filters', $hide))
                    <div class="w-3/6">
                        <x-input.text class="py-2" wire:model="filters.search" placeholder="Sök på abonnemang…" />
                    </div>
                    <div class="flex items-center w-3/6 space-x-4">
                        <x-input.select wire:model="filters.type" id="filter-status">
                            <option value="" selected>Visa typ</option>

                            @foreach (['DK' => 'Datakort', 'M' => 'Mobilabonnemang', 'MB' => 'Mobilt bredband'] as $type => $label)
                                <option value="{{ $type }}">{{ $label }}</option>
                            @endforeach
                        </x-input.select>
                        @if (!empty($filters['status']))
                            <x-button.link wire:click="resetFilters" class="p-4">&times;</x-button.link>
                        @endif

                    </div>
                @endunless
            </div>
            <div class="flex items-center justify-end sm:space-x-4">
                <span class="mr-3 text-xs font-semibold">{{ __('Per Page') }}</span>
                <x-input.select wire:model="perPage" id="perPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </x-input.select>
                @unless(in_array('create', $hide))
                    <x-button xs primary
                        class="ml-4 text-tkblue-500 dark:bg-tkteal-500 dark:text-tkblue-500 hover:bg-tkblue-500 hover:text-white"
                        right-icon='plus'
                        wire:click="$emit('openModal', 'company.create-subscription-modal', {{ json_encode(['companyId' => $model->id]) }})">
                        <span class="font-semibold"> {{ __('Nytt abonnemang') }}</span>
                    </x-button>
                @endunless

                @if ($selectPage || $selectAll || count($selected) >= 1)
                    <x-dropdown>
                        <x-slot name="trigger">
                            <x-button xs primary class="font-semibold text-tkblue-500 dark:bg-tkteal-500 dark:text-tkblue-500 hover:bg-tkblue-500 hover:text-white" >
                                {{ __('Massåtgärder') }}
                                <x-heroicon-s-chevron-down class="w-4 h-4 ml-2" />
                            </x-button>
                        </x-slot>
                        <x-dropdown.item type="button"
                            wire:click="$emit('openModal', 'company.edit-subscriptions-modal', {{ json_encode(['subscriptions' => $selected, 'all' => $selectAll, 'operatorId' => $operatorId]) }})"
                            class="flex items-center space-x-2">
                            <x-heroicon-o-refresh class="w-4 h-4 text-cool-gray-400" /> <span>Uppdatera Planer</span>
                        </x-dropdown.item>
                    </x-dropdown>
                @endif
            </div>

        </div>

        {{-- TABLE --}}

        <x-table>
            <x-slot name="head">
                @unless(in_array('filters', $hide))
                    <x-table.heading class="w-8 px-6 pr-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                @endunless
                @unless(in_array('type', $hide))
                    <x-table.heading class="px-6" sortable multi-column wire:click="sortBy('type')"
                        :direction="$sorts['type'] ?? null">
                        {{ __('telekom.type') }}
                    </x-table.heading>
                @endunless
                <x-table.heading class="pl-6" sortable multi-column wire:click="sortBy('status')"
                :direction="$sorts['status'] ?? null">Aktivt
                </x-table.heading>
                @unless(in_array('expires', $hide))
                    <x-table.heading class="px-6" sortable multi-column wire:click="sortBy('name')"
                        :direction="$sorts['name'] ?? null">
                        {{ __('telekom.subscription.expires') }}
                    </x-table.heading>
                @endunless
                <x-table.heading class="px-6" sortable multi-column wire:click="sortBy('name')"
                    :direction="$sorts['name'] ?? null">
                    {{ __('telekom.users') }}
                </x-table.heading>
             
                <x-table.heading class="min-w-72" sortable multi-column wire:click="sortBy('department')"
                    :direction="$sorts['department'] ?? null">{{ __('telekom.department') }}
                </x-table.heading>
                <x-table.heading sortable multi-column wire:click="sortBy('current_plan_usage')"
                    :direction="$sorts['usage'] ?? null">{{ __('telekom.usage') }}
                </x-table.heading>
                @unless(in_array('vaxel', $hide))
                    <x-table.heading>{{ __('telekom.vaxel') }}</x-table.heading>
                @endunless
                @unless(in_array('new_plan', $hide))
                    <x-table.heading class="min-w-82">Ny Prisplan</x-table.heading>
                @endunless
                @unless(in_array('actions', $hide))
                    <x-table.heading></x-table.heading>
                @endunless

            </x-slot>

            <x-slot name="body">
                @unless(in_array('filters', $hide))
                    @if ($selectPage ?? '')
                        <x-table.row class="bg-indigo-100" wire:key="select-message">
                            <x-table.cell colspan="{{ operators()->count() + 8 }}">
                                @unless($selectAll)
                                    <div>
                                        <span>Du har valt <strong>{{ $subscriptions->count() }}</strong>
                                            abonnemang, vill du välja alla
                                            <strong>{{ $subscriptions->total() }}</strong>?</span>
                                        <a href="#" wire:click.prevent="selectAll" class="ml-1 text-blue-600">Välj Alla</a>

                                    </div>
                                @else
                                    <span>Du har valt
                                        <strong>{{ $subscriptions->total() }}</strong> abonnemang.</span>
                        @endif
                        </x-table.cell>
                        </x-table.row>
                        @endif
                    @endunless

                    @forelse ($subscriptions as $subscription)
                        <x-table.row wire:loading.class.delay="opacity-50"
                            wire:key="subscription-{{ $subscription->id }}"
                            class="cursor-pointer transition-all duration-300 hover:bg-tkteal-50 {{ $loop->index % 2 == 0 ? 'bg-gray-100' : '' }}">
                            @unless(in_array('filters', $hide))
                                <x-table.cell class="pr-0">
                                    <x-input.checkbox wire:model="selected" value="{{ $subscription->id }}" />
                                </x-table.cell>
                            @endunless

                            @unless(in_array('type', $hide))
                                <x-table.cell>
                                    <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                                        <p class="truncate text-cool-gray-600">
                                            {{ $subscription->type }}
                                        </p>
                                    </span>
                                </x-table.cell>
                            @endunless

                            <x-table.cell>
                                <div class="flex flex-col items-center">
                                    @if ($subscription->isActive() && !$subscription->shouldBeCancelled())

                                        <div
                                            class="flex items-center justify-center w-3 h-3 text-xs bg-green-400 rounded-full shadow-md">
                                        </div>
                                    @else
                                        <small class="text-xs text-telekom-600">Avslutas</small>
                                    @endif
                                    <span class="mt-1 text-xs text-gray-800 ">
                                    </span>
                                </div>
                            </x-table.cell>

                            @unless(in_array('expires', $hide))
                                <x-table.cell>
                                    <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                                        <p class="text-xs truncate text-cool-gray-600">
                                            {{ optional($subscription->ends_at)->diffForHumans() ?? '' }}
                                        </p>
                                    </span>
                                </x-table.cell>
                            @endunless

                            <x-table.cell>
                                <div class="flex flex-col items-left">
                                    <span class="text-xs font-semibold">{{ $subscription->name }}</span>
                                    <span class="text-xs numbers">{{ $subscription->numberText }}</span>
                                </div>
                            </x-table.cell>

                          

                            <x-table.cell>
                                <div class="flex items-center justify-start">
                                    <span class="text-xs">{{ $subscription->department }}</span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex flex-col items-start">
                                    <div
                                        class="flex items-center justify-center px-2 py-1 text-xs rounded-full {{ $subscription->getClasses('usage')['label'] }}">
                                        <span
                                            class="w-2 h-2 mr-1 {{ $subscription->getClasses('usage')['dot'] }} rounded-full">
                                            &nbsp;
                                        </span>
                                        {{ $subscription->usage_level_text }}
                                    </div>
                                    <span class="mt-1 text-xs text-gray-800 ">

                                        {{ $subscription->usage_text }}
                                    </span>
                                </div>
                            </x-table.cell>
                            @unless(in_array('vaxel', $hide))
                                <x-table.cell>
                                    <div class="text-xs text-center">
                                        {{ $subscription->vaxel_user ? 'JA' : 'NEJ' }}
                                    </div>
                                </x-table.cell>
                            @endunless
                            @unless(in_array('new_plan', $hide))
                                <x-table.cell>
                                    @if ($operatorId)
                                        @php
                                            $plan = $subscription->plans->where('operator_id', $operatorId)->first();
                                            if ($plan) {
                                                $plan_detail = $this->offerPlans->where('id', $plan->id)->first();
                                            }
                                        @endphp
                                        @if ($plan)
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="text-sm font-semibold truncate">{{ $plan->name }}</span>
                                                <span class="text-sm"> {{ $plan->data }} GB
                                                    <small
                                                        class="ml-2 font-semibold">({{ $plan_detail->price ?? $plan->price }}
                                                        Kr.)</small></span>
                                            </div>
                                        @endif
                                    @endif
                                </x-table.cell>
                            @endunless
                            <x-table.cell>
                                <div class="flex flex-row justify-end">

                                    @unless(in_array('actions.edit', $hide))
                                        <x-button.link wire:click="edit({{ $subscription->id }})">Edit</x-button.link>
                                    @endunless
                                    @unless(in_array('actions.plans', $hide))
                                        @if ($subscription->isActive() && !$subscription->shouldBeCancelled())
                                        <x-dropdown>
                                            <x-slot name="trigger">

                                               <x-button flat sm>
                                                <span class="flex items-center space-x-2 text-xs">Justera
                                                    <x-heroicon-o-dots-vertical class="w-4 h-4 ml-2" />
                                                </span>
                                               </x-button>

                                            </x-slot>
                                                <x-dropdown.header
                                                    label="{{ __('Select New :resource', ['resource' => 'Plan']) }}">
                                                    @foreach ($this->plans->where('operator_id', $operatorId)->where('is_vaxel_plan', false) as $plan)
                                                        <x-dropdown.item
                                                            wire:click.prevent="setSubscriptionPlan({{ $subscription->id }}, {{ $operatorId }}, {{ $plan->id }})">
                                                            @php
                                                                $plan_detail = $this->offerPlans->where('id', $plan->id)->first();
                                                            @endphp
                                                            <span class="text-xs">{{ Str::limit($plan->name, 20) }}
                                                                ({{ $plan_detail->price ?? $plan->price }} kr.)</span>

                                                        </x-dropdown.item>
                                                    @endforeach
                                                </x-dropdown.header>
                                                <x-dropdown.item separator type="button" icon="pencil"
                                                    wire:click.prevent="$emit('openModal', 'company.edit-subscription-modal', {{ json_encode(['subscriptionId' => $subscription->id]) }})">
                                                    <span>Ändra Namn</span>
                                                </x-dropdown.item>

                                                <x-dropdown.item type="button" icon="trash"
                                                x-data="{ title: 'Avsluta abonnemanget?', description: 'Abonnemanget kommer avslutas, vilket betyder det kommer inte räknas med i framtida beställningar' }"
                                                x-on:confirm="{
                                                    title,
                                                    description,
                                                    icon: 'warning',
                                                    accept: {
                                                        label: 'Ja tack, Avsluta',
                                                        color: 'positive'
                                                    },
                                                    reject: {
                                                        label: 'Nej tack',
                                                    },
                                                    method: 'cancelSubscription',
                                                    params: {{ $subscription->id }}
                                                }">
                                                    <div
                                                        class="flex items-center space-x-2">
                                                        <span>Avsluta</span>
                                                    </div>
                                                </x-dropdown.item>
                                                
                                            </x-dropdown>
                                            @endif
                                      @if ($subscription->shouldBeCancelled())
                                      <div x-data="{ title: 'Aktivera abonnemanget?', description: 'Abonnemanget kommer aktiveras, vilket betyder det kommer räknas med i framtida beställningar' }">
                                        <x-button label="Aktivera" flat xs type="button" icon="badge-check"
                                            x-on:confirm="{
                                                title,
                                                description,
                                                icon: 'warning',
                                                accept: {
                                                    label: 'Ja tack, Aktivera',
                                                    color: 'positive'
                                                },
                                                reject: {
                                                    label: 'Nej tack',
                                                },
                                                method: 'activateSubscription',
                                                params: {{ $subscription->id }}
                                            }"
                                        />
                                    </div>
                                      @endif
                                    @endunless  

                                </div>

                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="10">
                                <div class="flex items-center justify-center space-x-6">
                                    <div class="flex items-center space-x-2 header">
                                        <x-heroicon-s-inbox class="w-8 h-8 text-cool-gray-400" />
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">Inga abonnemang</span>
                                    </div>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div class="p-4 bg-gray-100">
                {{ $subscriptions->links() }}
            </div>

            <div class="flex items-center p-4 legend">
                <h4 class="mr-3 text-sm font-semibold">Typförklaring</h4>
                <ul class="flex space-x-4 text-xs">
                    <li>M: Mobil</li>
                    <li>MB: Mobilt bredband</li>
                    <li>DK: Datakort</li>
                </ul>
            </div>
            {{-- TABLE END --}}
        </div>
    </div>
