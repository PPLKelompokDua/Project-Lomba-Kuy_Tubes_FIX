<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionMilestoneController extends Controller
{
    public function index($competitionId)
    {
        $competition = Competition::with('milestones')->findOrFail($competitionId);
        $milestones = $competition->milestones;

        return view('milestones.index', compact('competition', 'milestones'));
    }

        public function create($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        return view('milestones.create', compact('competition'));
    }


    public function store(Request $request, $competitionId)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Not Started,In Progress,Completed',
        ]);

        Milestone::create([
            'competition_id' => $competitionId,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            // 'is_done' => $request->has('is_done'), // Checkbox handling
        ]);

        return redirect()->route('milestones.index', $competitionId)->with('success', 'Milestone berhasil ditambahkan.');
    }

    public function edit($competitionId, $milestoneId)
    {
        $milestone = Milestone::where('competition_id', $competitionId)->findOrFail($milestoneId);
        return view('milestones.edit', compact('milestone', 'competitionId'));
    }

    public function update(Request $request, $competitionId, $milestoneId)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Not Started,In Progress,Completed',
        ]);

        $milestone = Milestone::where('competition_id', $competitionId)->findOrFail($milestoneId);
        $milestone->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            // 'is_done' => $request->has('is_done'), // Checkbox handling
        ]);

        return redirect()->route('milestones.index', $competitionId)->with('success', 'Milestone berhasil diperbarui.');
    }

    public function destroy($competitionId, $milestoneId)
    {
        $milestone = Milestone::where('competition_id', $competitionId)->findOrFail($milestoneId);
        $milestone->delete();

        return redirect()->route('milestones.index', $competitionId)->with('success', 'Milestone berhasil dihapus.');
    }

    public function chart($competitionId)
    {
        $competition = Competition::with('milestones')->findOrFail($competitionId);
        return view('milestones.chart', compact('competition'));
    }

    public function showChart($competitionId)
    {
        $competition = Competition::with('milestones')->findOrFail($competitionId);
        return view('competitions.milestones.chart', compact('competition'));
    }

    public function toggleDone($id)
    {
        $milestone = Milestone::findOrFail($id);
        // $milestone->is_done = !$milestone->is_done;
        $milestone->save();

        return response()->json(['success' => true, 'is_done' => $milestone->is_done]);
    }
}
