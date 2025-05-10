@extends('layouts.app')

@section('title', 'Find Team Members')

@section('content')
<!-- Breadcrumb Navigation -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-6">
    <nav class="text-sm text-gray-600" aria-label="breadcrumb">
        <ol class="flex space-x-2">
            <li>
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li>
                <a href="{{ route('explore') }}" class="text-indigo-600 hover:underline">Explore</a>
                <span class="mx-2">/</span>
            </li>
            <li>
                <a href="{{ route('competitions.show', $competition->id) }}" class="text-indigo-600 hover:underline">{{ Str::limit($competition->title, 30) }}</a>
                <span class="mx-2">/</span>
            </li>
            <li class="text-gray-500">Find Team Members</li>
        </ol>
    </nav>
</div>
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-800 to-indigo-600 text-white rounded-xl shadow-xl mb-8 overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col space-y-4">
            <a href="{{ route('competitions.show', $competition->id) }}"
               class="inline-flex items-center text-indigo-100 hover:text-white transition duration-150 ease-in-out group w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-150"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to competition
            </a>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-bold">Find Team Members</h1>
                    <p class="text-indigo-100">For {{ $competition->title }}</p>
                </div>
                <div class="shrink-0 flex flex-col md:flex-row gap-3">
                    <a href="{{ route('profile.edit') }}#competition-experience"
                       class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-full shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-1 transition-all duration-150">
                        <i class="bi bi-trophy mr-2"></i> Add Your Experience
                    </a>
                    <a href="{{ route('competitions.random-members', $competition->id) }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-full shadow-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-1 transition-all duration-150">
                        <i class="bi bi-shuffle mr-2"></i> Refresh List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-10">
    <!-- Category Filter -->
    <div class="bg-white rounded-xl shadow-md mb-8 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Filter by Competition Category</h2>
                    <p class="text-gray-600 text-sm">Find team members with experience in specific categories</p>
                </div>
                
                <div class="sm:flex-shrink-0">
                    <form action="{{ route('competitions.random-members', $competition->id) }}" method="GET" class="flex items-center space-x-2">
                        <select name="category" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                            <option value="">All Categories</option>
                            <option value="Desain" {{ request('category') == 'Desain' ? 'selected' : '' }}>Desain</option>
                            <option value="Teknologi" {{ request('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                            <option value="Musik" {{ request('category') == 'Musik' ? 'selected' : '' }}>Musik</option>
                            <option value="Olahraga" {{ request('category') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                            <option value="Pendidikan" {{ request('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="bi bi-filter mr-2"></i> Filter
                        </button>
                    </form>
                </div>
            </div>
            
            @if(request('category'))
            <div class="mt-4 p-3 bg-indigo-50 border border-indigo-100 rounded-lg">
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left text-indigo-700 gap-2">
                    <div class="flex items-center">
                        <i class="bi bi-filter-circle-fill mr-2 text-lg"></i>
                        <span class="text-sm">Showing members with <span class="font-semibold">{{ request('category') }}</span> experience</span>
                    </div>
                    <a href="{{ route('competitions.random-members', $competition->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        <i class="bi bi-x-circle mr-1"></i> Clear
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Team Formation Info Section -->
    <div class="bg-white rounded-xl shadow-md mb-8 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4 mb-6">
                <div class="flex-shrink-0 w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center">
                    <i class="bi bi-info-circle text-indigo-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Building Your Team</h2>
                    <p class="text-gray-600 mb-4">
                        We've selected potential team members for "{{ $competition->title }}" based on interests and experience.
                        These are randomly selected users who might be interested in joining your team.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-start space-x-2">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="bi bi-envelope-paper text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Send invitations</p>
                                <p class="text-gray-500">Contact potential teammates directly</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-2">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="bi bi-people text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Form your team</p>
                                <p class="text-gray-500">Create a balanced team with diverse skills</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-2">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="bi bi-trophy text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Win together</p>
                                <p class="text-gray-500">Collaborate effectively for success</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Potential Team Members Section -->
    @php
        if(request('category')) {
            $filteredUsers = $randomUsers->filter(function($user) {
                if(!empty($user->experience) && is_array($user->experience)) {
                    return in_array(request('category'), $user->experience);
                }
                return false;
            });
        } else {
            $filteredUsers = $randomUsers;
        }
    @endphp
    
    @if(count($filteredUsers) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach($filteredUsers as $user)
            @php
                $firstName = strtok($user->name, ' ') ?: $user->name;
                $hasRequestedCategory = request('category') && !empty($user->experience) && is_array($user->experience) && in_array(request('category'), $user->experience);
            @endphp
            <div class="{{ $hasRequestedCategory ? 'bg-green-50 ring-2 ring-green-500' : 'bg-white' }} rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
                @if($hasRequestedCategory)
                <div class="bg-green-600 px-3 py-1 text-white text-xs font-medium">
                    <div class="flex items-center justify-between">
                        <span>Recommended Match</span>
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-500 font-bold text-xl mr-4">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg truncate">{{ $user->name }}</h3>
                            <p class="text-gray-500 text-sm">Member since {{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4 mt-2">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Competition Experience</h4>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if(!empty($user->experience) && is_array($user->experience))
                                @foreach($user->experience as $exp)
                                    <span class="inline-flex analis-center px-2.5 py-0.5 rounded text-xs font-medium {{ $exp == request('category') ? 'bg-green-100 text-green-800 ring-2 ring-green-500' : 'bg-indigo-100 text-indigo-800' }}">
                                        @if($exp == request('category'))
                                            <i class="bi bi-star-fill mr-1 text-green-600"></i>
                                        @endif
                                        {{ $exp }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-400 text-sm italic">No competition experience added</span>
                            @endif
                        </div>
                    </div>

                    <!-- Added User Information -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-gray-500">
                            <i class="bi bi-envelope mr-2"></i>
                            <span class="text-sm">{{ $user->email }}</span>
                        </div>
                        @if($user->description)
                            <div class="flex items-center text-gray-600 text-sm">
                                <i class="bi bi-person-lines-fill mr-2"></i>
                                {{ Str::limit($user->description, 100) }}
                            </div>
                        @endif
                        @if($user->achievements)
                            <div class="flex items-center text-gray-600 text-sm">
                                <i class="bi bi-trophy-fill mr-2"></i>
                                {{ Str::limit($user->achievements, 80) }}
                            </div>
                        @endif
                    </div>

                    <div class="space-y-3">
                            <button
                                onclick="showInviteModal({{ $user->id }})"
                                class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                                <i class="bi bi-person-plus-fill mr-2"></i> Invite {{ $firstName }}
                            </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="text-center my-10">
        <p class="text-gray-500 mb-4">Not finding the right match? Try again for a different set of potential teammates.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:-translate-y-1">
                <i class="bi bi-shuffle mr-2"></i> Find More Team Members
            </a>
            <a href="{{ route('assessment.index', $competition->id) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform transition-all duration-200 hover:-translate-y-1">
                <i class="bi bi-clipboard-check mr-2"></i> Find by Assessment
            </a>
        </div>
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-xl shadow-md mb-10">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
            <i class="bi bi-people text-gray-500 text-2xl"></i>
        </div>
        @if(request('category'))
            <h2 class="text-xl font-medium text-gray-900 mb-2">No Members Found With {{ request('category') }} Experience</h2>
            <p class="text-gray-500 max-w-md mx-auto mb-6">We couldn't find any team members with experience in {{ request('category') }}. Try a different category or clear the filter.</p>
            <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="bi bi-x-circle mr-2"></i> Clear Filter
            </a>
        @else
            <h2 class="text-xl font-medium text-gray-900 mb-2">No Team Members Found</h2>
            <p class="text-gray-500 max-w-md mx-auto mb-6">We couldn't find any team members at the moment. Please try again later.</p>
            <a href="{{ route('competitions.random-members', $competition->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="bi bi-arrow-repeat mr-2"></i> Refresh
            </a>
        @endif
    </div>
    @endif
    
    <!-- Team Building Tips Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
        <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
            <div class="p-6">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                    <i class="bi bi-people-fill text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Diverse Skills</h3>
                <p class="text-gray-600">Look for team members with complementary skills. A diverse team has better problem-solving capabilities.</p>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
            <div class="p-6">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mb-4">
                    <i class="bi bi-chat-dots-fill text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Communication</h3>
                <p class="text-gray-600">Establish clear communication channels from the start. Regular check-ins help keep everyone aligned.</p>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg">
            <div class="p-6">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                    <i class="bi bi-calendar-check-fill text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Set Clear Goals</h3>
                <p class="text-gray-600">Define roles and responsibilities early. Create a shared timeline with milestones for your competition project.</p>
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
@endsection

<script>
    function showInviteModal(userId) {
        const modal = document.getElementById('inviteModal');
        const createTeamLink = document.getElementById('createTeamLink');
        const sendInviteLink = document.getElementById('sendInviteLink');

        // Update href sesuai dengan user yang dipilih
        const competitionId = "{{ $competition->id }}";
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
