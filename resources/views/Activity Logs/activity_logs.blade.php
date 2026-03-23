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
        
        .logo i { 
            color: #3b82f6; 
            font-size: 32px;
            filter: drop-shadow(0 4px 8px rgba(59, 130, 246, 0.4));
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from { filter: drop-shadow(0 4px 8px rgba(59, 130, 246, 0.4)); }
            to { filter: drop-shadow(0 4px 12px rgba(59, 130, 246, 0.6)); }
        }
        
        .nav-section {
            margin-bottom: 25px;
            padding: 0 20px;
        }
        
        .nav-section-title {
            color: rgba(255, 255, 255, 0.4);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 0 15px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-section-title::before {
            content: '';
            width: 3px;
            height: 3px;
            background: #3b82f6;
            border-radius: 50%;
            display: inline-block;
        }
        
        .nav-menu { 
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
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
        
        .nav-item:hover::before {
            left: 100%;
        }
        
        .nav-item i { 
            width: 24px; 
            text-align: center; 
            font-size: 18px;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.4s ease;
        }
        
        .nav-item:hover { 
            background: rgba(59, 130, 246, 0.15); 
            color: #fff;
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
        }
        
        .nav-item:hover i {
            color: #60a5fa;
            transform: scale(1.15) rotate(5deg);
        }
        
        .nav-item.active { 
            color: #fff; 
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); 
            box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
            font-weight: 600;
            transform: translateX(5px);
        }
        
        .nav-item.active::before {
            display: none;
        }
        
        .nav-item.active i {
            color: #fff;
            transform: scale(1.1);
        }
        
        .sidebar-footer { 
            margin-top: auto; 
            padding: 25px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.3);
        }
        
        .sidebar-footer .nav-item {
            margin: 3px 0;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .sidebar-footer .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
            box-shadow: none;
        }
        
        .sidebar-footer .nav-item.active {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: none;
        }
        
        /* Main Content */
        .main-content { 
            width: 100%; 
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
        
        /* Modal */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            width: 600px;
            max-width: 90%;
            padding: 30px;
            display: none;
            z-index: 2000;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1999;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .modal-close:hover {
            background: #f1f5f9;
        }
        
        .modal-body {
            margin-bottom: 25px;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }
        
        .btn-cancel {
            padding: 12px 24px;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-cancel:hover {
            background: #f1f5f9;
        }
        
        .btn-submit {
            padding: 12px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
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

    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutModalOverlay" onclick="closeLogoutModal()"></div>
    <div class="modal" id="logoutModal">
        <div class="modal-header">
            <h3 class="modal-title">Log Out</h3>
            <button onclick="closeLogoutModal()" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to log out?</p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeLogoutModal()" class="btn-cancel">Cancel</button>
            <button type="button" class="btn-submit" style="background: #dc2626;" onclick="document.getElementById('logoutForm').submit()">Yes, Log Out</button>
        </div>
    </div>

    <script>
        let lastUpdate = new Date().toISOString();
        
        function refreshLogs() {
            location.reload();
        }
        
        function updateActivityCounts() {
            // Update counts in the headers
            const sections = document.querySelectorAll('.section-count');
            sections.forEach(section => {
                const currentCount = parseInt(section.textContent);
                // Add animation if count changes
                section.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    section.style.transform = 'scale(1)';
                }, 300);
            });
        }
        
        function renderLogItem(log) {
            const iconHtml = getIconForModule(log.module);
            return `
                <div class="activity-item" style="opacity: 0; transform: translateY(-10px);">
                    <div class="activity-icon">
                        ${iconHtml}
                    </div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-action">${log.action}</span>
                            <span class="activity-time">${formatTimeAgo(log.created_at)}</span>
                        </div>
                        <div class="activity-description">${log.description}</div>
                        <div class="activity-meta">
                            <span class="activity-module">${log.module}</span>
                            <span class="activity-performed-by">by ${log.performed_by}</span>
                        </div>
                    </div>
                </div>
            `;
        }
        
        function getIconForModule(module) {
            switch(module) {
                case 'Programs':
                    return '<i class="fas fa-calendar-alt" style="color: #2563eb;"></i>';
                case 'Employee':
                    return '<i class="fas fa-users" style="color: #16a34a;"></i>';
                case 'System':
                    return '<i class="fas fa-cog" style="color: #6b7280;"></i>';
                default:
                    return '<i class="fas fa-info-circle" style="color: #d97706;"></i>';
            }
        }
        
        function formatTimeAgo(timestamp) {
            const now = new Date();
            const time = new Date(timestamp);
            const diff = Math.floor((now - time) / 1000); // seconds
            
            if (diff < 60) return 'just now';
            if (diff < 3600) return Math.floor(diff / 60) + ' minutes ago';
            if (diff < 86400) return Math.floor(diff / 3600) + ' hours ago';
            return Math.floor(diff / 86400) + ' days ago';
        }
        
        function updateLogSection(sectionClass, logs) {
            const section = document.querySelector(sectionClass);
            if (!section) return;
            
            const listContainer = section.querySelector('.activity-list');
            const emptyState = section.querySelector('.empty-state');
            const countElement = section.querySelector('.section-count');
            
            if (logs.length > 0) {
                if (listContainer) {
                    // Clear existing logs
                    listContainer.innerHTML = '';
                    
                    // Add new logs with animation
                    logs.forEach((log, index) => {
                        const logHtml = renderLogItem(log);
                        listContainer.insertAdjacentHTML('beforeend', logHtml);
                        
                        // Animate each log item
                        setTimeout(() => {
                            const newItem = listContainer.lastElementChild;
                            newItem.style.transition = 'all 0.3s ease';
                            newItem.style.opacity = '1';
                            newItem.style.transform = 'translateY(0)';
                        }, index * 50);
                    });
                }
                
                // Hide empty state if visible
                if (emptyState) {
                    emptyState.style.display = 'none';
                }
                
                // Update count
                if (countElement) {
                    countElement.textContent = `${logs.length} Logs`;
                }
            } else {
                // Show empty state
                if (listContainer) listContainer.style.display = 'none';
                if (emptyState) emptyState.style.display = 'block';
                if (countElement) countElement.textContent = '0 Logs';
            }
        }
        
        function fetchActivityLogs() {
            fetch('/api/activity-logs')
                .then(response => response.json())
                .then(data => {
                    // Update each section
                    updateLogSection('.dashboard-section:nth-child(1)', data.recentLogs); // Recent Activity
                    updateLogSection('.dashboard-section:nth-child(2)', data.programLogs); // Program Activity
                    updateLogSection('.dashboard-section:nth-child(3)', data.employeeLogs); // Employee Activity
                    updateLogSection('.dashboard-section:nth-child(4)', data.systemLogs); // System Activity
                    
                    // Update counts with animation
                    updateActivityCounts();
                    
                    console.log('Activity logs updated successfully');
                })
                .catch(error => {
                    console.error('Error fetching activity logs:', error);
                });
        }
        
        function confirmLogout(button) {
            if (confirm('Are you sure you want to logout?')) {
                button.closest('form').submit();
            }
        }
        
        function openLogoutModal() {
            document.getElementById('logoutModal').style.display = 'block';
            document.getElementById('logoutModalOverlay').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
            document.getElementById('logoutModalOverlay').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            console.log('Auto-refreshing activity logs...');
            fetchActivityLogs();
        }, 30000);
        
        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            // Add refresh button functionality
            const refreshBtn = document.querySelector('.btn-primary');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.querySelector('i').classList.add('fa-spin');
                    fetchActivityLogs();
                    setTimeout(() => {
                        this.querySelector('i').classList.remove('fa-spin');
                    }, 1000);
                });
            }
        });
    </script>
</body>
</html>
