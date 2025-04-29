@extends('layouts.app')

@section('title', 'My Competition')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <!-- Add Competition Button -->
  <div class="mb-6 flex justify-end">
    <a href="/competitions/form-experiance/" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
      </svg>
      Add Competition
    </a>
  </div>

  <!-- Competition List -->
  <div class="space-y-6">
    @foreach ($data as $item)
    <div class="bg-white shadow rounded-lg overflow-hidden transition-all duration-200 hover:shadow-lg">
      <div class="p-6">
        <div class="flex items-start space-x-4">
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
              <p class="text-sm font-medium text-gray-900">{{ $item->user->name }}</p>
              <span class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</span>
            </div>
            <h3 class="mt-1 text-lg font-semibold text-gray-900">{{ $item->title }}</h3>
            <p class="mt-2 text-gray-600">{{ $item->description }}</p>
            
            <!-- Comment Toggle Button -->
            <div class="mt-4">
              <button onclick="toggleComments('{{ $item->id }}')" class="flex items-center text-indigo-600 hover:text-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>Comments ({{ $item->comments->count() }})</span>
              </button>
            </div>
            
            <!-- Comments Section (Hidden by default) -->
            <div id="comments-{{ $item->id }}" class="mt-4 hidden">
              <div class="border-t border-gray-200 pt-4">
                <!-- Comment Form -->
                <form action="/competitions/comment-experiance/{{ $item->id }}" method="POST" class="mb-4">
                  @csrf
                  @method('POST')
                  <div class="flex space-x-2">
                    <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}" alt="User avatar">
                    <div class="flex-1">
                      <input type="text" name="comment" placeholder="Add a comment..." required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded-full hover:bg-indigo-700">
                      Post
                    </button>
                  </div>
                </form>
                
                <!-- Comment List -->
                <div class="space-y-3">
                  @forelse ($item->comments as $comment)
                  <div class="flex space-x-2">
                    <img class="h-8 w-8 rounded-full" src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="User avatar">
                    <div class="flex-1 bg-gray-50 p-3 rounded-lg">
                      <div class="flex justify-between items-start">
                        <span class="text-sm font-medium">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                      </div>
                      <p class="text-sm mt-1">{{ $comment->comment }}</p>
                    </div>
                  </div>
                  @empty
                  <p class="text-sm text-gray-500 text-center py-2">No comments yet</p>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<script>
  function toggleComments(competitionId) {
    const commentsSection = document.getElementById(`comments-${competitionId}`);
    commentsSection.classList.toggle('hidden');
  }
</script>
@endsection