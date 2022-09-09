{{-- -- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/ --}}
@props(['value', 'label', 'id'])
<div class="flex rounded-md shadow-sm">
    <label for="{{ $id }}">
        <input {{ $attributes }} id="{{ $id }}" type="radio" value="{{ $value }}" />
        {{ $label }}
    </label>
</div>
