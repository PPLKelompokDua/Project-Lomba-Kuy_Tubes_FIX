@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
  <h1 class="text-4xl font-bold mb-6 text-indigo-600">Welcome, Admin!</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-lg font-semibold mb-2">Total Users</h2>
          <p class="text-3xl font-bold text-indigo-700">123</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-lg font-semibold mb-2">Total Competitions</h2>
          <p class="text-3xl font-bold text-indigo-700">15</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-lg font-semibold mb-2">Active Organizers</h2>
          <p class="text-3xl font-bold text-indigo-700">7</p>
      </div>
  </div>
@endsection
