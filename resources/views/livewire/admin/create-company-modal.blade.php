@extends('layouts.modal')

@section('header')
<h3 class="text-lg font-bold text-yellow-500">{{__('Add :resource', ['resource' => __('company')])}}</h3>
@endsection

@section('body')
<form wire:submit.prevent='saveCompany'>
<div class="grid items-stretch sm:flex sm:space-x-4">
    <div class="w-full sm:w-1/2">
        {{-- <x-jet-label for="name" value="{{ __('Namn') }}" />
        <x-jet-input id="name" type="text" class="block w-full px-3 py-2 mt-1"
            wire:model.defer="company.name" autocomplete="name" placeholder="Företags namn" />
        <x-jet-input-error for="company.name" class="mt-2" /> --}}
        <x-input wire:model.defer="company.name" label="{{ __('Företagsnamn') }}*" placeholder="Winterfell AB" />
    </div>
    <div class="w-full sm:w-1/2">
        <x-inputs.maskable label="{{__('Organisationsnummer')}}*" aria-placeholder="xxxxxx-xxxx" wire:model.defer="company.reg_nr" mask="['######-####']" />
    </div>

</div>
<div class="grid items-stretch mt-6 sm:flex sm:space-x-4">

    <div class="w-full sm:w-1/2">
        <x-inputs.phone wire:model.defer="company.phone" label="{{__('Telefonnummer')}}"  mask="['### ## ###', '#### ## ## ##']" />
    </div>
</div>

<div class="grid items-stretch mt-6 sm:flex sm:space-x-4">
    <div class="w-full sm:w-1/2">
        <x-input wire:model.defer="owner.name" id="contact" label="{{__('Kontaktperson')}}" placeholder="{{__('Kontaktperson')}}" aria-autocomplete="name" autocomplete="name" />
    </div>
    <div class="w-full sm:w-1/2">
        <x-input wire:model.defer="owner.email" label="E-post (används till login)*" placeholder="ansvarig@foretag.se" />
    </div>
</div>
<div class="grid items-stretch mt-6 sm:flex sm:space-x-4">
    <div class="flex flex-col w-full space-y-3 sm:w-1/2">
        <x-inputs.currency wire:model.defer="company.current_monthly_cost" prefix="Kr" id="costs_today" label="{{__('Fasta kostnader idag per månad')}}*" placeholder="100.000" aria-autocomplete="price" autocomplete="price" />
        <x-inputs.currency wire:model.defer="company.current_monthly_flex_cost" prefix="Kr" id="costs_flex" label="{{__('Rörliga kostnader idag per månad')}}*" placeholder="10.000" aria-autocomplete="price" autocomplete="price" />
    </div>
    <div class="w-full sm:w-1/2">
        <x-inputs.currency wire:model.defer="company.over_paying" prefix="Kr" class="pl-6" label="Överdebiterad*" placeholder="100.000" />
    </div>
</div>
</form>
@endsection

@section('footer')
<div class="flex justify-end px-6 pt-6 pb-2 space-x-2">
    <x-button gray class="bg-gray-50" wire:click.prevent="cancel">Avbryt</x-button>

    <x-button spinner='saveCompany' primary class="font-semibold text-tkblue-500" type="submit" wire:click.prevent='saveCompany'>Skapa</x-button>
</div>
@endsection