@extends('layouts.app')

@section('title', 'Story & Prestasi Space')

@section('content')
<div class="container mx-auto py-10 px-4">
    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    <!-- Create Post Button -->
    <div class="flex justify-end mb-6">
        <button onclick="openCreateModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
            + Buat Postingan
        </button>
    </div>

    <!-- Post List -->
    <div class="space-y-8">
        @foreach($posts as $post)
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                <!-- User Info -->
                <div class="flex items-center mb-4">
                    <img src="{{ $post->user->profile_image ? asset('storage/images/' . $post->user->profile_image) : 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                    @if(auth()->id() == $post->user_id)
                        <div class="ml-auto">
                            <button onclick="openEditModal({{ $post->id }}, '{{ addslashes($post->caption) }}')" class="text-indigo-500 hover:text-indigo-700 text-sm">
                                Edit
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Caption -->
                <p class="text-gray-700 mb-4">{{ $post->caption }}</p>

                <!-- Image -->
                @if($post->media)
                    <img src="{{ asset('storage/' . $post->media) }}" class="rounded-lg mb-4 w-full">
                @endif

                <!-- Comment Button -->
                <button onclick="openCommentModal({{ $post->id }})" class="text-indigo-500 hover:text-indigo-700 text-sm">
                    💬 {{ $post->comments->count() }} Komentar
                </button>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>

<!-- Create Post Modal -->
<div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg relative">
        <h2 class="text-2xl font-bold mb-4">Buat Postingan</h2>
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <textarea name="caption" rows="4" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Tulis captionmu..." required></textarea>
            </div>
            <div class="mb-4">
                <input type="file" name="media" accept="image/*,video/*" class="w-full">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeCreateModal()" class="mr-2 text-gray-600 hover:text-gray-800">Batal</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">Post</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Post Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg relative">
        <h2 class="text-2xl font-bold mb-4">Edit Postingan</h2>
        <form method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <textarea name="caption" id="editCaption" rows="4" class="w-full border border-gray-300 rounded-lg p-2" required></textarea>
            </div>
            <div class="mb-4">
                <input type="file" name="media" accept="image/*,video/*" class="w-full">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeEditModal()" class="mr-2 text-gray-600 hover:text-gray-800">Batal</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Comment Modal -->
<div id="commentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg relative">
        <h2 class="text-2xl font-bold mb-4">Komentar</h2>
        <div id="commentList" class="space-y-4 mb-6">
            <!-- Komentar diisi via AJAX -->
        </div>
        <form method="POST" action="{{ route('comments.store', $post->id) }}">
            @csrf
            <div class="flex items-center">
                <input type="text" name="content" id="commentContent" class="w-full border border-gray-300 rounded-l-lg p-2" placeholder="Tulis komentar..." required>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg">Kirim</button>
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
        loadComments();
    }

    function closeCommentModal() {
        document.getElementById('commentModal').classList.add('hidden');
        document.getElementById('commentList').innerHTML = '';
    }

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

        await fetch(`/stories/${currentPostId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ comment: content })
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
