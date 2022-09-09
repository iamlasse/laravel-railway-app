@extends('layouts.modal')

@section('header')
    <h3 class="text-lg text-white font-">Skapa nytt abonnemang</h3>
@endsection

@section('body')
    <livewire:admin.create-subscription :company="$company" />
@endsection

