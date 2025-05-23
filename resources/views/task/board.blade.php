@extends('layouts.app')

@section('content')
<style>
    .kanban-board {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: 2rem;
    }
    .kanban-column {
        flex: 1;
        background-color: #f8f9ff;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        min-height: 300px;
    }
    .kanban-header {
        background-color: #6c3ef6;
        color: white;
        font-weight: bold;
        padding: 0.5rem;
        border-radius: 0.375rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    .task-card {
        background-color: #fff;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        cursor: grab;
    }
</style>

<div class="text-center py-6 bg-[#6c3ef6] text-white text-2xl font-bold">LombaKuy Review Tugas Board</div>

<div class="kanban-board">
    @php
        $statusMap = [
            'pending' => 'To Do',
            'in_progress' => 'In Progress',
            'in_review' => 'In Review',
            'completed' => 'Done',
            'blocked' => 'Blocked',
        ];
    @endphp

    @foreach ($statusMap as $statusKey => $label)
        <div class="kanban-column" data-status="{{ $statusKey }}" ondragover="allowDrop(event)" ondrop="drop(event, '{{ $statusKey }}')">
            <div class="kanban-header">{{ $label }}</div>
            <div class="task-list min-h-[200px]">
                @foreach (($tasks[$statusKey] ?? []) as $task)
                    <div class="task-card" draggable="true"
                            data-id="{{ $task->id }}"
                            data-status="{{ $task->status }}"
                            data-title="{{ $task->title }}"
                            data-due-date="{{ $task->due_date }}"
                            data-author="{{ optional($task->assignedUser)->name ?? 'Tidak ditentukan' }}"
                            data-start="{{ $task->created_at->format('Y-m-d') }}"
                            data-end="{{ $task->due_date }}">
                        <div class="font-semibold">{{ $task->title }}</div>
                        <div class="text-sm text-gray-500">
                            Assigned to: {{ optional($task->assignedUser)->name ?? '-' }}<br>
                            Deadline: {{ $task->due_date ?? 'N/A' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script>
let draggedTask = null;

function allowDrop(e) {
    e.preventDefault();
}

document.querySelectorAll('.task-card').forEach(card => {
    card.addEventListener('dragstart', e => {
        draggedTask = e.target;
    });
});

function drop(e, newStatus) {
    e.preventDefault();
    if (!draggedTask) return;

    const oldStatus = draggedTask.dataset.status;
    if (oldStatus === newStatus) return;

    if (confirm(`Yakin ingin memindahkan tugas ini ke '${newStatus.replace('_', ' ').toUpperCase()}'?`)) {
        const taskId = draggedTask.dataset.id;

        fetch(`/reviewtugas/${taskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                _method: 'PUT',
                title: draggedTask.dataset.title,
                due_date: draggedTask.dataset.dueDate,
                status: newStatus,
                author: draggedTask.dataset.author,
                start_date: draggedTask.dataset.start,
                end_date: draggedTask.dataset.end
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                draggedTask.dataset.status = newStatus;
                e.target.closest('.kanban-column').querySelector('.task-list').appendChild(draggedTask);
            } else {
                alert('Gagal mengubah status di database.');
            }
        })
        .catch(() => alert('Terjadi kesalahan saat update.'));
    }
}
</script>
@endsection
