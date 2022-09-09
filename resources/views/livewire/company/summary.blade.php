<div class="z-0 flex flex-col p-8 space-y-4 rounded-lg shadow-md">

    <div class="flex flex-col items-center space-y-2 sm:space-y-0 todays_cost">
        <p class="text-xs font-semibold text-gray-400">Fast månadskostnad idag</p>
        <h3 class="text-xl font-bold">{{ number_format(company()->current_monthly_cost, 0) }} Kr</h3>
    </div>
    <div class="flex flex-col items-center todays_flex_cost sm:space-y-0">
        <p class="text-xs font-semibold text-gray-400">Rörlig kostnad idag (ex tillägg av data)</p>
        <h3 class="text-xl font-bold">{{ number_format(company()->current_monthly_flex_cost, 0) }} Kr</h3>
    </div>

    <hr/>

    <div class="flex flex-col items-center space-y-2 text-center graph">
        <p class="text-sm font-semibold text-gray-400">Avtalad datamängd vs nyttjad för hela verksamheten</p>
    </div>

    <div class="summary">
@if (company()->hasSubscriptions())
    
<div class="flex flex-col items-center h-56 mt-6 column">
    <div class="relative w-full h-full columns md:w-56 lg:w-56 ">
        <div class="absolute bottom-0 z-0 w-full h-full transform -translate-x-1/2 used left-1/2">
            <div class="absolute bottom-0 w-5 h-full transform -translate-x-1/2 bg-telekom-darkgreen left-1/2"></div>
            <div
                class="absolute text-xs font-semibold text-left border-b border-gray-400 border-dashed left-5 min-w-min -top-4 min-w-40 sm:w-20 md:w-20 lg:w-20 xl:w-24">
                {{ number_format($total_data, 0) }} Gb
            </div>
        </div>

        <div class="absolute bottom-0 w-full transform -translate-x-1/2 used left-1/2 "
            style="height: {{ (max($total_usage, 1) / max($total_data, $total_usage)) * 100 }}%">
            <div class="absolute bottom-0 w-5 h-full transform -translate-x-1/2 bg-indigo-600 left-1/2"></div>
            <div
                class="absolute text-xs font-semibold text-right border-b border-gray-400 border-dashed right-5 min-w-min -top-4 min-w-40 sm:w-20 md:w-20 lg:w-20 xl:w-24">
                {{ number_format($total_usage, 1) }} Gb
            </div>
        </div>
    </div>

</div>
@endif

        <div class="flex justify-center pb-2 mt-5 space-x-4 legend">
            <div class="flex items-center total">
                <span class="w-5 h-3 mr-2 bg-telekom-darkgreen box">&nbsp;</span>
                <p class="text-xs font-semibold">{{ __('telekom.subscription.total') }}</p>
            </div>
            <div class="flex items-center used">
                <span class="w-5 h-3 mr-2 bg-indigo-600 box">&nbsp;</span>
                <p class="text-xs font-semibold">{{ __('telekom.subscription.used') }}</p>
            </div>
        </div
    </div>
</div>
