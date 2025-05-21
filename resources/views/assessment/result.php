@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Hasil Assessment Terbaru</h2>
    <p>{{ $result->result ?? 'Belum ada hasil.' }}</p>
    <a href="{{ route('assessment.retake') }}" class="btn btn-primary">Ulangi Assessment</a>
</div>
@endsection
