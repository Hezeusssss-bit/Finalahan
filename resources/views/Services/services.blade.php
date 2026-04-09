<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>Services — B-DEAMS</title>
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
            background: var(--teal);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: white;
            flex-shrink: 0;
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
        .stat-card.amber::before { background: var(--amber); }

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
        .stat-icon-wrap.green { background: var(--green-light); color: var(--green); }
        .stat-icon-wrap.amber { background: var(--amber-light); color: var(--amber); }

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
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
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

        .container {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            border: 1px solid var(--border);
            margin-bottom: 30px;
        }

        /* ── OFFICIALS SECTIONS ── */
        .officials-section {
            margin-bottom: 40px;
        }

        .section-header {
            background: var(--navy);
            color: white;
            padding: 20px 25px;
            border-radius: 15px 15px 0 0;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0;
        }

        .officials-list {
            background: white;
            border: 1px solid var(--border);
            border-radius: 0 0 15px 15px;
            padding: 20px;
        }

        .official-card {
            display: flex;
            align-items: center;
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            background: var(--slate-light);
        }

        .official-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .official-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            overflow: hidden;
        }

        .official-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .official-photo .default-icon {
            color: white;
            font-size: 32px;
        }

        .official-info {
            flex: 1;
        }

        .official-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .official-position {
            font-size: 14px;
            color: var(--text-mid);
            margin-bottom: 8px;
        }

        .official-details {
            display: flex;
            gap: 20px;
            margin-bottom: 8px;
        }

        .official-details span {
            font-size: 13px;
            color: var(--text-mid);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .official-details i {
            color: var(--blue);
            width: 16px;
        }

        .official-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: var(--green-light);
            color: #065f46;
        }

        .status-inactive {
            background: var(--rose-light);
            color: #9f1239;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            color: var(--border);
            margin-bottom: 20px;
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
            .stats-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .main { margin-left: 0; padding: 24px 20px; }
            .stats-row { grid-template-columns: 1fr; }
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
</style>
</head>
<body>

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-badge"><i class="fas fa-shield-alt"></i></div>
            <div>
                <div class="brand-name">B-DEAMS</div>
                <div class="brand-sub">Evacuation Alert System</div>
            </div>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('resident.index') }}" class="nav-link">
                <i class="fas fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('program.index') }}" class="nav-link">
                <i class="fas fa-clipboard-list"></i> Programs
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Services</div>
            <a href="{{ route('services') }}" class="nav-link active">
                <i class="fas fa-concierge-bell"></i> Services
            </a>
            <a href="{{ route('tryall') }}" class="nav-link">
                <i class="fas fa-sms"></i> SMS Alert
            </a>
            <a href="{{ route('facilities') }}" class="nav-link">
                <i class="fas fa-building"></i> Facilities
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
            <p class="page-eyebrow">Services</p>
            <h1 class="page-title">Barangay Officials</h1>
        </div>

        <!-- Stats -->
        <div class="stats-row anim delay-1">
            <div class="stat-card navy">
                <div class="stat-row-inner">
                    <div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-icon-wrap navy">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $officials->count() }}</div>
                <div class="stat-label">Total Officials</div>
            </div>

            
            <div class="stat-card amber">
                <div class="stat-row-inner">
                    <div>
                        <div class="stat-label">Leadership</div>
                    </div>
                    <div class="stat-icon-wrap amber">
                        <i class="fas fa-crown"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $captains->count() }}/1</div>
                <div class="stat-label">Barangay Captain</div>
            </div>

            <div class="stat-card amber">
                <div class="stat-row-inner">
                    <div>
                        <div class="stat-label">Council</div>
                    </div>
                    <div class="stat-icon-wrap amber">
                        <i class="fas fa-crown"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $kagawads->count() }}/7</div>
                <div class="stat-label">Kagawad Seats</div>
            </div>
            </div>
        </div>

        <!-- Officials Panel -->
        <div class="panel anim delay-2">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-users"></i> Barangay Officials Management
                </div>
                <button onclick="openAddOfficialModal()" class="btn-submit" style="padding: 8px 20px; font-size: 13px;">
                    <i class="fas fa-plus"></i> Add Official
                </button>
            </div>
            <div class="panel-body">
                <!-- Barangay Captain Section -->
                <div class="officials-section">
                    <div class="section-header">
                        <i class="fas fa-crown"></i> Barangay Captain
                    </div>
                    <div class="officials-list">
                        @forelse($captains as $official)
                          <div class="official-card">
                            <div class="official-photo">
                              @if($official->photo_path)
                                <img src="{{ asset('storage/' . $official->photo_path) }}" alt="{{ $official->full_name }}">
                              @else
                                <i class="fas fa-user default-icon"></i>
                              @endif
                            </div>
                            <div class="official-info">
                              <div class="official-name">{{ $official->full_name }}</div>
                              <div class="official-position">Barangay Captain</div>
                              <div class="official-details">
                                @if($official->contact_number)
                                  <span><i class="fas fa-phone"></i> {{ $official->contact_number }}</span>
                                @endif
                              </div>
                              <div class="official-status {{ $official->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $official->is_active ? 'Active' : 'Inactive' }}
                              </div>
                              <div class="official-actions" style="display: flex; gap: 8px; margin-top: 12px;">
                                <button onclick="editOfficial({{ $official->id }})" class="btn-submit" style="padding: 6px 12px; font-size: 12px; background: var(--blue);">
                                  <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="deleteOfficial({{ $official->id }}, '{{ $official->full_name }}')" class="btn-cancel" style="padding: 6px 12px; font-size: 12px; background: var(--rose-light); color: var(--rose); border-color: var(--rose);">
                                  <i class="fas fa-trash"></i> Delete
                                </button>
                              </div>
                            </div>
                          </div>
                        @empty
                          <div class="empty-state">
                            <i class="fas fa-crown"></i>
                            <h3>No Barangay Captain</h3>
                            <p>No captain has been added yet.</p>
                          </div>
                        @endforelse
                    </div>
                </div>

                <!-- Kagawad Section -->
                <div class="officials-section">
                    <div class="section-header">
                        <i class="fas fa-users"></i> Kagawad
                    </div>
                    <div class="officials-list">
                        @forelse($kagawads as $official)
                          <div class="official-card">
                            <div class="official-photo">
                              @if($official->photo_path)
                                <img src="{{ asset('storage/' . $official->photo_path) }}" alt="{{ $official->full_name }}">
                              @else
                                <i class="fas fa-user default-icon"></i>
                              @endif
                            </div>
                            <div class="official-info">
                              <div class="official-name">{{ $official->full_name }}</div>
                              <div class="official-position">{{ $official->position }}</div>
                              <div class="official-details">
                                @if($official->contact_number)
                                  <span><i class="fas fa-phone"></i> {{ $official->contact_number }}</span>
                                @endif
                              </div>
                              <div class="official-status {{ $official->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $official->is_active ? 'Active' : 'Inactive' }}
                              </div>
                              <div class="official-actions" style="display: flex; gap: 8px; margin-top: 12px;">
                                <button onclick="editOfficial({{ $official->id }})" class="btn-submit" style="padding: 6px 12px; font-size: 12px; background: var(--blue);">
                                  <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="deleteOfficial({{ $official->id }}, '{{ $official->full_name }}')" class="btn-cancel" style="padding: 6px 12px; font-size: 12px; background: var(--rose-light); color: var(--rose); border-color: var(--rose);">
                                  <i class="fas fa-trash"></i> Delete
                                </button>
                              </div>
                            </div>
                          </div>
                        @empty
                          <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h3>No Kagawad</h3>
                            <p>No kagawad have been added yet.</p>
                          </div>
                        @endforelse
                    </div>
                </div>

                <!-- Other Officials Section -->
                <div class="officials-section">
                    <div class="section-header">
                        <i class="fas fa-users"></i> Other Officials
                    </div>
                    <div class="officials-list">
                        @forelse($otherOfficials as $official)
                          <div class="official-card">
                            <div class="official-photo">
                              @if($official->photo_path)
                                <img src="{{ asset('storage/' . $official->photo_path) }}" alt="{{ $official->full_name }}">
                              @else
                                <i class="fas fa-user default-icon"></i>
                              @endif
                            </div>
                            <div class="official-info">
                              <div class="official-name">{{ $official->full_name }}</div>
                              <div class="official-position">{{ $official->position }}</div>
                              <div class="official-details">
                                @if($official->contact_number)
                                  <span><i class="fas fa-phone"></i> {{ $official->contact_number }}</span>
                                @endif
                              </div>
                              <div class="official-status {{ $official->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $official->is_active ? 'Active' : 'Inactive' }}
                              </div>
                              <div class="official-actions" style="display: flex; gap: 8px; margin-top: 12px;">
                                <button onclick="editOfficial({{ $official->id }})" class="btn-submit" style="padding: 6px 12px; font-size: 12px; background: var(--blue);">
                                  <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="deleteOfficial({{ $official->id }}, '{{ $official->full_name }}')" class="btn-cancel" style="padding: 6px 12px; font-size: 12px; background: var(--rose-light); color: var(--rose); border-color: var(--rose);">
                                  <i class="fas fa-trash"></i> Delete
                                </button>
                              </div>
                            </div>
                          </div>
                        @empty
                          <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h3>No Other Officials</h3>
                            <p>No other officials have been added yet.</p>
                          </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- ══ ADD OFFICIAL MODAL ══ -->
    <div class="modal-backdrop" id="addOfficialModal">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Add New Official</div>
                    <div class="modal-head-sub">Enter official details below</div>
                </div>
                <button class="modal-close" onclick="closeModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="addOfficialForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">First Name *</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position *</label>
                        <select id="position" name="position" class="form-control" required>
                            <option value="">Select Position</option>
                            <option value="Captain" {{ $currentCaptainsCount >= 1 ? 'disabled' : '' }}>Captain ({{ $currentCaptainsCount }}/1)</option>
                            <option value="Kagawad" {{ $currentKagawadsCount >= 7 ? 'disabled' : '' }}>Kagawad ({{ $currentKagawadsCount }}/7)</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Treasurer">Treasurer</option>
                            <option value="SK Chairman">SK Chairman</option>
                        </select>
                    </div>
                                        <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Term Start *</label>
                        <input type="date" id="term_start" name="term_start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Term End *</label>
                        <input type="date" id="term_end" name="term_end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea id="notes" name="notes" class="form-control" placeholder="Additional notes..."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="radio-group">
                            <label class="radio-opt">
                                <input type="radio" name="is_active" value="1" checked>
                                Active
                            </label>
                            <label class="radio-opt">
                                <input type="radio" name="is_active" value="0">
                                Inactive
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Save Official
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══ EDIT OFFICIAL MODAL ══ -->
    <div class="modal-backdrop" id="editOfficialModal">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Edit Official</div>
                    <div class="modal-head-sub">Update official details below</div>
                </div>
                <button class="modal-close" onclick="closeEditModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="editOfficialForm">
                    @csrf
                    <input type="hidden" id="edit_official_id" name="official_id">
                    <div class="form-group">
                        <label class="form-label">First Name *</label>
                        <input type="text" id="edit_first_name" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name *</label>
                        <input type="text" id="edit_last_name" name="last_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Middle Name</label>
                        <input type="text" id="edit_middle_name" name="middle_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position *</label>
                        <select id="edit_position" name="position" class="form-control" required>
                            <option value="">Select Position</option>
                            <option value="Captain" {{ $currentCaptainsCount >= 1 ? 'disabled' : '' }}>Captain ({{ $currentCaptainsCount }}/1)</option>
                            <option value="Kagawad" {{ $currentKagawadsCount >= 7 ? 'disabled' : '' }}>Kagawad ({{ $currentKagawadsCount }}/7)</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Treasurer">Treasurer</option>
                            <option value="SK Chairman">SK Chairman</option>
                        </select>
                    </div>
                                        <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <input type="text" id="edit_contact_number" name="contact_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" id="edit_email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Term Start *</label>
                        <input type="date" id="edit_term_start" name="term_start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Term End *</label>
                        <input type="date" id="edit_term_end" name="term_end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea id="edit_notes" name="notes" class="form-control" placeholder="Additional notes..."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="radio-group">
                            <label class="radio-opt">
                                <input type="radio" name="is_active" value="1" id="edit_active">
                                Active
                            </label>
                            <label class="radio-opt">
                                <input type="radio" name="is_active" value="0" id="edit_inactive">
                                Inactive
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Update Official
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══ LOGOUT MODAL ══ -->
    <div class="modal-backdrop" id="logoutBackdrop">
        <div class="modal-box" style="max-width:400px;">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Confirm Logout</div>
                    <div class="modal-head-sub">You will be signed out of system.</div>
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

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-circle-check"></i>
        <span id="toast-msg">Done!</span>
    </div>

