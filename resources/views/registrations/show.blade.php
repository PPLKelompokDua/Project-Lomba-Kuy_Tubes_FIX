@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('registrations.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Registrations</a>
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
        <div class="card-header">
            <h2>Registration Details</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Competition Information</h4>
                    <p><strong>Title:</strong> <a href="{{ route('competitions.show', $registration->competition->id) }}">{{ $registration->competition->title }}</a></p>
                    <p><strong>Organizer:</strong> {{ $registration->competition->organizer->name }}</p>
                    <p><strong>Location:</strong> {{ $registration->competition->location }}</p>
                    <p><strong>Event Period:</strong> {{ $registration->competition->start_date->format('M d, Y') }} - {{ $registration->competition->end_date->format('M d, Y') }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Registration Status</h4>
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $registration->status === 'approved' ? 'success' : ($registration->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </p>
                    <p><strong>Registration Date:</strong> {{ $registration->created_at->format('M d, Y H:i') }}</p>
                    @if($registration->status === 'approved' && $registration->approved_at)
                    <p><strong>Approved Date:</strong> {{ $registration->approved_at->format('M d, Y H:i') }}</p>
                    @endif
                    @if($registration->status === 'rejected' && $registration->rejected_at)
                    <p><strong>Rejected Date:</strong> {{ $registration->rejected_at->format('M d, Y H:i') }}</p>
                    @endif
                </div>
            </div>

            @if(Auth::user()->isAdmin() || Auth::user()->isOrganizer())
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Participant Information</h4>
                    <p><strong>Name:</strong> {{ $registration->user->name }}</p>
                    <p><strong>Email:</strong> {{ $registration->user->email }}</p>
                </div>
            </div>
            @endif

            @if($registration->notes)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Notes</h4>
                    <p>{{ $registration->notes }}</p>
                </div>
            </div>
            @endif

            @if($registration->additional_data && count($registration->additional_data) > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Additional Information</h4>
                    <div class="card">
                        <div class="card-body">
                            <dl class="row">
                                @foreach($registration->additional_data as $key => $value)
                                <dt class="col-sm-3">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                <dd class="col-sm-9">{{ is_array($value) ? implode(', ', $value) : $value }}</dd>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if(Auth::user()->isStudent() && $registration->status === 'pending' && $registration->competition->registration_deadline >= now())
                        <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-warning">Edit Registration</a>
                        <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this registration?')">Cancel Registration</button>
                        </form>
                        @endif

                        @if((Auth::user()->isOrganizer() || Auth::user()->isAdmin()) && $registration->status === 'pending')
                        <form action="{{ route('registrations.approve', $registration->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve Registration</button>
                        </form>
                        <form action="{{ route('registrations.reject', $registration->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Reject Registration</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
