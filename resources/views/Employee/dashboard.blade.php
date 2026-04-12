<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Employee Dashboard — B-DEAMS</title>
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

        /* ── HEADER ── */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            border-radius: 0 0 16px 16px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .brand-badge {
            width: 40px;
            height: 40px;
            background: var(--teal);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .brand-info h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .brand-info p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 2px 0 0 0;
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .nav-btn {
            padding: 10px 16px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-mid);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .nav-btn:hover {
            background: var(--slate-light);
            color: var(--text-dark);
        }

        .nav-btn.active {
            background: var(--teal);
            color: white;
            border-color: var(--teal);
        }

        .nav-btn.logout {
            color: var(--rose);
            border-color: var(--rose-light);
        }

        .nav-btn.logout:hover {
            background: var(--rose-light);
        }

        /* ── MAIN ── */
        .main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px 40px;
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
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 26px 28px;
            border: 1px solid var(--border);
            text-decoration: none;
            display: block;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.navy::before { background: var(--navy); }
        .stat-card.teal::before  { background: var(--teal); }
        .stat-card.green::before { background: var(--green); }
        .stat-card.blue::before  { background: var(--blue); }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .stat-row-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.navy { background: #e8ecf0; color: var(--navy); }
        .stat-icon.teal { background: var(--teal-light); color: var(--teal); }
        .stat-icon.green { background: var(--green-light); color: var(--green); }
        .stat-icon.blue { background: var(--blue-light); color: var(--blue); }

        .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 44px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
            margin-top: 18px;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .stat-link {
            font-size: 12px;
            font-weight: 500;
            color: var(--teal);
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* ── PANEL ── */
        .card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 0;
        }

        .card-header h3 i { color: var(--teal); font-size: 14px; }
        .card-content { padding: 20px 24px; }
        
        /* ── EMPLOYEE LIST ── */
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
            background: var(--slate-light);
            border-radius: 10px;
            transition: background 0.15s;
        }
        
        .employee-item:hover {
            background: #e2e8f0;
        }
        
        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-muted);
        }
        
        .employee-info {
            flex: 1;
        }
        
        .employee-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }
        
        .employee-position {
            font-size: 14px;
            color: var(--text-muted);
        }
        
        .employee-status {
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            color: white;
        }
        
        /* ── ASSIGNMENTS ── */
        .assignments-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .assignment-item {
            background: var(--slate-light);
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid var(--blue);
            transition: all 0.2s;
        }
        
        .assignment-item:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
            color: var(--text-dark);
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
            color: var(--text-mid);
            display: block;
            margin-bottom: 4px;
        }
        
        .assignment-date {
            color: var(--text-muted);
            font-size: 13px;
        }
        
        .assignment-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .btn-active {
            background: var(--green);
            color: white;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
        }
        
        .btn-done {
            background: var(--green);
            color: white;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .stat-card-link {
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .stat-card-link:hover {
            transform: translateY(-3px);
        }
        
        .stat-card-link:hover .stat-card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        

        /* ── SUCCESS MESSAGE ── */
        .success-message {
            background: var(--green);
            color: white;
            padding: 13px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeUp 0.3s ease both;
        }

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
            .stats-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .main { padding: 0 20px 20px; }
            .header { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .header-left { width: 100%; justify-content: center; }
            .nav-buttons { width: 100%; justify-content: center; }
            .stats-grid { grid-template-columns: 1fr; }
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>

    <!-- ══ HEADER ══ -->
    <header class="header">
        <div class="header-left">
            <div class="brand-badge"><i class="fas fa-shield-alt"></i></div>
            <div class="brand-info">
                <h1>B-DEAMS</h1>
                <p>Employee Dashboard</p>
            </div>
        </div>
        <div class="nav-buttons">
            <a href="{{ route('employee.dashboard') }}" class="nav-btn active">
                <i class="fas fa-gauge-high"></i> Dashboard
            </a>
            <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="nav-btn logout">
                    <i class="fas fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </header>

    <!-- ══ MAIN CONTENT ══ -->
    <main class="main">

        <!-- Page Header -->
        <div class="page-header anim">
            <p class="page-eyebrow">Employee Portal</p>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <!-- Stats -->
        <div class="stats-grid anim delay-1">
            <a href="{{ route('employee.history') }}" class="stat-card-link">
                <div class="stat-card green">
                    <div class="stat-row-inner">
                        <div>
                            <div class="stat-label">Completed Assignments</div>
                        </div>
                        <div class="stat-icon green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $completedAssignments ?? 0 }}</div>
                    <div class="stat-label">Tasks finished</div>
                    <div class="stat-link">View history <i class="fas fa-arrow-right" style="font-size:10px;"></i></div>
                </div>
            </a>

            <a href="#your-assignments" class="stat-card-link">
                <div class="stat-card blue">
                    <div class="stat-row-inner">
                        <div>
                            <div class="stat-label">Active Assignments</div>
                        </div>
                        <div class="stat-icon blue">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $activeAssignments ?? 0 }}</div>
                    <div class="stat-label">Current tasks</div>
                    <div class="stat-link">View all <i class="fas fa-arrow-right" style="font-size:10px;"></i></div>
                </div>
            </a>
        </div>
        
        <!-- Employee Assignments Section -->
        @if($employeeAssignments->count() > 0)
            <div class="card anim delay-3" id="your-assignments">
                <div class="card-header">
                    <h3><i class="fas fa-user-check"></i> Your Assignments</h3>
                </div>
                <div class="card-content">
                    <div class="assignments-list">
                        @foreach($employeeAssignments as $assignment)
                            <div class="assignment-item">
                                <div class="assignment-header">
                                    <div class="assignment-center" style="background: #f3f4f6; padding: 10px 16px; border-radius: 8px; border: 2px solid #d1d5db; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-map-marker-alt" style="color: #374151; font-size: 16px;"></i>
                                        {{ $assignment->purok }}
                                    </div>
                                    <div class="assignment-actions">
                                        @if($assignment->status === 'active')
                                            <button class="btn-active">
                                                Active
                                            </button>
                                            <button class="btn-done" onclick="markAsDone({{ $assignment->id }})">
                                                <i class="fas fa-check"></i> Done
                                            </button>
                                        @else
                                            <span class="employee-status" style="background: {{ $assignment->getStatusColor() }};">
                                                {{ $assignment->getStatusLabel() }}
                                            </span>
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
            <div class="card anim delay-3">
                <div class="card-header">
                    <h3><i class="fas fa-user-check"></i> Your Assignments</h3>
                </div>
                <div class="card-content">
                    <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fas fa-clipboard-list" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                        <h4 style="margin-bottom: 8px; color: var(--text-dark);">No Assignments Yet</h4>
                        <p>You haven't been assigned to any evacuation centers yet.</p>
                        <p style="font-size: 14px; color: var(--text-muted);">Check back later for new assignments from the administrator.</p>
                    </div>
                </div>
            </div>
        @endif
        
    </main>

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-circle-check"></i>
        <span id="toast-msg">Done!</span>
    </div>

    <script>
        const csrf = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showToast(msg, icon = 'fas fa-circle-check') {
            const t = document.getElementById('toast');
            t.querySelector('i').className = icon;
            document.getElementById('toast-msg').textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3200);
        }

        function markAsDone(assignmentId) {
            if (confirm('Are you sure you want to mark this assignment as completed?')) {
                fetch(`/employee-assignments/${assignmentId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf()
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Assignment marked as completed!');
                        
                        // Remove the assignment card
                        const assignmentCard = document.querySelector(`[onclick="markAsDone(${assignmentId})"]`).closest('.assignment-item');
                        assignmentCard.style.transition = 'opacity 0.3s, transform 0.3s';
                        assignmentCard.style.opacity = '0';
                        assignmentCard.style.transform = 'translateX(20px)';
                        
                        setTimeout(() => {
                            assignmentCard.remove();
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
