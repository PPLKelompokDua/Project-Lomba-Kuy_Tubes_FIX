@extends('layouts.app')

@section('title', 'Create New Competition')

@section('content')
<div class="max-w-4xl mx-auto">
  <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header Form -->
    <div class="bg-indigo-600 px-6 py-4">
      <h2 class="text-2xl font-bold text-white">Create New Experiance Competition</h2>
      <p class="text-indigo-100">Fill the form below to create a new experiance competition</p>
    </div>

    <!-- Form Content -->
    <form action="{{isset($id) ? '/competitions/form-experiance/'.$id : '/competitions/form-experiance/'}}" method="POST" class="p-6">
      @csrf
      @if(isset($id))
         @method('PUT')
      @else
         @method('POST')
      @endif
      
      <!-- Title Field -->
      <div class="mb-6">
        <label for="title" class="block text-gray-700 font-medium mb-2">Competition Title</label>
        <input 
          type="text" 
          id="title" 
          name="title" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
          placeholder="Enter competition title"
          value="{{ isset($id) ? old('title',$data->title) : old('title') }}"
          required
        >
        @error('title')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Description Field -->
      <div class="mb-8">
        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
        <textarea 
          id="description" 
          name="description" 
          rows="6"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
          placeholder="Describe your competition in detail..."
          required
        >{{ isset($id) ? old('description',$data->description) : old('description') }}</textarea>
        @error('description')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Form Actions -->
      <div class="flex items-center justify-end space-x-4">
        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">Cancel</a>
        <button 
          type="submit" 
          class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
        >
        @if(isset($id))
        Update Competition
        @else
        Create Competition
        @endif
        </button>
      </div>
    </form>
  </div>
</div>
@endsection