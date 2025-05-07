<h4>Beri Feedback untuk: {{ $team->name }}</h4>

<div class="mb-4">
<a href="{{ route('feedbacks.index') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
         ← Back to Feedback
    </a>
</div>

<form method="POST" action="{{ route('feedbacks.store') }}">
    @csrf
    <input type="hidden" name="team_id" value="{{ $team->id }}">

    {{-- Feedback ke Leader --}}
    @if ($team->leader_id !== auth()->id())
        <div class="mb-3">
            <label>Untuk {{ $team->leader->name }} (Leader)</label>
            <textarea name="feedback_member[{{ $team->leader->id }}]" class="form-control"></textarea>
        </div>
    @endif

    {{-- Feedback ke Member --}}
    @foreach ($team->acceptedMembers as $member)
        @if ($member->id !== auth()->id() && $member->id !== $team->leader_id)
            <div class="mb-3">
                <label>Untuk {{ $member->name }} (Anggota)</label>
                <textarea name="feedback_member[{{ $member->id }}]" class="form-control"></textarea>
            </div>
        @endif
    @endforeach

    <div class="mb-3">
        <label>Untuk Platform LombaKuy</label>
        <textarea name="feedback_platform" class="form-control"></textarea>
    </div>

    @if($competition)
        <div class="mb-3">
            <label>Untuk Penyelenggara ({{ $competition->organizer ?? 'Unknown Organizer' }})</label>
            <textarea name="feedback_organizer" class="form-control"></textarea>
        </div>
    @endif

    <button type="submit" class="btn btn-success">Kirim Feedback</button>
</form>
