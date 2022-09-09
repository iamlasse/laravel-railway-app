@props(['totals' => ['new' => 0, 'org' => 0, 'data' => 0, 'avg' => 0], 'data' => ['total_percent_saved' => 0, 'total_saved' => 0]])

<div class="flex flex-col flex-wrap gap-4 mt-4 sm:flex-row sm:space-y-0 boxes">
    <div class="flex flex-col items-center justify-center flex-1 px-8 py-4 text-center rounded-lg binding bg-telekom-darkblue">
        <h4 class="text-sm font-bold text-white">Bindingstid</h4>
        <h2 class="text-2xl font-bold text-white">24 mån</h2>
    </div>
    <div class="flex flex-col items-center justify-center flex-1 px-8 py-4 text-center rounded-lg binding bg-telekom-darkblue">
        <h4 class="text-sm font-bold text-white">Kostnad per månad</h4>
        <h2 class="text-2xl font-bold text-white">{{ number_format($totals['new'], 0) }} Kr</h2>
    </div>
    <div class="flex flex-col items-center justify-center flex-1 px-8 py-4 text-center rounded-lg binding bg-telekom-darkblue">
        <h4 class="text-sm font-bold text-white">Snittpris per anställd</h4>
        <h2 class="text-2xl font-bold text-white">{{ number_format($totals['avg'])}} Kr</h2>
    </div>
    <div class="sm:mt-0 w-full sm:w-auto items-center justify-start flex-1 flex flex-col px-8 py-4 text-center @if ($data['total_percent_saved'] < 0) bg-tkorange-200 @else bg-tkteal-200 @endif rounded-lg binding">
        <h4 class="text-sm font-bold text-tkblue-500">Ni sparar mot idag</h4>
        <span class="flex items-center justify-start space-x-3">
            @if ($data['total_percent_saved'] < 0) 
                <x-heroicon-s-arrow-down class="w-4 h-4 text-red-800" />
                @else
                
                <x-heroicon-s-arrow-up class="w-4 h-4 text-green-700" />
            @endif
            @if ($data['total_percent_saved'] > 100) - @endif{{ number_format($data['total_percent_saved'], 0) }} %</span>
        <h2 class="text-2xl font-bold text-tkblue-500">{{ number_format($data['total_saved'], 0) }}Kr.</h2>
    </div>
</div>