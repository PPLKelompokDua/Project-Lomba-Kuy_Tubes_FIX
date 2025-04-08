@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-8">
    <h1 class="text-4xl font-extrabold text-pink-500 mb-8 text-center">Admin Dashboard</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Users -->
        <div class="bg-gradient-to-r from-pink-300 to-pink-500 text-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <h3 class="text-lg font-semibold">Total Users</h3>
            <p class="text-5xl font-extrabold mt-3">500</p>
        </div>
        <!-- Total Articles -->
        <div class="bg-gradient-to-r from-green-300 to-green-500 text-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <h3 class="text-lg font-semibold">Total Articles</h3>
            <p class="text-5xl font-extrabold mt-3">15</p>
        </div>
        <!-- Total Events -->
        <div class="bg-gradient-to-r from-blue-300 to-blue-500 text-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <h3 class="text-lg font-semibold">Total Events</h3>
            <p class="text-5xl font-extrabold mt-3">12</p>
        </div>
        <!-- Forum or Feedback -->
        <div class="bg-gradient-to-r from-yellow-300 to-yellow-500 text-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <h3 class="text-lg font-semibold">Total Forum Questions</h3>
            <p class="text-5xl font-extrabold mt-3">350</p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('profiles.index') }}" 
           class="flex flex-col items-center justify-center bg-blue-500 text-white py-6 px-8 rounded-lg shadow-md hover:shadow-lg hover:bg-blue-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M16 11V7a4 4 0 00-8 0v4m8 0a4 4 0 01-8 0m8 0h4m-4 0h-4" />
            </svg>
            <span class="text-lg font-semibold">Manage Users</span>
        </a>

        <a href="{{ route('event.index') }}" 
           class="flex flex-col items-center justify-center bg-yellow-500 text-white py-6 px-8 rounded-lg shadow-md hover:shadow-lg hover:bg-yellow-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M12 4v16m8-8H4" />
            </svg>
            <span class="text-lg font-semibold">Manage Events</span>
        </a>

        <a href="{{ route('article.index') }}" 
           class="flex flex-col items-center justify-center bg-green-500 text-white py-6 px-8 rounded-lg shadow-md hover:shadow-lg hover:bg-green-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M9 17v2m0-6v2m6-2v2m0-6v2" />
            </svg>
            <span class="text-lg font-semibold">Manage Articles</span>
        </a>

        <a href="{{ route('admin.forum.index') }}" 
           class="flex flex-col items-center justify-center bg-orange-500 text-white py-6 px-8 rounded-lg shadow-md hover:shadow-lg hover:bg-orange-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M3 10h18M3 14h18M3 6h18M3 18h18" />
            </svg>
            <span class="text-lg font-semibold">Manage Forums</span>
        </a>

        <a href="{{ route('donation_feedback.index') }}" 
           class="flex flex-col items-center justify-center bg-purple-500 text-white py-6 px-8 rounded-lg shadow-md hover:shadow-lg hover:bg-purple-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <span class="text-lg font-semibold">Manage Feedbacks</span>
        </a>

        <a href="#" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="flex flex-col items-center justify-center bg-red-500 text-white py-6 px-8 rounded-lg shadow-md hover:shadow-lg hover:bg-red-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="text-lg font-semibold">Logout</span>
        </a>
    </div>
</div>
@endsection
