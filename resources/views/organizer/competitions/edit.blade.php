@extends('layouts.app')

@section('title', 'Edit Lomba')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-xl font-bold text-indigo-600 mb-4">Edit Lomba</h2>

    <form action="{{ route('organizer.competitions.update', $competition->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <x-input-label for="title" value="Judul Lomba" />
        <x-text-input id="title" name="title" type="text" class="w-full" value="{{ old('title', $competition->title) }}" required />

        <x-input-label for="description" value="Deskripsi" />
        <textarea id="description" name="description" rows="4" class="w-full border-gray-300 rounded">{{ old('description', $competition->description) }}</textarea>

        <x-input-label for="category" value="Kategori" />
        <x-text-input id="category" name="category" type="text" class="w-full" value="{{ old('category', $competition->category) }}" required />

        <x-input-label for="deadline" value="Deadline" />
        <x-text-input id="deadline" name="deadline" type="date" class="w-full" value="{{ $competition->deadline->format('Y-m-d') }}" required />

        <x-input-label for="prize" value="Hadiah" />
        <x-text-input id="prize" name="prize" type="text" class="w-full" value="{{ old('prize', $competition->prize) }}" required />

        <x-input-label for="photo" value="Ganti Poster (opsional)" />
        <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-600" />

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
    </form>
</div>
@endsection
