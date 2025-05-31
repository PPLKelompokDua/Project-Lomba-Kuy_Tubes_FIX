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
use App\Models\Milestone;

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

        // Untuk progress bar (semua task dengan due_date, termasuk completed)
        $allAssignedTasks = Task::where('assigned_user_id', auth()->id())
            ->whereNotNull('due_date')
            ->get();

        $total = $allAssignedTasks->count();
        $completed = $allAssignedTasks->where('status', 'completed')->count();
        $overallProgress = $total > 0 ? round(($completed / $total) * 100) : 0;

        // Untuk tampilan task (exclude completed)
        $assignedTasks = $allAssignedTasks->where('status', '!=', 'completed')->take(6);

        $latestArticles = Article::where('status', 'published')
                ->latest()
                ->take(5)
                ->get();

        $learningVideos = LearningVideo::where('is_published', true)
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
            
        $upcomingMilestones = Milestone::whereIn('team_id', $allTeamIds)
            ->where('status', '!=', 'completed')
            ->whereDate('end_date', '>=', Carbon::today())
            ->orderBy('end_date')
            ->take(5)
            ->get();

        $totalUpcomingMilestones = Milestone::whereIn('team_id', $allTeamIds)
            ->where('status', '!=', 'completed')
            ->whereDate('end_date', '>=', Carbon::today())
            ->count();

        return view('dashboard', compact(
            'competitions',
            'savedCompetitions',
            'activeCompetitions',
            'completedCompetitions',
            'overallProgress',
            'assignedTasks', 
            'user',
            'latestArticles',
            'upcomingMilestones',
            'totalUpcomingMilestones',
            'learningVideos'
        ));
    }
}
