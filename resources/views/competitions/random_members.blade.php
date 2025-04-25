@extends('layouts.app')

@section('title', 'Find Team Members')

@section('content')
<!-- Hero section with gradient background -->
<div class="bg-gradient-to-r from-indigo-800 to-indigo-600 text-white rounded-xl overflow-hidden shadow-xl mb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col space-y-4">
            <a href="{{ route('competitions.show', $competition->id) }}" class="inline-flex items-center text-indigo-100 hover:text-white transition duration-150 ease-in-out group w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-150 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to competition
            </a>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-bold">Find Team Members</h1>
                    <p class="text-indigo-100">For {{ $competition->title }}</p>
                </div>
                
                <div class="shrink-0">
                    <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-full shadow-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-1 transition-all duration-150 ease-in-out">
                        <i class="bi bi-shuffle mr-2"></i> Refresh List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-10">
    <!-- About Team Formation Section -->
    <div class="bg-white rounded-xl shadow-md mb-8 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-start mb-6 gap-4">
                <div class="flex-shrink-0 w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center">
                    <i class="bi bi-info-circle text-indigo-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-800 mb-3 pb-2 border-b border-gray-200 inline-block">About Team Formation</h4>
                    <p class="text-gray-700">We've selected random students who might be interested in joining your team for <span class="font-medium">{{ $competition->title }}</span>. Contact them directly to form your team!</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="bi bi-check-circle-fill text-green-600"></i>
                    </div>
                    <span class="text-gray-700">Students with accounts only</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="bi bi-shuffle text-yellow-600"></i>
                    </div>
                    <span class="text-gray-700">Randomly selected members</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="bi bi-envelope-fill text-blue-600"></i>
                    </div>
                    <span class="text-gray-700">Direct email contact</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Team Members Section -->
    @if($randomUsers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($randomUsers as $user)
                @php
                    $colors = ['indigo', 'green', 'red', 'yellow', 'purple', 'blue'];
                    $randomColor = $colors[array_rand($colors)];
                @endphp
                <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-14 h-14 rounded-full bg-{{ $randomColor }}-600 flex items-center justify-center text-white text-xl font-bold mr-4">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-800 mb-1">{{ $user->name }}</h5>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="bi bi-mortarboard-fill text-green-600 mr-1"></i> Student
                                </span>
                            </div>
                        </div>
                        <div class="mb-5">
                            <div class="flex items-center text-gray-500 mb-2">
                                <i class="bi bi-envelope mr-2"></i>
                                <span class="text-sm">{{ $user->email }}</span>
                            </div>
                        </div>
                        <a href="mailto:{{ $user->email }}?subject=Team Up for {{ urlencode($competition->title) }}&body=Hello {{ urlencode($user->name) }},%0D%0A%0D%0AI am looking for team members for the '{{ urlencode($competition->title) }}' competition. Would you be interested in joining my team?%0D%0A%0D%0ACompetition details: {{ urlencode(route('competitions.show', $competition->id)) }}%0D%0A%0D%0AThanks!" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:-translate-y-1">
                            <i class="bi bi-envelope-fill mr-2"></i> Contact {{ substr($user->name, 0, strpos($user->name, ' ') ?: strlen($user->name)) }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center my-10">
            <p class="text-gray-500 mb-4">Not finding the right match? Try again for a different set of potential teammates.</p>
            <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-200 hover:-translate-y-1">
                <i class="bi bi-shuffle mr-2"></i> Find More Team Members
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-10 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i class="bi bi-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No Team Members Found</h3>
                <p class="text-gray-500 mb-6">We couldn't find any potential team members at this time. Please try again later.</p>
                <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:-translate-y-1">
                    <i class="bi bi-arrow-repeat mr-2"></i> Try Again
                </a>
            </div>
        </div>
    @endif
    
    <!-- Team Building Tips Section -->
    <div class="mt-12">
        <h3 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200 inline-block">Tips for Building a Strong Team</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
                <div class="p-6">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                        <i class="bi bi-people-fill text-indigo-600 text-xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 mb-2">Complementary Skills</h5>
                    <p class="text-gray-600 text-sm">Look for members with different skills that complement each other.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
                <div class="p-6">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mb-4">
                        <i class="bi bi-chat-dots-fill text-green-600 text-xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 mb-2">Clear Expectations</h5>
                    <p class="text-gray-600 text-sm">Discuss commitment levels and expectations early on.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
                <div class="p-6">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mb-4">
                        <i class="bi bi-bullseye text-yellow-600 text-xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 mb-2">Set Clear Goals</h5>
                    <p class="text-gray-600 text-sm">Define responsibilities and goals for each team member.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
                <div class="p-6">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <i class="bi bi-calendar2-check text-blue-600 text-xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 mb-2">Regular Meetings</h5>
                    <p class="text-gray-600 text-sm">Schedule regular team meetings to track progress.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection