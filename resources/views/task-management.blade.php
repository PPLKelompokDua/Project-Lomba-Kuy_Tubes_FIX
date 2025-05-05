@extends('layouts.app')

@section('content')
<div class="task-management-container">
    <div class="container py-5">
        <div class="header-section mb-5">
            <h1 class="welcome-text"><i class="fas fa-tasks icon-gradient me-3"></i>Task Management</h1>
            <p class="text-muted">Organize your work and boost your productivity</p>
        </div>
        
        <!-- Display success message if any -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

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
                            <button onclick="editTask({{ $task->id }})" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i>Edit
                            </button>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this task?')">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </button>
                            </form>
                        </div>
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

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label><i class="fas fa-heading me-2"></i>Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group mb-4">
                        <label><i class="fas fa-align-left me-2"></i>Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt me-2"></i>Due Date</label>
                                <input type="date" name="due_date" id="edit_due_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-flag me-2"></i>Status</label>
                                <select name="status" id="edit_status" class="form-control" required>
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
                <button type="button" class="btn btn-primary" onclick="submitEditForm()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Container Styling */
.task-management-container {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4ecfa 100%);
    min-height: 100vh;
    padding: 30px 0;
}

/* Header Section */
.header-section {
    text-align: center;
    padding-bottom: 20px;
    position: relative;
}

.welcome-text {
    color: #5243AA;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.icon-gradient {
    background: linear-gradient(45deg, #5243AA, #8776d5);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-size: 2.2rem;
}

/* Stats Cards */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.stat-box {
    background: white;
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.stat-icon {
    background: linear-gradient(45deg, #5243AA, #8776d5);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 20px;
    box-shadow: 0 5px 15px rgba(82, 67, 170, 0.3);
}

.stat-icon.pending-icon {
    background: linear-gradient(45deg, #ff9a00, #ffcc80);
    box-shadow: 0 5px 15px rgba(255, 154, 0, 0.3);
}

.stat-icon.progress-icon {
    background: linear-gradient(45deg, #1e88e5, #64b5f6);
    box-shadow: 0 5px 15px rgba(30, 136, 229, 0.3);
}

.stat-icon.completed-icon {
    background: linear-gradient(45deg, #43a047, #81c784);
    box-shadow: 0 5px 15px rgba(67, 160, 71, 0.3);
}

.stat-info {
    flex: 1;
}

.stat-title {
    color: #666;
    font-size: 1rem;
    margin-bottom: 8px;
    font-weight: 500;
}

.stat-value {
    color: #5243AA;
    font-size: 2.2rem;
    font-weight: 700;
    line-height: 1;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 30px;
}

.card-header {
    padding: 20px 25px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.section-title {
    color: #5243AA;
    font-size: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.section-title i {
    color: #8776d5;
}

/* Form Styling */
.form-control {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 12px 15px;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: #5243AA;
    box-shadow: 0 0 0 3px rgba(82, 67, 170, 0.1);
}

.form-control::placeholder {
    color: #aaa;
    font-style: italic;
}

.form-group label {
    color: #555;
    font-weight: 600;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
}

.form-group label i {
    color: #8776d5;
    margin-right: 8px;
}

.btn-primary {
    background: linear-gradient(45deg, #5243AA, #8776d5);
    border: none;
    border-radius: 10px;
    padding: 12px 25px;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(82, 67, 170, 0.3);
    transition: all 0.3s;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #4535a0, #7667c6);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(82, 67, 170, 0.4);
}

/* Task List Styling */
.task-list {
    display: flex;
    flex-direction: column;
}

.task-item {
    background: white;
    border-radius: 12px;
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    transition: transform 0.3s, box-shadow 0.3s;
}

.task-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.task-divider {
    margin: 15px 0;
    border-color: rgba(0,0,0,0.05);
}

.task-info {
    flex: 1;
    padding-right: 20px;
}

.task-info h4 {
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
}

.task-info p {
    color: #666;
    font-size: 1rem;
    margin-bottom: 15px;
    line-height: 1.6;
}

.task-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 0.9rem;
    align-items: center;
}

.due-date {
    color: #666;
    display: flex;
    align-items: center;
    background: #f5f5f5;
    padding: 5px 12px;
    border-radius: 20px;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    display: flex;
    align-items: center;
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
    gap: 10px;
}

.btn-outline-primary {
    color: #5243AA;
    border-color: #5243AA;
    border-width: 2px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-outline-primary:hover {
    background: #5243AA;
    color: white;
    box-shadow: 0 5px 15px rgba(82, 67, 170, 0.2);
}

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
    border-width: 2px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
}

/* Empty State */
.empty-state {
    padding: 40px 0;
}

.empty-icon {
    font-size: 5rem;
    color: #e0e0e0;
    margin-bottom: 20px;
}

.empty-state h4 {
    color: #666;
    margin-bottom: 10px;
}

.empty-state p {
    color: #999;
}

/* Modal Styling */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.modal-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4ecfa 100%);
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 20px 25px;
}

.modal-header .modal-title {
    color: #5243AA;
    font-weight: 600;
}

.modal-body {
    padding: 25px;
}

.modal-footer {
    border-top: 1px solid rgba(0,0,0,0.05);
    padding: 20px 25px;
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
}
</style>

<script>
// Global variable to store current task ID being edited
let currentTaskId;

// Function to load and edit a task
function editTask(taskId) {
    currentTaskId = taskId;
    
    // Get task data via AJAX
    fetch(`/tasks/${taskId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(task => {
            // Populate form with task data
            document.getElementById('edit_title').value = task.title;
            document.getElementById('edit_description').value = task.description;
            document.getElementById('edit_due_date').value = task.due_date;
            document.getElementById('edit_status').value = task.status;
            
            // Set form action
            document.getElementById('editTaskForm').action = `/tasks/${taskId}`;
            
            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
            editModal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading task data');
        });
}

// Function to submit the edit form
function submitEditForm() {
    document.getElementById('editTaskForm').submit();
}
</script>
@endsection