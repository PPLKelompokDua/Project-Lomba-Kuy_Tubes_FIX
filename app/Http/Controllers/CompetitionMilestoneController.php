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
        return view('milestones.index', compact('competition'));
    }

    public function create($competitionId)
    {
        return view('milestones.create', ['competitionId' => $competitionId]);
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
        ]);

        return redirect()->route('milestones.index', $competitionId)->with('success', 'Milestone berhasil ditambahkan.');
    }
}

