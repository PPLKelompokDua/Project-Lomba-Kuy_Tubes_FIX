<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $teamId = $request->input('team_id');
        $team = $teamId ? Team::findOrFail($teamId) : null;

        // Ambil semua tasks yang assigned ke user
        $assignedTasks = Task::where('assigned_user_id', $userId)->get();
        $totalAssigned = $assignedTasks->count();
        $completedAssigned = $assignedTasks->where('status', 'completed')->count();
        $overallProgress = $totalAssigned > 0 ? round(($completedAssigned / $totalAssigned) * 100) : 0;

        // Ambil semua task tim jika ada team dipilih
        $teamTasks = $team ? Task::where('team_id', $team->id)->get() : collect();
        $totalTeamTasks = $teamTasks->count();
        $completedTeamTasks = $teamTasks->where('status', 'completed')->count();
        $teamProgress = $totalTeamTasks > 0 ? round(($completedTeamTasks / $totalTeamTasks) * 100) : 0;

        // Default tasks (hanya untuk tim yang dipilih)
        $tasks = $teamTasks->sortBy('due_date');

        // Ambil anggota tim
        if ($team) {
            $teamMembers = collect([$team->leader])->merge($team->acceptedMembers)->unique('id');
        } else {
            $teams = Team::where('leader_id', $user->id)
                        ->orWhereHas('acceptedMembers', fn($q) => $q->where('user_id', $userId))
                        ->get();

            $teamMembers = $teams->flatMap(fn ($team) => $team->acceptedMembers)
                                 ->merge($teams->pluck('leader'))
                                 ->unique('id');
        }

        return view('task-management.task-management', compact(
            'tasks',
            'teamMembers',
            'team',
            'user',
            'overallProgress',
            'teamProgress'
        ));
    }

    public function forTeam($teamId)
    {
        $team = \App\Models\Team::with('acceptedMembers')->findOrFail($teamId);
        $user = Auth::user();

        // Pastikan user adalah anggota/leader
        $isMember = $team->leader_id === $user->id || $team->acceptedMembers->contains('id', $user->id);
        abort_unless($isMember, 403);

        // Ambil semua task untuk tim ini
        $tasks = Task::where('team_id', $teamId)->orderBy('due_date')->get();

        // Hitung progress team
        $teamTaskCount = $tasks->count();
        $teamCompleted = $tasks->where('status', 'completed')->count();
        $teamProgress = $teamTaskCount > 0 ? round(($teamCompleted / $teamTaskCount) * 100) : 0;

        // Hitung progress user (hanya di team ini)
        $userTasks = $tasks->where('assigned_user_id', $user->id);
        $totalUser = $userTasks->count();
        $completedUser = $userTasks->where('status', 'completed')->count();
        $overallProgress = $totalUser > 0 ? round(($completedUser / $totalUser) * 100) : 0;

        $teamMembers = collect([$team->leader])->merge($team->acceptedMembers);
        $myTasks = $tasks->filter(fn($task) => $task->user_id === $user->id || $task->assigned_user_id === $user->id);
        $teamTasks = $tasks->diff($myTasks);

        return view('task-management.task-management', compact(
            'tasks',
            'team',
            'teamMembers',
            'myTasks',
            'teamTasks',
            'user',
            'overallProgress', // << ADD THIS
            'teamProgress'     // << ADD THIS
        ));
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
            'status' => 'required|in:pending,in_progress,in_review,completed,blocked',
            'blocker_reason' => 'nullable|string|max:255',
        ]);

        $data = $request->only('title', 'description', 'due_date', 'status');

        $data['completed_at'] = $request->status === 'completed' ? now() : null;
        $data['blocked_at'] = $request->status === 'blocked' ? now() : null;
        $data['blocker_reason'] = $request->status === 'blocked' ? $request->blocker_reason : null;

        $task->update($data);

        $redirect = $task->team_id ? route('tasks.team', $task->team_id) : route('tasks.index');
        return redirect($redirect)->with('success', 'Task updated successfully!');
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
