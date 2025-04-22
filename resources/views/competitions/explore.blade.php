@extends('layouts.app')

@section('title', 'Eksplorasi Lomba')

@section('content')
<div class="py-10">
    <h2 class="text-4xl font-extrabold text-center text-indigo-700 mb-10">
        Eksplorasi Katalog Lomba
    </h2>

    <!-- Filter Bar -->
    <!-- Filter Form - Full Width Box -->
    <div class="mb-10 mx-auto" style="max-width: 1140px;">
        <div class="bg-white shadow rounded-xl p-6 border border-gray-200">
            <form method="GET" action="{{ route('explore') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <select name="category" id="category" class="form-select w-full">
                        <option value="">Semua</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hadiah -->
                <div>
                    <label for="prize" class="block text-sm font-semibold text-gray-700 mb-1">Hadiah</label>
                    <select name="prize_range" id="prize" class="form-select w-full">
                        <option value="">Semua</option>
                        <option value="lt1" {{ request('prize_range') == 'lt1' ? 'selected' : '' }}>< 1 juta</option>
                        <option value="1to2" {{ request('prize_range') == '1to2' ? 'selected' : '' }}>1 - 2 juta</option>
                        <option value="gt2" {{ request('prize_range') == 'gt2' ? 'selected' : '' }}>> 2 juta</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div>
                    <label class="block text-sm font-semibold text-transparent mb-1">-</label>
                    <button type="submit" class="btn btn-primary w-full">Filter</button>
                </div>

                <!-- Bookmark Button -->
                <div>
                    <label class="block text-sm font-semibold text-transparent mb-1">-</label>
                    @auth
                    @if(auth()->user()->role === 'user')
                        <a href="{{ route('competitions.saved') }}" class="btn btn-outline-secondary w-full">
                            📌 Bookmark Saya
                        </a>
                    @endif
                    @endauth
                </div>
            </form>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse ($competitions as $competition)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover:shadow-lg transition rounded-xl overflow-hidden">
                    <div class="relative" style="height: 220px; overflow: hidden;">
                        <img 
                            src="{{ asset('storage/' . $competition->photo) }}" 
                            class="card-img-top object-fit-cover"
                            alt="{{ $competition->title }}"
                            style="height: 100%; width: 100%; object-fit: cover;"
                            data-bs-toggle="modal"
                            data-bs-target="#previewModal"
                            data-img="{{ asset('storage/' . $competition->photo) }}"
                        >

                        @auth
                        @if(auth()->user()->role === 'user')
                            <form action="{{ auth()->user()->savedCompetitions->contains($competition->id) 
                                            ? route('competitions.unsave', $competition->id) 
                                            : route('competitions.save', $competition->id) }}" 
                                  method="POST" 
                                  style="position: absolute; top: 12px; right: 12px;">
                                @csrf
                                @if(auth()->user()->savedCompetitions->contains($competition->id))
                                    @method('DELETE')
                                    <button class="btn btn-sm bg-white rounded-full shadow hover:bg-red-100 transition" title="Hapus Bookmark">
                                        <i class="bi bi-bookmark-fill text-danger"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm bg-white rounded-full shadow hover:bg-indigo-100 transition" title="Simpan Bookmark">
                                        <i class="bi bi-bookmark text-indigo-600"></i>
                                    </button>
                                @endif
                            </form>
                        @endif
                        @endauth
                    </div>

                    <div class="card-body">
                        <h5 class="card-title text-indigo-700 font-semibold mb-1">{{ $competition->title }}</h5>
                        <p class="text-sm text-muted mb-1">{{ $competition->category }}</p>
                        <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($competition->description, 80) }}</p>
                    </div>
                    <div class="card-footer bg-white border-t text-sm">
                        <div class="mb-1">
                            <span class="text-primary fw-semibold">🎁 Hadiah: {{ $competition->prize }}</span>
                        </div>
                        <div>
                            <span class="text-danger">⏰ Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</span>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary w-100 mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada kompetisi tersedia.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $competitions->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" class="rounded" style="display: block; margin: 0 auto; max-width: 100%; max-height: 80vh; object-fit: contain;">
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
        color: #4F46E5;
    }
    .pagination .page-item.active .page-link {
        background-color: #F97316;
        border-color: #F97316;
        color: white;
    }
</style>
@endpush
