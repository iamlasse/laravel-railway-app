@extends('layouts.modal')

@section('header')
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold text-yellow-500"> Edit abonnemang</h3>
        @if ($editing->shouldBeCancelled())
        <x-button wire:click.prevent="activateSubscription" spinner="activateSubscription" primary type="submit"
            class="font-semibold text-tkblue-500">Aktivera
        </x-button>
    @endif
    </div>
@endsection

@section('body')
    <div class="flex flex-col space-y-4">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Namn') }}" />
            <x-jet-input id="name" type="text" class="block w-full px-3 py-2 mt-1" wire:model.lazy="editing.name"
                autocomplete="name" />
            <x-jet-input-error for="editing.name" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="department" value="{{ __('Avdelning') }}" />
            <x-jet-input id="department" type="text" class="block w-full px-3 py-2 mt-1" wire:model.lazy="editing.department"
                autocomplete="department" />
            <x-jet-input-error for="editing.department" class="mt-2" />
        </div>

        @if (!$editing->isVaxelUser())
            <div class="flex flex-row items-center">
                <livewire:utils.toggle-switch :model="$editing" attribute="vaxel_user" />
                <span class="ml-1 font-semibold text-tkblue-600">Aktivera växel användare</span>
            </div>
        @endif
        <div class="flex flex-row items-center">
            <livewire:utils.toggle-switch :model="$editing" attribute="status" />
            <span class="ml-1 font-semibold text-tkblue-600">Abonnemang aktivt?</span>
        </div>

    </div>
    <div class="mt-6">

        <h2 class="mb-3 font-semibold">Abonnemangs Data Planer</h2>
        <x-table>
            <x-slot name="head">
                <x-table.heading class="heading">
                    Operator
                </x-table.heading>
                <x-table.heading class="heading">
                    Plan
                </x-table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse (operators() as $operator)
                    <x-table.row>
                        <x-table.cell>
                            {{ $operator['name'] }}
                        </x-table.cell>
                        <x-table.cell>
                            {{-- @livewire('utils.plan-select', ['operatorId' => $operator['id'], 'subscriptionId' => $editing->id], key( . '-' . )) --}}
                            <livewire:utils.plan-select :operator-id="$operator['id']" :subscription-id="$editing->id"
                                wire:key="{{ $operator['code'] }}-{{ $editing->id }}" />
                        </x-table.cell>
                    </x-table.row>
                @empty
                @endforelse
            </x-slot>
        </x-table>
    </div>
@endsection
@section('footer')
    <div class="flex px-6 pt-6 space-x-2">
        <x-button gray wire:click.prevent="cancel">{{ __('Cancel') }}</x-button>

        <x-button wire:click.prevent="saveSubscription" spinner="saveSubscription" primary type="submit"
            class="font-semibold text-tkblue-500">Spara Ändringar
        </x-button>

       
    </div>
@endsection
