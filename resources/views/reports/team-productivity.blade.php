<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Team Productivity Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #2d3748;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .metrics {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .metric {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            width: 23%;
        }
        .metric h3 {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .metric p {
            margin: 5px 0 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .bottleneck {
            background: #fff3f3;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
        }
        .bottleneck h4 {
            margin: 0 0 5px;
            color: #dc3545;
        }
        .bottleneck p {
            margin: 0;
            color: #666;
        }
        .milestone {
            margin-bottom: 20px;
        }
        .milestone-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .milestone-title {
            font-weight: bold;
            color: #2d3748;
        }
        .milestone-progress {
            color: #4a5568;
        }
        .progress-bar {
            height: 10px;
            background: #e2e8f0;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            background: #4299e1;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .feedback {
            background: #f0fff4;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
            border-left: 4px solid #48bb78;
        }
        .feedback h3 {
            color: #2f855a;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Team Productivity Report</h1>
        <p>Generated on {{ now()->format('F j, Y') }}</p>
    </div>

    <div class="section">
        <h2>Team Overview</h2>
        <p><strong>Team:</strong> {{ $team->name }}</p>
        <p><strong>Competition:</strong> {{ $team->competition->title }}</p>
        <p><strong>Period:</strong> {{ $period }}</p>
    </div>

    <div class="section">
        <h2>Key Metrics</h2>
        <div class="metrics">
            <div class="metric">
                <h3>Completion Rate</h3>
                <p>{{ $stats['completionRate'] }}%</p>
            </div>
            <div class="metric">
                <h3>Average Lead Time</h3>
                <p>{{ $stats['avgLeadTime'] }} days</p>
            </div>
            <div class="metric">
                <h3>Blocked Tasks</h3>
                <p>{{ $stats['blockedTasksCount'] }}</p>
            </div>
            <div class="metric">
                <h3>Tasks Per Day</h3>
                <p>{{ $stats['tasksPerDay'] }}</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Task Distribution</h2>
        <p><strong>Completed:</strong> {{ $stats['taskDistribution'][0] }}</p>
        <p><strong>In Progress:</strong> {{ $stats['taskDistribution'][1] }}</p>
        <p><strong>Blocked:</strong> {{ $stats['taskDistribution'][2] }}</p>
        <p><strong>Pending:</strong> {{ $stats['taskDistribution'][3] }}</p>
    </div>

    <div class="section">
        <h2>Bottleneck Tasks</h2>
        @foreach($stats['bottleneckTasks'] as $task)
        <div class="bottleneck">
            <h4>{{ $task['title'] }}</h4>
            <p><strong>Status:</strong> {{ ucfirst($task['status']) }}</p>
            <p><strong>Assignee:</strong> {{ $task['assignee']['name'] }}</p>
            <p><strong>Due Date:</strong> {{ $task['due_date_formatted'] }}</p>
            <p><strong>Reason:</strong> {{ $task['blocker_reason'] }}</p>
            @if($task['days_blocked'])
            <p><strong>Days Blocked:</strong> {{ $task['days_blocked'] }}</p>
            @endif
            @if($task['days_delayed'])
            <p><strong>Days Overdue:</strong> {{ $task['days_delayed'] }}</p>
            @endif
        </div>
        @endforeach
    </div>

    @if(isset($stats['milestones']) && is_array($stats['milestones']) && count($stats['milestones']))
    <div class="section">
        <h2>Milestone Progress</h2>
        @foreach($stats['milestones'] as $milestone)
        <div class="milestone">
            <div class="milestone-header">
                <span class="milestone-title">{{ $milestone['title'] }}</span>
                <span class="milestone-progress">{{ $milestone['progress'] }}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-bar-fill" style="width: {{ $milestone['progress'] }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="section">
        <h2>Charts Overview</h2>
        @if(!empty($taskDistributionChart))
            <div style="margin-bottom:20px;">
                <h4>Task Distribution</h4>
                <img src="{{ $taskDistributionChart }}" style="max-width:100%;height:auto;">
            </div>
        @endif
        @if(!empty($statusOverTimeChart))
            <div style="margin-bottom:20px;">
                <h4>Task Status Over Last 4 Weeks</h4>
                <img src="{{ $statusOverTimeChart }}" style="max-width:100%;height:auto;">
            </div>
        @endif
        @if(!empty($trendChart))
            <div style="margin-bottom:20px;">
                <h4>Productivity Trend</h4>
                <img src="{{ $trendChart }}" style="max-width:100%;height:auto;">
            </div>
        @endif
    </div>

    @if(isset($feedback))
    <div class="feedback">
        <h3>Team Leader Feedback</h3>
        <p>{{ $feedback }}</p>
    </div>
    @endif

    <div class="footer">
        <p>This report was generated by LombaKuy Team Productivity Analytics</p>
        <p>For more information, visit the team dashboard at {{ url('/teams/' . $team->id) }}</p>
    </div>
</body>
</html> 