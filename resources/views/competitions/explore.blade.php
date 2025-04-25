@extends('layouts.app')

@section('title', 'Eksplorasi Lomba')

@section('content')
<div class="py-16 bg-gray-50">
    <!-- Header Section -->
    <div class="container mx-auto px-6 mb-12 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">KATALOG LOMBA</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4" data-aos="fade-up">
            Eksplorasi Katalog Lomba
        </h2>
        <p class="text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Temukan kompetisi yang sesuai dengan minat dan keahlianmu. Filter, simpan, dan ikuti lomba impianmu sekarang!
        </p>
    </div>

    <!-- Filter Bar -->
    <div class="container mx-auto px-6 mb-12" data-aos="fade-up" data-aos-delay="200">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
            <form method="GET" action="{{ route('explore') }}" class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category" id="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hadiah -->
                <div>
                    <label for="prize" class="block text-sm font-semibold text-gray-700 mb-2">Hadiah</label>
                    <select name="prize_range" id="prize" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Hadiah</option>
                        <option value="lt1" {{ request('prize_range') == 'lt1' ? 'selected' : '' }}>< 1 juta</option>
                        <option value="1to2" {{ request('prize_range') == '1to2' ? 'selected' : '' }}>1 - 2 juta</option>
                        <option value="gt2" {{ request('prize_range') == 'gt2' ? 'selected' : '' }}>> 2 juta</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>

                <!-- Bookmark Button -->
                <div>
                    @auth
                    @if(auth()->user()->role === 'user')
                        <a href="{{ route('competitions.saved') }}" class="w-full bg-white border-2 border-indigo-600 text-indigo-600 font-bold py-3 px-6 rounded-lg hover:bg-indigo-50 transition transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-bookmark mr-2"></i> Bookmark Saya
                        </a>
                    @endif
                    @endauth
                </div>

                <!-- Clear Filters -->
                <div>
                    <a href="{{ route('explore') }}" class="w-full bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-300 transition transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-undo mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($competitions as $competition)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 hover:shadow-xl" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <!-- Image Section -->
                    <div class="relative h-56">
                        <img 
                            src="{{ asset('storage/' . $competition->photo) }}" 
                            class="w-full h-full object-cover"
                            alt="{{ $competition->title }}"
                            style="height: 100%; width: 100%; object-fit: cover;"
                            onclick="openPreviewModal('{{ asset('storage/' . $competition->photo) }}')"
                        >
                        <!-- Bookmark Button -->
                        @auth
                        @if(auth()->user()->role === 'user')
                            <form action="{{ auth()->user()->savedCompetitions->contains($competition->id) 
                                            ? route('competitions.unsave', $competition->id) 
                                            : route('competitions.save', $competition->id) }}" 
                                  method="POST" 
                                  class="absolute top-4 right-4">
                                @csrf
                                @if(auth()->user()->savedCompetitions->contains($competition->id))
                                    @method('DELETE')
                                    <button class="bg-white p-2 rounded-full shadow hover:bg-red-100 transition" title="Hapus Bookmark">
                                        <i class="fas fa-bookmark text-red-500"></i>
                                    </button>
                                @else
                                    <button class="bg-white p-2 rounded-full shadow hover:bg-indigo-100 transition" title="Simpan Bookmark">
                                        <i class="fas fa-bookmark text-indigo-600"></i>
                                    </button>
                                @endif
                            </form>
                        @endif
                        @endauth
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <h5 class="text-xl font-bold text-gray-800 mb-2">{{ $competition->title }}</h5>
                        <p class="text-sm text-indigo-600 font-semibold mb-2">{{ $competition->category }}</p>
                        <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($competition->description, 100) }}</p>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-6 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-gift text-indigo-600 mr-2"></i>
                            <span class="text-gray-800 font-semibold">Hadiah: {{ $competition->prize }}</span>
                        </div>
                        <div class="flex items-center text-sm mb-4">
                            <i class="fas fa-clock text-red-500 mr-2"></i>
                            <span class="text-gray-800">Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('competitions.show', $competition->id) }}" class="block w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12">
                    <p class="text-gray-600 text-lg">Belum ada kompetisi tersedia. Coba ubah filter atau periksa kembali nanti!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $competitions->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Modal Preview -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" id="previewModal">
        <div class="bg-white rounded-lg max-w-4xl w-full mx-4">
            <div class="p-4 text-center">
                <img id="modalImage" class="rounded mx-auto" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
            </div>
            <div class="p-4 border-t border-gray-200">
                <button type="button" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition" onclick="closePreviewModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    .pagination .page-link {
        @apply px-4 py-2 mx-1 rounded-lg text-indigo-600 hover:bg-indigo-100 transition;
    }
    .pagination .page-item.active .page-link {
        @apply bg-indigo-600 text-white border-indigo-600;
    }
    .pagination .page-item.disabled .page-link {
        @apply text-gray-400 cursor-not-allowed;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
    });

    function openPreviewModal(imageUrl) {
        console.log('Opening modal with image:', imageUrl); // Debug log
        const modal = document.getElementById('previewModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closePreviewModal() {
        console.log('Closing modal'); // Debug log
        const modal = document.getElementById('previewModal');
        modal.classList.add('hidden');
        document.getElementById('modalImage').src = ''; // Clear image
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close modal on click outside
    document.getElementById('previewModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('previewModal').classList.contains('hidden')) {
            closePreviewModal();
        }
    });
</script>
@endpush