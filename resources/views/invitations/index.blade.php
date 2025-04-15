@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Manage Invitations</h2>

    <!-- Form: Invite User -->
    <div class="card mb-4">
        <div class="card-header">Invite a Team Member</div>
        <div class="card-body">
            <form action="{{ route('invitations.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="receiver_id" class="form-label">Select User to Invite</label>
                    <select class="form-select" name="receiver_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Send Invitation</button>
            </form>
        </div>
    </div>

    <!-- Table: Sent Invitations -->
    <div class="card">
        <div class="card-header">Sent Invitations</div>
        <div class="card-body">
            @if($invitations->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invitations as $invite)
                            <tr>
                                <td>{{ $invite->receiver->name }}</td>
                                <td>{{ $invite->receiver->email }}</td>
                                <td>
                                    @if($invite->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($invite->status == 'accepted')
                                        <span class="badge bg-success">Accepted</span>
                                    @else
                                        <span class="badge bg-danger">Declined</span>
                                    @endif
                                </td>
                                <td>{{ $invite->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No invitations sent yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
