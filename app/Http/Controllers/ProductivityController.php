<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\ProductivityReportShared;

class ProductivityController extends Controller
{
    /**
     * Display the Team Productivity dashboard
     */
    public function index(Team $team)
    {
        $user = auth()->user();
        if (
            !$team->members->contains($user->id) &&
            $team->leader_id !== $user->id
        ) {
            abort(403, 'You are not a member or leader of this team.');
        }

        // Get initial stats for rendering
        $stats = $this->getProductivityStats($team, 'week');
        
        return view('team.productivity', [
            'team' => $team,
            'initialStats' => $stats
        ]);
    }
    
    /**
     * Get productivity data for charts based on time period
     */
    public function getProductivityData(Request $request, Team $team)
    {
        $user = auth()->user();
        if (
            !$team->members->contains($user->id) &&
            $team->leader_id !== $user->id
        ) {
            abort(403, 'You are not a member or leader of this team.');
        }

        $period = $request->input('period', 'week');
        $memberId = $request->input('member', 'all');
        $role = $request->input('role', 'all');
        $stats = $this->getProductivityStats($team, $period, $memberId, $role);
        return response()->json($stats);
    }

    /**
     * Export productivity report as PDF
     */
    public function exportReport(Request $request, Team $team)
    {
        $user = auth()->user();
        if (
            !$team->members->contains($user->id) &&
            $team->leader_id !== $user->id
        ) {
            abort(403, 'You are not a member or leader of this team.');
        }

        $period = $request->input('period', 'week');
        $stats = $this->getProductivityStats($team, $period);
        
        $pdf = PDF::loadView('reports.team-productivity', [
            'team' => $team,
            'stats' => $stats,
            'period' => ucfirst($period)
        ]);
        
        return $pdf->download('team-productivity-report.pdf');
    }

    /**
     * Share productivity report with team members
     */
    public function shareReport(Request $request, Team $team)
    {
        // Check if user is the team leader
        if (auth()->user()->id !== $team->leader_id) {
            abort(403, 'Only team leaders can share reports.');
        }

        $request->validate([
            'feedback_member' => 'required|array',
        ]);
        $feedbacks = $request->input('feedback_member', []);
        $period = $request->input('period', 'week');
        $stats = $this->getProductivityStats($team, $period);

        // Generate PDF (team-wide, can include summary or all feedbacks if desired)
        $pdf = PDF::loadView('reports.team-productivity', [
            'team' => $team,
            'stats' => $stats,
            'period' => ucfirst($period),
            'feedbacks' => $feedbacks
        ]);
        $pdfPath = storage_path('app/temp/productivity-report-' . $team->id . '.pdf');
        $pdf->save($pdfPath);

        // Notify each member with their own feedback (if any)
        foreach ($team->members as $member) {
            if ($member->id !== $team->leader_id && !empty($feedbacks[$member->id])) {
                $member->notify(new ProductivityReportShared($team, $pdfPath, $feedbacks[$member->id]));
            }
        }
        // Optionally, notify the leader with their own feedback if present
        if (!empty($feedbacks[$team->leader_id])) {
            $team->leader->notify(new ProductivityReportShared($team, $pdfPath, $feedbacks[$team->leader_id]));
        }
        return response()->json(['success' => true]);
    }

    /**
     * Export productivity report as PDF with chart images
     */
    public function exportReportWithCharts(Request $request, Team $team)
    {
        $user = auth()->user();
        if (
            !$team->members->contains($user->id) &&
            $team->leader_id !== $user->id
        ) {
            abort(403, 'You are not a member or leader of this team.');
        }

        $period = $request->input('period', 'week');
        $stats = $this->getProductivityStats($team, $period);

        // Get chart images from request
        $taskDistributionChart = $request->input('taskDistributionChart');
        $statusOverTimeChart = $request->input('statusOverTimeChart');
        $trendChart = $request->input('trendChart');

        $pdf = PDF::loadView('reports.team-productivity', [
            'team' => $team,
            'stats' => $stats,
            'period' => ucfirst($period),
            'taskDistributionChart' => $taskDistributionChart,
            'statusOverTimeChart' => $statusOverTimeChart,
            'trendChart' => $trendChart
        ]);

        return $pdf->download('team-productivity-report.pdf');
    }

