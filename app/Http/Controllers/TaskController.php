<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua tim yang user ikuti atau pimpin
        $teams = Team::where('leader_id', $user->id)
                    ->orWhereHas('acceptedMembers', fn ($q) => $q->where('user_id', $user->id))
                    ->get();

        // Ambil anggota tim
        $teamMembers = $teams->flatMap(fn ($team) => $team->acceptedMembers)
                            ->merge($teams->pluck('leader'))
                            ->unique('id');

        // Ambil semua task dari tim-tim tersebut
        $tasks = Task::where('team_id', $teamId)->orderBy('due_date', 'asc')->get();

        return view('task-management.task-management', compact('tasks', 'teamMembers', 'teams', 'user'));
    }


    public function forTeam($teamId)
    {
        $team = \App\Models\Team::with('acceptedMembers')->findOrFail($teamId);

        // Cek keanggotaan
        $user = Auth::user();
        $isMember = $team->leader_id === $user->id || $team->acceptedMembers->contains('id', $user->id);
        abort_unless($isMember, 403);

        $tasks = Task::where('team_id', $teamId)
             ->orderBy('due_date', 'asc')
             ->get();

        $teamMembers = collect([$team->leader])->merge($team->acceptedMembers);

        $myTasks = $tasks->filter(fn($task) =>
            $task->user_id === $user->id || $task->assigned_user_id === $user->id
            );

        $teamTasks = $tasks->diff($myTasks);

        return view('task-management.task-management', compact('tasks', 'team', 'teamMembers', 'myTasks', 'teamTasks', 'user'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:pending,in_progress,completed',
            'team_id' => 'nullable|exists:teams,id',
            'assigned_user_id' => 'nullable|exists:users,id',
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'team_id' => $request->team_id,
            'assigned_user_id' => $request->assigned_user_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        if ($request->team_id) {
            return redirect()->route('tasks.team', $request->team_id)->with('success', 'Task created!');
        }


        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($request->only('title', 'description', 'due_date', 'status'));

        $data = $request->only('title', 'description', 'due_date', 'status');
        $data['completed_at'] = $data['status'] === 'completed' ? now() : null;

        $task->update($data);

        if ($task->team_id) {
            return redirect()->route('tasks.team', $task->team_id)->with('success', 'Task updated!');
        }


        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $teamId = $task->team_id;
        $task->delete();

        if ($teamId) {
            return redirect()->route('tasks.team', $teamId)->with('success', 'Task deleted.');
        }

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }

    protected function authorizeTask(Task $task)
    {
        $user = Auth::user();

        $isLeader = optional($task->team)->leader_id === $user->id;
        $isAssigned = $task->assigned_user_id === $user->id;

        if (!($isLeader || $isAssigned)) {
            abort(403);
        }
    }
}
