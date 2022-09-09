<div class="offers-wrapper">
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Insikter & Trender') }}
            </h2>
            <h3 class="text-xl font-semibold">{{ optional($company->currentOffer)->getOperator()['name'] ?? ''}}</h3>
        </div>
    </x-slot>
    @forelse ($company->offers as $offer)
    <div class="py-4 offer">
        <div class="flex flex-col items-center justify-center space-y-6 offer-header sm:space-y-0 sm:justify-between sm:flex-row ">
            <div class="left">
                <img class="object-fill" src="{{ asset($offer->getOperator()['logo']) }}" />
            </div>
            <div class="flex space-x-4 right">
                <div class="button">
                    <h4 class="-mt-2 text-xs font-semibold text-telekom-300">Växellev idag</h4>
                    @livewire('utils.toggle-switch', ['model' => $offer, 'attribute' => 'is_current_vaxel'], key("toggle-{{ $loop->index }}-is_current_vaxel-{{ $offer->is_current_vaxel ? 'active' : 'inactive' }}"))
                    
                </div>
                <div class="button">
                    <h4 class="-mt-2 text-xs font-semibold text-telekom-300">Operatör idag</h4>
                    @livewire('utils.toggle-switch', ['model' => $offer, 'attribute' => 'is_current_operator'], key("toggle-{{ $loop->index }}-is_current_operator-{{ $offer->is_current_operator ? 'active' : 'inactive' }}"))
                </div>
                <div class="button">
                    <h4 class="-mt-2 text-xs font-semibold text-telekom-300">Rekommendera</h4>
                    @livewire('utils.toggle-switch', ['model' => $offer, 'attribute' => 'is_recommended'], key("toggle-{{ $loop->index }}-is_recommended-{{ $offer->is_recommended ? 'active' : 'inactive' }}"))
                </div>
            </div>
        </div>
        <livewire:admin.offer-plan-table :offer='$offer' :subscriptions="$company->subscriptions" wire:key="{{$offer->id}}" />
    </div>
    @empty

    @endforelse
</div>