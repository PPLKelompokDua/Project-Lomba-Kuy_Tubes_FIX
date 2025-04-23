@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <h2 class="text-2xl font-bold text-center mb-8 text-indigo-600">🎯 Manage Invitations</h2>

    {{-- Invite a Team Member --}}
    <div class="bg-white rounded-xl shadow p-6 mb-10">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Invite a Team Member</h3>
        
        <form method="POST" action="{{ route('invitations.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Select User to Invite:</label>
                <select name="user_id" id="user_id" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
                📩 Send Invitation
            </button>
        </form>
    </div>

    {{-- Sent Invitations --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Sent Invitations</h3>

        @if ($invitations->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach ($invitations as $invitation)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800 font-medium">{{ $invitation->receiver->name }}</p>
                            <p class="text-sm text-gray-500">Status: 
                                <span class="font-semibold capitalize">
                                    {{ $invitation->status }}
                                </span>
                            </p>
                        </div>
                        <form method="POST" action="{{ route('invitations.destroy', $invitation) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                ❌ Cancel
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-500">No invitations sent yet.</p>
        @endif
    </div>
</div>
@endsection
