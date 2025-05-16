@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-6 text-indigo-600" data-aos="fade-up">Welcome, Admin!</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10" data-aos="fade-up" data-aos-delay="100">
        <div class="bg-white p-6 rounded-lg shadow hover-rise">
            <h2 class="text-lg font-semibold mb-2 text-gray-800">Total Users</h2>
            <p class="text-3xl font-bold text-indigo-700">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover-rise">
            <h2 class="text-lg font-semibold mb-2 text-gray-800">Total Competitions</h2>
            <p class="text-3xl font-bold text-indigo-700">{{ $totalCompetitions }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover-rise">
            <h2 class="text-lg font-semibold mb-2 text-gray-800">Active Organizers</h2>
            <p class="text-3xl font-bold text-indigo-700">{{ $totalOrganizers }}</p>
        </div>
    </div>

    <!-- Competitions Table -->
    <div class="bg-white p-6 rounded-lg shadow hover-rise" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-xl font-bold mb-4 text-indigo-700">All Competitions</h2>

        @if ($competitions->count())
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm border">
                    <thead class="bg-indigo-100 text-left">
                        <tr>
                            <th class="p-3">Title</th>
                            <th class="p-3">Organizer</th>
                            <th class="p-3">Deadline</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competitions as $competition)
                            <tr class="border-t hover:bg-gray-50" data-aos="fade-up" data-aos-delay="{{ 300 + $loop->index * 50 }}">
                                <td class="p-3">{{ $competition->title }}</td>
                                <td class="p-3">{{ $competition->organizer->name ?? '-' }}</td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</td>
                                <td class="p-3 space-x-2">
                                    <button type="button" class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold transition toggle-details" data-target="details-{{ $competition->id }}">
                                        <i class="fas fa-info-circle mr-1"></i> Detail
                                    </button>
                                    <form action="{{ route('organizer.competitions.destroy', $competition->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 flex items-center text-sm font-semibold transition" type="submit">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Dropdown Details -->
                            <tr id="details-{{ $competition->id }}" class="hidden bg-gray-50">
                                <td colspan="4" class="p-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="mb-2"><strong class="text-gray-800">Category:</strong> {{ $competition->category ?? 'Not available' }}</p>
                                            <p class="mb-2"><strong class="text-gray-800">Prize:</strong> {{ $competition->prize ?? 'Not available' }}</p>
                                            <p class="mb-2"><strong class="text-gray-800">Location:</strong> {{ $competition->location ?? 'Not available' }}</p>
                                            <p class="mb-2"><strong class="text-gray-800">Maximum Participants:</strong> {{ $competition->max_participants ?? 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <p class="mb-2"><strong class="text-gray-800">Start Date:</strong> {{ \Carbon\Carbon::parse($competition->start_date)->format('d M Y') }}</p>
                                            <p class="mb-2"><strong class="text-gray-800">End Date:</strong> {{ \Carbon\Carbon::parse($competition->end_date)->format('d M Y') }}</p>
                                            <p class="mb-2"><strong class="text-gray-800">Registration Link:</strong> 
                                                <a href="{{ $competition->registration_link }}" class="text-indigo-600 hover:underline" target="_blank">
                                                    {{ Str::limit($competition->registration_link, 30) }}
                                                </a>
                                            </p>
                                            <p class="mb-2"><strong class="text-gray-800">External Registration Link:</strong> 
                                                @if ($competition->external_registration_link)
                                                    <a href="{{ $competition->external_registration_link }}" class="text-indigo-600 hover:underline" target="_blank">
                                                        {{ Str::limit($competition->external_registration_link, 30) }}
                                                    </a>
                                                @else
                                                    Not available
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-2"><strong class="text-gray-800">Description:</strong></p>
                                        <div class="bg-gray-100 p-4 rounded-lg max-h-48 overflow-y-auto">
                                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $competition->description ?? 'No description available' }}</p>
                                        </div>
                                    </div>
                                    @if ($competition->photo)
                                        <div class="mt-4">
                                            <p class="mb-2"><strong class="text-gray-800">Poster:</strong></p>
                                            <img src="{{ asset('storage/' . $competition->photo) }}"
                                                 alt="Poster {{ $competition->title }}"
                                                 class="w-32 h-32 object-cover rounded-lg cursor-pointer shadow-md"
                                                 onclick="openPreviewModal('{{ asset('storage/' . $competition->photo) }}')">
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($competitions->hasPages())
                <div class="mt-6 flex justify-center" data-aos="fade-up" data-aos-delay="250">
                    {{ $competitions->links() }}
                </div>
            @endif
        @else
            <p class="text-gray-600" data-aos="fade-up" data-aos-delay="250">No competitions available.</p>
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
    .toggle-details, button[type="submit"] {
        position: relative;
    }
    
    .toggle-details::after, button[type="submit"]::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        z-index: -1;
        border-radius: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .toggle-details:hover::after, button[type="submit"]:hover::after {
        opacity: 0.5;
    }
    
    /* Scrollbar for description */
    .max-h-48::-webkit-scrollbar {
        width: 8px;
    }
    
    .max-h-48::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .max-h-48::-webkit-scrollbar-thumb {
        background: #818cf8;
        border-radius: 4px;
    }
    
    .max-h-48::-webkit-scrollbar-thumb:hover {
        background: #4f46e5;
    }
    
    /* Pagination styling */
    .pagination {
        margin-top: 1rem;
    }

    .pagination .page-item .page-link {
        padding: 0.5rem 1rem;
        color: #4F46E5; /* Indigo-600 */
        background-color: white;
        border: 1px solid #E5E7EB; /* gray-200 */
        border-radius: 0.375rem;
        margin: 0 0.25rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #6366F1; /* Indigo-500 */
        color: white;
        border-color: #6366F1;
    }

    .pagination .page-item.disabled .page-link {
        color: #9CA3AF; /* gray-400 */
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-7xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing toggle-details');
        
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
        });

        // Toggle Details Dropdown
        const toggleButtons = document.querySelectorAll('.toggle-details');
        console.log('Found toggle buttons:', toggleButtons.length);
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                console.log('Toggling details for:', targetId);
                
                const detailsRow = document.getElementById(targetId);
                const isHidden = detailsRow.classList.contains('hidden');
                
                // Hide all other details rows
                document.querySelectorAll('tr[id^="details-"]').forEach(row => {
                    if (row.id !== targetId) {
                        row.classList.add('hidden');
                    }
                });
                
                // Toggle the clicked row
                detailsRow.classList.toggle('hidden');
                
                // Update button text/icon
                if (isHidden) {
                    this.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Close';
                } else {
                    this.innerHTML = '<i class="fas fa-info-circle mr-1"></i> Detail';
                }
            });
        });
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