@extends('layouts.app')

@section('title', 'Explore Competitions')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-indigo-900 overflow-hidden">
        <div class="container mx-auto px-6 py-16 md:py-24 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">Competitions Catalog</span>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight" data-aos="fade-up">
                    Explore Competitions Catalog
                </h1>
                <p class="text-indigo-100 text-lg md:text-xl max-w-2xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="100">
                    Find competitions that match your interests and skills. Filter, save, and join your dream competition now!
                </p>
                <div class="max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    <form method="GET" action="{{ route('explore') }}">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                class="w-full pl-12 pr-16 py-4 rounded-full border-0 focus:ring-2 focus:ring-indigo-500 shadow-lg text-gray-700"
                                placeholder="Search for your dream competition here...">
                            <div class="absolute inset-y-0 right-0 pr-4 flex">
                                <button dusk="submit-cari" type="submit" class="py-2 px-4 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 my-1 transition transform hover:scale-105">
                                    Search
                                </button>
                            </div>
                        </div>
                        <div id="searchSuggestions" class="absolute z-50 w-full bg-white rounded-lg shadow-lg hidden mt-2 max-h-60 overflow-y-auto"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 200">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L60,106.7C120,117,240,139,360,133.3C480,128,600,96,720,101.3C840,107,960,149,1080,154.7C1200,160,1320,128,1380,112L1440,96L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="container mx-auto px-4 -mt-6 mb-16 relative z-20">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden" data-aos="fade-up">
            <div class="p-1">
                <div class="p-5 md:p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-sliders-h text-indigo-600 mr-3"></i>
                        Filter Competitions
                    </h3>
                    <form method="GET" action="{{ route('explore') }}" class="grid grid-cols-1 md:grid-cols-6 gap-6" dusk="filter-form">
                        <!-- Category -->
                        <div class="md:col-span-2">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-th-list text-indigo-500 mr-2"></i> Category
                            </label>
                            <div class="relative">
                                <select name="category" id="category" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm appearance-none">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Prize -->
                        <div class="md:col-span-2">
                            <label for="prize" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-trophy text-yellow-500 mr-2"></i> Prize
                            </label>
                            <div class="relative">
                                <select name="prize_range" id="prize" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm appearance-none">
                                    <option value="">All Prizes</option>
                                    <option value="lt1" {{ request('prize_range') == 'lt1' ? 'selected' : '' }}>< 1 million</option>
                                    <option value="1to2" {{ request('prize_range') == '1to2' ? 'selected' : '' }}>1 - 2 million</option>
                                    <option value="gt2" {{ request('prize_range') == 'gt2' ? 'selected' : '' }}>> 2 million</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Filter Button -->
                            <button dusk="filter-form" type="submit" class="w-full bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-indigo-700 transition transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>

                            <!-- Bookmark Button -->
                            @auth
                            @if(auth()->user()->role === 'user')
                                <a href="{{ route('competitions.saved') }}" class="w-full bg-white border-2 border-indigo-600 text-indigo-600 font-medium py-3 px-4 rounded-lg hover:bg-indigo-50 transition transform hover:scale-105 flex items-center justify-center">
                                    <i class="fas fa-bookmark mr-2"></i> Bookmarks
                                </a>
                            @endif
                            @endauth
                            @guest
                                <div class="hidden md:block"></div>
                            @endguest

                            <!-- Clear Filters -->
                            <a href="{{ route('explore') }}" class="w-full bg-gray-100 text-gray-700 font-medium py-3 px-4 rounded-lg hover:bg-gray-200 transition transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-undo mr-2"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="container mx-auto px-4 mb-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col items-center text-center" data-aos="zoom-in" data-aos-delay="0">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-trophy text-indigo-600 text-xl"></i>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalActive }}+</h4>
                <p class="text-sm text-gray-500 mt-1">Active Competitions</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col items-center text-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-800">10K+</h4>
                <p class="text-sm text-gray-500 mt-1">Participants</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col items-center text-center" data-aos="zoom-in" data-aos-delay="200">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-medal text-yellow-600 text-xl"></i>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-800">300+</h4>
                <p class="text-sm text-gray-500 mt-1">Total Prizes (Million)</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col items-center text-center" data-aos="zoom-in" data-aos-delay="300">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-check text-red-600 text-xl"></i>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-800">30+</h4>
                <p class="text-sm text-gray-500 mt-1">Categories</p>
            </div>
        </div>
    </div>

    <!-- Competition Cards Section -->
    <div class="container mx-auto px-4 mb-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800" data-aos="fade-right">
                <i class="fas fa-list-alt text-indigo-600 mr-2"></i> Competitions Catalog
            </h2>
            <div class="text-gray-500 flex items-center" data-aos="fade-left">
                <form method="GET" action="{{ route('explore') }}" id="sortForm" class="flex items-center text-gray-500">
                    <i class="fas fa-sort mr-2"></i>
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-0 bg-transparent focus:ring-0 text-sm">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Nearest Deadline</option>
                        <option value="prize" {{ request('sort') == 'prize' ? 'selected' : '' }}>Largest Prize</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse ($competitions as $competition)
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
                <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                    <div class="bg-white rounded-2xl p-12 text-center shadow-lg border border-gray-100" data-aos="fade-up">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">No Competitions Found</h3>
                        <p class="text-gray-600 mb-6">No competitions are available yet. Try changing the filters or check back later!</p>
                        <a href="{{ route('explore') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-redo mr-2"></i> Reset Filters
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center" data-aos="fade-up">
            {{ $competitions->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="container mx-auto px-4 mb-16">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 md:p-12 shadow-xl relative overflow-hidden" data-aos="fade-up">
            <div class="absolute right-0 top-0 transform translate-x-1/4 -translate-y-1/4">
                <svg width="300" height="300" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="opacity-20">
                    <path fill="#FFFFFF" d="M42.7,-57.2C51.9,-45.7,54.3,-29.6,58.4,-13.5C62.4,2.6,68,18.8,63.1,30.9C58.1,43,42.6,51.1,27.1,57.9C11.5,64.7,-4.2,70.3,-17.2,66.4C-30.2,62.4,-40.6,49,-48.9,35.3C-57.3,21.5,-63.7,7.3,-63.1,-6.8C-62.6,-20.9,-55.2,-35,-44.2,-46.7C-33.1,-58.4,-18.5,-67.7,-1.5,-66C15.5,-64.2,33.5,-68.7,42.7,-57.2Z" transform="translate(100 100)" />
                </svg>
            </div>
            <div class="relative z-10 md:w-2/3">
                <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Stay Updated on the Latest Competitions</h3>
                <p class="text-indigo-100 mb-6">Don't miss the latest competitions that match your interests and skills. Subscribe now to receive notifications!</p>
                
                <form class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Enter your email" class="flex-grow py-3 px-4 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:outline-none">
                    <button type="submit" class="bg-white text-indigo-600 font-bold py-3 px-6 rounded-lg hover:bg-indigo-50 transition transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i> Subscribe
                    </button>
                </form>
            </div>
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
    
    /* Additional Styles */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Animated underline for links */
    .hover-underline-animation {
        position: relative;
    }
    
    .hover-underline-animation::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: currentColor;
        transform-origin: bottom right;
        transition: transform 0.3s ease-out;
    }
    
    .hover-underline-animation:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Modal functionality
    function openPreviewModal(imageUrl) {
        const modal = document.getElementById('previewModal');
        const modalImage = document.getElementById('modalImage');
        
        // Set image source
        modalImage.src = imageUrl;
        
        // Display modal
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePreviewModal() {
        const modal = document.getElementById('previewModal');
        
        // Hide modal
        modal.style.display = 'none';
        document.getElementById('modalImage').src = '';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('previewModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && document.getElementById('previewModal').style.display === 'flex') {
            closePreviewModal();
        }
    });

    // Search suggestions functionality
    const searchInput = document.getElementById('search');
    const suggestionsBox = document.getElementById('searchSuggestions');

    searchInput.addEventListener('input', async function() {
        const keyword = this.value.trim();

        if (keyword.length < 2) {
            suggestionsBox.classList.add('hidden');
            suggestionsBox.innerHTML = '';
            return;
        }

        try {
            const response = await fetch(`/search-suggestions?query=${encodeURIComponent(keyword)}`);
            const data = await response.json();

            if (data.length > 0) {
                suggestionsBox.innerHTML = data.map(item => 
                    `<div class="px-4 py-3 hover:bg-indigo-50 cursor-pointer text-gray-700 flex items-center" onclick="selectSuggestion('${item}')">
                        <i class="fas fa-search text-indigo-400 mr-3"></i>
                        ${item}
                    </div>`
                ).join('');
                suggestionsBox.classList.remove('hidden');
            } else {
                suggestionsBox.innerHTML = `<div class="px-4 py-3 text-gray-500 flex items-center"><i class="fas fa-info-circle text-gray-400 mr-3"></i>No results found...</div>`;
                suggestionsBox.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error fetching search suggestions:', error);
        }
    });

    function selectSuggestion(text) {
        searchInput.value = text;
        searchInput.form.submit();
    }

    document.addEventListener('click', function(e) {
        if (suggestionsBox && !suggestionsBox.contains(e.target) && e.target !== searchInput) {
            suggestionsBox.classList.add('hidden');
        }
    });

    // Initialize modal
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial display state of modal to none
        const modal = document.getElementById('previewModal');
        if (modal) {
            modal.style.display = 'none';
            console.log('Modal initialized');
        }
    });
</script>
@endpush