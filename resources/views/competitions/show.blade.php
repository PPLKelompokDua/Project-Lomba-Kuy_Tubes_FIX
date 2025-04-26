@extends('layouts.app')

@section('title', $competition->title)

@section('content')

<!-- Hero section with gradient background -->
<div class="bg-gradient-to-r from-indigo-800 to-indigo-600 text-white rounded-xl overflow-hidden shadow-xl mb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col space-y-4">
            <a href="{{ route('explore') }}" class="inline-flex items-center text-indigo-100 hover:text-white transition duration-150 ease-in-out group w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-150 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to competitions
            </a>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-bold">{{ $competition->title }}</h1>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $competition->status === 'open' ? 'bg-green-500 text-white' : ($competition->status === 'closed' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-800') }}">
                            <i class="bi {{ $competition->status === 'open' ? 'bi-unlock-fill' : ($competition->status === 'closed' ? 'bi-lock-fill' : 'bi-check-circle-fill') }} mr-1"></i>
                            {{ ucfirst($competition->status) }}
                        </span>
                        <span class="text-indigo-100 flex items-center">
                            <i class="bi bi-person mr-1"></i>
                            Organized by {{ $competition->organizer->name ?? 'Unknown' }}
                        </span>
                    </div>

                    <p class="text-indigo-100 max-w-prose">{{ Str::limit($competition->description, 150) }}</p>
                </div>

                @if($competition->registration_link && $competition->status === 'open')
                <div class="shrink-0">
                    <a href="{{ $competition->registration_link }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-full shadow-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-1 transition-all duration-150 ease-in-out" target="_blank">
                        <i class="bi bi-pencil-square mr-2"></i>
                        Register Now
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main content area -->
<div class="mx-auto">
    <!-- Competition details in a two-column layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl overflow-hidden shadow-md">
                <div class="h-80 overflow-hidden relative">
                    @if($competition->photo)
                    <img src="{{ asset('storage/' . $competition->photo) }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" alt="{{ $competition->title }}" 
                         onclick="openPreviewModal('{{ asset('storage/' . $competition->photo) }}')">
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
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-indigo-800 to-indigo-600">
                        <div class="text-center text-white p-6">
                            <i class="bi bi-image text-4xl mb-2"></i>
                            <h3 class="text-xl font-semibold">No Image Available</h3>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b border-gray-200">Event Details</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                                <i class="bi bi-geo-alt-fill text-indigo-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Location</p>
                                <h5 class="font-bold text-gray-800">{{ $competition->location ?? '-' }}</h5>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <i class="bi bi-calendar-event-fill text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Event Period</p>
                                <h5 class="font-bold text-gray-800">
                                    {{ $competition->start_date ? \Carbon\Carbon::parse($competition->start_date)->format('M d, Y') : '-' }} - 
                                    {{ $competition->end_date ? \Carbon\Carbon::parse($competition->end_date)->format('M d, Y') : '-' }}
                                </h5>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                                <i class="bi bi-hourglass-split text-yellow-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Registration Deadline</p>
                                <h5 class="font-bold {{ now()->gt(\Carbon\Carbon::parse($competition->registration_deadline)) ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $competition->deadline ? \Carbon\Carbon::parse($competition->deadline)->format('M d, Y') : '-' }}
                                    <span class="ml-2 text-sm font-normal text-gray-500">
                                        {{ $competition->deadline ? now()->diffForHumans($competition->deadline) : '' }}
                                    </span>
                                </h5>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <i class="bi bi-people-fill text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Maximum Participants</p>
                                <h5 class="font-bold text-gray-800">
                                    {{ $competition->max_participants ? number_format($competition->max_participants) . ' participants' : 'Unlimited participants' }}
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border-l-4 border-indigo-500 p-6 rounded-lg my-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-3 flex items-center">
                            <i class="bi bi-info-circle text-indigo-600 mr-2"></i>
                            About This Competition
                        </h3>
                        <p class="text-gray-700">{{ $competition->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right sidebar (1/3 width on large screens) -->
        <div class="space-y-6">
            <!-- Registration card -->
            @if(Auth::user()->isStudent())
                @if($competition->participants->contains(Auth::id()))
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <i class="bi bi-check-circle-fill text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-blue-800 mb-2">You've Already Registered</h5>
                                <p class="text-blue-600">You've successfully registered for this competition.</p>
                            </div>
                        </div>
                    </div>
                @else
                    @if($competition->registration_link && $competition->status === 'open')
                        <div class="bg-white p-6 rounded-xl shadow-md text-center">
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                                    <i class="bi bi-person-plus-fill text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">Join this Competition</h3>
                                <p class="text-gray-500 text-sm">Registration deadline: {{ $competition->deadline ? $competition->deadline->format('M d, Y') : '-' }}</p>
                            </div>
                            
                            <a href="{{ $competition->registration_link }}" class="block w-full px-5 py-3 bg-green-600 text-white text-center font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-1 transition-all duration-150 ease-in-out mb-2" target="_blank">
                                <i class="bi bi-pencil-square mr-2"></i> Register Now
                            </a>
                            <span class="text-xs text-gray-500">You'll be redirected to the official competition site</span>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg shadow-sm">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-3">
                                    <i class="bi bi-exclamation-triangle-fill text-yellow-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-yellow-800 mb-1">Registration Unavailable</h5>
                                    <p class="text-yellow-700">This competition is currently not accepting registrations.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Competition organizer info -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h5 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-building text-indigo-600 mr-2"></i> Organizer Information
                    </h5>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mr-4">
                            {{ substr($competition->organizer->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="font-semibold text-gray-800 mb-1">{{ $competition->organizer->name }}</h6>
                            <p class="text-gray-500 text-sm">{{ $competition->organizer->email }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Key Dates Card -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h5 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-calendar2-event text-indigo-600 mr-2"></i> Key Dates
                    </h5>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <i class="bi bi-calendar-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-0.5">Registration Deadline</p>
                                <p class="font-semibold text-gray-800">{{ $competition->deadline ? $competition->deadline->format('M d, Y') : '-' }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <i class="bi bi-calendar-plus text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-0.5">Event Starts</p>
                                <p class="font-semibold text-gray-800">{{ $competition->start_date ? $competition->start_date->format('M d, Y') : '-' }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="bi bi-calendar-minus text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-0.5">Event Ends</p>
                                <p class="font-semibold text-gray-800">{{ $competition->end_date ? $competition->end_date->format('M d, Y') : '-' }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Find Team Members For Students -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 rounded-xl shadow-md text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Need Team Members?</h3>
                            <p class="text-indigo-100">Find potential teammates randomly to build a winning team quickly</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center px-5 py-3 bg-white text-indigo-600 font-medium rounded-lg hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-150 ease-in-out">
                                <i class="bi bi-people-fill mr-2 text-lg"></i> Find Team Members
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Manage Your Team For All Students -->
                <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6 rounded-xl shadow-md text-white">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Manage Your Team</h3>
                            <p class="text-green-100">Already have your own team? Invite specific members to join your team for this competition</p>
                        </div>
                        <form action="#" method="POST" class="flex flex-col sm:flex-row gap-4">
                            @csrf
                            <input type="email" name="email" placeholder="Enter team member's email" class="px-4 py-2 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <button type="submit" class="inline-flex items-center px-5 py-3 bg-white text-green-600 font-medium rounded-lg hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-150 ease-in-out">
                                <i class="bi bi-person-plus-fill mr-2 text-lg"></i> Invite Member
                            </button>
                        </form>
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
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
@endpush

@push('scripts')
<script>
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