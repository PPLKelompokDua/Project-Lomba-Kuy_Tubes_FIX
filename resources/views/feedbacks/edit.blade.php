@extends('layouts.app')

@section('title', 'Edit Feedback')

@section('content')
<div class="container-fluid py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-6 flex items-center" data-aos="fade-up">
            <a href="{{ route('feedbacks.index') }}" class="relative inline-flex items-center bg-gradient-to-r from-indigo-600 to-indigo-500 text-white px-4 py-2 rounded-lg shadow-sm hover:from-indigo-700 hover:to-indigo-600 hover:-translate-y-0.5 transition-all duration-300">
                <span class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-50"></span>
                <i class="fas fa-arrow-left mr-2"></i> Back to Feedback
            </a>
            <nav aria-label="breadcrumb" class="ml-4 flex-1">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-500">Dashboard</a></li>
                    <li class="text-gray-500">/</li>
                    <li><a href="{{ route('feedbacks.index') }}" class="text-indigo-600 hover:text-indigo-500">Feedback</a></li>
                    <li class="text-gray-500">/</li>
                    <li class="text-gray-700 font-medium">Edit Feedback</li>
                </ol>
            </nav>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg relative" role="alert" data-aos="fade-up" data-aos-delay="50">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button class="absolute top-2 right-2 text-green-500 hover:text-green-700" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg relative" role="alert" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="absolute top-2 right-2 text-red-500 hover:text-red-700" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Main Content Card -->
        <div class="bg-white border-0 shadow-lg rounded-xl overflow-hidden" data-aos="fade-up" data-aos-delay="150">
            <!-- Header with Pattern Background -->
            <div class="relative py-6 px-4 bg-gradient-to-r from-indigo-600 to-indigo-500 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCI+CjxyZWN0IHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgZmlsbD0ibm9uZSIgLz4KPHBhdGggZD0iTTAgMCAxMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMTAgMCAyMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMjAgMCAzMCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMzAgMCA0MCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNNDAgMCA1MCAxMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMCAxMCAxMCAyMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNMTAgMTAgMjAgMjAgWiIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIGZpbGw9Im5vbmUiLz4KPHBhdGggZD0iTTIwIDEwIDMwIDIwIFoiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIiBmaWxsPSJub25lIi8+CjxwYXRoIGQ9Ik0zMCAxMCA0MCAyMCBaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgZmlsbD0ibm9uZSIvPgo8cGF0aCBkPSJNNDAgMTAgNTAgMjAgWiIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIGZpbGw9Im5vbmUiLz4KPC9zdmc+')] bg-center bg-repeat">
                <div class="flex items-center">
                    <div class="flex items-center justify-center rounded-full w-14 h-14 bg-white/20 mr-4">
                        <i class="fas fa-edit text-xl text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-0">Edit Feedback for {{ $team->name }}</h4>
                        <p class="text-white/75 mb-0 text-sm">Update your thoughts to improve collaboration</p>
                    </div>
                </div>
            </div>

            <div class="p-6 lg:p-8">
                <!-- Feedback Form -->
                <form action="{{ route('feedbacks.updateByTeam', ['team_id' => $team->id]) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="team_id" value="{{ $team->id }}">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column for Feedback Fields -->
                        <div class="lg:col-span-2">
                            <!-- Feedback for Leader -->
                            @if ($team->leader_id !== auth()->id())
                                <div class="mb-6" data-aos="fade-up" data-aos-delay="200">
                                    <label class="block text-gray-700 font-medium mb-2">{{ $team->leader->name }} (Leader)</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md text-gray-600">
                                            <i class="fas fa-user-crown"></i>
                                        </span>
                                        <textarea name="feedback_member[{{ $team->leader->id }}]" class="form-control w-full border border-gray-300 rounded-r-md p-3 focus:ring-indigo-600 focus:border-indigo-600" rows="4" placeholder="Provide feedback for the team leader">{{ old("feedback_member.{$team->leader->id}", $memberFeedback[$team->leader->id]->content ?? '') }}</textarea>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Share constructive feedback about leadership and collaboration</p>
                                </div>
                            @endif

                            <!-- Feedback for Members -->
                            @foreach ($team->acceptedMembers as $index => $member)
                                @if ($member->id !== auth()->id() && $member->id !== $team->leader_id)
                                    <div class="mb-6" data-aos="fade-up" data-aos-delay="{{ 250 + $index * 50 }}">
                                        <label class="block text-gray-700 font-medium mb-2">{{ $member->name }} (Member)</label>
                                        <div class="flex">
                                            <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md text-gray-600">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <textarea name="feedback_member[{{ $member->id }}]" class="form-control w-full border border-gray-300 rounded-r-md p-3 focus:ring-indigo-600 focus:border-indigo-600" rows="4" placeholder="Provide feedback for this team member">{{ old("feedback_member.{$member->id}", $memberFeedback[$member->id]->content ?? '') }}</textarea>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Highlight strengths and areas for improvement</p>
                                    </div>
                                @endif
                            @endforeach

                            <!-- Feedback for Platform -->
                            <div class="mb-6" data-aos="fade-up" data-aos-delay="{{ 300 + count($team->acceptedMembers) * 50 }}">
                                <label class="block text-gray-700 font-medium mb-2">Feedback for Competition Platform</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md text-gray-600">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <textarea name="feedback_platform" class="form-control w-full border border-gray-300 rounded-r-md p-3 focus:ring-indigo-600 focus:border-indigo-600" rows="4" placeholder="Share your experience with the competition platform">{{ old('feedback_platform', $platformFeedback->content ?? '') }}</textarea>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Help us improve the platform for all users</p>
                            </div>

                            <!-- Feedback for Organizer -->
                            @if($team->competition && $team->competition->organizer_id)
                                <div class="mb-6" data-aos="fade-up" data-aos-delay="{{ 350 + count($team->acceptedMembers) * 50 }}">
                                    <label class="block text-gray-700 font-medium mb-2">Feedback for Organizer {{ $team->competition->organizer->name ?? 'Unknown Organizer' }}</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md text-gray-600">
                                            <i class="fas fa-building"></i>
                                        </span>
                                        <textarea name="feedback_organizer" class="form-control w-full border border-gray-300 rounded-r-md p-3 focus:ring-indigo-600 focus:border-indigo-600" rows="4" placeholder="Provide feedback for the competition organizer">{{ old('feedback_organizer', $organizerFeedback->content ?? '') }}</textarea>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Share your thoughts on the competition organization</p>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column for Tips and Submit -->
                        <div class="lg:col-span-1">
                            <!-- Tips Card -->
                            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 border-0 shadow-sm rounded-xl overflow-hidden mb-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="p-4">
                                    <div class="flex items-center mb-3">
                                        <div class="rounded-full p-2 mr-3 bg-indigo-600">
                                            <i class="fas fa-lightbulb text-white"></i>
                                        </div>
                                        <h5 class="font-bold mb-0">Feedback Tips</h5>
                                    </div>
                                    <ul class="pl-4 mb-0 text-sm text-gray-700">
                                        <li class="mb-2">Be specific and constructive in your feedback</li>
                                        <li class="mb-2">Highlight both strengths and areas for improvement</li>
                                        <li class="mb-2">Keep your feedback respectful and professional</li>
                                        <li>Your feedback helps improve team collaboration</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Submit Button Card -->
                            <div class="bg-white border-0 shadow-sm rounded-xl overflow-hidden" data-aos="fade-up" data-aos-delay="450">
                                <div class="p-4">
                                    <h6 class="font-bold mb-3">Ready to Update?</h6>
                                    <p class="text-gray-500 text-sm mb-4">
                                        Your updated feedback will be shared with the respective recipients to foster better collaboration.
                                    </p>
                                    <div class="space-y-3">
                                        <button type="submit" class="relative w-full py-3 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-lg font-medium overflow-hidden hover:from-indigo-700 hover:to-indigo-600 hover:-translate-y-0.5 transition-all duration-300 group">
                                            <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 transform -translate-x-full group-hover:translate-x-full opacity-0 group-hover:opacity-100 transition-transform duration-800"></span>
                                            <i class="fas fa-save mr-2"></i> Update Feedback
                                        </button>
                                        <a href="{{ route('feedbacks.index') }}" class="relative w-full py-3 bg-gradient-to-r from-gray-200 to-gray-100 text-gray-700 rounded-lg font-medium overflow-hidden hover:from-gray-300 hover:to-gray-200 hover:-translate-y-0.5 transition-all duration-300 inline-block text-center">
                                            <i class="fas fa-times mr-2"></i> Cancel
                                        </a>
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* Input focus animation */
    textarea:focus {
        transform: scale(1.01);
        transition: transform 0.2s ease;
    }
    
    /* Scrollbar for textareas */
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #818cf8;
        border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #4f46e5;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-5xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
    });

    // Form validation
    (function() {
        'use strict';
        
        // Fetch all forms that need validation
        const forms = document.querySelectorAll('.needs-validation');
        
        // Add validation on submit
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endpush