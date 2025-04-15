@extends('layouts.organizer')

@section('title', 'Daftar Lomba')

@section('content')
<div class="flex justify-between items-center mb-6">
  <h2 class="text-2xl font-bold text-indigo-700">Lomba Anda</h2>
  <a href="{{ route('organizer.competitions.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
    + Tambah Lomba
  </a>
</div>

@if(session('success'))
  <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

@if($competitions->count())
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($competitions as $competition)
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <img src="{{ asset('storage/' . $competition->photo) }}" class="h-40 w-full object-cover" alt="{{ $competition->title }}">
        <div class="p-4">
          <h3 class="text-lg font-bold">{{ $competition->title }}</h3>
          <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($competition->description, 60) }}</p>
          <div class="mt-3 flex justify-between items-center text-sm text-gray-500">
            <span>📅 {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</span>
            <span>🏆 {{ $competition->prize }}</span>
          </div>
          <div class="flex gap-2 mt-4">
            <a href="{{ route('organizer.competitions.show', $competition->id) }}" class="text-blue-600 hover:underline text-sm">Detail</a>
            <a href="{{ route('organizer.competitions.edit', $competition->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
            <form action="{{ route('organizer.competitions.destroy', $competition->id) }}" method="POST" onsubmit="return confirm('Hapus lomba ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@else
  <p class="text-gray-600">Belum ada lomba yang ditambahkan.</p>
@endif

{{-- ✅ Pagination SELALU tampil jika ada lebih dari 1 halaman --}}
@if ($competitions->hasPages())
  <div class="mt-8 d-flex justify-content-center">
    {{ $competitions->onEachSide(1)->links('pagination::bootstrap-5') }}
  </div>
@endif
@endsection
