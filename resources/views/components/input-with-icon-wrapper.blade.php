<div {{ $attributes->merge(['class' => 'relative py-3 text-gray-500 focus-within:text-gray-900 dark:focus-within:text-gray-400'])}}>
    <div aria-hidden="true" class="absolute inset-y-1/2 justify-end right-0 flex items-center px-4 pointer-events-none">
        {{ $icon }}
    </div>
    {{ $slot }}
</div>