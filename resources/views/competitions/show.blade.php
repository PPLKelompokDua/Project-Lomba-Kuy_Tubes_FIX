@extends('layouts.app')

@section('title', $competition->title)

@section('content')

<!-- Hero section with gradient background -->
<div class="bg-gradient-to-r from-indigo-800 to-indigo-600 text-white rounded-xl overflow-hidden shadow-xl mb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col space-y-4">
            <a href="{{ route('competitions.index') }}" class="inline-flex items-center text-indigo-100 hover:text-white transition duration-150 ease-in-out group w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-150 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to competitions
            </a>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-bold">{{ $competition->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $competition->status === 'open' ? 'bg-green-500 text-white' : ($competition->status === 'closed' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-800') }}">
                            <i class="bi {{ $competition->status === 'open' ? 'bi-unlock-fill' : ($competition->status === 'closed' ? 'bi-lock-fill' : 'bi-check-circle-fill') }} mr-1"></i>
                            {{ ucfirst($competition->status) }}
                        </span>
                        <span class="text-indigo-100 flex items-center">
                            <i class="bi bi-person mr-1"></i>
                            Organized by {{ $competition->organizer->name }}
                        </span>
                    </div>
                    
                    <p class="text-indigo-100 max-w-prose">{{ Str::limit($competition->description, 150) }}</p>
                </div>
                
                @if($competition->external_registration_link && $competition->status === 'open')
                <div class="shrink-0">
                    <a href="{{ $competition->external_registration_link }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-full shadow-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-1 transition-all duration-150 ease-in-out" target="_blank">
                        <i class="bi bi-pencil-square mr-2"></i>
                        Register Now
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main content area -->
<div class="mx-auto">
    <!-- Competition details in a two-column layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Left column (2/3 width on large screens) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Competition image card -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md">
                <div class="h-80 overflow-hidden relative">
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
                </div>
                
                <!-- Event details with modern design -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b border-gray-200">Event Details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Location -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                                <i class="bi bi-geo-alt-fill text-indigo-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Location</p>
                                <h5 class="font-bold text-gray-800">{{ $competition->location }}</h5>
                            </div>
                        </div>
                        
                        <!-- Event Period -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <i class="bi bi-calendar-event-fill text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Event Period</p>
                                <h5 class="font-bold text-gray-800">{{ $competition->start_date->format('M d, Y') }} - {{ $competition->end_date->format('M d, Y') }}</h5>
                            </div>
                        </div>
                        
                        <!-- Registration Deadline -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full {{ now()->gt($competition->registration_deadline) ? 'bg-red-100' : 'bg-yellow-100' }} flex items-center justify-center mr-4">
                                <i class="bi bi-hourglass-split {{ now()->gt($competition->registration_deadline) ? 'text-red-600' : 'text-yellow-600' }} text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Registration Deadline</p>
                                <h5 class="font-bold {{ now()->gt($competition->registration_deadline) ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $competition->registration_deadline->format('M d, Y') }}
                                    <span class="ml-2 text-sm font-normal text-gray-500">{{ now()->diffForHumans($competition->registration_deadline) }}</span>
                                </h5>
                            </div>
                        </div>
                        
                        <!-- Max Participants -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <i class="bi bi-people-fill text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Maximum Participants</p>
                                @if($competition->max_participants)
                                    <h5 class="font-bold text-gray-800">{{ number_format($competition->max_participants) }} participants</h5>
                                @else
                                    <h5 class="font-bold text-gray-800">Unlimited participants</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- About section -->
                    <div class="bg-gray-50 border-l-4 border-indigo-500 p-6 rounded-lg my-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-3 flex items-center">
                            <i class="bi bi-info-circle text-indigo-600 mr-2"></i> 
                            About This Competition
                        </h3>
                        <p class="text-gray-700">{{ $competition->description }}</p>
                    </div>
                    
                    <!-- Admin/Organizer actions -->
                    @if(Auth::user()->isAdmin() || (Auth::user()->isOrganizer() && $competition->organizer_id === Auth::id()))
                    <div class="flex mt-6 space-x-3">
                        <a href="{{ route('competitions.edit', $competition->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
                            <i class="bi bi-pencil mr-2"></i> Edit
                        </a>
                        <form action="{{ route('competitions.destroy', $competition->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this competition?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150 ease-in-out">
                                <i class="bi bi-trash mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right sidebar (1/3 width on large screens) -->
        <div class="space-y-6">
            <!-- Registration card -->
            @if(Auth::user()->isStudent())
                @if($competition->participants->contains(Auth::id()))
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <i class="bi bi-check-circle-fill text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-blue-800 mb-2">You've Already Registered</h5>
                                <p class="text-blue-600">You've successfully registered for this competition.</p>
                            </div>
                        </div>
                    </div>
                @else
                    @if($competition->external_registration_link && $competition->status === 'open')
                        <div class="bg-white p-6 rounded-xl shadow-md text-center">
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                                    <i class="bi bi-person-plus-fill text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">Join this Competition</h3>
                                <p class="text-gray-500 text-sm">Registration deadline: {{ $competition->registration_deadline->format('M d, Y') }}</p>
                            </div>
                            
                            <a href="{{ $competition->external_registration_link }}" class="block w-full px-5 py-3 bg-green-600 text-white text-center font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-1 transition-all duration-150 ease-in-out mb-2" target="_blank">
                                <i class="bi bi-pencil-square mr-2"></i> Register Now
                            </a>
                            <span class="text-xs text-gray-500">You'll be redirected to the official competition site</span>
                            
                            @if(!Auth::user()->isStudent())
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="font-medium text-gray-700 mb-3">Competition Management</p>
                                <a href="{{ route('competitions.edit', $competition->id) }}" class="block w-full px-5 py-3 border border-indigo-600 text-indigo-600 text-center font-medium rounded-lg hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150 ease-in-out mb-2">
                                    <i class="bi bi-gear-fill mr-2"></i> Manage Competition
                                </a>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg shadow-sm">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-3">
                                    <i class="bi bi-exclamation-triangle-fill text-yellow-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-yellow-800 mb-1">Registration Unavailable</h5>
                                    <p class="text-yellow-700">This competition is currently not accepting registrations.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Competition organizer info -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h5 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-building text-indigo-600 mr-2"></i> Organizer Information
                    </h5>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mr-4">
                            {{ substr($competition->organizer->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="font-semibold text-gray-800 mb-1">{{ $competition->organizer->name }}</h6>
                            <p class="text-gray-500 text-sm">{{ $competition->organizer->email }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Key Dates Card -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h5 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-calendar2-event text-indigo-600 mr-2"></i> Key Dates
                    </h5>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <i class="bi bi-calendar-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-0.5">Registration Deadline</p>
                                <p class="font-semibold text-gray-800">{{ $competition->registration_deadline->format('M d, Y') }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <i class="bi bi-calendar-plus text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-0.5">Event Starts</p>
                                <p class="font-semibold text-gray-800">{{ $competition->start_date->format('M d, Y') }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="bi bi-calendar-minus text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-0.5">Event Ends</p>
                                <p class="font-semibold text-gray-800">{{ $competition->end_date->format('M d, Y') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Find Team Members For Students -->
                @if(Auth::user()->isStudent())
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 rounded-xl shadow-md text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Need Team Members?</h3>
                            <p class="text-indigo-100">Find potential teammates randomly to build a winning team quickly</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center px-5 py-3 bg-white text-indigo-600 font-medium rounded-lg hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-150 ease-in-out">
                                <i class="bi bi-people-fill mr-2 text-lg"></i> Find Team Members
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection
