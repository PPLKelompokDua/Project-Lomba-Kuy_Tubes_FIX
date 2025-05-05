@extends('layouts.app')

@section('title', 'Dashboard LombaKuy')

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
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 drop-shadow-md">Selamat datang, {{ auth()->user()->name }}!</h1>
                        <p class="text-indigo-100 text-lg mb-6">Mari tingkatkan potensimu dengan mengikuti kompetisi yang sesuai.</p>
                                                                      
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('explore') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 font-semibold rounded-lg px-5 py-3 transition shadow-lg flex items-center group">
                                <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Lomba
                            </a>
                            <a href="#" class="bg-indigo-500 bg-opacity-30 hover:bg-opacity-40 text-white font-semibold rounded-lg px-5 py-3 transition flex items-center border border-indigo-300 border-opacity-40 group">
                                <svg class="w-5 h-5 mr-2 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Cari Teman Lomba
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:block relative">
                    <!-- Spotlight effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-transparent opacity-20 rounded-full blur-3xl"></div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Lomba Aktif Card -->
                        <div class="bg-white bg-opacity-15 backdrop-filter backdrop-blur-md p-5 rounded-xl border border-white border-opacity-20 transform transition-all hover:scale-105 shadow-lg relative group overflow-hidden">
                            <!-- Decorative pattern inside card -->
                            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-white bg-opacity-20 rounded-full"></div>
                            
                            <div class="flex items-center space-x-3 mb-2 relative">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg shadow-inner">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-800 font-medium">Status Lomba</span>
                                
                                <!-- Glow effect on hover -->
                                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-blue-600 to-purple-600 opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></div>
                            </div>
                            <div class="flex justify-between relative">
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800">{{ $activeCompetitions ?? 0 }}</h4>
                                    <p class="text-xs text-gray-600">Lomba Aktif</p>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800">{{ $completedCompetitions ?? 0 }}</h4>
                                    <p class="text-xs text-gray-600">Selesai</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Lomba Tersimpan Card -->
                        <div class="bg-white bg-opacity-15 backdrop-filter backdrop-blur-md p-5 rounded-xl border border-white border-opacity-20 transform transition-all hover:scale-105 shadow-lg relative group overflow-hidden">
                            <!-- Decorative pattern inside card -->
                            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-white bg-opacity-20 rounded-full"></div>
                            
                            <div class="flex items-center space-x-3 mb-2 relative">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg shadow-inner">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-800 font-medium">Lomba Tersimpan</span>
                                
                                <!-- Glow effect on hover -->
                                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></div>
                            </div>
                            <div class="flex items-end justify-between">
                                <h4 class="text-3xl font-bold text-gray-800">{{ $savedCompetitions ?? 0 }}</h4>
                                <a href="{{ route('competitions.saved') }}" class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline group-hover:text-indigo-800 transition-colors">Lihat Semua</a>
                            </div>
                        </div>
                        
                        <!-- Upcoming Events Timeline -->
                        <div class="col-span-2 mt-4 bg-white bg-opacity-15 backdrop-filter backdrop-blur-md rounded-xl border border-white border-opacity-20 p-5 transform transition-all hover:scale-102 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-gray-800 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Jadwal Mendatang
                                </h3>
                                <span class="text-xs px-2 py-1 bg-indigo-700 bg-opacity-50 rounded-full text-white">3 Acara</span>
                            </div>
                            
                            <!-- Timeline -->
                            <div class="space-y-3">
                                <!-- Timeline Item 1 -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                    <div class="text-xs bg-white bg-opacity-10 px-3 py-1 rounded-md text-gray-800 flex-grow flex justify-between">
                                        <span>3 Mei</span>
                                        <span class="font-medium">Submit Proposal</span>
                                    </div>
                                </div>
                                
                                <!-- Timeline Item 2 -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="text-xs bg-white bg-opacity-10 px-3 py-1 rounded-md text-gray-800 flex-grow flex justify-between">
                                        <span>10 Mei</span>
                                        <span class="font-medium">Presentasi Final</span>
                                    </div>
                                </div>
                                
                                <!-- Timeline Item 3 -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="text-xs bg-white bg-opacity-10 px-3 py-1 rounded-md text-gray-800 flex-grow flex justify-between">
                                        <span>15 Mei</span>
                                        <span class="font-medium">Deadline UI/UX Challenge</span>
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
                    <h2 class="text-2xl font-bold text-gray-800">Lomba Rekomendasi</h2>
                    <a href="{{ route('explore') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold">
                        Lihat Semua
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
                                            title="Lihat Poster">
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
                                            <button class="bg-white p-2 rounded-full shadow hover:bg-red-100 transition transform hover:scale-110" title="Hapus Bookmark">
                                                <i class="fas fa-bookmark text-red-500"></i>
                                            </button>
                                        @else
                                            <button class="bg-white p-2 rounded-full shadow hover:bg-indigo-100 transition transform hover:scale-110" title="Simpan Bookmark">
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
                                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 hover:text-indigo-600 transition">{{ $competition->title ?? 'Judul Kompetisi' }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit($competition->description ?? 'Deskripsi kompetisi.', 100) }}</p>
                                
                                <!-- Prize and Deadline -->
                                <div class="space-y-4 mb-5">
                                    <!-- Prize -->
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-gift text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Total Hadiah</p>
                                            <p class="font-bold text-gray-800">{{ $competition->prize ?? 'Belum ditentukan' }}</p>
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
                                    <a href="{{ route('competitions.show', $competition->id) }}" class="block w-full bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-indigo-700 transition text-center transform hover:scale-105">
                                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-indigo-50 rounded-xl p-8 text-center" data-aos="fade-up">
                            <svg class="w-16 h-16 text-indigo-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada kompetisi</h3>
                            <p class="text-gray-600">Kompetisi akan segera ditampilkan di sini.</p>
                            <a href="{{ route('explore') }}" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg px-5 py-2.5">
                                Temukan Kompetisi
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Current Competition Progress -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h2 class="text-lg font-bold text-gray-800">Progres Kompetisi Aktif</h2>
                </div>
                
                @if(isset($activeCompetitions) && $activeCompetitions > 0)
                <div class="divide-y divide-gray-100">
                    <!-- Sample Active Competition 1 -->
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-semibold text-gray-800">UI/UX Design Competition 2025</h3>
                                <p class="text-sm text-gray-500">Deadline: 30 Mei 2025</p>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">On Going</span>
                        </div>
                        <div class="mt-3">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>65%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <img class="w-7 h-7 rounded-full border-2 border-white" src="/api/placeholder/30/30" alt="Team member">
                                <img class="w-7 h-7 rounded-full border-2 border-white" src="/api/placeholder/30/30" alt="Team member">
                                <img class="w-7 h-7 rounded-full border-2 border-white" src="/api/placeholder/30/30" alt="Team member">
                            </div>
                            <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Detail →</a>
                        </div>
                    </div>
                    
                    <!-- Sample Active Competition 2 -->
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-semibold text-gray-800">Hackathon Nasional Tel-U</h3>
                                <p class="text-sm text-gray-500">Deadline: 15 Juni 2025</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Baru Daftar</span>
                        </div>
                        <div class="mt-3">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>20%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 20%"></div>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <img class="w-7 h-7 rounded-full border-2 border-white" src="/api/placeholder/30/30" alt="Team member">
                                <img class="w-7 h-7 rounded-full border-2 border-white" src="/api/placeholder/30/30" alt="Team member">
                            </div>
                            <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Detail →</a>
                        </div>
                    </div>
                </div>
                @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-gray-700 font-medium mb-1">Belum Ada Lomba Aktif</h3>
                    <p class="text-gray-500 text-sm mb-4">Kamu belum mengikuti kompetisi apapun.</p>
                    <a href="{{ route('explore') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Jelajahi Kompetisi →
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
                        <p class="text-xs text-gray-600">Lomba Selesai</p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-3">
                        <h4 class="text-xl font-bold text-indigo-600">{{ $achievements ?? 0 }}</h4>
                        <p class="text-xs text-gray-600">Pencapaian</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('profile.show') }}" class="block text-center bg-white border border-indigo-600 hover:bg-indigo-50 text-indigo-600 font-medium rounded-lg py-2 transition">
                        Lihat Profil
                    </a>
                </div>
            </div>
            
            <!-- Quick Access Features -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Akses Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Tes Kecocokan</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Tim Saya</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Undangan</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center bg-indigo-50 hover:bg-indigo-100 rounded-lg p-4 transition">
                        <svg class="w-6 h-6 text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Notifikasi</span>
                    </a>
                </div>
            </div>
            
            <!-- Educational Resources -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Video & Tips Kompetisi</h3>
                    <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800">Lihat Semua</a>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Video Resource 1 -->
                    <div class="flex space-x-3">
                        <div class="flex-shrink-0 w-20 h-20 bg-indigo-100 rounded-lg overflow-hidden">
                            <img src="/api/placeholder/80/80" class="w-full h-full object-cover" alt="Video thumbnail">
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800 text-sm">Tips Presentasi Kompetisi yang Menarik</h4>
                            <p class="text-xs text-gray-500 mt-1">Pelajari cara menyampaikan ide dengan menarik dan persuasif</p>
                            <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800 mt-2 inline-block">Tonton Video</a>
                        </div>
                    </div>
                    
                    <!-- Video Resource 2 -->
                    <div class="flex space-x-3">
                        <div class="flex-shrink-0 w-20 h-20 bg-indigo-100 rounded-lg overflow-hidden">
                            <img src="/api/placeholder/80/80" class="w-full h-full object-cover" alt="Video thumbnail">
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800 text-sm">Strategi Memenangkan Hackathon</h4>
                            <p class="text-xs text-gray-500 mt-1">Guide lengkap persiapan dan eksekusi dalam kompetisi coding</p>
                            <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800 mt-2 inline-block">Tonton Video</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Winning Stories -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl shadow-lg text-white p-6">
                <h3 class="font-bold text-xl mb-4">Cerita Sukses</h3>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-4 mb-4">
                    <p class="italic text-sm mb-3">"Berkat fitur manajemen tim dan timeline di LombaKuy, tim kami berhasil menjuarai kompetisi desain UI/UX tingkat nasional!"</p>
                    <div class="flex items-center">
                        <img src="/api/placeholder/32/32" class="w-8 h-8 rounded-full mr-2" alt="User avatar">
                        <div class="text-xs">
                            <p class="font-semibold">Anita Wijaya</p>
                            <p class="opacity-80">Desain Komunikasi Visual</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="text-center block bg-white text-indigo-600 font-medium text-sm rounded-lg py-2 hover:bg-opacity-90 transition">
                    Baca Cerita Lainnya
                </a>
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
                <button type="button" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition" onclick="closePreviewModal()">Tutup</button>
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
@endpush