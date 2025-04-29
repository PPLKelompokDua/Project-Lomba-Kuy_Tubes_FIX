@extends('layouts.app')

@section('content')
<h1>All Stories & Prestasi</h1>
<a href="{{ route('stories.create') }}">Create New</a>

@foreach ($stories as $story)
    <div>
        <h2>{{ $story->title }} ({{ $story->type }})</h2>
        <p>{{ $story->content }}</p>
        <a href="{{ route('stories.show', $story) }}">View</a>
        <a href="{{ route('stories.edit', $story) }}">Edit</a>
        <form action="{{ route('stories.destroy', $story) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
@endforeach
@endsection
