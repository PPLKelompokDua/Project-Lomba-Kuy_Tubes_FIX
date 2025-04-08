@extends('layouts.app')

@section('title', 'Dashboard - LombaKuy')

@section('content')
<div class="bg-gradient-to-b from-indigo-500 to-gray-50 text-gray-800 py-16 rounded-xl shadow-inner">
    <div class="container mx-auto px-6">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-white drop-shadow-lg">
                Welcome Back, {{ auth()->user()->name }}!
            </h1>
            <p class="text-lg text-indigo-100 mt-4 max-w-xl mx-auto">
                Explore competitions, articles, events, and forums — all in one place.
            </p>
        </div>

        <!-- Grid Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Competition -->
            <a href="{{ route('competitions.index') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition hover:bg-indigo-50">
                <div class="flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center group-hover:bg-indigo-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 12c4.418 0 8-3.582 8-8m-8 8a8 8 0 01-8-8m8 8v8m0 0l-4-4m4 4l4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-indigo-700 group-hover:text-indigo-900">Competitions</h3>
                    <p class="text-sm text-gray-500 mt-2">Browse upcoming and ongoing competitions.</p>
                </div>
            </a>

            <!-- Articles -->
            <a href="{{ route('articles.index') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition hover:bg-indigo-50">
                <div class="flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center group-hover:bg-indigo-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-indigo-700 group-hover:text-indigo-900">Articles</h3>
                    <p class="text-sm text-gray-500 mt-2">Get tips and insights for your competition journey.</p>
                </div>
            </a>

            <!-- Events -->
            <a href="{{ route('events.index') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition hover:bg-indigo-50">
                <div class="flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center group-hover:bg-indigo-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 16l-4-4m0 0l4-4m-4 4h16"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-indigo-700 group-hover:text-indigo-900">Events</h3>
                    <p class="text-sm text-gray-500 mt-2">Join seminars, workshops, and special meetups.</p>
                </div>
            </a>

            <!-- Forum -->
            <a href="{{ route('forum.index') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition hover:bg-indigo-50">
                <div class="flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center group-hover:bg-indigo-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 8h10M7 12h6m-6 4h8M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-indigo-700 group-hover:text-indigo-900">Forum</h3>
                    <p class="text-sm text-gray-500 mt-2">Connect and share ideas with fellow members.</p>
                </div>
            </a>
        </div>

        <!-- Extra Content -->
        <div class="bg-white mt-20 p-10 rounded-xl text-center shadow-inner">
            <h2 class="text-3xl font-extrabold text-indigo-600 mb-2">Ready to Compete?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Stay active, stay competitive, and keep growing. We’re here to help you thrive!
            </p>
        </div>
    </div>
</div>
@endsection
