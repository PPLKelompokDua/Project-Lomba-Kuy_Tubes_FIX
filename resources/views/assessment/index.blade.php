@extends('layouts.app')

@section('title', 'Assessment')

@section('content')
<div class="flex-grow container mx-auto px-4 sm:px-6 py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4">Personality Assessment</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover your unique personality traits and find the perfect team role that matches your strengths.</p>
        </div>

        <!-- Main Assessment Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-10 transform transition-all hover:shadow-2xl">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 h-3"></div>
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-full md:w-1/2">
                        <div class="rounded-xl bg-indigo-50 p-6 border border-indigo-100">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <h2 class="text-2xl font-bold text-gray-800">Understand Your Personality</h2>
                            </div>
                            <p class="text-gray-600 mb-6">Take our comprehensive personality assessment based on the Big Five traits to understand your strengths, preferences, and the ideal team role for you.</p>
                            
                            <a href="{{ route('assessment.form') }}" class="inline-flex items-center justify-center w-full md:w-auto bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow-md hover:shadow-lg transform hover:translate-y-px">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Start Personality Test
                            </a>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 bg-transparent">
                        <img src="{{ asset('storage/bigfive/bigfive.png') }}" alt="Assessment Illustration" class="w-full h-auto rounded-lg shadow-lg bg-transparent" onerror="this.src='/api/placeholder/500/300'; this.onerror=null;">
                    </div>
                </div>

                <!-- Notification Section -->
                @if(session('success'))
                    <div class="mt-8 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-start animate__animated animate__fadeIn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Results Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Latest Result -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all hover:shadow-xl">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 px-6 py-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h2 class="text-xl font-semibold text-white">Your Latest Assessment Result</h2>
                </div>
                <div class="p-6">
                    @if(Auth::user()->personality_type && Auth::user()->preferred_role)
                        <div class="space-y-6">
                            <div class="flex flex-col items-center">
                                @php
                                    $images = [
                                        'Conscientiousness' => asset('storage/bigfive/conscientiousness.jpg'),
                                        'Openness to Experience' => asset('storage/bigfive/openness.jpg'),
                                        'Extraversion' => asset('storage/bigfive/extraversion.jpg'),
                                        'Neuroticism' => asset('storage/bigfive/neuroticism.jpg'),
                                        'Agreeableness' => asset('storage/bigfive/agreeableness.jpg'),
                                    ];
                                    $img = $images[Auth::user()->personality_type] ?? null;
                                @endphp

                                @if($img)
                                    <div class="mb-4 relative">
                                        <div class="absolute inset-0 bg-indigo-600 rounded-full opacity-10"></div>
                                        <img src="{{ $img }}" alt="Personality Illustration" class="w-32 h-32 object-cover rounded-full border-4 border-indigo-100 shadow-md z-10 relative">
                                    </div>
                                @endif
                                
                                <div class="text-center">
                                    <div class="inline-block bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full font-semibold mb-2">
                                        {{ Auth::user()->personality_type }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-xl p-6 shadow-sm border border-gray-100">
                                <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-3">
                                    <span class="text-gray-600 font-medium">Personality Type</span>
                                    <span class="font-semibold text-indigo-700">{{ Auth::user()->personality_type }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">Preferred Role</span>
                                    <span class="font-semibold text-indigo-700">{{ Auth::user()->preferred_role }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center bg-yellow-50 text-yellow-800 p-5 rounded-lg border-l-4 border-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>You haven't completed an assessment yet. Please click the button above to start the personality test.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Assessment History -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all hover:shadow-xl">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 px-6 py-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-white">Assessment History</h2>
                </div>
                <div class="p-6">
                    @if($history->count())
                        <div class="space-y-4 max-h-80 overflow-y-auto pr-2 styled-scrollbar">
                            @foreach($history as $entry)
                                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-400 hover:shadow-md transition-all">
                                    <div class="text-sm text-gray-500 mb-2">
                                        {{ $entry->created_at->format('d M Y • H:i') }}
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-3 py-1 rounded-full">
                                            {{ $entry->personality_type }}
                                        </span>
                                        <span class="bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">
                                            {{ $entry->preferred_role }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center bg-blue-50 text-blue-700 p-5 rounded-lg border-l-4 border-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>No assessment history available yet.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Team Recommendation Result -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12 transform transition-all hover:shadow-2xl">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 px-6 py-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <h2 class="text-xl font-semibold text-white">Team Recommendation Result</h2>
            </div>
            <div class="p-6">
                @if(isset($latestAssessment) && $latestAssessment)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-6">
                            <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                                <h3 class="text-lg font-medium text-gray-800 mb-4">Recommended Role</h3>
                                <div class="inline-flex items-center bg-green-100 text-green-800 px-4 py-2 rounded-lg font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $latestAssessment->recommended_role ?? '-' }}
                                </div>
                                
                                <h4 class="font-medium text-gray-700 mt-6 mb-3">Compatibility Score</h4>
                                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-4 rounded-full text-xs text-white flex items-center justify-center"
                                        style="width: {{ $latestAssessment->compatibility_score ?? 0 }}%">
                                        {{ $latestAssessment->compatibility_score ?? 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-green-50 rounded-xl p-6 border border-green-100">
                                <h4 class="font-medium text-green-700 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    Strengths
                                </h4>
                                <p class="text-gray-600">
                                    {{ $latestAssessment->strengths ?? 'Not available' }}
                                </p>
                            </div>
                            <div class="bg-red-50 rounded-xl p-6 border border-red-100">
                                <h4 class="font-medium text-red-700 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    Weaknesses
                                </h4>
                                <p class="text-gray-600">
                                    {{ $latestAssessment->weaknesses ?? 'Not available' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Team Members Section -->
                    <div class="mt-12">
                        <h3 class="text-center text-2xl font-bold mb-8 text-gray-800 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Recommended Team Members
                        </h3>

                        @php
                            $recommendedUsers = \App\Models\User::where('id', '!=', auth()->id())
                                ->where('role', 'user')
                                ->inRandomOrder()
                                ->limit(6)
                                ->get();
                        @endphp

                        @if($recommendedUsers->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recommendedUsers as $user)
                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all p-6 transform hover:-translate-y-1">
                                        <div class="flex items-center mb-4">
                                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center text-2xl font-bold mr-4 shadow-md">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="font-semibold text-gray-800 text-lg">{{ $user->name }}</h6>
                                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                            
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ $user->personality_type }}
                                            </span>
                                            <span class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ $user->preferred_role }}
                                            </span>
                                        </div>
                                            
                                        @if($user->description)
                                            <p class="text-sm text-gray-600 mb-4 border-t border-gray-100 pt-3">
                                                {{ \Illuminate\Support\Str::limit($user->description, 100) }}
                                            </p>
                                        @endif
                                            
                                        @php
                                            $firstName = explode(' ', $user->name)[0];
                                        @endphp
                                        <button type="button"
                                            onclick="showInviteModal({{ $user->id }})"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                            Invite {{ $firstName }}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-blue-50 text-blue-700 p-8 rounded-lg text-center border border-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="font-medium text-lg">No potential team members available yet.</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex items-center justify-center bg-yellow-50 text-yellow-800 p-8 rounded-lg border border-yellow-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-lg font-medium">Recommendation data not found. Please complete the assessment first.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Invitation Confirmation Modal -->
    <div id="inviteModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-md w-full mx-4 shadow-2xl p-6 border-t-4 border-indigo-600 animate__animated animate__fadeInUp">
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Confirm Invitation
            </h2>
            <p class="text-gray-600 mb-6 pl-8">Do you already have a team for this competition on LombaKuy?</p>
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <button onclick="closeInviteModal()" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <a id="createTeamLink" href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Not Yet, Create Team
                </a>
                <a id="sendInviteLink" href="#" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Already Have, Invite
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .styled-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .styled-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .styled-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }
    
    .styled-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #4f46e5;
    }
    
    /* Animation classes */
    .animate__animated {
        animation-duration: 0.4s;
    }
    
    .animate__fadeIn {
        animation-name: fadeIn;
    }
    
    .animate__fadeInUp {
        animation-name: fadeInUp;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 30px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
</style>

<script>
    function showInviteModal(userId) {
        const modal = document.getElementById('inviteModal');
        const createTeamLink = document.getElementById('createTeamLink');
        const sendInviteLink = document.getElementById('sendInviteLink');

        const competitionId = "{{ request('competition_id') ?? '' }}"; // ubah jika perlu ambil dari $competition->id

        createTeamLink.href = `/teams/create?competition_id=${competitionId}&user_id=${userId}`;
        sendInviteLink.href = `/invitations?competition_id=${competitionId}&user_id=${userId}`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeInviteModal() {
        const modal = document.getElementById('inviteModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection