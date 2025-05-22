@extends('layouts.admin')

@section('title', 'Platform Feedbacks')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-6 text-indigo-600" data-aos="fade-up">Feedback for Platform</h1>

    <!-- Feedback List -->
    <div class="bg-white p-6 rounded-lg shadow hover-rise" data-aos="fade-up" data-aos-delay="100">
        @if ($platformFeedbacks->isEmpty())
            <div class="flex items-center bg-blue-50 text-blue-700 p-4 rounded-lg border-l-4 border-blue-400" data-aos="fade-up" data-aos-delay="150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>No feedback available for the platform.</span>
            </div>
        @else
            <div class="space-y-4 max-h-[70vh] overflow-y-auto styled-scrollbar">
                @foreach ($platformFeedbacks as $feedback)
                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-400 hover:shadow-md transition-all" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 50 }}">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-user mr-2 text-indigo-600"></i>
                            <strong class="text-gray-800">From:</strong>
                            <span class="ml-2 text-gray-600">{{ $feedback->sender->name }}</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-users mr-2 text-indigo-600"></i>
                            <strong class="text-gray-800">Team:</strong>
                            <span class="ml-2 text-gray-600">{{ $feedback->team->name }}</span>
                        </div>
                        <div>
                            <div class="flex items-start mb-1">
                                <i class="fas fa-comment mr-2 text-indigo-600 mt-1"></i>
                                <strong class="text-gray-800">Content:</strong>
                            </div>
                            <p class="text-gray-600 ml-6 leading-relaxed">{{ $feedback->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $platformFeedbacks->links('vendor.pagination.custom') }}
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
    
    /* Scrollbar for feedback list */
    .styled-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    
    .styled-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .styled-scrollbar::-webkit-scrollbar-thumb {
        background: #818cf8;
        border-radius: 4px;
    }
    
    .styled-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #4f46e5;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-7xl {
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
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
        });
    });
</script>
@endpush