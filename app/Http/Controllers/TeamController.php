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
            ->where('competition_id', $competitionId)
            ->where('name', $validated['name'])
            ->first();

        // Kalau sudah ada, skip create dan langsung redirect ke invitation
        if ($existingTeam) {
            return back()->with('error', 'You already created a team with this name for this competition.');
        }

        // Kalau belum, create baru
        $team = Team::create([
            'name' => $validated['name'],
            'competition_id' => $validated['competition_id'] ?? null,
            'leader_id' => Auth::id(),
            'competition_name' => $validated['competition_name'],
            'category' => $validated['category'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
        

        if (!empty($validated['invite_user_id'])) {
            return redirect()->route('invitations.index', [
                'team_id' => $team->id,
                'user_id' => $validated['invite_user_id']
            ])->with('success', 'Team berhasil dibuat!');
        }
        
        return redirect()->route('invitations.index', [
            'team_id' => $team->id
        ])->with('success', 'Team berhasil dibuat!');
    }

    public function index()
    {
        $user = Auth::user();

        $ledTeams = $user->ledTeams()->with('invitations', 'acceptedMembers')->get();

        // Tim yang diikuti sebagai member
        $memberTeams = $user->memberTeams()->with('acceptedMembers')->get();

        // Gabungkan tanpa duplikat (kalau user adalah leader dan member sekaligus)
        $teams = $ledTeams->merge($memberTeams)->unique('id');

        return view('teams.index', compact('teams', 'user'));
    }

    public function show($id)
    {
        $team = Team::with(['acceptedMembers', 'competition'])->findOrFail($id);
        $user = Auth::user();

        // Boleh lihat jika leader atau anggota accepted
        $isMember = $team->acceptedMembers->contains('id', $user->id);

        if ($team->leader_id !== $user->id && !$isMember) {
            abort(403);
        }

        return view('teams.show', compact('team', 'user'));
    }

    public function destroy(Team $team)
    {
        if ($team->leader_id !== Auth::id()) {
            abort(403, 'Only the team leader can delete the team.');
        }

        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully.');
    }
}
