@extends('layouts.modal')

@section('header')
    <h3 class="text-lg font-bold text-white">{{ __('Add Subscription') }}</h3>
@endsection

@section('body')
    <div class="py-6">
        <form wire:submit.prevent='saveSubscription'>
            @csrf

            {{ $this->form }}
        </form>
    </div>
@endsection

@section('footer')
    <div class="flex px-6 space-x-2">
        <x-button gray wire:click.prevent="cancel">{{ __('Cancel') }}</x-button>

        <x-button wire:click.prevent="saveSubscription" spinner="saveSubscription" wire:loading.attr="disabled" primary class="font-semibold text-tkblue-500 dark:bg-tkteal-500 dark:text-tkblue-500 hover:bg-tkblue-500 hover:text-white"
            type="submit">Spara Ändringar</x-button>
    </div>
@endsection
