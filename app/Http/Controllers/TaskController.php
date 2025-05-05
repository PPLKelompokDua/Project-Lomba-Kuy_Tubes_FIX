<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->orderBy('due_date', 'asc')->get();
        return view('task-management', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status
        ]);

        return redirect()->route('task.management')->with('success', 'Task created successfully');
    }

    public function show(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        // Authorization check
        if ($task->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed'
        ]);
    
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status
        ]);
    
        return redirect()->route('task.management')->with('success', 'Task updated successfully');
    }
       
    public function destroy(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id != auth()->id()) {
            return abort(403);
        }

        $task->delete();
        
        return redirect()->route('task.management')->with('success', 'Task deleted successfully');
    }
}