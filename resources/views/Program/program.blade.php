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
                            <option value="">Select a program type…</option>
                            <option value="Medical Mission">Medical Mission</option>
                            <option value="Clean-up Drive">Clean-up Drive</option>
                            <option value="Youth Sports League">Youth Sports League</option>
                            <option value="Disaster Preparedness Training">Disaster Preparedness Training</option>
                            <option value="Senior Citizens Outreach">Senior Citizens Outreach</option>
                            <option value="Food Distribution Program">Food Distribution Program</option>
                            <option value="Health and Wellness Campaign">Health and Wellness Campaign</option>
                            <option value="Educational Assistance Program">Educational Assistance Program</option>
                            <option value="Infrastructure Development">Infrastructure Development</option>
                            <option value="Environmental Protection">Environmental Protection</option>
                            <option value="Community Building Activity">Community Building Activity</option>
                            <option value="Livelihood Training Program">Livelihood Training Program</option>
                            <option value="Others">Others (custom)</option>
                        </select>
                    </div>

                    <div class="form-group" id="customGroup" style="display:none;">
                        <label class="form-label">Custom Program Name</label>
                        <input type="text" name="custom_title" id="customTitle" class="form-control" placeholder="Enter program name…">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Purok / Location</label>
                        <select name="location" class="form-control">
                            <option value="">Select Purok…</option>
                            @foreach(['Purok I','Purok II','Purok III','Purok IV','Purok V'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                            @endforeach
                        </select>
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
            document.getElementById('modalSub').textContent    = 'Fill in the details to create a program.';
            document.getElementById('submitLabel').textContent = 'Add Program';
            document.getElementById('formMethod').value        = 'POST';
            document.getElementById('programForm').action      = '{{ route("program.store") }}';
            document.getElementById('programForm').reset();
            document.getElementById('customGroup').style.display = 'none';
            openBD('programBackdrop');
        }

        function closeModal() { closeBD('programBackdrop'); }

        function editProgram(id) {
            fetch(`/program/${id}`)
                .then(r => r.json())
                .then(p => {
                    document.getElementById('modalTitle').textContent  = 'Edit Program';
                    document.getElementById('modalSub').textContent    = 'Update the program details below.';
                    document.getElementById('submitLabel').textContent = 'Save Changes';
                    document.getElementById('formMethod').value        = 'PUT';
                    document.getElementById('programForm').action      = `/program/${id}`;

                    document.querySelector('select[name="title"]').value       = p.title;
                    document.querySelector('select[name="location"]').value    = p.location || '';
                    document.querySelector('textarea[name="description"]').value = p.description || '';
                    document.querySelector('input[name="start_date"]').value   = p.start_date ? p.start_date.slice(0,10) : '';
                    document.querySelector('input[name="end_date"]').value     = p.end_date   ? p.end_date.slice(0,10)   : '';
                    document.getElementById('customGroup').style.display       = 'none';

                    openBD('programBackdrop');
                })
                .catch(() => alert('Error loading program data.'));
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

        // ── Flash auto-dismiss ──
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