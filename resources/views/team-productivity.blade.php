<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Productivity - LombaKuy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #5C4EE3;
            --primary-light: #EBE9FC;
            --success: #28a745;
            --info: #4b9ce9;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --gray-light: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
        }
        
        .navbar {
            background-color: var(--primary);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .navbar-brand {
            font-size: 22px;
            font-weight: bold;
        }
        
        .navbar-links {
            display: flex;
            gap: 20px;
        }
        
        .navbar-links a {
            color: white;
            text-decoration: none;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .page-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary);
            font-size: 22px;
        }
        
        .page-description {
            color: var(--gray);
            font-size: 14px;
            margin-top: 5px;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stats-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .stats-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }
        
        .stats-content h3 {
            font-size: 22px;
            margin-bottom: 5px;
        }
        
        .stats-content p {
            color: var(--gray);
            font-size: 14px;
            margin: 0;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-outline-primary {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-light);
        }
        
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-item {
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            color: #333;
        }
        
        .dropdown-item:hover {
            background-color: var(--primary-light);
        }
        
        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .col-6 {
            width: 50%;
        }
        
        .progress-container {
            margin-top: 15px;
        }
        
        .progress-item {
            margin-bottom: 15px;
        }
        
        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .progress-bar-container {
            height: 6px;
            background-color: var(--gray-light);
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
        }
        
        .progress-completed {
            background-color: var(--success);
        }
        
        .progress-inprogress {
            background-color: var(--info);
        }
        
        .progress-pending {
            background-color: var(--warning);
        }
        
        .progress-blocked {
            background-color: var(--danger);
        }
        
        .blocked-tasks {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .blocked-task-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-light);
        }
        
        .blocked-task-item:last-child {
            border-bottom: none;
        }
        
        .blocked-task-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .blocked-task-title {
            font-weight: 600;
        }
        
        .blocked-days {
            background-color: var(--danger);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        
        .blocked-reason {
            color: var(--gray);
            font-size: 14px;
        }
        
        .empty-state {
            padding: 30px;
            text-align: center;
            color: var(--gray);
        }
        
        .empty-state i {
            font-size: 40px;
            color: var(--success);
            margin-bottom: 15px;
        }
        
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 500px;
            max-width: 90%;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-title {
            font-size: 18px;
            font-weight: 600;
        }
        
        .close-modal {
            font-size: 24px;
            cursor: pointer;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--gray-light);
            border-radius: 4px;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .filter-options {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .filter-option {
            background-color: white;
            border: 1px solid var(--gray-light);
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 14px;
            cursor: pointer;
        }
        
        .filter-option.active {
            background-color: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-brand">LombaKuy</div>
        <div class="navbar-links">
            <a href="/dashboard">Dashboard</a>
            <a href="/task-management">Task Management</a>
            <a href="/logout">Logout</a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <div class="page-title">
                    <i class="fas fa-chart-line"></i>
                    <span>Team Productivity Graph</span>
                </div>
                <div class="page-description">
                    Visualize your team's progress and identify bottlenecks
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <!-- Time Period Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary">
                        <span>Last 7 days</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="#" class="dropdown-item">Last 7 days</a>
                        <a href="#" class="dropdown-item">Last 14 days</a>
                        <a href="#" class="dropdown-item">Last 30 days</a>
                        <a href="#" class="dropdown-item">Last 90 days</a>
                    </div>
                </div>
                
                <!-- Export Report Button -->
                <button class="btn btn-outline-primary" id="exportBtn">
                    <i class="fas fa-download"></i>
                    <span>Export Report</span>
                </button>
                
                <!-- Share Feedback Button -->
                <button class="btn btn-primary" id="shareBtn">
                    <i class="fas fa-share"></i>
                    <span>Share Feedback</span>
                </button>
            </div>
        </div>
        
        <!-- Success Alert (initially hidden) -->
        <div class="alert alert-success" id="successAlert" style="display: none;">
            <i class="fas fa-check-circle"></i>
            <span>Report has been shared successfully!</span>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-cards">
            <!-- Completion Rate -->
            <div class="stats-card">
                <div class="stats-icon" style="background-color: var(--success);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-content">
                    <h3>75%</h3>
                    <p>Completion Rate</p>
                    <small style="color: var(--success);"><i class="fas fa-arrow-up"></i> 5%</small>
                </div>
            </div>
            
            <!-- Tasks Per Day -->
            <div class="stats-card">
                <div class="stats-icon" style="background-color: var(--info);">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stats-content">
                    <h3>4.2</h3>
                    <p>Tasks Per Day</p>
                </div>
            </div>
            
            <!-- Average Lead Time -->
            <div class="stats-card">
                <div class="stats-icon" style="background-color: var(--primary);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3>2.5 days</h3>
                    <p>Avg. Lead Time</p>
                </div>
            </div>
            
            <!-- Blocked Tasks -->
            <div class="stats-card">
                <div class="stats-icon" style="background-color: var(--danger);">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-content">
                    <h3>3 <small style="color: var(--gray); font-size: 14px;">(15%)</small></h3>
                    <p>Blocked Tasks</p>
                </div>
            </div>
        </div>
        
        <!-- Productivity Graph Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Team Progress Visualization</h3>
                <div class="filter-options">
                    <div class="filter-option active">Week</div>
                    <div class="filter-option">Month</div>
                    <div class="filter-option">Quarter</div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="productivityChart" height="250"></canvas>
            </div>
        </div>
        
        <!-- Two Column Layout -->
        <div class="row">
            <!-- Task Distribution -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Task Distribution</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="taskDistributionChart" height="200"></canvas>
                        <div class="progress-container">
                            <!-- Completed Tasks -->
                            <div class="progress-item">
                                <div class="progress-header">
                                    <span>Completed</span>
                                    <span>15 (75%)</span>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar progress-completed" style="width: 75%;"></div>
                                </div>
                            </div>
                            
                            <!-- In Progress Tasks -->
                            <div class="progress-item">
                                <div class="progress-header">
                                    <span>In Progress</span>
                                    <span>2 (10%)</span>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar progress-inprogress" style="width: 10%;"></div>
                                </div>
                            </div>
                            
                            <!-- Blocked Tasks -->
                            <div class="progress-item">
                                <div class="progress-header">
                                    <span>Blocked</span>
                                    <span>3 (15%)</span>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar progress-blocked" style="width: 15%;"></div>
                                </div>
                            </div>
                            
                            <!-- Pending Tasks -->
                            <div class="progress-item">
                                <div class="progress-header">
                                    <span>Pending</span>
                                    <span>0 (0%)</span>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar progress-pending" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottleneck Analysis -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bottleneck Analysis</h3>
                    </div>
                    <div class="card-body">
                        <div class="blocked-tasks">
                            <!-- Blocked Task 1 -->
                            <div class="blocked-task-item">
                                <div class="blocked-task-header">
                                    <div class="blocked-task-title">API Integration with Payment Gateway</div>
                                    <div class="blocked-days">3 days</div>
                                </div>
                                <div>Assigned to: Amalia Wijaya</div>
                                <div class="blocked-reason">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Waiting for API credentials from third-party provider
                                </div>
                            </div>
                            
                            <!-- Blocked Task 2 -->
                            <div class="blocked-task-item">
                                <div class="blocked-task-header">
                                    <div class="blocked-task-title">Database Migration Script</div>
                                    <div class="blocked-days">2 days</div>
                                </div>
                                <div>Assigned to: Budi Santoso</div>
                                <div class="blocked-reason">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Technical issue with schema compatibility
                                </div>
                            </div>
                            
                            <!-- Blocked Task 3 -->
                            <div class="blocked-task-item">
                                <div class="blocked-task-header">
                                    <div class="blocked-task-title">UI Design for Mobile View</div>
                                    <div class="blocked-days">1 day</div>
                                </div>
                                <div>Assigned to: Cahya Nugraha</div>
                                <div class="blocked-reason">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Waiting for design approval from project manager
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Share Feedback Modal -->
    <div class="modal" id="shareModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Share Team Progress Report</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter recipient email">
            </div>
            <div class="form-group">
                <label for="message">Message (Optional)</label>
                <textarea class="form-control" id="message" placeholder="Add a personalized message"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" id="cancelShare">Cancel</button>
                <button class="btn btn-primary" id="confirmShare">Share Report</button>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Productivity Chart
       // Produktivitas Chart - Menambahkan devicePixelRatio saja
// Team Progress Visualization Chart
const productivityCtx = document.getElementById('productivityChart').getContext('2d');
const productivityChart = new Chart(productivityCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
            {
                label: 'Completed Tasks',
                data: [5, 3, 6, 4, 7, 2, 3],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#28a745'
            },
            {
                label: 'Created Tasks',
                data: [3, 4, 7, 5, 6, 3, 2],
                borderColor: '#5C4EE3',
                backgroundColor: 'rgba(92, 78, 227, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#5C4EE3'
            },
            {
                label: 'Blocked Tasks',
                data: [1, 2, 1, 0, 1, 0, 1],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#dc3545'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        devicePixelRatio: 2,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#333',
                bodyColor: '#666',
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 10,
                displayColors: true,
                callbacks: {
                    title: function(tooltipItems) {
                        return tooltipItems[0].label;
                    },
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += context.parsed.y;
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Tasks',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                ticks: {
                    stepSize: 1
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            }
        },
        interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
        },
        animations: {
            tension: {
                duration: 1000,
                easing: 'linear'
            }
        }
    }
});

