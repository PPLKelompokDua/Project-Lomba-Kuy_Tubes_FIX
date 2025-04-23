@extends('layouts.app')

@section('title', 'Task Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-indigo-700">Task Management</h1>
        <button 
            onclick="document.getElementById('createTaskModal').classList.remove('hidden')"
            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
        >
            Create New Task
        </button>
    </div>

    <!-- Task List -->
    <div class="grid gap-4">
        @foreach($tasks as $task)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                    <p class="text-gray-600 mt-1">{{ $task->description }}</p>
                    <div class="mt-2">
                        <span class="text-sm text-gray-500">Due: {{ $task->due_date->format('M d, Y') }}</span>
                        <span class="ml-2 px-2 py-1 text-sm rounded-full 
                            {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button 
                        onclick="editTask({{ $task->id }})"
                        class="text-blue-600 hover:text-blue-800"
                    >
                        <i class="fas fa-edit"></i>
                    </button>
                    <button 
                        onclick="deleteTask({{ $task->id }})"
                        class="text-red-600 hover:text-red-800"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Create Task Modal -->
    <div id="createTaskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Create New Task</h2>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                    <input type="date" name="due_date" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Competition</label>
                    <select name="competition_id" class="w-full border rounded px-3 py-2" required>
                        @foreach($competitions as $competition)
                            <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" 
                        onclick="document.getElementById('createTaskModal').classList.add('hidden')"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editTask(taskId) {
    // Implement edit functionality
    window.location.href = `/tasks/${taskId}/edit`;
}

function deleteTask(taskId) {
    if(confirm('Are you sure you want to delete this task?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/tasks/${taskId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection