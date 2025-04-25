@extends('layouts.app')

@section('title', 'Competitions')

@section('content')
<!-- Page header with actions -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage Competitions</h1>
            <p class="mt-1 text-sm text-gray-500">View, create and manage your competitions</p>
        </div>
        @if(Auth::user()->isOrganizer() || Auth::user()->isAdmin())
        <a href="{{ route('competitions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
            <i class="bi bi-plus-circle mr-2"></i> Create New Competition
        </a>
        @endif
    </div>
</div>

@if(count($competitions) > 0)
<div class="bg-white overflow-hidden shadow-md rounded-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Location
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Registration Deadline
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Start Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($competitions as $competition)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $competition->title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $competition->location }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $competition->registration_deadline->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $competition->start_date->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $competition->status === 'open' ? 'bg-green-100 text-green-800' : 
                               ($competition->status === 'closed' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($competition->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('competitions.show', $competition->id) }}" 
                               class="inline-flex items-center px-2.5 py-1.5 border border-indigo-500 text-xs font-medium rounded text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
                                <i class="bi bi-eye mr-1"></i> View
                            </a>
                            @if((Auth::user()->isOrganizer() && $competition->organizer_id === Auth::id()) || Auth::user()->isAdmin())
                            <a href="{{ route('competitions.edit', $competition->id) }}" 
                               class="inline-flex items-center px-2.5 py-1.5 border border-yellow-500 text-xs font-medium rounded text-yellow-600 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-150 ease-in-out">
                                <i class="bi bi-pencil mr-1"></i> Edit
                            </a>
                            <form action="{{ route('competitions.destroy', $competition->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this competition?')"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-red-500 text-xs font-medium rounded text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150 ease-in-out">
                                    <i class="bi bi-trash mr-1"></i> Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="py-4 px-6 border-t border-gray-200">
        <div class="flex justify-center">
            {{ $competitions->links() }}
        </div>
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-md overflow-hidden text-center py-12 px-6">
    <div class="mx-auto w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
        <i class="bi bi-trophy text-indigo-600 text-2xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-800 mb-2">No Competitions Found</h3>
    <p class="text-gray-500 mb-6">There are no competitions available at this time.</p>
    @if(Auth::user()->isOrganizer())
    <a href="{{ route('competitions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
        <i class="bi bi-plus-circle mr-2"></i> Create Your First Competition
    </a>
    @endif
</div>
@endif
@endsection