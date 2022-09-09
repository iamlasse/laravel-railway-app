<div class="flex flex-row items-center justify-center h-full cursor-pointer" wire:loading.class="opacity-50">
    <div class="flex items-center justify-center"  x-data="{ toggleActive: @entangle('active') }">
      <span class="">
        <i class="text-gray-400 far fa-sun"></i>
      </span>
      <!-- Switch Container -->
      <div
        :class="{ 'bg-green-400': toggleActive}"
        class="flex items-center w-12 h-6 px-1 mx-3 transition-all bg-gray-300 rounded-full"
        @click="$wire.set('active', !toggleActive)"
      >
        <!-- Switch -->
        <div
          class="w-4 h-4 transition-all transform bg-white rounded-full shadow-md"
          :class="{ 'translate-x-6': toggleActive}"
        ></div>
      </div>
      <span class="">
        <i class="text-gray-400 far fa-moon"></i>
      </span>
    </div>
  </div>