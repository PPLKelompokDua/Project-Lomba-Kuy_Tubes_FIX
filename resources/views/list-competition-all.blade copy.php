@extends('layouts.app')

@section('title', 'My Competition')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <!-- Add Competition Button -->
  <div class="mb-6 flex justify-end">
    <a href="" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
      </svg>
      Add Competition
    </a>
  </div>

  <!-- Competition List -->
  <div class="space-y-6">
    <!-- Competition Card 1 -->
  @foreach ($data as $item)
    

    <div class="bg-white shadow rounded-lg overflow-hidden transition-all duration-200 hover:shadow-lg">
      <div class="p-6">
        <div class="flex items-start space-x-4">
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
              <p class="text-sm font-medium text-gray-900">{{$item->user->name}}</p>
              <span class="text-xs text-gray-500">{{$item->created_at->diffForHumans()}}</span>
            </div>
            <h3 class="mt-1 text-lg font-semibold text-gray-900">{{$item->title}}</h3>
            <p class="mt-2 text-gray-600">{{$item->description}}</p>
            
            <!-- Action Buttons -->
            <div class="mt-4 flex space-x-4">
              <a class="flex items-center text-gray-500 hover:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>24</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    @endforeach
  </div>
</div>
@endsection