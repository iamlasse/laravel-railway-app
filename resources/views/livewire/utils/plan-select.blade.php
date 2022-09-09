<div class="p-2" 
    x-data="{
        currentPlan: @entangle('plan'),
    }"
>
    <x-input.select wire:model.lazy="plan"  id="plan">
            <option value="" x-bind:disabled="currentPlan">{{ __('Välj Plan') }}</option>
        @foreach ($options as $option)
            <option value="{{$option->id}}">{{$option->name}}</option>
        @endforeach
    </x-input.select>
</div>