<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assignment History - MSWD</title>
    
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
        
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 30px;
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
        
        .assignments-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .assignment-item {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #6b7280;
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
        
        .employee-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        
        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            text-align: center;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }
        
        .back-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #e5e7eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #374151;
            margin-right: 15px;
            vertical-align: middle;
        }
        
        .back-button:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            transform: translateX(-2px);
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .nav-buttons {
                width: 100%;
                justify-content: center;
            }
            
            .stats-summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; align-items: center;">
            <a href="{{ route('employee.dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1><i class="fas fa-history"></i> Assignment History</h1>
        </div>
        <div class="nav-buttons">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn" style="background: #dc2626;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Completed Assignments Section -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-check-circle"></i> Completed Assignments</h3>
                <span style="color: #666; font-size: 14px;">{{ $completedAssignments->count() }} items</span>
            </div>
            <div class="card-content">
                @if($completedAssignments->count() > 0)
                    <div class="assignments-list">
                        @foreach($completedAssignments as $assignment)
                            <div class="assignment-item">
                                <div class="assignment-header">
                                    <div class="assignment-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $assignment->evacuation_center }}
                                    </div>
                                    <span class="employee-status" style="background: {{ $assignment->getStatusColor() }}; color: white;">
                                        {{ $assignment->getStatusLabel() }}
                                    </span>
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
                @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard-check"></i>
                        <h3>No Completed Assignments</h3>
                        <p>You haven't completed any assignments yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
