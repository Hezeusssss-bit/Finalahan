<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs - BARANGAY DISASTER EVACUATION ALERT MANAGEMENT SYSTEM</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: #f5f5f5; min-height: 100vh; margin: 0; display: flex; }
        
        /* Sidebar */
        .sidebar { 
            width: 280px; 
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); 
            min-height: 100vh; 
            max-height: 100vh;
            overflow-y: auto;
            padding: 0; 
            position: fixed; 
            left: 0; 
            top: 0; 
            display: flex; 
            flex-direction: column;
            box-shadow: 6px 0 30px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo { 
            color: #fff; 
            font-size: 28px; 
            font-weight: 800; 
            padding: 30px; 
            margin-bottom: 10px; 
            display: flex; 
            align-items: center; 
            gap: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-menu { display: flex; flex-direction: column; padding: 0 20px; }
        .nav-section { margin-bottom: 30px; }
        .nav-section-title { color: rgba(255, 255, 255, 0.4); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding: 0 20px; }
        
        .nav-item { 
            color: rgba(255, 255, 255, 0.8); 
            padding: 14px 20px; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            cursor: pointer; 
            font-size: 15px;
            font-weight: 500;
            position: relative;
            margin: 3px 0;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.6s;
        }
        
        .nav-item:hover::before { left: 100%; }
        .nav-item:hover { background: rgba(59, 130, 246, 0.15); color: #fff; transform: translateX(8px); }
        .nav-item i { width: 24px; text-align: center; font-size: 18px; color: rgba(255, 255, 255, 0.6); }
        .nav-item:hover i { color: #60a5fa; }
        
        /* Main Content */
        .main-content { 
            flex: 1; 
            margin-left: 0; 
            padding: 30px; 
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .page-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            padding-bottom: 20px; 
            border-bottom: 2px solid #e2e8f0;
        }
        
        .page-title { 
            font-size: 28px; 
            font-weight: 700; 
            color: #1a202c; 
            display: flex; 
            align-items: center; 
            gap: 12px;
        }
        
        .page-actions { display: flex; gap: 12px; }
        
        .btn { 
            padding: 10px 20px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 500; 
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary { background: #3b82f6; color: white; }
        .btn-primary:hover { background: #2563eb; transform: translateY(-2px); }
        
        .dashboard-section { 
            background: white; 
            border-radius: 16px; 
            padding: 24px; 
            margin-bottom: 24px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        
        .section-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
        }
        
        .section-title { 
            font-size: 18px; 
            font-weight: 600; 
            color: #1a202c; 
            display: flex; 
            align-items: center; 
            gap: 8px;
        }
        
        .section-count { 
            background: #f1f5f9; 
            color: #475569; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600;
        }
        
        .empty-state { 
            text-align: center; 
            padding: 60px 20px; 
            color: #64748b;
        }
        
        .empty-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
        .empty-text { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
        .empty-subtext { font-size: 14px; opacity: 0.7; }
        
        .activity-list { display: flex; flex-direction: column; gap: 12px; }
        
        .activity-item { 
            display: flex; 
            align-items: flex-start; 
            gap: 12px; 
            padding: 16px; 
            background: #f8fafc; 
            border-radius: 12px; 
            border-left: 4px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .activity-item:hover { 
            background: #f1f5f9; 
            border-left-color: #3b82f6;
            transform: translateX(4px);
        }
        
        .activity-icon { 
            width: 40px; 
            height: 40px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: white; 
            border-radius: 50%; 
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .activity-content { flex: 1; }
        .activity-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 4px; 
        }
        
        .activity-action { font-weight: 600; color: #1a202c; }
        .activity-time { font-size: 12px; color: #64748b; }
        .activity-description { color: #475569; margin-bottom: 8px; }
        .activity-meta { 
            display: flex; 
            gap: 12px; 
            font-size: 12px; 
            color: #64748b; 
        }
        
        .activity-module { 
            background: #e2e8f0; 
            padding: 2px 8px; 
            border-radius: 4px; 
            font-weight: 500;
        }
        
        .activity-performed-by { font-style: italic; }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            color: black;
            font-size: 1.2rem;
            text-decoration: none;
            margin-right: 15px;
            vertical-align: middle;
        }

        .back-button i {
            margin: 0;
        }
    </style>
</head>
<body>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <div class="page-title">
                <a href="{{ route('resident.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <i class="fas fa-history"></i>
                Activity Logs
            </div>
            <div class="page-actions">
                <button onclick="refreshLogs()" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-clock"></i>
                    Recent Activity
                </div>
                <div class="section-count">{{ $recentLogs->count() }} Logs</div>
            </div>
            
            @if($recentLogs->count() > 0)
                <div class="activity-list">
                    @foreach($recentLogs as $log)
                        <div class="activity-item">
                            <div class="activity-icon">
                                @switch($log->module)
                                    @case('Programs')
                                        <i class="fas fa-calendar-alt" style="color: #2563eb;"></i>
                                        @break
                                    @case('Employee')
                                        <i class="fas fa-users" style="color: #16a34a;"></i>
                                        @break
                                    @case('System')
                                        <i class="fas fa-cog" style="color: #6b7280;"></i>
                                        @break
                                    @default
                                        <i class="fas fa-info-circle" style="color: #d97706;"></i>
                                @endswitch
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <span class="activity-action">{{ $log->action }}</span>
                                    <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="activity-description">{{ $log->description }}</div>
                                <div class="activity-meta">
                                    <span class="activity-module">{{ $log->module }}</span>
                                    <span class="activity-performed-by">by {{ $log->performed_by }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="empty-text">No recent activity</div>
                    <div class="empty-subtext">Activity will appear here as actions are performed</div>
                </div>
            @endif
        </div>

        <!-- Program Activity Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-calendar-alt"></i>
                    Program Activity
                </div>
                <div class="section-count">{{ $programLogs->count() }} Logs</div>
            </div>
            
            @if($programLogs->count() > 0)
                <div class="activity-list">
                    @foreach($programLogs as $log)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-calendar-alt" style="color: #2563eb;"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <span class="activity-action">{{ $log->action }}</span>
                                    <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="activity-description">{{ $log->description }}</div>
                                <div class="activity-meta">
                                    <span class="activity-module">{{ $log->module }}</span>
                                    <span class="activity-performed-by">by {{ $log->performed_by }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="empty-text">No program activity</div>
                    <div class="empty-subtext">Program-related activity will appear here</div>
                </div>
            @endif
        </div>

        <!-- Employee Activity Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    Employee Activity
                </div>
                <div class="section-count">{{ $employeeLogs->count() }} Logs</div>
            </div>
            
            @if($employeeLogs->count() > 0)
                <div class="activity-list">
                    @foreach($employeeLogs as $log)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-users" style="color: #16a34a;"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <span class="activity-action">{{ $log->action }}</span>
                                    <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="activity-description">{{ $log->description }}</div>
                                <div class="activity-meta">
                                    <span class="activity-module">{{ $log->module }}</span>
                                    <span class="activity-performed-by">by {{ $log->performed_by }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="empty-text">No employee activity</div>
                    <div class="empty-subtext">Employee-related activity will appear here</div>
                </div>
            @endif
        </div>

        <!-- System Activity Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-cog"></i>
                    System Activity
                </div>
                <div class="section-count">{{ $systemLogs->count() }} Logs</div>
            </div>
            
            @if($systemLogs->count() > 0)
                <div class="activity-list">
                    @foreach($systemLogs as $log)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-cog" style="color: #6b7280;"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <span class="activity-action">{{ $log->action }}</span>
                                    <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="activity-description">{{ $log->description }}</div>
                                <div class="activity-meta">
                                    <span class="activity-module">{{ $log->module }}</span>
                                    <span class="activity-performed-by">by {{ $log->performed_by }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="empty-text">No system activity</div>
                    <div class="empty-subtext">System-related activity will appear here</div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function refreshLogs() {
            location.reload();
        }

        function confirmLogout(button) {
            if (confirm('Are you sure you want to logout?')) {
                button.closest('form').submit();
            }
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            console.log('Refreshing activity logs...');
        }, 30000);
    </script>
</body>
</html>
