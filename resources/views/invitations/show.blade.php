@extends('layouts.app')

@section('content')
<div class="container">

<a href="{{ route('invitations.index') }}"
   class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
    </svg>
    Back to Invitations
</a>


<h1 class="mb-4">
    Conversation with
    {{ Auth::id() === $invitation->sender_id
        ? $invitation->receiver->name
        : $invitation->sender->name }}
</h1>


<div class="mb-4 space-y-2">
    @foreach($invitation->messages as $message)
        @if($message->sender_id === Auth::id())
            {{-- Chat dari diri sendiri (kanan) --}}
            <div class="flex justify-end">
                <div class="bg-indigo-500 text-white px-4 py-2 rounded-lg max-w-xs text-right shadow">
                    <div class="text-sm">{{ $message->content }}</div>
                    <div class="text-xs text-gray-200 mt-1">{{ $message->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @else
            {{-- Chat dari lawan (kiri) --}}
            <div class="flex justify-start">
                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg max-w-xs shadow">
                    <div class="text-sm">{{ $message->content }}</div>
                    <div class="text-xs text-gray-600 mt-1">{{ $message->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @endif
    @endforeach
</div>


<form action="{{ route('messages.store') }}" method="POST" class="flex items-center gap-2 mt-4">
    @csrf
    <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

    <textarea name="content"
              class="flex-grow border rounded-xl p-2 resize-none h-12"
              placeholder="Type your message here..."
              required></textarea>

    <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full flex items-center justify-center h-12 w-12">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="w-5 h-5 rotate-180">
                <path d="M3.75 12l16.5-9-6.75 9 6.75 9-16.5-9z" />
            </svg>

    </button>
</form>

</div>
@endsection
