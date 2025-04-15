@extends('layouts.organizer')

@section('title', 'Detail Lomba')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold text-indigo-700 mb-4">{{ $competition->title }}</h2>

    <p class="text-sm text-gray-500 mb-2"><strong>Kategori:</strong> {{ $competition->category }}</p>
    <p class="text-sm text-gray-500 mb-2"><strong>Hadiah:</strong> {{ $competition->prize }}</p>
    <p class="text-sm text-gray-500 mb-2"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</p>
    <p class="text-gray-700 mt-4 mb-6">{{ $competition->description }}</p>

    <!-- Tombol Preview Gambar -->
    <div class="mb-6 text-center">
        <img src="{{ asset('storage/' . $competition->photo) }}" 
             alt="Poster {{ $competition->title }}" 
             class="w-full max-w-md mx-auto rounded shadow cursor-pointer"
             style="max-height: 300px; object-fit: cover;"
             data-bs-toggle="modal"
             data-bs-target="#posterModal"
             data-img="{{ asset('storage/' . $competition->photo) }}">
        <p class="text-sm text-gray-500 mt-2">Klik gambar untuk melihat ukuran penuh</p>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('organizer.competitions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
            ← Kembali
        </a>
        <div class="space-x-2">
            <a href="{{ route('organizer.competitions.edit', $competition->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Edit</a>
            <form action="{{ route('organizer.competitions.destroy', $competition->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus lomba ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Gambar Poster -->
<div class="modal fade" id="posterModal" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-white">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full Poster" class="img-fluid rounded mx-auto d-block" style="max-height: 80vh; object-fit: contain;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const previewModal = document.getElementById('posterModal');
        previewModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const imageUrl = trigger.getAttribute('data-img');
            document.getElementById('modalImage').src = imageUrl;
        });
    });
</script>
@endpush