// Task Distribution Chart
const distributionCtx = document.getElementById('taskDistributionChart').getContext('2d');
const taskDistributionChart = new Chart(distributionCtx, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'In Progress', 'Blocked', 'Pending'],
        datasets: [{
            data: [15, 2, 3, 0],
            backgroundColor: [
                '#28a745',
                '#4b9ce9',
                '#dc3545',
                '#ffc107'
            ],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        devicePixelRatio: 2, // Kunci untuk memperbaiki blur
        plugins: {
            legend: {
                position: 'right',
            }
        },
        cutout: '60%'
    }
});

// Sisakan kode asli dari updateCharts anda
function updateCharts(period = 'week') {
    fetch(`/productivity/data?period=${period}`)
        .then(response => response.json())
        .then(data => {
            // Update Line Chart
            productivityChart.data.labels = data.dates;
            productivityChart.data.datasets[0].data = data.completed;
            productivityChart.data.datasets[1].data = data.created;
            productivityChart.data.datasets[2].data = data.blocked;
            productivityChart.update();

            // Update Doughnut Chart
            taskDistributionChart.data.datasets[0].data = [
                data.taskDistribution[0],
                data.taskDistribution[1],
                data.taskDistribution[2],
                data.taskDistribution[3]
            ];
            taskDistributionChart.update();

            // Update Stats
            document.getElementById('completion-rate').textContent = `${data.completionRate}%`;
            document.getElementById('tasks-per-day').textContent = data.tasksPerDay;
            document.getElementById('avg-lead-time').textContent = `${data.avgLeadTime} days`;
            document.getElementById('blocked-tasks').textContent = data.blockedTasksCount;

            // Update Bottleneck Analysis
            updateBottleneckTasks(data.bottleneckTasks);
        });
}

