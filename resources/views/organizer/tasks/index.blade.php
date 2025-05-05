@extends('layouts.app')

@section('content')
<div class="organizer-container">
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>
    
    <div class="container py-5">
        <div class="header-section mb-5">
            <h1 class="welcome-text"><i class="fas fa-calendar-check icon-gradient me-3"></i>Personal Organizer</h1>
        </div>

        <!-- Stats Cards -->
        <div class="stats-row mb-5">
            <div class="stat-box">
                <div class="stat-icon"><i class="fas fa-list-check"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Tasks</div>
                    <div class="stat-value">{{ $tasks->count() }}</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon pending-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending</div>
                    <div class="stat-value">{{ $tasks->where('status', 'pending')->count() }}</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon progress-icon"><i class="fas fa-spinner"></i></div>
                <div class="stat-info">
                    <div class="stat-title">In Progress</div>
                    <div class="stat-value">{{ $tasks->where('status', 'in_progress')->count() }}</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon completed-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Completed</div>
                    <div class="stat-value">{{ $tasks->where('status', 'completed')->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Task Creation Section -->
        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-transparent">
                <h2 class="section-title mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Task</h2>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label><i class="fas fa-heading me-2"></i>Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="What needs to be done?" required>
                    </div>
                    <div class="form-group mb-4">
                        <label><i class="fas fa-align-left me-2"></i>Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Add details about this task..." required></textarea>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt me-2"></i>Due Date</label>
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-flag me-2"></i>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Create Task</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Task List -->
        <div class="card shadow-sm">
            <div class="card-header bg-transparent">
                <h2 class="section-title mb-0"><i class="fas fa-clipboard-list me-2"></i>Your Tasks</h2>
            </div>
            <div class="card-body p-4">
                <div class="task-list">
                    @foreach($tasks as $task)
                    <div class="task-item">
                        <div class="task-info">
                            <h4>{{ $task->title }}</h4>
                            <p>{{ $task->description }}</p>
                            <div class="task-meta">
                                <span class="due-date"><i class="fas fa-calendar me-1"></i>Due: {{ $task->due_date }}</span>
                                <span class="status-badge {{ $task->status }}">
                                    @if($task->status == 'pending')
                                        <i class="fas fa-hourglass-half me-1"></i>
                                    @elseif($task->status == 'in_progress')
                                        <i class="fas fa-spinner me-1"></i>
                                    @else
                                        <i class="fas fa-check-circle me-1"></i>
                                    @endif
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="task-actions">
                        <button 
    class="btn btn-sm btn-outline-info"
    data-id="{{ $task->id }}"
    data-title="{{ $task->title }}"
    data-description="{{ addslashes($task->description) }}"
    data-due-date="{{ $task->due_date }}"
    data-status="{{ $task->status }}"
    onclick="viewTask(
        {{ $task->id }}, 
        '{{ $task->title }}', 
        '{{ addslashes($task->description) }}', 
        '{{ $task->due_date }}', 
        '{{ $task->status }}'
    )">
    <i class="fas fa-eye me-1"></i>View
</button>
                           <button 
    class="btn btn-sm btn-outline-primary"
    data-id="{{ $task->id }}"
    data-title="{{ $task->title }}"
    data-description="{{ addslashes($task->description) }}"
    data-due-date="{{ $task->due_date }}"
    data-status="{{ $task->status }}"
    onclick="openEditModal(
        {{ $task->id }}, 
        '{{ $task->title }}', 
        '{{ addslashes($task->description) }}', 
        '{{ $task->due_date }}', 
        '{{ $task->status }}'
    )">
    <i class="fas fa-edit me-1"></i>Edit
</button>
                            <button onclick="deleteTask({{ $task->id }})" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash-alt me-1"></i>Delete
                            </button>
                        </div>
                        <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    @if(!$loop->last)
                        <hr class="task-divider">
                    @endif
                    @endforeach

                    @if($tasks->count() == 0)
                    <div class="empty-state text-center py-5">
                        <i class="fas fa-clipboard-list empty-icon"></i>
                        <h4>No tasks yet</h4>
                        <p>Create your first task to get started</p>
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTaskModalLabel"><i class="fas fa-eye me-2"></i>View Task</h5>
               
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
                            <i class="fas fa-calendar-alt me-2"></i>Due Date
                        </div>
                        <div class="detail-content" id="view-task-due-date"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn" onclick="window.history.back()">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel"><i class="fas fa-edit me-2"></i>Edit Task</h5>
                



            </div>
            <div class="modal-body p-4">
                <form id="edit-task-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label><i class="fas fa-heading me-2"></i>Title</label>
                        <input type="text" name="title" id="edit-title" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group mb-4">
                        <label><i class="fas fa-align-left me-2"></i>Description</label>
                        <textarea name="description" id="edit-description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt me-2"></i>Due Date</label>
                                <input type="date" name="due_date" id="edit-due-date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-flag me-2"></i>Status</label>
                                <select name="status" id="edit-status" class="form-control" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitEditForm()"><i class="fas fa-save me-2"></i>Save Changes</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Container Styling with Expanded Background */
