@extends('layouts.app')

@section('title', 'Team Productivity')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-4">
            <a href="{{ route('teams.index') }}" class="btn btn-sm text-white"
            style="background-color: #4f46e5; border-radius: 8px; padding: 8px 16px; font-weight: 500; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
                ← Back to My Teams
            </a>
        </div>
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Header with Team Info and Time Period Selector -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Team Productivity Analytics</h1>
                <p class="text-gray-600">{{ $team->name }} - {{ $team->competition->title }}</p>
            </div>
            <div class="flex space-x-4">
                <select id="memberFilter" class="form-select rounded-md border-gray-300">
                    <option value="all">All Members</option>
                    <option value="{{ $team->leader_id }}">{{ $team->leader->name }} (Leader)</option>
                    @foreach($team->members as $member)
                        @if($member->id !== $team->leader_id)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endif
                    @endforeach
                </select>
                <select id="timePeriod" class="form-select rounded-md border-gray-300">
                    <option value="week">Last Week</option>
                    <option value="month">Last Month</option>
                    <option value="quarter">Last Quarter</option>
                </select>
                <button onclick="downloadReportWithCharts()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Download Report
                </button>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h3 class="text-sm font-medium text-gray-500">Completion Rate</h3>
                <p class="text-2xl font-bold text-green-600" id="completionRate">0%</p>
                <p class="text-xs text-gray-500 mt-1">Tasks completed vs total</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h3 class="text-sm font-medium text-gray-500">Average Lead Time</h3>
                <p class="text-2xl font-bold text-blue-600" id="avgLeadTime">0 days</p>
                <p class="text-xs text-gray-500 mt-1">Time to complete tasks</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h3 class="text-sm font-medium text-gray-500">Blocked Tasks</h3>
                <p class="text-2xl font-bold text-red-600" id="blockedTasks">0</p>
                <p class="text-xs text-gray-500 mt-1">Tasks requiring attention</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h3 class="text-sm font-medium text-gray-500">Tasks Per Day</h3>
                <p class="text-2xl font-bold text-indigo-600" id="tasksPerDay">0</p>
                <p class="text-xs text-gray-500 mt-1">Average daily completion</p>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Task Distribution Chart -->
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h2 class="text-lg font-semibold mb-4">Task Distribution</h2>
                <canvas id="taskDistributionChart"></canvas>
            </div>
            <!-- Task Status Over Time (Stacked Bar Chart) -->
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h2 class="text-lg font-semibold mb-4">Task Status Over Last 4 Weeks</h2>
                <canvas id="statusOverTimeChart"></canvas>
            </div>
        </div>

        <!-- Trend Analysis -->
        <div class="bg-white p-4 rounded-lg shadow mb-8 hover:shadow-md transition-shadow">
            <h2 class="text-lg font-semibold mb-4 text-green-600 flex items-center">
                <i class="fas fa-chart-line mr-2"></i> Productivity Trend (Last 4 Weeks)
            </h2>
            <canvas id="trendChart"></canvas>
        </div>

        <!-- Bottleneck Tasks -->
        <div class="bg-white p-4 rounded-lg shadow mb-8 hover:shadow-md transition-shadow">
            <h2 class="text-lg font-semibold mb-4 text-red-600 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i> Bottleneck Tasks
            </h2>
            <div id="bottleneckTasks" class="space-y-2">
                <!-- Bottleneck tasks will be populated here -->
            </div>
        </div>

        <!-- Actionable Insights & Risk Indicators -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h2 class="text-lg font-semibold mb-4 text-red-600 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Team Health & Warnings
                </h2>
                <ul class="list-disc ml-6 text-sm text-gray-700" id="insightsList">
                    <!-- Insights will be populated here -->
                </ul>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                <h2 class="text-lg font-semibold mb-4 text-blue-600 flex items-center">
                    <i class="fas fa-trophy mr-2"></i> Top Contributors
                </h2>
                <ol class="list-decimal ml-6 text-sm text-gray-700" id="leaderboardList">
                    <!-- Leaderboard will be populated here -->
                </ol>
                <div id="noContributorsMsg" class="text-gray-500 text-center hidden">No completed tasks yet.</div>
            </div>
        </div>
    </div>
