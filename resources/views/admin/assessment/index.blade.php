@extends('layouts.admin')

@section('title', 'Assessment Questions')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-6 text-indigo-600" data-aos="fade-up">List of Assessment Questions</h1>

    <!-- Success Notification -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6" data-aos="fade-up" data-aos-delay="100">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Question Button -->
    <a href="{{ route('admin.assessment-questions.create') }}" class="inline-flex items-center mb-6 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium hover-rise" data-aos="fade-up" data-aos-delay="150">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add Question
    </a>

    <!-- Questions Table -->
    <div class="bg-white p-6 rounded-lg shadow hover-rise" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-xl font-bold mb-4 text-indigo-700">All Questions</h2>

        @if ($questions->count())
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm border">
                    <thead class="bg-indigo-100 text-left">
                        <tr>
                            <th class="p-3">Category</th>
                            <th class="p-3">Question</th>
                            <th class="p-3">Answer A</th>
                            <th class="p-3">Answer B</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $q)
                            <tr class="border-t hover:bg-gray-50" data-aos="fade-up" data-aos-delay="{{ 300 + $loop->index * 50 }}">
                                <td class="p-3">{{ $q->category }}</td>
                                <td class="p-3">{{ $q->question }}</td>
                                <td class="p-3">{{ $q->options->where('label', 'A')->first()->text ?? '-' }}</td>
                                <td class="p-3">{{ $q->options->where('label', 'B')->first()->text ?? '-' }}</td>
                                <td class="p-3 space-x-2 text-center">
                                    <a href="{{ route('admin.assessment-questions.edit', $q->id) }}" class="text-indigo-600 hover:text-indigo-800 flex items-center justify-center text-sm font-semibold transition">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.assessment-questions.destroy', $q->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 flex items-center justify-center text-sm font-semibold transition" type="submit">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600" data-aos="fade-up" data-aos-delay="250">No questions available yet.</p>
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
    
    /* Button hover glow */
    a, button[type="submit"] {
        position: relative;
    }
    
    a::after, button[type="submit"]::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        z-index: -1;
        border-radius: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    a:hover::after, button[type="submit"]:hover::after {
        opacity: 0.5;
    }
    
    /* Scrollbar for table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #818cf8;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
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