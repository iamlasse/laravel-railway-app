    <x-slot name="menu_header">
        <a href="{{ route('admin.company.index') }}">
            <x-heroicon-s-arrow-sm-left class="w-6 h-6 mr-3 text-tkteal-500" />
        </a>
        <h2 class="text-2xl font-bold text-tkteal-500">{{ $company->name }}</h2>
    </x-slot>

    <div x-data="{}">
        <div class="flex flex-col items-center gap-2 py-6 sm:flex-row justfy-between xl:px-12">
            <div class="w-full sm:w-1/2">
                @if ($company->hasOfferExpiration())
                    <div class="flex items-center px-4 py-2 leading-none text-indigo-100 rounded-lg bg-telekom-darkblue lg:inline-flex"
                        role="alert">
                        <x-heroicon-o-information-circle class="w-5 h-5 mr-2" />
                        <h4>Offerten är giltig t.o.m. {{ $company->offer_ends_at->format('d M Y') }}</h4>
                    </div>
                @endif
            </div>
            <div class="flex flex-grow space-x-2 sm:justify-end actions ">
                @if ($company->hasCurrentOffer())
                    <x-button  primary right-icon="upload" class="font-semibold text-tkblue-500"
                        wire:click.prevent="$emit('openModal', 'admin.import-subscriptions-modal', {{ json_encode(['companyId' => $company->id]) }})"
                        primary md>Importera abonnemang</x-button>
                @endif
                @unless($company->hasOfferExpiration())
                    <x-button dark  wire:click.prevent='startCompany' spinner='startCompany' dark md>Starta Offert</x-button>
                @endunless
                @if (auth()->user()->is($company->rep))
                    <x-button negative wire:click.prevent='deleteCompany' spinner='terminateCompany' md>Radera
                    </x-button>
                @endif
            </div>
        </div>





        <div class="pb-16 wrapper xl:px-12 sm:pb-0">
            <livewire:admin.company-edit-form :company='$company' wire:key='{{ $company->id }}-edit-form'>
            <livewire:admin.edit.company-details :company="$company" wire:key="{{ $company->id }}-edit-details" />
            <livewire:admin.company-offers :company='$company' wire:key="{{ $company->id }}-offers" />

            <x-toggle-box show="true">
                <x-slot name="title">
                    Abonnemang
                </x-slot>
                @if ($company->hasCurrentOffer())
                    <livewire:admin.subscriptions-table :company='$company'
                        wire:key='subscriptions-{{ $company->id }}' />
                @else
                    <div class="flex items-center justify-center space-x-2">
                        <h3 class="font-semibold text-center">Välg en operatör som nuvarande för att importera
                            abonnemang.</h3>
                    </div>
                @endif
            </x-toggle-box>
        </div>
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
