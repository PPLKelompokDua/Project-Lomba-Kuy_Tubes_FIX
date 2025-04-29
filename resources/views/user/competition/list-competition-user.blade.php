

@extends('layouts.app')

@section('title', 'My Competition')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @session('success')
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
      </div>
    @endsession

    @session('error')
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
      </div>
      @endSession

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
    <!-- Competition Card 1 -->
    <div class="bg-white shadow rounded-lg overflow-hidden transition-all duration-200 hover:shadow-lg">
      <div class="p-6">
        <div class="flex items-start space-x-4">
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
              <p class="text-sm font-medium text-gray-900">{{Auth::user()->name}}</p>
              <span class="text-xs text-gray-500">{{$item->created_at->diffForHumans()}}</span>
            </div>
            <h3 class="mt-1 text-lg font-semibold text-gray-900">{{$item->title}}</h3>
            <p class="mt-2 text-gray-600">{{$item->description}}</p>
            
            <!-- Action Buttons -->
            <div class="mt-4 flex space-x-4">
              <a href="/competitions/form-experiance/{{$item->id}}" class="flex items-center px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
              </a>
              <form action="/competitions/form-experiance/{{$item->id}}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition" onclick="return confirm('Are you sure you want to delete this competition?')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Delete
                </button>
              </form>
              {{-- <a href="#" class="flex items-center px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Show Comments
              </a> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
            
    @endforeach


  </div>
</div>
@endsection