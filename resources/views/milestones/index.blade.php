@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('milestones.create', $competition->id) }}" class="btn btn-primary mb-4">➕ Tambah Milestone</a>

    <div class="mb-4">
        <label for="filterStatus" class="form-label">Filter Status:</label>
        <select id="filterStatus" class="form-select" onchange="filterMilestones()">
            <option value="all">Semua</option>
            <option value="Not Started">Not Started</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>
    </div>

    <div class="row" id="milestoneContainer">
        @forelse ($competition->milestones as $milestone)
            <div class="col-md-6 col-lg-4 mb-4 milestone-card" data-status="{{ $milestone->status }}">
                <div class="card text-white shadow milestone-hover" style="background-color: #6C63FF;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $milestone->title }}</h5>
                        <p class="card-text text-light small mb-1">
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($milestone->start_date)->format('d M Y') }}
                            &ndash;
                            {{ \Carbon\Carbon::parse($milestone->end_date)->format('d M Y') }}
                        </p>
                        <span class="badge 
                            @if($milestone->status === 'Completed') bg-success
                            @elseif($milestone->status === 'In Progress') bg-info
                            @else bg-secondary
                            @endif">
                            {{ $milestone->status }}
                        </span>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between">
                        <a href="{{ route('milestones.edit', [$competition->id, $milestone->id]) }}" class="btn btn-sm btn-warning">✏️ Edit</a>

                        <form action="{{ route('milestones.destroy', [$competition->id, $milestone->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus milestone ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada milestone yang ditambahkan.</div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    function filterMilestones() {
        const status = document.getElementById('filterStatus').value;
        const cards = document.querySelectorAll('.milestone-card');

        cards.forEach(card => {
            const cardStatus = card.getAttribute('data-status');
            if (status === 'all' || cardStatus === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush

<style>
    .milestone-hover {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
    }

    .milestone-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection
