@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div class="container max-w-6xl mx-auto px-4 py-8">
    <!-- Back button -->
    <div class="mb-6">
        <a href="{{ route('teams.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Back to My Teams
        </a>
    </div>

    <!-- Team header -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $team->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $team->competition_name }}</p>
            </div>
            
            @if($team->leader_id === $user->id)
            <div class="mt-4 md:mt-0">
                <form action="{{ route('teams.updateStatus', $team) }}" method="POST" class="flex flex-wrap items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <label for="status_team" class="font-medium text-gray-700">Team Status:</label>
                    <div class="flex">
                        <select name="status_team" id="status_team" class="rounded-l-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $team->status_team === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700 transition-colors duration-200">
                            Update
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Competition Preview Card -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-5">Competition Preview</h2>
        <div class="space-y-4 text-gray-700">

            <!-- Competition Name -->
            <div class="flex items-start gap-4">
                <div class="text-indigo-600">
                    <i class="fas fa-trophy fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Competition Name</p>
                    <p class="text-base font-semibold text-gray-900">{{ $team->competition->title ?? $team->competition_name }}</p>
                </div>
            </div>

            <!-- Category -->
            <div class="flex items-start gap-4">
                <div class="text-indigo-600">
                    <i class="fas fa-tag fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Category</p>
                    <p class="text-base font-semibold text-gray-900">{{ $team->category ?? '-' }}</p>
                </div>
            </div>

            <!-- Deadline -->
            <div class="flex items-start gap-4">
                <div class="text-indigo-600">
                    <i class="fas fa-calendar-alt fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Deadline</p>
                    <p class="text-base font-semibold text-gray-900">
                        {{ $team->deadline ? \Carbon\Carbon::parse($team->deadline)->format('d F Y') : '-' }}
                    </p>
                </div>
            </div>

            <!-- Location -->
            <div class="flex items-start gap-4">
                <div class="text-indigo-600">
                    <i class="fas fa-map-marker-alt fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Location</p>
                    <p class="text-base font-semibold text-gray-900">{{ $team->location ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>


    <!-- Team Members List -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100">
            <h2 class="text-xl font-semibold text-gray-800">Team Members</h2>
        </div>
        
        <ul class="divide-y divide-gray-200">
            <!-- Leader -->
            <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4 hover:bg-gray-50">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 h-10 w-10">
                        @if ($team->leader->profile_image)
                            <img 
                                src="{{ asset('storage/images/' . $team->leader->profile_image) }}" 
                                alt="{{ $team->leader->name }}" 
                                class="h-10 w-10 rounded-full object-cover border-2 border-indigo-600"
                            >
                        @else
                            <div class="h-10 w-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-medium text-sm">
                                {{ strtoupper(substr($team->leader->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $team->leader->name }}</p>
                        <p class="text-sm text-gray-500">{{ $team->leader->email }}</p>
                    </div>
                </div>
                <div class="mt-2 sm:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                        Leader
                    </span>
                </div>
            </li>

            <!-- Members -->
            @foreach($team->acceptedMembers as $member)
                @if ($member->id !== $team->leader_id)
                <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 h-10 w-10">
                            @if ($member->profile_image)
                                <img 
                                    src="{{ asset('storage/images/' . $member->profile_image) }}" 
                                    alt="{{ $member->name }}" 
                                    class="h-10 w-10 rounded-full object-cover border-2 border-indigo-300"
                                >
                            @else
                                <div class="h-10 w-10 bg-indigo-200 rounded-full flex items-center justify-center text-indigo-800 font-medium text-sm">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $member->name }}</p>
                            <p class="text-sm text-gray-500">{{ $member->email }}</p>
                        </div>
                    </div>
                    <div class="mt-2 sm:mt-0 flex items-center space-x-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Team Member
                        </span>
                        @if ($team->leader_id === $user->id)
                        <form method="POST" action="{{ route('team-members.remove', [$team->id, $member->id]) }}" onsubmit="return confirm('Are you sure you want to remove this member?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium ml-2">
                                Remove
                            </button>
                        </form>
                        @endif
                    </div>
                </li>
                @endif
            @endforeach
        </ul>
        
        <!-- Manage Invitations Button -->
        @if($team->leader_id === $user->id && $team->status_team !== 'finished')
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('invitations.index', ['team_id' => $team->id]) }}" 
               class="inline-flex items-center justify-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                </svg>
                Manage Invitations
            </a>
        </div>
        @endif
    </div>
</div>
@endsection