</div>

<div class="loading-spinner" id="loadingSpinner">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
</div>

<!-- Personalized Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Send Personalized Feedback</h2>
        <form id="personalFeedbackForm">
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach([$team->leader, ...$team->members->where('id', '!=', $team->leader_id)->all()] as $member)
                <div>
                    <label class="block font-semibold mb-1">{{ $member->name }} <span class="text-xs text-gray-400">({{ $member->id == $team->leader_id ? 'Leader' : 'Member' }})</span></label>
                    <textarea name="feedback_member[{{ $member->id }}]" class="w-full border border-gray-300 rounded p-2" rows="2" placeholder="Feedback for {{ $member->name }}..."></textarea>
                </div>
                @endforeach
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeFeedbackModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                <button type="button" onclick="submitPersonalFeedback()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Send</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<style>
  .section-divider { border-bottom: 2px solid #e5e7eb; margin: 2rem 0; }
  .loading-spinner { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(255,255,255,0.7); z-index: 9999; align-items: center; justify-content: center; }
  .loading-spinner.active { display: flex; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
let taskDistributionChart, progressChart, trendChart, statusOverTimeChart;
let lastStats = null;

function showLoading(show) {
    const spinner = document.getElementById('loadingSpinner');
    if (show) spinner.classList.add('active');
    else spinner.classList.remove('active');
}

function showToast(type, msg) {
    toastr.options = { positionClass: 'toast-bottom-right', timeOut: 3000 };
    toastr[type](msg);
}

function showTaskModal(tasks, title) {
    let modal = document.getElementById('taskModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'taskModal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `<div class='bg-white rounded-lg p-6 max-w-lg w-full'><h2 class='text-xl font-bold mb-4' id='modalTitle'></h2><div id='modalContent'></div><button onclick='closeTaskModal()' class='mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700'>Close</button></div>`;
        document.body.appendChild(modal);
    }
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalContent').innerHTML = tasks.length ? tasks.map(t => `<div class='mb-2'><span class='font-semibold'>${t.title}</span> <span class='text-xs text-gray-500'>(Assignee: ${t.assignee.name})</span></div>`).join('') : '<p class="text-gray-500">No tasks found.</p>';
    modal.style.display = 'flex';
}

function closeTaskModal() { document.getElementById('taskModal').style.display = 'none'; }

function initCharts(data) {
    lastStats = data;
    // Task Distribution Chart
    if (taskDistributionChart) taskDistributionChart.destroy();
    const taskCtx = document.getElementById('taskDistributionChart').getContext('2d');
    taskDistributionChart = new Chart(taskCtx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'In Progress', 'Blocked', 'Pending','In Review'],
            datasets: [{
                data: data.taskDistribution,
                backgroundColor: ['#10B981', '#3B82F6', '#EF4444', '#F59E0B', '#C553EC']
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            },
            onClick: (e, elements) => {
                if (elements.length) {
                    const idx = elements[0].index;
                    let tasks = [];
                    switch(idx) {
                        case 0: tasks = data.tasks.completed; break;
                        case 1: tasks = data.tasks.in_progress; break;
                        case 2: tasks = data.tasks.blocked; break;
                        case 3: tasks = data.tasks.pending; break;
                        case 4: tasks = data.tasks.in_review; break;
                    }
                    showTaskModal(tasks, `Tasks: ${taskDistributionChart.data.labels[idx]}`);
                }
            }
        }
    });

    // Task Status Over Time (Stacked Bar Chart)
    if (statusOverTimeChart) statusOverTimeChart.destroy();
    const statusCtx = document.getElementById('statusOverTimeChart').getContext('2d');
    const weeks = data.statusOverTime.map(w => w.week);
    statusOverTimeChart = new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: weeks,
            datasets: [
                {
                    label: 'Completed',
                    data: data.statusOverTime.map(w => w.completed),
                    backgroundColor: '#10B981',
                    stack: 'Status',
                },
                {
                    label: 'In Progress',
                    data: data.statusOverTime.map(w => w.in_progress),
                    backgroundColor: '#3B82F6',
                    stack: 'Status',
                },
                {
                    label: 'Blocked',
                    data: data.statusOverTime.map(w => w.blocked),
                    backgroundColor: '#EF4444',
                    stack: 'Status',
                },
                {
                    label: 'Pending',
                    data: data.statusOverTime.map(w => w.pending),
                    backgroundColor: '#F59E0B',
                    stack: 'Status',
                },
                {
                    label: 'In Review',
                    data: data.statusOverTime.map(w => w.in_review),
                    backgroundColor: '#C553EC',
                    stack: 'Status',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            },
            scales: {
                x: { stacked: true, title: { display: true, text: 'Week' } },
                y: { stacked: true, beginAtZero: true, title: { display: true, text: 'Number of Tasks' } }
            }
        }
    });

    // Trend Chart
    if (trendChart) trendChart.destroy();
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    trendChart = new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: data.trend.map(t => t.week),
            datasets: [{
                label: 'Tasks Completed',
                data: data.trend.map(t => t.completed),
                backgroundColor: '#10B981',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Tasks Completed' },
                    ticks: { stepSize: 1 }
                },
                x: { title: { display: true, text: 'Week' } }
            }
        }
    });

    // Leaderboard
    const leaderboardList = document.getElementById('leaderboardList');
    const noContribMsg = document.getElementById('noContributorsMsg');
    if (data.leaderboard.length === 0) {
        leaderboardList.innerHTML = '';
        noContribMsg.classList.remove('hidden');
    } else {
        noContribMsg.classList.add('hidden');
        leaderboardList.innerHTML = data.leaderboard.map((user, idx) =>
            `<li class="mb-2"><span class="font-bold${idx === 0 ? ' text-blue-700' : ''}">${user.name}</span> <span class="text-xs text-gray-400 ml-1">[${user.role}]</span> <span class="text-gray-500">(${user.completed} tasks)</span></li>`
        ).join('');
    }

    // Insights & Risk
    const insightsList = document.getElementById('insightsList');
    insightsList.innerHTML = data.insights.length ? data.insights.map(msg =>
        `<li class="mb-2">${msg}</li>`
    ).join('') : '<li class="text-gray-500">No insights available.</li>';

    // Update metrics
    document.getElementById('completionRate').textContent = `${data.completionRate}%`;
    document.getElementById('avgLeadTime').textContent = `${data.avgLeadTime} days`;
    document.getElementById('blockedTasks').textContent = data.blockedTasksCount;
    document.getElementById('tasksPerDay').textContent = data.tasksPerDay;

    // Update bottleneck tasks
    const bottleneckContainer = document.getElementById('bottleneckTasks');
    if (data.bottleneckTasks.length === 0) {
        bottleneckContainer.innerHTML = '<p class="text-gray-500">No bottleneck tasks found.</p>';
    } else {
        bottleneckContainer.innerHTML = data.bottleneckTasks.map(task => `
            <div class="p-3 bg-red-50 rounded-md mb-2">
                <p class="font-medium">${task.title} <span class="text-xs text-gray-500">(${task.status})</span></p>
                <p class="text-sm text-gray-600">${task.blocker_reason}</p>
                <p class="text-xs text-gray-500 mt-1">Assigned to: ${task.assignee.name}</p>
                <p class="text-xs text-gray-500 mt-1">Due: ${task.due_date_formatted}</p>
                ${task.days_blocked ? `<p class='text-xs text-gray-500'>Days Blocked: ${task.days_blocked}</p>` : ''}
                ${task.days_delayed ? `<p class='text-xs text-gray-500'>Days Overdue: ${task.days_delayed}</p>` : ''}
                ${task.days_stagnant ? `<p class='text-xs text-gray-500'>Days Stagnant: ${task.days_stagnant}</p>` : ''}
            </div>
        `).join('');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const initialData = @json($initialStats);
    initCharts(initialData);
    document.getElementById('timePeriod').addEventListener('change', fetchAndUpdate);
    document.getElementById('memberFilter').addEventListener('change', fetchAndUpdate);
    document.getElementById('roleFilter').addEventListener('change', fetchAndUpdate);
});

function fetchAndUpdate() {
    showLoading(true);
    const period = document.getElementById('timePeriod').value;
    const member = document.getElementById('memberFilter').value;
    const role = document.getElementById('roleFilter').value;
    fetch(`/productivity/team/${@json($team->id)}/data?period=${period}&member=${member}&role=${role}`)
        .then(response => response.json())
        .then(data => { initCharts(data); showLoading(false); })
        .catch(error => { showToast('error', 'Failed to load data'); showLoading(false); });
}

function downloadReportWithCharts() {
    showLoading(true);
    // Get chart images as base64
    const taskDistImg = taskDistributionChart.toBase64Image();
    const statusImg = statusOverTimeChart.toBase64Image();
    const trendImg = trendChart.toBase64Image();
    const period = document.getElementById('timePeriod').value;
    const member = document.getElementById('memberFilter').value;
    // Create a form and submit via POST to new endpoint
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/productivity/team/${@json($team->id)}/report-with-charts`;
    form.target = '_blank';
    // CSRF
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
    form.appendChild(csrf);
    // Images
    const img1 = document.createElement('input');
    img1.type = 'hidden'; img1.name = 'taskDistributionChart'; img1.value = taskDistImg; form.appendChild(img1);
    const img2 = document.createElement('input');
    img2.type = 'hidden'; img2.name = 'statusOverTimeChart'; img2.value = statusImg; form.appendChild(img2);
    const img3 = document.createElement('input');
    img3.type = 'hidden'; img3.name = 'trendChart'; img3.value = trendImg; form.appendChild(img3);
    // Period/member
    const p = document.createElement('input');
    p.type = 'hidden'; p.name = 'period'; p.value = period; form.appendChild(p);
    const m = document.createElement('input');
    m.type = 'hidden'; m.name = 'member'; m.value = member; form.appendChild(m);
    document.body.appendChild(form);
    alert('Submitting PDF export form!');
    form.submit();
    setTimeout(() => { showLoading(false); form.remove(); }, 2000);
}

function openFeedbackModal() {
    document.getElementById('feedbackModal').classList.remove('hidden');
}

function closeFeedbackModal() {
    document.getElementById('feedbackModal').classList.add('hidden');
}

function submitPersonalFeedback() {
    const form = document.getElementById('personalFeedbackForm');
    const formData = new FormData(form);
    const feedbacks = {};
    for (const [key, value] of formData.entries()) {
        if (key.startsWith('feedback_member[') && value.trim() !== '') {
            const userId = key.match(/feedback_member\[(\d+)\]/)[1];
            feedbacks[userId] = value.trim();
        }
    }
    if (Object.keys(feedbacks).length === 0) {
        showToast('error', 'Please enter at least one feedback.');
        return;
    }
    closeFeedbackModal();
    showLoading(true);
    fetch(`/productivity/team/${@json($team->id)}/share`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            feedback_member: feedbacks,
            period: document.getElementById('timePeriod').value
        })
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            showToast('success', 'Feedback sent successfully!');
        } else {
            showToast('error', 'Failed to send feedback');
        }
    })
    .catch(error => { showToast('error', 'Error sending feedback'); showLoading(false); });
}
</script>
@endpush
@endsection 