function updateBottleneckTasks(tasks) {
    const container = document.querySelector('.blocked-tasks');
    container.innerHTML = tasks.length ? '' : '<div class="empty-state">No bottleneck tasks found</div>';

    tasks.forEach(task => {
        container.innerHTML += `
            <div class="blocked-task-item">
                <div class="blocked-task-header">
                    <div class="blocked-task-title">${task.title}</div>
                    <div class="blocked-days">${task.days_blocked || task.days_delayed} days</div>
                </div>
                <div>Assigned to: ${task.assignee.name}</div>
                <div class="blocked-reason">
                    <i class="fas fa-exclamation-triangle"></i>
                    ${task.blocker_reason}
                </div>
                <div>Due: ${task.due_date_formatted}</div>
            </div>
        `;
    });
}

// Auto-refresh data every minute
setInterval(() => updateCharts(document.querySelector('.filter-option.active').textContent.toLowerCase()), 60000);

// Handle filter clicks
document.querySelectorAll('.filter-option').forEach(option => {
    option.addEventListener('click', () => {
        document.querySelectorAll('.filter-option').forEach(opt => opt.classList.remove('active'));
        option.classList.add('active');
        updateCharts(option.textContent.toLowerCase());
    });
});

// Initial load
updateCharts('week');
    </script>
</body>
</html>