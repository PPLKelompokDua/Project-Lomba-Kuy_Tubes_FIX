@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('feedbacks.index') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            ← Kembali ke Feedback
        </a>
    </div>

    <h2 class="mb-4 text-2xl font-bold text-indigo-700">Feedback yang Kamu Terima</h2>

    @if ($feedbacksForMe->isEmpty())
        <div class="alert alert-info">
            Belum ada feedback yang kamu terima.
        </div>
    @else
        <div class="list-group">
            @foreach ($feedbacksForMe as $feedback)
            <div class="list-group-item mb-3 border rounded shadow-sm p-3">
                <div class="mb-2">
                    <strong>Dari:</strong> {{ $feedback->sender?->name ?? 'Pengguna Tidak Dikenal' }}
                </div>
                
                <div class="mb-2">
                    <strong>Tim:</strong> {{ $feedback->team->name ?? '-' }} <br>
                    <strong>Lomba:</strong> {{ $feedback->team->competition_name ?? '-' }}
                </div>

                <div>
                    <strong>Isi Feedback:</strong><br>
                    <div class="bg-light p-2 rounded border">
                        {{ $feedback->content }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
