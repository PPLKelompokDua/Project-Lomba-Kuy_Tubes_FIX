@extends('layouts.app')

@section('title', 'My Teams')

@section('content')
<div class="container-fluid py-5 px-md-5">
    <!-- Header Section with Gradient Background -->
    <div class="position-relative mb-5">
        <div class="bg-gradient-to-r p-4 rounded-lg shadow-lg" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-0 font-bold text-white text-4xl">My Teams & Competitions Portfolio</h2>
                    <p class="text-blue-100 mb-3 opacity-80">Collaborate, compete, and succeed together</p>
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 px-3 py-2 rounded-pill d-inline-flex align-items-center">
                            <i class="fas fa-users me-2 text-white"></i>
                            <span class="text-white fw-medium">Total Teams: {{ $totalTeams }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('teams.create') }}" class="btn px-4 py-2 btn-light shadow-sm fw-medium rounded-pill">
                        <i class="fas fa-plus-circle me-2 text-primary" style="color: #4f46e5 !important;"></i>Create New Team
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Abstract Shape Decorations -->
        <div class="position-absolute" style="top: -15px; right: 20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); z-index: 0;"></div>
        <div class="position-absolute" style="bottom: -10px; left: 10%; width: 40px; height: 40px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); z-index: 0;"></div>
        <div class="position-absolute" style="top: 30px; left: 25%; width: 15px; height: 15px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); z-index: 0;"></div>
    </div>

    <!-- Quick Filters -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div class="d-flex gap-2 mb-3 mb-md-0 flex-wrap">
            <a href="{{ route('teams.index') }}" class="btn btn-sm px-3 py-2 {{ request('status') === null ? 'active' : '' }}" 
                style="{{ request('status') === null ? 'background-color: #4f46e5; color: white;' : 'background-color: #f3f4f6; color: #4b5563;' }} border-radius: 20px;">
                All Teams
                </a>

            <a href="{{ route('teams.index', ['status' => 'ongoing']) }}" class="btn btn-sm px-3 py-2 {{ request('status') === 'ongoing' ? 'active' : '' }}" 
                style="{{ request('status') === 'ongoing' ? 'background-color: #4f46e5; color: white;' : 'background-color: #f3f4f6; color: #4b5563;' }} border-radius: 20px;">
                Active
                </a>
            <a href="{{ route('teams.index', ['status' => 'finished']) }}" class="btn btn-sm px-3 py-2 {{ request('status') === 'finished' ? 'active' : '' }}" 
                style="{{ request('status') === 'finished' ? 'background-color: #4f46e5; color: white;' : 'background-color: #f3f4f6; color: #4b5563;' }} border-radius: 20px;">
                Finished
                </a>
        </div>
        <div class="position-relative">
        <form method="GET" action="{{ route('teams.index') }}" class="position-relative">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                class="form-control ps-4" 
                placeholder="Search teams..." 
                style="border-radius: 20px; padding-right: 40px;">
            
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <i class="fas fa-search position-absolute" style="top: 50%; right: 15px; transform: translateY(-50%); color: #9ca3af;"></i>
        </form>
        </div>
    </div>

    @if($teams->isEmpty())
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 bg-gradient-to-br p-5 d-flex align-items-center justify-content-center" style="background: linear-gradient(145deg, #eef2ff 0%, #e0e7ff 100%);">
                        <img src="https://via.placeholder.com/400x300" alt="Teams illustration" class="img-fluid" style="max-width: 250px;">
                    </div>
                    <div class="col-md-7 p-5 d-flex flex-column justify-content-center">
                        <div class="bg-light d-inline-block px-3 py-1 rounded-pill mb-3" style="color: #4f46e5;">
                            <i class="fas fa-info-circle me-1"></i> No Teams
                        </div>
                        <h3 class="fw-bold mb-3">You haven't created any teams yet</h3>
                        <p class="text-muted mb-4">Create your first team to start collaborating with others on competitions and projects.</p>
                        <div>
                            <a href="{{ route('teams.create') }}" class="btn px-4 py-2 shadow-sm" style="background-color: #4f46e5; color: white; border-radius: 8px;">
                                <i class="fas fa-plus-circle me-2"></i>Create Your First Team
                            </a>
                            <a href="{{ route('explore') }}" class="btn btn-link ms-2" style="color: #4f46e5;">Looking An Competitions? Explore Catalog</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($teams as $team)
                <div class="col-xl-6 mb-4">
                    <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden team-card position-relative">
                        <!-- Status Indicator -->
                        <div class="position-absolute" style="top: 20px; right: 20px; z-index: 5;">
                            <div class="px-3 py-2 rounded-pill" 
                                style="background-color: {{ $team->status_team === 'finished' ? '#f3f4f6' : '#dcfce7' }}; 
                                      color: {{ $team->status_team === 'finished' ? '#6b7280' : '#166534' }};">
                                <i class="fas {{ $team->status_team === 'finished' ? 'fa-flag-checkered' : 'fa-spinner fa-spin' }} me-1"></i>
                                {{ ucfirst($team->status_team) }}
                            </div>
                        </div>
                        
                        <!-- Color Accent Line -->
                        <div class="position-absolute" style="top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #4f46e5, #6366f1);"></div>
                        
                        <div class="card-body d-flex flex-column justify-content-between p-0">
                            <div>
                                <!-- Team Header with Gradient Background -->
                                <div class="p-4 pb-3" style="background-color: #f9fafb;">
                                    <div class="d-flex align-items-center">
                                        <div class="team-avatar me-3 shadow-sm" style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(145deg, #4f46e5, #6366f1); display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white fw-bold fs-4">{{ substr($team->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="card-title mb-1 fw-bold">{{ $team->name }}</h4>
                                            <div class="d-flex align-items-center">
                                                <span class="badge rounded-pill bg-light text-dark me-2 d-flex align-items-center gap-1 px-2">
                                                    <i class="fas fa-user" style="color: #4f46e5;"></i> 
                                                    You are {{ $team->leader_id === $user->id ? 'Leader' : 'Member' }}
                                                </span>
                                                <span class="small text-muted">ID: #{{ $team->id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Team Details -->
                                <div class="p-4 pt-3">
                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-6">
                                            <div class="p-3 rounded-3 h-100" style="background-color: #f3f4f6;">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle p-2 me-3" style="background-color: #e0e7ff;">
                                                        <i class="fas fa-trophy" style="color: #4f46e5;"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Competition</small>
                                                        <span class="fw-medium">{{ $team->competition_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 rounded-3 h-100" style="background-color: #f3f4f6;">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle p-2 me-3" style="background-color: #e0e7ff;">
                                                        <i class="fas fa-users" style="color: #4f46e5;"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Members</small>
                                                        <span class="fw-medium">{{ $team->acceptedMembers->count() + 1 }} People</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Member Avatars -->
                                    <div class="mt-3 mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <div class="avatar-stack d-flex">
                                                <!-- Leader -->
                                                @php
                                                    $leader = $team->leader;
                                                @endphp

                                                @if($leader->profile_image)
                                                    <img 
                                                        src="{{ asset('storage/images/' . $leader->profile_image) }}" 
                                                        alt="{{ $leader->name }}" 
                                                        class="avatar-circle" 
                                                        style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid white; z-index: 3;">
                                                @else
                                                    <div class="avatar-circle" 
                                                        style="background-color: #4f46e5; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; z-index: 3;">
                                                        {{ strtoupper(substr($leader->name, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <!-- Members -->
                                                @for($i = 0; $i < min(3, $team->acceptedMembers->count()); $i++)
                                                    @php
                                                        $member = $team->acceptedMembers[$i];
                                                    @endphp

                                                    @if($member->profile_image)
                                                        <img 
                                                            src="{{ asset('storage/images/' . $member->profile_image) }}" 
                                                            alt="{{ $member->name }}" 
                                                            class="avatar-circle" 
                                                            style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid white; margin-left: -12px; z-index: {{ 2 - $i }};">
                                                    @else
                                                        <div class="avatar-circle" 
                                                            style="background-color: #a5b4fc; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; margin-left: -12px; z-index: {{ 2 - $i }};">
                                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                @endfor

                                                @if($team->acceptedMembers->count() > 3)
                                                    <div class="avatar-circle" style="background-color: #e0e7ff; color: #4f46e5; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; margin-left: -12px; z-index: 0;">
                                                        +{{ $team->acceptedMembers->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                            <small class="text-muted ms-2">Team members</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions Footer -->
                            <div class="p-4 pt-0">
                                <hr class="my-3">
                                <div class="d-flex flex-wrap gap-2 justify-content-between">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('teams.show', $team->id) }}" class="btn btn-sm px-3 py-2" 
                                           style="background-color: #4f46e5; color: white; border-radius: 8px;">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </a>

                                        @if($team->status_team !== 'finished')
                                        <a href="{{ route('tasks.team', $team->id) }}" class="btn btn-sm px-3 py-2"
                                            style="background-color: #10b981; color: white; border-radius: 8px;">
                                             <i class="fas fa-tasks me-1"></i> Manage Tasks
                                        </a>
                                        @endif
                                        
                                        @if($team->leader_id === $user->id && $team->status_team !== 'finished')
                                            <a href="{{ route('invitations.index', ['team_id' => $team->id]) }}" class="btn btn-sm px-3 py-2" 
                                               style="background-color: #047857; color: white; border-radius: 8px;">
                                                <i class="fas fa-user-plus me-1"></i> Invitations
                                            </a>
                                        @endif
                                        @if($team->status_team === 'finished')
                                            <a href="{{ route('feedbacks.index') }}" class="btn btn-sm px-3 py-2" 
                                            style="background-color: #f59e0b; color: white; border-radius: 8px;">
                                                <i class="fas fa-comment-alt me-1"></i> Feedback
                                            </a>
                                        @endif
                                    </div>
                                    
                                    @if($team->leader_id === $user->id)
                                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this team?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm px-3 py-2" 
                                                    style="background-color: #f9fafb; color: #b91c1c; border: 1px solid #fee2e2; border-radius: 8px;">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $teams->links('vendor.pagination.custom') }} {{-- atau default Tailwind: links() --}}
        </div>
    @endif
</div>

<style>
    /* General Styles */
    body {
        background-color: #f9fafb;
    }
    
    /* Card Hover Effects */
    .team-card {
        transition: all 0.3s ease;
        border-bottom: 5px solid transparent;
    }
    
    .team-card:hover {
        transform: translateY(-8px);
        border-bottom: 5px solid #4f46e5;
    }
    
    /* Button Hover Effects */
    .btn {
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }
    
    /* Status Animation */
    @keyframes pulse {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }
    
    .fa-spinner {
        animation: pulse 1.5s infinite;
    }
    
    /* Custom Theme Colors */
    .bg-gradient-to-r {
        border-radius: 16px;
    }
    
    .bg-gradient-to-br {
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }
    
    .text-blue-100 {
        color: #dbeafe;
    }
    
    .rounded-4 {
        border-radius: 16px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .bg-gradient-to-r {
            padding: 1.5rem;
        }
    }
</style>
@endsection