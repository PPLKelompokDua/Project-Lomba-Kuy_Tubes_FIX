@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary">📌 Timeline untuk Tim: <strong>{{ $team->name }}</strong></h3>

    @if ($team->competition_name)
        <p class="mb-4 text-muted">Kompetisi: <strong>{{ $team->competition_name }}</strong></p>
    @endif

    <!-- Tombol -->
    <a href="{{ route('milestones.create', $team->id) }}" class="btn btn-primary mb-4">➕ Tambah Milestone</a>
    <a href="{{ route('reviewtugas.index', ['team_id' => $team->id]) }}" class="btn btn-secondary mb-4">📋 Review Tugas</a>

    <!-- Filter untuk tugas anggota -->
    <div class="mb-4">
        <label for="filterStatus" class="form-label">Filter Tugas:</label>
        <select id="filterStatus" class="form-select" onchange="filterTasks()">
            <option value="all">Semua</option>
            <option value="Not Started">Not Started</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>
    </div>

    <!-- === TIMELINE (MILESTONES) === -->
    <h5 class="mb-3 text-secondary">📅 Timeline Tim</h5>
    <div class="row" id="milestoneContainer">
        @forelse ($milestones as $milestone)
            <div class="col-md-6 col-lg-4 mb-4 milestone-card">
                <div class="card text-white shadow milestone-hover" style="background-color: #6C63FF;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $milestone->title }}</h5>
                        <p class="card-text text-light small mb-0">
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($milestone->start_date)->format('d M Y') }}
                            &ndash;
                            {{ \Carbon\Carbon::parse($milestone->end_date)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada milestone.</p>
        @endforelse
    </div>

    <!-- === TASKS === -->
    <h5 class="mt-5 mb-3 text-secondary">🧩 Tugas Anggota</h5>
    <div class="row" id="taskContainer">
        @forelse ($tasks as $task)
            <div class="col-md-6 col-lg-4 mb-4 task-card" data-status="{{ $task->status }}">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $task->title }}</h5>
                        <p class="card-text text-muted small mb-1">
                            <i class="bi bi-calendar-check"></i>
                            Deadline: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'Tidak ditentukan' }}
                        </p>
                        <span class="badge 
                            @if($task->status === 'completed') bg-success
                            @elseif($task->status === 'in_progress') bg-info
                            @else bg-secondary
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada tugas untuk tim ini.</p>
        @endforelse

        <!-- Pesan ketika filter tugas menghasilkan kosong -->
        <div id="noTaskMessage" class="text-muted" style="display: none;">
            Tidak ada tugas dengan status tersebut.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterTasks() {
        const selectedStatus = document.getElementById('filterStatus').value;

        const taskCards = document.querySelectorAll('.task-card');
        let visibleCount = 0;

        taskCards.forEach(card => {
            const rawStatus = card.getAttribute('data-status');
            const statusMap = {
                'pending': 'Not Started',
                'in_progress': 'In Progress',
                'completed': 'Completed'
            };
            const mapped = statusMap[rawStatus] || 'Not Started';
            const visible = selectedStatus === 'all' || mapped === selectedStatus;

            card.style.display = visible ? 'block' : 'none';
            if (visible) visibleCount++;
        });

        document.getElementById('noTaskMessage').style.display = visibleCount === 0 ? 'block' : 'none';
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
