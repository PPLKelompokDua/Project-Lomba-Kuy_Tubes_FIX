@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Milestone</h2>
    
    <form action="{{ route('milestones.update', [$competitionId, $milestone->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $milestone->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description', $milestone->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="datetime-local" name="start_date" class="form-control" value="{{ \Carbon\Carbon::parse($milestone->start_date)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="datetime-local" name="end_date" class="form-control" value="{{ \Carbon\Carbon::parse($milestone->end_date)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option {{ $milestone->status == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                <option {{ $milestone->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option {{ $milestone->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('milestones.index', $competitionId) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
