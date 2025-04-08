@extends('layout.app')

@section('title', 'Organizer Dashboard - LombaKuy')

@section('content')
<div class="bg-gradient-to-b from-indigo-600 to-gray-50 text-gray-800 py-16">
    <div class="container mx-auto px-6">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-white drop-shadow-lg">
                Welcome, {{ auth()->user()->name }}!
            </h1>
            <p class="text-lg text-gray-200 mt-4">
                As an organizer, manage your competitions easily and keep participants informed.
            </p>
        </div>

        <!-- Organizer Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
            <!-- Manage Competitions -->
            <a href="{{ route('competitions.manage') }}" class="group relative bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:bg-indigo-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-t-lg"></div>
                <div class="flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full mx-auto group-hover:bg-indigo-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-center mt-6 text-indigo-500 group-hover:text-indigo-800 transition">
                    Manage Competitions
                </h3>
                <p class="text-center text-gray-500 mt-3">
                    Create, update, and oversee competition details.
                </p>
            </a>

            <!-- Registration Management -->
            <a href="{{ route('registrations.manage') }}" class="group relative bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:bg-indigo-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-t-lg"></div>
                <div class="flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full mx-auto group-hover:bg-indigo-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4m8 0a4 4 0 01-8 0m8 0h4m-4 0h-4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-center mt-6 text-indigo-500 group-hover:text-indigo-800 transition">
                    Manage Registrations
                </h3>
                <p class="text-center text-gray-500 mt-3">
                    Oversee and update competition registration links.
                </p>
            </a>

            <!-- Messaging / Team Matching -->
            <a href="{{ route('organizer.messaging') }}" class="group relative bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:bg-indigo-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-t-lg"></div>
                <div class="flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full mx-auto group-hover:bg-indigo-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h11l5 5z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-center mt-6 text-indigo-500 group-hover:text-indigo-800 transition">
                    Messaging
                </h3>
                <p class="text-center text-gray-500 mt-3">
                    Communicate with prospective participants and teams.
                </p>
            </a>
        </div>

        <!-- Organizer Inspirational Section -->
        <div class="bg-white p-12 rounded-xl shadow-md relative overflow-hidden mb-16">
            <h2 class="text-3xl font-extrabold text-indigo-500 text-center mb-4 z-10 relative">Lead with Excellence</h2>
            <p class="text-center text-gray-700 leading-relaxed z-10 relative">
                Empower your competition by providing clear, dynamic, and up-to-date information.
            </p>
        </div>
    </div>
</div>
@endsection
