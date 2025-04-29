@extends('layouts.app')

@section('title', 'My Team')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
  <!-- Header and Create Button -->
  <div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-gray-800">My Teams</h1>
    {{-- <a href="" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
      </svg>
      Create Team
    </a> --}}
  </div>

  <!-- Team List -->
  <div class="space-y-6">
    @forelse($data as $team)
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
      <div class="p-6">
        <!-- Team Header -->
        <div class="flex justify-between items-start">
          <div>
            <h2 class="text-xl font-semibold text-gray-800">{{ $team->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Created {{ $team->created_at->diffForHumans() }}</p>
          </div>
        </div>

        <!-- Feedback Section -->
        <div class="mt-6">
          <!-- Feedback Toggle -->
          <button onclick="toggleFeedback('{{ $team->id }}')" class="flex items-center text-indigo-600 hover:text-indigo-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <span>Feedback ({{ $team->feedback->count() }})</span>
          </button>

          <!-- Feedback Content (Hidden by default) -->
     <div id="feedback-{{ $team->id }}" class="mt-4 hidden">
            <!-- Feedback Form -->
            <form action="/tim/list-my-tim/feedback" method="POST" class="mb-6">
              @csrf
              @method('POST')
              <input type="hidden" name="tim_id" value="{{ $team->id }}">
              <div class="flex space-x-3">
                <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}" alt="Your avatar">
                <div class="flex-1">
                  <textarea name="feedback" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Write your feedback..." required></textarea>
                  <div class="mt-2 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Submit Feedback</button>
                  </div>
                </div>
              </div>
            </form>

            <!-- Feedback List -->
            <div class="space-y-4">
              @forelse($team->feedback as $feedback)
              <div class="flex space-x-3 group" id="feedback-item-{{ $feedback->id }}">
                <img class="h-10 w-10 rounded-full flex-shrink-0" src="{{ $feedback->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($feedback->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="User avatar">
                <div class="bg-gray-50 p-4 rounded-lg flex-1 relative">
                  <!-- Edit/Delete Buttons (visible on hover) -->
                  @if(auth()->id() == $feedback->user_id)
                  <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-2">
                    <!-- Edit Button -->
                    <button onclick="enableEdit('{{ $feedback->id }}')" class="text-gray-500 hover:text-indigo-600">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>
                    
                    <!-- Delete Button -->
                    <form action="/tim/list-my-tim/feedback/{{$feedback->id}}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <input type="hidden" name="tim_id" value="{{ $team->id }}">
                      <button type="submit" class="text-gray-500 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this feedback?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </form>
                  </div>
                  @endif
                  
                  <!-- Feedback Content Display -->
                  <div class="flex justify-between items-start">
                    <h4 class="font-medium text-gray-800">{{ $feedback->user->name }}</h4>
                    <span class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</span>
                  </div>
                  
                  <!-- Normal View -->
                  <div id="feedback-content-{{ $feedback->id }}">
                    <p class="mt-1 text-gray-700">{{ $feedback->feedback }}</p>
                  </div>
                  
                  <!-- Edit Form (Hidden by default) -->
                  <div id="feedback-edit-form-{{ $feedback->id }}" class="hidden mt-2">
                    <form action="/tim/list-my-tim/feedback/{{$feedback->id}}" method="POST">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="tim_id" value="{{ $team->id }}">
                      <textarea name="feedback" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ $feedback->content }}</textarea>
                      <div class="mt-2 flex justify-end space-x-2">
                        <button type="button" onclick="cancelEdit('{{ $feedback->id }}')" class="px-3 py-1 text-gray-600 hover:text-gray-800">Cancel</button>
                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @empty
              <p class="text-center text-gray-500 py-4">No feedback yet</p>
              @endforelse
            </div>
          </div> 
        </div>
      </div>
    </div>
    @empty
      <h3 class="mt-4 text-lg font-medium text-gray-900">No teams yet</h3>
    @endforelse
  </div>
</div>

<script>
  function toggleFeedback(teamId) {
    const feedbackSection = document.getElementById(`feedback-${teamId}`);
    feedbackSection.classList.toggle('hidden');
  }

  function enableEdit(feedbackId) {
    // Hide the content display
    document.getElementById(`feedback-content-${feedbackId}`).classList.add('hidden');
    // Show the edit form
    document.getElementById(`feedback-edit-form-${feedbackId}`).classList.remove('hidden');
  }

  function cancelEdit(feedbackId) {
    // Show the content display
    document.getElementById(`feedback-content-${feedbackId}`).classList.remove('hidden');
    // Hide the edit form
    document.getElementById(`feedback-edit-form-${feedbackId}`).classList.add('hidden');
  }
</script>
@endsection