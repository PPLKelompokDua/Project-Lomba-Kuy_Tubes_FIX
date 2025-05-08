@extends('layouts.app')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 Styling */
    .select2-container .select2-dropdown {
        background-color: white;
        border: 1px solid #ccc;
        z-index: 9999;
    }

    .select2-results__option--highlighted {
        background-color: #4f46e5 !important;
        color: white !important;
    }

    .select2-selection {
        background-color: white !important;
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
    }
    
    /* Pattern background */
    .pattern-bg {
        background-color: #4f46e5;
        background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCI+CjxyZWN0IHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgZmlsbD0ibm9uZSIgLz4KPHBhdGggZD0iTTAgMCAxMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMTAgMCAyMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMjAgMCAzMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMzAgMCA0MCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNNDAgMCA1MCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMCAxMCAxMCAyMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMTAgMTAgMjAgMjAgWiIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIGZpbGw9Im5vbmUiLz4KPHBhdGggZD0iTTIwIDEwIDMwIDIwIFoiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIiBmaWxsPSJub25lIi8+CjxwYXRoIGQ9Ik0zMCAxMCA0MCAyMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNNDAgMTAgNTAgMjAgWiIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIGZpbGw9Im5vbmUiLz4KPC9zdmc+');
        background-position: center;
        background-repeat: repeat;
    }
    
    /* Custom table styles */
    .custom-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .custom-table thead th {
        background-color: #f3f4f6;
        color: #4f46e5;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 12px 16px;
    }
    
    .custom-table tbody tr {
        background-color: white;
        transition: background-color 0.2s;
    }
    
    .custom-table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .custom-table tbody td {
        padding: 12px 16px;
        border-top: 1px solid #f3f4f6;
    }
    
    /* Button styles */
    .btn-primary {
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
    }
    
    .btn-outline {
        background-color: transparent;
        color: #4f46e5;
        border: 1px solid #4f46e5;
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-outline:hover {
        background-color: #4f46e5;
        color: white;
    }
    
    /* Badge styles */
    .badge {
        padding: 4px 8px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .badge-accepted {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .badge-declined {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    /* Card styles */
    .custom-card {
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .card-header-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        padding: 20px;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb with Accent -->
            <div class="mb-4 d-flex align-items-center">
                <a href="{{ route('teams.index') }}" class="btn position-relative overflow-hidden shadow-sm" 
                   style="background-color: #4f46e5; color: white; border-radius: 8px; padding: 10px 20px; z-index: 1;">
                    <div class="position-absolute top-0 start-0 w-100 h-100" 
                         style="background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%); z-index: -1;"></div>
                    <i class="fas fa-arrow-left me-2"></i> Back to My Teams
                </a>
                <nav aria-label="breadcrumb" class="ms-4 flex-grow-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none" style="color: #4f46e5;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teams.index') }}" class="text-decoration-none" style="color: #4f46e5;">Teams</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Invitations</li>
                    </ol>
                </nav>
            </div>
            
            <!-- Main Content Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                <!-- Main Content Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header with Pattern Background -->
                <div class="card-header border-0 py-4" style="background-color: #4f46e5; background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCI+CjxyZWN0IHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgZmlsbD0ibm9uZSIgLz4KPHBhdGggZD0iTTAgMCAxMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMTAgMCAyMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMjAgMCAzMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMzAgMCA0MCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNNDAgMCA1MCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMCAxMCAxMCAyMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMTAgMTAgMjAgMjAgWiIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIGZpbGw9Im5vbmUiLz4KPHBhdGggZD0iTTIwIDEwIDMwIDIwIFoiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIiBmaWxsPSJub25lIi8+CjxwYXRoIGQ9Ik0zMCAxMCA0MCAyMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNNDAgMTAgNTAgMjAgWiIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIGZpbGw9Im5vbmUiLz4KPC9zdmc+'); background-position: center; background-repeat: repeat;">
                    <div class="position-relative z-index-1">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center rounded-circle me-3" 
                                 style="width: 52px; height: 52px; background-color: rgba(255, 255, 255, 0.2);">
                                <i class="fas fa-users fa-lg text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-0 fw-bold">Create New Team</h4>
                                <p class="text-white text-opacity-75 mb-0">Set up your team to start collaborating</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-lg-5 p-4">
                    <!-- Alerts -->
                    @if (session('error'))
                        <div class="alert border-0 rounded-3 mb-4 alert-dismissible fade show" role="alert"
                             style="background-color: #fee2e2; color: #b91c1c;">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-exclamation-circle fa-lg" style="color: #b91c1c;"></i>
                                </div>
                                <div>
                                    <strong>Error!</strong> {{ session('error') }}
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert border-0 rounded-3 mb-4 alert-dismissible fade show" role="alert"
                             style="background-color: #dcfce7; color: #166534;">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-lg" style="color: #166534;"></i>
                                </div>
                                <div>
                                    <strong>Success!</strong> {{ session('success') }}
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Stepper -->
                    <div class="mb-5">
                        <div class="position-relative d-flex justify-content-between align-items-center" 
                             style="max-width: 500px; margin: 0 auto;">
                            <div class="position-absolute" style="top: 50%; height: 2px; left: 40px; right: 40px; background-color: #e5e7eb; z-index: 0;"></div>
                            
                            <div class="d-flex flex-column align-items-center position-relative" style="z-index: 1;">
                                <div class="d-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: #e5e7eb; color: #9ca3af;">
                                    <i class="fas fa-info"></i>
                                </div>
                                <span class="small text-muted">Basic Info</span>
                            </div>
                            
                            <div class="d-flex flex-column align-items-center position-relative" style="z-index: 1;">
                                <div class="d-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: #4f46e5; color: white;">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <span class="small" style="color: #4f46e5; font-weight: 500;">Invite Members</span>
                            </div>
                            
                            <div class="d-flex flex-column align-items-center position-relative" style="z-index: 1;">
                                <div class="d-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: #e5e7eb; color: #9ca3af;">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <span class="small text-muted">Complete</span>
                            </div>
                        </div>
                    </div>

                    <!-- Send Invitation Section -->
                    <div class="custom-card mb-5">
                        <div class="card-header-gradient d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-25 me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-paper-plane text-white"></i>
                            </div>
                            <h5 class="mb-0 text-white">Send New Invitation</h5>
                        </div>
                        <div class="p-4">
                            <form method="POST" action="{{ route('invitations.store') }}" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label for="user_id" class="form-label fw-medium mb-2">
                                        <i class="fas fa-user me-2 text-indigo-600" style="color: #4f46e5;"></i>
                                        Select User
                                    </label>
                                    <select name="user_id" id="user_id" class="form-select" data-placeholder="🔍 Search for a user...">
                                        <option></option> <!-- Placeholder -->
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $defaultUserId ?? '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    @if ($teams->count() === 1)
                                        <input type="hidden" name="team_id" value="{{ $teams->first()->id }}">
                                        <label class="form-label fw-medium mb-2">
                                            <i class="fas fa-users me-2" style="color: #4f46e5;"></i>
                                            Team
                                        </label>
                                        <div class="form-control bg-light" style="height: 42px;">{{ $teams->first()->name }}</div>
                                    @else
                                        <label for="team_id" class="form-label fw-medium mb-2">
                                            <i class="fas fa-users me-2" style="color: #4f46e5;"></i>
                                            Select Team
                                        </label>
                                        <select name="team_id" id="team_id" class="form-select" style="height: 42px;">
                                            <option value="">-- Select Team --</option>
                                            @foreach ($teams as $team)
                                                <option value="{{ $team->id }}" {{ old('team_id', $defaultTeamId) == $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                <div class="col-12 d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i> Send Invitation
                                    </button>
                                    <a href="{{ route('teams.create') }}" class="btn btn-outline">
                                        <i class="fas fa-plus me-2"></i> Invite Members to Your Team
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-pills mb-4" id="invitationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-4 py-2" 
                                    style="color:rgb(0, 0, 0); border-radius: 8px;"
                                    id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent-content" 
                                    type="button" role="tab" aria-controls="sent-content" aria-selected="true">
                                <i class="fas fa-paper-plane me-2"></i> Sent Invitations
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-2" 
                                    style="color:rgb(0, 0, 0); border-radius: 8px;"
                                    id="received-tab" data-bs-toggle="tab" data-bs-target="#received-content" 
                                    type="button" role="tab" aria-controls="received-content" aria-selected="false">
                                <i class="fas fa-inbox me-2"></i> Received Invitations
                            </button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content" id="invitationTabsContent">
                        <!-- Sent Invitations Tab -->
                        <div class="tab-pane fade show active" id="sent-content" role="tabpanel" aria-labelledby="sent-tab">
                            @if ($sentInvitations->count())
                                <div class="table-responsive">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>To</th>
                                                <th>Status</th>
                                                <th>Competition</th>
                                                <th>Team</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sentInvitations as $invitation)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle bg-indigo-100 d-flex align-items-center justify-content-center me-3" 
                                                                 style="width: 36px; height: 36px; background-color: #eef2ff;">
                                                                <i class="fas fa-user" style="color: #4f46e5;"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-medium">{{ $invitation->receiver->name }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($invitation->status === 'pending')
                                                            <span class="badge badge-pending">Pending</span>
                                                        @elseif($invitation->status === 'accepted')
                                                            <span class="badge badge-accepted">Accepted</span>
                                                        @elseif($invitation->status === 'declined')
                                                            <span class="badge badge-declined">Declined</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $invitation->team->competition_name ?? '-' }}</td>
                                                    <td>{{ $invitation->team->name ?? '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('invitations.show', $invitation->id) }}" 
                                                           class="btn btn-sm" style="color: #4f46e5;">
                                                            <i class="fas fa-comments me-1"></i> Messages
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5 my-4 bg-light rounded-3">
                                    <div class="mb-3">
                                        <i class="fas fa-inbox fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No invitations sent yet</h5>
                                    <p class="text-muted">Invite team members to start collaborating</p>
                                </div>
                            @endif
                        </div>

                        <!-- Received Invitations Tab -->
                        <div class="tab-pane fade" id="received-content" role="tabpanel" aria-labelledby="received-tab">
                            @if ($receivedInvitations->count())
                                <div class="table-responsive">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>From</th>
                                                <th>Status</th>
                                                <th>Competition</th>
                                                <th>Team</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($receivedInvitations as $invitation)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle bg-indigo-100 d-flex align-items-center justify-content-center me-3" 
                                                                 style="width: 36px; height: 36px; background-color: #eef2ff;">
                                                                <i class="fas fa-user" style="color: #4f46e5;"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-medium">{{ $invitation->sender->name }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($invitation->status === 'pending')
                                                            <span class="badge badge-pending">Pending</span>
                                                        @elseif($invitation->status === 'accepted')
                                                            <span class="badge badge-accepted">Accepted</span>
                                                        @elseif($invitation->status === 'declined')
                                                            <span class="badge badge-declined">Declined</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $invitation->team->competition_name ?? '-' }}</td>
                                                    <td>{{ $invitation->team->name ?? '-' }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            @if($invitation->status === 'pending')
                                                                <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm" style="background-color: #dcfce7; color: #166534; border: none;">
                                                                        <i class="fas fa-check me-1"></i> Accept
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('invitations.decline', $invitation->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm" style="background-color: #fee2e2; color: #b91c1c; border: none;">
                                                                        <i class="fas fa-times me-1"></i> Decline
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('invitations.show', $invitation->id) }}" 
                                                               class="btn btn-sm" style="color: #4f46e5;">
                                                                <i class="fas fa-comments me-1"></i> Messages
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5 my-4 bg-light rounded-3">
                                    <div class="mb-3">
                                        <i class="fas fa-inbox fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No invitations received</h5>
                                    <p class="text-muted">Check back later for new invitations</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#user_id').select2({
            placeholder: '🔍 Search for a user...',
            allowClear: true,
            width: 'resolve',
            dropdownParent: $('.custom-card')
        });
    });
</script>
@endpush