<script>
        // ── Modal helpers ──
        function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }

        ['logoutBackdrop'].forEach(id => {
            document.getElementById(id).addEventListener('click', e => { if (e.target.id === id) closeModal(id); });
        });

        function openLogoutModal()    { openModal('logoutBackdrop'); }
        function closeLogoutModal()   { closeModal('logoutBackdrop'); }

// Add Official Modal Functions
function openAddOfficialModal() {
    document.getElementById('addOfficialModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeAddOfficialModal() {
    document.getElementById('addOfficialModal').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('addOfficialForm').reset();
}

// Close modal when clicking outside
document.getElementById('addOfficialModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddOfficialModal();
    }
});

// Toast Function
function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toast-msg');
    toastMsg.textContent = message;
    toast.classList.add('show');
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Form Submission
document.getElementById('addOfficialForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    fetch('{{ route('services.officials.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast(result.message);
            closeModal();
            // Add new official to the list dynamically
            addOfficialToList(result.official);
        } else {
            showToast('Error adding official. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error adding official. Please check your input.');
    });
});

// Edit Modal Functions
function openEditModal() {
    document.getElementById('editOfficialModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editOfficialModal').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('editOfficialForm').reset();
}

// Function to calculate term end (3 years after term start)
function calculateTermEnd(termStartDate) {
    if (!termStartDate) return '';
    const startDate = new Date(termStartDate);
    const endDate = new Date(startDate);
    endDate.setFullYear(startDate.getFullYear() + 3);
    return endDate.toISOString().split('T')[0]; // Return YYYY-MM-DD format
}

