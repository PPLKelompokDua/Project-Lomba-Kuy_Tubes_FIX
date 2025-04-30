@extends('layouts.app')

@section('content')
<div class="organizer-container">
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>
    
    <div class="container py-4">
        <div class="header-section mb-5 text-center">
            <div class="logo-wrapper mb-3">
                <div class="app-logo">
                    <i class="fas fa-tasks icon-logo"></i>
                </div>
            </div>
            <h1 class="welcome-text">My Task Manager</h1>
            <p class="subtitle">Track and manage your work efficiently</p>
        </div>

        <!-- Enhanced Stats Cards -->
        <div class="stats-row mb-5">
            <div class="stat-box glassmorphism">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Tasks</div>
                    <div class="stat-value text-primary">{{ $tasks->count() }}</div>
                </div>
            </div>
            <div class="stat-box glassmorphism">
                <div class="stat-icon pending-icon"><i class="fas fa-pause-circle"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending</div>
                    <div class="stat-value text-warning">{{ $tasks->where('status', 'pending')->count() }}</div>
                </div>
            </div>
            <div class="stat-box glassmorphism">
                <div class="stat-icon progress-icon"><i class="fas fa-spinner"></i></div>
                <div class="stat-info">
                    <div class="stat-title">In Progress</div>
                    <div class="stat-value text-info">{{ $tasks->where('status', 'in_progress')->count() }}</div>
                </div>
            </div>
            <div class="stat-box glassmorphism">
                <div class="stat-icon completed-icon"><i class="fas fa-check-double"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Completed</div>
                    <div class="stat-value text-success">{{ $tasks->where('status', 'completed')->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Enhanced Task List -->
        <div class="card shadow-lg glassmorphism">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h2 class="section-title mb-0"><i class="fas fa-stream me-2"></i>Task List</h2>
                <div class="task-filters">
                    <select class="form-select form-select-sm me-2 d-inline-block w-auto">
                        <option value="all">All Tasks</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                    <select class="form-select form-select-sm d-inline-block w-auto">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="due_date">Due Date</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="task-list">
                    @foreach($tasks as $task)
                    <div class="task-item hover-lift" id="task-{{ $task->id }}" data-status="{{ $task->status }}">
                        <div class="task-info">
                            <div class="d-flex align-items-center mb-2">
                                <h4 class="mb-0">{{ $task->title }}</h4>
                                <span class="due-date badge bg-light text-dark ms-3">
                                    <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-muted mb-3">{{ $task->description }}</p>
                            <div class="task-meta">
                                <select class="form-select status-select" data-task-id="{{ $task->id }}" style="max-width: 150px">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="task-actions">
                            <button class="btn btn-icon" onclick="viewTask(
                                '{{ $task->title }}', 
                                `{{ addslashes($task->description) }}`, 
                                '{{ $task->due_date }}', 
                                '{{ $task->status }}'
                            )">
                                <i class="fas fa-eye text-info"></i>
                            </button>
                            <button class="btn btn-icon" onclick="confirmDelete({{ $task->id }})">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr class="task-divider">
                    @endif
                    @endforeach

                    @if($tasks->count() == 0)
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon">
                            <i class="fas fa-check-circle fa-4x text-muted"></i>
                        </div>
                        <h4 class="mt-4">No tasks found</h4>
                        <p class="text-muted">Start by creating your first task</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Task Modal -->
<div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glassmorphism">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTaskModalLabel"><i class="fas fa-file-alt me-2"></i>Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="view-task-content">
                    <div class="task-header mb-4">
                        <h2 id="view-task-title" class="mb-3"></h2>
                        <div class="task-status-container">
                            <span id="view-task-status" class="status-badge"></span>
                        </div>
                    </div>

                    <div class="detail-row mb-4">
                        <div class="detail-label">
                            <i class="fas fa-align-left me-2"></i>Description
                        </div>
                        <div class="detail-content" id="view-task-description"></div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-calendar-day me-2"></i>Due Date
                        </div>
                        <div class="detail-content" id="view-task-due-date"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glassmorphism">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="lead">Are you sure you want to delete this task?</p>
                <input type="hidden" id="delete-task-id">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="performDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>

<style>
.organizer-container {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
    min-height: 100vh;
    padding: 2rem 0;
    position: relative;
    overflow: hidden;
}

/* Enhanced Background Shapes */
.bg-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    overflow: hidden;
}

.shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.3;
}

.shape-1 {
    background: linear-gradient(45deg, #5243AA, #7C69EF);
    width: 300px;
    height: 300px;
    top: -100px;
    right: -100px;
}

.shape-2 {
    background: linear-gradient(45deg, #4158D0, #C850C0);
    width: 400px;
    height: 400px;
    bottom: -200px;
    left: -200px;
}

.shape-3 {
    background: linear-gradient(45deg, #0093E9, #80D0C7);
    width: 200px;
    height: 200px;
    top: 30%;
    right: 10%;
}

.shape-4 {
    background: linear-gradient(45deg, #FBAB7E, #F7CE68);
    width: 150px;
    height: 150px;
    bottom: 20%;
    right: 30%;
}

/* Enhanced Glassmorphism */
.glassmorphism {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(12px);
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.08);
    transition: all 0.3s ease;
}

.glassmorphism:hover {
    box-shadow: 0 12px 32px 0 rgba(31, 38, 135, 0.12);
}

/* App Logo */
.app-logo {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, #5243AA, #7C69EF);
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    box-shadow: 0 10px 20px rgba(124, 105, 239, 0.3);
}

.icon-logo {
    color: white;
    font-size: 2.5rem;
}

.welcome-text {
    font-weight: 700;
    background: linear-gradient(45deg, #5243AA, #7C69EF);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
}

.subtitle {
    color: #6c757d;
    font-size: 1.1rem;
}

/* Enhanced Stats Cards */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-box {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(45deg, #5243AA, #7C69EF);
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-icon.pending-icon {
    background: linear-gradient(45deg, #f7b733, #fc4a1a);
}

.stat-icon.progress-icon {
    background: linear-gradient(45deg, #2193b0, #6dd5ed);
}

.stat-icon.completed-icon {
    background: linear-gradient(45deg, #11998e, #38ef7d);
}

.stat-info {
    flex-grow: 1;
}

.stat-title {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.3rem;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1;
}

/* Enhanced Task Items */
.task-item {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 0.75rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 5px solid transparent;
    position: relative;
    overflow: hidden;
}

.task-item[data-status='pending'] {
    border-left-color: #f7b733;
}

.task-item[data-status='in_progress'] {
    border-left-color: #2193b0;
}

.task-item[data-status='completed'] {
    border-left-color: #11998e;
}

.task-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
}

.task-info {
    flex-grow: 1;
    max-width: 80%;
}

.task-item h4 {
    font-weight: 600;
    color: #333;
}

.status-select {
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-select:focus {
    border-color: #7C69EF;
    box-shadow: 0 0 0 0.2rem rgba(124, 105, 239, 0.25);
}

.task-actions {
    display: flex;
    gap: 0.5rem;
}

.task-actions .btn-icon {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.task-actions .btn-icon:hover {
    background: rgba(0, 0, 0, 0.05);
    transform: translateY(-2px);
}

.task-divider {
    border-top: 1px dashed rgba(0, 0, 0, 0.1);
    margin: 1rem 0;
}

/* Status Badge */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-block;
    position: relative;
}

.status-badge.pending {
    background: #fff3cd;
    color: #856404;
}

.status-badge.in_progress {
    background: #cce5ff;
    color: #004085;
}

.status-badge.completed {
    background: #d4edda;
    color: #155724;
}

/* Due Date Badge */
.due-date {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.due-date:hover {
    background: rgba(108, 117, 125, 0.2);
}

/* Enhanced Empty State */
.empty-state {
    padding: 3rem;
    text-align: center;
    background: linear-gradient(135deg, rgba(255,255,255,0.8), rgba(255,255,255,0.9));
    border-radius: 1rem;
    position: relative;
    overflow: hidden;
}

.empty-state::after {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: linear-gradient(45deg, rgba(124, 105, 239, 0.1), rgba(124, 105, 239, 0.05));
    top: -150px;
    right: -150px;
    z-index: -1;
}

.empty-state .empty-icon {
    color: #7C69EF;
    opacity: 0.5;
    margin-bottom: 1.5rem;
}

/* Enhanced Modal Styling */
.modal-content {
    border: none;
    overflow: hidden;
}

.modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.modal-title {
    font-weight: 600;
}

.modal-body {
    padding: 1.5rem;
}

.detail-row {
    margin-bottom: 1.5rem;
}

.detail-label {
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.detail-content {
    background: rgba(0, 0, 0, 0.02);
    padding: 1rem;
    border-radius: 0.5rem;
    font-size: 1rem;
    line-height: 1.6;
}

.btn-danger {
    background: #dc3545;
    border: none;
}

.btn-danger:hover {
    background: #c82333;
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
}

/* Responsive Design */
@media (max-width: 992px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .task-filters {
        margin-top: 1rem;
        display: flex;
        gap: 0.5rem;
        width: 100%;
    }
    
    .task-filters select {
        width: 100% !important;
    }
    
    .task-item {
        flex-direction: column;
    }
    
    .task-info {
        max-width: 100%;
        margin-bottom: 1rem;
    }
    
    .task-actions {
        margin-top: 1rem;
        width: 100%;
        justify-content: flex-end;
    }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Set data-status on task items
    $('.task-item').each(function() {
        const status = $(this).find('.status-select').val();
        $(this).attr('data-status', status);
    });
    
    // Status change handler
    $('.status-select').change(function() {
        const taskId = $(this).data('task-id');
        const newStatus = $(this).val();
        
        // Update the task item status attribute
        $(this).closest('.task-item').attr('data-status', newStatus);
        
        $.ajax({
            url: `/tasks/${taskId}`,
            method: 'PUT',
            data: {
                status: newStatus,
                _method: 'PUT',
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                // Add a subtle animation
                $(`#task-${taskId}`).addClass('highlight-update').delay(1000).queue(function(){
                    $(this).removeClass('highlight-update').dequeue();
                });
            },
            error: function(xhr) {
                alert('Error updating status: ' + xhr.responseJSON.message);
            }
        });
    });
});

let deleteTaskId = null;

function confirmDelete(id) {
    deleteTaskId = id;
    $('#deleteConfirmModal').modal('show');
}

function performDelete() {
    if(deleteTaskId) {
        $.ajax({
            url: `/tasks/${deleteTaskId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                // Add fade-out animation
                $(`#task-${deleteTaskId}`).fadeOut(300, function() {
                    $(this).remove();
                    // Check if there are no tasks left
                    if($('.task-item').length === 0) {
                        location.reload(); // Reload to show empty state
                    }
                });
                $('#deleteConfirmModal').modal('hide');
            },
            error: function(xhr) {
                alert('Error deleting task: ' + xhr.responseJSON.message);
            }
        });
    }
}

function viewTask(title, description, dueDate, status) {
    $('#view-task-title').text(title);
    $('#view-task-description').text(description);
    $('#view-task-due-date').text(new Date(dueDate).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }));
    
    const statusBadge = $('#view-task-status')
        .removeClass()
        .addClass('status-badge ' + status)
        .html(`<i class="fas fa-circle me-1"></i>${status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ')}`);
    
    new bootstrap.Modal(document.getElementById('viewTaskModal')).show();
}
</script>
@endsection