    /**
     * Compute productivity statistics based on specified time period and member
     */
    private function getProductivityStats(Team $team, $period, $memberId = 'all', $role = 'all')
    {
        $endDate = Carbon::now();
        $startDate = $this->getStartDateByPeriod($period);

        // Determine user IDs to include based on role filter
        $userIds = collect();
        if ($role === 'leader') {
            $userIds = collect([$team->leader_id]);
        } elseif ($role === 'member') {
            $userIds = $team->members->pluck('id')->filter(fn($id) => $id != $team->leader_id);
        } else {
            $userIds = $team->members->pluck('id');
            if (!$userIds->contains($team->leader_id)) {
                $userIds = $userIds->push($team->leader_id);
            }
        }

        // Only tasks for this team and its competition, filtered by member/role if set
        $tasksQuery = Task::where('team_id', $team->id)
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                      ->orWhereBetween('updated_at', [$startDate, $endDate]);
            });
        if ($memberId !== 'all') {
            $tasksQuery->where(function($q) use ($memberId) {
                $q->where('user_id', $memberId)
                  ->orWhere('assigned_user_id', $memberId);
            });
        } elseif ($role !== 'all') {
            $tasksQuery->where(function($q) use ($userIds) {
                $q->whereIn('user_id', $userIds)
                  ->orWhereIn('assigned_user_id', $userIds);
            });
        }
        $tasks = $tasksQuery->with('user')->get();

        // Trend: tasks completed per week (last 4 weeks)
        $trend = $this->getTaskCompletionTrend($team, $memberId, $role);
        $statusOverTime = $this->getTaskStatusOverTime($team, $period, $memberId, $role);

        // Leaderboard: top contributors by completed tasks (in period)
        $leaderboard = $this->getLeaderboard($team, $startDate, $endDate, $memberId, $role);

        // Risk/Health: count overdue, blocked, and inactive members
        $risk = $this->getRiskIndicators($team, $tasks, $memberId, $role);

        // Actionable insights
        $insights = $this->getActionableInsights($team, $tasks, $memberId, $role);

        // Calculate date labels for charts
        $dateLabels = $this->generateDateLabels($startDate, $endDate, $period);
        
        // Initialize data arrays for charts
        $completedData = array_fill(0, count($dateLabels), 0);
        $createdData = array_fill(0, count($dateLabels), 0);
        $blockedData = array_fill(0, count($dateLabels), 0);
        
        // Task distribution counters
        $completed = 0;
        $inProgress = 0;
        $blocked = 0;
        $pending = 0;
        
        // Task completion timestamps for lead time calculation
        $completionTimes = [];
        
        // Track bottleneck tasks
        $bottleneckTasks = [];
        
        // Collect tasks by status for frontend modals and accuracy
        $tasksByStatus = [
            'completed' => [],
            'in_progress' => [],
            'blocked' => [],
            'pending' => []
        ];
        foreach ($tasks as $task) {
            $arr = [
                'id' => $task->id,
                'title' => $task->title,
                'assignee' => $task->user ? ['id' => $task->user->id, 'name' => $task->user->name] : null,
                'status' => $task->status,
                'due_date' => $task->due_date,
                'completed_at' => $task->completed_at
            ];
            if ($task->status === 'completed') $tasksByStatus['completed'][] = $arr;
            elseif ($task->status === 'in_progress') $tasksByStatus['in_progress'][] = $arr;
            elseif ($task->status === 'blocked') $tasksByStatus['blocked'][] = $arr;
            else $tasksByStatus['pending'][] = $arr;
            
            // Process for line chart data by date
            $this->processTaskForChartData(
                $task, 
                $startDate, 
                $dateLabels, 
                $completedData, 
                $createdData, 
                $blockedData, 
                $period
            );
            
            // Process for task distribution
            $this->processTaskForDistribution(
                $task, 
                $completed, 
                $inProgress, 
                $blocked, 
                $pending, 
                $completionTimes, 
                $bottleneckTasks
            );
        }
        
        // Calculate metrics
        $totalTasks = $completed + $inProgress + $blocked + $pending;
        $completionRate = $totalTasks > 0 ? round(($completed / $totalTasks) * 100) : 0;
        
        $tasksPerDay = array_map(function($date) use($completedData) {
            return $completedData[$date] ?? 0;
        }, $dateLabels);
        
        $avgLeadTime = $this->calculateAverageLeadTime($completionTimes);

        // Calculate average tasks per day (single value)
        $avgTasksPerDay = (count($completedData) > 0) ? round(array_sum($completedData) / count($completedData), 1) : 0;

        return [
            'dates' => $dateLabels,
            'completed' => $completedData,
            'created' => $createdData,
            'blocked' => $blockedData,
            'taskDistribution' => [$completed, $inProgress, $blocked, $pending],
            'completionRate' => $completionRate,
            'tasksPerDay' => $avgTasksPerDay,
            'avgLeadTime' => $avgLeadTime,
            'blockedTasksCount' => $blocked,
            'blockedPercentage' => $totalTasks > 0 ? round(($blocked / $totalTasks) * 100) : 0,
            'bottleneckTasks' => $bottleneckTasks,
            'trend' => $trend,
            'leaderboard' => $leaderboard,
            'risk' => $risk,
            'insights' => $insights,
            'milestones' => [],
            'statusOverTime' => $statusOverTime,
            'tasks' => $tasksByStatus,
        ];
    }
    
    /**
     * Get start date based on selected period
     */
    private function getStartDateByPeriod($period)
    {
        $now = Carbon::now();
        
        switch (strtolower($period)) {
            case 'week':
                return $now->copy()->subDays(6)->startOfDay();
            case 'month':
                return $now->copy()->subDays(29)->startOfDay();
            case 'quarter':
                return $now->copy()->subDays(89)->startOfDay();
            default:
                return $now->copy()->subDays(6)->startOfDay();
        }
    }
    
    /**
     * Generate date labels for chart x-axis
     */
    private function generateDateLabels($startDate, $endDate, $period)
    {
        $labels = [];
        $currentDate = $startDate->copy();
        
        // Format based on period
        $format = $this->getDateFormatByPeriod($period);
        
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format($format);
            
            // Increment based on period
            if ($period == 'week' || $period == 'month') {
                $currentDate->addDay();
            } else {
                // For quarter, increment by week
                $currentDate->addWeek();
            }
        }
        
        return $labels;
    }
    
    /**
     * Get date format string based on period
     */
    private function getDateFormatByPeriod($period)
    {
        switch (strtolower($period)) {
            case 'week':
                return 'D'; // Mon, Tue, etc.
            case 'month':
                return 'j M'; // 1 Jan, 2 Jan, etc.
            case 'quarter':
                return 'j M'; // Week starting dates
            default:
                return 'D';
        }
    }
    
    /**
     * Process task data for chart visualization
     */
    private function processTaskForChartData(
        $task, 
        $startDate, 
        $dateLabels, 
        &$completedData, 
        &$createdData, 
        &$blockedData, 
        $period
    ) {
        // Process created date for chart
        if ($task->created_at >= $startDate) {
            $createdIndex = $this->getDateIndex($task->created_at, $startDate, $period);
            if (isset($createdData[$createdIndex])) {
                $createdData[$createdIndex]++;
            }
        }
        
        // Process completion date for chart
        if ($task->status == 'completed' && $task->completed_at >= $startDate) {
            $completedIndex = $this->getDateIndex($task->completed_at, $startDate, $period);
            if (isset($completedData[$completedIndex])) {
                $completedData[$completedIndex]++;
            }
        }
        
        // Process blocked status for chart
        if ($task->status == 'blocked' && $task->blocked_at >= $startDate) {
            $blockedIndex = $this->getDateIndex($task->blocked_at, $startDate, $period);
            if (isset($blockedData[$blockedIndex])) {
                $blockedData[$blockedIndex]++;
            }
        }
    }
    
    /**
     * Get index in the date labels array for a specific date
     */
    private function getDateIndex($date, $startDate, $period)
    {
        // Ensure both are Carbon instances
        if (!($date instanceof \Carbon\Carbon)) {
            $date = \Carbon\Carbon::parse($date);
        }
        if (!($startDate instanceof \Carbon\Carbon)) {
            $startDate = \Carbon\Carbon::parse($startDate);
        }

        if ($period == 'week' || $period == 'month') {
            return $date->diffInDays($startDate);
        } else {
            // For quarter, calculate by week
            return floor($date->diffInDays($startDate) / 7);
        }
    }
    
    /**
     * Process task for distribution statistics and bottleneck detection
     */
    private function processTaskForDistribution(
        $task, 
        &$completed, 
        &$inProgress, 
        &$blocked, 
        &$pending, 
        &$completionTimes, 
        &$bottleneckTasks
    ) {
        // Count task by status
        switch ($task->status) {
            case 'completed':
                $completed++;
                // Calculate lead time
                $completedAt = $this->toCarbonOrNull($task->completed_at);
                $createdAt = $this->toCarbonOrNull($task->created_at);
                if ($completedAt && $createdAt) {
                    $completionTimes[] = $completedAt->diffInDays($createdAt);
                }
                break;
            case 'in_progress':
                $inProgress++;
                // Check for stagnant tasks (in progress for more than 5 days)
                $lastActivityAt = $this->toCarbonOrNull($task->last_activity_at);
                if ($lastActivityAt && $lastActivityAt->diffInDays(\Carbon\Carbon::now()) > 5) {
                    $bottleneckTasks[] = $this->formatBottleneckTask($task, 'stagnant');
                }
                break;
            case 'blocked':
                $blocked++;
                // Add to bottleneck tasks
                $blockedAt = $this->toCarbonOrNull($task->blocked_at);
                $daysBlocked = $blockedAt ? $blockedAt->diffInDays(\Carbon\Carbon::now()) : 0;
                $bottleneckTasks[] = $this->formatBottleneckTask($task, 'blocked', $daysBlocked);
                break;
            case 'pending':
            default:
                $pending++;
                break;
        }
        // Check for overdue tasks
        $dueDate = $this->toCarbonOrNull($task->due_date);
        if ($dueDate && \Carbon\Carbon::now()->gt($dueDate) && $task->status != 'completed') {
            $daysOverdue = \Carbon\Carbon::now()->diffInDays($dueDate);
            $bottleneckTasks[] = $this->formatBottleneckTask($task, 'overdue', $daysOverdue);
        }
    }
    
    /**
     * Format task data for bottleneck display
     */
    private function formatBottleneckTask($task, $bottleneckType, $days = 0)
    {
        $dueDate = $this->toCarbonOrNull($task->due_date);
        $reasons = [];
        if ($bottleneckType == 'blocked') $reasons[] = 'Blocked: ' . ($task->blocker_reason ?? 'No reason specified');
        if ($bottleneckType == 'overdue') $reasons[] = 'Overdue';
        if ($bottleneckType == 'stagnant') $reasons[] = 'Stagnant (no progress >5 days)';
        return [
            'id' => $task->id,
            'title' => $task->title,
            'assignee' => [
                'id' => $task->user->id,
                'name' => $task->user->name
            ],
            'status' => $task->status,
            'bottleneck_type' => $bottleneckType,
            'days_blocked' => $bottleneckType == 'blocked' ? $days : null,
            'days_delayed' => $bottleneckType == 'overdue' ? $days : null,
            'days_stagnant' => $bottleneckType == 'stagnant' ? $days : null,
            'due_date' => $task->due_date,
            'due_date_formatted' => $dueDate ? $dueDate->format('M d, Y') : 'No deadline',
            'blocker_reason' => implode('; ', $reasons)
        ];
    }
    
    /**
     * Calculate average tasks completed per day
     */
    private function calculateTasksPerDay($completedData, $days)
    {
        $totalCompleted = array_sum($completedData);
        return $days > 0 ? round($totalCompleted / $days, 1) : 0;
    }
    
    /**
     * Calculate average lead time (days from creation to completion)
     */
    private function calculateAverageLeadTime($completionTimes)
    {
        if (empty($completionTimes)) {
            return 0;
        }
        
        return round(array_sum($completionTimes) / count($completionTimes), 1);
    }

    /**
     * Ensure a value is a Carbon instance or null
     */
    private function toCarbonOrNull($value)
    {
        if (!$value) return null;
        if ($value instanceof \Carbon\Carbon) return $value;
        try {
            return \Carbon\Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    // Trend analysis: tasks completed per week (last 4 weeks)
    private function getTaskCompletionTrend(Team $team, $memberId = 'all', $role = 'all')
    {
        $trend = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = Carbon::now()->subWeeks($i+1)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();
            $query = Task::where('team_id', $team->id)
                ->where('status', 'completed')
                ->whereBetween('completed_at', [$start, $end]);
            if ($memberId !== 'all') {
                $query->where(function($q) use ($memberId) {
                    $q->where('user_id', $memberId)
                      ->orWhere('assigned_user_id', $memberId);
                });
            } elseif ($role === 'leader') {
                $query->where('user_id', $team->leader_id);
            } elseif ($role === 'member') {
                $memberIds = $team->members->pluck('id')->filter(fn($id) => $id != $team->leader_id);
                $query->whereIn('user_id', $memberIds);
            }
            $count = $query->count();
            $trend[] = [
                'week' => $start->format('M d'),
                'completed' => $count
            ];
        }
        while (count($trend) < 4) {
            $trend[] = ['week' => '', 'completed' => 0];
        }
        return $trend;
    }

    // Leaderboard: top contributors by completed tasks (in period)
    private function getLeaderboard(Team $team, $startDate = null, $endDate = null, $memberId = 'all', $role = 'all')
    {
        $users = $team->members->keyBy('id');
        if (!$users->has($team->leader_id) && $team->leader) {
            $users->put($team->leader_id, $team->leader);
        }
        $scores = [];
        foreach ($users as $user) {
            $query = Task::where('team_id', $team->id)
                ->where('status', 'completed');
            if ($startDate && $endDate) {
                $query->whereBetween('completed_at', [$startDate, $endDate]);
            }
            if ($memberId !== 'all') {
                $query->where(function($q) use ($user, $memberId) {
                    $q->where('user_id', $memberId)
                      ->orWhere('assigned_user_id', $memberId);
                });
            } elseif ($role === 'leader') {
                $query->where('user_id', $team->leader_id);
            } elseif ($role === 'member') {
                $memberIds = $team->members->pluck('id')->filter(fn($id) => $id != $team->leader_id);
                $query->whereIn('user_id', $memberIds);
            }
            $roleLabel = ($user->id == $team->leader_id) ? 'Leader' : 'Member';
            $scores[] = [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $roleLabel,
                'completed' => $query->count()
            ];
        }
        usort($scores, fn($a, $b) => $b['completed'] <=> $a['completed']);
        $allZero = array_reduce($scores, fn($carry, $item) => $carry && $item['completed'] == 0, true);
        return $allZero ? [] : array_slice($scores, 0, 5);
    }

    // Risk/Health indicator
    private function getRiskIndicators(Team $team, $tasks, $memberId = 'all', $role = 'all')
    {
        $overdue = 0; $blocked = 0; $inactive = 0;
        $overdueTasks = [];
        $blockedTasks = [];
        foreach ($tasks as $task) {
            $dueDate = $this->toCarbonOrNull($task->due_date);
            if ($dueDate && Carbon::now()->gt($dueDate) && $task->status != 'completed') {
                $overdue++;
                $overdueTasks[] = $task->title;
            }
            if ($task->status == 'blocked') {
                $blocked++;
                $blockedTasks[] = $task->title;
            }
        }
        $inactiveMembers = [];
        foreach ($team->members as $user) {
            $query = Task::where('team_id', $team->id)
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->where('completed_at', '>=', Carbon::now()->subWeeks(2));
            if ($memberId !== 'all') {
                $query->where(function($q) use ($memberId) {
                    $q->where('user_id', $memberId)
                      ->orWhere('assigned_user_id', $memberId);
                });
            } elseif ($role === 'leader') {
                $query->where('user_id', $team->leader_id);
            } elseif ($role === 'member') {
                $memberIds = $team->members->pluck('id')->filter(fn($id) => $id != $team->leader_id);
                $query->whereIn('user_id', $memberIds);
            }
            $recent = $query->count();
            if ($recent == 0) $inactiveMembers[] = $user->name;
        }
        return [
            'overdue' => $overdue,
            'overdueTasks' => $overdueTasks,
            'blocked' => $blocked,
            'blockedTasks' => $blockedTasks,
            'inactive' => $inactiveMembers
        ];
    }

    // Actionable insights
    private function getActionableInsights(Team $team, $tasks, $memberId = 'all', $role = 'all')
    {
        $insights = [];
        $risk = $this->getRiskIndicators($team, $tasks, $memberId, $role);
        if ($risk['overdue'] > 0) {
            $insights[] = $risk['overdue'] . ' tasks are overdue!';
            if (!empty($risk['overdueTasks'])) {
                $insights[] = 'Overdue tasks: ' . implode(', ', $risk['overdueTasks']);
            }
        }
        if ($risk['blocked'] > 0) {
            $insights[] = $risk['blocked'] . ' tasks are blocked!';
            if (!empty($risk['blockedTasks'])) {
                $insights[] = 'Blocked tasks: ' . implode(', ', $risk['blockedTasks']);
            }
        }
        if (count($risk['inactive']) > 0) $insights[] = 'Inactive members: ' . implode(', ', $risk['inactive']);
        if (empty($insights)) $insights[] = 'All systems normal. Keep up the good work!';
        return $insights;
    }

    private function getTaskStatusOverTime(Team $team, $period = 'week', $memberId = 'all', $role = 'all')
    {
        $weeks = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = Carbon::now()->subWeeks($i+1)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();
            $statuses = ['completed', 'in_progress', 'blocked', 'pending'];
            $counts = [];
            foreach ($statuses as $status) {
                $query = Task::where('team_id', $team->id)
                    ->where('status', $status)
                    ->whereBetween('created_at', [$start, $end]);
                if ($memberId !== 'all') {
                    $query->where(function($q) use ($memberId) {
                        $q->where('user_id', $memberId)
                          ->orWhere('assigned_user_id', $memberId);
                    });
                } elseif ($role === 'leader') {
                    $query->where('user_id', $team->leader_id);
                } elseif ($role === 'member') {
                    $memberIds = $team->members->pluck('id')->filter(fn($id) => $id != $team->leader_id);
                    $query->whereIn('user_id', $memberIds);
                }
                $counts[$status] = $query->count();
            }
            $weeks[] = [
                'week' => $start->format('M d'),
                'completed' => $counts['completed'],
                'in_progress' => $counts['in_progress'],
                'blocked' => $counts['blocked'],
                'pending' => $counts['pending'],
            ];
        }
        return $weeks;
    }
}