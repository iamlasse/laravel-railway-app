<div x-data="{ showEdit: false, flash: false  }">
    <form wire:submit.prevent="saveExtraField">
        <div class="flex justify-end mb-6">
            <div class="flex space-x-2"><span x-show="flash" x-transition.duration.300ms
                    class="p-2 text-xs font-semibold rounded-lg opacity-50 bg-telekom-100 ">Sparad...</span>
                <x-button primary spinner="saveExtraField" x-show="showEdit" type="submmit" :disabled="!$this->isDirty()" class="text-white bg-indigo-500"
                    x-on:click="flash = true; setTimeout(() => { flash = false; showEdit = false }, 1000)">Spara
                </x-button>
            </div>
        </div>
    
        <textarea wire:model.lazy="extra" x-on:focus="showEdit = true" name="extra"
            id="extra" cols="30" rows="10" class="w-full p-6 bg-white shadow-md rounded-xl">
            {{ $extra }}
        </textarea>
    </form>

</div>
