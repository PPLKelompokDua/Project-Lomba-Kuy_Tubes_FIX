<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Jika menggunakan dompdf
use Maatwebsite\Excel\Facades\Excel; // Jika menggunakan Laravel Excel
use App\Exports\ProductivityExport; // Jika menggunakan Laravel Excel


class ProductivityController extends Controller
{
    /**
     * Display the Team Productivity dashboard
     */
    public function index()
    {
        // Get initial stats for rendering
        $stats = $this->getProductivityStats('week');
        
        return view('team-productivity', [
            'initialStats' => $stats
        ]);
    }
    
    /**
     * Get productivity data for charts based on time period
     */
    public function getProductivityData(Request $request)
{
    $period = $request->input('period', 'week');
    
    $stats = $this->getProductivityStats($period);
    
    return response()->json($stats);
}
    /**
     * Compute productivity statistics based on specified time period
     */
    private function getProductivityStats($period)
    {
        // Define date ranges based on period
        $endDate = Carbon::now();
        $startDate = $this->getStartDateByPeriod($period);
        
        // Get tasks within the date range
        $tasks = Task::whereBetween('created_at', [$startDate, $endDate])
                     ->orWhereBetween('updated_at', [$startDate, $endDate])
                     ->with('user') // Eager load user data
                     ->get();
        
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
        
        // Process each task
        foreach ($tasks as $task) {
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
        
        // Ambil semua nilai (jumlah tugas) dari array as-is
        $tasksPerDay = array_map(function($date) use($completedData){
            return $completedData[$date] ?? 0;
        }, $dateLabels);
    ;
        
        $avgLeadTime = $this->calculateAverageLeadTime($completionTimes);
        
        // Return formatted data for frontend
        return [
            'dates' => $dateLabels,
            'completed' => $completedData,
            'created' => $createdData,
            'blocked' => $blockedData,
            'taskDistribution' => [$completed, $inProgress, $blocked, $pending],
            'completionRate' => $completionRate,
            'tasksPerDay' => $tasksPerDay,
            'avgLeadTime' => $avgLeadTime,
            'blockedTasksCount' => $blocked,
            'blockedPercentage' => $totalTasks > 0 ? round(($blocked / $totalTasks) * 100) : 0,
            'bottleneckTasks' => $bottleneckTasks
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
                if ($task->completed_at && $task->created_at) {
                    $completionTimes[] = $task->completed_at->diffInDays($task->created_at);
                }
                break;
                
            case 'in_progress':
                $inProgress++;
                
                // Check for stagnant tasks (in progress for more than 5 days)
                if ($task->last_activity_at && $task->last_activity_at->diffInDays(Carbon::now()) > 5) {
                    $bottleneckTasks[] = $this->formatBottleneckTask($task, 'stagnant');
                }
                break;
                
            case 'blocked':
                $blocked++;
                
                // Add to bottleneck tasks
                $daysBlocked = $task->blocked_at ? $task->blocked_at->diffInDays(Carbon::now()) : 0;
                $bottleneckTasks[] = $this->formatBottleneckTask($task, 'blocked', $daysBlocked);
                break;
                
            case 'pending':
            default:
                $pending++;
                break;
        }
        
        // Check for overdue tasks
        if ($task->due_date && Carbon::now()->gt($task->due_date) && $task->status != 'completed') {
            $daysOverdue = Carbon::now()->diffInDays($task->due_date);
            $bottleneckTasks[] = $this->formatBottleneckTask($task, 'overdue', $daysOverdue);
        }
    }
    
    /**
     * Format task data for bottleneck display
     */
    private function formatBottleneckTask($task, $bottleneckType, $days = 0)
    {
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
            'due_date_formatted' => $task->due_date ? $task->due_date->format('M d, Y') : 'No deadline',
            'blocker_reason' => $task->blocker_reason ?? 'No reason specified'
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

    public function exportReport(Request $request)
    {

        // Validate request
        $request->validate([
            'period' => 'required|string|in:week,month,quarter',
            'exportType' => 'required|string|in:pdf,csv,excel'
        ]);
        
        $period = $request->input('period');
        $exportType = $request->input('exportType');
        
        // Get productivity data
        $data = $this->getProductivityStats($period);
        
        // Generate filename
        $filename = 'productivity_report_' . date('Y-m-d') . '.' . strtolower($exportType);
        
        // In a real implementation, you would use a PDF library like dompdf, mpdf, or other reporting tools
        // to generate the actual report file.
        
        // For this example, we'll just return a download URL
        $downloadUrl = url('storage/exports/' . $filename);
        
        // Return the download URL
        return response()->json([
            'success' => true,
            'downloadUrl' => $downloadUrl,
            'filename' => $filename
        ]);
    }
    
    /**
     * Share productivity report via email
     */
    public function shareReport(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'message' => 'nullable|string',
        'period' => 'required|string|in:week,month,quarter'
    ]);
    
    $data = $this->getProductivityStats($request->period);
    
    // Generate PDF
    $pdf = PDF::loadView('exports.report', $data);
    
    // Kirim email
    Mail::to($request->email)->send(new ProductivityReportMail($data, $request->message, $pdf));
    
    return response()->json([
        'success' => true,
        'message' => 'Report has been shared successfully to ' . $request->email
    ]);
}

    
}