@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('competitions.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to List</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                @if($competition->image)
                <img src="{{ asset('storage/' . $competition->image) }}" class="img-fluid rounded-start" alt="{{ $competition->title }}">
                @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 100%;">
                    <span>No Image</span>
                </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="card-title">{{ $competition->title }}</h1>
                        <span class="badge bg-{{ $competition->status === 'open' ? 'success' : ($competition->status === 'closed' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($competition->status) }}
                        </span>
                    </div>
                    
                    <p class="card-text mb-1">
                        <strong>Organized by:</strong> {{ $competition->organizer->name }}
                    </p>
                    <p class="card-text mb-1">
                        <strong>Location:</strong> {{ $competition->location }}
                    </p>
                    <p class="card-text mb-1">
                        <strong>Event Period:</strong> {{ $competition->start_date->format('M d, Y') }} - {{ $competition->end_date->format('M d, Y') }}
                    </p>
                    <p class="card-text mb-3">
                        <strong>Registration Deadline:</strong> 
                        <span class="text-{{ now()->gt($competition->registration_deadline) ? 'danger' : 'success' }}">
                            {{ $competition->registration_deadline->format('M d, Y') }}
                        </span>
                    </p>
                    
                    @if($competition->max_participants)
                    <p class="card-text mb-3">
                        <strong>Maximum Participants:</strong> {{ $competition->max_participants }}
                        @if(Auth::user()->isOrganizer() || Auth::user()->isAdmin())
                        ({{ $competition->registrations->where('status', 'approved')->count() }} approved so far)
                        @endif
                    </p>
                    @endif
                    
                    <h5>Description</h5>
                    <p class="card-text">{{ $competition->description }}</p>
                    
                    <div class="mt-4">
                        @if((Auth::user()->isOrganizer() && $competition->organizer_id === Auth::id()) || Auth::user()->isAdmin())
                        <!-- Admin/Organizer actions -->
                        <div class="btn-group">
                            <a href="{{ route('competitions.edit', $competition->id) }}" class="btn btn-warning">Edit Competition</a>
                            <form action="{{ route('competitions.destroy', $competition->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this competition?')">Delete Competition</button>
                            </form>
                        </div>
                        @elseif(Auth::user()->isStudent() && $competition->status === 'open' && now()->lt($competition->registration_deadline))
                        <!-- Student actions -->
                        @php
                            $isRegistered = Auth::user()->registrations()->where('competition_id', $competition->id)->exists();
                        @endphp
                        
                        @if($isRegistered)
                            <a href="{{ route('registrations.index') }}" class="btn btn-secondary">View Your Registration</a>
                        @else
                            @if($competition->external_registration_link)
                                <a href="{{ $competition->external_registration_link }}" class="btn btn-success" target="_blank">Register Now <i class="bi bi-box-arrow-up-right"></i></a>
                                <small class="d-block mt-1 text-muted">This will take you to an external registration site</small>
                            @else
                                <span class="text-muted">Registration link not available. Please contact the organizer.</span>
                            @endif
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if((Auth::user()->isOrganizer() && $competition->organizer_id === Auth::id()) || Auth::user()->isAdmin())
    <!-- Registration Management for Organizers/Admins -->
    <div class="card">
        <div class="card-header">
            <h3>Registration Management</h3>
        </div>
        <div class="card-body">
            @if(count($competition->registrations) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Participant</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($competition->registrations as $registration)
                        <tr>
                            <td>{{ $registration->user->name }}</td>
                            <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $registration->status === 'approved' ? 'success' : ($registration->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('registrations.show', $registration->id) }}" class="btn btn-sm btn-info">View</a>
                                    
                                    @if($registration->status === 'pending')
                                    <form action="{{ route('registrations.approve', $registration->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form action="{{ route('registrations.reject', $registration->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                No registrations for this competition yet.
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
