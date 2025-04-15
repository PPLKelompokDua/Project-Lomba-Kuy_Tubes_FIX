@extends('layouts.organizer')

@section('title', 'Tambah Lomba')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Tambah Lomba Baru</h2>
        <a href="{{ route('organizer.competitions.index') }}"
           class="text-indigo-600 hover:underline text-sm">
           ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('organizer.competitions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block font-medium mb-1">Judul Lomba</label>
            <input type="text" name="title" id="title" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full border p-2 rounded" required></textarea>
        </div>

        <div class="mb-4">
            <label for="category" class="block font-medium mb-1">Kategori</label>
            <input type="text" name="category" id="category" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="deadline" class="block font-medium mb-1">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="prize" class="block font-medium mb-1">Hadiah</label>
            <input type="text" name="prize" id="prize" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="registration_link" class="block font-medium mb-1">Link Pendaftaran</label>
            <input type="url" name="registration_link" id="registration_link" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="photo" class="block font-medium mb-1">Poster Lomba (Opsional)</label>
            <input type="file" name="photo" id="photo" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Simpan
        </button>
    </form>
</div>
@endsection
