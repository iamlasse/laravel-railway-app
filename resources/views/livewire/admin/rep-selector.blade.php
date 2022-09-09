<x-jet-dropdown align="left" width="56" class="w-full sm:w-56">
    <x-slot name="trigger">
        <x-button lg primary class="font-bold">
                <h4 class="text-lg font-bold">Välj Kundansvarig</h4>
                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
        </x-button>
    </x-slot>

    <x-slot name="content">
        @forelse ($reps as $rep)
                  <div class="flex hover:bg-gray-100">
                    <button class="flex items-center justify-between w-full px-2 py-2 space-x-4 bg-transparent border-0 hover:bg-gray-100 hover:cursor-pointer" wire:click="setRep({{$rep->id}})">
                        <span class="flex items-center">
                            <img class="object-cover w-8 h-8 rounded-md" src="{{ $rep->profile_photo_url }}" alt="{{ $rep->name }}" /> 
                            <h4 class="ml-2 font-semibold text-md">{{$rep->name}}</h4>
                        </span>
                        @if ($company->isCurrentRep($rep->id))
                            <x-heroicon-o-check-circle class="w-6 h-6 ml-6 text-green-500" />
                        @endif
                    </button>
                  </div>
        @empty
            <div class="empty">
                <p>No reps</p>
            </div>
        @endforelse
    </x-slot>
</x-jet-dropdown>