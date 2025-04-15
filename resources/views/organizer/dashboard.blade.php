@extends('layouts.organizer')

@section('title', 'Organizer Dashboard')

@section('content')
<h2 class="text-3xl font-bold text-indigo-700 mb-6">Selamat datang, {{ auth()->user()->name }}!</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
  <div class="bg-white shadow p-6 rounded-lg">
    <h3 class="text-lg font-semibold text-indigo-600">Total Kompetisi Dibuat</h3>
    <p class="text-4xl font-bold mt-2">{{ $totalCompetitions }}</p>
  </div>
</div>

<div class="flex justify-between items-center mb-4">
  <h4 class="text-xl font-semibold text-indigo-700">Kompetisi yang Kamu Buat</h4>
  <a href="{{ route('organizer.competitions.create') }}"
     class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
    + Tambah Lomba Baru
  </a>
</div>

<div class="bg-white p-6 rounded-lg shadow">
  @if ($competitions->count())
    <table class="w-full table-auto border text-sm">
      <thead class="bg-indigo-50 text-left text-gray-700">
        <tr>
          <th class="p-3">Judul</th>
          <th class="p-3">Deadline</th>
          <th class="p-3">Hadiah</th>
          <th class="p-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($competitions as $competition)
          <tr class="border-t hover:bg-gray-50">
            <td class="p-3 font-medium">{{ $competition->title }}</td>
            <td class="p-3">{{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</td>
            <td class="p-3">{{ $competition->prize }}</td>
            <td class="p-3 flex gap-2 justify-center">
              <a href="{{ route('organizer.competitions.show', $competition->id) }}"
                 class="text-blue-600 hover:underline">Detail</a>
              <a href="{{ route('organizer.competitions.edit', $competition->id) }}"
                 class="text-yellow-600 hover:underline">Edit</a>
              <form action="{{ route('organizer.competitions.destroy', $competition->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus lomba ini?')">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="text-gray-600">Belum ada lomba yang kamu buat.</p>
  @endif
</div>

@if ($competitions->hasPages())
  <div class="mt-6 flex justify-center">
    {{ $competitions->links() }}
  </div>
@endif
@endsection

@push('styles')
<style>
    .pagination-info {
        display: none !important;
    }
</style>
@endpush
