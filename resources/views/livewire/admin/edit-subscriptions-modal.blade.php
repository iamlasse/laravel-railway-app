@extends('layouts.modal')

@section('header')
    <h3 class="text-lg font-bold text-white">Ändra flertal abonnemang</h3>
@endsection

@section('body')

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
                        <livewire:utils.plan-select :operator-id="$operator['id']"
                            wire:key="{{ $operator['code'] }}-mass-update" />
                    </x-table.cell>
                </x-table.row>
            @empty

            @endforelse
        </x-slot>
    </x-table>

@endsection

@section('footer')
    <div class="flex px-6 pt-6 space-x-2">
        <x-button gray wire:click.prevent="cancel">{{ __('Cancel') }}</x-button>

        <x-button wire:click.prevent="saveSubscriptions" spinner="saveSubscriptions" primary type="submit" class="font-semibold text-tkblue-500">
            {{ __('Save Changes') }}</x-button>
    </div>
@endsection
