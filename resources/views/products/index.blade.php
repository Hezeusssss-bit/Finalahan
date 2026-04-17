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



                        <div class="stat-label">Total Family</div>



                    </div>



                    <div class="stat-icon-wrap navy">



                        <i class="fas fa-users"></i>



                    </div>



                </div>



                <div class="stat-value">{{ number_format($totalResidents) }}</div>



                <div class="stat-label">Registered Family</div>



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







        <!-- Data Analytics Dashboard -->



        <div class="analytics-dashboard anim delay-2" style="margin-bottom: 24px;">



            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">



                <h2 style="color: var(--navy); font-size: 18px; font-weight: 600; margin: 0;">



                    <i class="fas fa-chart-line" style="margin-right: 8px; color: var(--teal);"></i>



                    Data Analytics Dashboard



                </h2>



                <div style="display: flex; gap: 8px;">



                    <a href="{{ route('upcoming-assistance-requirements') }}" class="filter-btn" style="padding: 6px 12px; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">



                        <i class="fas fa-sync-alt"></i> View All



                    </a>



                </div>



            </div>



            



            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px;">



                <!-- Upcoming Assistance Requirements -->



                <div class="panel" style="border-radius: 12px;">



                    <div style="padding: 16px; border-bottom: 1px solid var(--border);">



                        <h3 style="color: var(--navy); font-size: 14px; font-weight: 600; margin: 0;">



                            <i class="fas fa-hands-helping" style="color: var(--amber); margin-right: 6px;"></i>



                            Upcoming Assistance Requirements



                        </h3>



                    </div>



                    <div style="padding: 16px;">



                        @php
                            // Use the accurate assistance requirements from controller
                            // This includes proper DSS metrics for Evacuee Programs
                            $assistanceRequirements = $assistanceRequirements ?? [];
                        @endphp

                            @if(count($assistanceRequirements) > 0)

                            <div style="display: grid; grid-template-columns: 1fr; gap: 50px;">



                                @foreach($assistanceRequirements as $requirement)

                                @php

                                    // Check if this is an Evacuee Program for enhanced DSS display

                                    $isEvacueeProgram = isset($requirement['program_title']) && $requirement['program_title'] === 'Evacuee Program';

                                    
                                    // Use accurate DSS metrics from controller for evacuee programs

                                    if ($isEvacueeProgram && isset($requirement['dss_metrics'])) {

                                        $dssMetrics = $requirement['dss_metrics'];

                                        $totalResidents = $requirement['total_residents'] ?? 0;

                                        $dailyMeals = $dssMetrics['daily_meals'] ?? 0;

                                        $waterNeeded = $dssMetrics['water_needed'] ?? 0;

                                        $hygieneKits = $dssMetrics['hygiene_kits'] ?? 0;

                                        $blankets = $dssMetrics['blankets'] ?? 0;

                                        $firstAidKits = $dssMetrics['first_aid_kits'] ?? 0;

                                        

                                        // Get vulnerable group counts

                                        $seniorCount = $requirement['senior_count'] ?? 0;

                                        $pwdCount = $requirement['pwd_count'] ?? 0;

                                        $infantCount = $dssMetrics['infant_count'] ?? 0;

                                        

                                        // Additional detailed needs

                                        $babyFormula = $dssMetrics['baby_formula'] ?? 0;

                                        $diapers = $dssMetrics['diapers'] ?? 0;

                                        $adultDiapers = $dssMetrics['adult_diapers'] ?? 0;

                                        $medicineKits = $dssMetrics['medicine_kits'] ?? 0;

                                        $wheelchairs = $dssMetrics['wheelchairs'] ?? 0;

                                        $walkingCanes = $dssMetrics['walking_canes'] ?? 0;

                                        $riceKilos = $dssMetrics['rice_kilos'] ?? 0;

                                        $cannedGoods = $dssMetrics['canned_goods'] ?? 0;

                                        $instantNoodles = $dssMetrics['instant_noodles'] ?? 0;

                                        $clothingNeeds = $dssMetrics['clothing_needs'] ?? [];

                                        $toiletPaper = $dssMetrics['toilet_paper'] ?? 0;

                                        $soapBars = $dssMetrics['soap_bars'] ?? 0;

                                        $sanitizer = $dssMetrics['sanitizer'] ?? 0;

                                        $sleepingMats = $dssMetrics['sleeping_mats'] ?? 0;

                                        $tarpaulins = $dssMetrics['tarpaulins'] ?? 0;

                                        $rope = $dssMetrics['rope'] ?? 0;

                                    } elseif ($isEvacueeProgram) {

                                        // Fallback to basic calculations if DSS metrics not available

                                        $totalResidents = $requirement['total_residents'] ?? 0;

                                        $dailyMeals = $totalResidents * 3;

                                        $waterNeeded = $totalResidents * 4;

                                        $hygieneKits = ceil($totalResidents * 0.8);

                                        $blankets = ceil($totalResidents * 0.7);

                                        $firstAidKits = ceil($totalResidents / 10);

                                        

                                        $seniorCount = $requirement['senior_count'] ?? 0;

                                        $pwdCount = $requirement['pwd_count'] ?? 0;

                                        $infantCount = 0;

                                        

                                        // Set fallback values for additional needs

                                        $babyFormula = 0; $diapers = 0; $adultDiapers = 0; $medicineKits = 0;

                                        $wheelchairs = 0; $walkingCanes = 0; $riceKilos = 0; $cannedGoods = 0;

                                        $instantNoodles = 0; $clothingNeeds = []; $toiletPaper = 0;

                                        $soapBars = 0; $sanitizer = 0; $sleepingMats = 0; $tarpaulins = 0; $rope = 0;

                                    }

                                @endphp

                                

                                <div style="padding: 12px; background: var(--white); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">

                                        <div>

                                            <div style="font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 4px;">

                                                {{ $requirement['program_title'] }}

                                                @if($isEvacueeProgram)

                                                    <span style="background: var(--teal); color: white; padding: 2px 6px; border-radius: 4px; font-size: 9px; margin-left: 6px;">

                                                        <i class="fas fa-brain" style="font-size: 8px; margin-right: 1px;"></i>DSS

                                                    </span>

                                                @endif

                                            </div>

                                            <div style="font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 6px;">

                                                <i class="fas fa-map-marker-alt" style="color: var(--teal); font-size: 10px;"></i>

                                                {{ $requirement['purok'] }}

                                            </div>

                                        </div>

                                        <div style="font-size: 10px; color: var(--text-muted); background: var(--slate-light); padding: 4px 8px; border-radius: 6px;">

                                            {{ $requirement['start_date'] }}

                                        </div>

                                    </div>



                                    @if($isEvacueeProgram)

                                        <!-- Enhanced DSS Display for Evacuee Programs -->

                                        <div style="margin-bottom: 12px;">

                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">

                                                <div style="text-align: center; padding: 8px; background: linear-gradient(135deg, #e0f7f6 0%, #f0fdf4 100%); border-radius: 8px; border: 1px solid var(--border);">

                                                    <div style="font-size: 18px; font-weight: 700; color: var(--navy);">{{ $totalResidents }}</div>

                                                    <div style="font-size: 9px; color: var(--text-muted);">Total Evacuees</div>

                                                </div>

                                                <div style="text-align: center; padding: 8px; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%); border-radius: 8px; border: 1px solid var(--border);">

                                                    <div style="font-size: 18px; font-weight: 700; color: #92400e;">{{ $dailyMeals }}</div>

                                                    <div style="font-size: 9px; color: var(--text-muted);">Daily Meals</div>

                                                </div>

                                            </div>

                                            

                                            <div style="margin-bottom: 8px;">

                                                <div style="font-size: 10px; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">IMMEDIATE NEEDS:</div>

                                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; font-size: 9px; color: var(--text-mid);">

                                                    <div><i class="fas fa-tint" style="color: var(--blue); margin-right: 2px;"></i>{{ $waterNeeded }}L Water/Day</div>

                                                    <div><i class="fas fa-box" style="color: var(--teal); margin-right: 2px;"></i>{{ $hygieneKits }} Hygiene Kits</div>

                                                    <div><i class="fas fa-bed" style="color: var(--rose); margin-right: 2px;"></i>{{ $blankets }} Blankets</div>

                                                    <div><i class="fas fa-medkit" style="color: var(--green); margin-right: 2px;"></i>{{ $firstAidKits }} First Aid</div>

                                                </div>

                                            </div>

                                            

                                            @if($seniorCount > 0 || $pwdCount > 0 || $infantCount > 0)

                                            <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 6px; padding: 6px; margin-bottom: 8px;">

                                                <div style="font-size: 9px; font-weight: 600; color: #92400e; margin-bottom: 3px;">SPECIAL CARE:</div>

                                                <div style="display: flex; flex-wrap: wrap; gap: 2px;">

                                                    @if($infantCount > 0)

                                                    <span style="background: #f59e0b; color: white; padding: 1px 4px; border-radius: 4px; font-size: 8px;">

                                                        <i class="fas fa-baby" style="font-size: 7px; margin-right: 1px;"></i>{{ $infantCount }} Infants

                                                    </span>

                                                    @endif

                                                    @if($seniorCount > 0)

                                                    <span style="background: #6366f1; color: white; padding: 1px 4px; border-radius: 4px; font-size: 8px;">

                                                        <i class="fas fa-user-clock" style="font-size: 7px; margin-right: 1px;"></i>{{ $seniorCount }} Seniors

                                                    </span>

                                                    @endif

                                                    @if($pwdCount > 0)

                                                    <span style="background: #8b5cf6; color: white; padding: 1px 4px; border-radius: 4px; font-size: 8px;">

                                                        <i class="fas fa-wheelchair" style="font-size: 7px; margin-right: 1px;"></i>{{ $pwdCount }} PWD

                                                    </span>

                                                    @endif

                                                </div>

                                            </div>

                                            @endif

                                        </div>

                                    @else

                                        @if(isset($requirement['assistance_type']) && $requirement['assistance_type'] === 'Educational Assistance')
                                            <!-- Educational Assistance Display - Show Children, Family, Pregnant Women -->
                                            <div style="display: flex; gap: 12px; margin-bottom: 8px;">
                                                <div style="flex: 1; text-align: center; background: #e3f2fd; padding: 8px; border-radius: 8px;">
                                                    <div style="font-size: 16px; font-weight: 700; color: #1565c0;">{{ $requirement['child_count'] ?? 0 }}</div>
                                                    <div style="font-size: 10px; color: var(--text-muted);">Children</div>
                                                </div>
                                                <div style="flex: 1; text-align: center; background: var(--blue-light); padding: 8px; border-radius: 8px;">
                                                    <div style="font-size: 16px; font-weight: 700; color: var(--blue);">{{ $requirement['total_residents'] }}</div>
                                                    <div style="font-size: 10px; color: var(--text-muted);">Family</div>
                                                </div>
                                                <div style="flex: 1; text-align: center; background: #fce4ec; padding: 8px; border-radius: 8px;">
                                                    <div style="font-size: 16px; font-weight: 700; color: #c2185b;">{{ $requirement['pregnant_count'] ?? 0 }}</div>
                                                    <div style="font-size: 10px; color: var(--text-muted);">Pregnant</div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Standard Display for Other Programs - Show Family, PWD, Seniors -->
                                            <div style="display: flex; gap: 12px; margin-bottom: 8px;">
                                                <div style="flex: 1; text-align: center; background: var(--blue-light); padding: 8px; border-radius: 8px;">
                                                    <div style="font-size: 16px; font-weight: 700; color: var(--blue);">{{ $requirement['total_residents'] }}</div>
                                                    <div style="font-size: 10px; color: var(--text-muted);">Family</div>
                                                </div>
                                                <div style="flex: 1; text-align: center; background: var(--amber-light); padding: 8px; border-radius: 8px;">
                                                    <div style="font-size: 16px; font-weight: 700; color: #92400e;">{{ $requirement['pwd_count'] }}</div>
                                                    <div style="font-size: 10px; color: var(--text-muted);">PWD</div>
                                                </div>
                                                <div style="flex: 1; text-align: center; background: var(--green-light); padding: 8px; border-radius: 8px;">
                                                    <div style="font-size: 16px; font-weight: 700; color: #065f46;">{{ $requirement['senior_count'] }}</div>
                                                    <div style="font-size: 10px; color: var(--text-muted);">Seniors</div>
                                                </div>
                                            </div>
                                        @endif

                                    @endif



                                    @if(isset($requirement['specific_needs']))

                                    <div style="border-top: 1px solid var(--border); padding-top: 8px;">

                                        <div style="font-size: 11px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">

                                            <i class="fas fa-clipboard-list" style="margin-right: 4px;"></i>

                                            {{ $isEvacueeProgram ? 'DSS Supply Requirements:' : 'Assistance Needs:' }}

                                        </div>

                                        @if($isEvacueeProgram)
                                            <!-- Enhanced DSS Display for Evacuee Programs -->
                                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                                @if($babyFormula > 0)
                                                <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                    <i class="fas fa-baby-bottle" style="margin-right: 1px;"></i>{{ $babyFormula }} Formula/Day
                                                </div>
                                                @endif
                                                @if($diapers > 0)
                                                <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                    <i class="fas fa-baby" style="margin-right: 1px;"></i>{{ $diapers }} Diapers/Day
                                                </div>
                                                @endif
                                                @if($medicineKits > 0)
                                                <div style="background: #dcfce7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #166534;">
                                                    <i class="fas fa-medkit" style="margin-right: 1px;"></i>{{ $medicineKits }} Medicine Kits
                                                </div>
                                                @endif
                                                @if($wheelchairs > 0)
                                                <div style="background: #dcfce7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #166534;">
                                                    <i class="fas fa-wheelchair" style="margin-right: 1px;"></i>{{ $wheelchairs }} Wheelchairs
                                                </div>
                                                @endif
                                                @if($walkingCanes > 0)
                                                <div style="background: #dcfce7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #166534;">
                                                    <i class="fas fa-walking" style="margin-right: 1px;"></i>{{ $walkingCanes }} Walking Canes
                                                </div>
                                                @endif
                                                @if($riceKilos > 0)
                                                <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                    <i class="fas fa-bowl-rice" style="margin-right: 1px;"></i>{{ $riceKilos }}kg Rice
                                                </div>
                                                @endif
                                                @if($cannedGoods > 0)
                                                <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                    <i class="fas fa-box" style="margin-right: 1px;"></i>{{ $cannedGoods }} Canned Goods
                                                </div>
                                                @endif
                                                @if($sleepingMats > 0)
                                                <div style="background: #f3e8ff; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #6b21a8;">
                                                    <i class="fas fa-bed" style="margin-right: 1px;"></i>{{ $sleepingMats }} Sleeping Mats
                                                </div>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Enhanced Display for Other Programs -->
                                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                                @if(isset($requirement['specific_needs']))
                                                    <!-- Medical Supplies -->
                                                    @if(isset($requirement['specific_needs']['medicine_kits_needed']) && $requirement['specific_needs']['medicine_kits_needed'] > 0)
                                                    <div style="background: #dcfce7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #166534;">
                                                        <i class="fas fa-medkit" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['medicine_kits_needed'] }} Medicine Kits
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['basic_medicine_kits']) && $requirement['specific_needs']['basic_medicine_kits'] > 0)
                                                    <div style="background: #dcfce7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #166534;">
                                                        <i class="fas fa-pills" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['basic_medicine_kits'] }} Basic Medicine
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['vitamin_supplements']) && $requirement['specific_needs']['vitamin_supplements'] > 0)
                                                    <div style="background: #dcfce7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #166534;">
                                                        <i class="fas fa-capsules" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['vitamin_supplements'] }} Vitamins
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['first_aid_kits']) && $requirement['specific_needs']['first_aid_kits'] > 0)
                                                    <div style="background: #dcfce7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #166534;">
                                                        <i class="fas fa-first-aid" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['first_aid_kits'] }} First Aid
                                                    </div>
                                                    @endif
                                                    
                                                    <!-- Medical Equipment -->
                                                    @if(isset($requirement['specific_needs']['wheelchairs_needed']) && $requirement['specific_needs']['wheelchairs_needed'] > 0)
                                                    <div style="background: #e0f2fe; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #0369a1;">
                                                        <i class="fas fa-wheelchair" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['wheelchairs_needed'] }} Wheelchairs
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['walking_aids_needed']) && $requirement['specific_needs']['walking_aids_needed'] > 0)
                                                    <div style="background: #e0f2fe; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #0369a1;">
                                                        <i class="fas fa-walking" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['walking_aids_needed'] }} Walking Aids
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['mobility_aids_needed']) && $requirement['specific_needs']['mobility_aids_needed'] > 0)
                                                    <div style="background: #e0f2fe; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #0369a1;">
                                                        <i class="fas fa-crutch" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['mobility_aids_needed'] }} Mobility Aids
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['blood_pressure_monitors']) && $requirement['specific_needs']['blood_pressure_monitors'] > 0)
                                                    <div style="background: #e0f2fe; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #0369a1;">
                                                        <i class="fas fa-heartbeat" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['blood_pressure_monitors'] }} BP Monitors
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['reading_glasses_needed']) && $requirement['specific_needs']['reading_glasses_needed'] > 0)
                                                    <div style="background: #e0f2fe; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #0369a1;">
                                                        <i class="fas fa-glasses" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['reading_glasses_needed'] }} Reading Glasses
                                                    </div>
                                                    @endif
                                                    
                                                    <!-- Services -->
                                                    @if(isset($requirement['specific_needs']['medical_consultations']) && $requirement['specific_needs']['medical_consultations'] > 0)
                                                    <div style="background: #f3e8ff; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #6b21a8;">
                                                        <i class="fas fa-stethoscope" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['medical_consultations'] }} Consultations
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['transportation_assistance']) && $requirement['specific_needs']['transportation_assistance'] > 0)
                                                    <div style="background: #f3e8ff; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #6b21a8;">
                                                        <i class="fas fa-bus" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['transportation_assistance'] }} Transport
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['medical_supplies_needed']) && $requirement['specific_needs']['medical_supplies_needed'] > 0)
                                                    <div style="background: #f3e8ff; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #6b21a8;">
                                                        <i class="fas fa-band-aid" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['medical_supplies_needed'] }} Medical Supplies
                                                    </div>
                                                    @endif
                                                    
                                                    <!-- Educational Supplies -->
                                                    @if(isset($requirement['specific_needs']['school_supplies_needed']) && $requirement['specific_needs']['school_supplies_needed'] > 0)
                                                    <div style="background: #e0f7fa; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #006064;">
                                                        <i class="fas fa-pencil-ruler" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['school_supplies_needed'] }} School Supplies
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['educational_materials']) && $requirement['specific_needs']['educational_materials'] > 0)
                                                    <div style="background: #e0f7fa; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #006064;">
                                                        <i class="fas fa-book" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['educational_materials'] }} Educational Materials
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['backpacks_needed']) && $requirement['specific_needs']['backpacks_needed'] > 0)
                                                    <div style="background: #e0f7fa; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #006064;">
                                                        <i class="fas fa-backpack" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['backpacks_needed'] }} Backpacks
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['uniform_assistance']) && $requirement['specific_needs']['uniform_assistance'] > 0)
                                                    <div style="background: #e0f7fa; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #006064;">
                                                        <i class="fas fa-tshirt" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['uniform_assistance'] }} Uniforms
                                                    </div>
                                                    @endif
                                                    
                                                    <!-- Food & Supplies -->
                                                    @if(isset($requirement['specific_needs']['food_packages_needed']) && $requirement['specific_needs']['food_packages_needed'] > 0)
                                                    <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                        <i class="fas fa-box" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['food_packages_needed'] }} Food Packs
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['rice_kilos_needed']) && $requirement['specific_needs']['rice_kilos_needed'] > 0)
                                                    <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                        <i class="fas fa-bowl-rice" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['rice_kilos_needed'] }}kg Rice
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['canned_goods_needed']) && $requirement['specific_needs']['canned_goods_needed'] > 0)
                                                    <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                        <i class="fas fa-drumstick-bite" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['canned_goods_needed'] }} Canned Goods
                                                    </div>
                                                    @endif
                                                    @if(isset($requirement['specific_needs']['drinking_water_liters']) && $requirement['specific_needs']['drinking_water_liters'] > 0)
                                                    <div style="background: #fef3c7; padding: 3px 6px; border-radius: 4px; font-size: 9px; color: #92400e;">
                                                        <i class="fas fa-tint" style="margin-right: 1px;"></i>{{ $requirement['specific_needs']['drinking_water_liters'] }}L Water
                                                    </div>
                                                    @endif
                                                @else
                                                    <!-- Default assistance needs when specific_needs is not set -->
                                                    <div style="background: var(--slate-light); padding: 4px 8px; border-radius: 6px; font-size: 10px; color: var(--text-mid);">
                                                        <i class="fas fa-info-circle" style="margin-right: 4px;"></i>
                                                        Standard program supplies and materials needed
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                </div>

                                @endforeach



                            </div>



                        @else



                            <div style="text-align: center; padding: 30px; color: var(--text-muted); font-size: 12px;">



                                <i class="fas fa-clipboard-check" style="font-size: 24px; margin-bottom: 8px; color: var(--text-muted);"></i>



                                <div>No upcoming programs require assistance</div>



                            </div>



                        @endif



                    </div>



                </div>







                <!-- Evacuation Area Analytics -->



                <div class="panel" style="border-radius: 12px;">



                    <div style="padding: 16px; border-bottom: 1px solid var(--border);">



                        <h3 style="color: var(--navy); font-size: 14px; font-weight: 600; margin: 0;">



                            <i class="fas fa-building" style="color: var(--teal); margin-right: 6px;"></i>



                            Evacuation Area Analytics



                        </h3>



                    </div>



                    <div style="padding: 16px;">



                        <div id="evacuationAreaAnalytics">



                            <!-- Evacuation area analytics will be loaded here -->



                            <div style="text-align: center; padding: 20px; color: var(--text-muted);">



                                <i class="fas fa-spinner fa-spin" style="font-size: 20px; margin-bottom: 8px;"></i>



                                <div style="font-size: 12px;">Loading evacuation area analytics...</div>



                            </div>



                        </div>



                    </div>



                </div>







                <!-- Key Insights & Recommendations -->



                <div class="panel" style="border-radius: 12px;">



                    <div style="padding: 16px; border-bottom: 1px solid var(--border);">



                        <h3 style="color: var(--navy); font-size: 14px; font-weight: 600; margin: 0;">



                            <i class="fas fa-lightbulb" style="color: var(--amber); margin-right: 6px;"></i>



                            Key Insights & Recommendations



                        </h3>



                    </div>



                    <div style="padding: 16px;">



                        <!-- Evacuee-Specific Insights -->



                        <div style="background: var(--rose-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--rose); margin-bottom: 16px;">



                            <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">



                                <i class="fas fa-exclamation-triangle" style="color: var(--rose); margin-right: 4px; font-size: 11px;"></i>



                                Evacuee Response Priority



                            </div>



                            <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">



                                <div style="margin-bottom: 4px;">



                                    <strong>Immediate Action Required:</strong> {{ $totalEvacuees > 0 ? 'Activate emergency protocols for ' . $totalEvacuees . ' evacuees' : 'No active evacuees' }}



                                </div>



                                <div style="margin-bottom: 4px;">



                                    <strong>Shelter Capacity:</strong> {{ $totalEvacuees > 0 ? round(($totalEvacuees / 500) * 100) . '% occupancy - ' . ($totalEvacuees > 400 ? 'CRITICAL' : 'MANAGEABLE') : 'No current occupancy' }}



                                </div>



                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">



                                    <i class="fas fa-chart-line" style="margin-right: 2px;"></i>



                                    Based on real-time evacuee data analysis



                                </div>



                            </div>



                        </div>







                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">



                        @php



                            // Dynamic DSS: Analyze actual family data from residents to recommend programs



                            $purokAnalytics = [];



                            



                            // Initialize purok data structure



                            $puroks = ['Purok I', 'Purok II', 'Purok III', 'Purok IV', 'Purok V'];



                            foreach($puroks as $purok) {



                                $purokAnalytics[$purok] = [



                                    'total_families' => 0,



                                    'senior_count' => 0,



                                    'child_count' => 0,



                                    'pregnant_count' => 0,



                                    'pwd_count' => 0,



                                    'no_contact_count' => 0,



                                    'large_family_count' => 0,



                                    'recommendations' => []



                                ];



                            }



                            



                            // Analyze actual resident data



                            if(isset($residents)) {



                                foreach($residents as $resident) {



                                    $purok = $resident->description ?? 'Unassigned';



                                    if(!isset($purokAnalytics[$purok])) {



                                        $purokAnalytics[$purok] = [



                                            'total_families' => 0,



                                            'senior_count' => 0,



                                            'child_count' => 0,



                                            'pregnant_count' => 0,



                                            'pwd_count' => 0,



                                            'no_contact_count' => 0,



                                            'large_family_count' => 0,



                                            'recommendations' => []



                                        ];



                                    }



                                    



                                    $purokAnalytics[$purok]['total_families']++;



                                    



                                    // Count vulnerable members in this family



                                    $familySeniors = 0;



                                    $familyChildren = 0;



                                    $familyPWD = 0;



                                    $isPregnant = false;



                                    



                                    // Check family head



                                    if($resident->family_head_age >= 60) $familySeniors++;



                                    if($resident->family_head_age < 18 && $resident->family_head_age > 0) $familyChildren++;



                                    if($resident->family_head_pwd) $familyPWD++;



                                    



                                    // Check wife



                                    if($resident->wife_age >= 60) $familySeniors++;



                                    if($resident->wife_age < 18 && $resident->wife_age > 0) $familyChildren++;



                                    if($resident->wife_pwd) $familyPWD++;



                                    if($resident->wife_pregnant) $isPregnant = true;



                                    



                                    // Check son



                                    if($resident->son_age >= 60) $familySeniors++;



                                    if($resident->son_age < 18 && $resident->son_age > 0) $familyChildren++;



                                    if($resident->son_pwd) $familyPWD++;



                                    



                                    // Check daughter



                                    if($resident->daughter_age >= 60) $familySeniors++;



                                    if($resident->daughter_age < 18 && $resident->daughter_age > 0) $familyChildren++;



                                    if($resident->daughter_pwd) $familyPWD++;



                                    



                                    // Check grandparents



                                    if($resident->grandmother_age >= 60) $familySeniors++;



                                    if($resident->grandmother_age < 18 && $resident->grandmother_age > 0) $familyChildren++;



                                    if($resident->grandmother_pwd) $familyPWD++;



                                    



                                    if($resident->grandfather_age >= 60) $familySeniors++;



                                    if($resident->grandfather_age < 18 && $resident->grandfather_age > 0) $familyChildren++;



                                    if($resident->grandfather_pwd) $familyPWD++;



                                    



                                    // Update purok counts



                                    $purokAnalytics[$purok]['senior_count'] += $familySeniors;



                                    $purokAnalytics[$purok]['child_count'] += $familyChildren;



                                    $purokAnalytics[$purok]['pwd_count'] += $familyPWD;



                                    if($isPregnant) $purokAnalytics[$purok]['pregnant_count']++;



                                    



                                    // Check contact



                                    if(!$resident->contact_number) $purokAnalytics[$purok]['no_contact_count']++;



                                    



                                    // Check family size



                                    $memberCount = 1; // family head



                                    if($resident->wife_fullname) $memberCount++;



                                    if($resident->son_fullname) $memberCount++;



                                    if($resident->daughter_fullname) $memberCount++;



                                    if($resident->grandmother_fullname) $memberCount++;



                                    if($resident->grandfather_fullname) $memberCount++;



                                    



                                    if($memberCount >= 5) $purokAnalytics[$purok]['large_family_count']++;



                                    



                                    // Generate recommendations based on analysis



                                    $recommendations = [];



                                    



                                    // Senior-focused programs with specific interventions
                                    if($familySeniors > 0) {
                                        $recommendations[] = 'Senior Citizen Care';
                                        $recommendations[] = 'Medical Mission';
                                        $recommendations[] = 'Elderly Mobility Assistance';
                                        if($familySeniors >= 2) {
                                            $recommendations[] = 'Chronic Medication Management';
                                        }
                                    }
                                    
                                    // Child-focused programs with age-specific interventions
                                    if($familyChildren > 0) {
                                        $recommendations[] = 'Child Protection';
                                        $recommendations[] = 'Educational Support';
                                        // Check for infants in the family
                                        $hasInfant = false;
                                        if($resident->son_age > 0 && $resident->son_age <= 5) $hasInfant = true;
                                        if($resident->daughter_age > 0 && $resident->daughter_age <= 5) $hasInfant = true;
                                        if($hasInfant) {
                                            $recommendations[] = 'Infant Care Program';
                                            $recommendations[] = 'Baby Formula Distribution';
                                        }
                                        if($familyChildren >= 2) {
                                            $recommendations[] = 'Youth Development Activities';
                                        }
                                    }
                                    
                                    // PWD programs with accessibility focus
                                    if($familyPWD > 0) {
                                        $recommendations[] = 'PWD Assistance';
                                        $recommendations[] = 'Accessibility Programs';
                                        $recommendations[] = 'Mobility Equipment Support';
                                        if($familyPWD >= 2) {
                                            $recommendations[] = 'Special Needs Transportation';
                                        }
                                    }
                                    
                                    // Pregnancy programs with comprehensive care
                                    if($isPregnant) {
                                        $recommendations[] = 'Maternal Health';
                                        $recommendations[] = 'Nutrition Program';
                                        $recommendations[] = 'Prenatal Care Services';
                                        $recommendations[] = 'Pregnancy Nutrition Supplements';
                                    }
                                    
                                    // Large family support with economic assistance
                                    if($memberCount >= 5) {
                                        $recommendations[] = 'Food Security';
                                        $recommendations[] = 'Livelihood Training';
                                        $recommendations[] = 'Family Economic Assistance';
                                        if($memberCount >= 7) {
                                            $recommendations[] = 'Housing Support Program';
                                        }
                                    }
                                    
                                    // No contact - need communication programs with urgency
                                    if(!$resident->contact_number) {
                                        $recommendations[] = 'Community Outreach';
                                        $recommendations[] = 'Contact Registration';
                                        $recommendations[] = 'Emergency Contact Update';
                                        $recommendations[] = 'Communication Access Program';
                                    }
                                    
                                    // Purok-specific interventions based on location
                                    if($purok === 'Purok I') {
                                        $recommendations[] = 'High-Density Area Management';
                                        // Check if this purok has high population based on families
                                        if(isset($purokAnalytics[$purok]['total_families']) && $purokAnalytics[$purok]['total_families'] > 10) {
                                            $recommendations[] = 'Resource Allocation Optimization';
                                        }
                                    } elseif($purok === 'Purok II') {
                                        $recommendations[] = 'Senior-Friendly Community Programs';
                                        // Check if this purok has many seniors
                                        if(isset($purokAnalytics[$purok]['senior_count']) && $purokAnalytics[$purok]['senior_count'] > 5) {
                                            $recommendations[] = 'Elderly Medical Priority';
                                        }
                                    } elseif($purok === 'Purok III') {
                                        $recommendations[] = 'Contact Information Campaign';
                                        // Check if this purok has many families without contact info
                                        if(isset($purokAnalytics[$purok]['no_contact_count']) && $purokAnalytics[$purok]['no_contact_count'] > 2) {
                                            $recommendations[] = 'Communication Protocol Update';
                                        }
                                    } elseif($purok === 'Purok IV') {
                                        $recommendations[] = 'Children Evacuation Planning';
                                        // Check if this purok has many children
                                        if(isset($purokAnalytics[$purok]['child_count']) && $purokAnalytics[$purok]['child_count'] > 8) {
                                            $recommendations[] = 'Child Safety Initiative';
                                        }
                                    } elseif($purok === 'Purok V') {
                                        $recommendations[] = 'Family Resource Distribution';
                                        // Check if this purok has many large families
                                        if(isset($purokAnalytics[$purok]['large_family_count']) && $purokAnalytics[$purok]['large_family_count'] > 1) {
                                            $recommendations[] = 'Large Family Support Network';
                                        }
                                    }
                                    
                                    // Default programs if no specific needs
                                    if(empty($recommendations)) {
                                        $recommendations = ['Youth Development', 'Skills Training', 'Community Building', 'Disaster Preparedness', 'Health Awareness Campaign'];
                                    }

                                    



                                    // Add to purok recommendations (avoid duplicates)



                                    foreach($recommendations as $rec) {



                                        if(!in_array($rec, $purokAnalytics[$purok]['recommendations'])) {



                                            $purokAnalytics[$purok]['recommendations'][] = $rec;



                                        }



                                    }



                                }



                            }



                        @endphp
                        
                        @php
                        // Use the same dssMetrics structure as EvacueeProgram for accurate family-based calculations
                        $totalMembers = $dssMetrics['total_family_members'] ?? 0;
                        $totalSeniors = $dssMetrics['senior_count'] ?? 0;
                        $totalChildren = $dssMetrics['child_count'] ?? 0;
                        $totalPregnant = $dssMetrics['pregnant_women_count'] ?? 0;
                        $totalPWD = $dssMetrics['disabled_persons_count'] ?? 0;
                        
                        // For infants, estimate based on children breakdown from dssMetrics if available
                        $totalInfants = 0;
                        if(isset($dssMetrics['clothing_inventory_children_0_5'])) {
                            $totalInfants = $dssMetrics['clothing_inventory_children_0_5'];
                        } else {
                            // Fallback: estimate infants as 25% of total children
                            $totalInfants = floor($totalChildren * 0.25);
                        }
                        
                        // Calculate remaining children (non-infants)
                        $totalChildrenNonInfants = $totalChildren - $totalInfants;
                        @endphp
                        
                        @php
                        // Calculate assistance requirements for Medical Mission based on actual demographics
                        $assistanceRequirements = [];
                        
                        // Get upcoming programs from residents data
                        if(isset($residents)) {
                            $upcomingPrograms = [];
                            
                            foreach($residents as $resident) {
                                $programDate = '2026-04-14'; // From the image
                                $purok = $resident->description ?? 'Unassigned';
                                
                                // Count demographics for this family
                                $familySeniors = 0;
                                $familyPWD = 0;
                                $familyChildren = 0;
                                $totalMembers = 0;
                                
                                // Check family head
                                if($resident->family_head_age >= 60) { $familySeniors++; $totalMembers++; }
                                if($resident->family_head_age < 18 && $resident->family_head_age > 0) { $familyChildren++; $totalMembers++; }
                                if($resident->family_head_pwd) { $familyPWD++; $totalMembers++; }
                                
                                // Check wife
                                if($resident->wife_fullname) {
                                    $totalMembers++;
                                    if($resident->wife_age >= 60) $familySeniors++;
                                    if($resident->wife_age < 18 && $resident->wife_age > 0) $familyChildren++;
                                    if($resident->wife_pwd) $familyPWD++;
                                }
                                
                                // Check other family members
                                $otherMembers = ['son', 'daughter', 'grandmother', 'grandfather'];
                                foreach($otherMembers as $member) {
                                    $ageField = $member . '_age';
                                    $pwdField = $member . '_pwd';
                                    $nameField = $member . '_fullname';
                                    
                                    if($resident->$nameField) {
                                        $totalMembers++;
                                        if($resident->$ageField >= 60) $familySeniors++;
                                        if($resident->$ageField < 18 && $resident->$ageField > 0) $familyChildren++;
                                        if($resident->$pwdField) $familyPWD++;
                                    }
                                }
                                
                                // Calculate specific needs for Medical Mission
                                $specificNeeds = [];
                                
                                // Medical Mission specific calculations
                                if($familySeniors > 0) {
                                    $specificNeeds['medicine_kits_needed'] = max(1, ceil($familySeniors * 0.5));
                                    $specificNeeds['blood_pressure_monitors'] = max(1, ceil($familySeniors * 0.3));
                                    $specificNeeds['reading_glasses_needed'] = max(1, ceil($familySeniors * 0.4));
                                }
                                
                                if($familyPWD > 0) {
                                    $specificNeeds['wheelchairs_needed'] = max(1, ceil($familyPWD * 0.5));
                                }
                                
                                if($familyChildren > 0) {
                                    $specificNeeds['pediatric_supplies_needed'] = max(1, ceil($familyChildren * 0.3));
                                }
                                
                                // Base medical supplies (always needed for medical mission)
                                $specificNeeds['first_aid_kits_needed'] = max(2, ceil($totalMembers * 0.4));
                                $specificNeeds['medical_supplies_needed'] = max(1, ceil($totalMembers * 0.3));
                                $specificNeeds['disinfectant_needed'] = max(1, ceil($totalMembers * 0.2));
                                
                                // Add to assistance requirements
                                $upcomingPrograms[] = [
                                    'program_title' => 'Medical Mission',
                                    'purok' => $purok,
                                    'start_date' => $programDate,
                                    'total_residents' => $totalMembers,
                                    'pwd_count' => $familyPWD,
                                    'senior_count' => $familySeniors,
                                    'specific_needs' => $specificNeeds
                                ];
                            }
                            
                            // Filter for Medical Mission in Purok I on Apr 14, 2026
                            $medicalMissionRequirements = array_filter($upcomingPrograms, function($program) {
                                return $program['program_title'] === 'Medical Mission' && 
                                       $program['purok'] === 'Purok I' && 
                                       $program['start_date'] === '2026-04-14';
                            });
                            
                            $assistanceRequirements = $medicalMissionRequirements;
                        }
                        @endphp
                        
                        <!-- Display program recommendations based on actual data analysis -->



                        <div style="background: var(--slate-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--amber);">



                            <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">



                                <i class="fas fa-map-marker-alt" style="color: var(--amber); margin-right: 4px; font-size: 11px;"></i>



                                Purok I



                            </div>



                            <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">



                                <div style="margin-bottom: 4px;">



                                    @php
                                        $purokIRecommendations = 'No specific recommendations';
                                        $purokIRecs = $purokAnalytics['Purok I']['recommendations'] ?? [];
                                        if(!empty($purokIRecs) && is_array($purokIRecs)) {
                                            $purokIRecommendations = implode(', ', array_slice($purokIRecs, 0, 2));
                                            if(count($purokIRecs) > 2) {
                                                $purokIRecommendations .= ' +' . (count($purokIRecs) - 2) . ' more';
                                            }
                                        }
                                    @endphp
                                    {{ $purokIRecommendations }}



                                </div>



                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">



                                    <i class="fas fa-chart-line" style="margin-right: 2px;"></i>



                                    Based on family data analysis



                                </div>



                            </div>



                        </div>



                        



                        <div style="background: var(--slate-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--amber);">



                            <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">



                                <i class="fas fa-map-marker-alt" style="color: var(--amber); margin-right: 4px; font-size: 11px;"></i>



                                Purok II



                            </div>



                            <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">



                                <div style="margin-bottom: 4px;">



                                    @php
                                        $purokIIRecommendations = 'No specific recommendations';
                                        $purokIIRecs = $purokAnalytics['Purok II']['recommendations'] ?? [];
                                        if(!empty($purokIIRecs) && is_array($purokIIRecs)) {
                                            $purokIIRecommendations = implode(', ', array_slice($purokIIRecs, 0, 2));
                                            if(count($purokIIRecs) > 2) {
                                                $purokIIRecommendations .= ' +' . (count($purokIIRecs) - 2) . ' more';
                                            }
                                        }
                                    @endphp
                                    {{ $purokIIRecommendations }}



                                </div>



                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">



                                    <i class="fas fa-chart-line" style="margin-right: 2px;"></i>



                                    Based on family data analysis



                                </div>



                            </div>



                        </div>



                        



                        <div style="background: var(--slate-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--amber);">



                            <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">



                                <i class="fas fa-map-marker-alt" style="color: var(--amber); margin-right: 4px; font-size: 11px;"></i>



                                Purok III



                            </div>



                            <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">



                                <div style="margin-bottom: 4px;">



                                    @php
                                        $purokIIIRecommendations = 'No specific recommendations';
                                        $purokIIIRecs = $purokAnalytics['Purok III']['recommendations'] ?? [];
                                        if(!empty($purokIIIRecs) && is_array($purokIIIRecs)) {
                                            $purokIIIRecommendations = implode(', ', array_slice($purokIIIRecs, 0, 2));
                                            if(count($purokIIIRecs) > 2) {
                                                $purokIIIRecommendations .= ' +' . (count($purokIIIRecs) - 2) . ' more';
                                            }
                                        }
                                    @endphp
                                    {{ $purokIIIRecommendations }}



                                </div>



                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">



                                    <i class="fas fa-chart-line" style="margin-right: 2px;"></i>



                                    Based on family data analysis



                                </div>



                            </div>



                        </div>



                        



                        <div style="background: var(--slate-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--amber);">



                            <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">



                                <i class="fas fa-map-marker-alt" style="color: var(--amber); margin-right: 4px; font-size: 11px;"></i>



                                Purok IV



                            </div>



                            <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">



                                <div style="margin-bottom: 4px;">



                                    @php
                                        $purokIVRecommendations = 'No specific recommendations';
                                        $purokIVRecs = $purokAnalytics['Purok IV']['recommendations'] ?? [];
                                        if(!empty($purokIVRecs) && is_array($purokIVRecs)) {
                                            $purokIVRecommendations = implode(', ', array_slice($purokIVRecs, 0, 2));
                                            if(count($purokIVRecs) > 2) {
                                                $purokIVRecommendations .= ' +' . (count($purokIVRecs) - 2) . ' more';
                                            }
                                        }
                                    @endphp
                                    {{ $purokIVRecommendations }}



                                </div>



                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">



                                    <i class="fas fa-chart-line" style="margin-right: 2px;"></i>



                                    Based on family data analysis



                                </div>



                            </div>



                        </div>



                        



                        <div style="background: var(--slate-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--amber);">



                            <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">



                                <i class="fas fa-map-marker-alt" style="color: var(--amber); margin-right: 4px; font-size: 11px;"></i>



                                Purok V



                            </div>



                            <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">



                                <div style="margin-bottom: 4px;">



                                    @php
                                        $purokVRecommendations = 'No specific recommendations';
                                        $purokVRecs = $purokAnalytics['Purok V']['recommendations'] ?? [];
                                        if(!empty($purokVRecs) && is_array($purokVRecs)) {
                                            $purokVRecommendations = implode(', ', array_slice($purokVRecs, 0, 2));
                                            if(count($purokVRecs) > 2) {
                                                $purokVRecommendations .= ' +' . (count($purokVRecs) - 2) . ' more';
                                            }
                                        }
                                    @endphp
                                    {{ $purokVRecommendations }}



                                </div>



                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">



                                    <i class="fas fa-chart-line" style="margin-right: 2px;"></i>



                                    Based on family data analysis



                                </div>



                            </div>



                        </div>



                    </div>



                </div>



            </div>



        </div>







        <!-- Evacuee Aid Distribution Requirements -->



        <div class="panel anim delay-2" style="margin-bottom: 24px;">



            <div class="panel-head">



                <div class="panel-title">



                    <i class="fas fa-truck-loading"></i> Evacuee Aid Distribution Requirements



                </div>



                <div style="display: flex; gap: 8px;">



                    <button class="btn-submit green" onclick="generateDistributionPlan()" style="padding: 6px 12px; font-size: 12px;">



                        <i class="fas fa-download"></i> Download Plan



                    </button>



                </div>



            </div>



            <div class="panel-body">



                <div id="evacueeAidContent">



                    <!-- Aid distribution content will be loaded here -->



                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 20px;">



                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; text-align: center;">



                            <div style="font-size: 28px; font-weight: 700; color: var(--navy);" id="evacueeTotal">-</div>



                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total Evacuees</div>



                        </div>



                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; text-align: center;">



                            <div style="font-size: 28px; font-weight: 700; color: var(--teal);" id="dailyMeals">-</div>



                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Daily Meals</div>



                        </div>



                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; text-align: center;">



                            <div style="font-size: 28px; font-weight: 700; color: var(--blue);" id="waterLiters">-</div>



                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Water (Liters)</div>



                        </div>



                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; text-align: center;">



                            <div style="font-size: 28px; font-weight: 700; color: var(--amber);" id="hygieneKits">-</div>



                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Hygiene Kits</div>



                        </div>



                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; text-align: center;">



                            <div style="font-size: 28px; font-weight: 700; color: var(--rose);" id="blanketCount">-</div>



                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Blankets</div>



                        </div>



                    </div>



                    



                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">



                        <div style="background: var(--blue-light); padding: 16px; border-radius: 12px; border-left: 4px solid var(--blue);">



                            <div style="font-weight: 600; color: var(--navy); font-size: 14px; margin-bottom: 8px;">



                                <i class="fas fa-exclamation-triangle" style="color: var(--amber); margin-right: 6px;"></i>



                                Critical Requirements



                            </div>



                            <div id="criticalRequirements" style="font-size: 12px; color: var(--text-mid); line-height: 1.5;">



                                Click "Calculate Needs" to determine critical aid requirements



                            </div>



                        </div>



                        



                        <div style="background: var(--amber-light); padding: 16px; border-radius: 12px; border-left: 4px solid var(--amber);">



                            <div style="font-weight: 600; color: var(--navy); font-size: 14px; margin-bottom: 8px;">



                                <i class="fas fa-users" style="color: var(--amber); margin-right: 6px;"></i>



                                Vulnerable Groups



                            </div>



                            <div id="vulnerableGroups" style="font-size: 12px; color: var(--text-mid); line-height: 1.5;">



                                Click "Calculate Needs" to analyze vulnerable group requirements



                            </div>



                        </div>



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



                        <option value="residents">All Family Report</option>



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







            const names = { residents:'All Family Report', evacuees:'Evacuees Report', programs:'Programs Report', facilities:'Facilities Report', activities:'Activity Logs Report', summary:'Dashboard Summary Report' };







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




        // ── Evacuee Aid Distribution Functions ──



        function calculateEvacueeAidNeeds() {
            showToast('Fetching real-time evacuee data...');
            
            // Show loading state
            document.getElementById('evacueeTotal').textContent = '...';
            document.getElementById('dailyMeals').textContent = '...';
            document.getElementById('waterLiters').textContent = '...';
            document.getElementById('hygieneKits').textContent = '...';
            document.getElementById('blanketCount').textContent = '...';
            document.getElementById('criticalRequirements').innerHTML = '<div style="text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin" style="margin-bottom: 8px;"></i><div>Fetching real-time data...</div></div>';
            document.getElementById('vulnerableGroups').innerHTML = '<div style="text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin" style="margin-bottom: 8px;"></i><div>Analyzing demographics...</div></div>';
            
            // Fetch fresh data from backend (same as EvacueeProgram.blade.php)
            fetch('/api/analytics-data')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Process real-time evacuee data
                        const evacueeData = processRealTimeEvacueeData(data.evacuees, data.facilities, data.dssMetrics);
                        const needs = calculateAidRequirementsFromRealData(evacueeData, data.dssMetrics);
                        displayAidRequirements(needs, evacueeData);
                        showToast('Aid requirements calculated with real-time data');
                    } else {
                        throw new Error(data.message || 'Failed to fetch evacuee data');
                    }
                })
                .catch(error => {
                    console.error('Error fetching evacuee data:', error);
                    // Fallback to static data if API fails
                    const evacueeData = {
                        totalEvacuees: {{ $totalMembers ?? $totalEvacuees }},
                        totalFamilyMembers: {{ $totalMembers ?? 0 }},
                        demographics: {
                            seniors: {{ $totalSeniors ?? 0 }},
                            children: {{ $totalChildrenNonInfants ?? $totalChildren ?? 0 }},
                            infants: {{ $totalInfants ?? 0 }},
                            pregnant: {{ $totalPregnant ?? 0 }},
                            pwd: {{ $totalPWD ?? 0 }}
                        },
                        dssMetrics: @json($dssMetrics ?? [])
                    };
                    const needs = calculateAidRequirements(evacueeData);
                    displayAidRequirements(needs, evacueeData);
                    showToast('Using cached data - real-time fetch failed', 'warning');
                });
        }

        // Process real-time evacuee data (from EvacueeProgram.blade.php)
        function processRealTimeEvacueeData(evacuees, facilities, dssMetrics) {
            // Group evacuees by evacuation area
            const areaGroups = {};
            
            evacuees.forEach(evacuee => {
                const area = evacuee.evacuation_area || 'Unknown';
                if (!areaGroups[area]) {
                    areaGroups[area] = {
                        area: area,
                        evacuees: [],
                        totalMembers: 0,
                        maleCount: 0,
                        femaleCount: 0,
                        seniorCount: 0,
                        childCount: 0,
                        infantCount: 0,
                        pregnantCount: 0,
                        pwdCount: 0,
                        chronicCount: 0,
                        rooms: new Set(),
                        dailyMealsNeeded: 0,
                        waterNeeded: 0,
                        hygieneKitsNeeded: 0,
                        blanketsNeeded: 0
                    };
                }
                
                const group = areaGroups[area];
                group.evacuees.push(evacuee);
                group.totalMembers += evacuee.total_members || 1;
                
                // Count demographics from family members for accuracy
                if (evacuee.family_members && Array.isArray(evacuee.family_members)) {
                    evacuee.family_members.forEach(member => {
                        const age = parseInt(member.age) || 0;
                        const gender = member.gender || 'Male';
                        
                        if (gender === 'Male') group.maleCount++;
                        else group.femaleCount++;
                        
                        if (age >= 60) group.seniorCount++;
                        else if (age < 18) group.childCount++;
                        if (age <= 5) group.infantCount++;
                        
                        if (member.pregnant) group.pregnantCount++;
                        if (member.pwd) group.pwdCount++;
                        if (member.chronic_illness) group.chronicCount++;
                        
                        // Calculate needs based on actual family member ages
                        group.dailyMealsNeeded += calculateDailyMeals(age, 1);
                        group.waterNeeded += 4; // 4 liters per person per day
                        group.hygieneKitsNeeded += Math.ceil(1 * 0.8);
                        group.blanketsNeeded += Math.ceil(1 * 0.7);
                    });
                } else {
                    // Fallback to family head data if family members not available
                    if (evacuee.gender === 'Male') group.maleCount++;
                    else group.femaleCount++;
                    
                    if (evacuee.age >= 60) group.seniorCount++;
                    else if (evacuee.age < 18) group.childCount++;
                    if (evacuee.age <= 5) group.infantCount++;
                    
                    group.pregnantCount += evacuee.pregnant_count || 0;
                    group.pwdCount += evacuee.pwd_count || 0;
                    
                    // Calculate needs
                    const familySize = evacuee.total_members || 1;
                    group.dailyMealsNeeded += calculateDailyMeals(evacuee.age, familySize);
                    group.waterNeeded += familySize * 4; // 4 liters per person per day
                    group.hygieneKitsNeeded += Math.ceil(familySize * 0.8);
                    group.blanketsNeeded += Math.ceil(familySize * 0.7);
                }
                
                if (evacuee.room_number) group.rooms.add(evacuee.room_number);
            });
            
            // Calculate totals across all areas
            const totals = {
                totalEvacuees: 0,
                totalFamilyMembers: 0,
                totalMaleCount: 0,
                totalFemaleCount: 0,
                totalSeniorCount: 0,
                totalChildCount: 0,
                totalInfantCount: 0,
                totalPregnantCount: 0,
                totalPwdCount: 0,
                totalChronicCount: 0,
                totalDailyMeals: 0,
                totalWaterNeeded: 0,
                totalHygieneKits: 0,
                totalBlankets: 0,
                areas: Object.values(areaGroups)
            };
            
            Object.values(areaGroups).forEach(area => {
                totals.totalEvacuees += area.evacuees.length;
                totals.totalFamilyMembers += area.totalMembers;
                totals.totalMaleCount += area.maleCount;
                totals.totalFemaleCount += area.femaleCount;
                totals.totalSeniorCount += area.seniorCount;
                totals.totalChildCount += area.childCount;
                totals.totalInfantCount += area.infantCount;
                totals.totalPregnantCount += area.pregnantCount;
                totals.totalPwdCount += area.pwdCount;
                totals.totalChronicCount += area.chronicCount;
                totals.totalDailyMeals += area.dailyMealsNeeded;
                totals.totalWaterNeeded += area.waterNeeded;
                totals.totalHygieneKits += area.hygieneKitsNeeded;
                totals.totalBlankets += area.blanketsNeeded;
            });
            
            return totals;
        }

        function calculateDailyMeals(age, familySize) {
            let mealsPerPerson = 3; // Default for adults
            
            if (age <= 2) mealsPerPerson = 6; // Infants: 6 small meals
            else if (age <= 12) mealsPerPerson = 5; // Children: 3 meals + 2 snacks
            else if (age <= 17) mealsPerPerson = 3; // Teens: 3 meals
            
            return mealsPerPerson * familySize;
        }

        // Calculate aid requirements from real-time data (enhanced version from EvacueeProgram)
        function calculateAidRequirementsFromRealData(evacueeData, dssMetrics) {
            const total = evacueeData.totalFamilyMembers;
            const demo = {
                seniors: evacueeData.totalSeniorCount,
                children: evacueeData.totalChildCount,
                infants: evacueeData.totalInfantCount,
                pregnant: evacueeData.totalPregnantCount,
                pwd: evacueeData.totalPwdCount
            };

            // Use real-time meal calculations
            const totalDailyMeals = evacueeData.totalDailyMeals;

            const criticalRequirements = [
                `Immediate food supply for ${totalDailyMeals} daily meals (based on actual age demographics)`,
                `${evacueeData.totalWaterNeeded} liters water per day (4L per person)`,
                `${Math.ceil(total / 25)} sanitation facilities needed (1 per 25 people)`,
                `${Math.ceil(demo.seniors * 0.3)} medical staff for elderly care`,
                `${Math.ceil(demo.infants * 0.5)} caregivers for infant support`,
                `${Math.ceil(demo.pwd * 0.4)} accessibility assistants`,
                `${Math.ceil(demo.pregnant * 0.3)} maternal health specialists`
            ];

            if (demo.seniors > 0) {
                criticalRequirements.push(`${Math.ceil(demo.seniors * 0.6)} chronic medication management kits`);
                criticalRequirements.push(`${Math.ceil(demo.seniors * 0.4)} mobility assistance devices`);
            }

            if (demo.infants > 0) {
                criticalRequirements.push(`${demo.infants * 7} baby formula cans per week`);
                criticalRequirements.push(`${demo.infants * 3} diaper packs per week`);
            }

            if (demo.pregnant > 0) {
                criticalRequirements.push(`${demo.pregnant} prenatal care packages`);
                criticalRequirements.push(`${Math.ceil(demo.pregnant * 2)} nutrition supplement kits`);
            }

            const vulnerableGroups = [];

            if (demo.seniors > 0) {
                vulnerableGroups.push(`${demo.seniors} elderly residents (60+) requiring medical attention, mobility assistance, and special dietary needs`);
            }

            if (demo.infants > 0) {
                vulnerableGroups.push(`${demo.infants} infants (0-5 years) needing formula, diapers, pediatric care, and constant supervision`);
            }

            if (demo.children > 0) {
                vulnerableGroups.push(`${demo.children} children (6-17 years) requiring educational support, child protection services, and recreational activities`);
            }

            if (demo.pregnant > 0) {
                vulnerableGroups.push(`${demo.pregnant} pregnant women requiring prenatal care, nutrition supplements, and maternal health monitoring`);
            }

            if (demo.pwd > 0) {
                vulnerableGroups.push(`${demo.pwd} persons with disabilities needing accessibility support, specialized equipment, and inclusive services`);
            }

            if (evacueeData.totalChronicCount > 0) {
                vulnerableGroups.push(`${evacueeData.totalChronicCount} chronic illness patients requiring ongoing medication and regular medical monitoring`);
            }

            return {
                totalEvacuees: evacueeData.totalEvacuees,
                totalFamilyMembers: evacueeData.totalFamilyMembers,
                dailyMeals: totalDailyMeals,
                waterLiters: evacueeData.totalWaterNeeded,
                hygieneKits: evacueeData.totalHygieneKits,
                blankets: evacueeData.totalBlankets,
                criticalRequirements: criticalRequirements,
                vulnerableGroups: vulnerableGroups,
                areaBreakdown: evacueeData.areas.map(area => ({
                    name: area.area,
                    evacuees: area.evacuees.length,
                    members: area.totalMembers,
                    meals: area.dailyMealsNeeded,
                    water: area.waterNeeded,
                    hygiene: area.hygieneKitsNeeded,
                    blankets: area.blanketsNeeded
                }))
            };
        }

