<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center space-x-4">
                <h2 class="flex items-center space-x-8 text-xl font-semibold leading-tight">
                    {{ __('Anpassa själv') }}
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <h3 class="p-3 text-xl font-semibold bg-white rounded-lg">
                    <img src="{{ asset($operator['logo']) }}" width="100" height="40"
                        style="max-height: 30px; object-fit:contain" alt="">
                </h3>
                
            </div>
        </div>
    </x-slot>
    <div class="flex justify-between px-4 py-4 mx-auto 2xl:px-0 max-w-7xl">
        <x-button 
        href="{{route('company.offers')}}"
        label="Tillbaka till prisförslag"
        icon="arrow-left"
        lg primary rounded class="font-semibold bg-tkteal-500 dark:bg-tkteal-500 text-tkblue-500 dark:text-tkblue-500 hover:bg-tkblue-500 hover:text-white" />
    </div>

    <section class="px-4 mx-auto my-10 2xl:px-0 max-w-7xl">
        <header>
            <h3 class="text-3xl font-bold text-tkblue-600">Anpassa dina abonnemang hos
                "{{ $operator['name'] ?? '' }}"
            </h3>
            <p class="text-base text-tkblue-600">
                Tänk på att datamängden abonnemanget innehåller återspeglar kostnaden per månad. Desto högre datamängd,
                desto högre månadspris.
                <br />
                <br />
                Därför kan du enkelt se vad en användare förbrukat historiskt och snabbt anpassa rätt prisplan på rätt
                person.
                Justera nya abonnemang på individnivå eller gör massåtgärd för ex. olika avdelningar.

            </p>
        </header>
    </section>
    <section class="px-4 mx-auto 2xl:px-0 max-w-7xl">
        <div class="my-10">
            <livewire:subscriptions-table :model='company()' :hide="['actions.edit']"
                wire:key="{{ company()->id }}-subscriptions">
        </div>
    </section>
    @push('scripts')
        <script>
            window.addEventListener('saved', event => {
                console.log('saved?')
                window.notyf.success({
                    message: `${event.detail.message}`
                })
            })
        </script>
    @endpush
</x-app-layout>
