@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Competitions</h1>
        @if(Auth::user()->isOrganizer() || Auth::user()->isAdmin())
        <a href="{{ route('competitions.create') }}" class="btn btn-primary">Create New Competition</a>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(count($competitions) > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Registration Deadline</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($competitions as $competition)
                        <tr>
                            <td>{{ $competition->title }}</td>
                            <td>{{ $competition->location }}</td>
                            <td>{{ $competition->registration_deadline->format('M d, Y') }}</td>
                            <td>{{ $competition->start_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $competition->status === 'open' ? 'success' : ($competition->status === 'closed' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($competition->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('competitions.show', $competition->id) }}" class="btn btn-sm btn-info">View</a>
                                    @if((Auth::user()->isOrganizer() && $competition->organizer_id === Auth::id()) || Auth::user()->isAdmin())
                                    <a href="{{ route('competitions.edit', $competition->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('competitions.destroy', $competition->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this competition?')">Delete</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $competitions->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        No competitions found. 
        @if(Auth::user()->isOrganizer())
        <a href="{{ route('competitions.create') }}">Create your first competition</a>
        @endif
    </div>
    @endif
</div>
@endsection
