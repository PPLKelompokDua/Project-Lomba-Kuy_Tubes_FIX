@extends('layouts.organizer')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-2xl font-bold text-indigo-700">Feedback dari Peserta</h2>

    @if ($organizerFeedbacks->isEmpty())
        <div class="alert alert-info">Belum ada feedback dari peserta.</div>
    @else
        <div class="list-group">
            @foreach ($organizerFeedbacks as $feedback)
            <div class="list-group-item mb-3 border rounded shadow-sm p-3">
                <div class="mb-2"><strong>Dari:</strong> {{ $feedback->sender->name }}</div>
                <div class="mb-2"><strong>Tim:</strong> {{ $feedback->team->name }}</div>
                <div class="mb-2">
                    <strong>Kompetisi:</strong>
                    {{ $feedback->team->competition_name ?? '-' }}
                </div>
                <div><strong>Isi:</strong><br> {{ $feedback->content }}</div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
