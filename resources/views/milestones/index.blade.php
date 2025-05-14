@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Milestone - {{ $competition->title }}</h2>
    <a href="{{ route('milestones.create', $competition->id) }}" class="btn btn-primary">Tambah Milestone</a>

    <ul class="list-group mt-4">
        @foreach ($competition->milestones as $milestone)
            <li class="list-group-item">
                <strong>{{ $milestone->title }}</strong><br>
                {{ $milestone->start_date }} - {{ $milestone->end_date }}<br>
                Status: <span class="badge bg-info">{{ $milestone->status }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
