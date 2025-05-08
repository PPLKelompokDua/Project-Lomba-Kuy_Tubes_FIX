@extends('layouts.app')

@section('title', 'My Bookmarks')

@section('content')
<div class="py-16 bg-gray-50">
    <!-- Header Section -->
    <div class="container mx-auto px-6 mb-12">
        <div class="flex justify-between items-center" data-aos="fade-up">
            <div>
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">MY BOOKMARKS</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800">Saved Competitions</h2>
            </div>
            <a href="{{ route('explore') }}" class="bg-white border-2 border-indigo-600 text-indigo-600 font-bold py-3 px-6 rounded-lg hover:bg-indigo-50 transition transform hover:scale-105 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Explore
            </a>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($savedCompetitions as $item)
                @php $competition = $item->competition; @endphp
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="relative h-56">
                        <img 
                            src="{{ asset('storage/' . ($competition->photo ?? 'images/default-competition.jpg')) }}" 
                            class="w-full h-full object-cover"
                            alt="{{ $competition->title ?? 'Competition Image' }}"
                            style="height: 100%; width: 100%; object-fit: cover;"
                            onclick="openPreviewModal('{{ asset('storage/' . ($competition->photo ?? 'images/default-competition.jpg')) }}')"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-600 bg-opacity-90 text-white backdrop-blur-sm">
                                {{ $competition->category }}
                            </span>
                        </div>
                        
                        <!-- View Poster Button -->
                        <div class="absolute top-4 right-16">
                            <button onclick="openPreviewModal('{{ asset('storage/' . ($competition->photo)) }}')" 
                                    class="bg-white p-2 rounded-full shadow hover:bg-blue-100 transition transform hover:scale-110" 
                                    title="View Poster">
                                <i class="fas fa-search-plus text-blue-600"></i>
                            </button>
                        </div>
                        
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
                                    <button class="bg-white p-2 rounded-full shadow hover:bg-red-100 transition transform hover:scale-110" title="Remove Bookmark">
                                        <i class="fas fa-bookmark text-red-500"></i>
                                    </button>
                                @else
                                    <button class="bg-white p-2 rounded-full shadow hover:bg-indigo-100 transition transform hover:scale-110" title="Save Bookmark">
                                        <i class="far fa-bookmark text-indigo-600"></i>
                                    </button>
                                @endif
                            </form>
                        @endif
                        @endauth
                        
                        <!-- Deadline Badge -->
                        <div class="absolute bottom-4 left-4">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-600 bg-opacity-90 text-white backdrop-blur-sm">
                                <i class="fas fa-clock mr-1"></i>
                                {{ \Carbon\Carbon::parse($competition->deadline)->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-3 {{ $competition->status === 'open' ? 'bg-green-500 text-white' : ($competition->status === 'closed' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-800') }}">
                            <i class="fas {{ $competition->status === 'open' ? 'fa-unlock' : ($competition->status === 'closed' ? 'fa-lock' : 'fa-check-circle') }} mr-1"></i>
                            {{ ucfirst($competition->status) }}
                        </span>
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 hover:text-indigo-600 transition">{{ $competition->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit($competition->description, 100) }}</p>
                        
                        <!-- Prize and Deadline -->
                        <div class="space-y-4 mb-5">
                            <!-- Prize -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-gift text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Total Prize</p>
                                    <p class="font-bold text-gray-800">{{ $competition->prize }}</p>
                                </div>
                            </div>
                            <!-- Deadline -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-red-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Deadline</p>
                                    <p class="font-bold text-gray-800">
                                        {{ $competition->deadline ? \Carbon\Carbon::parse($competition->deadline)->format('M d, Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('competitions.show', $competition->id) }}" dusk="lihat-detail-{{ $competition->id }}" class="block w-full bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-indigo-700 transition text-center transform hover:scale-105">
                                <i class="fas fa-eye mr-2"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12" data-aos="fade-up">
                    <p class="text-gray-600 text-lg mb-4">You haven't saved any competitions yet.</p>
                    <a href="{{ route('explore') }}" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition transform hover:scale-105 inline-flex items-center">
                        <i class="fas fa-search mr-2"></i> Find Competitions
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
                <button type="button" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition" onclick="closePreviewModal()">Close</button>
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