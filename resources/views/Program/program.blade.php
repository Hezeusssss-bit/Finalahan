<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Program Management — B-DEAMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --navy: #0d1b2a;
            --navy-mid: #1b2e42;
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
            --violet: #7c3aed;
            --violet-light: #ede9fe;
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
            display: flex; flex-direction: column;
            z-index: 200;
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-brand {
            padding: 22px 24px 18px;
            display: flex; align-items: center; gap: 13px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .brand-badge {
            width: 38px; height: 38px;
            background: transparent; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; color: white; flex-shrink: 0;
        }

        .dswd-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
            border-radius: 6px;
        }

        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 16px; font-weight: 700; color: white;
        }

        .brand-sub {
            font-size: 10px; color: rgba(255,255,255,0.35);
            font-weight: 300; letter-spacing: 0.06em;
            text-transform: uppercase; margin-top: 1px;
        }

        .nav-section { padding: 18px 16px 4px; }

        .nav-section-label {
            font-size: 10.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.1em;
            color: rgba(255,255,255,0.28);
            padding: 0 8px; margin-bottom: 6px;
            display: flex; align-items: center; gap: 6px;
        }

        .nav-section-label::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,0.08);
        }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 10px;
            color: rgba(255,255,255,0.6); text-decoration: none;
            font-size: 14px; font-weight: 400;
            transition: all 0.2s; margin-bottom: 2px;
            border: none; background: none;
            width: 100%; cursor: pointer; text-align: left;
        }

        .nav-link i {
            width: 18px; text-align: center; font-size: 14px;
            color: rgba(255,255,255,0.35); transition: color 0.2s; flex-shrink: 0;
        }

        .nav-link:hover { background: rgba(255,255,255,0.07); color: white; }
        .nav-link:hover i { color: var(--teal); }

        .nav-link.active {
            background: rgba(14,165,160,0.15); color: white; font-weight: 500;
        }

        .nav-link.active i { color: var(--teal); }

        .sidebar-footer {
            margin-top: auto; padding: 12px 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .nav-link-danger:hover { background: rgba(244,63,94,0.12); color: #fca5a5; }
        .nav-link-danger:hover i { color: #fca5a5; }

        /* ── MAIN ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1; padding: 36px 40px; min-height: 100vh;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px; flex-wrap: wrap; gap: 16px;
        }

        .page-eyebrow {
            font-size: 11.5px; font-weight: 500;
            color: var(--teal); text-transform: uppercase;
            letter-spacing: 0.12em; margin-bottom: 6px;
        }

        .page-title {
            font-family: 'Outfit', sans-serif;
            font-size: 28px; font-weight: 700;
            color: var(--text-dark); line-height: 1.2;
        }

        .btn-add-program {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 22px; border-radius: 10px;
            background: var(--navy); color: white; border: none;
            font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500;
            cursor: pointer; transition: all 0.2s;
        }

        .btn-add-program:hover { background: var(--navy-mid); }

        /* ── FLASH ── */
        .flash-alert {
            display: flex; align-items: center; gap: 12px;
            padding: 13px 18px; border-radius: 12px;
            font-size: 13.5px; margin-bottom: 24px;
            animation: fadeUp 0.3s ease both;
        }

        .flash-alert.success { background: var(--green-light); color: #065f46; }

        /* ── SECTION ── */
        .program-section { margin-bottom: 36px; }

        .section-head {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .section-title-row {
            display: flex; align-items: center; gap: 12px;
        }

        .section-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }

        .icon-upcoming  { background: var(--amber-light); color: #b45309; }
        .icon-ongoing   { background: var(--blue-light);  color: #1d4ed8; }
        .icon-completed { background: var(--green-light); color: #065f46; }

        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 17px; font-weight: 700; color: var(--text-dark);
        }

        .section-badge {
            display: inline-block; padding: 3px 12px;
            border-radius: 20px; font-size: 12px; font-weight: 600;
            background: var(--slate-light); color: var(--text-muted);
        }

        /* ── PROGRAM GRID ── */
        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 18px;
        }

        .program-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 22px;
            position: relative; overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .program-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
        }

        .program-card.upcoming::before  { background: var(--amber); }
        .program-card.ongoing::before   { background: var(--blue); }
        .program-card.completed::before { background: var(--green); }

        .program-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.08);
        }

        .prog-title {
            font-family: 'Outfit', sans-serif;
            font-size: 15.5px; font-weight: 700;
            color: var(--text-dark); margin-bottom: 8px;
            line-height: 1.3;
        }

        .prog-location {
            display: flex; align-items: center; gap: 6px;
            font-size: 12.5px; color: var(--text-muted);
            margin-bottom: 12px;
        }

        .prog-location i { font-size: 11px; color: var(--teal); }

        .prog-desc {
            font-size: 13px; color: var(--text-mid);
            line-height: 1.6; margin-bottom: 16px;
        }

        .prog-dates {
            display: flex; justify-content: space-between;
            font-size: 12px; color: var(--text-muted);
            margin-bottom: 14px; flex-wrap: wrap; gap: 4px;
        }

        .prog-status {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
            margin-bottom: 14px;
        }

        .prog-status::before {
            content: ''; width: 6px; height: 6px;
            border-radius: 50%;
        }

        .status-upcoming  { background: var(--amber-light); color: #92400e; }
        .status-upcoming::before  { background: var(--amber); }
        .status-ongoing   { background: var(--blue-light);  color: #1e40af; }
        .status-ongoing::before   { background: var(--blue); }
        .status-completed { background: var(--green-light); color: #065f46; }
        .status-completed::before { background: var(--green); }

        .prog-actions { display: flex; gap: 6px; }

        .prog-btn {
            width: 30px; height: 30px; border-radius: 7px;
            border: 1px solid var(--border); background: white;
            color: var(--text-mid); font-size: 12px; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s; text-decoration: none;
        }

        .prog-btn:hover { background: var(--navy); color: white; border-color: var(--navy); }
        .prog-btn.del:hover { background: var(--rose); border-color: var(--rose); }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: var(--white); border: 1px solid var(--border);
            border-radius: 16px; text-align: center;
            padding: 44px 20px; color: var(--text-muted);
        }

        .empty-icon-wrap {
            width: 64px; height: 64px; border-radius: 18px;
            background: var(--slate-light); display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 26px; color: var(--text-muted); margin-bottom: 14px;
        }

        .empty-title { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 600; color: var(--text-dark); margin-bottom: 5px; }
        .empty-sub   { font-size: 13px; }

        /* ── MODAL ── */
        .modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(13,27,42,0.55);
            backdrop-filter: blur(2px);
            z-index: 500; display: none;
            align-items: center; justify-content: center;
        }

        .modal-backdrop.open { display: flex; }

        .modal-box {
            background: white; border-radius: 18px;
            width: 90%; max-width: 520px;
            max-height: 90vh; overflow-y: auto;
            scrollbar-width: none;
            animation: modalIn 0.25s cubic-bezier(0.175,0.885,0.32,1.275) both;
        }

        .modal-box::-webkit-scrollbar { display: none; }

        @keyframes modalIn {
            from { opacity:0; transform:translateY(20px) scale(0.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        .modal-head {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: flex-start;
            justify-content: space-between; gap: 12px;
            position: sticky; top: 0; background: white;
            border-radius: 18px 18px 0 0; z-index: 10;
        }

        .modal-head-title {
            font-family: 'Outfit', sans-serif;
            font-size: 17px; font-weight: 700; color: var(--text-dark);
        }

        .modal-head-sub { font-size: 12.5px; color: var(--text-muted); margin-top: 2px; }

        .modal-close {
            width: 28px; height: 28px; border-radius: 7px;
            border: 1px solid var(--border); background: var(--slate-light);
            color: var(--text-muted); font-size: 13px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: all 0.2s;
        }

        .modal-close:hover { background: var(--rose-light); color: var(--rose); border-color: var(--rose); }

        .modal-body { padding: 18px 24px 24px; }

        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block; font-size: 11.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.07em;
            color: var(--text-muted); margin-bottom: 6px;
        }

        .form-control {
            width: 100%; padding: 9px 12px;
            border: 1px solid var(--border); border-radius: 9px;
            font-size: 13.5px; font-family: 'DM Sans', sans-serif;
            color: var(--text-dark); background: var(--slate-light);
            transition: all 0.2s; outline: none;
        }

        .form-control:focus {
            background: white; border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14,165,160,0.12);
        }

        textarea.form-control { resize: vertical; min-height: 90px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .modal-footer {
            display: flex; justify-content: flex-end; gap: 10px;
            padding-top: 16px; border-top: 1px solid var(--border); margin-top: 16px;
        }

        .btn-cancel {
            padding: 9px 20px; border-radius: 9px;
            border: 1px solid var(--border); background: var(--slate-light);
            color: var(--text-mid); font-family: 'DM Sans', sans-serif;
            font-size: 13.5px; font-weight: 500; cursor: pointer; transition: all 0.2s;
        }

        .btn-cancel:hover { background: var(--border); }

        .btn-submit {
            padding: 9px 22px; border-radius: 9px; border: none;
            background: var(--navy); color: white;
            font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            transition: all 0.2s;
        }

        .btn-submit:hover { background: var(--navy-mid); }
        .btn-submit.danger { background: var(--rose); }
        .btn-submit.danger:hover { background: #e11d48; }

        /* ── TOAST ── */
        .toast {
            position: fixed; bottom: 28px; right: 28px;
            background: var(--navy); color: white;
            padding: 13px 20px; border-radius: 12px;
            font-size: 14px; font-weight: 500;
            display: flex; align-items: center; gap: 10px;
            z-index: 9999; transform: translateY(80px); opacity: 0;
            transition: all 0.3s cubic-bezier(0.175,0.885,0.32,1.275);
            pointer-events: none;
        }

        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { color: var(--teal); }

        /* ── ANIMS ── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .anim    { animation: fadeUp 0.4s ease both; }
        .delay-1 { animation-delay: 0.07s; }
        .delay-2 { animation-delay: 0.13s; }
        .delay-3 { animation-delay: 0.19s; }

        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .main { margin-left: 0; padding: 22px 18px; }
            .program-grid { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('resident.index') }}" class="nav-link"><i class="fas fa-gauge-high"></i> Dashboard</a>
            <a href="{{ route('program.index') }}" class="nav-link active"><i class="fas fa-clipboard-list"></i> Programs</a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Services</div>
            <a href="{{ route('services') }}" class="nav-link"><i class="fas fa-concierge-bell"></i> Services</a>
            <a href="{{ route('tryall') }}" class="nav-link"><i class="fas fa-sms"></i> SMS Alert</a>
            <a href="{{ route('facilities') }}" class="nav-link"><i class="fas fa-building"></i> Facilities</a>
                        <a href="{{ route('idps') }}" class="nav-link">
                <i class="fas fa-users"></i> IDP's
            </a>
        </div>
        

        <div class="sidebar-footer">
            <div style="font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.28);padding:0 8px;margin-bottom:6px;">System</div>
            <a href="{{ route('activity-logs.index') }}" class="nav-link"><i class="fas fa-scroll"></i> Activity Log</a>
            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="button" class="nav-link nav-link-danger" onclick="openLogoutModal()">
                    <i class="fas fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- ══ MAIN ══ -->
    <main class="main">

        <!-- Header -->
        <div class="page-header anim">
            <div>
                <p class="page-eyebrow">Administration</p>
                <h1 class="page-title">Program Management</h1>
            </div>
            <button class="btn-add-program" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Program
            </button>
        </div>

        @if(session('Success'))
        <div class="flash-alert success anim" id="flashAlert">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('Success') }}</span>
        </div>
        @endif

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

                // Senior-focused programs
                if($familySeniors > 0) {
                    $recommendations[] = 'Senior Citizen Care';
                    $recommendations[] = 'Medical Mission';
                }

                // Child-focused programs
                if($familyChildren > 0) {
                    $recommendations[] = 'Child Protection';
                    $recommendations[] = 'Educational Support';
                }

                // PWD programs
                if($familyPWD > 0) {
                    $recommendations[] = 'PWD Assistance';
                    $recommendations[] = 'Accessibility Programs';
                }

                // Pregnancy programs
                if($isPregnant) {
                    $recommendations[] = 'Maternal Health';
                    $recommendations[] = 'Nutrition Program';
                }

                // Large family support
                if($memberCount >= 5) {
                    $recommendations[] = 'Food Security';
                    $recommendations[] = 'Livelihood Training';
                }

                // No contact - need communication programs
                if(!$resident->contact_number) {
                    $recommendations[] = 'Community Outreach';
                    $recommendations[] = 'Contact Registration';
                }

                // Default programs if no specific needs
                if(empty($recommendations)) {
                    $recommendations = ['Youth Development', 'Skills Training', 'Community Building'];
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

        <!-- Upcoming -->
        <div class="program-section anim delay-1">
            <div class="section-head">
                <div class="section-title-row">
                    <div class="section-icon icon-upcoming"><i class="fas fa-clock"></i></div>
                    <span class="section-title">Upcoming Programs</span>
                </div>
                <span class="section-badge">{{ $upcomingPrograms->count() }}</span>
            </div>

            @if($upcomingPrograms->count() > 0)
            <div class="program-grid">
                @foreach($upcomingPrograms as $program)
                <div class="program-card upcoming">
                    <div class="prog-title">{{ $program->title }}</div>
                    <div class="prog-location"><i class="fas fa-location-dot"></i> {{ $program->location ?? 'TBD' }}</div>
                    @if($program->description)
                    <div class="prog-desc">{{ $program->description }}</div>
                    @endif
                    <div class="prog-dates">
                        <span><i class="fas fa-calendar-day" style="margin-right:4px;color:var(--teal);font-size:10px;"></i>Start: {{ $program->start_date->format('M d, Y') }}</span>
                        @if($program->end_date)<span>End: {{ $program->end_date->format('M d, Y') }}</span>@endif
                    </div>
                    <div class="prog-status status-upcoming">{{ $program->getStatusLabel() }}</div>
                    
                    @if($program->title === 'Evacuee Program')
                        @php
                            // Get evacuee data for this evacuation area
                            $areaEvacuees = collect($evacuees ?? [])->filter(function($e) use ($program) {
                                $evacuationArea = is_array($e) ? ($e['evacuation_area'] ?? null) : ($e->evacuation_area ?? null);
                                return $evacuationArea === $program->location;
                            });
                            
                            // Calculate DSS metrics
                            $totalEvacuees = $areaEvacuees->count();
                            $seniorCount = $areaEvacuees->filter(function($e) { $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                                return $age >= 60; })->count();
                            $infantCount = $areaEvacuees->filter(function($e) { 
                                $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                                return $age <= 5; })->count();
                            $pregnantCount = $areaEvacuees->filter(function($e) { $hasPregnant = is_array($e) ? ($e['has_pregnant'] ?? false) : ($e->has_pregnant ?? false);
                                return $hasPregnant; })->count();
                            $pwdCount = $areaEvacuees->filter(function($e) { 
                                $hasPwd = is_array($e) ? ($e['has_pwd'] ?? false) : ($e->has_pwd ?? false);
                                return $hasPwd; })->count();
                            
                            // Calculate needs
                            $dailyMeals = $areaEvacuees->sum(function($e) {
                                $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                                $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                                
                                $mealsPerPerson = 3;
                                if ($age <= 2) $mealsPerPerson = 6;
                                else if ($age <= 12) $mealsPerPerson = 5;
                                return $mealsPerPerson * $totalMembers;
                            });
                            $waterNeeded = $areaEvacuees->sum(function($e) { 
                                $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                                return $totalMembers * 4; 
                            });
                            $totalFamilyMembers = $areaEvacuees->sum(function($e) { 
                                return is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1); 
                            });
                            $hygieneKits = ceil($totalFamilyMembers * 0.8);
                            $blankets = ceil($totalFamilyMembers * 0.7);
                        @endphp
                        <div class="prog-evacuee-needs" style="margin-top: 12px; padding: 12px; background: linear-gradient(135deg, #e0f7f6 0%, #f0fdf4 100%); border-radius: 10px; border-left: 4px solid var(--teal);">
                            <div style="font-size: 11px; font-weight: 700; color: #0f766e; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fas fa-brain" style="margin-right: 4px;"></i>DSS Assistance Requirements
                            </div>
                            
                            @if($totalEvacuees > 0)
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                                    <div style="text-align: center; padding: 6px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                                        <div style="font-size: 14px; font-weight: 700; color: var(--navy);">{{ $totalEvacuees }}</div>
                                        <div style="font-size: 8px; color: var(--text-muted);">Evacuees</div>
                                    </div>
                                    <div style="text-align: center; padding: 6px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                                        <div style="font-size: 14px; font-weight: 700; color: var(--amber);">{{ $dailyMeals }}</div>
                                        <div style="font-size: 8px; color: var(--text-muted);">Meals/Day</div>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 8px;">
                                    <div style="font-size: 9px; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">IMMEDIATE NEEDS:</div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; font-size: 9px; color: var(--text-mid);">
                                        <div><i class="fas fa-tint" style="color: var(--blue); margin-right: 2px;"></i>{{ $waterNeeded }}L Water/Day</div>
                                        <div><i class="fas fa-box" style="color: var(--teal); margin-right: 2px;"></i>{{ $hygieneKits }} Hygiene Kits</div>
                                        <div><i class="fas fa-bed" style="color: var(--rose); margin-right: 2px;"></i>{{ $blankets }} Blankets</div>
                                        <div><i class="fas fa-medkit" style="color: var(--green); margin-right: 2px;"></i>{{ ceil($totalEvacuees / 10) }} First Aid</div>
                                    </div>
                                </div>
                                
                                @if($seniorCount > 0 || $infantCount > 0 || $pregnantCount > 0 || $pwdCount > 0)
                                <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 6px; padding: 6px;">
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
                                        @if($pregnantCount > 0)
                                        <span style="background: #ec4899; color: white; padding: 1px 4px; border-radius: 4px; font-size: 8px;">
                                            <i class="fas fa-baby-carriage" style="font-size: 7px; margin-right: 1px;"></i>{{ $pregnantCount }} Pregnant
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
                            @else
                                <div style="text-align: center; padding: 12px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle" style="font-size: 16px; margin-bottom: 4px; opacity: 0.5;"></i>
                                    <div style="font-size: 10px;">No evacuee data available for {{ $program->location }}</div>
                                </div>
                            @endif
                        </div>
                    @else
                        @php
                            $purokData = $purokAnalytics[$program->location] ?? null;
                        @endphp
                        <div class="prog-needs" style="margin-top: 12px; padding: 10px; background: var(--amber-light); border-radius: 8px; border-left: 3px solid var(--amber);">
                            <div style="font-size: 11px; font-weight: 600; color: #92400e; margin-bottom: 6px;">
                                <i class="fas fa-brain" style="margin-right: 4px;"></i>DSS Program Recommendations:
                            </div>
                            @if($purokData)
                                <div style="margin-bottom: 8px;">
                                    <div style="font-size: 9px; font-weight: 600; color: #92400e; margin-bottom: 4px;">PUROK DEMOGRAPHICS:</div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px; font-size: 9px; color: #78350f;">
                                        @if($purokData['senior_count'] > 0)
                                        <div><strong>{{ $purokData['senior_count'] }}</strong> Seniors</div>
                                        @endif
                                        @if($purokData['child_count'] > 0)
                                        <div><strong>{{ $purokData['child_count'] }}</strong> Children</div>
                                        @endif
                                        @if($purokData['pwd_count'] > 0)
                                        <div><strong>{{ $purokData['pwd_count'] }}</strong> PWD</div>
                                        @endif
                                        @if($purokData['pregnant_count'] > 0)
                                        <div><strong>{{ $purokData['pregnant_count'] }}</strong> Pregnant</div>
                                        @endif
                                        @if($purokData['large_family_count'] > 0)
                                        <div><strong>{{ $purokData['large_family_count'] }}</strong> Large Families</div>
                                        @endif
                                        @if($purokData['no_contact_count'] > 0)
                                        <div><strong>{{ $purokData['no_contact_count'] }}</strong> No Contact</div>
                                        @endif
                                    </div>
                                </div>
                                @if(!empty($purokData['recommendations']))
                                <div>
                                    <div style="font-size: 9px; font-weight: 600; color: #92400e; margin-bottom: 4px;">RECOMMENDED PROGRAMS:</div>
                                    <div style="display: flex; flex-wrap: wrap; gap: 3px;">
                                        @foreach($purokData['recommendations'] as $rec)
                                        <span style="background: #d97706; color: white; padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: 500;">
                                            {{ $rec }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @else
                                <div style="font-size: 10px; color: #78350f;">
                                    <div>Standard program supplies and materials needed</div>
                                    <div style="margin-top: 4px; font-size: 9px; color: #92400e;">
                                        <i class="fas fa-info-circle" style="margin-right: 2px;"></i>Demographics analysis will be available once resident data is loaded
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="prog-actions">
                        <button class="prog-btn" onclick="editProgram({{ $program->id }})" title="Edit"><i class="fas fa-pen"></i></button>
                        <form action="{{ route('program.destroy', $program->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this program?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="prog-btn del" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon-wrap"><i class="fas fa-calendar-plus"></i></div>
                <div class="empty-title">No upcoming programs</div>
                <div class="empty-sub">Add a program with a future start date to see it here.</div>
            </div>
            @endif
        </div>

        <!-- Ongoing -->
        <div class="program-section anim delay-2">
            <div class="section-head">
                <div class="section-title-row">
                    <div class="section-icon icon-ongoing"><i class="fas fa-play-circle"></i></div>
                    <span class="section-title">Ongoing Programs</span>
                </div>
                <span class="section-badge">{{ $ongoingPrograms->count() }}</span>
            </div>

            @if($ongoingPrograms->count() > 0)
            <div class="program-grid">
                @foreach($ongoingPrograms as $program)
                <div class="program-card ongoing">
                    <div class="prog-title">{{ $program->title }}</div>
                    <div class="prog-location"><i class="fas fa-location-dot"></i> {{ $program->location ?? 'TBD' }}</div>
                    @if($program->description)
                    <div class="prog-desc">{{ $program->description }}</div>
                    @endif
                    <div class="prog-dates">
                        <span><i class="fas fa-calendar-day" style="margin-right:4px;color:var(--teal);font-size:10px;"></i>Started: {{ $program->start_date->format('M d, Y') }}</span>
                        @if($program->end_date)<span>Until: {{ $program->end_date->format('M d, Y') }}</span>@endif
                    </div>
                    <div class="prog-status status-ongoing">{{ $program->getStatusLabel() }}</div>
                    
                    @if($program->title === 'Evacuee Program')
                        @php
                            // Get evacuee data for this evacuation area
                            $areaEvacuees = collect($evacuees ?? [])->filter(function($e) use ($program) {
                                $evacuationArea = is_array($e) ? ($e['evacuation_area'] ?? null) : ($e->evacuation_area ?? null);
                                return $evacuationArea === $program->location;
                            });
                            
                            // Calculate DSS metrics
                            $totalEvacuees = $areaEvacuees->count();
                            $seniorCount = $areaEvacuees->filter(function($e) { $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                                return $age >= 60; })->count();
                            $infantCount = $areaEvacuees->filter(function($e) { 
                                $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                                return $age <= 5; })->count();
                            $pregnantCount = $areaEvacuees->filter(function($e) { $hasPregnant = is_array($e) ? ($e['has_pregnant'] ?? false) : ($e->has_pregnant ?? false);
                                return $hasPregnant; })->count();
                            $pwdCount = $areaEvacuees->filter(function($e) { 
                                $hasPwd = is_array($e) ? ($e['has_pwd'] ?? false) : ($e->has_pwd ?? false);
                                return $hasPwd; })->count();
                            
                            // Calculate needs
                            $dailyMeals = $areaEvacuees->sum(function($e) {
                                $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                                $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                                
                                $mealsPerPerson = 3;
                                if ($age <= 2) $mealsPerPerson = 6;
                                else if ($age <= 12) $mealsPerPerson = 5;
                                return $mealsPerPerson * $totalMembers;
                            });
                            $waterNeeded = $areaEvacuees->sum(function($e) { 
                                $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                                return $totalMembers * 4; 
                            });
                            $totalFamilyMembers = $areaEvacuees->sum(function($e) { 
                                return is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1); 
                            });
                            $hygieneKits = ceil($totalFamilyMembers * 0.8);
                            $blankets = ceil($totalFamilyMembers * 0.7);
                        @endphp
                        <div class="prog-evacuee-needs" style="margin-top: 12px; padding: 12px; background: linear-gradient(135deg, #dbeafe 0%, #e0f7f6 100%); border-radius: 10px; border-left: 4px solid var(--blue);">
                            <div style="font-size: 11px; font-weight: 700; color: #1e40af; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fas fa-brain" style="margin-right: 4px;"></i>DSS Assistance Requirements
                            </div>
                            
                            @if($totalEvacuees > 0)
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                                    <div style="text-align: center; padding: 6px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                                        <div style="font-size: 14px; font-weight: 700; color: var(--navy);">{{ $totalEvacuees }}</div>
                                        <div style="font-size: 8px; color: var(--text-muted);">Evacuees</div>
                                    </div>
                                    <div style="text-align: center; padding: 6px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                                        <div style="font-size: 14px; font-weight: 700; color: var(--amber);">{{ $dailyMeals }}</div>
                                        <div style="font-size: 8px; color: var(--text-muted);">Meals/Day</div>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 8px;">
                                    <div style="font-size: 9px; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">IMMEDIATE NEEDS:</div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; font-size: 9px; color: var(--text-mid);">
                                        <div><i class="fas fa-tint" style="color: var(--blue); margin-right: 2px;"></i>{{ $waterNeeded }}L Water/Day</div>
                                        <div><i class="fas fa-box" style="color: var(--teal); margin-right: 2px;"></i>{{ $hygieneKits }} Hygiene Kits</div>
                                        <div><i class="fas fa-bed" style="color: var(--rose); margin-right: 2px;"></i>{{ $blankets }} Blankets</div>
                                        <div><i class="fas fa-medkit" style="color: var(--green); margin-right: 2px;"></i>{{ ceil($totalEvacuees / 10) }} First Aid</div>
                                    </div>
                                </div>
                                
                                @if($seniorCount > 0 || $infantCount > 0 || $pregnantCount > 0 || $pwdCount > 0)
                                <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 6px; padding: 6px;">
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
                                        @if($pregnantCount > 0)
                                        <span style="background: #ec4899; color: white; padding: 1px 4px; border-radius: 4px; font-size: 8px;">
                                            <i class="fas fa-baby-carriage" style="font-size: 7px; margin-right: 1px;"></i>{{ $pregnantCount }} Pregnant
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
                            @else
                                <div style="text-align: center; padding: 12px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle" style="font-size: 16px; margin-bottom: 4px; opacity: 0.5;"></i>
                                    <div style="font-size: 10px;">No evacuee data available for {{ $program->location }}</div>
                                </div>
                            @endif
                        </div>
                    @else
                        @php
                            $requirement = collect($ongoingRequirements)->firstWhere('purok', $program->location);
                        @endphp
                        <div class="prog-needs" style="margin-top: 12px; padding: 10px; background: var(--blue-light); border-radius: 8px; border-left: 3px solid var(--blue);">
                            <div style="font-size: 11px; font-weight: 600; color: #1e40af; margin-bottom: 6px;">
                                <i class="fas fa-clipboard-list" style="margin-right: 4px;"></i>Program Assistance Needs:
                            </div>
                            @if($requirement && isset($requirement['specific_needs']))
                                <div style="font-size: 10.5px; color: #1e3a8a;">
                                    @if(isset($requirement['pwd_count']) && $requirement['pwd_count'] > 0)
                                    <div><strong>{{ $requirement['pwd_count'] }}</strong> PWD</div>
                                    @endif
                                    @if(isset($requirement['senior_count']) && $requirement['senior_count'] > 0)
                                    <div><strong>{{ $requirement['senior_count'] }}</strong> Seniors</div>
                                    @endif
                                    @if(isset($requirement['specific_needs']['medicine_kits_needed']))
                                    <div><strong>{{ $requirement['specific_needs']['medicine_kits_needed'] }}</strong> Medicine Kits</div>
                                    @endif
                                    @if(isset($requirement['specific_needs']['wheelchairs_needed']))
                                    <div><strong>{{ $requirement['specific_needs']['wheelchairs_needed'] }}</strong> Wheelchairs</div>
                                    @endif
                                </div>
                            @else
                                <div style="font-size: 10px; color: #1e3a8a;">
                                    <div>Standard program supplies and materials needed</div>
                                    <div style="margin-top: 4px; font-size: 9px; color: #1e40af;">
                                        <i class="fas fa-info-circle" style="margin-right: 2px;"></i>Specific requirements will be updated based on program type and location analysis
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="prog-actions">
                        <button class="prog-btn" onclick="editProgram({{ $program->id }})" title="Edit"><i class="fas fa-pen"></i></button>
                        <form action="{{ route('program.destroy', $program->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this program?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="prog-btn del" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon-wrap"><i class="fas fa-hourglass-half"></i></div>
                <div class="empty-title">No ongoing programs</div>
                <div class="empty-sub">Programs appear here once their start date has passed.</div>
            </div>
            @endif
        </div>

        <!-- Completed -->
        <div class="program-section anim delay-3">
            <div class="section-head">
                <div class="section-title-row">
                    <div class="section-icon icon-completed"><i class="fas fa-circle-check"></i></div>
                    <span class="section-title">Completed Programs</span>
                </div>
                <span class="section-badge">{{ $completedPrograms->count() }}</span>
            </div>

            @if($completedPrograms->count() > 0)
            <div class="program-grid">
                @foreach($completedPrograms as $program)
                <div class="program-card completed">
                    <div class="prog-title">{{ $program->title }}</div>
                    <div class="prog-location"><i class="fas fa-location-dot"></i> {{ $program->location ?? 'TBD' }}</div>
                    @if($program->description)
                    <div class="prog-desc">{{ $program->description }}</div>
                    @endif
                    <div class="prog-dates">
                        <span><i class="fas fa-calendar-check" style="margin-right:4px;color:var(--green);font-size:10px;"></i>
                        Completed: {{ $program->end_date ? $program->end_date->format('M d, Y') : $program->start_date->format('M d, Y') }}</span>
                    </div>
                    <div class="prog-status status-completed">{{ $program->getStatusLabel() }}</div>
                    <div class="prog-actions">
                        <button class="prog-btn" onclick="editProgram({{ $program->id }})" title="Edit"><i class="fas fa-pen"></i></button>
                        <form action="{{ route('program.destroy', $program->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this program?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="prog-btn del" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon-wrap"><i class="fas fa-flag-checkered"></i></div>
                <div class="empty-title">No completed programs</div>
                <div class="empty-sub">Finished programs will appear here.</div>
            </div>
            @endif
        </div>

    </main>

    <!-- Toast -->
    <div class="toast" id="toast"><i class="fas fa-circle-check"></i><span id="toast-msg">Done!</span></div>

    <!-- ══ ADD / EDIT PROGRAM MODAL ══ -->
    <div class="modal-backdrop" id="programBackdrop">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title" id="modalTitle">Add New Program</div>
                    <div class="modal-head-sub" id="modalSub">Fill in the details to create a program.</div>
                </div>
                <button class="modal-close" onclick="closeModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="programForm" action="{{ route('program.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="form-group">
                        <label class="form-label">Program Title</label>
                        <select name="title" id="programTitleSelect" class="form-control" required>
                            <option value="">Select a program type...</option>
                            
                            @if($vulnerableGroups['total_vulnerable'] > 0)
                            <optgroup label="Vulnerable Groups Support Programs">
                                @if($vulnerableGroups['pregnant_count'] > 0)
                                <option value="Maternal Health Program">Maternal Health Program ({{ $vulnerableGroups['pregnant_count'] }} Pregnant)</option>
                                <option value="Prenatal Care Assistance">Prenatal Care Assistance</option>
                                <option value="Nutrition Support for Mothers">Nutrition Support for Mothers</option>
                                @endif
                                
                                @if($vulnerableGroups['pwd_count'] > 0)
                                <option value="PWD Assistance Program">PWD Assistance Program ({{ $vulnerableGroups['pwd_count'] }} PWD)</option>
                                <option value="Accessibility Support Services">Accessibility Support Services</option>
                                <option value="Mobility Aid Distribution">Mobility Aid Distribution</option>
                                @endif
                                
                                @if($vulnerableGroups['senior_count'] > 0)
                                <option value="Senior Citizens Outreach">Senior Citizens Outreach ({{ $vulnerableGroups['senior_count'] }} Seniors)</option>
                                <option value="Elderly Care Program">Elderly Care Program</option>
                                <option value="Senior Medical Mission">Senior Medical Mission</option>
                                @endif
                                
                                @if($vulnerableGroups['children_count'] > 0)
                                <option value="Educational Assistance Program">Educational Assistance Program ({{ $vulnerableGroups['children_count'] }} Children)</option>
                                <option value="Child Protection Program">Child Protection Program</option>
                                <option value="Youth Development Services">Youth Development Services</option>
                                @endif
                                
                                @if($vulnerableGroups['total_vulnerable'] > 1)
                                <option value="Comprehensive Vulnerable Support">Comprehensive Vulnerable Support ({{ $vulnerableGroups['total_vulnerable'] }} Total)</option>
                                @endif
                            </optgroup>
                            @endif
                            
                            <optgroup label="General Community Programs">
                                <option value="Medical Mission">Medical Mission</option>
                                <option value="Food Distribution Program">Food Distribution Program</option>
                                <option value="Health and Wellness Campaign">Health and Wellness Campaign</option>
                                <option value="Livelihood Training Program">Livelihood Training Program</option>
                                <option value="Disaster Preparedness Training">Disaster Preparedness Training</option>
                                <option value="Clean-up Drive">Clean-up Drive</option>
                                <option value="Youth Sports League">Youth Sports League</option>
                                <option value="Infrastructure Development">Infrastructure Development</option>
                                <option value="Environmental Protection">Environmental Protection</option>
                                <option value="Community Building Activity">Community Building Activity</option>
                                <option value="Evacuee Program">Evacuee Program</option>
                                <option value="Others">Others (custom)</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group" id="customGroup" style="display:none;">
                        <label class="form-label">Custom Program Name</label>
                        <input type="text" name="custom_title" id="customTitle" class="form-control" placeholder="Enter program name…">
                    </div>

                    <div class="form-group">
                        <label class="form-label" id="locationLabel">Purok / Location</label>
                        <select name="location" id="locationSelect" class="form-control" onchange="handleLocationChange()">
                            <option value="">Select Purok...</option>
                            @foreach($allPuroks as $purok)
                            <option value="{{ $purok }}">{{ $purok }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="recommendationsGroup" style="display:none;">
                        <label class="form-label">
                            <i class="fas fa-lightbulb" style="color: var(--amber); margin-right: 4px;"></i>
                            Recommended Programs for This Purok
                        </label>
                        <div id="recommendationsList" style="background: var(--slate-light); padding: 12px; border-radius: 8px; border-left: 4px solid var(--amber);">
                            <div style="font-size: 12px; color: var(--text-muted); text-align: center;">
                                Select a purok to see recommendations
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="dssRecommendationsGroup" style="display:none;">
                        <label class="form-label">
                            <i class="fas fa-chart-line" style="color: var(--teal); margin-right: 4px;"></i>
                            DSS Evacuee Analytics & Recommendations
                        </label>
                        <div id="dssRecommendationsList" style="background: var(--slate-light); padding: 12px; border-radius: 8px; border-left: 4px solid var(--teal);">
                            <div style="font-size: 12px; color: var(--text-muted); text-align: center;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 16px; margin-bottom: 8px;"></i>
                                <div>Loading evacuation area analytics...</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Describe the program…"></textarea>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">End Date (optional)</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-floppy-disk"></i> <span id="submitLabel">Add Program</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══ LOGOUT MODAL ══ -->
    <div class="modal-backdrop" id="logoutBackdrop">
        <div class="modal-box" style="max-width:380px;">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Confirm Logout</div>
                    <div class="modal-head-sub">You will be signed out of B-DEAMS.</div>
                </div>
                <button class="modal-close" onclick="closeLogoutModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13.5px;color:var(--text-mid);line-height:1.6;">Are you sure you want to log out?</p>
                <div class="modal-footer">
                    <button class="btn-cancel" onclick="closeLogoutModal()">Stay</button>
                    <button class="btn-submit danger" onclick="document.getElementById('logoutForm').submit()">
                        <i class="fas fa-right-from-bracket"></i> Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ── Modal helpers ──
        function openBD(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
        function closeBD(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }

        ['programBackdrop','logoutBackdrop'].forEach(id => {
            document.getElementById(id).addEventListener('click', e => { if(e.target.id===id) closeBD(id); });
        });

        function openLogoutModal()  { openBD('logoutBackdrop'); }
        function closeLogoutModal() { closeBD('logoutBackdrop'); }

        function openAddModal() {
            document.getElementById('modalTitle').textContent  = 'Add New Program';
            document.getElementById('modalSub').textContent    = 'Fill in details to create a program.';
            document.getElementById('submitLabel').textContent = 'Add Program';
            document.getElementById('formMethod').value        = 'POST';
            document.getElementById('programForm').action      = '{{ route("program.store") }}';
            document.getElementById('programForm').reset();
            document.getElementById('customGroup').style.display = 'none';
            document.getElementById('recommendationsGroup').style.display = 'none';
            openBD('programBackdrop');
        }

        function closeModal() { closeBD('programBackdrop'); }

        function editProgram(id) {
            fetch(`/program/${id}`)
                .then(r => r.json())
                .then(p => {
                    document.getElementById('modalTitle').textContent  = 'Edit Program';
                    document.getElementById('modalSub').textContent    = 'Update program details below.';
                    document.getElementById('submitLabel').textContent = 'Save Changes';
                    document.getElementById('formMethod').value        = 'PUT';
                    document.getElementById('programForm').action      = `/program/${id}`;

                    document.querySelector('select[name="title"]').value       = p.title;
                    document.querySelector('select[name="location"]').value    = p.location || '';
                    document.querySelector('textarea[name="description"]').value = p.description || '';
                    document.querySelector('input[name="start_date"]').value   = p.start_date ? p.start_date.slice(0,10) : '';
                    document.querySelector('input[name="end_date"]').value     = p.end_date   ? p.end_date.slice(0,10)   : '';
                    document.getElementById('customGroup').style.display       = 'none';
                    
                    // Load recommendations if location is set
                    if (p.location) {
                        handleLocationChange();
                    } else {
                        document.getElementById('recommendationsGroup').style.display = 'none';
                        hideDSSRecommendations();
                    }

                    openBD('programBackdrop');
                })
                .catch(() => alert('Error loading program data.'));
        }

        // ── Handle location change for both program types
        function handleLocationChange() {
            const programTitleSelect = document.getElementById('programTitleSelect');
            const selectedProgram = programTitleSelect.value;
            const locationSelect = document.getElementById('locationSelect');
            const selectedLocation = locationSelect.value;
            
            if (selectedProgram === 'Evacuee Program') {
                // Handle evacuation area selection for DSS analytics
                if (selectedLocation) {
                    loadDSSAnalytics(selectedLocation);
                } else {
                    hideDSSRecommendations();
                }
            } else {
                // Handle regular purok selection for program recommendations
                if (selectedLocation) {
                    loadRecommendations();
                } else {
                    document.getElementById('recommendationsGroup').style.display = 'none';
                }
                hideDSSRecommendations();
            }
        }

        // Handle program type selection
        document.getElementById('programTitleSelect').addEventListener('change', function() {
            const selectedProgram = this.value;
            const locationLabel = document.getElementById('locationLabel');
            const locationSelect = document.getElementById('locationSelect');
            const recommendationsGroup = document.getElementById('recommendationsGroup');
            
            console.log('Program selection changed to:', selectedProgram);
            
            if (selectedProgram === 'Evacuee Program') {
                console.log('Evacuee Program selected - fetching facilities');
                // Change label to Evacuation Area
                locationLabel.textContent = 'Evacuation Area';
                
                // Clear current options and show loading
                locationSelect.innerHTML = '<option value="">Loading evacuation areas...</option>';
                
                // Use facilities data from the view
                const facilitiesData = @json($facilities);
                console.log('Facilities data from view:', facilitiesData);
                
                // Clear loading indicator
                locationSelect.innerHTML = '<option value="">Select Evacuation Area...</option>';
                
                if (Array.isArray(facilitiesData) && facilitiesData.length > 0) {
                    // Add real facilities from database
                    facilitiesData.forEach(facility => {
                        const option = document.createElement('option');
                        option.value = facility.name;
                        option.textContent = facility.name;
                        locationSelect.appendChild(option);
                    });
                } else {
                    // Fallback to default evacuation areas if no facilities exist
                    const defaultEvacuationAreas = [
                        { name: 'Barangay Hall' },
                        { name: 'Purok I Chapel' },
                        { name: 'Purok II Community Center' },
                        { name: 'Purok III School' },
                        { name: 'Purok IV Basketball Court' },
                        { name: 'Purok V Multi-Purpose Hall' }
                    ];
                    
                    defaultEvacuationAreas.forEach(area => {
                        const option = document.createElement('option');
                        option.value = area.name;
                        option.textContent = area.name;
                        locationSelect.appendChild(option);
                    });
                }
                
                // Hide regular recommendations for evacuee program (different logic applies)
                recommendationsGroup.style.display = 'none';
            } else {
                // Reset to Purok selection
                locationLabel.textContent = 'Purok / Location';
                locationSelect.innerHTML = '<option value="">Select Purok…</option>';
                
                // Add back original purok options
                const puroks = ['Purok I', 'Purok II', 'Purok III', 'Purok IV', 'Purok V'];
                puroks.forEach(purok => {
                    const option = document.createElement('option');
                    option.value = purok;
                    option.textContent = purok;
                    locationSelect.appendChild(option);
                });
                
                // Show recommendations if there's a selected purok
                if (locationSelect.value) {
                    loadRecommendations();
                } else {
                    recommendationsGroup.style.display = 'none';
                }
            }
            
            // Hide DSS recommendations when switching program types
            hideDSSRecommendations();
        });
        
        // ── Load recommendations based on purok selection ──
        function loadRecommendations() {
            const locationSelect = document.getElementById('locationSelect');
            const recommendationsGroup = document.getElementById('recommendationsGroup');
            const recommendationsList = document.getElementById('recommendationsList');
            const programTitleSelect = document.getElementById('programTitleSelect');
            
            const selectedPurok = locationSelect.value;
            const selectedProgram = programTitleSelect.value;
            
            // Don't show recommendations for Evacuee Program
            if (selectedProgram === 'Evacuee Program') {
                recommendationsGroup.style.display = 'none';
                return;
            }
            
            if (!selectedPurok) {
                recommendationsGroup.style.display = 'none';
                return;
            }
            
            // Show recommendations section
            recommendationsGroup.style.display = 'block';
            
            // Define recommendations based on the analysis from products/index.blade.php
            const purokRecommendations = {
                'Purok I': ['Senior Citizen Care', 'Medical Mission', 'Health and Wellness Campaign'],
                'Purok II': ['Child Protection', 'Educational Support', 'Educational Assistance Program'],
                'Purok III': ['PWD Assistance', 'Accessibility Programs', 'Infrastructure Development'],
                'Purok IV': ['Maternal Health', 'Nutrition Program', 'Food Distribution Program'],
                'Purok V': ['Food Security', 'Livelihood Training', 'Community Building Activity']
            };
            
            const recommendations = purokRecommendations[selectedPurok] || [];
            
            // Display recommendations
            let html = '<div style="margin-bottom: 8px; font-weight: 600; color: var(--navy); font-size: 12px;">';
            html += '<i class="fas fa-map-marker-alt" style="color: var(--amber); margin-right: 4px; font-size: 10px;"></i>';
            html += 'Suggested programs for ' + selectedPurok;
            html += '</div>';
            
            html += '<div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 8px;">';
            recommendations.slice(0, 3).forEach(program => {
                html += '<span class="recommendation-tag" onclick="selectProgram(\'' + program + '\')" style="background: white; border: 1px solid var(--border); padding: 4px 8px; border-radius: 6px; font-size: 11px; color: var(--text-mid); cursor: pointer; transition: all 0.2s;">';
                html += '<i class="fas fa-plus-circle" style="color: var(--teal); margin-right: 3px; font-size: 9px;"></i>';
                html += program;
                html += '</span>';
            });
            html += '</div>';
            
            html += '<div style="font-size: 10px; color: var(--text-muted);">';
            html += '<i class="fas fa-chart-line" style="margin-right: 2px;"></i>';
            html += 'Based on family demographics analysis';
            html += '</div>';
            
            recommendationsList.innerHTML = html;
            
            // Add hover effects to recommendation tags
            setTimeout(() => {
                document.querySelectorAll('.recommendation-tag').forEach(tag => {
                    tag.addEventListener('mouseenter', function() {
                        this.style.background = 'var(--teal-light)';
                        this.style.borderColor = 'var(--teal)';
                        this.style.color = 'var(--navy)';
                    });
                    tag.addEventListener('mouseleave', function() {
                        this.style.background = 'white';
                        this.style.borderColor = 'var(--border)';
                        this.style.color = 'var(--text-mid)';
                    });
                });
            }, 100);
        }
        
        // ── Select program from recommendations ──
        function selectProgram(programName) {
            const programTitleSelect = document.getElementById('programTitleSelect');
            
            // Check if the program exists in the dropdown
            let found = false;
            for (let i = 0; i < programTitleSelect.options.length; i++) {
                if (programTitleSelect.options[i].value === programName) {
                    programTitleSelect.selectedIndex = i;
                    found = true;
                    break;
                }
            }
            
            // If not found, select "Others" and fill the custom field
            if (!found) {
                programTitleSelect.value = 'Others';
                document.getElementById('customGroup').style.display = 'block';
                document.getElementById('customTitle').value = programName;
                document.getElementById('customTitle').required = true;
            }
            
            // Trigger change event to handle custom title display
            programTitleSelect.dispatchEvent(new Event('change'));
            
            // Show toast notification
            showToast('Program selected: ' + programName);
        }
        
        // ── Toast notification helper ──
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-msg');
            toastMsg.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // ── Custom title toggle ──
        document.getElementById('programTitleSelect').addEventListener('change', function() {
            const grp = document.getElementById('customGroup');
            const inp = document.getElementById('customTitle');
            if (this.value === 'Others') {
                grp.style.display = 'block'; inp.required = true;
            } else {
                grp.style.display = 'none'; inp.required = false; inp.value = '';
            }
        });

        // ── Handle custom title on submit ──
        document.getElementById('programForm').addEventListener('submit', function(e) {
            const sel = document.getElementById('programTitleSelect');
            const inp = document.getElementById('customTitle');
            if (sel.value === 'Others' && inp.value.trim()) {
                const h = document.createElement('input');
                h.type = 'hidden'; h.name = 'title'; h.value = inp.value.trim();
                sel.name = 'title_original'; sel.removeAttribute('required');
                this.appendChild(h);
            }
        });

        // ── DSS Analytics Functions
        function hideDSSRecommendations() {
            document.getElementById('dssRecommendationsGroup').style.display = 'none';
        }

        function showDSSRecommendations() {
            document.getElementById('dssRecommendationsGroup').style.display = 'block';
        }

        function loadDSSAnalytics(evacuationArea) {
            showDSSRecommendations();
            const dssRecommendationsList = document.getElementById('dssRecommendationsList');
            
            // Show loading state
            dssRecommendationsList.innerHTML = `
                <div style="font-size: 12px; color: var(--text-muted); text-align: center;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 16px; margin-bottom: 8px;"></i>
                    <div>Loading evacuation area analytics for ${evacuationArea}...</div>
                </div>
            `;
            
            // Use the same data structure as EvacueeProgram
            try {
                // Get the evacuee and facilities data from the view (same as EvacueeProgram)
                const evacuees = @json($evacuees ?? []);
                const facilities = @json($facilities ?? []);
                
                const areaAnalytics = analyzeEvacuationArea(evacuees, facilities, evacuationArea);
                displayRealDSSAnalytics(evacuationArea, areaAnalytics);
            } catch (error) {
                console.error('Error analyzing evacuation data:', error);
                // Fallback to mock data if analysis fails
                displayDSSAnalytics(evacuationArea);
            }
        }

        function displayRealDSSAnalytics(evacuationArea, areaData) {
            const dssRecommendationsList = document.getElementById('dssRecommendationsList');
            
            if (!areaData || areaData.totalMembers === 0) {
                dssRecommendationsList.innerHTML = `
                    <div style="font-size: 12px; color: var(--text-muted); text-align: center; padding: 20px;">
                        <i class="fas fa-chart-line" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                        <div style="margin-bottom: 4px;">No evacuee data available for ${evacuationArea}</div>
                        <div style="font-size: 10px;">This evacuation area currently has no registered evacuees.</div>
                    </div>
                `;
                return;
            }
            
            // Determine priority level and color
            let priorityLevel = 'LOW';
            let priorityColor = 'var(--green)';
            
            if (areaData.aidPriority >= 70) {
                priorityLevel = 'HIGH';
                priorityColor = 'var(--rose)';
            } else if (areaData.aidPriority >= 40) {
                priorityLevel = 'MEDIUM';
                priorityColor = 'var(--amber)';
            }
            
            // Create vulnerable groups array
            const vulnerableGroups = [];
            if (areaData.seniorCount > 0) vulnerableGroups.push({ icon: 'user-clock', label: 'Seniors', count: areaData.seniorCount, color: '#6366f1' });
            if (areaData.childCount > 0) vulnerableGroups.push({ icon: 'child', label: 'Children', count: areaData.childCount, color: '#10b981' });
            if (areaData.infantCount > 0) vulnerableGroups.push({ icon: 'baby', label: 'Infants', count: areaData.infantCount, color: '#f59e0b' });
            if (areaData.pregnantCount > 0) vulnerableGroups.push({ icon: 'baby-carriage', label: 'Pregnant', count: areaData.pregnantCount, color: '#ec4899' });
            if (areaData.pwdCount > 0) vulnerableGroups.push({ icon: 'wheelchair', label: 'PWD', count: areaData.pwdCount, color: '#8b5cf6' });
            
            // Calculate detailed needs
            const weeklyFoodRequirement = areaData.dailyMealsNeeded * 7;
            const weeklyWaterRequirement = areaData.waterNeeded * 7;
            const clothingAdults = Math.ceil(areaData.totalMembers * 0.6);
            const purificationTablets = Math.ceil(areaData.totalMembers * 2);
            const firstAidKits = Math.ceil(areaData.totalMembers / 10);
            const showerStations = Math.ceil(areaData.totalMembers / 15);
            const familyPartitions = Math.ceil(areaData.totalMembers / 10);
            
            let html = `
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <i class="fas fa-map-marker-alt" style="color: var(--teal); font-size: 14px;"></i>
                        <span style="font-weight: 600; color: var(--text-dark); font-size: 14px;">${evacuationArea}</span>
                        <span style="background: ${priorityColor}; color: white; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 600;">
                            ${priorityLevel} PRIORITY
                        </span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-bottom: 12px;">
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--navy);">${areaData.totalMembers}</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Evacuees</div>
                        </div>
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--teal);">${Math.round(areaData.occupancy_rate)}%</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Occupancy</div>
                        </div>
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--amber);">${areaData.dailyMealsNeeded}</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Meals/Day</div>
                        </div>
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--blue);">${areaData.waterNeeded}L</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Water/Day</div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Vulnerable Groups</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                        ${vulnerableGroups.map(group => `
                            <span style="background: ${group.color}; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: 500;">
                                <i class="fas fa-${group.icon}" style="font-size: 8px; margin-right: 2px;"></i>${group.count} ${group.label}
                            </span>
                        `).join('')}
                    </div>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <i class="fas fa-box" style="margin-right: 4px;"></i>Supply Requirements
                    </div>
                    <div style="background: white; border: 1px solid var(--border); border-radius: 8px; padding: 12px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 11px;">
                            <div><i class="fas fa-utensils" style="color: var(--amber); margin-right: 4px;"></i><strong>Daily Meals:</strong> ${areaData.dailyMealsNeeded}</div>
                            <div><i class="fas fa-tint" style="color: var(--blue); margin-right: 4px;"></i><strong>Water/Day:</strong> ${areaData.waterNeeded}L</div>
                            <div><i class="fas fa-box" style="color: var(--teal); margin-right: 4px;"></i><strong>Hygiene Kits:</strong> ${areaData.hygieneKitsNeeded}</div>
                            <div><i class="fas fa-bed" style="color: var(--rose); margin-right: 4px;"></i><strong>Blankets:</strong> ${areaData.blanketsNeeded}</div>
                            <div><i class="fas fa-tshirt" style="color: var(--violet); margin-right: 4px;"></i><strong>Adult Clothing:</strong> ${clothingAdults}</div>
                            <div><i class="fas fa-medkit" style="color: var(--green); margin-right: 4px;"></i><strong>First Aid Kits:</strong> ${firstAidKits}</div>
                        </div>
                        
                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--border);">
                            <div style="font-size: 10px; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">WEEKLY REQUIREMENTS:</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 10px; color: var(--text-mid);">
                                <div>Weekly Food: ${weeklyFoodRequirement} meals</div>
                                <div>Weekly Water: ${weeklyWaterRequirement}L</div>
                                <div>Purification Tablets: ${purificationTablets}</div>
                                <div>Shower Stations: ${showerStations}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <i class="fas fa-heart" style="margin-right: 4px;"></i>Special Care Needs
                    </div>
                    <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 10px;">
                        ${areaData.infantCount > 0 ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-baby" style="color: #f59e0b; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #92400e;">Infant Care (${areaData.infantCount}):</span>
                            <div style="font-size: 9px; color: #78350f; margin-left: 20px;">
                                Baby formula, diapers, infant clothing, feeding bottles
                            </div>
                        </div>
                        ` : ''}
                        ${areaData.seniorCount > 0 ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-user-clock" style="color: #6366f1; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #4338ca;">Elderly Care (${areaData.seniorCount}):</span>
                            <div style="font-size: 9px; color: #3730a3; margin-left: 20px;">
                                Medication management, mobility aids, special dietary needs
                            </div>
                        </div>
                        ` : ''}
                        ${areaData.pregnantCount > 0 ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-baby-carriage" style="color: #ec4899; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #be185d;">Maternal Care (${areaData.pregnantCount}):</span>
                            <div style="font-size: 9px; color: #9f1239; margin-left: 20px;">
                                Prenatal vitamins, maternity clothing, regular medical check-ups
                            </div>
                        </div>
                        ` : ''}
                        ${areaData.pwdCount > 0 ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-wheelchair" style="color: #8b5cf6; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #7c3aed;">PWD Support (${areaData.pwdCount}):</span>
                            <div style="font-size: 9px; color: #6d28d9; margin-left: 20px;">
                                Accessibility equipment, assistive devices, accessible facilities
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
                
                <div>
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">DSS Recommendations</div>
                    <div style="display: grid; gap: 6px;">
                        ${areaData.recommendations.map(rec => `
                            <div style="display: flex; align-items: flex-start; gap: 6px; padding: 6px 8px; border-radius: 6px; font-size: 11px; 
                                ${rec.type === 'critical' ? 'background: #fef2f2; border-left: 2px solid var(--rose); color: #991b1b;' : 
                                  rec.type === 'warning' ? 'background: #fffbeb; border-left: 2px solid var(--amber); color: #92400e;' : 
                                  'background: #f0fdf4; border-left: 2px solid var(--green); color: #166534;'}">
                                <i class="fas fa-${rec.icon}" style="margin-top: 1px; flex-shrink: 0; font-size: 9px;"></i>
                                <span>${rec.text}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            
            dssRecommendationsList.innerHTML = html;
        }

        function displayDSSAnalytics(evacuationArea) {
            const dssRecommendationsList = document.getElementById('dssRecommendationsList');
            
            // Simulated analytics data based on evacuation area
            const analyticsData = generateMockAnalytics(evacuationArea);
            
            // Calculate detailed needs for mock data
            const weeklyFoodRequirement = analyticsData.dailyMeals * 7;
            const weeklyWaterRequirement = analyticsData.waterNeeded * 7;
            const clothingAdults = Math.ceil(analyticsData.totalEvacuees * 0.6);
            const purificationTablets = Math.ceil(analyticsData.totalEvacuees * 2);
            const firstAidKits = Math.ceil(analyticsData.totalEvacuees / 10);
            const showerStations = Math.ceil(analyticsData.totalEvacuees / 15);
            const hygieneKitsNeeded = Math.ceil(analyticsData.totalEvacuees * 0.8);
            const blanketsNeeded = Math.ceil(analyticsData.totalEvacuees * 0.7);
            
            let html = `
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <i class="fas fa-map-marker-alt" style="color: var(--teal); font-size: 14px;"></i>
                        <span style="font-weight: 600; color: var(--text-dark); font-size: 14px;">${evacuationArea}</span>
                        <span style="background: ${analyticsData.priorityColor}; color: white; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 600;">
                            ${analyticsData.priorityLevel} PRIORITY
                        </span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-bottom: 12px;">
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--navy);">${analyticsData.totalEvacuees}</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Evacuees</div>
                        </div>
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--teal);">${analyticsData.occupancyRate}%</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Occupancy</div>
                        </div>
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--amber);">${analyticsData.dailyMeals}</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Meals/Day</div>
                        </div>
                        <div style="text-align: center; padding: 8px; background: white; border-radius: 6px; border: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: var(--blue);">${analyticsData.waterNeeded}L</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Water/Day</div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Vulnerable Groups</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                        ${analyticsData.vulnerableGroups.map(group => `
                            <span style="background: ${group.color}; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: 500;">
                                <i class="fas fa-${group.icon}" style="font-size: 8px; margin-right: 2px;"></i>${group.count} ${group.label}
                            </span>
                        `).join('')}
                    </div>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <i class="fas fa-box" style="margin-right: 4px;"></i>Supply Requirements
                    </div>
                    <div style="background: white; border: 1px solid var(--border); border-radius: 8px; padding: 12px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 11px;">
                            <div><i class="fas fa-utensils" style="color: var(--amber); margin-right: 4px;"></i><strong>Daily Meals:</strong> ${analyticsData.dailyMeals}</div>
                            <div><i class="fas fa-tint" style="color: var(--blue); margin-right: 4px;"></i><strong>Water/Day:</strong> ${analyticsData.waterNeeded}L</div>
                            <div><i class="fas fa-box" style="color: var(--teal); margin-right: 4px;"></i><strong>Hygiene Kits:</strong> ${hygieneKitsNeeded}</div>
                            <div><i class="fas fa-bed" style="color: var(--rose); margin-right: 4px;"></i><strong>Blankets:</strong> ${blanketsNeeded}</div>
                            <div><i class="fas fa-tshirt" style="color: var(--violet); margin-right: 4px;"></i><strong>Adult Clothing:</strong> ${clothingAdults}</div>
                            <div><i class="fas fa-medkit" style="color: var(--green); margin-right: 4px;"></i><strong>First Aid Kits:</strong> ${firstAidKits}</div>
                        </div>
                        
                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--border);">
                            <div style="font-size: 10px; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">WEEKLY REQUIREMENTS:</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 10px; color: var(--text-mid);">
                                <div>Weekly Food: ${weeklyFoodRequirement} meals</div>
                                <div>Weekly Water: ${weeklyWaterRequirement}L</div>
                                <div>Purification Tablets: ${purificationTablets}</div>
                                <div>Shower Stations: ${showerStations}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <i class="fas fa-heart" style="margin-right: 4px;"></i>Special Care Needs
                    </div>
                    <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 10px;">
                        ${analyticsData.vulnerableGroups.find(g => g.label === 'Infants') ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-baby" style="color: #f59e0b; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #92400e;">Infant Care:</span>
                            <div style="font-size: 9px; color: #78350f; margin-left: 20px;">
                                Baby formula, diapers, infant clothing, feeding bottles
                            </div>
                        </div>
                        ` : ''}
                        ${analyticsData.vulnerableGroups.find(g => g.label === 'Seniors') ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-user-clock" style="color: #6366f1; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #4338ca;">Elderly Care:</span>
                            <div style="font-size: 9px; color: #3730a3; margin-left: 20px;">
                                Medication management, mobility aids, special dietary needs
                            </div>
                        </div>
                        ` : ''}
                        ${analyticsData.vulnerableGroups.find(g => g.label === 'Pregnant') ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-baby-carriage" style="color: #ec4899; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #be185d;">Maternal Care:</span>
                            <div style="font-size: 9px; color: #9f1239; margin-left: 20px;">
                                Prenatal vitamins, maternity clothing, regular medical check-ups
                            </div>
                        </div>
                        ` : ''}
                        ${analyticsData.vulnerableGroups.find(g => g.label === 'PWD') ? `
                        <div style="margin-bottom: 6px;">
                            <i class="fas fa-wheelchair" style="color: #8b5cf6; margin-right: 4px;"></i>
                            <span style="font-size: 10px; font-weight: 600; color: #7c3aed;">PWD Support:</span>
                            <div style="font-size: 9px; color: #6d28d9; margin-left: 20px;">
                                Accessibility equipment, assistive devices, accessible facilities
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
                
                <div>
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">DSS Recommendations</div>
                    <div style="display: grid; gap: 6px;">
                        ${analyticsData.recommendations.map(rec => `
                            <div style="display: flex; align-items: flex-start; gap: 6px; padding: 6px 8px; border-radius: 6px; font-size: 11px; 
                                ${rec.type === 'critical' ? 'background: #fef2f2; border-left: 2px solid var(--rose); color: #991b1b;' : 
                                  rec.type === 'warning' ? 'background: #fffbeb; border-left: 2px solid var(--amber); color: #92400e;' : 
                                  'background: #f0fdf4; border-left: 2px solid var(--green); color: #166534;'}">
                                <i class="fas fa-${rec.icon}" style="margin-top: 1px; flex-shrink: 0; font-size: 9px;"></i>
                                <span>${rec.text}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            
            dssRecommendationsList.innerHTML = html;
        }

        // Real Analytics Functions (mirroring EvacueeProgram logic)
        function analyzeEvacuationArea(evacuees, facilities, targetArea) {
            // Filter evacuees for the specific evacuation area
            const areaEvacuees = evacuees.filter(e => e.evacuation_area === targetArea);
            
            if (areaEvacuees.length === 0) {
                return null;
            }
            
            // Initialize area data
            const areaData = {
                area: targetArea,
                evacuees: areaEvacuees,
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
            
            // Process each evacuee
            areaEvacuees.forEach(evacuee => {
                areaData.totalMembers += evacuee.total_members || 1;
                
                // Count demographics
                if (evacuee.gender === 'Male') areaData.maleCount++;
                else areaData.femaleCount++;
                
                if (evacuee.age >= 60) areaData.seniorCount++;
                else if (evacuee.age < 18) areaData.childCount++;
                if (evacuee.age <= 5) areaData.infantCount++;
                
                if (evacuee.has_pregnant) areaData.pregnantCount++;
                if (evacuee.has_pwd) areaData.pwdCount++;
                
                if (evacuee.room_number) areaData.rooms.add(evacuee.room_number);
                
                // Calculate needs
                const familySize = evacuee.total_members || 1;
                areaData.dailyMealsNeeded += calculateDailyMeals(evacuee.age, familySize);
                areaData.waterNeeded += familySize * 4; // 4 liters per person per day
                areaData.hygieneKitsNeeded += Math.ceil(familySize * 0.8);
                areaData.blanketsNeeded += Math.ceil(familySize * 0.7);
            });
            
            // Add facility capacity information
            const facility = facilities.find(f => f.name === targetArea);
            if (facility) {
                areaData.capacity = facility.capacity || 0;
                areaData.available_spaces = facility.available_spaces || 0;
                areaData.occupancy_rate = areaData.capacity > 0 ? (areaData.totalMembers / areaData.capacity) * 100 : 0;
            } else {
                areaData.capacity = 'Unknown';
                areaData.available_spaces = 'Unknown';
                areaData.occupancy_rate = 0;
            }
            
            // Calculate aid priority based on multiple factors
            areaData.aidPriority = calculateAidPriority(areaData);
            
            // Generate specific recommendations
            areaData.recommendations = generateAreaRecommendations(areaData);
            
            return areaData;
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
                    text: `Water supply: ${area.waterNeeded} liters daily needed. Ensure adequate water delivery.`
                });
            }
            
            return recommendations.slice(0, 3); // Return top 3 recommendations
        }

        function generateMockAnalytics(evacuationArea) {
            // Generate different data based on evacuation area to simulate real variation
            const areaData = {
                'Barangay Hall': { base: 45, variance: 20 },
                'Purok I Chapel': { base: 25, variance: 10 },
                'Purok II Community Center': { base: 35, variance: 15 },
                'Purok III School': { base: 60, variance: 25 },
                'Purok IV Basketball Court': { base: 30, variance: 12 },
                'Purok V Multi-Purpose Hall': { base: 40, variance: 18 }
            };
            
            const config = areaData[evacuationArea] || { base: 30, variance: 15 };
            const totalEvacuees = config.base + Math.floor(Math.random() * config.variance);
            
            // Calculate derived metrics
            const occupancyRate = Math.min(95, Math.round((totalEvacuees / 50) * 100));
            const dailyMeals = totalEvacuees * 3;
            const waterNeeded = totalEvacuees * 4;
            
            // Generate vulnerable groups (simplified distribution)
            const vulnerableGroups = [];
            const seniorCount = Math.floor(totalEvacuees * 0.15);
            const childCount = Math.floor(totalEvacuees * 0.25);
            const infantCount = Math.floor(totalEvacuees * 0.08);
            const pregnantCount = Math.floor(totalEvacuees * 0.05);
            const pwdCount = Math.floor(totalEvacuees * 0.03);
            
            if (seniorCount > 0) vulnerableGroups.push({ icon: 'user-clock', label: 'Seniors', count: seniorCount, color: '#6366f1' });
            if (childCount > 0) vulnerableGroups.push({ icon: 'child', label: 'Children', count: childCount, color: '#10b981' });
            if (infantCount > 0) vulnerableGroups.push({ icon: 'baby', label: 'Infants', count: infantCount, color: '#f59e0b' });
            if (pregnantCount > 0) vulnerableGroups.push({ icon: 'baby-carriage', label: 'Pregnant', count: pregnantCount, color: '#ec4899' });
            if (pwdCount > 0) vulnerableGroups.push({ icon: 'wheelchair', label: 'PWD', count: pwdCount, color: '#8b5cf6' });
            
            // Generate recommendations based on data
            const recommendations = [];
            
            if (occupancyRate > 90) {
                recommendations.push({
                    type: 'critical',
                    icon: 'exclamation-triangle',
                    text: `Critical overcrowding at ${occupancyRate}%. Activate overflow shelters immediately.`
                });
            } else if (occupancyRate > 75) {
                recommendations.push({
                    type: 'warning',
                    icon: 'exclamation-circle',
                    text: `High occupancy at ${occupancyRate}%. Prepare backup facilities.`
                });
            }
            
            if (infantCount > 0) {
                recommendations.push({
                    type: 'info',
                    icon: 'baby',
                    text: `Urgent: Baby formula, diapers, and infant care supplies needed for ${infantCount} infants.`
                });
            }
            
            if (seniorCount > 0) {
                recommendations.push({
                    type: 'info',
                    icon: 'user-clock',
                    text: `Elderly care: Medication management and mobility assistance for ${seniorCount} seniors.`
                });
            }
            
            if (waterNeeded > 200) {
                recommendations.push({
                    type: 'info',
                    icon: 'tint',
                    text: `Water supply: ${waterNeeded} liters daily needed. Ensure adequate water delivery.`
                });
            }
            
            // Determine priority level
            let priorityLevel = 'LOW';
            let priorityColor = 'var(--green)';
            
            if (occupancyRate > 90 || totalEvacuees > 50) {
                priorityLevel = 'HIGH';
                priorityColor = 'var(--rose)';
            } else if (occupancyRate > 75 || totalEvacuees > 30) {
                priorityLevel = 'MEDIUM';
                priorityColor = 'var(--amber)';
            }
            
            return {
                totalEvacuees,
                occupancyRate,
                dailyMeals,
                waterNeeded,
                vulnerableGroups,
                recommendations: recommendations.slice(0, 3),
                priorityLevel,
                priorityColor
            };
        }

        // Flash auto-dismiss
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('flashAlert');
            if (f) { setTimeout(() => { f.style.opacity='0'; f.style.transition='opacity 0.4s'; setTimeout(()=>f.remove(),400); }, 4500); }
        });

        // ── Auto-update statuses ──
        setInterval(() => {
            fetch('/program/update-statuses', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(d => { if (d.success) location.reload(); })
            .catch(() => {});
        }, 60000);
    </script>
</body>
</html>