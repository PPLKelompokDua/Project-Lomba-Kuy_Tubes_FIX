@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Milestone</h2>
    <form action="{{ route('milestones.store', $competitionId) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-select" required>
                <option value="Not Started">Belum Dimulai</option>
                <option value="In Progress">Sedang Berjalan</option>
                <option value="Completed">Selesai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