// Add event listeners for automatic term end calculation
document.addEventListener('DOMContentLoaded', function() {
    // Add Official Form
    const termStartInput = document.getElementById('term_start');
    const termEndInput = document.getElementById('term_end');
    
    if (termStartInput && termEndInput) {
        termStartInput.addEventListener('change', function() {
            if (this.value) {
                termEndInput.value = calculateTermEnd(this.value);
                termEndInput.min = this.value; // Set minimum date to term start
            }
        });
    }
    
    // Edit Official Form
    const editTermStartInput = document.getElementById('edit_term_start');
    const editTermEndInput = document.getElementById('edit_term_end');
    
    if (editTermStartInput && editTermEndInput) {
        editTermStartInput.addEventListener('change', function() {
            if (this.value) {
                editTermEndInput.value = calculateTermEnd(this.value);
                editTermEndInput.min = this.value; // Set minimum date to term start
            }
        });
    }
});

// Function to dynamically add official to the list
function addOfficialToList(official) {
    if (!official || !official.position) return;
    
    const officialCard = document.createElement('div');
    officialCard.className = 'official-card anim';
    officialCard.style.animation = 'fadeUp 0.4s ease both';
    
    // Determine official type
    const isCaptain = official.position.toLowerCase().includes('captain');
    const isKagawad = official.position.toLowerCase().includes('kagawad');
    
    officialCard.innerHTML = `
        <div class="official-photo">
            <i class="fas fa-user default-icon"></i>
        </div>
        <div class="official-info">
            <div class="official-name">${official.first_name} ${official.middle_name || ''} ${official.last_name}</div>
            <div class="official-position">${isCaptain ? 'Barangay Captain' : official.position}</div>
            <div class="official-details">
                ${official.contact_number ? `<span><i class="fas fa-phone"></i> ${official.contact_number}</span>` : ''}
            </div>
            <div class="official-status ${official.is_active ? 'status-active' : 'status-inactive'}">
                ${official.is_active ? 'Active' : 'Inactive'}
            </div>
            <div class="official-actions" style="display: flex; gap: 8px; margin-top: 12px;">
                <button onclick="editOfficial(${official.id})" class="btn-submit" style="padding: 6px 12px; font-size: 12px; background: var(--blue);">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button onclick="deleteOfficial(${official.id}, '${official.first_name} ${official.middle_name || ''} ${official.last_name}')" class="btn-cancel" style="padding: 6px 12px; font-size: 12px; background: var(--rose-light); color: var(--rose); border-color: var(--rose);">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    `;
    
    // Add to the appropriate section
    let targetList;
    if (isCaptain) {
        // Find captains section
        targetList = document.querySelectorAll('.officials-section')[0]?.querySelector('.officials-list');
        if (targetList?.querySelector('.empty-state')) {
            targetList.innerHTML = '';
        }
    } else if (isKagawad) {
        // Find kagawad section (second section)
        targetList = document.querySelectorAll('.officials-section')[1]?.querySelector('.officials-list');
        if (targetList?.querySelector('.empty-state')) {
            targetList.innerHTML = '';
        }
    } else {
        // Find other officials section (third section)
        targetList = document.querySelectorAll('.officials-section')[2]?.querySelector('.officials-list');
        if (targetList?.querySelector('.empty-state')) {
            targetList.innerHTML = '';
        }
    }
    
    if (targetList) {
        targetList.appendChild(officialCard);
    }
}

