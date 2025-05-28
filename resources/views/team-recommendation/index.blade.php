@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Rekomendasi Teman Tim</h2>
        </div>
        <div class="card-body">
            @if($recommendations->isEmpty())
                <p>Tidak ada rekomendasi saat ini.</p>
            @else
                @foreach($recommendations as $recommendation)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ optional($recommendation['user'])->name }}</h5>
                            <p class="card-text">
                                <strong>Kecocokan:</strong> {{ $recommendation['match_score'] }}%<br>
                                <strong>Keahlian:</strong> {{ $recommendation['expertise'] }}<br>
                                <strong>Gaya Kerja:</strong> {{ $recommendation['work_style'] }}
                            </p>
                            <a href="{{ route('messages.conversation', $recommendation['user']->id) }}" 
                               class="btn btn-primary">Kirim Pesan</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
