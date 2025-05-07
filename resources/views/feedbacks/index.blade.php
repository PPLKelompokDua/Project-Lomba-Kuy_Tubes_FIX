@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Feedback untuk Tim</h2>

    <div class="mb-4 text-end">
        <a href="{{ route('feedbacks.received') }}" class="btn btn-outline-info">
            💬 Lihat Feedback yang Saya Terima
        </a>
    </div>

    @if($allTeams->isEmpty())
        <p class="text-muted">Kamu belum pernah tergabung di tim manapun.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Team</th>
                    <th>Competition</th>
                    <th>Status</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allTeams as $team)
                    <tr>
                        <td>{{ $team->name }}</td>
                        <td>{{ $team->competition_name ?? '-' }}</td>
                        <td>{{ ucfirst($team->status_team) }}</td>
                        <td>
                            @if($team->status_team !== 'finished')
                                <span class="badge bg-secondary">Belum selesai</span>
                            @elseif(in_array($team->id, $givenFeedback))
                                <span class="badge bg-success">Sudah memberi feedback</span>
                                <div class="mt-2 d-flex gap-2">
                                    <a href="{{ route('feedbacks.edit', ['team_id' => $team->id]) }}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('feedbacks.destroyByTeam', ['team_id' => $team->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus feedback?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('feedbacks.create', ['team_id' => $team->id]) }}" class="btn btn-primary btn-sm">
                                    Kasih Feedback
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
