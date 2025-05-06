@extends(auth()->user()->role === 'organizer' ? 'layouts.organizer' : 'layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover-rise" data-aos="fade-up">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Profil Saya</h2>
            <a href="{{ route('dashboard') }}"
               class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold transition"
               data-aos="fade-left">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Profile Information -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" data-aos="fade-up" data-aos-delay="100">
            <!-- Profile Image -->
            <div class="text-center">
                <img src="{{ $user->profile_image ? asset('storage/images/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                     alt="{{ $user->name }}'s Profile"
                     class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto border-2 border-indigo-100 cursor-pointer shadow-md"
                     onclick="openPreviewModal('{{ $user->profile_image ? asset('storage/images/' . $user->profile_image) : 'https://via.placeholder.com/150' }}')">
                <p class="text-sm text-gray-500 mt-2">Klik untuk melihat foto profil</p>
            </div>
            <!-- User Details -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $user->name }}</h3>
                <p class="text-sm text-gray-600 mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="text-sm text-gray-600 mb-2"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                @if ($user->description)
                    <p class="text-sm text-gray-600 mb-2"><strong>Deskripsi:</strong> {{ $user->description }}</p>
                @endif

                @if ($user->achievements)
                    <p class="text-sm text-gray-600 mb-2"><strong>Prestasi:</strong> {{ $user->achievements }}</p>
                @endif

                @if ($user->personality_type)
                    <p class="text-sm text-gray-600 mb-2"><strong>Kepribadian:</strong> {{ $user->personality_type }}</p>
                @endif

                @if ($user->preferred_role)
                    <p class="text-sm text-gray-600 mb-2"><strong>Peran yang Diinginkan:</strong> {{ $user->preferred_role }}</p>
                @endif

                @if (!empty($user->experience))
                    <p class="text-sm text-gray-600 mb-2"><strong>Pengalaman Kompetisi:</strong> {{ implode(', ', $user->experience) }}</p>
                @endif
            </div>
        </div>

        <!-- Action Button -->
        <div class="flex justify-end mb-8" data-aos="fade-up" data-aos-delay="150">
            <a href="{{ route('profile.edit') }}"
               class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg flex items-center transition min-w-[120px] shadow-md action-button">
                <i class="fas fa-edit mr-2"></i> Edit Profil
            </a>
            <a href="{{ route('assessment.index') }}"
                class="ml-4 bg-white border border-indigo-600 text-indigo-600 hover:bg-indigo-50 px-6 py-3 rounded-lg flex items-center transition min-w-[120px] shadow-md action-button">
                    <i class="fas fa-brain mr-2"></i> Assessment
            </a>

        </div>

        

        @if(auth()->user()->role === 'user')
        <!-- Saved Competitions -->
        <div data-aos="fade-up" data-aos-delay="200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Lomba Tersimpan</h2>
                <a href="{{ route('competitions.saved') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                @forelse($user->savedCompetitions as $competition)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 hover:shadow-xl" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <!-- Image Section -->
                        <div class="relative h-56">
                            <img src="{{ asset('storage/' . $competition->photo)}}"
                                 class="w-full h-full object-cover"
                                 alt="{{ $competition->title ?? 'Competition Image' }}"
                                 style="height: 100%; width: 100%; object-fit: cover;"
                                 onclick="openPreviewModal('{{ asset('storage/' . $competition->photo) }}')">
                            <!-- Bookmark Button -->
                            <form action="{{ route('competitions.unsave', $competition->id) }}"
                                  method="POST"
                                  class="absolute top-4 right-4">
                                @csrf
                                @method('DELETE')
                                <button class="bg-white p-2 rounded-full shadow hover:bg-red-100 transition" title="Hapus Bookmark">
                                    <i class="fas fa-bookmark text-red-500"></i>
                                </button>
                            </form>
                        </div>
                        <!-- Card Body -->
                        <div class="p-6">
                            <h5 class="text-xl font-bold text-gray-800 mb-2">{{ $competition->title ?? 'Judul Kompetisi' }}</h5>
                            <p class="text-sm text-indigo-600 font-semibold mb-2">{{ $competition->category ?? 'Umum' }}</p>
                            <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($competition->description ?? 'Deskripsi kompetisi.', 100) }}</p>
                        </div>
                        <!-- Card Footer -->
                        <div class="p-6 bg-gray-50 border-t border-gray-100">
                            <div class="flex items-center text-sm mb-2">
                                <i class="fas fa-gift text-indigo-600 mr-2"></i>
                                <span class="text-gray-800 font-semibold">Hadiah: {{ $competition->prize ?? 'Belum ditentukan' }}</span>
                            </div>
                            <div class="flex items-center text-sm mb-4">
                                <i class="fas fa-clock text-red-500 mr-2"></i>
                                <span class="text-gray-800">Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</span>
                            </div>
                            <a href="#"
                               class="block w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition text-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 bg-indigo-50 rounded-xl p-8 text-center" data-aos="fade-up">
                        <svg class="w-16 h-16 text-indigo-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Lomba Tersimpan</h3>
                        <p class="text-gray-600">Simpan kompetisi yang menarik untuk dilihat nanti.</p>
                        <a href="{{ route('explore') }}" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg px-5 py-2.5">
                            Temukan Kompetisi
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
        @endif
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
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
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        z-index: -1;
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .action-button:hover::after {
        opacity: 0.5;
    }
    
    @media (max-width: 640px) {
        .max-w-4xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    function openPreviewModal(imageUrl) {
        console.log('Opening modal with image:', imageUrl);
        const modal = document.getElementById('previewModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePreviewModal() {
        console.log('Closing modal');
        const modal = document.getElementById('previewModal');
        modal.classList.add('hidden');
        document.getElementById('modalImage').src = '';
        document.body.style.overflow = 'auto';
    }

    document.getElementById('previewModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('previewModal').classList.contains('hidden')) {
            closePreviewModal();
        }
    });
</script>
@endpush