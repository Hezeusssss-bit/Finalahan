<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Activity Logs — B-DEAMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --navy: #0d1b2a;
            --navy-mid: #1b2e42;
            --navy-light: #243447;
            --teal: #0ea5a0;
            --teal-light: #e0f7f6;
            --amber: #f59e0b;
            --amber-light: #fef3c7;
            --rose: #f43f5e;
            --rose-light: #ffe4e6;
            --green: #10b981;
            --green-light: #d1fae5;
            --blue: #3b82f6;
            --blue-light: #dbeafe;
            --slate-light: #f1f5f9;
            --white: #ffffff;
            --border: #e2e8f0;
            --text-dark: #0f172a;
            --text-mid: #475569;
            --text-muted: #94a3b8;
            --sidebar-w: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f0f4f8;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
        
        /* ── MAIN ── */
        .main {
            flex: 1;
            padding: 36px 40px;
            min-height: 100vh;
        }
        
        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 32px;
        }

        .page-eyebrow {
            font-size: 11.5px;
            font-weight: 500;
            color: var(--teal);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 6px;
        }

        .page-title {
            font-family: 'Outfit', sans-serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .page-actions { display: flex; gap: 12px; }
        
        .btn { 
            padding: 9px 20px; 
            border-radius: 10px; 
            border: none;
            background: var(--navy);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn:hover { background: var(--navy-mid); }
        .btn.green { background: var(--green); }
        .btn.green:hover { background: #059669; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        
        /* ── PANEL ── */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .dashboard-section {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 24px;
        }
        
        .panel-head {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-title {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .panel-title i { color: var(--teal); font-size: 14px; }
        .section-title i { color: var(--teal); font-size: 14px; }
        .panel-body { padding: 20px 24px; }
        
        .section-count { 
            background: var(--slate-light); 
            color: var(--text-muted); 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600;
        }
        
        .empty-state { 
            text-align: center; 
            padding: 60px 20px; 
            color: var(--text-muted);
        }
        
        .empty-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
        .empty-text { font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text-mid); }
        .empty-subtext { font-size: 14px; opacity: 0.7; color: var(--text-muted); }
        
        /* ── ACTIVITY ── */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .activity-list::-webkit-scrollbar { display: none; }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            transition: background 0.15s;
            cursor: pointer;
        }

        .activity-item:hover { background: var(--slate-light); }

        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 4px;
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
        
        .activity-action { font-weight: 600; color: var(--text-dark); }
        .activity-time { font-size: 12px; color: var(--text-muted); }
        .activity-description { color: var(--text-mid); margin-bottom: 8px; }
        .activity-meta { 
            display: flex; 
            gap: 12px; 
            font-size: 12px; 
            color: var(--text-muted); 
        }
        
        .activity-module { 
            background: var(--border); 
            padding: 2px 8px; 
            border-radius: 4px; 
            font-weight: 500;
        }
        
        .activity-performed-by { font-style: italic; }
        
        .activity-empty {
            text-align: center;
            padding: 30px;
            font-size: 13px;
            color: var(--text-muted);
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            background: var(--navy-mid);
            color: var(--white);
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .back-button:hover {
            background: var(--navy);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .back-button i {
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .back-button:hover i {
            transform: translateX(-2px);
        }
        
        /* ── MODAL ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 500;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-backdrop.open { display: flex; }

        .modal-box {
            background: white;
            border-radius: 18px;
            width: 90%;
            max-width: 500px;
            max-height: 88vh;
            overflow-y: auto;
            scrollbar-width: none;
            animation: modalIn 0.25s cubic-bezier(0.175,0.885,0.32,1.275) both;
        }

        .modal-box::-webkit-scrollbar { display: none; }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-head {
            padding: 22px 26px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            position: sticky;
            top: 0;
            background: white;
            border-radius: 18px 18px 0 0;
            z-index: 10;
        }

        .modal-head-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .modal-head-sub { font-size: 12.5px; color: var(--text-muted); margin-top: 3px; }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--slate-light);
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .modal-close:hover { background: var(--rose-light); color: var(--rose); border-color: var(--rose); }

        .modal-body { padding: 20px 26px 26px; }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-top: 18px;
        }

        .btn-cancel {
            padding: 9px 20px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--slate-light);
            color: var(--text-mid);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover { background: var(--border); }

        .btn-submit {
            padding: 9px 24px;
            border-radius: 10px;
            border: none;
            background: var(--navy);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-submit:hover { background: var(--navy-mid); }
        .btn-submit.green { background: var(--green); }
        .btn-submit.green:hover { background: #059669; }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .anim       { animation: fadeUp 0.4s ease both; }
        .delay-1    { animation-delay: 0.07s; }
        .delay-2    { animation-delay: 0.13s; }
        .delay-3    { animation-delay: 0.19s; }
        .delay-4    { animation-delay: 0.25s; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .content-grid { grid-template-columns: 1fr; }
            .quick-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .main { padding: 24px 20px; }
            .stats-row { grid-template-columns: 1fr; }
            .quick-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- ══ MAIN CONTENT ══ -->
    <main class="main">
        <!-- Page Header -->
        <div class="page-header anim">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p class="page-eyebrow">System</p>
                    <h1 class="page-title">Activity Logs</h1>
                </div>
                <a href="{{ route('resident.index') }}" class="back-button">
                    <i class="fas fa-chevron-left"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- Recent Activity Panel -->
        <div class="panel anim delay-1">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-clock-rotate-left"></i> Recent Activity
                </div>
                <div class="section-count">{{ $recentLogs->count() }} Logs</div>
            </div>
            <div class="panel-body" style="padding-top:12px;">
                <div class="activity-list">
                    @forelse($recentLogs as $log)
                    <div class="activity-item">
                        <div class="activity-dot" style="background:{{ $log->color ?? '#0ea5a0' }};"></div>
                        <div>
                            <div class="activity-desc">{{ $log->description }}</div>
                            <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="activity-empty">
                        <i class="fas fa-inbox" style="font-size:24px;margin-bottom:8px;display:block;"></i>
                        No recent activities
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Program Activity Panel -->
        <div class="panel anim delay-2">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-calendar-alt"></i> Program Activity
                </div>
                <div class="section-count">{{ $programLogs->count() }} Logs</div>
            </div>
            <div class="panel-body" style="padding-top:12px;">
                <div class="activity-list">
                    @forelse($programLogs as $log)
                    <div class="activity-item">
                        <div class="activity-dot" style="background:#2563eb;"></div>
                        <div>
                            <div class="activity-desc">{{ $log->description }}</div>
                            <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="activity-empty">
                        <i class="fas fa-calendar-alt" style="font-size:24px;margin-bottom:8px;display:block;"></i>
                        No program activities
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Employee Activity Panel -->
        <div class="panel anim delay-3">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-users"></i> Employee Activity
                </div>
                <div class="section-count">{{ $employeeLogs->count() }} Logs</div>
            </div>
            <div class="panel-body" style="padding-top:12px;">
                <div class="activity-list">
                    @forelse($employeeLogs as $log)
                    <div class="activity-item">
                        <div class="activity-dot" style="background:#16a34a;"></div>
                        <div>
                            <div class="activity-desc">{{ $log->description }}</div>
                            <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="activity-empty">
                        <i class="fas fa-users" style="font-size:24px;margin-bottom:8px;display:block;"></i>
                        No employee activities
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- System Activity Panel -->
        <div class="panel anim delay-4">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-cog"></i> System Activity
                </div>
                <div class="section-count">{{ $systemLogs->count() }} Logs</div>
            </div>
            <div class="panel-body" style="padding-top:12px;">
                <div class="activity-list">
                    @forelse($systemLogs as $log)
                    <div class="activity-item">
                        <div class="activity-dot" style="background:#6b7280;"></div>
                        <div>
                            <div class="activity-desc">{{ $log->description }}</div>
                            <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="activity-empty">
                        <i class="fas fa-cog" style="font-size:24px;margin-bottom:8px;display:block;"></i>
                        No system activities
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </main>

    <!-- ══ LOGOUT MODAL ══ -->
    <div class="modal-backdrop" id="logoutBackdrop">
        <div class="modal-box" style="max-width:400px;">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Confirm Logout</div>
                    <div class="modal-head-sub">You will be signed out of the system.</div>
                </div>
                <button class="modal-close" onclick="closeLogoutModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13.5px;color:var(--text-mid);line-height:1.6;margin-bottom:4px;">Are you sure you want to log out of B-DEAMS?</p>
                <div class="modal-footer">
                    <button class="btn-cancel" onclick="closeLogoutModal()">Stay</button>
                    <button class="btn-submit" style="background:var(--rose);" onclick="document.getElementById('logoutForm').submit()">
                        <i class="fas fa-right-from-bracket"></i> Yes, Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const csrf = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ── Modal helpers ──
        function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }

        ['logoutBackdrop'].forEach(id => {
            document.getElementById(id).addEventListener('click', e => { if (e.target.id === id) closeModal(id); });
        });

        function openLogoutModal()    { openModal('logoutBackdrop'); }
        function closeLogoutModal()   { closeModal('logoutBackdrop'); }

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
                    <div class="activity-dot" style="background:${log.color ?? '#0ea5a0'};"></div>
                    <div>
                        <div class="activity-desc">${log.description}</div>
                        <div class="activity-time">${formatTimeAgo(log.created_at)}</div>
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
            const emptyState = section.querySelector('.activity-empty');
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
                    updateLogSection('.panel:nth-child(2)', data.recentLogs); // Recent Activity
                    updateLogSection('.panel:nth-child(3)', data.programLogs); // Program Activity
                    updateLogSection('.panel:nth-child(4)', data.employeeLogs); // Employee Activity
                    updateLogSection('.panel:nth-child(5)', data.systemLogs); // System Activity
                    
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
