@extends('layouts.app')

@section('title', 'Detail Lomba')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h2 class="text-2xl font-bold text-indigo-700 mb-4">{{ $competition->title }}</h2>
    
    <img src="{{ asset('storage/' . $competition->photo) }}" alt="{{ $competition->title }}" class="w-full h-72 object-cover rounded mb-4">

    <p class="text-sm text-gray-500">Kategori: {{ $competition->category }}</p>
    <p class="text-sm text-gray-600 mt-2">Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</p>
    <p class="text-sm text-green-600 mt-1">Hadiah: {{ $competition->prize }}</p>

    <div class="mt-6 text-gray-800 leading-relaxed">
        {!! nl2br(e($competition->description)) !!}
    </div>

    <a href="{{ route('organizer.competitions.index') }}" class="inline-block mt-6 text-indigo-600 hover:underline">← Kembali ke daftar lomba</a>
</div>
@endsection
