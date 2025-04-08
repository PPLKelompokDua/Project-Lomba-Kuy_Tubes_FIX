@extends('layouts.app')

@section('title', 'Kelola Lomba')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-indigo-600">Daftar Lomba Saya</h1>
        <a href="{{ route('organizer.competitions.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Tambah Lomba
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($competitions as $competition)
            <div class="bg-white rounded shadow p-4">
                <img src="{{ asset('storage/' . $competition->photo) }}" alt="{{ $competition->title }}" class="w-full h-40 object-cover rounded mb-3">
                <h2 class="text-lg font-semibold">{{ $competition->title }}</h2>
                <p class="text-sm text-gray-500 mb-2">{{ $competition->category }}</p>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Hadiah: {{ $competition->prize }}</span>
                    <span>Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</span>
                </div>

                <div class="mt-4 flex justify-between text-sm">
                    <a href="{{ route('organizer.competitions.show', $competition->id) }}" class="text-indigo-600 hover:underline">Lihat</a>
                    <a href="{{ route('organizer.competitions.edit', $competition->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <form action="{{ route('organizer.competitions.destroy', $competition->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600">Belum ada lomba yang ditambahkan.</p>
        @endforelse
    </div>
</div>
@endsection
