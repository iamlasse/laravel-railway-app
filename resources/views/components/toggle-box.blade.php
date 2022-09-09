@props(['show'=>false])
<div {{ $attributes->merge(['class' => "bg-gray-200 rounded-lg"]) }} x-data="function(){
    return {
        show: @js($show),
    }
}">
    <div class="flex items-center justify-between px-6 py-2 rounded-t-lg bg-tkblue-500 hover:cursor-pointer" x-on:click.stop="show = !show">
        <h3 class="text-lg font-semibold text-white">
            {{ $title  ?? '' }}
        </h3>
        <x-heroicon-s-chevron-down x-show="!show" class="w-6 h-6 text-white" x-on:click.stop="show = true" />
        <x-heroicon-s-chevron-up x-show="show" class="w-6 h-6 text-white" x-on:click.stop="show = false" />
    </div>

    <div  x-show="show" x-transition.300ms>
        <div class="px-6 py-4">{{ $slot }}</div>
    </div>

</div>