function displayAidRequirements(needs, data) {
    // Handle both real-time data and fallback data structures
    const totalEvacuees = data.totalEvacuees || data.totalFamilyMembers || 0;
    const totalFamilyMembers = data.totalFamilyMembers || data.totalEvacuees || 0;
    
    document.getElementById('evacueeTotal').textContent = totalEvacuees.toLocaleString();
    document.getElementById('dailyMeals').textContent = needs.dailyMeals.toLocaleString();
    document.getElementById('waterLiters').textContent = needs.waterLiters.toLocaleString();
    document.getElementById('hygieneKits').textContent = needs.hygieneKits.toLocaleString();
    document.getElementById('blanketCount').textContent = needs.blankets.toLocaleString();

    const criticalDiv = document.getElementById('criticalRequirements');
    criticalDiv.innerHTML = needs.criticalRequirements.map(req => 
        `<div style="margin-bottom: 6px;">· <strong>${req}</strong></div>`
    ).join('');

    const vulnerableDiv = document.getElementById('vulnerableGroups');
    vulnerableDiv.innerHTML = needs.vulnerableGroups.map(group => 
        `<div style="margin-bottom: 6px;">· ${group}</div>`
    ).join('');
    
    // Display area breakdown if available (real-time data feature)
    if (needs.areaBreakdown && needs.areaBreakdown.length > 0) {
        const areaHtml = needs.areaBreakdown.map(area => 
            `<div style="background: var(--slate-light); padding: 12px; border-radius: 8px; margin-bottom: 8px;">
                <div style="font-weight: 600; color: var(--text-dark); margin-bottom: 4px;">${area.name}</div>
                <div style="font-size: 12px; color: var(--text-muted);">
                    Families: ${area.evacuees} | Members: ${area.members} | 
                    Meals: ${area.meals} | Water: ${area.water}L | 
                    Hygiene: ${area.hygiene} | Blankets: ${area.blankets}
                </div>
            </div>`
        ).join('');
        
        // Add area breakdown after vulnerable groups
        vulnerableDiv.innerHTML += `
            <div style="margin-top: 16px; padding-top: 12px; border-top: 1px solid var(--border);">
                <div style="font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                    <i class="fas fa-map-marked-alt" style="color: var(--teal); margin-right: 6px;"></i>
                    Evacuation Area Breakdown
                </div>
                ${areaHtml}
            </div>
        `;
    }
}

