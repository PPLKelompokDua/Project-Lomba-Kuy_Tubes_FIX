@extends('layouts.admin')

@section('title', 'Article Management')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6" data-aos="fade-up">
        <h1 class="text-4xl font-bold text-indigo-600">Articles</h1>
        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Article
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow-sm" data-aos="fade-up" data-aos-delay="100">
            {{ session('success') }}
        </div>
    @endif

    <!-- Articles Table -->
    <div class="bg-white p-6 rounded-lg shadow hover-rise" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-xl font-bold mb-4 text-indigo-700">All Articles</h2>

        @if ($articles->count())
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm border">
                    <thead class="bg-indigo-100 text-left">
                        <tr>
                            <th class="p-3">Title</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr class="border-t hover:bg-gray-50" data-aos="fade-up" data-aos-delay="{{ 300 + $loop->index * 50 }}">
                                <td class="p-3">{{ $article->title }}</td>
                                <td class="p-3">{{ $article->category ?? '-' }}</td>
                                <td class="p-3 capitalize">{{ $article->status }}</td>
                                <td class="p-3 space-x-2">
                                    <!-- Detail -->
                                    <button type="button"
                                        class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 text-sm font-semibold transition toggle-details"
                                        data-target="details-{{ $article->id }}">
                                        <i class="fas fa-info-circle text-base align-middle"></i>
                                        Detail
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                        class="inline-flex items-center gap-1 text-yellow-600 hover:text-yellow-800 text-sm font-semibold transition">
                                        <i class="fas fa-pen text-base align-middle"></i>
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this article?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-sm font-semibold transition">
                                            <i class="fas fa-trash text-base align-middle"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Dropdown Details -->
                            <tr id="details-{{ $article->id }}" class="hidden bg-gray-50">
                                <td colspan="4" class="p-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="mb-2"><strong class="text-gray-800">Category:</strong> {{ $article->category ?? 'Not available' }}</p>
                                            <p class="mb-2"><strong class="text-gray-800">Status:</strong> <span class="capitalize">{{ $article->status }}</span></p>
                                            <p class="mb-2"><strong class="text-gray-800">Hashtags:</strong> {{ $article->hashtags ? implode(', ', $article->hashtags) : 'Not available' }}</p>
                                        </div>
                                        <div>
                                            <p class="mb-2"><strong class="text-gray-800">Created:</strong> {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</p>
                                            <p class="mb-2"><strong class="text-gray-800">Updated:</strong> {{ \Carbon\Carbon::parse($article->updated_at)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-2"><strong class="text-gray-800">Article Content:</strong></p>
                                        <div class="bg-gray-100 p-4 rounded-lg max-h-48 overflow-y-auto prose max-w-none">
                                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{!! nl2br(e($article->body)) !!}</p>
                                        </div>
                                    </div>
                                    @if ($article->thumbnail)
                                        <div class="mt-4">
                                            <p class="mb-2"><strong class="text-gray-800">Thumbnail:</strong></p>
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                 alt="Thumbnail {{ $article->title }}"
                                                 class="w-32 h-32 object-cover rounded-lg cursor-pointer shadow-md"
                                                 onclick="openPreviewModal('{{ asset('storage/' . $article->thumbnail) }}')">
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($articles->hasPages())
                <div class="mt-6 flex justify-center" data-aos="fade-up" data-aos-delay="250">
                    {{ $articles->links() }}
                </div>
            @endif
        @else
            <p class="text-gray-600" data-aos="fade-up" data-aos-delay="250">No articles available.</p>
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
    a, .toggle-details, button[type="submit"] {
        position: relative;
    }
    
    a::after, .toggle-details::after, button[type="submit"]::after {
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
    
    a:hover::after, .toggle-details:hover::after, button[type="submit"]:hover::after {
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