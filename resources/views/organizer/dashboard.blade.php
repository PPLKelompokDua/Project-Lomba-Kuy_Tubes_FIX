@extends('layouts.app')

@section('title', 'Organizer Dashboard')

@section('content')
  <h2 class="text-3xl font-bold text-indigo-700 mb-6">Welcome Organizer, {{ auth()->user()->name }}</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
    <div class="bg-white shadow p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-indigo-600">Created Competitions</h3>
      <p class="text-4xl font-bold mt-2">4</p>
    </div>
    <div class="bg-white shadow p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-green-600">Total Registrants</h3>
      <p class="text-4xl font-bold mt-2">120</p>
    </div>
  </div>

  <div class="bg-white p-6 rounded-lg shadow">
    <h4 class="text-xl font-semibold mb-4 text-indigo-700">Recent Competitions You Created</h4>
    <table class="w-full table-auto border">
      <thead class="bg-indigo-100 text-left">
        <tr>
          <th class="p-3">Title</th>
          <th class="p-3">Deadline</th>
          <th class="p-3">Registrants</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t hover:bg-gray-50">
          <td class="p-3">Data Science Cup</td>
          <td class="p-3">2025-05-20</td>
          <td class="p-3">34</td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
          <td class="p-3">Coding Fest</td>
          <td class="p-3">2025-06-15</td>
          <td class="p-3">57</td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
