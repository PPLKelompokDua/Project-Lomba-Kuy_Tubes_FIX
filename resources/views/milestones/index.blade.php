@extends('layouts.app')

@section('title', 'Milestones and Task Timeline')

@section('content')
<div class="min-vh-100 bg-light">
    <!-- Header Section with Gradient Background -->
    <div class="position-relative mb-5">
        <div class="bg-gradient-to-r p-4 rounded-lg shadow-lg" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="mb-0 font-bold text-white text-4xl">{{ $team->name }}</h2>
                        @if ($team->competition_name)
                            <p class="text-blue-100 mb-3 opacity-80">
                                <i class="bi bi-trophy-fill me-2"></i>
                                {{ $team->competition_name }}
                            </p>
                        @endif
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 px-3 py-2 rounded-pill d-inline-flex align-items-center">
                                <i class="bi bi-bar-chart-fill me-2 text-white"></i>
                                <span class="text-white fw-medium">
                                    Milestones: {{ count($milestones) }} | Tasks: {{ count($tasks) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('teams.index') }}" class="btn px-4 py-2 btn-light shadow-sm fw-medium rounded-pill">
                            <i class="bi bi-arrow-left me-2 text-primary" style="color: #4f46e5 !important;"></i>Back to Teams
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <!-- Action Buttons -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="action-buttons-container">
                    <a href="{{ route('milestones.create', $team->id) }}" class="action-btn primary-btn">
                        <div class="btn-icon">
                            <i class="bi bi-plus-circle-fill"></i>
                        </div>
                        <div class="btn-content">
                            <div class="btn-title">Add Milestone</div>
                            <div class="btn-subtitle">Create a new milestone</div>
                        </div>
                    </a>
                    
                    <a href="{{ route('reviewtugas.index', ['team_id' => $team->id]) }}" class="action-btn secondary-btn">
                        <div class="btn-icon">
                            <i class="bi bi-clipboard-check-fill"></i>
                        </div>
                        <div class="btn-content">
                            <div class="btn-title">Review Tasks</div>
                            <div class="btn-subtitle">Evaluate team progress</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Visual Timeline Section -->
        <div class="section-container mb-5">
            <div class="section-header">
                <div class="section-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="section-title">
                    <h3 class="mb-0">Visual Timeline</h3>
                    <p class="text-muted mb-0">Milestones and tasks over time</p>
                </div>
                <div class="zoom-controls ms-auto d-flex align-items-center gap-2">
                    <button id="zoomInBtn" class="btn btn-sm btn-outline-primary" title="Zoom In">
                        <i class="bi bi-zoom-in"></i>
                    </button>
                    <button id="zoomOutBtn" class="btn btn-sm btn-outline-primary" title="Zoom Out">
                        <i class="bi bi-zoom-out"></i>
                    </button>
                    <input type="range" id="zoomSlider" min="0.5" max="3" step="0.1" value="1" class="form-range" style="width: 120px;">
                </div>
            </div>

            @php
                // Determine timeline range, starting from team creation date
                $allDates = [];
                $teamCreationDate = \Carbon\Carbon::parse($team->created_at)->startOfDay();

                foreach ($milestones as $milestone) {
                    $allDates[] = \Carbon\Carbon::parse($milestone->start_date);
                    $allDates[] = \Carbon\Carbon::parse($milestone->end_date);
                }
                foreach ($tasks as $status => $taskGroup) {
                    foreach ($taskGroup as $task) {
                        $dueDate = $task->due_date ? \Carbon\Carbon::parse($task->due_date) : $teamCreationDate;
                        $allDates[] = $dueDate;
                    }
                }

                if (empty($allDates)) {
                    $minDate = $teamCreationDate;
                    $maxDate = \Carbon\Carbon::today()->addMonth();
                } else {
                    $minDate = min($allDates)->startOfDay();
                    $maxDate = max($allDates)->endOfDay();
                    if ($teamCreationDate->lt($minDate)) {
                        $minDate = $teamCreationDate;
                    }
                }

                $totalDays = $maxDate->diffInDays($minDate) ?: 1;
                $timelineStart = $minDate->copy();

                // Group tasks by due date to handle stacking
                $tasksByDueDate = [];
                foreach ($tasks as $status => $taskGroup) {
                    foreach ($taskGroup as $task) {
                        $dueDate = $task->due_date ? \Carbon\Carbon::parse($task->due_date)->toDateString() : $minDate->toDateString();
                        if (!isset($tasksByDueDate[$dueDate])) {
                            $tasksByDueDate[$dueDate] = [];
                        }
                        $tasksByDueDate[$dueDate][] = $task;
                    }
                }

                // Define interval for date markers (e.g., every 7 days)
                $dateInterval = max(7, floor($totalDays / 10)); // Adjust based on total days, minimum 7 days
            @endphp

            <div class="timeline-wrapper" id="timelineWrapper">
                <!-- Timeline Content Container -->
                <div class="timeline-content" id="timelineContent">
                    <!-- Timeline Bar -->
                    <div class="timeline-bar" id="timelineBar"></div>

                    <!-- Timeline Date Markers -->
                    <div class="timeline-date-markers" id="timelineDateMarkers">
                        @php
                            $currentDate = $minDate->copy();
                            while ($currentDate <= $maxDate) {
                                $position = $currentDate->diffInDays($minDate) / $totalDays * 100;
                                if ($position > 100) $position = 100;
                                $isEarliest = $currentDate->eq($minDate);
                                $isLatest = $currentDate->eq($maxDate);
                                $markerClass = $isEarliest ? 'date-earliest' : ($isLatest ? 'date-latest' : '');
                        @endphp
                        <div class="timeline-date-marker {{ $markerClass }}" style="left: {{ $position }}%;">
                            <div class="date-label">{{ $currentDate->format('d M Y') }}</div>
                            <div class="date-tick"></div>
                        </div>
                        @php
                                $currentDate->addDays($dateInterval);
                            }
                        @endphp
                    </div>

                    <!-- Milestones -->
                    @foreach ($milestones as $milestone)
                        @php
                            $start = \Carbon\Carbon::parse($milestone->start_date);
                            $end = \Carbon\Carbon::parse($milestone->end_date);
                            $startPosition = $start->diffInDays($minDate) / $totalDays * 100;
                            $endPosition = $end->diffInDays($minDate) / $totalDays * 100;
                            $width = $endPosition - $startPosition;
                            if ($width < 0) $width = 0;
                            if ($startPosition < 0) $startPosition = 0;
                            if ($endPosition > 100) $endPosition = 100;
                            $statusClass = $milestone->status === 'Completed' ? 'milestone-completed' : ($milestone->status === 'In Progress' ? 'milestone-progress' : 'milestone-pending');
                        @endphp
                        <div class="timeline-block {{ $statusClass }}" style="left: {{ $startPosition }}%; width: {{ $width }}%;" data-tooltip="true" data-tooltip-content="{{ $milestone->title }} ({{ $milestone->status }})<br>{{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}">
                            <div class="timeline-block-label">{{ $milestone->title }}</div>
                            <!-- Start Dot -->
                            <div class="timeline-dot milestone-dot-start" style="background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);"></div>
                            <!-- End Dot -->
                            <div class="timeline-dot milestone-dot-end" style="background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%); right: 0;"></div>
                        </div>
                    @endforeach

                    <!-- Tasks -->
                    @foreach ($tasksByDueDate as $dueDate => $taskGroup)
                        @php
                            $due = \Carbon\Carbon::parse($dueDate);
                            $position = $due->diffInDays($minDate) / $totalDays * 100;
                            if ($position < 0) $position = 0;
                            if ($position > 100) $position = 100;
                        @endphp
                        @foreach ($taskGroup as $index => $task)
                            @php
                                $statusClass = $task->status === 'completed' ? 'task-completed' : ($task->status === 'in_progress' ? 'task-progress' : ($task->status === 'in_review' ? 'task-review' : ($task->status === 'blocked' ? 'task-blocked' : 'task-pending')));
                                $isOverdue = $task->due_date && $due->lt(\Carbon\Carbon::today()) && $task->status !== 'completed';
                                $tooltipDate = $task->due_date ? 'Due: ' . $due->format('d M Y') : 'Due: Not specified';
                                $verticalOffset = 75 + ($index * 20); // 20% offset per task
                            @endphp
                            <div class="timeline-dot task-dot {{ $statusClass }} {{ $isOverdue ? 'task-overdue' : '' }}" style="left: {{ $position }}%; top: {{ $verticalOffset }}%;" data-tooltip="true" data-tooltip-content="{{ $task->title }} ({{ ucfirst(str_replace('_', ' ', $task->status)) }})<br>{{ $tooltipDate }}{{ $isOverdue ? '<br><span style=\"color: #ef4444;\">Overdue</span>' : '' }}">
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <!-- Timeline Legend -->
            <div class="timeline-legend">
                <div class="legend-item">
                    <span class="legend-dot task-dot task-completed"></span>
                    <span>Task - Completed</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot task-dot task-progress"></span>
                    <span>Task - In Progress</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot task-dot task-pending"></span>
                    <span>Task - Not Started</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot task-dot task-overdue"></span>
                    <span>Task - Overdue</span>
                </div>
            </div>
        </div>

        <!-- Timeline Section (Original List) -->
        <div class="section-container mb-5">
            <div class="section-header">
                <div class="section-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="section-title">
                    <h3 class="mb-0">Team Timeline</h3>
                    <p class="text-muted mb-0">Milestones and achievement targets</p>
                </div>
            </div>
            
            <div class="row" id="milestoneContainer">
                @forelse ($milestones as $index => $milestone)
                    <div class="col-lg-6 col-xl-4 mb-4 milestone-card">
                        <div class="milestone-item" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="milestone-header">
                                <div class="milestone-number">{{ $index + 1 }}</div>
                                <div class="milestone-date">
                                    {{ \Carbon\Carbon::parse($milestone->start_date)->format('d M') }}
                                    -
                                    {{ \Carbon\Carbon::parse($milestone->end_date)->format('d M Y') }}
                                </div>
                            </div>
                            <div class="milestone-body">
                                <h5 class="milestone-title">{{ $milestone->title }}</h5>
                                <div class="milestone-status">
                                    <span class="task-badge
                                        @if($milestone->status === 'Completed') badge-completed
                                        @elseif($milestone->status === 'In Progress') badge-progress
                                        @else badge-pending
                                        @endif">
                                        {{ $milestone->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="milestone-actions mt-2">
                                <a href="{{ route('milestones.edit', ['team' => $team->id, 'milestone' => $milestone->id]) }}" class="btn btn-sm btn-outline-light me-2">
                                    <i class="bi bi-pencil-fill me-1"></i>Edit
                                </a>
                                <form action="{{ route('milestones.destroy', ['team' => $team->id, 'milestone' => $milestone->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this milestone?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash-fill me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-calendar-x"></i>
                            </div>
                            <h5>No milestones yet</h5>
                            <p class="text-muted">Add your first milestone to start the team timeline</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="filter-container">
                    <div class="filter-header">
                        <h5 class="mb-0">Filter Tasks</h5>
                    </div>
                    <div class="filter-content">
                        <select id="filterStatus" class="form-select custom-select" onchange="filterTasks()">
                            <option value="all">All Status</option>
                            <option value="Not Started">Not Started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="In Review">In Review</option>
                            <option value="Completed">Completed</option>
                            <option value="Blocked">Blocked</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Section -->
        <div class="section-container">
            <div class="section-header">
                <div class="section-icon">
                    <i class="bi bi-puzzle"></i>
                </div>
                <div class="section-title">
                    <h3 class="mb-0">Member Tasks</h3>
                    <p class="text-muted mb-0">List of tasks and completion status</p>
                </div>
            </div>
            
            <div class="row" id="taskContainer">
                @forelse ($tasks as $status => $taskGroup)
                    @foreach ($taskGroup as $index => $task)
                        <div class="col-lg-6 col-xl-4 mb-4 task-card" data-status="{{ $task->status }}" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="task-item">
                                <div class="task-status-indicator 
                                    @if($task->status === 'completed') status-completed
                                    @elseif($task->status === 'in_progress') status-progress
                                    @elseif($task->status === 'in_review') status-review
                                    @elseif($task->status === 'blocked') status-blocked
                                    @else status-pending
                                    @endif">
                                </div>

                                <div class="task-header">
                                    <h5 class="task-title">{{ $task->title }}</h5>
                                    <div class="task-badge
                                        @if($task->status === 'completed') badge-completed
                                        @elseif($task->status === 'in_progress') badge-progress
                                        @elseif($task->status === 'in_review') badge-review
                                        @elseif($task->status === 'blocked') badge-blocked
                                        @else badge-pending
                                        @endif">
                                        {{ [
                                            'pending' => 'Not Started',
                                            'in_progress' => 'In Progress',
                                            'in_review' => 'In Review',
                                            'completed' => 'Completed',
                                            'blocked' => 'Blocked'
                                        ][$task->status] ?? ucfirst($task->status) }}
                                    </div>
                                </div>

                                <div class="task-meta">
                                    <div class="task-date">
                                        <i class="bi bi-calendar3"></i>
                                        <span>
                                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'Not specified' }}
                                        </span>
                                    </div>

                                    <div class="task-assigned mt-2">
                                        <i class="bi bi-person-fill"></i>
                                        <span>{{ optional($task->assignedUser)->name ?? 'Unassigned' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-puzzle"></i>
                            </div>
                            <h5>No tasks yet</h5>
                            <p class="text-muted">Tasks will appear here once added</p>
                        </div>
                    </div>
                @endforelse

                <!-- No Task Message -->
                <div id="noTaskMessage" class="col-12" style="display: none;">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h5>No tasks found</h5>
                        <p class="text-muted">No tasks found with the selected status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let zoomFactor = 1; // Default zoom level
    const minZoom = 0.5;
    const maxZoom = 3;

    function updateTimelineZoom() {
        const timelineContent = document.getElementById('timelineContent');
        const dateMarkers = document.querySelectorAll('.timeline-date-marker');
        const blocks = document.querySelectorAll('.timeline-block');
        const dots = document.querySelectorAll('.timeline-dot:not(.milestone-dot-start):not(.milestone-dot-end)'); // Exclude milestone dots

        // Reset any previous transforms
        dateMarkers.forEach(marker => {
            const originalLeft = parseFloat(marker.getAttribute('data-original-left') || marker.style.left);
            marker.setAttribute('data-original-left', originalLeft); // Store original position
            marker.style.left = `${originalLeft * zoomFactor}%`;
        });

        // Adjust milestone blocks
        blocks.forEach(block => {
            const originalLeft = parseFloat(block.getAttribute('data-original-left') || block.style.left);
            const originalWidth = parseFloat(block.getAttribute('data-original-width') || block.style.width);
            block.setAttribute('data-original-left', originalLeft);
            block.setAttribute('data-original-width', originalWidth);
            block.style.left = `${originalLeft * zoomFactor}%`;
            block.style.width = `${originalWidth * zoomFactor}%`;
        });

        // Adjust task dots
        dots.forEach(dot => {
            const originalLeft = parseFloat(dot.getAttribute('data-original-left') || dot.style.left);
            const originalTop = parseFloat(dot.getAttribute('data-original-top') || dot.style.top);
            dot.setAttribute('data-original-left', originalLeft);
            dot.setAttribute('data-original-top', originalTop);
            dot.style.left = `${originalLeft * zoomFactor}%`;
            // Adjust vertical position based on zoom
            dot.style.top = `${originalTop * zoomFactor}%`;
        });

        // Adjust font sizes and dot sizes for better readability when zoomed
        const fontSize = 0.85 * zoomFactor; // Base font size for blocks
        const dotSize = 16 * zoomFactor; // Base dot size
        const dateFontSize = 0.65 * zoomFactor; // Base font size for date labels

        blocks.forEach(block => {
            block.style.fontSize = `${fontSize}rem`;
        });

        document.querySelectorAll('.timeline-dot').forEach(dot => {
            dot.style.width = `${dotSize}px`;
            dot.style.height = `${dotSize}px`;
        });

        document.querySelectorAll('.date-label').forEach(label => {
            label.style.fontSize = `${dateFontSize}rem`;
        });

        // Adjust the timeline bar height for visual consistency
        const timelineBar = document.getElementById('timelineBar');
        timelineBar.style.height = `${6 * zoomFactor}px`;
    }

    function filterTasks() {
        const selectedStatus = document.getElementById('filterStatus').value;
        const taskCards = document.querySelectorAll('.task-card');
        let visibleCount = 0;

        taskCards.forEach(card => {
            const rawStatus = card.getAttribute('data-status');
            const statusMap = {
                'pending': 'Not Started',
                'in_progress': 'In Progress',
                'in_review': 'In Review',
                'completed': 'Completed',
                'blocked': 'Blocked'
            };
            const mapped = statusMap[rawStatus] || 'Not Started';
            const visible = selectedStatus === 'all' || mapped === selectedStatus;

            card.style.display = visible ? 'block' : 'none';
            if (visible) visibleCount++;
        });

        document.getElementById('noTaskMessage').style.display = visibleCount === 0 ? 'block' : 'none';
    }

    // Add smooth scroll animations and zoom functionality
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.milestone-item, .task-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.6s ease-in-out';
            observer.observe(item);
        });

        // Tooltip functionality for timeline
        const tooltipElements = document.querySelectorAll('[data-tooltip="true"]');
        tooltipElements.forEach(el => {
            const tooltip = document.createElement('div');
            tooltip.classList.add('timeline-tooltip');
            tooltip.innerHTML = el.getAttribute('data-tooltip-content');
            document.body.appendChild(tooltip);

            el.addEventListener('mouseenter', (e) => {
                tooltip.style.display = 'block';
                const rect = el.getBoundingClientRect();
                tooltip.style.left = `${rect.left + window.scrollX + rect.width / 2 - tooltip.offsetWidth / 2}px`;
                tooltip.style.top = `${rect.top + window.scrollY - tooltip.offsetHeight - 10}px`;
            });

            el.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });

            window.addEventListener('scroll', () => {
                if (tooltip.style.display === 'block') {
                    const rect = el.getBoundingClientRect();
                    tooltip.style.left = `${rect.left + window.scrollX + rect.width / 2 - tooltip.offsetWidth / 2}px`;
                    tooltip.style.top = `${rect.top + window.scrollY - tooltip.offsetHeight - 10}px`;
                }
            });
        });

        // Zoom controls
        const zoomInBtn = document.getElementById('zoomInBtn');
        const zoomOutBtn = document.getElementById('zoomOutBtn');
        const zoomSlider = document.getElementById('zoomSlider');

        zoomInBtn.addEventListener('click', () => {
            zoomFactor = Math.min(zoomFactor + 0.1, maxZoom);
            zoomSlider.value = zoomFactor;
            updateTimelineZoom();
        });

        zoomOutBtn.addEventListener('click', () => {
            zoomFactor = Math.max(zoomFactor - 0.1, minZoom);
            zoomSlider.value = zoomFactor;
            updateTimelineZoom();
        });

        zoomSlider.addEventListener('input', () => {
            zoomFactor = parseFloat(zoomSlider.value);
            updateTimelineZoom();
        });

        // Initial zoom setup
        updateTimelineZoom();
    });
