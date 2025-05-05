@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Create Team</h2>

    <form method="POST" action="{{ route('teams.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name">Team Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="competition_name">Competition Name</label>
            <input type="text" name="competition_name" class="form-control"
                value="{{ $competition->title ?? '' }}" {{ isset($competition) ? 'readonly' : '' }} required>
        </div>

        @if(isset($recommendedUser))
            <input type="hidden" name="invite_user_id" value="{{ $recommendedUser->id ?? '' }}">
        @endif

        <div class="mb-3">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" value="{{ $competition->category ?? '' }}">
        </div>

        <div class="mb-3">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" class="form-control" value="{{ optional(optional($competition)->deadline)->format('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $competition->location ?? '' }}">
        </div>

        <div class="mb-3">
            <label for="description">Short Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $competition->description ?? '' }}</textarea>
        </div>

        @if(isset($competition))
            <input type="hidden" name="competition_id" value="{{ $competition->id }}">
        @endif

        <button type="submit" class="btn btn-primary">Create Team</button>
    </form>
</div>
@endsection
