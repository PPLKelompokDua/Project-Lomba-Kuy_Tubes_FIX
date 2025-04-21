@extends('layouts.app')

@section('title', 'Available Competitions')

@section('content')
<!-- Hero section with gradient background -->
<div class="bg-gradient-to-r from-indigo-800 to-indigo-600 text-white rounded-xl overflow-hidden shadow-xl mb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-bold">Available Competitions</h1>
                    <p class="text-indigo-100 max-w-prose">Discover and join exciting competitions that match your interests and skills. Register before the deadline to secure your spot!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
        <div class="flex items-center">
            <i class="bi bi-check-circle-fill text-green-500 mr-2 text-lg"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm">
        <div class="flex items-center">
            <i class="bi bi-exclamation-circle-fill text-red-500 mr-2 text-lg"></i>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if(count($competitions) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($competitions as $competition)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 ease-in-out h-full flex flex-col">
            <div class="h-48 overflow-hidden relative">
                @if($competition->image)
                <img src="{{ asset('storage/' . $competition->image) }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" alt="{{ $competition->title }}">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-indigo-800 to-indigo-600">
                    <div class="text-center text-white p-6">
                        <i class="bi bi-image text-4xl mb-2"></i>
                        <h3 class="text-xl font-semibold">No Image Available</h3>
                    </div>
                </div>
                @endif
                
                <!-- Status badge -->
                <div class="absolute top-3 right-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500 text-white">
                        <i class="bi bi-unlock-fill mr-1"></i>
                        Open
                    </span>
                </div>
            </div>
            
            <div class="p-6 flex-grow">
                <h2 class="text-xl font-bold text-gray-800 mb-3 hover:text-indigo-600 transition-colors duration-200">{{ $competition->title }}</h2>
                
                <div class="space-y-3 mb-4">
                    <!-- Location -->
                    <div class="flex items-center text-gray-600">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                            <i class="bi bi-geo-alt-fill text-indigo-600"></i>
                        </div>
                        <span>{{ $competition->location }}</span>
                    </div>
                    
                    <!-- Event Period -->
                    <div class="flex items-center text-gray-600">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <i class="bi bi-calendar-event-fill text-green-600"></i>
                        </div>
                        <span>{{ $competition->start_date->format('M d, Y') }} - {{ $competition->end_date->format('M d, Y') }}</span>
                    </div>
                    
                    <!-- Registration Deadline -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ now()->gt($competition->registration_deadline) ? 'bg-red-100' : 'bg-yellow-100' }} flex items-center justify-center mr-3">
                            <i class="bi bi-hourglass-split {{ now()->gt($competition->registration_deadline) ? 'text-red-600' : 'text-yellow-600' }}"></i>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Registration deadline:</span>
                            <span class="ml-1 font-medium {{ now()->gt($competition->registration_deadline) ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $competition->registration_deadline->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <p class="text-gray-600 mt-4 mb-6">{{ Str::limit($competition->description, 120) }}</p>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('competitions.show', $competition->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
                        <i class="bi bi-info-circle mr-2"></i> View Details
                    </a>
                    @if($competition->external_registration_link)
                        <a href="{{ $competition->external_registration_link }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150 ease-in-out" target="_blank">
                            <i class="bi bi-pencil-square mr-2"></i> Register Now
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="flex justify-center mt-8">
        {{ $competitions->links() }}
    </div>
    @else
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm text-center my-12 max-w-3xl mx-auto">
        <div class="flex flex-col items-center">
            <div class="flex-shrink-0 mb-4">
                <i class="bi bi-calendar-x text-blue-500 text-4xl"></i>
            </div>
            <div class="flex flex-col items-center">
                <h3 class="text-xl font-bold text-blue-800 mb-2">No Open Competitions Available</h3>
                <p class="text-blue-600">Check back later for new competitions or contact organizers for more information.</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
