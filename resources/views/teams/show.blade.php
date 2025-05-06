@extends('layouts.app')

@section('content')

<div class="mb-4">
<a href="{{ route('teams.index') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
         ← Back to My Teams
    </a>
</div>

<div class="container py-5">
    <h2>{{ $team->name }} - Team Members</h2>
    <p>{{ $team->competition_name }}</p>

    <h4 class="mt-4">Team Members</h4>
    <ul class="list-group">
        {{-- Tambahkan Leader --}}
        <li class="list-group-item d-flex justify-between align-items-center">
            {{ $team->leader->name }}
            <span class="badge bg-warning text-dark">Leader</span>
            <span class="badge bg-primary">{{ $team->leader->email }}</span>
        </li>

        {{-- Tambahkan Anggota --}}
        @foreach($team->acceptedMembers as $member)
            @if ($member->id !== $team->leader_id) {{-- Hindari duplikasi jika leader juga masuk acceptedMembers --}}
                <li class="list-group-item d-flex justify-between align-items-center">
                    {{ $member->name }}
                    <span class="badge bg-info">Team Member</span>
                    <span class="badge bg-primary">{{ $member->email }}</span>
                </li>
            @endif
        @endforeach
    </ul>

    @if($team->leader_id === $user->id)
        <a href="{{ route('invitations.index', ['team_id' => $team->id]) }}" class="btn btn-success btn-sm">
            Manage Invitations
        </a>
    @endif
</div>
@endsection
