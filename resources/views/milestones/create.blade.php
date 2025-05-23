@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold text-primary">📝 Tambah Milestone</h3>

    <form action="{{ route('milestones.store', $team->id) }}" method="POST">
        @csrf

        <!-- Judul -->
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-type"></i></span>
                <input type="text" class="form-control" id="title" name="title" placeholder="Judul Milestone" required>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi milestone..." required></textarea>
            </div>
        </div>

        <!-- Tanggal & Waktu Mulai -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
            </div>
            <div class="col-md-6">
                <label for="start_time" class="form-label">Waktu Mulai</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                </div>
            </div>
        </div>

        <!-- Tanggal & Waktu Selesai -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
            </div>
            <div class="col-md-6">
                <label for="end_time" class="form-label">Waktu Selesai</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-clock-history"></i></span>
                    <input type="time" class="form-control" id="end_time" name="end_time" required>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label for="status" class="form-label">Status</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-flag"></i></span>
                <select class="form-select" id="status" name="status" required>
                    <option value="Not Started">Belum Dimulai</option>
                    <option value="In Progress">Sedang Berlangsung</option>
                    <option value="Completed">Selesai</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success shadow-sm px-4 py-2">💾 Simpan</button>
    </form>
</div>
@endsection

@push('styles')
<!-- Tambahkan Bootstrap Icons jika belum -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@push('scripts')
<style>
    input:focus, textarea:focus, select:focus {
        box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
        border-color: #6c63ff;
        transition: all 0.3s ease;
    }

    .input-group-text {
        background-color: #6c63ff;
        color: white;
    }

    label {
        font-weight: 500;
    }
</style>
@endpush