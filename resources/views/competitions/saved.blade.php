@extends('layouts.app')

@section('title', 'Bookmark Saya')

@section('content')
<div class="py-8">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-2xl font-bold text-indigo-700">Kompetisi yang Disimpan</h2>
        <a href="{{ route('explore') }}" class="btn btn-secondary">← Kembali ke Eksplorasi</a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse ($savedCompetitions as $item)
            @php $competition = $item->competition; @endphp
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <div style="height: 220px; overflow: hidden;">
                        <img 
                            src="{{ asset('storage/' . $competition->photo) }}" 
                            class="card-img-top object-fit-cover"
                            alt="{{ $competition->title }}"
                            data-bs-toggle="modal"
                            data-bs-target="#previewModal"
                            data-img="{{ asset('storage/' . $competition->photo) }}"
                            style="cursor: pointer;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $competition->title }}</h5>
                        <p class="text-muted mb-1">{{ $competition->category }}</p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($competition->description, 80) }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-primary fw-semibold d-block">🎁 {{ $competition->prize }}</small>
                        <small class="text-danger d-block">⏰ {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</small>
                        <div class="d-flex gap-2 mt-2">
                            <a href="#" class="btn btn-sm btn-outline-primary w-100">Lihat Detail</a>
                            <form action="{{ route('competitions.unsave', $competition->id) }}" method="POST" class="w-100">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger w-100" onclick="return confirm('Hapus dari bookmark?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada kompetisi yang kamu simpan.</p>
                <a href="{{ route('explore') }}" class="btn btn-primary mt-3">Cari Lomba</a>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" class="rounded img-fluid" style="max-height: 80vh; object-fit: contain;">
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
        const modal = document.getElementById('previewModal');
        modal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const imageUrl = trigger.getAttribute('data-img');
            document.getElementById('modalImage').src = imageUrl;
        });
    });
</script>
@endpush
