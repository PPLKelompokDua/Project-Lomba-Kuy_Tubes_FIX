<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\Team;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\LearningVideo;

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

        $completedCompetitions = Team::whereIn('id', $allTeamIds)->where('status_team', 'finished')->count();
        $activeCompetitions = Team::whereIn('id', $allTeamIds)->where('status_team', 'ongoing')->count();

        $assignedTasks = Task::with('team')
            ->where('assigned_user_id', auth()->id())
            ->whereNotNull('due_date')
            ->orderBy('due_date')
            ->take(3)
            ->get();

        $total = $assignedTasks->count();
        $completed = $assignedTasks->where('status', 'completed')->count();
        $overallProgress = $total > 0 ? round(($completed / $total) * 100) : 0;

        $latestArticles = Article::where('status', 'published')
                ->latest()
                ->take(5)
                ->get();

        $learningVideos = LearningVideo::where('is_published', true)
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            

        return view('dashboard', compact(
            'competitions',
            'savedCompetitions',
            'activeCompetitions',
            'completedCompetitions',
            'overallProgress',
            'assignedTasks', 
            'user',
            'latestArticles',
            'learningVideos'
        ));
    }
}
