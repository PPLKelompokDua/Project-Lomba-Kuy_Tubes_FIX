@extends('layouts.app')

@section('title', 'Manage Invitations')

@push('styles')
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
<style>
    /* Card Styling */
    .card-header-white {
        background-color: rgb(182, 0, 0);
        border-bottom: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    .card-header-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        border-bottom: 0;
    }
    .card-accent-line {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4f46e5, #6366f1);
    }

    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        display: inline-block;
        text-transform: capitalize;
    }

    /* Custom Focus Rings */
    .btn:focus, .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
    }

    .invitation-tab {
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        color: #4f46e5;
        background-color: transparent;
        font-weight: 500;
        transition: all 0.2s;
        border: 1px solid transparent;
        margin-right: 0.5rem;
    }

    .invitation-tab:hover {
        background-color: #f3f4f6;
        color: #4f46e5;
    }

    .invitation-tab.active {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    /* Table Styles */
    .table-invitation th {
        background-color: #f8fafc;
        color: #374151;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        border-top: none;
        padding: 14px 16px;
    }
    .table-invitation td {
        vertical-align: middle;
        padding: 14px 16px;
    }
    .table-invitation tbody tr {
        border-bottom: 1px solid #f3f4f6;
    }
    .table-invitation tbody tr:last-child {
        border-bottom: none;
    }

    /* Stepper Styling */
    .step-progress-item {
        position: relative;
        z-index: 1;
    }
    .step-progress-item.active .step-icon {
        background-color: #4f46e5;
        color: white;
    }
    .step-progress-item.active .step-text {
        color: #4f46e5;
        font-weight: 600;
    }
    .step-icon {
        width: 46px;
        height: 46px;
        background-color: #e5e7eb;
        color: #9ca3af;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        transition: all 0.3s;
    }

    /* Tab Button Styling */
    .invitation-tab {
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        color: #6b7280;
        font-weight: 500;
        transition: all 0.2s;
    }
    .invitation-tab:hover {
        background-color: #f3f4f6;
    }
    .invitation-tab.active {
        background-color: #4f46e5;
        color: white;
    }

    /* Button Styles */
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
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
    }
    .btn-outline-primary {
        background-color: transparent;
        color: #4f46e5;
        border: 1px solid #4f46e5;
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-outline-primary:hover {
        background-color: #4f46e5;
        color: white;
    }

    /* General Styles */
    body {
        background-color: #f9fafb;
    }
    .rounded-4 {
        border-radius: 16px;
    }

    /* Table Responsiveness */
    @media (max-width: 992px) {
        .table-invitation {
            display: block;
            width: 100%;
            overflow-x: auto;
        }
    }
    .nav-tabs .nav-link.active {
        background-color: #4f46e5;
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 8px;
    }

    .nav-tabs .nav-link {
        color: #4f46e5;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 8px;
        border: none;
        background-color: #f3f4f6;
    }

    .nav-tabs .nav-link:hover {
        background-color: #e5e7eb;
        color: #4f46e5;
    }

    /* Custom Search Input Styling */
    .search-container {
        position: relative;
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: #e5e7eb; /* Warna abu-abu */
        border: 1px solid #d1d5db;
        border-top: none; /* Menghapus border atas agar menyatu */
        border-radius: 0 0 8px 8px; /* Hanya sudut bawah membulat */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        padding: 0;
        margin-top: -1px; /* Menghilangkan celah dengan input */
    }

    .search-results.show {
        display: block;
    }

    .search-result-item {
        background-color: transparent;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
        cursor: pointer;
        border-bottom: 1px solid #d1d5db;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-item:hover {
        background-color: #d1d5db;
    }

    .search-result-item .user-info {
        font-weight: 500;
        color: #1f2937;
        flex-grow: 1;
        white-space: nowrap; /* Mencegah teks ke bawah */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .form-control.search-input {
        padding-left: 2.5rem;
        height: 42px;
        border-radius: 8px 8px 0 0; /* Membulatkan sudut atas */
        border: 1px solid #d1d5db;
        border-bottom: none; /* Menghapus border bawah agar menyatu */
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #4f46e5;
        font-size: 1.1rem;
    }

    .no-results {
        padding: 12px;
        color: #6b7280;
        font-style: italic;
        text-align: center;
    }
</style>
@endpush

@push('scripts')
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tab navigation
    const tabButtons = document.querySelectorAll('#invitationTabs button');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function () {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Search functionality
    const searchInput = document.querySelector('#user_search');
    const searchResults = document.querySelector('#search_results');
    const userIdInput = document.querySelector('#user_id');
    let debounceTimeout;

    function fetchUsers(params) {
        return fetch('{{ route("users.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(params),
        })
        .then(response => response.json())
        .catch(error => {
            console.error('Error fetching users:', error);
            return [];
        });
    }

    function displayUsers(users) {
        searchResults.innerHTML = '';
        if (users.length === 0) {
            searchResults.innerHTML += '<div class="no-results">No users found</div>';
            searchResults.classList.add('show');
            userIdInput.value = '';
            return;
        }

        users.forEach(user => {
            const item = document.createElement('div');
            item.classList.add('search-result-item');
            item.innerHTML = `
                <div class="user-info">${user.name} (${user.email})</div>
            `;
            item.addEventListener('click', () => {
                searchInput.value = `${user.name} (${user.email})`;
                userIdInput.value = user.id;
                searchResults.classList.remove('show');
            });
            searchResults.appendChild(item);
        });
        searchResults.classList.add('show');
    }

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(debounceTimeout);

        if (query.length < 2) {
            userIdInput.value = '';
            searchResults.classList.remove('show');
            searchResults.innerHTML = '';
            return;
        }

        debounceTimeout = setTimeout(() => {
            fetchUsers({
                query: query,
                team_id: document.querySelector('#team_id')?.value || '{{ $teams->first()->id ?? "" }}',
            }).then(users => {
                if (query.length >= 2) {
                    displayUsers(users);
                }
            });
        }, 300);
    });

    // Hide search results when clicking outside
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.remove('show');
        }
    });

    // Preselect user if defaultUserId is provided
    @if (isset($defaultUserId) && $defaultUserId)
        fetchUsers({
            user_id: '{{ $defaultUserId }}',
            team_id: document.querySelector('#team_id')?.value || '{{ $teams->first()->id ?? "" }}',
        }).then(data => {
            if (data.length > 0) {
                const user = data[0];
                searchInput.value = `${user.name} (${user.email})`;
                userIdInput.value = user.id;
            }
        }).catch(error => console.error('Error preselecting user:', error));
    @endif
});
</script>
@endpush

