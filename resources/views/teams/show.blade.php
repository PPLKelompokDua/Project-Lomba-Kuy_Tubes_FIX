@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>{{ $team->name }} - Team Members</h2>
    <p>{{ $team->competition_name }}</p>

    <h4 class="mt-4">Accepted Members</h4>
    @if($team->acceptedMembers->isEmpty())
        <p>No accepted members yet.</p>
    @else
        <ul class="list-group">
            @foreach($team->acceptedMembers as $member)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $member->name }}
                    <span class="badge bg-primary">{{ $member->email }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('invitations.create', ['team_id' => $team->id]) }}" class="btn btn-outline-success mt-4">Manage Invitations</a>
</div>
@endsection
