@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-2xl font-bold text-center text-indigo-700">Manage Invitations</h1>

    {{-- Form Send Invitation --}}
    <div class="card shadow p-4 mb-5 border rounded">
        <h2 class="text-lg font-semibold mb-3">Send Invitation</h2>
        <form method="POST" action="{{ route('invitations.store') }}" class="flex flex-col gap-3">
            @csrf
            <div>
                <label for="user_id" class="block mb-1 font-medium">Select User</label>
                <select name="user_id" id="user_id" class="form-select w-full border rounded p-2">
                    <option value="">-- Select User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Send Invitation
                </button>
                <button>
                <a class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition"> Make Team</a>
                </button>
            </div>
        </form>
    </div>

    
    {{-- Sent Invitations --}}
    <div class="mb-5">
        <h2 class="text-lg font-semibold mb-3">Sent Invitations</h2>
        @if ($sentInvitations->count())
            <div class="overflow-x-auto">
                <table class="table-auto w-full border rounded">
                    <thead class="bg-indigo-100">
                        <tr>
                            <th class="px-4 py-2 text-left">To</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sentInvitations as $invitation)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $invitation->receiver->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($invitation->status) }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('invitations.show', $invitation->id) }}"
                                       class="text-sm text-indigo-600 hover:underline">View Messages</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No invitations sent yet.</p>
        @endif
    </div>
    
    
    {{-- Received Invitations --}}
    <div>
        <h2 class="text-lg font-semibold mb-3">Received Invitations</h2>
        @if ($receivedInvitations->count())
            <div class="overflow-x-auto">
                <table class="table-auto w-full border rounded">
                    <thead class="bg-indigo-100">
                        <tr>
                            <th class="px-4 py-2 text-left">From</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receivedInvitations as $invitation)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $invitation->sender->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($invitation->status) }}</td>
                                <td class="px-4 py-2">
                                    @if($invitation->status === 'pending')
                                        <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button class="text-green-600 hover:underline">Accept</button>
                                        </form>
                                        <form action="{{ route('invitations.decline', $invitation->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            <button class="text-red-600 hover:underline">Decline</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">No action</span>
                                    @endif
                                </td>
                                <td>
                                    @if($invitation->status === 'accepted')
                                        <a href="{{ route('invitations.show', $invitation->id) }}" class="text-indigo-600 hover:underline">
                                            View Messages
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Waiting for response</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No invitations received.</p>
        @endif
    </div>
</div>
@endsection
