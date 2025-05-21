@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ulangi Assessment</h2>
    <form action="{{ route('assessment.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="result" class="form-label">Jawaban / Hasil</label>
            <textarea name="result" id="result" class="form-control" rows="5" required>{{ old('result') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
