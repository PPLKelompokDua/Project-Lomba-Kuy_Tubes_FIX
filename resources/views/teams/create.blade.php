@extends('layouts.app')

@section('title', 'Create Teams')

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
                        <li class="breadcrumb-item active" aria-current="page">Create Team</li>
                    </ol>
                </nav>
            </div>
            
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
                                     style="width: 40px; height: 40px; background-color: #4f46e5; color: white;">
                                    <i class="fas fa-info"></i>
                                </div>
                                <span class="small" style="color: #4f46e5; font-weight: 500;">Basic Info</span>
                            </div>
                            
                            <div class="d-flex flex-column align-items-center position-relative" style="z-index: 1;">
                                <div class="d-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: #e5e7eb; color: #9ca3af;">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <span class="small text-muted">Invite Members</span>
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

                    <!-- Team Creation Form -->
                    <form method="POST" action="{{ route('teams.store') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <!-- Left Column for Team Details -->
                            <div class="col-lg-7 pe-lg-5">
                                <div class="shadow-sm rounded-4 border p-4 mb-4" style="border-color: #e5e7eb !important;">
                                    <h5 class="mb-3 fw-bold">Team Details</h5>
                                
                                    <div class="mb-4">
                                        <label for="name" class="form-label fw-medium mb-2">Team Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <input type="text" name="name" id="name" class="form-control border-start-0 ps-0" 
                                                   style="border-color: #d1d5db;" placeholder="Enter your team name" required>
                                        </div>
                                        <div class="form-text">Choose a unique and memorable name for your team</div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="competition_name" class="form-label fw-medium mb-2">Competition Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="fas fa-trophy"></i>
                                            </span>
                                            <input type="text" name="competition_name" id="competition_name" 
                                                   class="form-control border-start-0 ps-0" style="border-color: #d1d5db;"
                                                   value="{{ $competition->title ?? '' }}" {{ isset($competition) ? 'readonly' : '' }} 
                                                   placeholder="Enter competition name" required>
                                        </div>
                                        @if(isset($competition))
                                            <div class="form-text">This competition name is pre-filled and cannot be changed</div>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="category" class="form-label fw-medium mb-2">Category</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                            <input type="text" name="category" id="category" class="form-control border-start-0 ps-0" 
                                                   style="border-color: #d1d5db;" value="{{ $competition->category ?? '' }}" 
                                                   placeholder="Enter competition category">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="shadow-sm rounded-4 border p-4" style="border-color: #e5e7eb !important;">
                                    <h5 class="mb-3 fw-bold">Competition Details</h5>
                                    
                                    <div class="mb-4">
                                        <label for="deadline" class="form-label fw-medium mb-2">Deadline</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <input type="date" name="deadline" id="deadline" class="form-control border-start-0 ps-0" 
                                                   style="border-color: #d1d5db;" value="{{ optional(optional($competition)->deadline)->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="location" class="form-label fw-medium mb-2">Location</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="color: #6b7280;">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </span>
                                            <input type="text" name="location" id="location" class="form-control border-start-0 ps-0" 
                                                   style="border-color: #d1d5db;" value="{{ $competition->location ?? '' }}" 
                                                   placeholder="Enter competition location">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-0">
                                        <label for="description" class="form-label fw-medium mb-2">Short Description</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 align-items-start py-2" style="color: #6b7280;">
                                                <i class="fas fa-align-left"></i>
                                            </span>
                                            <textarea name="description" id="description" class="form-control border-start-0 ps-0" 
                                                      style="border-color: #d1d5db;" rows="4" 
                                                      placeholder="Brief description of your team or project">{{ $competition->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column for Info and Submit -->
                            <div class="col-lg-5 mt-4 mt-lg-0">
                                <!-- Hidden Inputs -->
                                @if(isset($recommendedUser))
                                    <input type="hidden" name="invite_user_id" value="{{ $recommendedUser->id ?? '' }}">
                                @endif
                                
                                @if(isset($competition))
                                    <input type="hidden" name="competition_id" value="{{ $competition->id }}">
                                @else
                                    <input type="hidden" name="competition_id" value="">
                                @endif
                                
                                <!-- Tips Card -->
                                <div class="card border-0 bg-gradient-to-br mb-4 shadow-sm rounded-4 overflow-hidden" 
                                     style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle p-2 me-3" style="background-color: #4f46e5;">
                                                <i class="fas fa-lightbulb text-white"></i>
                                            </div>
                                            <h5 class="card-title mb-0 fw-bold">Team Creation Tips</h5>
                                        </div>
                                        <ul class="ps-4 mb-0">
                                            <li class="mb-2">Choose a clear, unique team name</li>
                                            <li class="mb-2">Set realistic deadlines for your project</li>
                                            <li class="mb-2">Provide enough details about your competition</li>
                                            <li>You can invite team members after creation</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- Competition Preview -->
                                @if(isset($competition))
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                                    <div class="card-header border-0 py-3" style="background-color: #f3f4f6;">
                                        <h6 class="mb-0 fw-bold">Competition Preview</h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; background-color: #eef2ff;">
                                                <i class="fas fa-trophy" style="color: #4f46e5;"></i>
                                            </div>
                                            <h6 class="mb-0">{{ $competition->title ?? 'Competition' }}</h6>
                                        </div>
                                        
                                        @if(isset($competition->deadline))
                                        <div class="d-flex align-items-center mb-2">
                                            <div style="width: 24px;" class="text-center me-2 text-muted">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                            <div class="small text-muted">
                                                Deadline: {{ optional($competition->deadline)->format('F j, Y') }}
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if(isset($competition->category) && !empty($competition->category))
                                        <div class="d-flex align-items-center mb-2">
                                            <div style="width: 24px;" class="text-center me-2 text-muted">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <div class="small text-muted">
                                                Category: {{ $competition->category }}
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if(isset($recommendedUser))
                                        <div class="mt-3 pt-2 border-top">
                                            <div class="small fw-medium mb-1">Recommended Teammate:</div>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px; background-color: #4f46e5; color: white; font-size: 12px;">
                                                    {{ substr($recommendedUser->name ?? 'U', 0, 1) }}
                                                </div>
                                                <div class="small">{{ $recommendedUser->name ?? 'User' }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Submit Button Card -->
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                    <div class="card-body p-4">
                                        <h6 class="fw-bold mb-3">Ready to Create?</h6>
                                        <p class="text-muted small mb-4">
                                            By creating a team, you'll become the team leader with access to manage members and settings.
                                        </p>
                                        <button type="submit" class="btn w-100 py-3 fw-medium position-relative overflow-hidden" 
                                                style="background-color: #4f46e5; color: white; border-radius: 8px;">
                                            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-0 hover-shine" 
                                                 style="background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%); transform: translateX(-100%);"></div>
                                            <i class="fas fa-plus-circle me-2"></i> Create Team
                                        </button>
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

<style>
    /* Custom Form Styling */
    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
    }
    
    .input-group-text {
        border-color: #d1d5db;
    }
    
    .form-text {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    /* Card styling */
    .rounded-4 {
        border-radius: 16px;
    }
    
    /* Pattern Background */
    .card-header {
        position: relative;
        overflow: hidden;
    }
    
    /* Shine effect for button */
    .hover-shine {
        transition: transform 0.8s ease-in-out;
    }
    
    .btn:hover .hover-shine {
        transform: translateX(100%);
        opacity: 1;
    }
    
    /* Stepper active vs inactive */
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
        transition: all 0.3s ease;
    }
    
    /* Responsive margins/paddings */
    @media (max-width: 992px) {
        .card-body {
            padding: 1.5rem;
        }
    }
</style>

<script>
    // Form validation
    (function() {
        'use strict'
        
        // Fetch all forms that need validation
        const forms = document.querySelectorAll('.needs-validation')
        
        // Add validation on submit
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection