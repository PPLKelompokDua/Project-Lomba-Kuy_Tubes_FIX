@extends('layouts.app')

@section('title', 'Review Task Board')

@section('content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #3730a3;
        --primary-light: #6366f1;
        --secondary: #e0e7ff;
        --background: #f8fafc;
        --surface: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border: #e2e8f0;
        --shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.1;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .controls-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        margin-top: -1rem;
        position: relative;
        z-index: 10;
        box-shadow: var(--shadow);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-enhanced {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
    }

    .btn-primary-enhanced {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: white;
        box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.3);
    }

    .btn-primary-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px 0 rgba(79, 70, 229, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary-enhanced {
        background: var(--surface);
        color: var(--text-primary);
        border: 2px solid var(--border);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-secondary-enhanced:hover {
        background: var(--secondary);
        border-color: var(--primary-color);
        transform: translateY(-1px);
        color: var(--text-primary);
        text-decoration: none;
    }

    .kanban-board {
        display: flex;
        flex-wrap: nowrap; /* Prevent wrapping to the next line */
        gap: 1rem; /* Reduced gap for better fit */
        padding: 2rem 1rem; /* Reduced padding */
        max-width: 100%; /* Fit within viewport */
        margin: 0 auto;
        overflow-x: hidden; /* Disable horizontal scrolling */
    }

    .kanban-column {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1rem; /* Reduced padding */
        box-shadow: var(--shadow);
        border: 1px solid rgba(255, 255, 255, 0.2);
        min-height: 400px;
        position: relative;
        transition: all 0.3s ease;
        flex: 1; /* Distribute available space equally */
        min-width: 200px; /* Minimum width to ensure readability */
        max-width: 300px; /* Maximum width to prevent over-expansion */
    }

    .kanban-column:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .kanban-column[data-status="pending"] .kanban-header {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    }

    .kanban-column[data-status="in_progress"] .kanban-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .kanban-column[data-status="in_review"] .kanban-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .kanban-column[data-status="completed"] .kanban-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .kanban-column[data-status="blocked"] .kanban-header {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .kanban-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        font-weight: 700;
        padding: 0.75rem 1rem; /* Reduced padding */
        border-radius: 0.75rem;
        text-align: center;
        margin-bottom: 1rem; /* Reduced margin */
        position: relative;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem; /* Slightly smaller font */
        overflow: visible;
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kanban-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .kanban-header:hover::before {
        left: 100%;
    }

    .task-list {
        min-height: 250px;
        position: relative;
    }

    .task-card {
        background: var(--surface);
        padding: 1rem; /* Reduced padding */
        margin-bottom: 0.75rem; /* Reduced margin */
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        cursor: grab;
        position: relative;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    .task-card:active {
        cursor: grabbing;
        transform: rotate(2deg) scale(1.02);
    }

    .task-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-color);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .task-card:hover::before {
        opacity: 1;
    }

    .task-title {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem; /* Reduced margin */
        font-size: 1rem; /* Slightly smaller font */
        line-height: 1.3; /* Adjusted for better fit */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap; /* Prevent text wrapping */
    }

    .task-meta {
        font-size: 0.8rem; /* Reduced font size */
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .task-meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.2rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .task-meta-icon {
        width: 14px; /* Reduced icon size */
        height: 14px;
        opacity: 0.7;
    }

    .badge-overdue {
        position: absolute;
        top: 8px; /* Adjusted for smaller card */
        right: 8px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.2rem 0.4rem;
        font-size: 0.65rem; /* Reduced font size */
        font-weight: 600;
        border-radius: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .drop-zone {
        min-height: 80px; /* Reduced height */
        border: 2px dashed transparent;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-style: italic;
        font-size: 0.85rem;
    }

    .drop-zone.drag-over {
        border-color: var(--primary-color);
        background: var(--secondary);
        color: var(--primary-color);
    }

    .empty-state {
        text-align: center;
        padding: 1.5rem; /* Reduced padding */
        color: var(--text-secondary);
        font-style: italic;
        font-size: 0.85rem;
    }

    .task-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        width: 20px; /* Reduced size */
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem; /* Reduced font size */
        font-weight: 600;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .controls-container {
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }

        .kanban-board {
            padding: 1rem 0.5rem;
            gap: 0.5rem; /* Further reduced gap */
        }

        .kanban-column {
            min-width: 180px; /* Further reduced min-width for mobile */
            max-width: 250px;
            padding: 0.75rem;
        }

        .kanban-header {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            min-height: 40px;
        }

        .task-card {
            padding: 0.75rem;
        }

        .task-title {
            font-size: 0.9rem;
        }

        .task-meta {
            font-size: 0.75rem;
        }

        .task-meta-icon {
            width: 12px;
            height: 12px;
        }

        .badge-overdue {
            top: 6px;
            right: 6px;
            font-size: 0.6rem;
            padding: 0.15rem 0.3rem;
        }

        .task-count {
            width: 18px;
            height: 18px;
            font-size: 0.6rem;
        }
    }
</style>

<div class="page-header rounded-[10px]">
    <h1 class="page-title">Task Review Board</h1>
    <p class="page-subtitle">Manage and track your team's progress with style</p>
</div>

<div class="controls-container">
    <a href="{{ route('tasks.team', $team->id) }}" class="btn-enhanced btn-primary-enhanced">
        <svg class="task-meta-icon" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
        </svg>
        Create New Task
    </a>
    <a href="{{ route('milestones.index', $team->id) }}" class="btn-enhanced btn-secondary-enhanced">
        <svg class="task-meta-icon" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
        </svg>
        View Milestones
    </a>
</div>

<div class="kanban-board">
    @php
        $statusMap = [
            'pending' => 'To Do',
            'in_progress' => 'In Progress',
            'in_review' => 'In Review',
            'completed' => 'Done',
            'blocked' => 'Blocked',
        ];

        $today = \Carbon\Carbon::today();
    @endphp

    @foreach ($statusMap as $statusKey => $label)
        @php
            $taskCount = count($tasks[$statusKey] ?? []);
        @endphp
        <div class="kanban-column" data-status="{{ $statusKey }}" ondragover="allowDrop(event)" ondrop="drop(event, '{{ $statusKey }}')">
            <div class="kanban-header">
                {{ $label }}
                @if($taskCount > 0)
                    <span class="task-count">{{ $taskCount }}</span>
                @endif
            </div>
            <div class="task-list">
                @forelse (($tasks[$statusKey] ?? []) as $task)
                    @php
                        $isLeader = auth()->id() === $team->leader_id;
                        $isAssigned = $task->assigned_user_id === auth()->id();
                        $canDrag = $isLeader || $isAssigned;
                        $isOverdue = $task->due_date && $task->status !== 'completed' && \Carbon\Carbon::parse($task->due_date)->lt($today);
                    @endphp
                    <div class="task-card"
                         @if($canDrag) draggable="true" @endif
                         data-id="{{ $task->id }}"
                         data-status="{{ $task->status }}"
                         data-title="{{ $task->title }}"
                         data-due-date="{{ $task->due_date }}"
                         data-author="{{ optional($task->assignedUser)->name ?? 'Unassigned' }}"
                         data-start="{{ $task->created_at->format('Y-m-d') }}"
                         data-end="{{ $task->due_date }}">
                         
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-meta">
                            <div class="task-meta-item">
                                <svg class="task-meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span><strong>Assigned to:</strong> {{ optional($task->assignedUser)->name ?? 'Unassigned' }}</span>
                            </div>
                            <div class="task-meta-item">
                                <svg class="task-meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span><strong>Deadline:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No deadline' }}</span>
                            </div>
                        </div>

                        @if($isOverdue)
                            <div class="badge-overdue">Overdue</div>
                        @endif
                    </div>
                @empty
                
                @endforelse
            </div>
        </div>
    @endforeach
</div>

<script>
let draggedTask = null;

function allowDrop(e) {
    e.preventDefault();
}

document.querySelectorAll('.task-card[draggable="true"]').forEach(card => {
    card.addEventListener('dragstart', e => {
        draggedTask = e.target;
    });
});

function drop(e, newStatus) {
    e.preventDefault();
    if (!draggedTask) return;

    const oldStatus = draggedTask.dataset.status;
    if (oldStatus === newStatus) return;

    if (confirm(`Are you sure you want to move this task to '${newStatus.replace('_', ' ').toUpperCase()}'?`)) {
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
                alert('Failed to update status in the database.');
            }
        })
        .catch(() => alert('An error occurred during the update.'));
    }
}
</script>
@endsection