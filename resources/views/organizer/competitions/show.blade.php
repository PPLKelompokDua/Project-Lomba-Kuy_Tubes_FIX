@extends('layouts.organizer')

@section('title', 'Competition Details')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover-rise" data-aos="fade-up">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $competition->title }}</h2>
            <a href="{{ route('organizer.competitions.index') }}"
               class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold transition"
               data-aos="fade-left">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <!-- Competition Details -->
        <div class="space-y-6 mb-6" data-aos="fade-up" data-aos-delay="100">
            <!-- Metadata -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">Category:</strong> {{ $competition->category ?? 'Not specified' }}</p>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">Prize:</strong> {{ $competition->prize ?? 'Not specified' }}</p>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">Location:</strong> {{ $competition->location ?? 'Not specified' }}</p>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">Maximum Participants:</strong> {{ $competition->max_participants ?? 'Not specified' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">Deadline:</strong> {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</p>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">Start Date:</strong> {{ \Carbon\Carbon::parse($competition->start_date)->format('d M Y') }}</p>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">End Date:</strong> {{ \Carbon\Carbon::parse($competition->end_date)->format('d M Y') }}</p>
                    <p class="text-sm text-gray-600 mb-2"><strong class="text-gray-800">Registration Link:</strong> 
                        <a href="{{ $competition->registration_link }}" class="text-indigo-600 hover:underline" target="_blank">
                            {{ Str::limit($competition->registration_link, 30) }}
                        </a>
                    </p>
                </div>
            </div>
            <!-- Description -->
            <div class="bg-gray-50 p-4 rounded-lg max-h-96 overflow-y-auto">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $competition->description ?? 'No description available' }}</p>
            </div>
        </div>

        <!-- Poster Image -->
        <div class="mb-6 text-center" data-aos="fade-up" data-aos-delay="200">
            @if ($competition->photo)
                <img src="{{ asset('storage/' . $competition->photo) }}"
                     alt="Poster {{ $competition->title }}"
                     class="w-48 h-48 md:w-64 md:h-64 object-cover rounded-lg mx-auto cursor-pointer shadow-md"
                     onclick="openPreviewModal('{{ asset('storage/' . $competition->photo) }}')">
                <p class="text-sm text-gray-500 mt-2">Click the image to view full size</p>
            @else
                <div class="w-48 h-48 md:w-64 md:h-64 bg-gray-100 rounded-lg mx-auto flex items-center justify-center">
                    <p class="text-gray-500 text-sm">No poster available</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:justify-between items-center gap-4" data-aos="fade-up" data-aos-delay="250">
            <a href="{{ route('organizer.competitions.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg flex items-center transition min-w-[120px] action-button">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
            <div class="flex gap-3">
                <a href="{{ route('organizer.competitions.edit', $competition->id) }}"
                   class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg flex items-center transition min-w-[120px] shadow-md action-button">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('organizer.competitions.destroy', $competition->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this competition?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center transition min-w-[120px] shadow-md action-button">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* Card hover effects */
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    /* Button hover glow */
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
    
    /* Scrollbar for description */
    .max-h-96::-webkit-scrollbar {
        width: 8px;
    }
    
    .max-h-96::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .max-h-96::-webkit-scrollbar-thumb {
        background: #818cf8;
        border-radius: 4px;
    }
    
    .max-h-96::-webkit-scrollbar-thumb:hover {
        background: #4f46e5;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-5xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
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