@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
  <h2 class="text-3xl font-bold text-indigo-700 mb-6">Welcome, {{ auth()->user()->name }}</h2>

    <!-- Tombol invitation yang lebih stylish -->
    <a href="{{ route('invitations.index') }}" class="btn btn-outline-primary d-flex align-items-center gap-2 shadow-sm px-4 py-2">
        <i class="bi bi-person-plus-fill"></i> <!-- Bootstrap Icon -->
        <span>Manage Team Invitations</span>
    </a>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white shadow p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-indigo-600">Competitions</h3>
      <p class="text-4xl font-bold mt-2">8</p>
    </div>
    <div class="bg-white shadow p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-green-600">Events</h3>
      <p class="text-4xl font-bold mt-2">3</p>
    </div>
    <div class="bg-white shadow p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-yellow-600">Forum Posts</h3>
      <p class="text-4xl font-bold mt-2">12</p>
    </div>
  </div>

  <div class="bg-white p-6 rounded-lg shadow">
    <h4 class="text-xl font-semibold mb-4 text-indigo-700">Your Registered Competitions</h4>
    <ul class="space-y-2">
      <li class="border p-3 rounded hover:bg-gray-100">UI/UX Hackfest 2025</li>
      <li class="border p-3 rounded hover:bg-gray-100">AI Challenge 2025</li>
      <li class="border p-3 rounded hover:bg-gray-100">Marketing War 2025</li>
    </ul>
  </div>
@endsection
