@extends('layouts.app')

@section('title', 'Eksplorasi Lomba')

@section('content')
<div class="py-8">
    <h2 class="text-3xl font-bold text-center mb-8">Eksplorasi Katalog Lomba</h2>

    <!-- Filter Form -->
    <div class="mb-6 text-center">
        <form method="GET" action="{{ route('explore') }}" class="d-inline-flex flex-wrap gap-3 justify-content-center">
            <div>
                <label for="category" class="form-label">Kategori</label>
                <select name="category" id="category" class="form-select w-auto">
                    <option value="">Semua</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="prize" class="form-label">Hadiah</label>
                <select name="prize_range" id="prize" class="form-select w-auto">
                    <option value="">Semua</option>
                    <option value="lt1" {{ request('prize_range') == 'lt1' ? 'selected' : '' }}>< 1 juta</option>
                    <option value="1to2" {{ request('prize_range') == '1to2' ? 'selected' : '' }}>1 - 2 juta</option>
                    <option value="gt2" {{ request('prize_range') == 'gt2' ? 'selected' : '' }}>> 2 juta</option>
                </select>
            </div>

            <div class="align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        @auth
        @if(auth()->user()->role === 'user')
            <div class="mt-3">
                <a href="{{ route('competitions.saved') }}" class="btn btn-outline-secondary btn-sm">
                    📌 Lihat Bookmark Saya
                </a>
            </div>
        @endif
        @endauth
    </div>

    <!-- Katalog Cards -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse ($competitions as $competition)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <div style="height: 220px; overflow: hidden; position: relative;">
                        <img 
                            src="{{ asset('storage/' . $competition->photo) }}" 
                            class="card-img-top img-thumbnail object-fit-cover"
                            alt="{{ $competition->title }}"
                            style="cursor: pointer"
                            data-bs-toggle="modal"
                            data-bs-target="#previewModal"
                            data-img="{{ asset('storage/' . $competition->photo) }}">

                        @auth
                        @if(auth()->user()->role === 'user')
                            <form action="{{ auth()->user()->savedCompetitions->contains($competition->id) 
                                            ? route('competitions.unsave', $competition->id) 
                                            : route('competitions.save', $competition->id) }}" 
                                  method="POST" 
                                  style="position: absolute; top: 10px; right: 10px;">
                                @csrf
                                @if(auth()->user()->savedCompetitions->contains($competition->id))
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light border rounded-circle" title="Hapus Bookmark">
                                        <i class="bi bi-bookmark-fill text-danger"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-light border rounded-circle" title="Simpan Bookmark">
                                        <i class="bi bi-bookmark"></i>
                                    </button>
                                @endif
                            </form>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $competition->title }}</h5>
                        <p class="text-muted mb-1">{{ $competition->category }}</p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($competition->description, 80) }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-primary fw-semibold d-block">🎁 Hadiah: {{ $competition->prize }}</small>
                        <small class="text-danger d-block">⏰ Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</small>
                        <a href="#" class="btn btn-sm btn-outline-primary w-100 mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                <p>Belum ada kompetisi tersedia.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5 w-100">
        <nav>
            {{ $competitions->appends(request()->query())->links() }}
        </nav>
    </div>
</div>

<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" 
                    src="" 
                    alt="Full Poster" 
                    class="rounded" 
                    style="display: block; margin-left: auto; margin-right: auto; max-width: 100%; max-height: 80vh; object-fit: contain;">
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
        const previewModal = document.getElementById('previewModal');
        previewModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const imageUrl = trigger.getAttribute('data-img');
            document.getElementById('modalImage').src = imageUrl;
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .pagination {
        margin-top: 2rem;
    }
    .pagination .page-item .page-link {
        border-radius: 6px;
        margin: 0 3px;
        color: #4F46E5; /* Tailwind indigo-600 */
    }
    .pagination .page-item.active .page-link {
        background-color: #F97316; /* Tailwind orange-500 */
        border-color: #F97316;
        color: white;
    }
</style>
@endpush
