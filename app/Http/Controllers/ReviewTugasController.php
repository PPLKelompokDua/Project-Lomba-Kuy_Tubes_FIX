<?php

namespace App\Http\Controllers;

use App\Models\ReviewTugas;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Team;

class ReviewTugasController extends Controller
{
    public function index(Request $request)
    {
        $teamId = $request->query('team_id'); // contoh: ?team_id=1

        $team = $teamId ? Team::findOrFail($teamId) : null;

        $tasks = Task::query()
            ->when($teamId, fn($q) => $q->where('team_id', $teamId))
            ->with('assignedUser') // supaya bisa akses nama assigned
            ->get()
            ->groupBy('status'); // group by: pending, in_progress, etc

        return view('task.board', compact('tasks', 'team', 'teamId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required',
            'status'     => 'required|in:todo,in_progress,in_review,done,blocked',
            'author'     => 'required',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'team_id'    => 'required|exists:teams,id',
        ]);

        $task = ReviewTugas::create($request->only([
            'title', 'status', 'author', 'start_date', 'end_date', 'team_id'
        ]));

        return response()->json(['id' => $task->id]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,in_review,completed,blocked',
        ]);

        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'completed_at' => $request->status === 'done' ? now() : null,
            'blocked_at' => $request->status === 'blocked' ? now() : null,
        ]);

        \Log::info($request->all());

        return response()->json(['success' => true]);
    }
}