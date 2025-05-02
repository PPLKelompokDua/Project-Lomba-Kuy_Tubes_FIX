<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamsMemberController extends Controller
{
    public function index($teamId)
{
    $team = Team::with('members')->findOrFail($teamId);
    return view('teams.members.index', compact('team'));
}

public function editRole(Request $request, $teamId, $userId)
{
    $team = Team::findOrFail($teamId);
    $team->members()->updateExistingPivot($userId, ['role' => $request->role]);
    return back()->with('success', 'Role updated!');
}

public function remove($teamId, $userId)
{
    $team = Team::findOrFail($teamId);
    $team->members()->detach($userId);
    return back()->with('success', 'Member removed.');
}
}
