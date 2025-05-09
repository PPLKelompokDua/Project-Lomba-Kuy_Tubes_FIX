@extends('layouts.app')

@section('title', 'Edit Feedbacks')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('feedbacks.index') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            ← Back to Feedback
        </a>
    </div>

    <h1 class="mb-4">Edit Feedback untuk Tim {{ $team->name }}</h1>

    <form action="{{ route('feedbacks.updateByTeam', ['team_id' => $team->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="team_id" value="{{ $team->id }}">

        {{-- Feedback ke Anggota Tim --}}
        <h4 class="mb-3">Feedback untuk Anggota Tim</h4>

        {{-- Feedback ke Leader (jika bukan diri sendiri) --}}
        @if ($team->leader_id !== auth()->id())
            <div class="mb-3">
                <label for="feedback_member[{{ $team->leader->id }}]" class="form-label">
                    {{ $team->leader->name }} (Leader)
                </label>
                <textarea name="feedback_member[{{ $team->leader->id }}]" class="form-control" rows="2">{{ old("feedback_member.{$team->leader->id}", $memberFeedback[$team->leader->id]->content ?? '') }}</textarea>
            </div>
        @endif

        {{-- Feedback ke Member (selain diri sendiri & leader) --}}
        @foreach($team->acceptedMembers as $member)
            @if ($member->id !== auth()->id() && $member->id !== $team->leader_id)
                <div class="mb-3">
                    <label for="feedback_member[{{ $member->id }}]" class="form-label">
                        {{ $member->name }} (Member)
                    </label>
                    <textarea name="feedback_member[{{ $member->id }}]" class="form-control" rows="2">{{ old("feedback_member.{$member->id}", $memberFeedback[$member->id]->content ?? '') }}</textarea>
                </div>
            @endif
        @endforeach

        {{-- Feedback ke Platform --}}
        <h4 class="mb-3 mt-4">Feedback untuk Platform LombaKuy</h4>
        <div class="mb-3">
            <textarea name="feedback_platform" class="form-control" rows="3">{{ old('feedback_platform', $platformFeedback->content ?? '') }}</textarea>
        </div>

        {{-- Feedback ke Organizer --}}
        @if ($team->competition && $team->competition->organizer_id)
            <h4 class="mb-3 mt-4">Feedback untuk Penyelenggara Lomba</h4>
            <div class="mb-3">
                <textarea name="feedback_organizer" class="form-control" rows="3">{{ old('feedback_organizer', $organizerFeedback->content ?? '') }}</textarea>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Update Feedback</button>
        <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
