@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Feedback yang Kamu Terima</h2>
    @if($feedbacksForMe->isEmpty())
        <p class="text-muted">Belum ada feedback yang kamu terima.</p>
    @else
        <ul class="list-group">
            @foreach($feedbacksForMe as $feedback)
                <li class="list-group-item">
                    <strong>Dari:</strong> {{ $feedback->sender->name ?? 'User' }} <br>
                    <strong>Isi:</strong> {{ $feedback->content }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