.task-management-container {
    background: linear-gradient(135deg, #6442ff 0%, #3721db 100%);
    min-height: 100vh;
    padding: 40px 0;
    position: relative;
    overflow: hidden;
}

/* Large background shapes */
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
    opacity: 0.2;
}

.shape-1 {
    background: linear-gradient(45deg, #9c77ff, #6442ff);
    width: 80vh;
    height: 80vh;
    top: -30vh;
    right: -20vh;
}

.shape-2 {
    background: linear-gradient(45deg, #ff66c4, #cb52ea);
    width: 70vh;
    height: 70vh;
    bottom: -30vh;
    left: -20vh;
}

.shape-3 {
    background: linear-gradient(45deg, #00deff, #6442ff);
    width: 40vh;
    height: 40vh;
    top: 50%;
    right: 10%;
    transform: translateY(-50%);
}

.shape-4 {
    background: linear-gradient(45deg, #fcff52, #ff7857);
    width: 30vh;
    height: 30vh;
    top: 30%;
    left: 10%;
}

.container {
    position: relative;
    z-index: 1;
}

/* Header Section */
.header-section {
    text-align: center;
    padding-bottom: 30px;
    position: relative;
}

.welcome-text {
    color: #ffffff;
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 15px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.header-section p {
    color: rgba(255, 255, 255, 0.8) !important;
    font-size: 1.2rem;
}

.icon-gradient {
    color: #fff;
    font-size: 2.5rem;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
}

/* Stats Cards */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.stat-box {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 30px;
    display: flex;
    align-items: center;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s, box-shadow 0.3s;
    backdrop-filter: blur(10px);
}

.stat-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.stat-icon {
    background: linear-gradient(45deg, #5243AA, #8776d5);
    color: white;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-right: 25px;
    box-shadow: 0 10px 20px rgba(82, 67, 170, 0.3);
}

.stat-icon.pending-icon {
    background: linear-gradient(45deg, #ff9a00, #ffcc80);
    box-shadow: 0 10px 20px rgba(255, 154, 0, 0.3);
}

.stat-icon.progress-icon {
    background: linear-gradient(45deg, #1e88e5, #64b5f6);
    box-shadow: 0 10px 20px rgba(30, 136, 229, 0.3);
}

.stat-icon.completed-icon {
    background: linear-gradient(45deg, #43a047, #81c784);
    box-shadow: 0 10px 20px rgba(67, 160, 71, 0.3);
}

.stat-info {
    flex: 1;
}

.stat-title {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 8px;
    font-weight: 500;
}

.stat-value {
    color: #5243AA;
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 40px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.card-header {
    padding: 25px 30px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.section-title {
    color: #5243AA;
    font-size: 1.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.section-title i {
    color: #8776d5;
    font-size: 1.6rem;
    margin-right: 15px;
}

/* Form Styling */
.form-control {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 15px 20px;
    transition: all 0.3s;
    font-size: 1.05rem;
}

.form-control:focus {
    border-color: #5243AA;
    box-shadow: 0 0 0 4px rgba(82, 67, 170, 0.1);
}

.form-control::placeholder {
    color: #aaa;
    font-style: italic;
}

.form-group label {
    color: #555;
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    font-size: 1.1rem;
}

.form-group label i {
    color: #8776d5;
    margin-right: 10px;
    font-size: 1.2rem;
}

.btn-primary {
    background: linear-gradient(45deg, #5243AA, #8776d5);
    border: none;
    border-radius: 12px;
    padding: 15px 30px;
    font-weight: 600;
    box-shadow: 0 10px 20px rgba(82, 67, 170, 0.3);
    transition: all 0.3s;
    font-size: 1.1rem;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #4535a0, #7667c6);
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(82, 67, 170, 0.4);
}

/* Task List Styling */
.task-list {
    display: flex;
    flex-direction: column;
}

.task-item {
    background: white;
    border-radius: 15px;
    padding: 30px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s, box-shadow 0.3s;
    margin-bottom: 20px;
}

.task-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.task-divider {
    margin: 20px 0;
    border-color: rgba(0, 0, 0, 0.05);
    opacity: 0.5;
}

.task-info {
    flex: 1;
    padding-right: 25px;
}

.task-info h4 {
    color: #333;
    margin-bottom: 12px;
    font-weight: 600;
    font-size: 1.3rem;
}

.task-info p {
    color: #666;
    font-size: 1.05rem;
    margin-bottom: 20px;
    line-height: 1.7;
}

.task-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 0.95rem;
    align-items: center;
}

.due-date {
    color: #666;
    display: flex;
    align-items: center;
    background: #f5f5f5;
    padding: 8px 15px;
    border-radius: 25px;
    font-weight: 500;
}

.due-date i {
    margin-right: 8px;
    color: #8776d5;
}

.status-badge {
    padding: 8px 15px;
    border-radius: 25px;
    font-size: 0.95rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.status-badge i {
    margin-right: 8px;
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

.task-actions {
    display: flex;
    gap: 12px;
}

.btn-outline-primary {
    color: #5243AA;
    border-color: #5243AA;
    border-width: 2px;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s;
    padding: 8px 16px;
}

.btn-outline-primary:hover {
    background: #5243AA;
    color: white;
    box-shadow: 0 8px 15px rgba(82, 67, 170, 0.2);
}

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
    border-width: 2px;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s;
    padding: 8px 16px;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
    box-shadow: 0 8px 15px rgba(220, 53, 69, 0.2);
}

.btn-outline-info {
    color: #17a2b8;
    border-color: #17a2b8;
    border-width: 2px;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s;
    padding: 8px 16px;
}

.btn-outline-info:hover {
    background: #17a2b8;
    color: white;
    box-shadow: 0 8px 15px rgba(23, 162, 184, 0.2);
}

/* Empty State */
.empty-state {
    padding: 60px 0;
}

.empty-icon {
    font-size: 6rem;
    color: #e0e0e0;
    margin-bottom: 30px;
}

.empty-state h4 {
    color: #666;
    margin-bottom: 15px;
    font-size: 1.5rem;
}

.empty-state p {
    color: #999;
    font-size: 1.1rem;
}

/* Modal Styling */
.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 20px 30px;
}

.modal-title {
    color: #5243AA;
    font-weight: 600;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
}

.modal-title i {
    color: #8776d5;
    margin-right: 10px;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 20px 30px;
}

.btn-secondary {
    background: #f2f2f2;
    color: #666;
    border: none;
    border-radius: 12px;
    padding: 12px 25px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-secondary:hover {
    background: #e0e0e0;
    color: #333;
}

/* View Task Modal Styling */
.view-task-content {
    padding: 10px;
}

.task-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.task-header h2 {
    color: #333;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 15px;
}

.task-status-container {
    display: flex;
    align-items: center;
}

.detail-row {
    margin-bottom: 25px;
}

.detail-label {
    font-weight: 600;
    color: #666;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.detail-label i {
    color: #8776d5;
    margin-right: 10px;
}

.detail-content {
    color: #333;
    font-size: 1.1rem;
    line-height: 1.8;
    padding: 5px 0;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .task-item {
        flex-direction: column;
    }
    
    .task-info {
        padding-right: 0;
        padding-bottom: 20px;
    }
    
    .task-actions {
        width: 100%;
        justify-content: flex-end;
    }
    
    .shape-1, .shape-2, .shape-3, .shape-4 {
        opacity: 0.1;
    }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // View Task
    function viewTask(taskId, title, description, dueDate, status) {
        $('#view-task-title').text(title);
        $('#view-task-description').text(description);
        $('#view-task-due-date').text(dueDate);
    
        
        // Update status badge
        const statusBadge = $('#view-task-status')
            .removeClass()
            .addClass('status-badge ' + status)
            .html(`<i class="fas ${
                status === 'pending' ? 'fa-hourglass-half' : 
                status === 'in_progress' ? 'fa-spinner' : 'fa-check-circle'
            } me-1"></i>${status.charAt(0).toUpperCase() + status.slice(1)}`);
        
        new bootstrap.Modal(document.getElementById('viewTaskModal')).show();
    }

    // Edit Task
    let currentTaskId = null;

    function openEditModal(taskId, title, description, dueDate, status) {
        currentTaskId = taskId;
        
        // Set form values
        $('#edit-title').val(title);
        $('#edit-description').val(description);
        $('#edit-due-date').val(dueDate);
        $('#edit-status').val(status);
        
        // Set form action
        $('#edit-task-form').attr('action', `/tasks/${taskId}`);
        
        new bootstrap.Modal(document.getElementById('editTaskModal')).show();
    }

    function submitEditForm() {
        $.ajax({
            url: $('#edit-task-form').attr('action'),
            method: 'PUT',
            data: {
                title: $('#edit-title').val(),
                description: $('#edit-description').val(),
                due_date: $('#edit-due-date').val(),
                status: $('#edit-status').val(),
                _method: 'PUT'
            },
            success: function() {
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    }

    // Delete Task
    function deleteTask(taskId) {
        if(confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: `/tasks/${taskId}`,
                method: 'DELETE',
                success: function() {
                    $(`#task-${taskId}`).remove();
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        }
    }
</script>
@endsection