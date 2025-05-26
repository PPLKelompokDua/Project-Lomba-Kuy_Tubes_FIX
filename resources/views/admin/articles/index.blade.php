@extends('layouts.admin')

@section('title', 'Article Management')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6" data-aos="fade-up">
        <h1 class="text-3xl font-bold text-indigo-600">Articles</h1>
        <a href="{{ route('admin.articles.create') }}" dusk="add-article" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            Add New Article
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" data-aos="fade-up" data-aos-delay="100">
            {{ session('success') }}
        </div>
    @endif

    <!-- Articles Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($articles as $article)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-16 bg-gray-200 rounded">
                                    @if($article->thumbnail)
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                             alt="{{ $article->title }}"
                                             class="h-10 w-16 object-cover rounded cursor-pointer"
                                             onclick="openPreviewModal('{{ asset('storage/' . $article->thumbnail) }}')">
                                    @else
                                        <div class="h-10 w-16 flex items-center justify-center bg-gray-200 text-gray-500 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                {{ $article->category ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($article->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Detail Button -->
                                <button type="button"
                                    class="text-blue-600 hover:text-blue-900 toggle-details" dusk="view-article-{{ $article->id }}"
                                    data-target="details-{{ $article->id }}"
                                    title="View Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <!-- Edit Button -->
                                <a href="{{ route('admin.articles.edit', $article) }}"
                                   class="text-indigo-600 hover:text-indigo-900" dusk="edit-article-{{ $article->id }}"
                                   title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('admin.articles.destroy', $article) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this article?')"
                                      dusk="delete-article-{{ $article->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <!-- Dropdown Details -->
                    <tr id="details-{{ $article->id }}" class="hidden bg-gray-50">
                        <td colspan="4" class="px-6 py-4">
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
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <p class="text-lg font-medium">No articles found</p>
                            <p class="mt-1">Click "Add New Article" to create your first article.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($articles->hasPages())
        <div class="mt-6 flex justify-center" data-aos="fade-up" data-aos-delay="250">
            {{ $articles->links('vendor.pagination.custom') }}
        </div>
    @endif
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
            
            // Update button icon
            if (isHidden) {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>`;
            } else {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>`;
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