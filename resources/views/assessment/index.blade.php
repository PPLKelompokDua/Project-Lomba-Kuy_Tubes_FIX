@extends('layouts.app')

@section('content')
<div class="flex-grow container mx-auto px-6 py-10">
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-indigo-600 h-16 flex items-center px-8">
                <h1 class="text-2xl font-bold text-white">Personality Assessment</h1>
            </div>
            <div class="p-8">
                <p class="text-gray-600 mb-6">Understand your personality better and discover the most suitable role for your ideal team.</p>
                
                <!-- Tombol Mulai Tes -->
                <a href="{{ route('assessment.form') }}" class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Start Personality Test
                </a>

                <!-- Notifikasi Sukses -->
                @if(session('success'))
                    <div class="mt-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Hasil Terakhir -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h2 class="text-xl font-semibold text-white">Latest Result</h2>
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
                                        <img src="{{ $img }}" alt="Ilustrasi Kepribadian" class="w-32 h-32 object-cover rounded-full border-4 border-indigo-100 shadow-md z-10 relative">
                                    </div>
                                @endif
                                
                                <div class="text-center">
                                    <div class="inline-block bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full font-semibold mb-2">
                                        {{ Auth::user()->personality_type }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-xl p-4 shadow-inner">
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
                        <div class="flex items-center bg-yellow-50 text-yellow-800 p-4 rounded-lg border-l-4 border-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>You haven’t completed an assessment yet. Please click the button above to start the personality test.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Assessment -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4 flex items-center">
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
                        <div class="flex items-center bg-blue-50 text-blue-700 p-4 rounded-lg border-l-4 border-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>No assessment history available yet.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Hasil Rekomendasi Tim -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <h2 class="text-xl font-semibold text-white">Team Recommendation Result</h2>
            </div>
            <div class="p-6">
                @if(isset($latestAssessment) && $latestAssessment)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 mb-2">Recommended Role</h3>
                                <div class="inline-flex items-center bg-green-100 text-green-800 px-4 py-2 rounded-lg font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $latestAssessment->recommended_role ?? '-' }}
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Compatibility Score</h4>
                                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-4 rounded-full text-xs text-white flex items-center justify-center"
                                        style="width: {{ $latestAssessment->compatibility_score ?? 0 }}%">
                                        {{ $latestAssessment->compatibility_score ?? 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                                <h4 class="font-medium text-green-700 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    Strengths
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    {{ $latestAssessment->strengths ?? 'Tidak tersedia' }}
                                </p>
                            </div>
                            <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                                <h4 class="font-medium text-red-700 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    Weaknesses
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    {{ $latestAssessment->weaknesses ?? 'Tidak tersedia' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Rekomendasi Anggota Berdasarkan Assessment -->
                    <div class="mt-8">
                        <h3 class="text-center text-xl font-bold mb-6 text-indigo-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recommendedUsers as $user)
                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-full bg-indigo-600 text-white flex items-center justify-center text-2xl font-bold mb-4">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <h6 class="font-semibold text-indigo-700 text-lg">{{ $user->name }}</h6>
                                            <p class="text-sm text-gray-500 mb-3">{{ $user->email }}</p>
                                            
                                            <div class="flex flex-wrap gap-2 justify-center mb-4">
                                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    {{ $user->personality_type }}
                                                </span>
                                                <span class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    {{ $user->preferred_role }}
                                                </span>
                                            </div>
                                            
                                            @if($user->description)
                                                <p class="text-sm text-gray-600 text-center mb-4">
                                                    {{ \Illuminate\Support\Str::limit($user->description, 100) }}
                                                </p>
                                            @endif
                                            
                                            @php
                                                $firstName = explode(' ', $user->name)[0];
                                            @endphp
                                            <button type="button"
                                                onclick="showInviteModal({{ $user->id }})"
                                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                </svg>
                                                Invite {{ $firstName }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-blue-50 text-blue-700 p-4 rounded-lg text-center border border-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="font-medium">Belum ada calon anggota yang tersedia.</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex items-center justify-center bg-yellow-50 text-yellow-800 p-8 rounded-lg border border-yellow-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-lg">Data rekomendasi tidak ditemukan. Silakan selesaikan assessment terlebih dahulu.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Invitation Confirmation Modal -->
    <div id="inviteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-md w-full mx-4 shadow-xl p-6 border-t-4 border-indigo-600">
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
        width: 8px;
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