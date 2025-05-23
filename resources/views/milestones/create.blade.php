@extends('layouts.app')

@section('title', 'Add Milestone')

@section('content')
<div class="container-fluid py-5 bg-light min-vh-100">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb with Back Button -->
            <div class="mb-4 d-flex align-items-center">
                <a href="{{ route('milestones.index', $team->id) }}" class="btn position-relative overflow-hidden shadow-sm me-3"
                   style="background-color: #4f46e5; color: white; border-radius: 8px; padding: 10px 20px; z-index: 1;">
                    <div class="position-absolute top-0 start-0 w-100 h-100"
                         style="background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%); z-index: -1;"></div>
                    <i class="bi bi-arrow-left me-2"></i> Back to Milestones
                </a>
                <nav aria-label="breadcrumb" class="flex-grow-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none" style="color: #4f46e5;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('milestones.index', $team->id) }}" class="text-decoration-none" style="color: #4f46e5;">Milestones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Milestone</li>
                    </ol>
                </nav>
            </div>

            <!-- Main Content Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header with Gradient Background -->
                <div class="card-header border-0 py-4" style="background-color: #4f46e5;">
                    <div class="position-relative z-index-1">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center rounded-circle me-3"
                                 style="width: 52px; height: 52px; background-color: rgba(255, 255, 255, 0.2);">
                                <i class="bi bi-calendar-plus fa-lg text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-0 fw-bold">Add Milestone</h4>
                                <p class="text-white text-opacity-75 mb-0 small">Team: {{ $team->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-lg-5 p-4">

                    <!-- Milestone Creation Form -->
                    <form action="{{ route('milestones.store', $team->id) }}" method="POST" class="milestone-form needs-validation" novalidate>
                        @csrf

                        <div class="row">
                            <!-- Left Column for Milestone Details -->
                            <div class="col-lg-7 pe-lg-5">
                                <div class="shadow-sm rounded-4 border p-4 mb-4" style="border-color: #e5e7eb !important;">
                                    <h5 class="mb-3 fw-bold">Milestone Details</h5>

                                    <div class="mb-4">
                                        <label for="title" class="form-label fw-medium mb-2">Milestone Title <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="bi bi-bookmark-fill"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0 custom-input" id="title" name="title"
                                                   style="border-color: #d1d5db;" placeholder="Enter milestone title..." required>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label for="description" class="form-label fw-medium mb-2">Description <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 align-items-start py-2" style="color: #6b7280;">
                                                <i class="bi bi-card-text"></i>
                                            </span>
                                            <textarea class="form-control border-start-0 ps-0 custom-input custom-textarea" id="description" name="description" rows="4"
                                                      style="border-color: #d1d5db;" placeholder="Describe the milestone and targets to be achieved..." required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="shadow-sm rounded-4 border p-4 mb-4" style="border-color: #e5e7eb !important;">
                                    <h5 class="mb-3 fw-bold">Implementation Schedule</h5>

                                    <div class="mb-4">
                                        <label for="start_date" class="form-label fw-medium mb-2">Start Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="bi bi-calendar-event"></i>
                                            </span>
                                            <input type="date" class="form-control border-start-0 ps-0 custom-input" id="start_date" name="start_date" style="border-color: #d1d5db;" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="start_time" class="form-label fw-medium mb-2">Start Time <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="bi bi-clock"></i>
                                            </span>
                                            <input type="time" class="form-control border-start-0 ps-0 custom-input" id="start_time" name="start_time" style="border-color: #d1d5db;" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="end_date" class="form-label fw-medium mb-2">End Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="bi bi-calendar-check"></i>
                                            </span>
                                            <input type="date" class="form-control border-start-0 ps-0 custom-input" id="end_date" name="end_date" style="border-color: #d1d5db;" required>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label for="end_time" class="form-label fw-medium mb-2">End Time <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="bi bi-clock-history"></i>
                                            </span>
                                            <input type="time" class="form-control border-start-0 ps-0 custom-input" id="end_time" name="end_time" style="border-color: #d1d5db;" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Section -->
                                <div class="shadow-sm rounded-4 border p-4 mb-4" style="border-color: #e5e7eb !important;">
                                    <h5 class="mb-3 fw-bold">Milestone Status</h5>
                                    
                                    <div class="form-group">
                                        <label for="status" class="form-label fw-medium mb-2">Current Status <span class="text-danger">*</span></label>
                                        <div class="status-selector">
                                            <div class="status-option">
                                                <input type="radio" id="status_not_started" name="status" value="Not Started" checked>
                                                <label for="status_not_started" class="status-label not-started">
                                                    <div class="status-indicator"></div>
                                                    <div class="status-content">
                                                        <div class="status-title">Not Started</div>
                                                        <div class="status-desc">Milestone has not been started</div>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            <div class="status-option">
                                                <input type="radio" id="status_in_progress" name="status" value="In Progress">
                                                <label for="status_in_progress" class="status-label in-progress">
                                                    <div class="status-indicator"></div>
                                                    <div class="status-content">
                                                        <div class="status-title">In Progress</div>
                                                        <div class="status-desc">Milestone is in progress</div>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            <div class="status-option">
                                                <input type="radio" id="status_completed" name="status" value="Completed">
                                                <label for="status_completed" class="status-label completed">
                                                    <div class="status-indicator"></div>
                                                    <div class="status-content">
                                                        <div class="status-title">Completed</div>
                                                        <div class="status-desc">Milestone has been completed</div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column for Tips and Submit -->
                            <div class="col-lg-5 mt-4 mt-lg-0">
                                <!-- Tips Card -->
                                <div class="card border-0 bg-gradient-to-br mb-4 shadow-sm rounded-4 overflow-hidden"
                                     style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle p-2 me-3" style="background-color: #4f46e5;">
                                                <i class="bi bi-lightbulb text-white"></i>
                                            </div>
                                            <h5 class="card-title mb-0 fw-bold">Tips for Creating a Milestone</h5>
                                        </div>
                                        <ul class="ps-4 mb-0 small text-muted">
                                            <li class="mb-2">Provide a clear and specific title</li>
                                            <li class="mb-2">Set a realistic schedule</li>
                                            <li class="mb-2">Describe the target in detail</li>
                                            <li>Milestones can be updated anytime</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Submit Button Card -->
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                    <div class="card-body p-4">
                                        <h6 class="fw-bold mb-3">Ready to Save?</h6>
                                        <p class="text-muted small mb-4">
                                            Ensure all milestone details are correct before saving.
                                        </p>
                                        <div class="d-flex justify-content-end gap-3">
                                            <button type="button" class="btn btn-outline-secondary py-2"
                                                    onclick="history.back()">
                                                <i class="bi bi-x-circle me-2"></i>Cancel
                                            </button>
                                            <button type="submit" class="btn py-2 position-relative overflow-hidden submit-btn"
                                                    style="background-color: #4f46e5; color: white; border-radius: 8px;">
                                                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-0 hover-shine"
                                                     style="background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%); transform: translateX(-100%);"></div>
                                                <i class="bi bi-check-circle me-2"></i> Save Milestone
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('.milestone-form');
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', validateInput);
        input.addEventListener('input', clearValidation);
    });
    
    function validateInput(e) {
        const input = e.target;
        const wrapper = input.closest('.input-group');
        
        if (!input.value.trim() && input.type !== 'radio') {
            wrapper.classList.add('error');
        } else {
            wrapper.classList.remove('error');
        }
    }
    
    function clearValidation(e) {
        const input = e.target;
        const wrapper = input.closest('.input-group');
        wrapper.classList.remove('error');
    }
    
    // Date validation
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
    });
});
</script>
@endpush

