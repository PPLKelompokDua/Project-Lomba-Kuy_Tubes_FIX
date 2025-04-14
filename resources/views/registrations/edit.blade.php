@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('registrations.show', $registration->id) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Registration</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Edit Registration</h2>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h4>{{ $registration->competition->title }}</h4>
                    <p><strong>Organizer:</strong> {{ $registration->competition->organizer->name }}</p>
                    <p><strong>Location:</strong> {{ $registration->competition->location }}</p>
                    <p><strong>Event Date:</strong> {{ $registration->competition->start_date->format('M d, Y') }} - {{ $registration->competition->end_date->format('M d, Y') }}</p>
                    <p>
                        <strong>Registration Deadline:</strong> 
                        <span class="text-{{ now()->gt($registration->competition->registration_deadline) ? 'danger' : 'success' }}">
                            {{ $registration->competition->registration_deadline->format('M d, Y') }}
                        </span>
                    </p>
                </div>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('registrations.update', $registration->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes (Optional)</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $registration->notes) }}</textarea>
                    <div class="form-text">Provide any additional information or special requests for the organizer.</div>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Additional fields with existing data -->
                <div class="mb-3">
                    <label class="form-label">Additional Information</label>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="additional_data[team_name]" class="form-label">Team Name (if applicable)</label>
                                <input type="text" class="form-control" id="additional_data[team_name]" name="additional_data[team_name]" 
                                       value="{{ old('additional_data.team_name', $registration->additional_data['team_name'] ?? '') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_data[student_id]" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="additional_data[student_id]" name="additional_data[student_id]" 
                                       value="{{ old('additional_data.student_id', $registration->additional_data['student_id'] ?? '') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_data[institution]" class="form-label">Institution</label>
                                <input type="text" class="form-control" id="additional_data[institution]" name="additional_data[institution]" 
                                       value="{{ old('additional_data.institution', $registration->additional_data['institution'] ?? '') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_data[department]" class="form-label">Department/Major</label>
                                <input type="text" class="form-control" id="additional_data[department]" name="additional_data[department]" 
                                       value="{{ old('additional_data.department', $registration->additional_data['department'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Update Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