</script>
@endpush

<style>
/* Timeline Styles */
.timeline-wrapper {
    position: relative;
    height: 300px; /* Adjusted for stacked tasks */
    margin-top: 2rem;
    background: #f9fafb;
    border-radius: 12px;
    overflow-x: auto;
    padding: 40px 40px 20px 40px; /* Increased horizontal padding for better spacing */
    box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.05);
    width: 100%;
}

.timeline-content {
    position: relative;
    width: 100%;
    height: 100%;
    transition: all 0.3s ease;
}

.timeline-bar {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 6px;
    background: #e5e7eb;
    transform: translateY(-50%);
    border-radius: 3px;
    z-index: 1;
    transition: height 0.3s ease;
}

.timeline-date-markers {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 30px;
    z-index: 2;
}

.timeline-date-marker {
    position: absolute;
    top: 0;
    transform: translateX(-50%);
    text-align: center;
    transition: left 0.3s ease, font-size 0.3s ease;
}

.date-label {
    font-size: 0.65rem;
    padding: 4px 8px;
    background: #f9fafb;
    border-radius: 6px;
    color: #6b7280;
    white-space: nowrap;
}

.date-earliest .date-label,
.date-latest .date-label {
    font-weight: bold;
    font-size: 0.85rem;
    color: #1f2937;
    background: #e0e7ff;
    padding: 4px 12px;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.date-tick {
    width: 1px;
    height: 6px;
    background: #d1d5db;
    margin: 3px auto 0;
}

.date-earliest .date-tick,
.date-latest .date-tick {
    height: 14px;
    background: #4f46e5;
}

.timeline-block {
    position: absolute;
    top: 22px;
    height: 36px;
    border-radius: 8px;
    padding: 0 12px;
    color: white;
    font-size: 0.85rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 36px;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: left 0.3s ease, width 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease, font-size 0.3s ease;
    cursor: pointer;
}

.timeline-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.timeline-block-label {
    display: inline-block;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
}

.milestone-completed {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.milestone-progress {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.milestone-pending {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

.timeline-dot {
    position: absolute;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    transform: translateX(-50%);
    z-index: 3;
    border: 3px solid white;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    transition: left 0.3s ease, top 0.3s ease, transform 0.3s ease, width 0.3s ease, height 0.3s ease;
    cursor: pointer;
}

.timeline-dot:hover {
    transform: translateX(-50%) scale(1.2);
}

.milestone-dot-start {
    left: 0;
    top: 50%;
    transform: translateY(-50%);
}

.milestone-dot-end {
    right: 0;
    top: 50%;
    transform: translateY(-50%);
}

.task-dot {
    /* Dynamic top position set via inline style */
}

.task-completed {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.task-progress {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.task-pending {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

.task-review {
    background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
}

.task-blocked {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.task-overdue {
    border-color: #ef4444;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: translateX(-50%) scale(1);
    }
    50% {
        transform: translateX(-50%) scale(1.2);
    }
}

.timeline-tooltip {
    position: absolute;
    background: #1f2937;
    color: white;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    line-height: 1.4;
    z-index: 1000;
    display: none;
    pointer-events: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.timeline-tooltip::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 50%;
    transform: translateX(-50%);
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #1f2937;
}

.timeline-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.5rem;
    padding: 0 40px 1rem 40px; /* Match padding with timeline-wrapper */
    border-top: 1px solid #e5e7eb;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #374151;
}

.legend-dot {
    display: inline-block;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.legend-dot.milestone-dot {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
}

.zoom-controls .btn {
    border-radius: 8px;
    padding: 0.25rem 0.5rem;
    font-size: 0.85rem;
}

.zoom-controls .form-range {
    accent-color: #4f46e5;
}

/* Hero Section */
.hero-section {
    position: relative;
}

/* Action Buttons */
.action-buttons-container {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.action-btn {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    flex: 1;
    min-width: 280px;
    position: relative;
    overflow: hidden;
}

.action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.6s ease;
}

.action-btn:hover::before {
    left: 100%;
}

.primary-btn {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    box-shadow: 0 4px 16px rgba(79, 70, 229, 0.2);
}

.primary-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
    color: white;
}

.secondary-btn {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    box-shadow: 0 4px 16px rgba(107, 114, 128, 0.2);
}

.secondary-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(107, 114, 128, 0.3);
    color: white;
}

.btn-icon {
    font-size: 2rem;
    margin-right: 1rem;
}

.btn-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 2px;
}

.btn-subtitle {
    font-size: 0.85rem;
    opacity: 0.8;
}

/* Filter Container */
.filter-container {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(79, 70, 229, 0.1);
}

.filter-header h5 {
    color: #4f46e5;
    font-weight: 600;
}

.custom-select {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.custom-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    background: white;
}

/* Section Container */
.section-container {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(79, 70, 229, 0.05);
    position: relative;
    overflow: hidden;
}

.section-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.section-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
}

.section-title h3 {
    color: #1f2937;
    font-weight: 700;
}

/* Milestone Item */
.milestone-item {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 20px;
    padding: 1.5rem;
    color: white;
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
    animation: slideInUp 0.6s ease-out forwards;
}

.milestone-item::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    transform: rotate(45deg);
}

.milestone-item:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 50px rgba(79, 70, 229, 0.4);
}

.milestone-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.milestone-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    backdrop-filter: blur(10px);
}

