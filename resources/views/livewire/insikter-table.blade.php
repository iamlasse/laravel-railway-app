<div>
    <x-table>
        <x-slot name="head">
            <x-table.heading>Typ</x-table.heading>
            <x-table.heading>
                <div class="text-left">
                    Användare
                </div>
            </x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Avdelning</x-table.heading>
            <x-table.heading>
                <div class="text-left">
                    Data Förbrukning
                </div>
            </x-table.heading>
            <x-table.heading>Växel</x-table.heading>
        </x-slot>
        <x-slot name="body">
            
            @forelse ($subscriptions as $subscription)
            <x-table.row>
                <x-table.cell class="max-w-xs">
                    <div class="text-center">
                        {{ $subscription->type }}
                    </div>
                </x-table.cell>
                <x-table.cell>
                    <div class="flex flex-col items-left">
                        <span class="text-sm font-semibold">{{ $subscription->name }}</span>
                        <span class="text-xs numbers">{{ $subscription->phone_numbers }}</span>
                    </div>
                </x-table.cell>
                <x-table.cell>
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center px-2 py-1 text-xs rounded-full {{ $subscription->getClasses('status')['label'] }}">
                            <span class="w-2 h-2 mr-1 {{ $subscription->getClasses('status')['dot'] }} rounded-full">
                                &nbsp;
                            </span>
                            {{ $subscription->status_text }}
                        </div>
                        <span class="mt-1 text-xs text-gray-800 ">
                            @if (($subscription->isExpired() || $subscription->isExpiring()) && $subscription->expires_at)
                            {{ $subscription->expires_at->format('Y/m/d') }}
                            @endif

                            @if ($subscription->isCancelled())
                            {{ $subscription->cancelled_at->format('Y/m/d') }}
                            @endif
                        </span>
                    </div>
                </x-table.cell>
                <x-table.cell>
                    <div class="flex items-center justify-center">
                        <span class="text-sm">{{ $subscription->department }}</span>
                    </div>
                </x-table.cell>
                <x-table.cell>
                    <div class="flex flex-col items-start text-center">
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
                <x-table.cell>
                    <div class="text-center">
                        {{ $subscription->vaxel_user ? 'JA' : 'NEJ' }}
                    </div>
                </x-table.cell>
            </x-table.row>
            @empty
                
            @endforelse
        </x-slot>


    </x-table>
    <div class="p-4 bg-gray-100">
        {{ $subscriptions->links() }}
    </div>
</div>