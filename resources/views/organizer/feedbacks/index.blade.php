@extends('layouts.organizer')

@section('title', 'Organizer Feedbacks')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover-rise" data-aos="fade-up">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Feedback from Participants</h2>

        @if ($organizerFeedbacks->isEmpty())
            <div class="mb-6 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg relative" role="alert" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span class="font-semibold">No feedback from participants yet.</span>
                </div>
                <button class="absolute top-2 right-2 text-blue-500 hover:text-blue-700" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($organizerFeedbacks as $index => $feedback)
                <div class="bg-gray-50 rounded-lg p-4 shadow-sm hover-rise" data-aos="fade-up" data-aos-delay="{{ 150 + $index * 50 }}">
                    <div class="mb-2">
                        <span class="text-sm font-medium text-gray-700">From:</span>
                        <span class="text-gray-600">{{ $feedback->sender->name }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-sm font-medium text-gray-700">Team:</span>
                        <span class="text-gray-600">{{ $feedback->team->name }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-sm font-medium text-gray-700">Competition:</span>
                        <span class="text-gray-600">{{ $feedback->team->competition_name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Content:</span><br>
                        <p class="text-gray-600 leading-relaxed max-h-96 overflow-y-auto whitespace-pre-wrap">{{ $feedback->content }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* Card hover effects */
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    /* Button hover glow (for future-proofing) */
    .action-button {
        position: relative;
    }
    
    .action-button::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        z-index: -1;
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .action-button:hover::after {
        opacity: 0.5;
    }
    
    /* Scrollbar for feedback content */
    .max-h-96::-webkit-scrollbar {
        width: 8px;
    }
    
    .max-h-96::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .max-h-96::-webkit-scrollbar-thumb {
        background: #818cf8;
        border-radius: 4px;
    }
    
    .max-h-96::-webkit-scrollbar-thumb:hover {
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
</script>
@endpush