.milestone-date {
    font-size: 0.85rem;
    opacity: 0.9;
    text-align: right;
    line-height: 1.3;
}

.milestone-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.milestone-status {
    margin-bottom: 1rem;
}

.milestone-actions .btn {
    border-radius: 8px;
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
}

.milestone-actions .btn-outline-light {
    border-color: rgba(255, 255, 255, 0.5);
}

.milestone-actions .btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.1);
}

.milestone-actions .btn-outline-danger {
    border-color: #ef4444;
    color: #ef4444;
}

.milestone-actions .btn-outline-danger:hover {
    background: #ef4444;
    color: white;
}

/* Task Item */
.task-item {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    height: 100%;
    position: relative;
    border: 2px solid #f1f5f9;
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out forwards;
}

.task-item:hover {
    transform: translateY(-4px);
    border-color: #4f46e5;
    box-shadow: 0 12px 32px rgba(79, 70, 229, 0.15);
}

.task-status-indicator {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.status-completed {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.status-progress {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.status-pending {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

.status-review {
    background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
}

.status-blocked {
    background: linear-gradient(135deg, #fecaca 0%, #f87171 100%);
}

.badge-review {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.badge-blocked {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.task-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    margin-top: 0.5rem;
}

.task-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    line-height: 1.4;
    flex: 1;
    margin-right: 1rem;
}

.task-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.badge-completed {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.badge-progress {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.badge-pending {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #374151;
}

.task-meta {
    margin-top: auto;
}

.task-date {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
    color: #6b7280;
}

.task-date i {
    margin-right: 0.5rem;
    color: #4f46e5;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: #9ca3af;
}

.empty-state h5 {
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes progressFill {
    to {
        width: 70%;
    }
}

/* Responsive Styles */
@media (max-width: 768px) {
    .action-buttons-container {
        flex-direction: column;
    }

    .action-btn {
        min-width: auto;
    }

    .section-header {
        flex-direction: column;
        text-align: center;
    }

    .section-icon {
        margin: 0 0 1rem 0;
    }

    .zoom-controls {
        margin-top: 1rem;
        justify-content: center;
    }

    .timeline-wrapper {
        height: 250px;
        padding: 30px 20px 10px 20px; /* Adjusted padding for smaller screens */
    }

    .timeline-legend {
        padding: 0 20px 1rem 20px;
        gap: 0.75rem;
        font-size: 0.75rem;
    }

    .timeline-block {
        height: 30px;
        line-height: 30px;
        font-size: 0.75rem;
    }

    .timeline-dot {
        width: 14px;
        height: 14px;
    }

    .date-label {
        font-size: 0.55rem;
        padding: 2px 6px;
    }

    .date-earliest .date-label,
    .date-latest .date-label {
        font-size: 0.75rem;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
    }
}

@media (max-width: 576px) {
    .container {
        padding: 2rem 0 !important;
    }

    .section-container {
        padding: 1.5rem;
    }

    .task-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .task-badge {
        margin-top: 0.5rem;
    }

    .timeline-wrapper {
        height: 220px;
        padding: 30px 15px 10px 15px; /* Further adjusted padding */
    }

    .timeline-legend {
        padding: 0 15px 1rem 15px;
    }

    .timeline-block {
        height: 26px;
        line-height: 26px;
        font-size: 0.7rem;
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
    }

    .date-label {
        font-size: 0.5rem;
        padding: 2px 4px;
    }

    .date-earliest .date-label,
    .date-latest .date-label {
        font-size: 0.65rem;
        padding: 3px 8px;
    }

    .zoom-controls .form-range {
        width: 100px;
    }
}
</style>