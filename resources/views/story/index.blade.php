@extends('layouts.app')

@section('title', 'Story & Achievements Space')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12 mb-8 rounded-[10px]">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Story & Achievements Space</h1>
                <p class="text-xl text-indigo-100 max-w-2xl mx-auto">Share your competition experiences and inspiring achievements with the community</p>
                <div class="mt-8">
                    <button onclick="openCreateModal()" class="bg-white text-indigo-700 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full shadow-lg transform transition duration-200 hover:scale-105 flex items-center mx-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Share Your Story
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Flash Message with animation -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow mb-6 animate-pulse">
                <div class="flex">
                    <div class="py-1">
                        <svg class="h-6 w-6 text-green-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Mobile Create Button (visible on small screens) -->
        <div class="md:hidden flex justify-end mb-6">
            <button onclick="openCreateModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Post
            </button>
        </div>

        <!-- 3-Column Post Grid or No Data Message -->
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 flex flex-col h-full">
                        <!-- User Info -->
                        <div class="flex items-center p-4 border-b border-gray-50">
                            <img src="{{ $post->user->profile_image ? asset('storage/images/' . $post->user->profile_image) : 'https://via.placeholder.com/40' }}" 
                                 class="w-10 h-10 rounded-full mr-3 border-2 border-indigo-100 object-cover">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                                <p class="text-xs text-gray-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            @if(auth()->id() == $post->user_id)
                            <div class="relative ml-auto">
                                <button onclick="toggleDropdown({{ $post->id }})" class="text-gray-500 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-lg shadow-lg z-10 border border-gray-100 overflow-hidden">
                                    <a href="javascript:void(0)" onclick="openEditModal({{ $post->id }}, '{{ addslashes($post->caption) }}')" 
                                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left block px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Image (if exists) -->
                        @if($post->media)
                            <div class="relative overflow-hidden" style="max-height: 200px;">
                                <img src="{{ asset('storage/' . $post->media) }}" class="w-full h-full object-cover hover:opacity-95 transition-opacity duration-300">
                            </div>
                        @endif

                        <!-- Caption -->
                        <div class="p-4 flex-grow">
                            <p class="text-gray-700 leading-relaxed text-sm line-clamp-3">{{ $post->caption }}</p>
                            @if(strlen($post->caption) > 150)
                                <button class="text-indigo-600 hover:text-indigo-800 text-sm mt-2" onclick="openDetailModal({{ $post->id }}, '{{ addslashes($post->caption) }}', '{{ $post->media ? asset('storage/' . $post->media) : '' }}')">
                                    Read More
                                </button>
                            @endif
                        </div>

                        <!-- Engagement Section -->
                        <div class="border-t border-gray-50 px-4 py-3 bg-gray-50 rounded-b-xl">
                            <div class="flex items-center">
                                <form method="POST" action="{{ $post->isLikedBy(auth()->user()) ? route('posts.unlike', $post->id) : route('posts.like', $post->id) }}" class="flex-grow">
                                    @csrf
                                    @if($post->isLikedBy(auth()->user()))
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center text-red-500 hover:text-red-700 font-medium transition">
                                            <svg class="w-5 h-5 mr-1 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                            <span>{{ $post->likes->count() }}</span>
                                        </button>
                                    @else
                                        <button type="submit" class="flex items-center text-gray-500 hover:text-red-500 font-medium transition">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span>{{ $post->likes->count() }}</span>
                                        </button>
                                    @endif
                                </form>

                                <button onclick="openCommentModal({{ $post->id }})" class="flex items-center text-indigo-500 hover:text-indigo-700 font-medium transition">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span>{{ $post->comments->count() }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                <div class="flex justify-center">
                    {{ $posts->links('vendor.pagination.custom') }}
                </div>
            </div>
        @else
            <!-- No Data Message -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-9 3h18a2 2 0 002-2V6a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">No Stories Yet</h3>
                <p class="text-gray-600 mb-6">It looks like there are no stories or achievements shared yet. Be the first to share your experience!</p>
                <button onclick="openCreateModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg shadow-md transition flex items-center mx-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Share Your Story
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Post Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-3xl mx-4 relative animate__animated animate__fadeInUp">
        <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <div class="flex flex-col md:flex-row">
            <div id="detailImageContainer" class="w-full md:w-1/2 bg-gray-100 rounded-l-xl flex items-center justify-center hidden">
                <img id="detailImage" src="" class="w-full h-full object-cover rounded-l-xl" alt="Post image">
            </div>
            <div class="p-6 w-full md:w-1/2">
                <h3 class="text-xl font-bold text-indigo-800 mb-4">Post Details</h3>
                <p id="detailCaption" class="text-gray-700 whitespace-pre-line"></p>
            </div>
        </div>
    </div>
</div>

<!-- Create Post Modal -->
<div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
    <div class="bg-white p-8 rounded-xl w-full max-w-lg mx-4 relative animate__animated animate__fadeInUp">
        <h2 class="text-2xl font-bold mb-6 text-indigo-800 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Create New Post
        </h2>
        
        <button onclick="closeCreateModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="caption" class="block text-sm font-medium text-gray-700 mb-2">Share Your Experience</label>
                <textarea name="caption" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                       placeholder="Share your achievement story or experience..." required></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Add Media</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition cursor-pointer">
                    <input type="file" name="media" accept="image/*,video/*" class="hidden" id="mediaInput">
                    <label for="mediaInput" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-1 text-sm text-gray-600">Click to select a photo or video</p>
                        <p class="mt-1 text-xs text-gray-400">Supported formats: JPG, PNG, MP4</p>
                    </label>
                </div>
                <div id="mediaPreview" class="mt-3 hidden">
                    <img id="imagePreview" class="rounded-lg max-h-40 mx-auto" src="" alt="Preview">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Post
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Post Modal -->
<div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
    <div class="bg-white p-8 rounded-xl w-full max-w-lg mx-4 relative animate__animated animate__fadeInUp">
        <h2 class="text-2xl font-bold mb-6 text-indigo-800 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Post
        </h2>
        
        <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <form method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="editCaption" class="block text-sm font-medium text-gray-700 mb-2">Edit Your Story</label>
                <textarea name="caption" id="editCaption" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Change Media (optional)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition cursor-pointer">
                    <input type="file" name="media" accept="image/*,video/*" class="hidden" id="editMediaInput">
                    <label for="editMediaInput" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-1 text-sm text-gray-600">Click to change photo or video</p>
                        <p class="mt-1 text-xs text-gray-400">Leave empty if you don't want to change</p>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Comment Modal -->
<div id="commentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
    <div class="bg-white p-6 rounded-xl w-full max-w-lg mx-4 relative animate__animated animate__fadeInUp">
        <h2 class="text-2xl font-bold mb-4 text-indigo-800 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            Comments
        </h2>
        
        <button onclick="closeCommentModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <div id="commentListContainer" class="max-h-80 overflow-y-auto mb-4 pr-2">
            <div id="commentList" class="space-y-3">
                <!-- Comments loaded via AJAX -->
                <div class="flex items-center justify-center py-6 text-gray-400">
                    <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <form id="commentForm" method="POST" class="border-t border-gray-100 pt-4">
            @csrf
            <div class="flex items-center">
                <input type="text" name="content" id="commentContent" class="w-full border border-gray-300 rounded-l-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Write your comment..." required>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    function openEditModal(postId, caption) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editCaption').value = caption;
        document.getElementById('editForm').action = '/posts/' + postId;
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    let currentPostId = null;

    function openCommentModal(postId) {
        document.getElementById('commentModal').classList.remove('hidden');
        currentPostId = postId;
        
        // SET ACTION FORM DYNAMIC
        document.getElementById('commentForm').action = `/posts/${postId}/comments`;

        loadComments();
    }

    function closeCommentModal() {
        document.getElementById('commentModal').classList.add('hidden');
        document.getElementById('commentList').innerHTML = '';
    }

    function toggleDropdown(postId) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(drop => drop.classList.add('hidden'));
        document.getElementById(`dropdown-${postId}`).classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(drop => drop.classList.add('hidden'));
        }
    });

    async function loadComments() {
        const res = await fetch(`/stories/${currentPostId}/comments`);
        const comments = await res.json();
        const commentList = document.getElementById('commentList');
        commentList.innerHTML = '';

        comments.forEach(c => {
            const div = document.createElement('div');
            div.className = 'p-3 border rounded-lg';
            div.innerHTML = `<p class="font-semibold">${c.user_name}</p><p class="text-gray-700">${c.comment}</p>`;
            commentList.appendChild(div);
        });
    }

    document.getElementById('commentForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const content = document.getElementById('commentContent').value;
        const action = this.action;
        const token = '{{ csrf_token() }}';

        await fetch(action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ content: content })
        });

        document.getElementById('commentContent').value = '';
        loadComments();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
            closeCommentModal();
        }
    });
</script>
@endpush