@extends('layouts.app')

@section('title', 'Bookmark Saya')

@section('content')
<div class="py-16 bg-gray-50">
    <!-- Header Section -->
    <div class="container mx-auto px-6 mb-12">
        <div class="flex justify-between items-center" data-aos="fade-up">
            <div>
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">BOOKMARK SAYA</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800">Kompetisi yang Disimpan</h2>
            </div>
            <a href="{{ route('explore') }}" class="bg-white border-2 border-indigo-600 text-indigo-600 font-bold py-3 px-6 rounded-lg hover:bg-indigo-50 transition transform hover:scale-105 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Eksplorasi
            </a>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($savedCompetitions as $item)
                @php $competition = $item->competition; @endphp
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 hover:shadow-xl">
                    <!-- Image Section -->
                    <div class="relative" style="height: 220px; overflow: hidden;">
                        <img 
                            src="{{ asset('storage/' . $competition->photo) }}" 
                            class="w-full h-full object-cover"
                            alt="{{ $competition->title }}"
                            style="height: 100%; width: 100%; object-fit: cover;"
                            onclick="openPreviewModal('{{ asset('storage/' . $competition->photo) }}')"
                        >
                        <!-- Bookmark Button -->
                        <form action="{{ route('competitions.unsave', $competition->id) }}" method="POST" class="absolute top-4 right-4">
                            @csrf
                            @method('DELETE')
                            <button class="bg-white p-2 rounded-full shadow hover:bg-red-100 transition" title="Hapus Bookmark" onclick="return confirm('Hapus dari bookmark?')">
                                <i class="fas fa-bookmark text-red-500"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <h5 class="text-xl font-bold text-gray-800 mb-2">{{ $competition->title }}</h5>
                        <p class="text-sm text-indigo-600 font-semibold mb-2">{{ $competition->category }}</p>
                        <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($competition->description, 80) }}</p>
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
                        <div class="flex gap-4">
                            <a href="#" class="flex-1 bg-white border-2 border-indigo-600 text-indigo-600 font-bold py-2 px-4 rounded-lg hover:bg-indigo-50 transition text-center">
                                Lihat Detail
                            </a>
                            <form action="{{ route('competitions.unsave', $competition->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button class="w-full bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition" onclick="return confirm('Hapus dari bookmark?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12" data-aos="fade-up">
                    <p class="text-gray-600 text-lg mb-4">Belum ada kompetisi yang kamu simpan.</p>
                    <a href="{{ route('explore') }}" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition transform hover:scale-105 inline-flex items-center">
                        <i class="fas fa-search mr-2"></i> Cari Lomba
                    </a>
                </div>
            @endforelse
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