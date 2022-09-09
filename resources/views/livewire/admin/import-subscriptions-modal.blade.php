@extends('layouts.modal')

@section('header')
   <div class="flex justify-between">
    <h3 class="text-lg font-bold text-white">{{ __('Importera abonnemang') }}</h3>
    <x-button wire:click.prevent.stop="getTemplate" icon="download" flat primary  sm label="Hämta mall" class="font-semibold text-white hover:text-tkblue-500" />
   </div>
@endsection

@section('body')
    <form wire:submit.prevent='handleImport' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col" style="max-width: 500px; margin: 0 auto;">
            <div class="flex items-center">
                <h3 class="text-lg font-semibold">Importera Kundens abonnemang</h3>
            </div>

            <div class="flex items-center py-6 mb-12">
                <div class="w-full">
                    <x-errors title="Det fanns {errors} fel i filen"/>
                    <x-file-attachment accept="xlsx,csv" :file="$sheet" wire:model="sheet" id="sheet" type="file" placeholder="{{ __('Välj') }}"
                        class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('sheet') border-red-500 @enderror"
                        name="sheet" required />
                    @error('sheet')
                        <p class="mt-4 text-xs italic text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
    </form>
@endsection

@section('footer')
    <x-button gray md wire:click="closeModal">
        {{ __('Avbryt') }}
    </x-button>
    <x-button primary :disabled="!$sheet" md wire:click="handleImport" spinner="handleImport" class="font-semibold text-tkblue-500">
        {{ __('Importera') }}
    </x-button>
@endsection
