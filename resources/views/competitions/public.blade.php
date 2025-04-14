@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Available Competitions</h1>

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

    @if(count($competitions) > 0)
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($competitions as $competition)
        <div class="col">
            <div class="card h-100">
                @if($competition->image)
                <img src="{{ asset('storage/' . $competition->image) }}" class="card-img-top" alt="{{ $competition->title }}">
                @else
                <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                    <span>No Image</span>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $competition->title }}</h5>
                    <p class="card-text text-muted mb-1">
                        <i class="bi bi-geo-alt"></i> {{ $competition->location }}
                    </p>
                    <p class="card-text text-muted">
                        <i class="bi bi-calendar-event"></i> {{ $competition->start_date->format('M d, Y') }} - {{ $competition->end_date->format('M d, Y') }}
                    </p>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Registration deadline:</small>
                            <small class="text-{{ now()->gt($competition->registration_deadline) ? 'danger' : 'success' }}">
                                {{ $competition->registration_deadline->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                    <p class="card-text">{{ Str::limit($competition->description, 120) }}</p>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2">
                        <a href="{{ route('competitions.show', $competition->id) }}" class="btn btn-primary">View Details</a>
                        @if($competition->external_registration_link)
                            <a href="{{ $competition->external_registration_link }}" class="btn btn-success" target="_blank">Register Now <i class="bi bi-box-arrow-up-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $competitions->links() }}
    </div>
    @else
    <div class="alert alert-info">
        No open competitions available at the moment. Please check back later.
    </div>
    @endif
</div>
@endsection
