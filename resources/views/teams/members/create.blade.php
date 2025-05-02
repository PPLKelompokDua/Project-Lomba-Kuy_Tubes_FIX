@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Create a Team</h2>

    <form method="POST" action="{{ route('teams.store') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block mb-1 font-medium">Team Name</label>
            <input type="text" id="name" name="name"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        @if($acceptedUsers->count())
        <div class="mb-4">
            <label for="members" class="block mb-1 font-medium">Add Members</label>
            <select name="members[]" id="members" class="w-full border px-3 py-2 rounded" multiple>
                @foreach($acceptedUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Create Team
        </button>
    </form>
</div>
@endsection
