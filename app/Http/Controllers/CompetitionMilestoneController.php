<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Competition;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Team;

class CompetitionMilestoneController extends Controller
{

    public function index($teamId)
    {
        // Ambil data tim beserta relasi milestones
        $team = Team::with('milestones')->findOrFail($teamId);

        // Ambil milestone dari tabel milestones asli (khusus timeline tim)
        $milestones = Milestone::where('team_id', $teamId)->get();

        // Ambil tasks dari tabel tasks, exclude status 'blocked'
        $tasks = Task::where('team_id', $teamId)
                    ->where('status', '!=', 'blocked')
                    ->get();

        // Mapping status task ke format seperti milestone (untuk keseragaman jika ingin dipakai bareng)
        $mappedTasks = $tasks->map(function ($task) {
            $statusMap = [
                'pending' => 'Not Started',
                'in_progress' => 'In Progress',
                'completed' => 'Completed'
            ];

            $dueDate = $task->due_date 
                ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') 
                : $task->created_at->copy()->addDays(5)->format('Y-m-d');

            return (object)[
                'id' => $task->id,
                'title' => $task->title,
                'start_date' => $task->created_at->format('Y-m-d'),
                'end_date' => $dueDate,
                'due_date' => $dueDate, // <--- Tambahkan ini
                'status' => $statusMap[$task->status] ?? 'Not Started'
            ];
        });

        return view('milestones.index', [
            'team' => $team,
            'milestones' => $milestones,
            'tasks' => $mappedTasks
        ]);
    }

    public function create($teamId)
    {
        $team = Team::findOrFail($teamId);
        return view('milestones.create', compact('team'));
    }


    public function store(Request $request, $teamId)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Not Started,In Progress,Completed',
        ]);

        Milestone::create([
            'team_id' => $teamId, // ✅ sesuaikan dengan struktur tabel terbaru
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('milestones.index', $teamId)->with('success', 'Milestone successfully added.');
    }

    public function edit($competitionId, $milestoneId)
    {
        $milestone = Milestone::where('team_id', $teamId)->findOrFail($milestoneId);
        return view('milestones.edit', compact('milestone', 'competitionId'));
    }

    public function update(Request $request, $teamId, $milestoneId)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Not Started,In Progress,Completed',
        ]);

        $milestone = Milestone::where('team_id', $teamId)->findOrFail($milestoneId);
        $milestone->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            // 'is_done' => $request->has('is_done'), // Checkbox handling
        ]);

        return redirect()->route('milestones.index', $teamId)->with('success', 'Milestone successfully updated.');
    }

    public function destroy($teamId, $milestoneId)
    {
        $milestone = Milestone::where('team_id', $teamId)->findOrFail($milestoneId);
        $milestone->delete();

        return redirect()->route('milestones.index', $teamId)->with('success', 'Milestone successfully deleted.');
    }

    public function toggleDone($id)
    {
        $milestone = Milestone::findOrFail($id);
        // $milestone->is_done = !$milestone->is_done;
        $milestone->save();

        return response()->json(['success' => true, 'is_done' => $milestone->is_done]);
    }
}