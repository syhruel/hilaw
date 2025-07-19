@extends('dokter.layouts.app')

@section('title', 'Chat Pasien')
@section('page-title', 'Chat Pasien')

@section('content')
    <livewire:live-chat :consultationId="$consultation->id" />
@endsection
