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
        
        /* ── EVACUEE MANAGEMENT ── */
        .evacuee-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            align-items: center;
        }

        .evacuee-controls .form-select,
        .evacuee-controls .search-input {
            padding: 10px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            background: var(--slate-light);
            transition: all 0.2s;
            outline: none;
        }

        .evacuee-controls .form-select {
            flex: 1;
            min-width: 200px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .evacuee-controls .form-select:focus,
        .evacuee-controls .search-input:focus {
            background: white;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14, 165, 160, 0.12);
        }

        .evacuee-controls .search-input {
            flex: 2;
            min-width: 250px;
        }

        .evacuee-table-responsive {
            overflow-x: auto;
        }

        .evacuee-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .evacuee-table th,
        .evacuee-table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .evacuee-table th {
            background: var(--slate-light);
            font-weight: 600;
            color: var(--text-mid);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        .evacuee-table tbody tr:hover {
            background: var(--slate-light);
        }

        .evacuee-table tbody tr:last-child td {
            border-bottom: none;
        }

        .evacuee-action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            background: var(--slate-light);
            color: var(--text-muted);
            border: 1px solid var(--border);
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
        }

        .btn-action:hover {
            background: var(--border);
            color: var(--text-mid);
        }

        .btn-export {
            padding: 9px 20px;
            border-radius: 10px;
            border: none;
            background: var(--blue);
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

        .btn-export:hover { background: #1d4ed8; }

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
        
        <!-- Evacuee Management Section -->
        <div class="card anim delay-2" id="evacuee-management">
            <div class="card-header">
                <h3><i class="fas fa-users"></i> Evacuee Management</h3>
                <p style="margin: 0; color: var(--text-muted); font-size: 12.5px; font-weight: 400;">Manage evacuees, track shelter capacity, and monitor evacuation status.</p>
            </div>
            <div class="card-content">
                <!-- Controls -->
                <div class="evacuee-controls">
                    <input type="text" class="search-input" placeholder="Search evacuees..." id="searchInput">
                    <div style="display: flex; gap: 10px; margin-left: auto;">
                        <button class="btn-export" onclick="exportEvacuees()">
                            <i class="fas fa-download"></i> EXPORT
                        </button>
                    </div>
                </div>
                
                <!-- Evacuees Table -->
                <div class="evacuee-table-responsive">
                    <table class="evacuee-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FULLNAME</th>
                                <th>AGE</th>
                                <th>GENDER</th>
                                <th>EVACUATION STATUS</th>
                                <th>EVACUATION AREA</th>
                                <th>ROOM NUMBER</th>
                                <th>EVACUATION DATE</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="evacueesTableBody">
                            @php
                                $assignedAreas = $employeeAssignments->pluck('evacuation_center')->toArray();
                                $evacuees = App\Models\Evacuee::whereIn('evacuation_area', $assignedAreas)
                                    ->where('evacuation_status', '!=', 'Released')
                                    ->with('resident')
                                    ->get();
                            @endphp
                            @if($evacuees->count() > 0)
                                @foreach($evacuees as $evacuee)
                                    <tr>
                                        <td>{{ str_pad($evacuee->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $evacuee->resident->name ?? 'N/A' }}</td>
                                        <td>{{ $evacuee->resident->price ?? 'N/A' }}</td>
                                        <td>{{ $evacuee->resident->gender ?? 'N/A' }}</td>
                                        <td>
                                            <span class="employee-status" style="background: {{ $evacuee->evacuation_status === 'Evacuated' ? '#10b981' : '#f59e0b' }};">
                                                {{ $evacuee->evacuation_status }}
                                            </span>
                                        </td>
                                        <td>{{ $evacuee->evacuation_area }}</td>
                                        <td>{{ $evacuee->room_number ?? 'N/A' }}</td>
                                        <td>{{ $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            <div class="evacuee-action-buttons">
                                                <button class="btn-action" onclick="viewEvacuee({{ $evacuee->id }})" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn-action" onclick="releaseEvacuee({{ $evacuee->id }})" title="Release">
                                                    <i class="fas fa-door-open"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px; color: #6b7280;">
                                        <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                                        <h4 style="margin-bottom: 8px; color: #333;">No Evacuees Found</h4>
                                        <p>No evacuees have been assigned to your evacuation centers yet.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
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
                                    <div class="assignment-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $assignment->evacuation_center }}
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
        
        
        // Event listener for search
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('searchInput').addEventListener('input', searchEvacuees);
        });
        
        // Evacuee Search Function
        function searchEvacuees() {
            const searchFilter = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#evacueesTableBody tr');
            
            rows.forEach(row => {
                const fullname = row.cells[1].textContent.toLowerCase();
                const id = row.cells[0].textContent.toLowerCase();
                
                const matchesSearch = !searchFilter || fullname.includes(searchFilter) || id.includes(searchFilter);
                
                row.style.display = matchesSearch ? '' : 'none';
            });
        }
        
        function exportEvacuees() {
            // Export evacuees from employee's assigned areas
            window.open('{{ route("employee.evacuees.export") }}', '_blank');
        }
        
        function viewEvacuee(id) {
            // Fetch evacuee details and display in modal
            fetch(`/evacuees/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const evacuee = data.evacuee;
                        const details = `
Evacuee Details

ID: ${evacuee.id}
Name: ${evacuee.name}
Age: ${evacuee.age}
Gender: ${evacuee.gender}
Evacuation Status: ${evacuee.evacuation_status}
Evacuation Area: ${evacuee.evacuation_area}
Room Number: ${evacuee.room_number}
Evacuation Date: ${evacuee.evacuation_date}
Released At: ${evacuee.released_at}
                        `;
                        alert(details.trim());
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching evacuee details.');
                });
        }
        
        function releaseEvacuee(id) {
            if (confirm('Are you sure you want to release this evacuee?')) {
                fetch(`/evacuees/${id}/release`, {
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
                        showToast('Evacuee released successfully!');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while releasing the evacuee.');
                });
            }
        }
        
    </script>
</body>
</html>