// Add refresh functionality for evacuee aid data
function refreshEvacueeAidData() {
    calculateEvacueeAidNeeds();
}

// Auto-calculate evacuee aid requirements on page load
document.addEventListener('DOMContentLoaded', function() {
    // Delay slightly to ensure all elements are loaded
    setTimeout(() => {
        calculateEvacueeAidNeeds();
    }, 1000);
});

function generateDistributionPlan() {
    showToast('Generating comprehensive distribution plan...');

    setTimeout(() => {
        const evacueeCount = {{ $totalEvacuees }};
        const planContent = `EVACUEE AID DISTRIBUTION PLAN



B-DEAMS - Barangay Disaster Evacuation Alert Management System



Generated: ${new Date().toLocaleString()}



Total Evacuees: ${evacueeCount}







=== IMMEDIATE DISTRIBUTION REQUIREMENTS ===







FOOD DISTRIBUTION:



• Daily Meals Required: ${evacueeCount * 3} meals



• Weekly Food Supply: ${evacueeCount * 21} meals



• Emergency Rations: ${evacueeCount * 2} 3-day supply packs



• Special Dietary Needs:



  - Infant Formula: ${Math.ceil(evacueeCount * 0.15)} cans



  - Baby Food: ${Math.ceil(evacueeCount * 0.1)} jars



  - Soft/Easy to digest meals: ${Math.ceil(evacueeCount * 0.25)} portions







WATER AND SANITATION:



• Daily Water Requirement: ${evacueeCount * 4} liters



• Weekly Water Supply: ${evacueeCount * 28} liters



• Water Containers: ${Math.ceil(evacueeCount / 5)} units



• Sanitation Facilities: ${Math.ceil(evacueeCount / 25)} units



• Waste Management: ${Math.ceil(evacueeCount / 30)} bins







SHELTER AND COMFORT:



• Blankets Required: ${Math.ceil(evacueeCount * 0.7)} pieces



• Sleeping Mats: ${Math.ceil(evacueeCount * 0.8)} pieces



• Pillows: ${Math.ceil(evacueeCount * 0.6)} pieces



• Privacy Screens: ${Math.ceil(evacueeCount / 10)} partitions



• Lighting Equipment: ${Math.ceil(evacueeCount / 20)} units







HYGIENE AND HEALTH:



• Hygiene Kits: ${Math.ceil(evacueeCount * 0.8)} complete kits



• Soap Bars: ${evacueeCount * 2} bars (2-week supply)



• Toothbrushes: ${evacueeCount} pieces



• Toothpaste: ${Math.ceil(evacueeCount / 2)} tubes



• Feminine Hygiene: ${Math.ceil(evacueeCount * 0.3 * 0.6)} packages



• Adult Diapers: ${Math.ceil(evacueeCount * 0.25 * 0.2)} packages







=== VULNERABLE GROUPS SUPPORT ===







ELDERLY CARE (${Math.ceil(evacueeCount * 0.25)} people):



• Chronic Medication Management



• Mobility Assistance Devices



• Special Diet Preparation



• Regular Health Monitoring



• Comfortable Sleeping Arrangements







INFANT AND CHILD CARE (${Math.ceil(evacueeCount * 0.5)} children):



• Baby Formula and Diapers



• Pediatric Medical Supplies



• Child-Friendly Spaces



• Educational Materials



• Child Care Support Staff







PREGNANT WOMEN (${Math.ceil(evacueeCount * 0.08)} women):



• Prenatal Vitamins and Supplements



• Maternity Clothing



• Special Nutritional Support



• Prenatal Medical Checkups



• Safe Delivery Preparation







PERSONS WITH DISABILITIES (${Math.ceil(evacueeCount * 0.12)} people):



• Accessibility Equipment



• Assistive Devices



• Special Transportation



• Accessible Toilet Facilities



• Personal Care Assistance







=== DISTRIBUTION LOGISTICS ===







STAFFING REQUIREMENTS:



• Distribution Coordinators: ${Math.ceil(evacueeCount / 50)} people



• Medical Staff: ${Math.ceil(evacueeCount / 100)} personnel



• Support Volunteers: ${Math.ceil(evacueeCount / 25)} volunteers



• Security Personnel: ${Math.ceil(evacueeCount / 75)} guards







TRANSPORTATION NEEDS:



• Supply Trucks: ${Math.ceil(evacueeCount / 100)} vehicles



• Medical Transport: 2 ambulances on standby



• Staff Transport: ${Math.ceil(evacueeCount / 200)} vehicles



• Emergency Evacuation: 4 vehicles available







STORAGE REQUIREMENTS:



• Food Storage: ${Math.ceil(evacueeCount / 10)} cubic meters



• Water Storage: ${Math.ceil(evacueeCount / 5)} cubic meters



• Medical Supply Storage: ${Math.ceil(evacueeCount / 20)} cubic meters



• Equipment Storage: ${Math.ceil(evacueeCount / 15)} cubic meters







=== DISTRIBUTION SCHEDULE ===







DISTRIBUTION FREQUENCY:



• Food Distribution: 3 times daily (6AM, 12PM, 6PM)



• Water Distribution: 2 times daily



• Hygiene Supplies: Weekly distribution



• Medical Supplies: Daily check and resupply



• Special Items: As needed basis







PRIORITY DISTRIBUTION:



1. Immediate: Food, Water, Medical Supplies



2. High Priority: Hygiene, Shelter, Infant Supplies



3. Medium Priority: Comfort items, Educational materials



4. Low Priority: Non-essential comfort items







=== MONITORING AND REPORTING ===







DAILY TRACKING:



• Distribution Records: Maintain detailed logs



• Inventory Management: Real-time tracking



• Beneficiary Feedback: Collect satisfaction data



• Issue Resolution: Address problems immediately







QUALITY CONTROL:



• Food Safety: Regular quality checks



• Water Quality: Daily testing



• Medical Supply Expiry: Regular monitoring



• Equipment Maintenance: Scheduled checks







=== EMERGENCY PROTOCOLS ===







SHORTAGE RESPONSE:



• Activate backup suppliers



• Implement rationing if necessary



• Prioritize vulnerable groups



• Coordinate with neighboring areas







MEDICAL EMERGENCIES:



• 24/7 medical hotline



• Ambulance on standby



• First aid stations



• Emergency medical protocols







SECURITY MEASURES:



• Distribution point security



• Crowd control measures



• Emergency evacuation plans



• Communication systems







=== CONTACT INFORMATION ===



Distribution Coordinator: [Contact Number]



Medical Emergency: [Contact Number]



Supply Manager: [Contact Number]



24/7 Hotline: [Emergency Number]`;



                



                downloadFile('evacuee_distribution_plan.txt', planContent);



                showToast('Distribution plan generated and downloaded');



            }, 2000);



        }







        function downloadFile(filename, content) {



            const blob = new Blob([content], { type: 'text/plain' });



            const url = URL.createObjectURL(blob);



            const link = document.createElement('a');



            link.href = url;



            link.download = filename;



            document.body.appendChild(link);



            link.click();



            document.body.removeChild(link);



            URL.revokeObjectURL(url);



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







        // Analytics Functions



        function drawDemographicsChart(data) {



            const canvas = document.getElementById('demographicsChart');



            if (!canvas) return;



            



            const ctx = canvas.getContext('2d');



            



            // Check if data is valid



            if (!data || typeof data !== 'object') {



                console.warn('Invalid demographics data provided to drawDemographicsChart');



                return;



            }



            



            const labels = ['Senior M', 'Senior F', 'Adult M', 'Adult F', 'Child M', 'Child F'];



            const values = [



                data.seniorMale || 0, 



                data.seniorFemale || 0, 



                data.adultMale || 0, 



                data.adultFemale || 0, 



                data.childMale || 0, 



                data.childFemale || 0



            ];



            const colors = ['#3b82f6', '#ec4899', '#1e40af', '#9d174d', '#10b981', '#0ea5a0'];



            



            // Clear canvas



            ctx.clearRect(0, 0, canvas.width, canvas.height);



            



            // Draw pie chart



            const total = values.reduce((a, b) => a + b, 0);



            if (total === 0) return;



            



            const centerX = canvas.width / 2;



            const centerY = canvas.height / 2;



            const radius = 70;



            



            let currentAngle = -Math.PI / 2;



            



            values.forEach((value, index) => {



                const sliceAngle = (value / total) * 2 * Math.PI;



                



                // Draw slice



                ctx.beginPath();



                ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);



                ctx.lineTo(centerX, centerY);



                ctx.fillStyle = colors[index];



                ctx.fill();



                



                // Draw label



                const labelAngle = currentAngle + sliceAngle / 2;



                const labelX = centerX + Math.cos(labelAngle) * (radius + 20);



                const labelY = centerY + Math.sin(labelAngle) * (radius + 20);



                



                ctx.fillStyle = '#475569';



                ctx.font = '10px DM Sans';



                ctx.textAlign = 'center';



                ctx.fillText(labels[index], labelX, labelY);



                



                currentAngle += sliceAngle;



            });



        }







        function drawReadinessChart(data) {



            const canvas = document.getElementById('readinessChart');



            if (!canvas) return;



            



            const ctx = canvas.getContext('2d');



            



            // Check if data is valid



            if (!data || typeof data !== 'object') {



                console.warn('Invalid readiness data provided to drawReadinessChart');



                return;



            }



            



            const contactCoverage = data.contactCoverage || 0;



            const readinessScore = data.readinessScore || 0;



            



            // Clear canvas



            ctx.clearRect(0, 0, canvas.width, canvas.height);



            



            // Draw gauge chart



            const centerX = canvas.width / 2;



            const centerY = canvas.height - 30;



            const radius = 60;



            



            // Draw background arc



            ctx.beginPath();



            ctx.arc(centerX, centerY, radius, Math.PI, 0, false);



            ctx.strokeStyle = '#e2e8f0';



            ctx.lineWidth = 15;



            ctx.stroke();



            



            // Draw progress arc



            const progressAngle = ((readinessScore || 0) / 100) * Math.PI;



            ctx.beginPath();



            ctx.arc(centerX, centerY, radius, Math.PI, Math.PI + progressAngle, false);



            ctx.strokeStyle = readinessScore >= 80 ? '#10b981' : readinessScore >= 60 ? '#f59e0b' : '#f43f5e';



            ctx.lineWidth = 15;



            ctx.stroke();



            



            // Draw text



            ctx.fillStyle = '#0f172a';



            ctx.font = 'bold 20px Outfit';



            ctx.textAlign = 'center';



            ctx.fillText(readinessScore + '%', centerX, centerY - 10);



            



            ctx.fillStyle = '#475569';



            ctx.font = '11px DM Sans';



            ctx.fillText('Readiness', centerX, centerY + 10);



            ctx.fillText(`Contact: ${contactCoverage}%`, centerX, centerY + 20);



        }







        function drawPurokChart(data) {



            const canvas = document.getElementById('purokChart');



            if (!canvas) return;



            



            const ctx = canvas.getContext('2d');



            const purokData = data && data.distribution ? data.distribution : {};



            



            // Check if purokData is valid



            if (!purokData || typeof purokData !== 'object') {



                console.warn('Invalid purok data provided to drawPurokChart');



                return;



            }



            



            const values = Object.values(purokData);



            const labels = Object.keys(purokData);



            const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#6366f1'];



            



            // Clear canvas



            ctx.clearRect(0, 0, canvas.width, canvas.height);



            



            // Draw horizontal bar chart



            const maxValue = Math.max(...values, 1);



            const barHeight = 25;



            const barSpacing = 10;



            const startX = 80;



            const startY = 25;



            const chartWidth = canvas.width - startX - 20;



            



            values.forEach((value, index) => {



                const y = startY + (barHeight + barSpacing) * index;



                const barWidth = (value / maxValue) * chartWidth;



                



                // Draw bar



                ctx.fillStyle = colors[index];



                ctx.fillRect(startX, y, barWidth, barHeight);



                



                // Draw value



                ctx.fillStyle = '#0f172a';



                ctx.font = '11px DM Sans';



                ctx.textAlign = 'left';



                ctx.fillText(value, startX + barWidth + 5, y + barHeight / 2 + 4);



                



                // Draw label



                ctx.fillStyle = '#475569';



                ctx.font = '10px DM Sans';



                ctx.textAlign = 'right';



                ctx.fillText(labels[index], startX - 5, y + barHeight / 2 + 4);



            });



        }







        // Fetch analytics data from API



        async function fetchAnalyticsData() {



            try {



                const response = await fetch('/api/analytics-data', {



                    headers: {



                        'X-CSRF-TOKEN': csrf(),



                        'Content-Type': 'application/json'



                    }



                });



                const data = await response.json();



                



                // Update dashboard statistics



                updateDashboardStats(data);



                



                // Draw charts



                drawDemographicsChart(data);



                drawReadinessChart(data);



                drawPurokChart(data);



                



                // Load evacuation area analytics



                loadEvacuationAreaAnalytics();



                



            } catch (error) {



                console.error('Error fetching analytics data:', error);



            }



        }







        // Update dashboard statistics with real data



        function updateDashboardStats(data) {



            // Update demographics stats



            const avgAgeEl = document.querySelector('[data-stat="avgAge"]');



            const ratioEl = document.querySelector('[data-stat="genderRatio"]');



            const dependencyEl = document.querySelector('[data-stat="dependencyRatio"]');



            



            if (avgAgeEl && data.demographics && data.demographics.avgAge !== undefined) {



                avgAgeEl.textContent = data.demographics.avgAge + ' years avg';



            }



            if (ratioEl && data.demographics && data.demographics.genderRatio !== undefined) {



                ratioEl.textContent = data.demographics.genderRatio + ':100';



            }



            if (dependencyEl && data.demographics && data.demographics.dependencyRatio !== undefined) {



                dependencyEl.textContent = data.demographics.dependencyRatio + '%';



            }



            



            // Update readiness stats



            const contactEl = document.querySelector('[data-stat="contactCoverage"]');



            const readinessEl = document.querySelector('[data-stat="readinessScore"]');



            const responseEl = document.querySelector('[data-stat="responseTime"]');



            



            if (contactEl && data.readiness && data.readiness.contactCoverage !== undefined) {



                contactEl.textContent = data.readiness.contactCoverage + '%';



            }



            if (readinessEl && data.readiness && data.readiness.readinessScore !== undefined) {



                readinessEl.textContent = data.readiness.readinessScore + '/100';



            }



            if (responseEl && data.readiness && data.readiness.responseTime !== undefined) {



                responseEl.textContent = data.readiness.responseTime;



            }



            



            // Update purok stats



            const maxPurokEl = document.querySelector('[data-stat="maxPurok"]');



            const coveredEl = document.querySelector('[data-stat="coveredAreas"]');



            const avgPurokEl = document.querySelector('[data-stat="avgPerPurok"]');



            



            if (maxPurokEl && data.purok && data.purok.maxPurokName !== undefined && data.purok.maxPurok !== undefined) {



                maxPurokEl.textContent = data.purok.maxPurokName + ' (' + data.purok.maxPurok + ')';



            }



            if (coveredEl && data.purok && data.purok.coveredAreas !== undefined) {



                coveredEl.textContent = data.purok.coveredAreas + '/5';



            }



            if (avgPurokEl && data.purok && data.purok.avgPerPurok !== undefined) {



                avgPurokEl.textContent = data.purok.avgPerPurok;



            }



        }







        function refreshAnalytics() {



            showToast('Refreshing analytics data...');



            fetchAnalyticsData().then(data => {



                if (data) {



                    drawDemographicsChart(data.demographics);



                    drawReadinessChart(data.readiness);



                    drawPurokChart(data.purok);



                    updateDashboardStats(data);



                    showToast('Analytics updated successfully');



                }



            });



        }







        // Evacuation Area Analytics Functions (mirroring EvacueeProgram logic)



        function loadEvacuationAreaAnalytics() {

            const analyticsContent = document.getElementById('evacuationAreaAnalytics');



            analyticsContent.innerHTML = `

                <div style="text-align: center; padding: 20px; color: var(--text-muted);">

                    <i class="fas fa-spinner fa-spin" style="font-size: 20px; margin-bottom: 8px;"></i>

                    <div style="font-size: 12px;">Loading evacuation area analytics...</div>

                </div>

            `;



            

            // Fetch fresh data from backend using same API as EvacueeProgram

            fetch('/api/analytics-data')

                .then(response => response.json())

                .then(data => {

                    if (data.success) {

                        // Use the same accurate DSS metrics as EvacueeProgram

                        const areaAnalysis = analyzeEvacuationAreas(data.evacuees, data.facilities, data.dssMetrics);

                        displayEvacuationAreaAnalytics(areaAnalysis, data.dssMetrics);

                    } else {

                        throw new Error(data.message || 'Failed to load analytics');

                    }

                })

                .catch(error => {

                    console.error('Error loading evacuation area analytics:', error);

                    displayEmptyAnalytics();

                });

        } 



        function analyzeEvacuationAreas(evacuees, facilities, dssMetrics = {}) {



            // Group evacuees by evacuation area



            const areaGroups = {};



            



            evacuees.forEach(evacuee => {



                const area = evacuee.evacuation_area || 'Unknown';



                if (!areaGroups[area]) {



                    areaGroups[area] = {



                        area: area,



                        evacuees: [],



                        totalMembers: 0,



                        maleCount: 0,



                        femaleCount: 0,



                        seniorCount: 0,



                        childCount: 0,



                        infantCount: 0,



                        pregnantCount: 0,



                        pwdCount: 0,



                        rooms: new Set(),



                        dailyMealsNeeded: 0,



                        waterNeeded: 0,



                        hygieneKitsNeeded: 0,



                        blanketsNeeded: 0



                    };



                }



                



                const group = areaGroups[area];



                group.evacuees.push(evacuee);



                group.totalMembers += evacuee.total_members || 1;



                



                // Count demographics



                if (evacuee.gender === 'Male') group.maleCount++;



                else group.femaleCount++;



                



                if (evacuee.age >= 60) group.seniorCount++;



                else if (evacuee.age < 18) group.childCount++;



                if (evacuee.age <= 5) group.infantCount++;



                



                if (evacuee.has_pregnant) group.pregnantCount++;



                if (evacuee.has_pwd) group.pwdCount++;



                



                if (evacuee.room_number) group.rooms.add(evacuee.room_number);



                



                // Calculate needs



                const familySize = evacuee.total_members || 1;



                group.dailyMealsNeeded += calculateDailyMeals(evacuee.age, familySize);



                group.waterNeeded += familySize * 4; // 4 liters per person per day



                group.hygieneKitsNeeded += Math.ceil(familySize * 0.8);



                group.blanketsNeeded += Math.ceil(familySize * 0.7);



            });



            



            // Convert to array and add facility info



            const areas = Object.values(areaGroups);



            



            // Add facility capacity information



            areas.forEach(area => {



                const facility = facilities.find(f => f.name === area.area);



                if (facility) {



                    area.capacity = facility.capacity || 0;



                    area.available_spaces = facility.available_spaces || 0;



                    area.occupancy_rate = area.capacity > 0 ? (area.totalMembers / area.capacity) * 100 : 0;



                } else {



                    area.capacity = 'Unknown';



                    area.available_spaces = 'Unknown';



                    area.occupancy_rate = 0;



                }



                



                // Calculate aid priority based on multiple factors



                area.aidPriority = calculateAidPriority(area);



                



                // Generate specific recommendations



                area.recommendations = generateAreaRecommendations(area);



            });



            



            // Sort by aid priority (highest first)



            areas.sort((a, b) => b.aidPriority - a.aidPriority);



            



            return areas;



        }







        function calculateDailyMeals(age, familySize) {



            let mealsPerPerson = 3; // Default for adults



            



            if (age <= 2) mealsPerPerson = 6; // Infants: 6 small meals



            else if (age <= 12) mealsPerPerson = 5; // Children: 3 meals + 2 snacks



            else if (age <= 17) mealsPerPerson = 3; // Teens: 3 meals



            



            return mealsPerPerson * familySize;



        }







        function calculateAidPriority(area) {



            let priority = 0;



            



            // High occupancy increases priority



            if (area.occupancy_rate > 90) priority += 30;



            else if (area.occupancy_rate > 75) priority += 20;



            else if (area.occupancy_rate > 50) priority += 10;



            



            // Vulnerable populations increase priority



            if (area.seniorCount > 0) priority += area.seniorCount * 3;



            if (area.infantCount > 0) priority += area.infantCount * 4;



            if (area.pregnantCount > 0) priority += area.pregnantCount * 5;



            if (area.pwdCount > 0) priority += area.pwdCount * 4;



            



            // Large populations increase priority



            if (area.totalMembers > 50) priority += 15;



            else if (area.totalMembers > 25) priority += 10;



            else if (area.totalMembers > 10) priority += 5;



            



            return Math.min(priority, 100); // Cap at 100



        }







        function generateAreaRecommendations(area) {



            const recommendations = [];



            



            // Capacity recommendations



            if (area.occupancy_rate > 90) {



                recommendations.push({



                    type: 'critical',



                    icon: 'exclamation-triangle',



                    text: `Critical overcrowding at ${Math.round(area.occupancy_rate)}%. Activate overflow shelters immediately.`



                });



            } else if (area.occupancy_rate > 75) {



                recommendations.push({



                    type: 'warning',



                    icon: 'exclamation-circle',



                    text: `High occupancy at ${Math.round(area.occupancy_rate)}%. Prepare backup facilities.`



                });



            }



            



            // Vulnerable group recommendations



            if (area.infantCount > 0) {



                recommendations.push({



                    type: 'info',



                    icon: 'baby',



                    text: `Urgent: Baby formula, diapers, and infant care supplies needed for ${area.infantCount} infants.`



                });



            }



            



            if (area.seniorCount > 0) {



                recommendations.push({



                    type: 'info',



                    icon: 'user-clock',



                    text: `Elderly care: Medication management and mobility assistance for ${area.seniorCount} seniors.`



                });



            }



            



            if (area.pregnantCount > 0) {



                recommendations.push({



                    type: 'info',



                    icon: 'baby-carriage',



                    text: `Maternal care: Prenatal supplies and monitoring for ${area.pregnantCount} pregnant women.`



                });



            }



            



            // Supply recommendations



            if (area.dailyMealsNeeded > 100) {



                recommendations.push({



                    type: 'info',



                    icon: 'utensils',



                    text: `High food demand: ${area.dailyMealsNeeded} daily meals required. Consider additional kitchen facilities.`



                });



            }



            



            if (area.waterNeeded > 200) {



                recommendations.push({



                    type: 'info',



                    icon: 'tint',



                    text: `Water supply: ${area.waterNeeded}L daily needed. Ensure adequate water delivery.`



                });



            }



            



            return recommendations.slice(0, 3); // Return top 3 recommendations



        }







        function displayEvacuationAreaAnalytics(areas, dssMetrics = {}) {



            const analyticsContent = document.getElementById('evacuationAreaAnalytics');



            



            if (areas.length === 0) {



                displayEmptyAnalytics();



                return;



            }



            



            let html = `



                <div style="margin-bottom: 16px;">



                    <!-- Use accurate DSS metrics for summary cards -->



                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-bottom: 12px;">



                        <div style="text-align: center; padding: 8px; background: var(--navy-light); color: white; border-radius: 6px;">



                            <div style="font-size: 16px; font-weight: 700;">${areas.length}</div>



                            <div style="font-size: 9px; text-transform: uppercase;">Active Areas</div>



                        </div>



                        <div style="text-align: center; padding: 8px; background: var(--teal-light); color: var(--teal); border-radius: 6px;">



                            <div style="font-size: 16px; font-weight: 700;">${dssMetrics.total_family_members || areas.reduce((sum, area) => sum + area.totalMembers, 0)}</div>



                            <div style="font-size: 9px; text-transform: uppercase;">Total People</div>



                        </div>



                        <div style="text-align: center; padding: 8px; background: #fce7f3; color: #ec4899; border-radius: 6px;">



                            <div style="font-size: 16px; font-weight: 700;">${dssMetrics.pregnant_women_count || areas.reduce((sum, area) => sum + area.pregnantCount, 0)}</div>



                            <div style="font-size: 9px; text-transform: uppercase;">Pregnant</div>



                        </div>



                        <div style="text-align: center; padding: 8px; background: #e0e7ff; color: #6366f1; border-radius: 6px;">



                            <div style="font-size: 16px; font-weight: 700;">${dssMetrics.disabled_persons_count || areas.reduce((sum, area) => sum + area.pwdCount, 0)}</div>



                            <div style="font-size: 9px; text-transform: uppercase;">PWD</div>



                        </div>



                    </div>



                    



                    <!-- Additional Demographics Summary using DSS Metrics -->



                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 6px; margin-bottom: 12px;">



                        <div style="background: #f0fdf4; color: #16a34a; padding: 6px; border-radius: 4px; text-align: center;">



                            <div style="font-size: 14px; font-weight: 600;">${dssMetrics.senior_count || 0}</div>



                            <div style="font-size: 8px; text-transform: uppercase;">Seniors (60+)</div>



                        </div>



                        <div style="background: #fef3c7; color: #d97706; padding: 6px; border-radius: 4px; text-align: center;">



                            <div style="font-size: 14px; font-weight: 600;">${dssMetrics.child_count || 0}</div>



                            <div style="font-size: 8px; text-transform: uppercase;">Children (&lt;18)</div>



                        </div>



                        <div style="background: #dbeafe; color: #2563eb; padding: 6px; border-radius: 4px; text-align: center;">



                            <div style="font-size: 14px; font-weight: 600;">${dssMetrics.male_count || 0}</div>



                            <div style="font-size: 8px; text-transform: uppercase;">Male</div>



                        </div>



                        <div style="background: #fce7f3; color: #ec4899; padding: 6px; border-radius: 4px; text-align: center;">



                            <div style="font-size: 14px; font-weight: 600;">${dssMetrics.female_count || 0}</div>



                            <div style="font-size: 8px; text-transform: uppercase;">Female</div>



                        </div>



                        <div style="background: #e0e7ff; color: #6366f1; padding: 6px; border-radius: 4px; text-align: center;">



                            <div style="font-size: 14px; font-weight: 600;">${areas.reduce((sum, area) => sum + (area.dailyMealsNeeded || 0), 0)}</div>



                            <div style="font-size: 8px; text-transform: uppercase;">Daily Meals</div>



                        </div>



                        <div style="background: #ecfdf5; color: #059669; padding: 6px; border-radius: 4px; text-align: center;">



                            <div style="font-size: 14px; font-weight: 600;">${(dssMetrics.daily_water_requirement || 0).toLocaleString()}L</div>



                            <div style="font-size: 8px; text-transform: uppercase;">Water/Day</div>



                        </div>



                    </div>



                </div>



                



                <div style="display: grid; gap: 12px;">



            `;



            



            areas.slice(0, 3).forEach((area, index) => {



                const priorityColor = area.aidPriority >= 70 ? 'var(--rose)' : 



                                   area.aidPriority >= 40 ? 'var(--amber)' : 'var(--green)';



                



                const occupancyColor = area.occupancy_rate > 90 ? 'var(--rose)' :



                                    area.occupancy_rate > 75 ? 'var(--amber)' : 'var(--green)';



                



                html += `



                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 8px; padding: 12px; position: relative;">



                        ${area.aidPriority >= 50 ? '<div style="position: absolute; top: -6px; right: 12px; background: ' + priorityColor + '; color: white; padding: 2px 8px; border-radius: 8px; font-size: 9px; font-weight: 600; text-transform: uppercase;">HIGH PRIORITY</div>' : ''}



                        



                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">



                            <div>



                                <h4 style="color: var(--text-dark); font-size: 13px; font-weight: 600; margin: 0 0 2px 0;">



                                    <i class="fas fa-map-marker-alt" style="color: var(--teal); margin-right: 4px; font-size: 10px;"></i>${area.area}



                                </h4>



                                <div style="color: var(--text-muted); font-size: 10px;">



                                    ${area.totalMembers} evacuees



                                </div>



                            </div>



                            <div style="text-align: right;">



                                <div style="font-size: 14px; font-weight: 700; color: ${priorityColor}; margin-bottom: 2px;">



                                    ${Math.round(area.aidPriority)}%



                                </div>



                                <div style="font-size: 8px; text-transform: uppercase; color: var(--text-muted);">Priority</div>



                            </div>



                        </div>



                        



                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; margin-bottom: 8px;">



                            <div style="text-align: center; padding: 6px; background: var(--slate-light); border-radius: 4px;">



                                <div style="font-size: 12px; font-weight: 600; color: var(--text-dark);">${area.totalMembers}</div>



                                <div style="font-size: 8px; color: var(--text-muted);">People</div>



                            </div>



                            <div style="text-align: center; padding: 6px; background: var(--slate-light); border-radius: 4px;">



                                <div style="font-size: 12px; font-weight: 600; color: ${occupancyColor};">${Math.round(area.occupancy_rate)}%</div>



                                <div style="font-size: 8px; color: var(--text-muted);">Occupancy</div>



                            </div>



                            <div style="text-align: center; padding: 6px; background: var(--slate-light); border-radius: 4px;">



                                <div style="font-size: 12px; font-weight: 600; color: var(--teal);">${area.dailyMealsNeeded}</div>



                                <div style="font-size: 8px; color: var(--text-muted);">Meals/Day</div>



                            </div>



                            <div style="text-align: center; padding: 6px; background: var(--slate-light); border-radius: 4px;">



                                <div style="font-size: 12px; font-weight: 600; color: var(--blue);">${area.waterNeeded}L</div>



                                <div style="font-size: 8px; color: var(--text-muted);">Water/Day</div>



                            </div>



                        </div>



                        



                        ${area.recommendations.length > 0 ? `



                            <div style="border-top: 1px solid var(--border); padding-top: 6px;">



                                <div style="font-size: 9px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Top Recommendation</div>



                                <div style="font-size: 10px; color: var(--text-mid); line-height: 1.3;">



                                    <i class="fas fa-${area.recommendations[0].icon}" style="color: ${area.recommendations[0].type === 'critical' ? 'var(--rose)' : area.recommendations[0].type === 'warning' ? 'var(--amber)' : 'var(--green)'}; margin-right: 2px; font-size: 8px;"></i>



                                    ${area.recommendations[0].text}



                                </div>



                            </div>



                        ` : ''}



                    </div>



                `;



            });



            



            html += '</div>';



            analyticsContent.innerHTML = html;



        }







        function displayEmptyAnalytics() {



            const analyticsContent = document.getElementById('evacuationAreaAnalytics');



            analyticsContent.innerHTML = `



                <div style="text-align: center; padding: 20px; color: var(--text-muted);">



                    <i class="fas fa-building" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5;"></i>



                    <div style="font-size: 12px; font-weight: 600; margin-bottom: 4px;">No Evacuation Data Available</div>



                    <div style="font-size: 10px;">No active evacuees in evacuation areas</div>



                </div>



            `;



        }







        // Initialize charts on page load



        document.addEventListener('DOMContentLoaded', () => {



            setTimeout(() => {



                fetchAnalyticsData().then(data => {



                    if (data) {



                        drawDemographicsChart(data.demographics);



                        drawReadinessChart(data.readiness);



                        drawPurokChart(data.purok);



                        updateDashboardStats(data);



                    }



                });



            }, 500);



        });



    </script>



</body>



</html>