@extends('layouts.app')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-2xl font-bold text-center text-indigo-700">Manage Invitations</h1>

    <div class="mb-4">
        <a href="{{ route('teams.index') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            ← Back to My Teams
        </a>
    </div>
    @if (session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
        </div>
    @endif

    {{-- Form Send Invitation --}}
    <div class="card shadow p-4 mb-5 border rounded">
        <h2 class="text-lg font-semibold mb-3">Send Invitation</h2>
        <form method="POST" action="{{ route('invitations.store') }}" class="flex flex-col gap-3">
            @csrf
            <div>
                <label for="user_id" class="block mb-1 font-medium">Select User</label>
                <select name="user_id" id="user_id" class="w-full border rounded p-2"> data-placeholder="🔍 Search for a user...">
                    <option></option> <!-- Placeholder -->
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $defaultUserId ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($teams->count() === 1)
                <input type="hidden" name="team_id" value="{{ $teams->first()->id }}">
                @else
                    <div>
                        <label for="team_id">Select Team</label>
                        <select name="team_id" id="team_id" class="form-select w-full border rounded p-2">
                            <option value="">-- Select Team --</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id', $defaultTeamId) == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            <div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Send Invitation
                </button>
                <button>
                    <a href="{{ route('teams.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition"> Make Team</a>
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
                            <th class="px-4 py-2 text-left">Competition</th>
                            <th class="px-4 py-2 text-left">Team</th>
                            <th class="px-4 py-2 text-left">Messages</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sentInvitations as $invitation)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $invitation->receiver->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($invitation->status) }}</td>
                                <td class="px-4 py-2">{{ $invitation->team->competition_name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $invitation->team->name ?? '-' }}</td>
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
                            <th class="px-4 py-2 text-left">Competition</th>
                            <th class="px-4 py-2 text-left">Team</th>
                            <th class="px-4 py-2 text-left">Action</th>
                            <th class="px-4 py-2 text-left">Messages</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receivedInvitations as $invitation)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $invitation->sender->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($invitation->status) }}</td>
                                <td class="px-4 py-2">{{ $invitation->team->competition_name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $invitation->team->name ?? '-' }}</td>
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
                                <td class="px-4 py-2">
                                    <a href="{{ route('invitations.show', $invitation->id) }}"
                                    class="text-sm text-indigo-600 hover:underline">
                                        View Messages
                                    </a>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#user_id').select2({
            placeholder: '🔍 Search for a user...',
            allowClear: true,
            width: 'resolve',
            dropdownParent: $('.card') // memastikan dropdown tidak terpotong jika dalam container
        });
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Ubah background dropdown Select2 */
    .select2-container .select2-dropdown {
        background-color: white;
        border: 1px solid #ccc;
        z-index: 9999;
    }

    /* Ubah background saat hover & selected */
    .select2-results__option--highlighted {
        background-color: #4f46e5 !important; /* indigo-600 */
        color: white !important;
    }

    .select2-selection {
        background-color: white !important;
    }
</style>
@endpush
