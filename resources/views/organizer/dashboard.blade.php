@extends('layouts.organizer')

@section('title', 'Organizer Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner with Quick Stats -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="relative p-8 md:p-10">
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white bg-opacity-10 rounded-full blur-xl"></div>
            <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-40 h-40 bg-indigo-400 bg-opacity-20 rounded-full blur-xl"></div>
            
            <div class="relative grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2" data-aos="fade-right">Selamat datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-indigo-100 text-lg mb-6" data-aos="fade-right" data-aos-delay="100">Kelola kompetisi Anda dan wujudkan acara luar biasa.</p>
                    <a href="{{ route('organizer.competitions.create') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 font-semibold rounded-lg px-5 py-3 transition shadow-lg flex items-center w-fit" data-aos="fade-right" data-aos-delay="200">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Lomba Baru
                    </a>
                </div>
                <div class="grid grid-cols-1 gap-4" data-aos="fade-left">
                    <div class="bg-indigo-800 bg-opacity-30 p-6 rounded-xl shadow-md">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="p-2 bg-indigo-900 bg-opacity-50 rounded-lg">
                                <i class="fas fa-trophy text-white text-2xl"></i>
                            </div>
                            <span class="text-white text-lg font-semibold">Total Kompetisi Dibuat</span>
                        </div>
                        <h4 class="text-4xl font-bold text-white">{{ $totalCompetitions }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Competitions Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden" data-aos="fade-up">
        <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Kompetisi yang Kamu Buat</h2>
            <a href="{{ route('organizer.competitions.create') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold">
                <i class="fas fa-plus-circle mr-1"></i> Tambah Lomba
            </a>
        </div>
        
        @if ($competitions->count())
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-sm">
                    <thead class="bg-indigo-50 text-left text-gray-700">
                        <tr>
                            <th class="p-4">Poster</th>
                            <th class="p-4">Judul</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Deadline</th>
                            <th class="p-4">Hadiah</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competitions as $competition)
                            <tr class="border-t hover:bg-gray-50 transition hover-rise">
                                <td class="p-4">
                                    <img 
                                        src="{{ asset('storage/' . ($competition->photo ?? 'images/default-competition.jpg')) }}" 
                                        class="w-16 h-16 object-cover rounded-lg cursor-pointer"
                                        alt="{{ $competition->title ?? 'Competition Image' }}"
                                        onclick="openPreviewModal('{{ asset('storage/' . ($competition->photo ?? 'images/default-competition.jpg')) }}')"
                                    >
                                </td>
                                <td class="p-4 font-medium">{{ $competition->title }}</td>
                                <td class="p-4">{{ $competition->category ?? 'Umum' }}</td>
                                <td class="p-4">{{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</td>
                                <td class="p-4">{{ $competition->prize }}</td>
                                <td class="p-4 flex gap-3 justify-center">
                                    <a href="{{ route('organizer.competitions.show', $competition->id) }}"
                                       class="text-indigo-600 hover:bg-indigo-100 p-2 rounded-full transition"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('organizer.competitions.edit', $competition->id) }}"
                                       class="text-yellow-600 hover:bg-yellow-100 p-2 rounded-full transition"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('organizer.competitions.destroy', $competition->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus lomba ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:bg-red-100 p-2 rounded-full transition"
                                                type="submit"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center" data-aos="fade-up">
                <svg class="w-16 h-16 text-indigo-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada kompetisi</h3>
                <p class="text-gray-600 mb-4">Buat kompetisi pertama Anda sekarang!</p>
                <a href="{{ route('organizer.competitions.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg px-5 py-2.5">
                    Tambah Kompetisi
                </a>
            </div>
        @endif
    </div>

    @if ($competitions->hasPages())
        <div class="mt-6 flex justify-center" data-aos="fade-up">
            {{ $competitions->links() }}
        </div>
    @endif

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
    /* Custom Animations for Elements */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    /* Custom Scrollbar for Lists */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #818cf8;
    }
    
    /* Card hover effects */
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    /* Glowing effect for buttons */
    .action-button {
        position: relative;
    }
    
    .action-button::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8, #c7d2fe);
        z-index: -1;
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .action-button:hover::after {
        opacity: 0.7;
        animation: rotate-gradient 3s linear infinite;
    }
    
    @keyframes rotate-gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Pulse notification dot */
    .notification-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        background-color: #ef4444;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    
    /* Table row animation */
    .table-row-animate {
        position: relative;
        overflow: hidden;
    }
    
    .table-row-animate::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: progress-shine 2s infinite;
    }
    
    @keyframes progress-shine {
        100% { left: 100%; }
    }
    
    /* Pagination styling */
    .pagination .page-link {
        color: #4f46e5;
        border: 1px solid #e0e7ff;
        margin: 0 4px;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .pagination .page-link:hover {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
        color: white;
    }
    
    .pagination-info {
        display: none !important;
    }
    
    /* Responsive adjustments for mobile */
    @media (max-width: 640px) {
        .dashboard-grid {
            display: flex;
            flex-direction: column;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>
@endpush

@push('styles')
<style>
    .stats-card {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
    });

    // Modal Preview Functions
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