<style>
/* Custom Form Styling */
.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
}

.input-group-text {
    border-color: #d1d5db;
}

/* Card styling */
.rounded-4 {
    border-radius: 16px;
}

/* Shine effect for button */
.hover-shine {
    transition: transform 0.8s ease-in-out;
}

.btn:hover .hover-shine {
    transform: translateX(100%);
    opacity: 1;
}

/* Button hover effects */
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    transition: all 0.3s ease;
}

.btn-outline-secondary {
    border-color: #d1d5db;
    color: #374151;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: #f9fafb;
    border-color: #b0b5b9;
}

/* Form Groups and Inputs */
.input-group {
    position: relative;
    transition: all 0.3s ease;
}

.input-group.error .form-control {
    border-color: #ef4444;
    background: #fef2f2;
}

.input-group.error .input-group-text {
    color: #ef4444;
}

.custom-input {
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f9fafb;
    width: 100%;
    box-sizing: border-box;
}

.custom-textarea {
    min-height: 100px;
    resize: vertical;
}

/* Status Selector */
.status-selector {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.status-option {
    position: relative;
}

.status-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.status-label {
    display: flex;
    align-items: center;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.status-label:hover {
    border-color: #b0b5b9;
    background: white;
}

.status-option input[type="radio"]:checked + .status-label {
    border-color: #4f46e5;
    background: white;
    box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 12px;
    flex-shrink: 0;
}

.not-started .status-indicator {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

.in-progress .status-indicator {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.completed .status-indicator {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.status-content {
    flex: 1;
}

.status-title {
    font-weight: 600;
    color: #374151;
    margin-bottom: 2px;
    font-size: 0.95rem;
}

.status-desc {
    font-size: 0.85rem;
    color: #6b7280;
}

/* Responsive margins/paddings */
@media (max-width: 992px) {
    .card-body {
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .d-flex.justify-content-end {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-end .btn {
        width: 100%;
    }
}
</style>