@extends('layouts.modal')

@section('header')
    <h3 class="text-lg font-bold text-white"> Edit abonnemang</h3>
@endsection

@section('body')
    <form wire:submit.prevent="save">
        <x-jet-label for="name" value="{{ __('Namn') }}" />
        <x-jet-input id="name" type="text" class="block w-full px-3 py-2 mt-1" wire:model.lazy="editing.name"
            autocomplete="name" />
        <x-jet-input-error for="editing.name" class="mt-2" />
    </form>

@endsection

@section('footer')
    <div class="flex px-6 pt-6 space-x-2">
        <x-button gray wire:click.prevent="closeModal">{{ __('Cancel') }}</x-button>

        <x-button wire:click.prevent="save" spinner="save" wire:loading.attr='disabled' primary type="submit" class="text-tkblue-500">
            {{ __('Save Changes') }}</x-button>
    </div>
@endsection
