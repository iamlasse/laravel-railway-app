<div class="subscriptions--wrapper">
    <div class="px-5 pt-0 sm:px-0">
        <!-- Top Bar -->
        @unless (in_array('filters', $hide))
        <div class="flex flex-col justify-between pb-4 mt-4 sm:mt-0 sm:px-4 sm:py-4 sm:flex-row">
            <div class="flex items-center w-full space-x-4 sm:w-2/4">
                <div class="w-3/6">
                    <x-input.text class="py-2" wire:model="filters.search" placeholder="Sök på abonnemang…" />
                </div>
                <div class="flex items-center w-3/6 space-x-4">
                    <x-input.select wire:model="filters.type" id="filter-status">
                        <option value="" selected>Visa typ</option>

                        @foreach (['DK', 'M', 'MB'] as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </x-input.select>

                    @if(!empty($filters['status']))
                    <x-button type="link" wire:click="resetFilters" class="p-4">&times;</x-button>
                    @endif

                </div>
            </div>

          
            <div class="flex flex-col items-center justify-end w-full space-y-2 sm:space-y-0 sm:space-x-2 sm:w-2/4 sm:flex-row">
                
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-semibold">Per Sida</span>
                    <x-input.select wire:model="perPage" id="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </x-input.select>
                </div>
                <x-button xs primary wire:click="$emit('openModal', 'admin.import-subscriptions-modal', {{ json_encode(['companyId' => $company->id])}})" class="font-semibold text-tkblue-500">
                    <span class="font-semibold">{{__('Importera')}}</span> <x-heroicon-s-upload class="w-4 h-4 ml-2" />
                </x-button>
                <x-button xs primary wire:click="$emit('openModal', 'admin.create-subscription-modal', {{ json_encode(['companyId' => $company->id])}})" class="font-semibold text-tkblue-500">
                    <span class="font-semibold">{{__('Nytt abonnemang')}}</span> <x-heroicon-s-plus class="w-4 h-4 ml-2" />
                </x-button>
                
                @if ($selectPage || $selectAll || count($selected) >= 1)
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-button outline blue xs class="font-semibold" right-icon="chevron-down" label="{{__('Massåtgärder')}}" />
                    </x-slot>
                    <x-dropdown.item type="button" wire:click="$emit('openModal', 'admin.edit-subscriptions-modal', {{ json_encode(['subscriptions' => $selected, 'all' => $selectAll]) }})" class="flex items-center space-x-2">
                        <x-heroicon-o-refresh class="w-4 h-4 text-cool-gray-400"/> <span>Uppdatera Planer</span>
                    </x-dropdown.item>
                    <x-dropdown.item type="button" icon="trash"
                                                x-data="{ title: 'Radera abonnemang?', description: 'Abonnemang och tilldelade pris planer kommer raderas. Du kan skapa dem på nytt vid attt lägga till ett abonnemang.' }"
                                                x-on:confirm="{
                                                    title,
                                                    description,
                                                    icon: 'warning',
                                                    accept: {
                                                        label: 'Ja tack, Radera dessa',
                                                        color: 'negative'
                                                    },
                                                    reject: {
                                                        label: 'Nej tack',
                                                    },
                                                    method: 'deleteSubscriptions'
                                                }">
                                                    <div
                                                        class="flex items-center space-x-2">
                                                        <span>Radera Valda</span>
                                                    </div>
                                                </x-dropdown.item>
                </x-dropdown>
                @endif
            </div>
        </div>
        @endunless

        <!-- Advanced Search -->
        <div>
            @if ($showFilters)
            <div class="relative flex p-4 rounded shadow-inner bg-cool-gray-200">
                <div class="w-1/2 pr-2 space-y-4">
                    <x-input.group inline for="filter-status" label="Status">
                        <x-input.select wire:model="filters.status" id="filter-status">
                            <option value="" disabled>Välj Status...</option>

                            @foreach (App\Models\Subscription::getStatuses() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    {{-- <x-input.group inline for="filter-amount-min" label="Minimum Amount">
                        <x-input.money wire:model.lazy="filters.amount-min" id="filter-amount-min" />
                    </x-input.group>

                    <x-input.group inline for="filter-amount-max" label="Maximum Amount">
                        <x-input.money wire:model.lazy="filters.amount-max" id="filter-amount-max" />
                    </x-input.group> --}}
                </div>

                <div class="w-1/2 pl-2 space-y-4">
                    {{-- <x-input.group inline for="filter-date-min" label="Minimum Date">
                        <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="MM/DD/YYYY" />
                    </x-input.group>

                    <x-input.group inline for="filter-date-max" label="Maximum Date">
                        <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="MM/DD/YYYY" />
                    </x-input.group> --}}

                    <x-button wire:click="resetFilters" class="absolute bottom-0 right-0 p-4">Reset Filters</x-button>
                </div>
            </div>
            @endif
        </div>
        {{-- TABLE --}}

        <x-table>
            <x-slot name="head">
                @unless (in_array('filters', $hide))
                <x-table.heading class="w-8 px-6 pr-0">
                    <x-checkbox wire:model="selectPage" />
                </x-table.heading>
                @endunless
                @unless (in_array('filters', $hide))
                <x-table.heading class="px-6" sortable multi-column wire:click="sortBy('type')" :direction="$sorts['type'] ?? null">
                    {{ __('telekom.type') }}
                </x-table.heading>
                @endunless
                @unless (in_array('expires', $hide))
                <x-table.heading class="px-6" sortable multi-column wire:click="sortBy('type')" :direction="$sorts['type'] ?? null">
                    {{ __('telekom.subscription.expires') }}
                </x-table.heading>
                @endunless
                <x-table.heading class="px-6" sortable multi-column wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">
                    {{ __('telekom.users') }}
                </x-table.heading>
                <x-table.heading class="pl-6" sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status
                </x-table.heading>
                <x-table.heading class="min-w-72" sortable multi-column wire:click="sortBy('department')" :direction="$sorts['department'] ?? null">{{ __('telekom.department') }}
                    
                </x-table.heading>
                <x-table.heading sortable multi-column wire:click="sortBy('current_plan_usage')" :direction="$sorts['current_plan_usage'] ?? null">{{ __('telekom.usage') }}
                </x-table.heading>
                @foreach (operators() as $operator)
                    <x-table.heading class="min-w-48">
                        {{ $operator['name'] }}
                     </x-table.heading>
                @endforeach
                
                @unless (in_array('actions', $hide))
                    <x-table.heading>Actions</x-table.heading>
                @endunless

            </x-slot>

            <x-slot name="body">
            @unless (in_array('filters', $hide))
                @if ($selectPage ?? '')
                <x-table.row class="bg-tkteal-50" wire:key="select-message">
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
                <x-table.row wire:key="subscription-{{ $subscription->id }}" class="cursor-pointer transition-all duration-300 hover:bg-tkteal-50 {{ $loop->index % 2 == 0 ? 'bg-gray-100' : ''}}">
                @unless (in_array('filters', $hide))
                    <x-table.cell class="pr-0">
                        <x-checkbox wire:model="selected" value="{{ $subscription->id }}" />
                    </x-table.cell>
                    @endunless

                    @unless (in_array('filters', $hide))
                    <x-table.cell>
                        <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                            <p class="truncate text-cool-gray-600">
                                {{ $subscription->type }}
                            </p>
                        </span>
                    </x-table.cell>
                    @endunless

                    @unless (in_array('expires', $hide))
                    <x-table.cell>
                        <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                            <p class="truncate text-cool-gray-600">
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
                        <div class="flex flex-col items-start">
                            <div class="flex items-center justify-center px-2 py-1 text-xs rounded-full {{ $subscription->getClasses('status')['label'] }}">
                                <span class="w-2 h-2 mr-1 {{ $subscription->getClasses('status')['dot'] }} rounded-full">
                                    &nbsp;
                                </span>
                                {{ $subscription->statusText }}
                            </div>
                        </div>
                    </x-table.cell>

                    <x-table.cell>
                        <div class="flex items-center justify-start">
                            <span class="text-sm">{{ $subscription->department }}</span>
                        </div>
                    </x-table.cell>

                    <x-table.cell>
                        <div class="flex flex-col items-start">
                            <div class="flex items-center justify-center px-2 py-1 text-xs rounded-full {{ $subscription->getClasses('usage')['label'] }}">
                                <span class="w-2 h-2 mr-1 {{ $subscription->getClasses('usage')['dot'] }} rounded-full">
                                    &nbsp;
                                </span>
                                {{ $subscription->usage_level_text }}
                            </div>
                            <span class="mt-1 text-xs text-gray-800 ">

                                {{ $subscription->usage_text }}
                            </span>
                        </div>
                    </x-table.cell>
                    @if($subscription->isActive() && !$subscription->shouldBeCancelled())
                        @foreach (operators() as $operator)
                            <x-table.cell class="min-w-48">
                                <div class="text-center">
                                    @php
                                    $data = $this->getPlanData($operator['id'], $subscription->id);
                                @endphp
                            @if ($data)
                            {{ $data }} GB
                            @endif
                                </div>
                            </x-table.cell>
                        @endforeach
                    @else
                        @foreach (operators() as $operator)
                            <x-table.cell class="">
                                <div class="text-center">
                                <span class="text-xs text-red-800">Avslutas</span>
                            </div>
                            </x-table.cell>
                        @endforeach
                    @endif
                    @unless (in_array('actions', $hide))
                    <x-table.cell>
                        <div class="flex flex-row items-center justify-center">
                            <x-button class="font-semibold text-tkblue-500" flat xs primary wire:click.prevent="$emit('openModal', 'admin.edit-subscription-modal', {{ json_encode(['subscriptionId' => $subscription->id])}})">Edit</x-button>                           
                        </div>
                    </x-table.cell>
                    @endunless
                </x-table.row>
                @empty
                <x-table.row>
                    <x-table.cell colspan="{{ 8 + operators()->count() }}">
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

        <div class="flex flex-col items-center p-6 legend sm:flex-row">
            <h4 class="mr-3 text-sm font-semibold">Typförklaring</h4>
            <ul class="flex flex-col text-xs sm:space-x-4 sm:flex-row">
                <li>M: Mobilabonnemang</li>
                <li>MB: Mobilt bredband</li>
                <li>DK: Datakort</li>
            </ul>
        </div>


        {{-- TABLE END --}}
    </div>
</div>
