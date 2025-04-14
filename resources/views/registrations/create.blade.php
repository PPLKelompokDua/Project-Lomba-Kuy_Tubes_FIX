@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('competitions.public') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Competitions</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Register for Competition</h2>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h4>{{ $competition->title }}</h4>
                    <p><strong>Organizer:</strong> {{ $competition->organizer->name }}</p>
                    <p><strong>Location:</strong> {{ $competition->location }}</p>
                    <p><strong>Event Date:</strong> {{ $competition->start_date->format('M d, Y') }} - {{ $competition->end_date->format('M d, Y') }}</p>
                    <p>
                        <strong>Registration Deadline:</strong> 
                        <span class="text-{{ now()->gt($competition->registration_deadline) ? 'danger' : 'success' }}">
                            {{ $competition->registration_deadline->format('M d, Y') }}
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

            <form action="{{ route('registrations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="competition_id" value="{{ $competition->id }}">
                
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes (Optional)</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    <div class="form-text">Provide any additional information or special requests for the organizer.</div>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Additional fields can be added here if needed for specific competitions -->
                <div class="mb-3">
                    <label class="form-label">Additional Information</label>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="additional_data[team_name]" class="form-label">Team Name (if applicable)</label>
                                <input type="text" class="form-control" id="additional_data[team_name]" name="additional_data[team_name]" value="{{ old('additional_data.team_name') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_data[student_id]" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="additional_data[student_id]" name="additional_data[student_id]" value="{{ old('additional_data.student_id') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_data[institution]" class="form-label">Institution</label>
                                <input type="text" class="form-control" id="additional_data[institution]" name="additional_data[institution]" value="{{ old('additional_data.institution') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_data[department]" class="form-label">Department/Major</label>
                                <input type="text" class="form-control" id="additional_data[department]" name="additional_data[department]" value="{{ old('additional_data.department') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">
                        I agree to the competition rules and terms of participation
                    </label>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Submit Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
