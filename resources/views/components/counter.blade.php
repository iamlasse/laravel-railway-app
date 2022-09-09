@props([ 'label' => '', 'count' => 0 ])

<div {{ $attributes }} class="flex flex-col items-center justify-center font-bold text-white rounded-lg lg:py-6 bg-telekom-darkblue">
    <h4 class="text-sm truncate 2xl:text-base">{{ $label }}</h4>
    <h3 class="text-4xl md:text-3xl">{{ $count }}</h3>
</div>