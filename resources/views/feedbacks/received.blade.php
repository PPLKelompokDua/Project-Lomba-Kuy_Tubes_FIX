@extends('layouts.app')

@section('title', 'Received Feedbacks')

@section('content')
<div class="container py-6 max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('feedbacks.index') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-md hover:shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Feedback
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <h2 class="mb-6 text-2xl font-bold text-indigo-700 border-b pb-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            Feedback yang Kamu Terima
        </h2>

        @if ($feedbacksForMe->isEmpty())
            <div class="bg-blue-50 text-blue-700 p-4 rounded-lg border border-blue-200 flex items-center" dusk="no-feedback-message">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Belum ada feedback yang kamu terima.</span>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 md:gap-6" dusk="received-feedback-list">
                @foreach ($feedbacksForMe as $feedback)
                <div class="bg-gray-50 hover:bg-indigo-50 transition-colors duration-200 rounded-lg shadow-sm hover:shadow p-5 border border-gray-200" dusk="received-feedback-item-{{ $feedback->id }}">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-3">
                        <div class="flex-grow">
                            <div class="flex items-center mb-2">
                                <div class="h-10 w-10 rounded-full bg-indigo-600 text-white flex items-center justify-center mr-3">
                                    <span class="font-bold">{{ substr($feedback->sender?->name ?? 'User', 0, 1) }}</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $feedback->sender?->name ?? 'Pengguna Tidak Dikenal' }}</h3>
                                    <p class="text-gray-500 text-sm">Pengirim Feedback</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                            <div class="mb-1 text-sm text-gray-600">
                                <span class="font-medium text-indigo-700">Tim:</span> 
                                {{ $feedback->team->name ?? '-' }}
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium text-indigo-700">Lomba:</span> 
                                {{ $feedback->team->competition_name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h4 class="font-medium text-indigo-600 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Isi Feedback:
                        </h4>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-inner whitespace-pre-line text-gray-700" dusk="received-feedback-content-{{ $feedback->id }}">
                            {{ $feedback->content }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection