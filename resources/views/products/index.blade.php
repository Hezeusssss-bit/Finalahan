<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dashboard — B-DEAMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
            display: flex;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--navy);
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 200;
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-brand {
            padding: 22px 24px 18px;
            display: flex;
            align-items: center;
            gap: 13px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .brand-badge {
            width: 38px;
            height: 38px;
            background: transparent;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: white;
            flex-shrink: 0;
        }

        .dswd-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
            border-radius: 6px;
        }

        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: white;
            letter-spacing: 0.02em;
        }

        .brand-sub {
            font-size: 10px;
            color: rgba(255,255,255,0.35);
            font-weight: 300;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .nav-section {
            padding: 18px 16px 4px;
        }

        .nav-section-label {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.28);
            padding: 0 8px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.08);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: all 0.2s;
            margin-bottom: 2px;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
        }

        .nav-link i {
            width: 18px;
            text-align: center;
            font-size: 14px;
            color: rgba(255,255,255,0.35);
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: white;
        }

        .nav-link:hover i { color: var(--teal); }

        .nav-link.active {
            background: rgba(14, 165, 160, 0.15);
            color: white;
            font-weight: 500;
        }

        .nav-link.active i { color: var(--teal); }

        .sidebar-footer {
            margin-top: auto;
            padding: 12px 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .nav-link-danger:hover {
            background: rgba(244, 63, 94, 0.12);
            color: #fca5a5;
        }

        .nav-link-danger:hover i { color: #fca5a5; }

        /* ── MAIN ── */
        .main {
            margin-left: var(--sidebar-w);
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
        }

        /* ── STAT CARDS ── */
        .stats-row {
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.navy::before { background: var(--navy); }
        .stat-card.teal::before  { background: var(--teal); }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .stat-row-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon-wrap {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon-wrap.navy { background: #e8ecf0; color: var(--navy); }
        .stat-icon-wrap.teal { background: var(--teal-light); color: var(--teal); }

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

        /* ── GRID ── */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            margin-bottom: 24px;
        }

        /* ── PANEL ── */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .panel-head {
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

        .panel-title i { color: var(--teal); font-size: 14px; }
        .panel-body { padding: 20px 24px; }

        /* ── ANALYTICS ── */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .analytics-tile {
            background: var(--slate-light);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .analytics-tile .val {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
            margin-bottom: 5px;
        }

        .analytics-tile .lbl {
            font-size: 12px;
            color: var(--text-muted);
        }

        .growth-bar {
            background: var(--blue-light);
            border-radius: 10px;
            padding: 12px 16px;
            border-left: 4px solid var(--blue);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .growth-label {
            font-size: 12.5px;
            font-weight: 500;
            color: #1e40af;
        }

        .growth-value {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #1d4ed8;
        }

        /* ── ACTIVITY ── */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
            max-height: 260px;
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
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            margin-right: 4px;
        }

        .activity-desc {
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .activity-time {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .activity-empty {
            text-align: center;
            padding: 30px;
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ── QUICK ACTIONS ── */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .quick-card {
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 18px;
            text-decoration: none;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .quick-card:hover {
            border-color: var(--teal);
            box-shadow: 0 6px 20px rgba(14, 165, 160, 0.1);
            transform: translateY(-2px);
        }

        .quick-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .quick-name {
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .quick-sub {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        /* ── ALERT BANNER ── */
        .flash-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 22px;
            animation: fadeUp 0.3s ease both;
        }

        .flash-alert.success { background: var(--green-light); color: #065f46; }
        .flash-alert.error   { background: var(--rose-light);  color: #9f1239; }

        /* ── TOAST ── */
        .toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: var(--navy);
            color: white;
            padding: 14px 22px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 9999;
            transform: translateY(80px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: none;
        }

        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { color: var(--teal); }

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
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
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

        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-muted);
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
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

        .form-control:focus {
            background: white;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14, 165, 160, 0.12);
        }

        textarea.form-control { resize: vertical; min-height: 80px; }

        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .radio-opt {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13.5px;
            cursor: pointer;
            color: var(--text-mid);
        }

        .radio-opt input { accent-color: var(--teal); }

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
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .main { margin-left: 0; padding: 24px 20px; }
            .stats-row { grid-template-columns: 1fr; }
            .quick-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-badge">
                    <img src="{{ asset('images/dswd_logo.png') }}" alt="DSWD Logo" class="dswd-logo">
                </div>
            <div>
                <div class="brand-name">MSWD IS with Intellegent Decision Support</div> <br>
                <div class="brand-sub">Barangay Gargato</div>
            </div>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('resident.index') }}" class="nav-link active">
                <i class="fas fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('program.index') }}" class="nav-link">
                <i class="fas fa-clipboard-list"></i> Programs
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Services</div>
            <a href="{{ route('services') }}" class="nav-link">
                <i class="fas fa-concierge-bell"></i> Services
            </a>
            <a href="{{ route('tryall') }}" class="nav-link">
                <i class="fas fa-sms"></i> SMS Alert
            </a>
            <a href="{{ route('facilities') }}" class="nav-link">
                <i class="fas fa-building"></i> Facilities
            </a>
            <a href="{{ route('idps') }}" class="nav-link">
                <i class="fas fa-users"></i> IDP's
            </a>
        </div>

        <div class="sidebar-footer">
            <div style="font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.28);padding:0 8px;margin-bottom:6px;">System</div>
            <a href="{{ route('activity-logs.index') }}" class="nav-link">
                <i class="fas fa-scroll"></i> Activity Log
            </a>
            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="button" class="nav-link nav-link-danger" onclick="openLogoutModal()">
                    <i class="fas fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- ══ MAIN CONTENT ══ -->
    <main class="main">

        <!-- Page Header -->
        <div class="page-header anim">
            <p class="page-eyebrow">Administration</p>
            <h1 class="page-title">Dashboard</h1>
        </div>

        <!-- Flash -->
        @if(session('Success'))
        <div class="flash-alert success anim">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('Success') }}</span>
        </div>
        @endif

        <!-- Stats -->
        <div class="stats-row anim delay-1">
            <a href="{{ route('home') }}" class="stat-card navy">
                <div class="stat-row-inner">
                    <div>
                        <div class="stat-label">Total Residents</div>
                    </div>
                    <div class="stat-icon-wrap navy">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalResidents) }}</div>
                <div class="stat-label">Registered Residents</div>
                <div class="stat-link">View all <i class="fas fa-arrow-right" style="font-size:10px;"></i></div>
            </a>

            <a href="{{ route('program.evacuee') }}" class="stat-card teal">
                <div class="stat-row-inner">
                    <div>
                        <div class="stat-label">Total Evacuee</div>
                    </div>
                    <div class="stat-icon-wrap teal">
                        <i class="fas fa-person-shelter"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalEvacuees) }}</div>
                <div class="stat-label">Current Evacuees</div>
                <div class="stat-link">View all <i class="fas fa-arrow-right" style="font-size:10px;"></i></div>
            </a>
        </div>

        <!-- Analytics + Activity -->
        <div class="content-grid anim delay-2">

            <!-- Analytics Panel -->
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="fas fa-chart-line"></i> Analytics & Insights
                    </div>
                </div>
                <div class="panel-body">
                    @php
                        $totalResidents = $totalResidents ?? 0;
                        $newThisMonth   = $newThisMonth ?? 0;
                        $growthRate     = $totalResidents > 0 ? round(($newThisMonth / $totalResidents) * 100, 1) : 0;
                    @endphp
                    <div class="analytics-grid">
                        <div class="analytics-tile">
                            <div class="val">{{ number_format($totalResidents) }}</div>
                            <div class="lbl">Total Residents</div>
                        </div>
                        <div class="analytics-tile">
                            <div class="val" style="color:var(--green);">{{ $newThisMonth ?? 0 }}</div>
                            <div class="lbl">New This Month</div>
                        </div>
                    </div>
                    <div class="growth-bar">
                        <div>
                            <div class="growth-label">Monthly Growth Rate</div>
                            <div style="font-size:12px;color:#3b82f6;margin-top:2px;">Based on registrations this month</div>
                        </div>
                        <div class="growth-value">+{{ $growthRate }}%</div>
                    </div>
                </div>
            </div>

            <!-- Activity Panel -->
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="fas fa-clock-rotate-left"></i> Recent Activity
                    </div>
                </div>
                <div class="panel-body" style="padding-top:12px;">
                    <div class="activity-list">
                        @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="background:{{ $activity['color'] }}20; color:{{ $activity['color'] }};">
                                @if(str_contains($activity['description'] ?? '', 'registered'))
                                    <i class="fas fa-user-plus"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'evacuee'))
                                    <i class="fas fa-person-shelter"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'program'))
                                    <i class="fas fa-clipboard-list"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'facility'))
                                    <i class="fas fa-building"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'SMS') || str_contains($activity['description'] ?? '', 'alert'))
                                    <i class="fas fa-sms"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'employee'))
                                    <i class="fas fa-user-tie"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'assignment'))
                                    <i class="fas fa-list-check"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'login'))
                                    <i class="fas fa-right-to-bracket"></i>
                                @elseif(str_contains($activity['description'] ?? '', 'logout'))
                                    <i class="fas fa-right-from-bracket"></i>
                                @else
                                    <i class="fas fa-circle-info"></i>
                                @endif
                            </div>
                            <div>
                                <div class="activity-desc">{{ $activity['description'] }}</div>
                                <div class="activity-time">{{ $activity['time_ago'] }}</div>
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
        </div>

        <!-- Quick Actions -->
        <div class="panel anim delay-3">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-bolt"></i> Quick Actions
                </div>
            </div>
            <div class="panel-body">
                <div class="quick-grid">
                    <div class="quick-card" onclick="openReportModal()">
                        <div class="quick-icon" style="background:var(--blue-light);color:var(--blue);">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <div class="quick-name">Generate Report</div>
                            <div class="quick-sub">Export resident data</div>
                        </div>
                    </div>
                    <a href="{{ route('employee.employee') }}" class="quick-card">
                        <div class="quick-icon" style="background:#f1f5f9;color:var(--text-mid);">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <div class="quick-name">Employee Management</div>
                            <div class="quick-sub">Manage staff & access</div>
                        </div>
                    </a>
                    <a href="{{ route('employee-assignments.index') }}" class="quick-card">
                        <div class="quick-icon" style="background:#f3f0ff;color:#7c3aed;">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <div>
                            <div class="quick-name">Assignments</div>
                            <div class="quick-sub">View all employee tasks</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-circle-check"></i>
        <span id="toast-msg">Done!</span>
    </div>

    <!-- ══ REPORT MODAL ══ -->
    <div class="modal-backdrop" id="reportBackdrop">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Generate Report</div>
                    <div class="modal-head-sub">Select type and format to export data</div>
                </div>
                <button class="modal-close" onclick="closeReportModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Report Type</label>
                    <select id="reportType" class="form-control">
                        <option value="">Select a report type…</option>
                        <option value="residents">All Residents Report</option>
                        <option value="evacuees">Evacuees Report</option>
                        <option value="programs">Programs Report</option>
                        <option value="facilities">Facilities Report</option>
                        <option value="activities">Activity Logs Report</option>
                        <option value="summary">Dashboard Summary</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Export Format</label>
                    <div class="radio-group">
                        <label class="radio-opt"><input type="radio" name="format" value="pdf" checked> PDF</label>
                        <label class="radio-opt"><input type="radio" name="format" value="csv"> CSV</label>
                        <label class="radio-opt"><input type="radio" name="format" value="print"> Print</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" onclick="closeReportModal()">Cancel</button>
                    <button class="btn-submit green" onclick="generateReport()">
                        <i class="fas fa-file-export"></i> Generate
                    </button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- ══ ASSIGNMENT MODAL ══ -->
    <div class="modal-backdrop" id="assignmentBackdrop">
        <div class="modal-box" style="max-width:540px;">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Assign Employee</div>
                    <div class="modal-head-sub">Assign staff to manage an evacuation center</div>
                </div>
                <button class="modal-close" onclick="closeAssignmentModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="assignmentForm" onsubmit="submitAssignment(event)">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Select Employee</label>
                        <select id="employee_id" name="employee_id" required class="form-control">
                            <option value="">Choose an employee…</option>
                            @foreach(App\Models\Employee::where('status', 'active')->get() as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }} — {{ $employee->position }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Evacuation Center</label>
                        <select id="evacuation_center" name="evacuation_center" required class="form-control">
                            <option value="">Select center…</option>
                            <option>Barangay Hall Evacuation Center</option>
                            <option>Community Center Evacuation</option>
                            <option>School Gymnasium</option>
                            <option>Sports Complex</option>
                            <option>Multi-Purpose Hall</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Responsibilities</label>
                        <textarea id="responsibilities" name="responsibilities" class="form-control" placeholder="e.g. Organize residents, manage supplies…"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Additional Notes</label>
                        <textarea id="notes" name="notes" class="form-control" style="min-height:65px;" placeholder="Any extra instructions…"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeAssignmentModal()">Cancel</button>
                        <button type="submit" class="btn-submit green" id="assignBtn">
                            <i class="fas fa-user-check"></i> Assign Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
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

        // ── Modal helpers ──
        function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }

        ['reportBackdrop','logoutBackdrop','assignmentBackdrop'].forEach(id => {
            document.getElementById(id).addEventListener('click', e => { if (e.target.id === id) closeModal(id); });
        });

        function openReportModal()    { openModal('reportBackdrop'); }
        function closeReportModal()   { closeModal('reportBackdrop'); }
        function openLogoutModal()    { openModal('logoutBackdrop'); }
        function closeLogoutModal()   { closeModal('logoutBackdrop'); }
        function openAssignmentModal(){ openModal('assignmentBackdrop'); }
        function closeAssignmentModal(){ closeModal('assignmentBackdrop'); document.getElementById('assignmentForm').reset(); }

        // ── Flash auto-dismiss ──
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.flash-alert').forEach(el => {
                setTimeout(() => { el.style.opacity='0'; el.style.transition='opacity 0.4s'; setTimeout(()=>el.remove(),400); }, 4000);
            });
        });

        // ── Report generation ──
        function generateReport() {
            const type   = document.getElementById('reportType').value;
            const format = document.querySelector('input[name="format"]:checked').value;
            if (!type) { showToast('Please select a report type.', 'fas fa-triangle-exclamation'); return; }

            const names = { residents:'All Residents Report', evacuees:'Evacuees Report', programs:'Programs Report', facilities:'Facilities Report', activities:'Activity Logs Report', summary:'Dashboard Summary Report' };

            const btn = document.querySelector('#reportBackdrop .btn-submit.green');
            const orig = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating…';

            setTimeout(() => {
                if (format === 'print')  printReport(type, names[type]);
                else if (format === 'pdf')  generatePDFReport(type, names[type]);
                else if (format === 'csv')  generateCSVReport(type, names[type]);
                btn.disabled = false;
                btn.innerHTML = orig;
                closeReportModal();
                showToast(`${names[type]} exported as ${format.toUpperCase()}`);
            }, 1200);
        }

        // ── Assignment submit ──
        function submitAssignment(event) {
            event.preventDefault();
            const btn = document.getElementById('assignBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Assigning…';
            const formData = new FormData(event.target);

            fetch('/employee-assignments', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': csrf() }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) { closeAssignmentModal(); showToast('Employee assigned successfully!'); }
                else { alert('Errors:\n' + Object.values(data.errors || {}).flat().join('\n')); }
            })
            .catch(() => alert('An error occurred. Please try again.'))
            .finally(() => { btn.disabled = false; btn.innerHTML = '<i class="fas fa-user-check"></i> Assign Employee'; });
        }

        /* ── PDF / CSV / Print helpers (preserved from original) ── */
        const sampleData = {
            residents:[{id:1,name:'Juan Dela Cruz',age:35,address:'Brgy. Masagana',contact:'09123456789'},{id:2,name:'Maria Santos',age:28,address:'Brgy. Poblacion',contact:'09987654321'}],
            evacuees:[{id:1,name:'Ana Garcia',family:4,center:'Evacuation Center A',date:'2024-01-15'}],
            programs:[{id:1,name:'Disaster Preparedness Training',participants:45,date:'2024-01-10',status:'Completed'}],
            facilities:[{id:1,name:'Evacuation Center A',capacity:100,current:45,status:'Operational'}],
            activities:[{id:1,action:'Resident Registration',user:'Admin',date:'2024-01-15 10:30'}],
            summary:{totalResidents:1250,totalEvacuees:78,activePrograms:5,operationalFacilities:3,recentActivities:23}
        };

        function generatePDFReport(reportType, reportName) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(18); doc.setTextColor(13,27,42);
            doc.text(reportName, 105, 18, { align:'center' });
            doc.setFontSize(10); doc.setTextColor(100,100,100);
            doc.text(`Generated on ${new Date().toLocaleDateString()}`, 105, 26, { align:'center' });
            let y = 40;
            const colMap = {
                residents:['ID','Name','Age','Address','Contact'],
                evacuees:['ID','Family Head','Members','Center','Date'],
                programs:['ID','Program','Participants','Date','Status'],
                facilities:['ID','Facility','Capacity','Occupancy','Status'],
                activities:['ID','Action','User','Date & Time']
            };
            const rowMap = {
                residents: sampleData.residents.map(r=>[r.id,r.name,r.age,r.address,r.contact]),
                evacuees:  sampleData.evacuees.map(e=>[e.id,e.name,e.family,e.center,e.date]),
                programs:  sampleData.programs.map(p=>[p.id,p.name,p.participants,p.date,p.status]),
                facilities:sampleData.facilities.map(f=>[f.id,f.name,f.capacity,f.current,f.status]),
                activities:sampleData.activities.map(a=>[a.id,a.action,a.user,a.date])
            };
            if (reportType === 'summary') {
                doc.setFontSize(12); doc.setTextColor(0,0,0);
                Object.entries(sampleData.summary).forEach(([k,v])=>{ doc.text(`${k}: ${v}`,20,y); y+=8; });
            } else if (colMap[reportType]) {
                doc.autoTable({ head:[colMap[reportType]], body:rowMap[reportType], startY:y, theme:'grid', headStyles:{fillColor:[13,27,42],textColor:255}, styles:{fontSize:10} });
            }
            const pg = doc.internal.pageSize.height;
            doc.setFontSize(8); doc.setTextColor(150,150,150);
            doc.text('B-DEAMS — Barangay Disaster Evacuation Alert Management System', 105, pg-8, { align:'center' });
            doc.save(`${reportName.replace(/\s+/g,'_')}_${new Date().toISOString().slice(0,10)}.pdf`);
        }

        function generateCSVReport(reportType, reportName) {
            let csv = `Report,${reportName}\nDate,${new Date().toLocaleDateString()}\n\n`;
            const colMap = { residents:'ID,Name,Age,Address,Contact', evacuees:'ID,Family Head,Members,Center,Date', programs:'ID,Program,Participants,Date,Status', facilities:'ID,Facility,Capacity,Occupancy,Status', activities:'ID,Action,User,DateTime', summary:'Metric,Value' };
            csv += (colMap[reportType] || '') + '\n';
            if (reportType==='summary') Object.entries(sampleData.summary).forEach(([k,v])=>{ csv+=`${k},${v}\n`; });
            else if (sampleData[reportType]) sampleData[reportType].forEach(r=>{ csv+=Object.values(r).join(',')+'\n'; });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(new Blob([csv],{type:'text/csv'}));
            a.download = `${reportName.replace(/\s+/g,'_')}_${new Date().toISOString().slice(0,10)}.csv`;
            a.click();
        }

        function printReport(reportType, reportName) {
            const w = window.open('','_blank');
            w.document.write(`<!DOCTYPE html><html><head><title>${reportName}</title><style>body{font-family:Arial;margin:20px;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background:#f0f4f8;}</style></head><body><h2>${reportName}</h2><p>Generated: ${new Date().toLocaleDateString()}</p></body></html>`);
            w.document.close();
            setTimeout(()=>{ w.print(); w.close(); },400);
        }
    </script>
</body>
</html>