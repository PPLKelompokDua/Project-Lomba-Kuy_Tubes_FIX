<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Team;

class ProductivityController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->input('days', 7);
        $teamId = auth()->user()->team_id; // Asumsikan user terkait dengan team

        // Data untuk line chart
        $chartData = $this->getProductivityChartData($teamId, $days);
        
        // Data untuk task distribution
        $taskDistribution = $this->getTaskDistribution($teamId);
        
        // Data member contribution
        $teamMembers = $this->getMemberContributions($teamId);

        return view('productivity', [
            'chartDates' => $chartData['dates'],
            'completedData' => $chartData['completed'],
            'pendingData' => $chartData['pending'],
            'taskDistribution' => $taskDistribution,
            'teamMembers' => $teamMembers,
            'selectedDays' => $days
        ]);
    }

    private function getProductivityChartData($teamId, $days)
    {
        $startDate = Carbon::now()->subDays($days);
        $endDate = Carbon::now();

        $completedTasks = Task::where('team_id', $teamId)
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->completed_at)->format('Y-m-d');
            });

        $pendingTasks = Task::where('team_id', $teamId)
            ->where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $dates = [];
        $completedData = [];
        $pendingData = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $dates[] = $date;
            $completedData[] = $completedTasks->has($date) ? $completedTasks[$date]->count() : 0;
            $pendingData[] = $pendingTasks->has($date) ? $pendingTasks[$date]->count() : 0;
        }

        return [
            'dates' => $dates,
            'completed' => $completedData,
            'pending' => $pendingData
        ];
    }

    private function getTaskDistribution($teamId)
    {
        return [
            Task::where('team_id', $teamId)->where('status', 'completed')->count(),
            Task::where('team_id', $teamId)->where('status', 'in_progress')->count(),
            Task::where('team_id', $teamId)->where('status', 'blocked')->count(),
            Task::where('team_id', $teamId)->where('status', 'pending')->count()
        ];
    }

    private function getMemberContributions($teamId)
    {
        return User::where('team_id', $teamId)
            ->withCount(['tasks as completed_tasks' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withCount(['tasks as total_tasks'])
            ->get()
            ->map(function($user) {
                return (object) [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.$user->name,
                    'completed_tasks' => $user->completed_tasks,
                    'total_tasks' => $user->total_tasks,
                    'completion_rate' => $user->total_tasks > 0 
                        ? round(($user->completed_tasks / $user->total_tasks) * 100)
                        : 0
                ];
            });
    }
}