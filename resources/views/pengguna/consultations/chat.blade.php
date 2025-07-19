@extends('pengguna.layouts.app')

@section('title', 'Chat Konsultasi')
@section('page-title', 'Chat Konsultasi')

@section('content')
    <livewire:live-chat :consultationId="$consultation->id" />
@endsection
