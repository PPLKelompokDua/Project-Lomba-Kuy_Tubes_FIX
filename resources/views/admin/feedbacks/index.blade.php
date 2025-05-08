@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-2xl font-bold text-indigo-700">Feedback untuk Platform</h2>

    @if ($platformFeedbacks->isEmpty())
        <div class="alert alert-info">Belum ada feedback untuk platform.</div>
    @else
        <div class="list-group">
            @foreach ($platformFeedbacks as $feedback)
            <div class="list-group-item mb-3 border rounded shadow-sm p-3">
                <div><strong>Dari:</strong> {{ $feedback->sender->name }}</div>
                <div><strong>Tim:</strong> {{ $feedback->team->name }}</div>
                <div><strong>Isi:</strong><br> {{ $feedback->content }}</div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
