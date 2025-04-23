@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Conversation with {{ $invitation->receiver->name }}</h3>

    <!-- Status invitation -->
    <p>Status: 
        @if ($invitation->status == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>
        @elseif ($invitation->status == 'accepted')
            <span class="badge bg-success">Accepted</span>
        @else
            <span class="badge bg-danger">Declined</span>
        @endif
    </p>

    <!-- Chat box -->
    <div class="card mb-3">
        <div class="card-header">Messages</div>
        <div class="card-body" style="max-height: 300px; overflow-y: scroll;">
            @foreach($invitation->messages as $message)
                <div class="mb-2">
                    <strong>{{ $message->sender->name }}:</strong> {{ $message->content }}
                    <small class="text-muted d-block">{{ $message->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Send message -->
    <form action="{{ route('messages.store', $invitation->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3" placeholder="Write a message..."></textarea>
        </div>
        <button class="btn btn-primary">Send</button>
    </form>

    @if (auth()->id() === $invitation->receiver_id && $invitation->status === 'pending')
        <div class="mt-4">
            <form action="{{ route('invitations.respond', ['id' => $invitation->id, 'response' => 'accepted']) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-success">Accept</button>
            </form>
            <form action="{{ route('invitations.respond', ['id' => $invitation->id, 'response' => 'declined']) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-danger">Decline</button>
            </form>
        </div>
    @endif
</div>
@endsection
