@extends('layouts.modal')

@section('header')
    <h3 class="text-lg font-bold text-white"> Edit abonnemang</h3>
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
        @php
            $operator = operators()->where('id', $operatorId)->first();
        @endphp
            <x-table.row>
                <x-table.cell>
                    {{ $operator['name'] }}
                </x-table.cell>
                <x-table.cell>
                   <livewire:utils.plan-select :operator-id="$operator['id']" wire:key="{$operator['code']}-mass-update" />
                </x-table.cell>
            </x-table.row>
    </x-slot>
</x-table>

@endsection

@section('footer')
<div class="flex items-center px-4 mt-2 space-x-2">
    <x-button gray wire:click.prevent="cancel">{{ __('Cancel') }}</x-button>

<x-button  class="ml-4 font-semibold text-tkblue-500 dark:bg-tkteal-500 dark:text-tkblue-500 hover:bg-tkblue-500 hover:text-white" x-data="{ plans: @entangle('plans') }" x-bind:disabled="plans.length === 0" spinner="saveSubscriptions" wire:click.prevent="saveSubscriptions" primary type="submit">{{ __('Save Changes') }}</x-button>
</div>
@endsection