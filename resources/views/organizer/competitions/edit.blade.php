@extends('layouts.organizer')

@section('title', 'Edit Lomba')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Lomba</h2>

    <form action="{{ route('organizer.competitions.update', $competition->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="title" value="{{ old('title', $competition->title) }}" class="w-full border p-2 mb-3 rounded" required>

        <textarea name="description" class="w-full border p-2 mb-3 rounded" required>{{ old('description', $competition->description) }}</textarea>

        <input type="text" name="category" value="{{ old('category', $competition->category) }}" class="w-full border p-2 mb-3 rounded" required>

        <input type="text" name="prize" value="{{ old('prize', $competition->prize) }}" class="w-full border p-2 mb-3 rounded" required>

        <input type="date" name="deadline" value="{{ old('deadline', $competition->deadline) }}" class="w-full border p-2 mb-3 rounded" required>

        <input type="text" name="registration_link" value="{{ old('registration_link', $competition->registration_link) }}" class="w-full border p-2 mb-3 rounded">

        <input type="file" name="photo" class="w-full border p-2 mb-3 rounded">

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Update</button>
    </form>
</div>
@endsection
