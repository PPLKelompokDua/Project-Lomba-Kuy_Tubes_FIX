<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $competitions = Competition::latest()->take(6)->get();
        $savedCompetitions = $user->savedCompetitions()->count();

        $ledTeamIds = $user->ledTeams()->pluck('teams.id')->toArray();
        $memberTeamIds = $user->memberTeams()->wherePivot('status', 'accepted')->pluck('teams.id')->toArray();
        $allTeamIds = array_unique(array_merge($ledTeamIds, $memberTeamIds));

        $completedCompetitions = Team::whereIn('id', $allTeamIds)
            ->where('status_team', 'finished')
            ->count();

        $activeCompetitions = Team::whereIn('id', $allTeamIds)
            ->where('status_team', 'ongoing')
            ->count();

        return view('dashboard', compact(
            'competitions',
            'savedCompetitions',
            'activeCompetitions',
            'completedCompetitions',
            'user'
        ));
    }
}

