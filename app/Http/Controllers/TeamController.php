<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitation;
use App\Models\User;

class TeamController extends Controller
{
    public function create(Request $request)
    {
        $competitionId = $request->input('competition_id');
        $userId = $request->input('user_id');

        $competition = null;
        $recommendedUser = null;

        if ($competitionId) {
            $competition = \App\Models\Competition::find($competitionId);
        }

        if ($userId) {
            $recommendedUser = \App\Models\User::find($userId);
        }

        return view('teams.create', compact('competition', 'recommendedUser'));
    }


    public function createFromRecommendation($userId)
    {
        $user = User::findOrFail($userId);

        return view('teams.create', [
            'recommendedUser' => $user
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'competition_id' => 'nullable|exists:competitions,id',
            'competition_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'invite_user_id' => 'nullable|exists:users,id',
        ]);

        // Cari dulu apakah user sudah punya tim untuk kompetisi ini
        $competitionId = $validated['competition_id'] ?? null;

        $existingTeam = Team::where('leader_id', Auth::id())
            ->when($competitionId, function ($query, $competitionId) {
                return $query->where('competition_id', $competitionId);
            })
            ->first();

        // Kalau sudah ada, skip create dan langsung redirect ke invitation
        if ($existingTeam) {
            if (!empty($validated['invite_user_id'])) {
                return redirect()->route('invitations.create', [
                    'team_id' => $existingTeam->id,
                    'user_id' => $validated['invite_user_id']
                ]);
            } else {
                return redirect()->route('invitations.index')->with('success', 'Team already exists.');
            }
        }

        // Kalau belum, create baru
        $team = Team::create([
            'name' => $validated['name'],
            'competition_id' => $validated['competition_id'],
            'leader_id' => Auth::id(),
            'competition_name' => $validated['competition_name'],
            'category' => $validated['category'],
            'deadline' => $validated['deadline'],
            'location' => $validated['location'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('invitations.index', [
            'team_id' => $team->id,
            'user_id' => $validated['invite_user_id']
        ]);
    }

    public function index()
    {
        $teams = Auth::user()->ledTeams()->with('invitations', 'acceptedMembers')->get();

        return view('teams.index', compact('teams'));
    }

    public function show($id)
    {
        $team = Team::with(['acceptedMembers', 'competition'])->findOrFail($id);

        if ($team->leader_id !== Auth::id()) {
            abort(403);
        }

        return view('teams.show', compact('team'));
    }


}