@section('title', 'Manage Invitations')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb -->
            <div class="mb-4 d-flex align-items-center">
                <a href="{{ route('teams.index') }}" class="btn position-relative overflow-hidden shadow-sm" 
                   style="background-color: #4f46e5; color: white; border-radius: 8px; padding: 10px 20px; z-index: 1;">
                    <div class="position-absolute top-0 start-0 w-100 h-100" 
                         style="background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%); z-index: -1;"></div>
                    <i class="fas fa-arrow-left me-2"></i> Back to My Teams
                </a>
                <nav aria-label="breadcrumb" class="ms-4 flex-grow-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #4f46e5;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teams.index') }}" class="text-decoration-none" style="color: #4f46e5;">My Teams</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Invitations</li>
                    </ol>
                </nav>
            </div>

            <!-- Main Content Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                <!-- Header -->
                <div class="p-4 pb-3" style="background-color: #4f46e5;">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.15); border: 2px solid white;">
                            <i class="fas fa-paper-plane" style="color: #ffffff;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold" style="color: rgb(255, 255, 255);">Invite Member for Your Team</h4>
                            <p class="text-white-50 mb-0">Set up your team to start collaborating</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-lg-5 p-4">
                    <!-- Alerts -->
                    @if (session('error'))
                        <div class="alert alert-danger border-0 rounded-3 mb-4 alert-dismissible fade show" role="alert">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-exclamation-circle fa-lg"></i>
                                </div>
                                <div>
                                    <strong>Error!</strong> {{ session('error') }}
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success border-0 rounded-3 mb-4 alert-dismissible fade show" role="alert">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-lg"></i>
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
                    <div class="card border shadow-sm mb-5 rounded-4 overflow-hidden">
                        <div class="card-header card-header-primary py-3" style="background-color: #4f46e5;">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-white bg-opacity-25 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-paper-plane text-white"></i>
                                </div>
                                <h5 class="mb-0 text-white">Send New Invitation</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('invitations.store') }}" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label for="user_search" class="form-label fw-medium mb-2">
                                        <i class="fas fa-user me-2" style="color: #4f46e5;"></i>Search User
                                    </label>
                                    <div class="search-container">
                                        <input type="text" id="user_search" class="form-control search-input" placeholder="Search by name or email..." autocomplete="off">
                                        <i class="fas fa-search search-icon"></i>
                                        <div id="search_results" class="search-results"></div>
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $defaultUserId ?? '' }}" required>
                                    </div>
                                    @error('user_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    @if ($teams->count() === 1)
                                        <input type="hidden" name="team_id" value="{{ $teams->first()->id }}">
                                        <label class="form-label fw-medium mb-2">
                                            <i class="fas fa-users me-2" style="color: #4f46e5;"></i>Team
                                        </label>
                                        <div class="form-control bg-light" style="height: 42px;">{{ $teams->first()->name }}</div>
                                    @else
                                        <label for="team_id" class="form-label fw-medium mb-2">
                                            <i class="fas fa-users me-2" style="color: #4f46e5;"></i>Select Team
                                        </label>
                                        <select name="team_id" id="team_id" class="form-select" required>
                                            <option value="">-- Select Team --</option>
                                            @foreach ($teams as $team)
                                                <option value="{{ $team->id }}" {{ old('team_id', $defaultTeamId) == $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('team_id')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                                <div class="col-12 d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Send Invitation
                                    </button>
                                    <a href="{{ route('teams.create') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-plus me-2"></i>Create New Team
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Invitations List Section -->
                    <div class="card border shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white p-0 border-0">
                            <!-- Enhanced Tab Navigation -->
                            <ul class="nav nav-tabs mb-3" id="invitationTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent-content" type="button" role="tab" aria-controls="sent-content" aria-selected="true">
                                        <i class="fas fa-paper-plane me-2"></i> Sent Invitations
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="received-tab" data-bs-toggle="tab" data-bs-target="#received-content" type="button" role="tab" aria-controls="received-content" aria-selected="false">
                                        <i class="fas fa-inbox me-2"></i> Received Invitations
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-0">
                            <!-- Tabs Content -->
                            <div class="tab-content" id="invitationTabsContent">
                                <!-- Sent Invitations Tab -->
                                <div class="tab-pane fade show active p-4" id="sent-content" role="tabpanel" aria-labelledby="sent-tab">
                                    @if ($sentInvitations->count())
                                        <div class="table-responsive">
                                            <table class="table table-invitation mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-4" style="width: 25%;">To</th>
                                                        <th style="width: 17%;">Status</th>
                                                        <th style="width: 24%;">Competition</th>
                                                        <th style="width: 19%;">Team</th>
                                                        <th class="text-end pe-4" style="width: 15%;">Messages</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sentInvitations as $invitation)
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    @if($invitation->receiver->profile_image)
                                                                        <img src="{{ asset('storage/images/' . $invitation->receiver->profile_image) }}" alt="{{ $invitation->receiver->name }}" class="rounded-circle me-3" style="width: 36px; height: 36px; object-fit: cover;">
                                                                    @else
                                                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; background-color: #eef2ff;">
                                                                            <span class="fw-medium" style="color: #4f46e5;">{{(substr($invitation->receiver->name, 0, 2)) }}</span>
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <div class="fw-medium">{{ $invitation->receiver->name }}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if ($invitation->status === 'pending')
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block text-capitalize" style="background-color: #fef3c7; color: #92400e;">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @elseif ($invitation->status === 'accepted')
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block text-capitalize" style="background-color: #dcfce7; color: #166534;">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @elseif ($invitation->status === 'declined')
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block text-capitalize" style="background-color: #fee2e2; color: #b91c1c;">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @else
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block bg-secondary text-white text-capitalize">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $invitation->team->competition_name ?? '-' }}</td>
                                                            <td>{{ $invitation->team->name ?? '-' }}</td>
                                                            <td class="text-end pe-4">
                                                                <a href="{{ route('invitations.show', $invitation->id) }}" class="btn btn-sm btn-outline-primary" style="color: #4f46e5; border-color: #4f46e5;">
                                                                    <i class="fas fa-comments me-1" style="color: #4f46e5;"></i>Messages
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
                                                <i class="fas fa-paper-plane fa-3x text-muted"></i>
                                            </div>
                                            <h5 class="fw-medium text-muted">No Invitations Sent</h5>
                                            <p class="text-muted">Invite team members to start collaborating</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Received Invitations Tab -->
                                <div class="tab-pane fade p-4" id="received-content" role="tabpanel" aria-labelledby="received-tab">
                                    @if ($receivedInvitations->count())
                                        <div class="table-responsive">
                                            <table class="table table-invitation mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-4" style="width: 25%;">From</th>
                                                        <th style="width: 15%;">Status</th>
                                                        <th style="width: 25%;">Competition</th>
                                                        <th style="width: 20%;">Team</th>
                                                        <th class="text-end pe-4" style="width: 15%;">Actions</th>
                                                        <th class="text-end pe-4" style="width: 15%;">Messages</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($receivedInvitations as $invitation)
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    @if($invitation->sender->profile_image)
                                                                        <img src="{{ asset('storage/images/' . $invitation->sender->profile_image) }}" alt="{{ $invitation->sender->name }}" class="rounded-circle me-3" style="width: 36px; height: 36px; object-fit: cover;">
                                                                    @else
                                                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; background-color: #eef2ff;">
                                                                            <span class="fw-medium" style="color: #4f46e5;">{{ strtoupper(substr($invitation->sender->name, 0, 2)) }}</span>
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <div class="fw-medium">{{ $invitation->sender->name }}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if ($invitation->status === 'pending')
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block text-capitalize" style="background-color: #fef3c7; color: #92400e;">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @elseif ($invitation->status === 'accepted')
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block text-capitalize" style="background-color: #dcfce7; color: #166534;">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @elseif ($invitation->status === 'declined')
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block text-capitalize" style="background-color: #fee2e2; color: #b91c1c;">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @else
                                                                    <span class="px-3 py-2 rounded-pill d-inline-block bg-secondary text-white text-capitalize">
                                                                        {{ $invitation->status }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $invitation->team->competition_name ?? '-' }}</td>
                                                            <td>{{ $invitation->team->name ?? '-' }}</td>
                                                            <td class="text-end pe-4">
                                                                <div class="d-flex gap-2 justify-content-end">
                                                                    @if($invitation->status === 'pending')
                                                                        <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                                <i class="fas fa-check me-1"></i>Accept
                                                                            </button>
                                                                        </form>
                                                                        <form action="{{ route('invitations.decline', $invitation->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                                <i class="fas fa-times me-1"></i>Decline
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <span class="text-muted fst-italic">No actions available</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="text-end pe-4">
                                                                <a href="{{ route('invitations.show', $invitation->id) }}" 
                                                                class="btn btn-sm btn-outline-primary" 
                                                                style="color: #4f46e5; border-color: #4f46e5;">
                                                                    <i class="fas fa-comments me-1" style="color: #4f46e5;"></i>Messages
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
                                            <h5 class="fw-medium text-muted">No Invitations Received</h5>
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
    </div>
</div>
@endsection