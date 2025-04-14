@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ Auth::user()->isStudent() ? 'Your Registrations' : 'Manage Registrations' }}</h1>

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

    @if(count($registrations) > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @if(Auth::user()->isAdmin() || Auth::user()->isOrganizer())
                            <th>Participant</th>
                            @endif
                            <th>Competition</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                        <tr>
                            @if(Auth::user()->isAdmin() || Auth::user()->isOrganizer())
                            <td>{{ $registration->user->name }}</td>
                            @endif
                            <td>{{ $registration->competition->title }}</td>
                            <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $registration->status === 'approved' ? 'success' : ($registration->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('registrations.show', $registration->id) }}" class="btn btn-sm btn-info">View</a>
                                    
                                    @if(Auth::user()->isStudent() && $registration->status === 'pending' && $registration->competition->registration_deadline >= now())
                                    <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this registration?')">Cancel</button>
                                    </form>
                                    @endif
                                    
                                    @if((Auth::user()->isOrganizer() || Auth::user()->isAdmin()) && $registration->status === 'pending')
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $registrations->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        @if(Auth::user()->isStudent())
        You haven't registered for any competitions yet. <a href="{{ route('competitions.public') }}">Browse competitions</a>
        @else
        No registrations found.
        @endif
    </div>
    @endif
    
    @if(Auth::user()->isStudent())
    <div class="mt-4">
        <a href="{{ route('competitions.public') }}" class="btn btn-primary">Browse Available Competitions</a>
    </div>
    @endif
</div>
@endsection
