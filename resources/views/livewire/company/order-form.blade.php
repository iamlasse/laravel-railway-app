<div class="px-4 mb-24 sm:mb-auto 2xl:px-0">
    <div class="mx-auto mt-6 rounded-lg max-w-7xl">
        <form wire:submit.prevent="confirmOrder">
            @csrf
           <div class="my-2 bg-white rounded-xl text-tkblue-500"> {{ $this->companyForm }}</div>
            <div class="my-2 bg-white text-tkblue-500 rounded-xl">{{ $this->addressForm }}</div>
            <div class="my-2 bg-white text-tkblue-500 rounded-xl">{{ $this->customerForm }}</div>

            <div class="flex flex-col justify-end gap-4 mt-6 sm:flex-row sm:space-x-2">
                <x-button rounded lg right-icon="pencil" label="{{ __('Anpassa') }}" class="font-semibold bg-tkorange-500 text-tkblue-500 hover:bg-tkblue-500 hover:text-white"
                    wire:click.prevent="adjustOrder" />
                <x-button primary rounded lg type="submit" right-icon="arrow-right"  class="font-semibold text-tkblue-500 hover:bg-tkblue-500 hover:text-white"
                    label="  {{ __('Bekräfta beställning') }}" />
            </div>
        </form>

    </div>
</div>
