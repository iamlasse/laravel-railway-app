{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

<div class="min-w-full overflow-x-auto align-middle shadow sm:rounded-lg">
    <table class="min-w-full divide-y divide-cool-gray-200">
        <thead>
            {{ $head ?? '' }}
        </thead>

        <tbody class="bg-white divide-y divide-cool-gray-200">
            {{ $body ?? '' }}
        </tbody>
        <tfoot class="bg-white divide-y divide-cool-gray-200">
            {{ $footer ?? '' }}
        </tfoot>
    </table>
</div>