// Function to dynamically remove official from DOM
function removeOfficialFromDOM(officialId) {
    // Find the official card by ID and remove it
    const officialCards = document.querySelectorAll('.official-card');
    officialCards.forEach(card => {
        const editButton = card.querySelector(`button[onclick*="editOfficial(${officialId})"]`);
        const deleteButton = card.querySelector(`button[onclick*="deleteOfficial(${officialId}"]`);
        
        if (editButton || deleteButton) {
            card.style.animation = 'fadeUp 0.3s ease both reverse';
            setTimeout(() => {
                card.remove();
                
                // Check if section is now empty and show empty state
                const section = card.closest('.officials-section');
                const remainingCards = section.querySelectorAll('.official-card');
                if (remainingCards.length === 0) {
                    const officialsList = section.querySelector('.officials-list');
                    officialsList.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-${section.querySelector('.section-header i').className.includes('crown') ? 'crown' : 'users'}"></i>
                            <h3>No ${section.querySelector('.section-header').textContent.trim().replace('Barangay ', '')}</h3>
                            <p>No ${section.querySelector('.section-header').textContent.trim().replace('Barangay ', '').toLowerCase()} have been added yet.</p>
                        </div>
                    `;
                }
            }, 300);
            return;
        }
    });
}

// Edit Official Function
function editOfficial(officialId) {
    fetch(`{{ route('services.officials.get', ':id') }}`.replace(':id', officialId))
        .then(response => response.json())
        .then(official => {
            // Populate the edit form with official data
            document.getElementById('edit_official_id').value = official.id;
            document.getElementById('edit_first_name').value = official.first_name || '';
            document.getElementById('edit_last_name').value = official.last_name || '';
            document.getElementById('edit_middle_name').value = official.middle_name || '';
            document.getElementById('edit_position').value = official.position || '';
            document.getElementById('edit_contact_number').value = official.contact_number || '';
            document.getElementById('edit_email').value = official.email || '';
            document.getElementById('edit_term_start').value = official.term_start || '';
            document.getElementById('edit_term_end').value = official.term_end || '';
            document.getElementById('edit_notes').value = official.notes || '';
            
            // Set active/inactive radio button
            if (official.is_active) {
                document.getElementById('edit_active').checked = true;
            } else {
                document.getElementById('edit_inactive').checked = true;
            }
            
            openEditModal();
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading official data.');
        });
}

// Delete Official Function
function deleteOfficial(officialId, officialName) {
    if (confirm(`Are you sure you want to delete ${officialName}? This action cannot be undone.`)) {
        fetch(`{{ route('services.officials.delete', ':id') }}`.replace(':id', officialId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showToast(result.message, 'success');
                // Remove official from DOM dynamically
                removeOfficialFromDOM(officialId);
            } else {
                showToast('Error deleting official. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error deleting official. Please try again.');
        });
    }
}

// Edit Form Submission
document.getElementById('editOfficialForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const officialId = document.getElementById('edit_official_id').value;
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    fetch(`{{ route('services.officials.update', ':id') }}`.replace(':id', officialId), {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast(result.message);
            closeEditModal();
            // Reload page after 1 second to show updated official
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast('Error updating official. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error updating official. Please check your input.');
    });
});

// Close edit modal when clicking outside
document.getElementById('editOfficialModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>

</body>
</html>
