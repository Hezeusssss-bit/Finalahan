<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Dashboard - MSWD</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        body {
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }
        
        .nav-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            background: #1a1a2e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn:hover {
            background: #2a2a3e;
            transform: translateY(-1px);
        }
        
        .btn-primary {
            background: #2563eb;
        }
        
        .btn-primary:hover {
            background: #1d4ed8;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-content {
            padding: 25px;
        }
        
        .employee-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .employee-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .employee-item:hover {
            background: #f3f4f6;
        }
        
        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #666;
        }
        
        .employee-info {
            flex: 1;
        }
        
        .employee-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        
        .employee-position {
            font-size: 14px;
            color: #666;
        }
        
        .employee-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .assignments-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .assignment-item {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #3b82f6;
            transition: all 0.3s ease;
        }
        
        .assignment-item:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .assignment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .assignment-center {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .assignment-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .assignment-responsibilities,
        .assignment-notes,
        .assignment-date {
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .assignment-responsibilities strong,
        .assignment-notes strong {
            color: #374151;
            display: block;
            margin-bottom: 4px;
        }
        
        .assignment-date {
            color: #6b7280;
            font-size: 13px;
        }
        
        .department-chart {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .department-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .department-name {
            font-weight: 500;
            color: #333;
            min-width: 120px;
        }
        
        .department-bar {
            flex: 1;
            height: 30px;
            background: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }
        
        .department-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 10px;
            color: white;
            font-size: 12px;
            font-weight: 500;
            transition: width 0.5s ease;
        }
        
        .department-count {
            font-weight: 600;
            color: #333;
            min-width: 30px;
            text-align: right;
        }
        
        .success-message {
            background: #10b981;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-success {
            background: #10b981;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .assignment-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .stat-card-link {
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .stat-card-link:hover {
            transform: translateY(-5px);
        }
        
        .stat-card-link:hover .stat-card {
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .nav-buttons {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-chart-line"></i> Employee Dashboard</h1>
        <div class="nav-buttons">
            <a href="{{ route('employee.history') }}" class="btn btn-primary">
                <i class="fas fa-history"></i> History
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn" style="background: #dc2626;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Assignment Statistics -->
        <div class="stats-grid">
            <a href="{{ route('employee.history') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon" style="background: #10b981; color: white;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $completedAssignments ?? 0 }}</div>
                <div class="stat-label">Completed Assignments</div>
            </div>
            </a>
            
            <a href="#your-assignments" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon" style="background: #3b82f6; color: white;">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-value">{{ $activeAssignments ?? 0 }}</div>
                <div class="stat-label">Active Assignments</div>
            </div>
            </a>
        </div>
        
        <!-- Employee Assignments Section -->
        @if($employeeAssignments->count() > 0)
            <div class="card" id="your-assignments">
                <div class="card-header">
                    <h3><i class="fas fa-user-check"></i> Your Assignments</h3>
                </div>
                <div class="card-content">
                    <div class="assignments-list">
                        @foreach($employeeAssignments as $assignment)
                            <div class="assignment-item">
                                <div class="assignment-header">
                                    <div class="assignment-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $assignment->evacuation_center }}
                                    </div>
                                    <div class="assignment-actions">
                                        <span class="employee-status" style="background: {{ $assignment->getStatusColor() }}; color: white;">
                                            {{ $assignment->getStatusLabel() }}
                                        </span>
                                        @if($assignment->status === 'active')
                                            <button class="btn btn-success" onclick="markAsDone({{ $assignment->id }})" style="padding: 6px 12px; font-size: 12px;">
                                                <i class="fas fa-check"></i> Done
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="assignment-details">
                                    @if($assignment->responsibilities)
                                        <div class="assignment-responsibilities">
                                            <strong>Responsibilities:</strong> {{ $assignment->responsibilities }}
                                        </div>
                                    @endif
                                    @if($assignment->notes)
                                        <div class="assignment-notes">
                                            <strong>Notes:</strong> {{ $assignment->notes }}
                                        </div>
                                    @endif
                                    <div class="assignment-date">
                                        <strong>Assigned:</strong> {{ $assignment->created_at->format('M d, Y \a\t h:i A') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-user-check"></i> Your Assignments</h3>
                </div>
                <div class="card-content">
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-clipboard-list" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                        <h4 style="margin-bottom: 8px; color: #333;">No Assignments Yet</h4>
                        <p>You haven't been assigned to any evacuation centers yet.</p>
                        <p style="font-size: 14px; color: #666;">Check back later for new assignments from the administrator.</p>
                    </div>
                </div>
            </div>
        @endif
        
    </div>

    <script>
        function markAsDone(assignmentId) {
            if (confirm('Are you sure you want to mark this assignment as completed?')) {
                fetch(`/employee-assignments/${assignmentId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const successDiv = document.createElement('div');
                        successDiv.className = 'success-message';
                        successDiv.innerHTML = `<i class="fas fa-check-circle"></i> Assignment marked as completed!`;
                        
                        const container = document.querySelector('.container');
                        container.insertBefore(successDiv, container.firstChild);
                        
                        // Remove the assignment card
                        const assignmentCard = document.querySelector(`[onclick="markAsDone(${assignmentId})"]`).closest('.assignment-item');
                        assignmentCard.style.transition = 'opacity 0.3s, transform 0.3s';
                        assignmentCard.style.opacity = '0';
                        assignmentCard.style.transform = 'translateX(20px)';
                        
                        setTimeout(() => {
                            assignmentCard.remove();
                            // Remove success message after 3 seconds
                            setTimeout(() => {
                                successDiv.remove();
                            }, 3000);
                        }, 300);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while marking the assignment as complete.');
                });
            }
        }
    </script>
</body>
</html>
