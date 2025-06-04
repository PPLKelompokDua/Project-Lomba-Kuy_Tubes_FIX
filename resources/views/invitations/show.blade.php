@extends('layouts.app')

@section('title', 'Room Chat')

@section('content')
<div class="container mx-auto max-w-5xl px-4 py-6">
    <!-- Back button with animation -->
    <a href="{{ route('invitations.index' , ['team_id' => $invitation->team_id]) }}"
       class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-800 mb-6 transition-all duration-200 hover:translate-x-[-3px]">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="2" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
        Back to Invitations
    </a>

    <!-- Chat header with better styling -->
    <div class="flex items-center mb-6 bg-white rounded-lg shadow-sm p-4 border border-gray-100">
        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-lg">
            {{ substr(Auth::id() === $invitation->sender_id ? $invitation->receiver->name : $invitation->sender->name, 0, 1) }}
        </div>
        <div class="ml-3">
            <h1 class="text-xl font-semibold text-gray-800">
                Conversation with
                {{ Auth::id() === $invitation->sender_id
                    ? $invitation->receiver->name
                    : $invitation->sender->name }}
            </h1>
            <p class="text-sm text-gray-500">{{ $invitation->created_at->format('F j, Y') }}</p>
        </div>
    </div>

    <!-- Message container with improved styling -->
    <div class="mb-6 space-y-3 max-h-[60vh] overflow-y-auto p-2" id="message-container">
        @foreach($invitation->messages as $message)
            @if($message->sender_id === Auth::id())
                <!-- Self messages (right side) -->
                <div class="flex justify-end">
                    <div class="bg-indigo-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm max-w-sm md:max-w-lg text-right shadow-md">
                        <div class="text-sm">{{ $message->content }}</div>
                        <div class="text-xs text-indigo-200 mt-1 flex justify-end items-center">
                            {{ $message->created_at->diffForHumans() }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            @else
                <!-- Received messages (left side) -->
                <div class="flex justify-start">
                    <div class="bg-white text-gray-800 px-4 py-3 rounded-2xl rounded-tl-sm max-w-sm md:max-w-lg shadow-md border border-gray-100">
                        <div class="text-sm">{{ $message->content }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $message->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Message input form with enhanced styling -->
    <form action="{{ route('messages.store') }}" method="POST" class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 flex items-center gap-3">
        @csrf
        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

        <textarea name="content"
                  class="flex-grow bg-gray-50 border-none rounded-xl p-3 resize-none focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-gray-400 text-sm"
                  dusk="message-input"
                  placeholder="Type your message here..."
                  rows="1"
                  required></textarea>

        <button type="submit"
                dusk="send-message-button"
                class="bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-xl flex items-center justify-center h-12 w-12 transition-all duration-200 hover:scale-105 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" 
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5">
                    <path d="M6 12L3 21l10.5-7L3 3l3 9z" />
                    <path d="M6 12h15" />
                </svg>
        </button>
    </form>
</div>

<script>
    // Auto-scroll to bottom of messages when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const messageContainer = document.getElementById('message-container');
        messageContainer.scrollTop = messageContainer.scrollHeight;
        
        // Auto-resize textarea as user types
        const textarea = document.querySelector('textarea[name="content"]');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight < 120) ? this.scrollHeight + 'px' : '120px';
        });
    });
</script>
@endsection