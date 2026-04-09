<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Assignment History — B-DEAMS</title>
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

        .back-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--white);
            border: 2px solid var(--border);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: var(--text-mid);
            margin-right: 15px;
            vertical-align: middle;
        }

        .back-button:hover {
            background: var(--slate-light);
            border-color: var(--border);
            transform: translateX(-2px);
        }
        
        /* ── PANEL ── */
        .card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 30px;
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
            border-left: 4px solid var(--green);
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
        
        .employee-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }
        
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        
        .empty-state h3 {
            color: var(--text-dark);
            margin-bottom: 10px;
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

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .main { padding: 0 20px 20px; }
            .header { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .header-left { width: 100%; justify-content: center; }
            .nav-buttons { width: 100%; justify-content: center; }
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
                <p>Assignment History</p>
            </div>
        </div>
        <div class="nav-buttons">
            <a href="{{ route('employee.dashboard') }}" class="nav-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
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
            <h1 class="page-title">Assignment History</h1>
        </div>
        <!-- Completed Assignments Section -->
        <div class="card anim delay-1">
            <div class="card-header">
                <h3><i class="fas fa-check-circle"></i> Completed Assignments</h3>
                <span style="color: var(--text-muted); font-size: 12.5px;">{{ $completedAssignments->count() }} items</span>
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
    </script>
</body>
</html>
