@extends('layouts.app')

@section('title', 'LombaKuy Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Enhanced Welcome Banner with Quick Stats -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden relative z-0">
        <!-- Decorative patterns and shapes - TOP -->
        <div class="absolute top-0 right-0 w-full h-full overflow-hidden">
            <svg class="absolute right-0 top-0 opacity-20" width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FFFFFF" d="M38.9,-66.7C50.5,-58.5,60.2,-48.1,67.8,-35.8C75.3,-23.5,80.7,-9.4,79.9,4.6C79.1,18.6,72.1,32.5,63.3,44.2C54.5,55.9,43.9,65.3,31.7,69.2C19.4,73.1,5.4,71.5,-9.2,70.8C-23.9,70.1,-39.3,70.3,-51.5,64.4C-63.7,58.5,-72.8,46.5,-79.2,33C-85.7,19.4,-89.5,4.3,-87.9,-10.3C-86.3,-24.9,-79.2,-39,-68.8,-49.6C-58.3,-60.3,-44.4,-67.6,-30.7,-74.2C-17,-80.7,-3.5,-86.6,8.2,-80.8C19.9,-75.1,39.8,-57.7,38.9,-66.7Z" transform="translate(100 100)" />
            </svg>
            <svg class="absolute left-1/4 top-0 opacity-20" width="250" height="250" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FFFFFF" d="M43.7,-76.3C57.9,-69.9,71.5,-59.8,80.3,-46.1C89.1,-32.4,93,-15.2,90.3,0.8C87.6,16.8,78.3,31.6,67.4,43.9C56.5,56.2,44,66,30.3,73.8C16.6,81.5,1.8,87.1,-13.1,87.4C-28,87.7,-43,82.7,-55.1,73.5C-67.2,64.4,-76.5,51.1,-81.5,36.5C-86.5,21.9,-87.2,5.9,-85.3,-10C-83.4,-25.9,-78.9,-41.8,-69.1,-54C-59.3,-66.2,-44.3,-74.8,-29.3,-80.2C-14.3,-85.7,0.6,-88,14.6,-85.4C28.5,-82.8,41.3,-75.4,43.7,-76.3Z" transform="translate(100 100)" />
            </svg>
        </div>
        
        <div class="relative p-8 md:p-10">
            <!-- Top decorative elements -->
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white bg-opacity-10 rounded-full blur-xl"></div>
            <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-40 h-40 bg-indigo-400 bg-opacity-20 rounded-full blur-xl"></div>
            
            <!-- Floating Particles/Icons -->
            <div class="absolute h-full w-full top-0 left-0 overflow-hidden">
                <div class="absolute top-1/4 left-1/3 animate-pulse">
                    <svg class="w-6 h-6 text-white opacity-40" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <div class="absolute top-1/5 right-1/4 animate-float">
                    <svg class="w-8 h-8 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="absolute bottom-1/4 right-1/5">
                    <svg class="w-5 h-5 text-white opacity-50 animate-spin-slow" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="absolute bottom-1/3 left-1/4">
                    <svg class="w-6 h-6 text-white opacity-40 animate-bounce-slow" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Wave pattern at the bottom -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="opacity-20">
                    <path fill="#FFFFFF" fill-opacity="1" d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,90.7C672,85,768,107,864,122.7C960,139,1056,149,1152,138.7C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>
            </div>
            
            <!-- Main Content with Enhanced Visual Design -->
            <div class="relative grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <!-- Abstract shape behind the heading -->
                    <div class="absolute -left-10 -top-10 w-32 h-32 bg-purple-500 rounded-full filter blur-3xl opacity-20"></div>
                    
                    <div class="relative">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 drop-shadow-md">Welcome, {{ auth()->user()->name }}!</h1>
                        <p class="text-indigo-100 text-lg mb-6">Let's unlock your potential by joining competitions that suit you.</p>
                                                                      
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('explore') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 font-semibold rounded-lg px-5 py-3 transition shadow-lg flex items-center group">
                                <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Find Competitions
                            </a>
                            <a href="#" class="bg-indigo-500 bg-opacity-30 hover:bg-opacity-40 text-white font-semibold rounded-lg px-5 py-3 transition flex items-center border border-indigo-300 border-opacity-40 group">
                                <svg class="w-5 h-5 mr-2 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Find Competition Teammates
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:block relative">
                    <!-- Spotlight effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-transparent opacity-20 rounded-full blur-3xl"></div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Competition Status Card -->
                        <div class="bg-white bg-opacity-15 backdrop-filter backdrop-blur-md p-5 rounded-xl border border-white border-opacity-20 transform transition-all hover:scale-105 shadow-lg relative group overflow-hidden">
                            <!-- Decorative pattern inside card -->
                            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-white bg-opacity-20 rounded-full"></div>
                            
                            <div class="flex items-center space-x-3 mb-2 relative">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg shadow-inner">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-800 font-medium">Competition Status</span>
                                
                                <!-- Glow effect on hover -->
                                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-blue-600 to-purple-600 opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></div>
                            </div>
                            <div class="flex justify-between relative">
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800">{{ $activeCompetitions ?? 0 }}</h4>
                                    <p class="text-xs text-gray-600">Active Competitions</p>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800">{{ $completedCompetitions ?? 0 }}</h4>
                                    <p class="text-xs text-gray-600">Completed</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Saved Competitions Card -->
                        <div class="bg-white bg-opacity-15 backdrop-filter backdrop-blur-md p-5 rounded-xl border border-white border-opacity-20 transform transition-all hover:scale-105 shadow-lg relative group overflow-hidden">
                            <!-- Decorative pattern inside card -->
                            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-white bg-opacity-20 rounded-full"></div>
                            
                            <div class="flex items-center space-x-3 mb-2 relative">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg shadow-inner">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-800 font-medium">Saved Competitions</span>
                                
                                <!-- Glow effect on hover -->
                                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></div>
                            </div>
                            <div class="flex items-end justify-between">
                                <h4 class="text-3xl font-bold text-gray-800">{{ $savedCompetitions ?? 0 }}</h4>
                                <a href="{{ route('competitions.saved') }}" class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline group-hover:text-indigo-800 transition-colors">See All</a>
                            </div>
                        </div>
                        
                        <!-- Upcoming Schedule Timeline -->
                        <div class="col-span-2 mt-4 bg-white bg-opacity-15 backdrop-filter backdrop-blur-md rounded-xl border border-white border-opacity-20 p-5 transform transition-all hover:scale-102 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-gray-800 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Upcoming Schedule
                                </h3>
                                <span class="text-xs px-2 py-1 bg-indigo-700 bg-opacity-50 rounded-full text-white">3 Events</span>
                            </div>
                            
                            <!-- Timeline -->
                            <div class="space-y-3">
                                <!-- Timeline Item 1 -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                    <div class="text-xs bg-white bg-opacity-10 px-3 py-1 rounded-md text-gray-800 flex-grow flex justify-between">
                                        <span>May 3</span>
                                        <span class="font-medium">Submit Proposal</span>
                                    </div>
                                </div>
                                
                                <!-- Timeline Item 2 -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="text-xs bg-white bg-opacity-10 px-3 py-1 rounded-md text-gray-800 flex-grow flex justify-between">
                                        <span>May 10</span>
                                        <span class="font-medium">Final Presentation</span>
                                    </div>
                                </div>
                                
                                <!-- Timeline Item 3 -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="text-xs bg-white bg-opacity-10 px-3 py-1 rounded-md text-gray-800 flex-grow flex justify-between">
                                        <span>May 15</span>
                                        <span class="font-medium">UI/UX Challenge Deadline</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Competition Feed -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recommended Competitions -->
            <div>
                <div class="flex justify-between items-center mb-6 relative z-10">
                    <h2 class="text-2xl font-bold text-gray-800">Recommended Competitions</h2>
                    <a href="{{ route('explore') }}" dusk="lihat-semua-lomba" class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold">
                        See All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @forelse ($competitions ?? [] as $competition)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <!-- Image Section -->
                            <div class="relative h-56 group overflow-hidden">
                                <img 
                                    src="{{ asset('storage/' . ($competition->photo ?? 'images/default-competition.jpg')) }}" 
                                    class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                                    alt="{{ $competition->title ?? 'Competition Image' }}"
                                    style="height: 100%; width: 100%; object-fit: cover;"
                                    onclick="openPreviewModal('{{ asset('storage/' . ($competition->photo ?? 'images/default-competition.jpg')) }}')"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-600 bg-opacity-90 text-white backdrop-blur-sm">
                                        {{ $competition->category }}
                                    </span>
                                </div>
                                
                                <!-- View Poster Button -->
                                <div class="absolute top-4 right-16">
                                    <button onclick="openPreviewModal('{{ asset('storage/' . ($competition->photo ?? 'images/default-competition.jpg')) }}')" 
                                            class="bg-white p-2 rounded-full shadow hover:bg-blue-100 transition transform hover:scale-110" 
                                            title="View Poster">
                                        <i class="fas fa-search-plus text-blue-600"></i>
                                    </button>
                                </div>
                                
                                <!-- Bookmark Button -->
                                @auth
                                @if(auth()->user()->role === 'user')
                                    <form action="{{ auth()->user()->savedCompetitions->contains($competition->id) 
                                                    ? route('competitions.unsave', $competition->id) 
                                                    : route('competitions.save', $competition->id) }}" 
                                        method="POST" 
                                        class="absolute top-4 right-4">
                                        @csrf
                                        @if(auth()->user()->savedCompetitions->contains($competition->id))
                                            @method('DELETE')
                                            <button class="bg-white p-2 rounded-full shadow hover:bg-red-100 transition transform hover:scale-110" title="Remove Bookmark">
                                                <i class="fas fa-bookmark text-red-500"></i>
                                            </button>
                                        @else
                                            <button class="bg-white p-2 rounded-full shadow hover:bg-indigo-100 transition transform hover:scale-110" title="Save Bookmark">
                                                <i class="far fa-bookmark text-indigo-600"></i>
                                            </button>
                                        @endif
                                    </form>
                                @endif
                                @endauth
                                
                                <!-- Deadline Badge -->
                                <div class="absolute bottom-4 left-4">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-600 bg-opacity-90 text-white backdrop-blur-sm">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($competition->deadline)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 hover:text-indigo-600 transition">{{ $competition->title ?? 'Competition Title' }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit($competition->description ?? 'Competition description.', 100) }}</p>
                                
                                <!-- Prize and Deadline -->
                                <div class="space-y-4 mb-5">
                                    <!-- Prize -->
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-gift text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Total Prize</p>
                                            <p class="font-bold text-gray-800">{{ $competition->prize ?? 'Not yet determined' }}</p>
                                        </div>
                                    </div>
                                    <!-- Deadline -->
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-clock text-red-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Deadline</p>
                                            <p class="font-bold text-gray-800">
                                                {{ $competition->deadline ? \Carbon\Carbon::parse($competition->deadline)->format('M d, Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex space-x-2 mt-auto">
                                    <a href="{{ route('competitions.show', $competition->id) }}" dusk="lihat-detail-{{ $competition->id }}" class="block w-full bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-indigo-700 transition text-center transform hover:scale-105">
                                        <i class="fas fa-eye mr-2"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-indigo-50 rounded-xl p-8 text-center" data-aos="fade-up">
                            <svg class="w-16 h-16 text-indigo-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Competitions Yet</h3>
                            <p class="text-gray-600">Competitions will soon be displayed here.</p>
                            <a href="{{ route('explore') }}" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg px-5 py-2.5">
                                Discover Competitions
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Active Competition Tasks -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="border-b border-gray-100 px-6 py-4 bg-gradient-to-r from-indigo-50 to-white flex justify-between items-center relative">
                    <h2 class="text-lg font-bold text-gray-800 z-10">Upcoming Tasks (Nearest Deadlines)</h2>
                    <div class="flex items-center space-x-3 z-10">
                        <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full transition-all duration-500" style="width: {{ $overallProgress }}%;"></div>
                        </div>
                        <span class="text-sm text-gray-600 flex items-center">
                            <span class="font-semibold text-indigo-600 relative">
                                {{ $overallProgress }}%
                                <span class="absolute -top-2 -right-4 w-4 h-4 bg-indigo-600 rounded-full opacity-20 animate-ping"></span>
                            </span>
                        </span>
                    </div>
                    <!-- Decorative gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-transparent opacity-50 blur-md"></div>
                </div>

                @if($assignedTasks->count())
                <div class="relative p-6">
                    <!-- Slider Container -->
                    <div class="flex items-start gap-6 overflow-x-auto scrollbar-hide snap-x" id="taskSlider">
                        @foreach($assignedTasks as $task)
                        <div class="min-w-[300px] min-h-[220px] bg-white p-5 rounded-lg shadow-md hover:bg-indigo-50/50 transition-all duration-300 snap-center border border-indigo-200 flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="flex-1">
                                <!-- Task Details -->
                                <div class="flex justify-between items-start gap-4 relative">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800 text-lg group-hover:text-indigo-600 transition-colors line-clamp-2">
                                            {{ $task->title }}
                                        </h3>
                                        <div class="text-sm text-gray-600 space-y-1 mt-2">
                                            <p class="line-clamp-1">Comp: {{ $task->team->competition_name ?? '-' }}</p>
                                            <p class="line-clamp-1">DL: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') ?? '-' }}</p>
                                            <p class="line-clamp-1">Team: {{ $task->team->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <!-- Status Badge with Animation -->
                                    <span class="status-badge {{ str_replace('_', '-', $task->status) }} text-xs font-medium px-3 py-1.5 rounded-full shadow-sm transform transition-all group-hover:scale-105 whitespace-nowrap">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        <span class="ml-1 inline-block w-2 h-2 rounded-full animate-pulse" style="background-color: inherit;"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('tasks.index', ['team_id' => $task->team_id]) }}" 
                                class="text-xs text-indigo-600 hover:text-indigo-700 font-medium flex items-center group/link transition-all">
                                    View Team Tasks →
                                    <svg class="w-3 h-3 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows -->
                    <button id="prevTask" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-[#4f46e5] hover:bg-[#4338ca] rounded-full p-2 shadow-md transition-all z-10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="nextTask" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#4f46e5] hover:bg-[#4338ca] rounded-full p-2 shadow-md transition-all z-10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                @else
                <div class="p-10 text-center bg-indigo-50/50 rounded-b-xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-transparent opacity-30 blur-md"></div>
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-gray-700 font-medium mb-3 relative z-10">No Tasks Assigned</h3>
                    <p class="text-gray-500 text-sm mb-6 relative z-10">You are not assigned to any tasks yet.</p>
                    <a href="{{ route('explore') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium relative z-10 inline-flex items-center">
                        Explore Competitions →
                        <svg class="w-4 h-4 ml-1 transform hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Right Column - User Activity & Quick Access -->
        <div class="space-y-8">
            <!-- Personal Profile Summary -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center space-x-4">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/images/' . auth()->user()->profile_image) : 'https://via.placeholder.com/150' }}" class="w-16 h-16 rounded-full border-2 border-indigo-100" alt="Profile Photo">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-3 text-center">
                    <div class="bg-indigo-50 rounded-lg p-3">
                        <h4 class="text-xl font-bold text-indigo-600">{{ $completedCompetitions ?? 0 }}</h4>
                        <p class="text-xs text-gray-600">Completed Competitions</p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-3">
                        <h4 class="text-xl font-bold text-indigo-600">{{ $achievements ?? 0 }}</h4>
                        <p class="text-xs text-gray-600">Achievements</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('profile.show') }}" class="block text-center bg-white border border-indigo-600 hover:bg-indigo-50 text-indigo-600 font-medium rounded-lg py-2 transition">
                        View Profile
                    </a>
                </div>
            </div>
            
            <!-- Quick Access Features -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Quick Access</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('assessment.index')}}" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Assessment</span>
                    </a>
                    <a href="{{ route('teams.index') }}" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">My Team</span>
                    </a>
                    <a href="{{ route('invitations.index') }}" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Invitations</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Notifications</span>
                    </a>
                </div>
            </div>
            
            <!-- Competition Videos & Tips -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 relative overflow-hidden">
                    <!-- Decorative element -->
                    <div class="absolute -right-6 -top-6 w-12 h-12 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute left-2 bottom-0 w-20 h-20 bg-purple-500 bg-opacity-20 rounded-full filter blur-2xl"></div>
                    
                    <div class="flex justify-between items-center relative z-10">
                        <h3 class="font-bold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Competition Videos & Tips
                        </h3>
                        <a href="{{ route('learning-videos.index') }}" class="text-white hover:underline text-xs font-medium transition-all flex items-center">
                            See All
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse($learningVideos as $video)
                        <a href="{{ route('learning-videos.show', $video->id) }}" class="block group hover:bg-indigo-50 transition-colors duration-300">
                            <div class="p-4 flex space-x-3">
                                <div class="flex-shrink-0 relative w-32 h-20 bg-gray-100 rounded-lg overflow-hidden shadow-sm">
                                    @if($video->thumbnail_url)
                                        <img 
                                            src="{{ $video->thumbnail_url }}" 
                                            alt="{{ $video->title }}" 
                                            class="w-full h-full object-cover z-10 relative group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy"
                                            referrerpolicy="no-referrer"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 text-indigo-400 z-10 relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Category badge -->
                                    <div class="absolute top-1 left-1 z-20">
                                        <span class="inline-block bg-black bg-opacity-60 text-white text-[10px] px-1.5 py-0.5 rounded">
                                            {{ $video->category }}
                                        </span>
                                    </div>

                                    <!-- Play Overlay -->
                                    <div class="absolute inset-0 z-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                        <div class="w-8 h-8 rounded-full bg-indigo-600 bg-opacity-0 group-hover:bg-opacity-90 flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            </svg>
                                        </div>
                                    </div>

                                    @if($video->duration)
                                        <div class="absolute bottom-1 right-1 bg-black bg-opacity-70 text-white text-[10px] px-1 py-0.5 rounded z-20">
                                            {{ $video->duration }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-800 group-hover:text-indigo-600 transition line-clamp-2 mb-1">{{ $video->title }}</h4>
                                    @if($video->description)
                                        <p class="text-xs text-gray-500 line-clamp-1 mb-1">{{ Str::limit($video->description, 60) }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500">No learning videos available yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Latest Articles Section -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-4 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-16 h-16 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute -left-4 bottom-0 w-24 h-24 bg-purple-500 bg-opacity-20 rounded-full filter blur-xl"></div>

                    <div class="w-full flex justify-start">
                        <h3 class="text-lg font-bold text-white flex items-center relative z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Latest Articles
                        </h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($latestArticles->take(3) as $article)
                        <div class="flex border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            @if($article->thumbnail)
                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 mr-4">
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 mr-4 bg-indigo-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2 py-0.5 rounded mb-1">
                                    {{ $article->category }}
                                </div>
                                <h4 class="font-medium text-gray-800 mb-1 line-clamp-2 hover:text-indigo-600 transition">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </h4>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $article->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>No articles published yet</p>
                        </div>
                    @endforelse
                    <div class="mt-6">
                        <a href="{{ route('articles.index') }}"
                        class="w-full block text-center bg-indigo-600 text-white font-medium text-sm rounded-lg py-2.5 hover:bg-indigo-700 transition">
                            Read More Articles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" id="previewModal">
        <div class="bg-white rounded-lg max-w-4xl w-full mx-4">
            <div class="p-4 text-center">
                <img id="modalImage" class="rounded mx-auto" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
            </div>
            <div class="p-4 border-t border-gray-200">
                <button type="button" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition" onclick="closePreviewModal()">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* Custom Animations for Elements */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    /* Additional new styles */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
    
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 4s infinite;
    }
    
    .hover\:scale-102:hover {
        transform: scale(1.02);
    }

    /* Custom Scrollbar for Lists */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #818cf8;
    }
    
    /* Card hover effects */
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    /* Glowing effect for achievement badges */
    .achievement-badge {
        position: relative;
    }
    
    .achievement-badge::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8, #c7d2fe);
        z-index: -1;
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .achievement-badge:hover::after {
        opacity: 0.7;
        animation: rotate-gradient 3s linear infinite;
    }
    
    @keyframes rotate-gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Pulse notification dot */
    .notification-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        background-color: #ef4444;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    
    /* Progress bar animation */
    .progress-bar-animate {
        position: relative;
        overflow: hidden;
    }
    
    .progress-bar-animate::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: progress-shine 2s infinite;
    }
    
    @keyframes progress-shine {
        100% { left: 100%; }
    }
    
    /* Timeline connector animation */
    .timeline-connector {
        position: relative;
    }
    
    .timeline-connector::before {
        content: "";
        position: absolute;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
        width: 2px;
        height: 100%;
        background: linear-gradient(180deg, #4f46e5 0%, #c7d2fe 100%);
        opacity: 0.6;
    }
    
    /* Confetti animation for achievements */
    .confetti-animation {
        position: relative;
        overflow: hidden;
    }
    
    .confetti-animation::before {
        content: "";
        position: absolute;
        top: -10px;
        left: 0;
        right: 0;
        height: 10px;
        background-image: 
            radial-gradient(circle, #ff0000 2px, transparent 2px),
            radial-gradient(circle, #00ff00 2px, transparent 2px),
            radial-gradient(circle, #0000ff 2px, transparent 2px),
            radial-gradient(circle, #ffff00 2px, transparent 2px);
        background-size: 10px 10px;
        animation: confetti-fall 3s linear infinite;
    }
    
    @keyframes confetti-fall {
        0% { transform: translateY(-10px); }
        100% { transform: translateY(300px); }
    }
    
    /* Responsive adjustments for mobile */
    @media (max-width: 640px) {
        .dashboard-grid {
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-container {
            width: 100%;
            position: static;
        }
        
        .content-container {
            margin-left: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
// Slider Navigation for Tasks
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('taskSlider');
    const prevButton = document.getElementById('prevTask');
    const nextButton = document.getElementById('nextTask');

    if (slider && prevButton && nextButton) {
        const scrollAmount = 320; // Adjust based on min-width of task cards (e.g., 300px + padding)

        prevButton.addEventListener('click', () => {
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        nextButton.addEventListener('click', () => {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        // Optional: Hide arrows when at start/end
        slider.addEventListener('scroll', () => {
            if (slider.scrollLeft === 0) {
                prevButton.style.opacity = '0.5';
                prevButton.disabled = true;
            } else {
                prevButton.style.opacity = '1';
                prevButton.disabled = false;
            }

            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth) {
                nextButton.style.opacity = '0.5';
                nextButton.disabled = true;
            } else {
                nextButton.style.opacity = '1';
                nextButton.disabled = false;
            }
        });

        // Initial check
        slider.dispatchEvent(new Event('scroll'));
    }
});
</script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
    });

    // Modal Preview Functions
    function openPreviewModal(imageUrl) {
        console.log('Opening modal with image:', imageUrl); // Debug log
        const modal = document.getElementById('previewModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closePreviewModal() {
        console.log('Closing modal'); // Debug log
        const modal = document.getElementById('previewModal');
        modal.classList.add('hidden');
        document.getElementById('modalImage').src = ''; // Clear image
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close modal on click outside
    document.getElementById('previewModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('previewModal').classList.contains('hidden')) {
            closePreviewModal();
        }
    });

    // Dashboard Charts & Data Visualization
    document.addEventListener('DOMContentLoaded', function() {
        // Progress Bar Animation
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            bar.classList.add('progress-bar-animate');
        });
        
        // Notification Counter
        const notificationBadge = document.getElementById('notification-badge');
        if (notificationBadge) {
            let count = parseInt(localStorage.getItem('notificationCount') || '0');
            notificationBadge.textContent = count;
            notificationBadge.style.display = count > 0 ? 'flex' : 'none';
        }
        
        // Animate Stats Counter
        const countElements = document.querySelectorAll('.count-up');
        countElements.forEach(el => {
            const target = parseInt(el.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                el.textContent = Math.floor(current);
                if (current >= target) {
                    el.textContent = target;
                    clearInterval(timer);
                }
            }, 16);
        });
        
        // Calendar Integration
        const calendarEl = document.getElementById('competition-calendar');
        if (calendarEl) {
            // Initialize a simple event display
            const events = [
                { date: '2025-05-10', title: 'UI/UX Competition Deadline' },
                { date: '2025-05-15', title: 'Submission Review' },
                { date: '2025-05-30', title: 'Hackathon Preparation' }
            ];
            
            const currentDate = new Date();
            let calendarHTML = `<div class="text-center mb-2">${currentDate.toLocaleString('default', { month: 'long' })} ${currentDate.getFullYear()}</div>`;
            calendarHTML += `<div class="grid grid-cols-7 gap-1">`;
            
            // Add day labels
            ['S', 'M', 'T', 'W', 'T', 'F', 'S'].forEach(day => {
                calendarHTML += `<div class="text-xs text-center font-medium text-gray-500">${day}</div>`;
            });
            
            // Generate calendar days
            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            
            // Add empty cells for days before the 1st of the month
            for (let i = 0; i < firstDay.getDay(); i++) {
                calendarHTML += `<div class="h-8 bg-gray-50 rounded-md opacity-50"></div>`;
            }
            
            // Add days of the month
            for (let i = 1; i <= lastDay.getDate(); i++) {
                const dateStr = `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
                const hasEvent = events.some(event => event.date === dateStr);
                
                if (i === currentDate.getDate()) {
                    calendarHTML += `<div class="h-8 bg-indigo-600 text-white rounded-md flex items-center justify-center text-xs font-medium">${i}</div>`;
                } else if (hasEvent) {
                    calendarHTML += `<div class="h-8 bg-indigo-100 text-indigo-800 rounded-md flex items-center justify-center text-xs font-medium relative">
                        ${i}
                        <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-indigo-600 rounded-full"></span>
                    </div>`;
                } else {
                    calendarHTML += `<div class="h-8 hover:bg-gray-100 rounded-md flex items-center justify-center text-xs">${i}</div>`;
                }
            }
            
            calendarHTML += `</div>`;
            
            // Add upcoming events list
            calendarHTML += `<div class="mt-4 space-y-2">
                <h4 class="text-xs font-medium text-gray-600">UPCOMING EVENTS</h4>`;
                
            events.forEach(event => {
                const eventDate = new Date(event.date);
                calendarHTML += `<div class="flex items-center space-x-2 text-xs">
                    <div class="w-2 h-2 bg-indigo-600 rounded-full"></div>
                    <span class="text-gray-600">${eventDate.getDate()}/${eventDate.getMonth() + 1}</span>
                    <span class="font-medium text-gray-800">${event.title}</span>
                </div>`;
            });
            
            calendarHTML += `</div>`;
            calendarEl.innerHTML = calendarHTML;
        }
    });
    
    // Team collaboration features
    function inviteTeamMember(competitionId) {
        // Open modal dialog
        const modal = document.getElementById('invite-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.getElementById('competition-id').value = competitionId;
        }
    }
    
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
    
    // Task management
    function updateTaskStatus(taskId, status) {
        // Visual feedback immediately
        const taskElement = document.getElementById(`task-${taskId}`);
        if (taskElement) {
            // Remove all status classes
            taskElement.classList.remove('border-yellow-300', 'border-blue-300', 'border-green-300');
            
            // Add appropriate class based on new status
            if (status === 'pending') {
                taskElement.classList.add('border-yellow-300');
            } else if (status === 'in-progress') {
                taskElement.classList.add('border-blue-300');
            } else if (status === 'completed') {
                taskElement.classList.add('border-green-300');
            }
            
            // Update status text
            const statusBadge = taskElement.querySelector('.status-badge');
            if (statusBadge) {
                statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1).replace('-', ' ');
            }
        }
        
        // In a real application, you would also make an AJAX call to update the status in the database
    }
    
    // Notification handling
    function markAllAsRead() {
        // Visual feedback
        const badges = document.querySelectorAll('.notification-badge');
        badges.forEach(badge => {
            badge.style.display = 'none';
        });
        
        localStorage.setItem('notificationCount', '0');
        
        // In a real application, make an AJAX call to mark notifications as read in the database
    }
</script>

<style>
/* Custom Animations for Elements */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
    
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 4s infinite;
    }
    
    .hover\:scale-102:hover {
        transform: scale(1.02);
    }

    /* Custom Scrollbar for Lists */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #818cf8;
    }
    
    /* Card hover effects */
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    /* Glowing effect for achievement badges */
    .achievement-badge {
        position: relative;
    }
    
    .achievement-badge::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8, #c7d2fe);
        z-index: -1;
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .achievement-badge:hover::after {
        opacity: 0.7;
        animation: rotate-gradient 3s linear infinite;
    }
    
    @keyframes rotate-gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Pulse notification dot */
    .notification-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        background-color: #ef4444;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    
    /* Progress bar animation */
    .progress-bar-animate {
        position: relative;
        overflow: hidden;
    }
    
    .progress-bar-animate::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: progress-shine 2s infinite;
    }
    
    @keyframes progress-shine {
        100% { left: 100%; }
    }
    
    /* Timeline connector animation */
    .timeline-connector {
        position: relative;
    }
    
    .timeline-connector::before {
        content: "";
        position: absolute;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
        width: 2px;
        height: 100%;
        background: linear-gradient(180deg, #4f46e5 0%, #c7d2fe 100%);
        opacity: 0.6;
    }
    
    /* Confetti animation for achievements */
    .confetti-animation {
        position: relative;
        overflow: hidden;
    }
    
    .confetti-animation::before {
        content: "";
        position: absolute;
        top: -10px;
        left: 0;
        right: 0;
        height: 10px;
        background-image: 
            radial-gradient(circle, #ff0000 2px, transparent 2px),
            radial-gradient(circle, #00ff00 2px, transparent 2px),
            radial-gradient(circle, #0000ff 2px, transparent 2px),
            radial-gradient(circle, #ffff00 2px, transparent 2px);
        background-size: 10px 10px;
        animation: confetti-fall 3s linear infinite;
    }
    
    @keyframes confetti-fall {
        0% { transform: translateY(-10px); }
        100% { transform: translateY(300px); }
    }
    
    /* Responsive adjustments for mobile */
    @media (max-width: 640px) {
        .dashboard-grid {
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-container {
            width: 100%;
            position: static;
        }
        
        .content-container {
            margin-left: 0;
        }
    }

    /* Status Badge Styles */
    .status-badge {
        display: inline-flex;
        align-items: center;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .status-badge.pending {
        background: #fef3c7; /* Warm yellow */
        color: #d97706; /* Amber text */
    }

    .status-badge.pending .animate-pulse {
        background: #d97706 !important; /* Match amber text */
    }

    .status-badge.in-progress {
        background: #dbeafe; /* Light blue */
        color: #1e40af; /* Dark blue text */
    }

    .status-badge.in-progress .animate-pulse {
        background: #1e40af !important; /* Match dark blue text */
    }

    .status-badge.completed {
        background: #d1fae5; /* Light green */
        color: #047857; /* Green text */
    }

    .status-badge.completed .animate-pulse {
        background: #047857 !important; /* Match green text */
    }

    .status-badge.blocked {
        background: #fee2e2; /* Light red */
        color history: #dc2626; /* Red text */
    }

    .status-badge.blocked .animate-pulse {
        background: #dc2626 !important; /* Match red text */
    }

    /* Progress Bar Animation */
    .progress-bar {
        position: relative;
        overflow: hidden;
    }

    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.2), transparent);
        animation: progress-shine 2s infinite;
    }

    @keyframes progress-shine {
        100% { left: 100%; }
    }

    /* Hide default scrollbar and customize slider */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }

    /* Ensure smooth scrolling */
    #taskSlider {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    /* Position and style navigation arrows */
    #prevTask, #nextTask {
        display: none; /* Hidden by default, shown with JavaScript */
    }

    @media (min-width: 640px) {
        #prevTask, #nextTask {
            display: block;
        }
    }

    /* Override opacity for disabled state */
    #prevTask:disabled, #nextTask:disabled {
        background-color: #4f46e5 !important;
        opacity: 0.5;
    }

    /* Ensure SVG stroke color remains white even when disabled */
    #prevTask svg, #nextTask svg {
        stroke: white;
    }

    /* Optional: Add spacing and snap points for better alignment */
    .snap-center {
        scroll-snap-align: center;
    }
</style>
@endpush