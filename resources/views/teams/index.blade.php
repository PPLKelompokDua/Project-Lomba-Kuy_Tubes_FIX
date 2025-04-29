@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">My Teams</h2>
        <a href="{{ route('teams.create') }}" class="btn btn-primary">
            + Create Team
        </a>
    </div>

    @if($teams->isEmpty())
        <div class="alert alert-info">
            You haven't created any teams yet.
        </div>
    @else
        <div class="row">
            @foreach($teams as $team)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $team->name }}</h5>
                                <p class="card-text mb-1"><strong>Competition:</strong> {{ $team->competition_name }}</p>
                                <p class="card-text mb-3"><strong>Members:</strong> {{ $team->acceptedMembers->count() }}</p>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('teams.show', $team->id) }}" class="btn btn-primary btn-sm">
                                    View Team
                                </a>
                                <a href="{{ route('invitations.index', ['team_id' => $team->id]) }}" class="btn btn-success btn-sm">
                                    Manage Invitations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
