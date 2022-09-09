<x-toggle-box>
    <x-slot name="title">
        {{__('Företagsinformation')}}
    </x-slot>

    <form wire:submit.prevent='saveCompanyInformation' class="w-full ">
        @csrf
        <div class="flex space-y-4">
            <div class="flex-grow">
                {{ $this->companyForm }}
            </div>
        
        </div>
        <div class="flex mt-4 space-x-4">
            <div class="w-1/2">
                {{ $this->addressForm }}
            </div>
            <div class="w-1/2">
            {{ $this->contactForm }}
            </div>
            
        </div>


        <div class="flex justify-end mt-4 space-x-2 actions">
            <x-button spinner="saveCompanyInformation" type="submit" primary md class="font-semibold text-tkblue-500">
                {{__('Save')}}
            </x-button>
        </div>
    </form>    

</x-toggle-box>