<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Residents List — B-DEAMS</title>
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

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* ── TOP NAV ── */
        .topnav {
            background: var(--navy);
            padding: 0 40px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topnav-left { display: flex; align-items: center; gap: 16px; }

        .brand-badge {
            width: 36px; height: 36px;
            background: var(--teal);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: white;
        }

        .brand-text {
            font-family: 'Outfit', sans-serif;
            font-size: 17px; font-weight: 600;
            color: white; letter-spacing: 0.01em;
        }

        .brand-sub {
            font-size: 11px; color: rgba(255,255,255,0.4);
            font-weight: 300; letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .nav-divider {
            width: 1px; height: 28px;
            background: rgba(255,255,255,0.12);
        }

        .page-crumb {
            font-family: 'Outfit', sans-serif;
            font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,0.5);
            display: flex; align-items: center; gap: 8px;
        }

        .page-crumb span { color: white; }

        .nav-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 8px;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.75);
            text-decoration: none; font-size: 13.5px; font-weight: 500;
            transition: all 0.2s;
        }

        .nav-back:hover { background: rgba(255,255,255,0.14); color: white; }

        /* ── PAGE ── */
        .page { max-width: 1400px; margin: 0 auto; padding: 32px 40px; }

        /* ── STAT STRIP ── */
        .stat-strip {
            display: flex; gap: 12px; flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .stat-chip {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 16px;
            display: flex; align-items: center; gap: 10px;
            transition: box-shadow 0.2s;
        }

        .stat-chip:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.07); }

        .chip-val {
            font-family: 'Outfit', sans-serif;
            font-size: 20px; font-weight: 700; color: var(--text-dark);
            line-height: 1;
        }

        .chip-lbl { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }

        .chip-dot {
            width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
        }

        /* ── PANEL ── */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .panel-toolbar {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }

        .toolbar-left  { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .toolbar-right { display: flex; align-items: center; gap: 10px; }

        /* ── FILTER DROPDOWN ── */
        .filter-dropdown { position: relative; }

        .filter-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 16px; border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--slate-light);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px; font-weight: 500;
            color: var(--text-mid); cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover { border-color: var(--teal); color: var(--teal); }
        .filter-btn.active { background: var(--teal-light); border-color: var(--teal); color: #0f5e5c; }

        .filter-btn i { font-size: 11px; transition: transform 0.2s; }
        .filter-dropdown.open .filter-btn i.fa-chevron-down { transform: rotate(180deg); }

        .dropdown-panel {
            position: absolute;
            top: calc(100% + 6px); left: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(0,0,0,0.1);
            min-width: 200px;
            padding: 8px;
            z-index: 200;
            display: none;
        }

        .filter-dropdown.open .dropdown-panel { display: block; }

        .dropdown-opt {
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 13px;
            color: var(--text-mid);
            cursor: pointer;
            transition: all 0.15s;
        }

        .dropdown-opt:hover { background: var(--slate-light); color: var(--text-dark); }
        .dropdown-opt.selected { background: var(--teal-light); color: #0f5e5c; font-weight: 500; }

        /* ── SEARCH ── */
        .search-wrap { position: relative; }

        .search-wrap i {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); font-size: 13px;
        }

        .search-input {
            padding: 9px 14px 9px 36px;
            border: 1px solid var(--border); border-radius: 10px;
            font-size: 13.5px; font-family: 'DM Sans', sans-serif;
            color: var(--text-dark); background: var(--slate-light);
            transition: all 0.2s; outline: none; width: 260px;
        }

        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus {
            background: white; border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14,165,160,0.12);
        }

        /* ── TOOLBAR BUTTONS ── */
        .btn-add {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 18px; border-radius: 10px;
            background: var(--green); color: white; border: none;
            font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
            cursor: pointer; transition: all 0.2s;
        }

        .btn-add:hover { background: #059669; }

        .btn-export {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 18px; border-radius: 10px;
            background: var(--navy); color: white; border: none;
            font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
            cursor: pointer; transition: all 0.2s;
        }

        .btn-export:hover { background: var(--navy-mid); }

        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }

        table.data-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }

        .data-table thead th {
            padding: 11px 16px;
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.09em;
            color: var(--text-muted); background: var(--slate-light);
            border-bottom: 1px solid var(--border);
            white-space: nowrap; text-align: left;
        }

        .data-table thead th.sortable { cursor: pointer; user-select: none; }
        .data-table thead th.sortable:hover { color: var(--teal); }

        .data-table tbody tr {
            border-bottom: 1px solid #f1f5f9; transition: background 0.15s;
        }

        .data-table tbody tr:hover { background: #f8fafc; }
        .data-table tbody tr:last-child { border-bottom: none; }

        .data-table td { padding: 13px 16px; color: var(--text-dark); vertical-align: middle; }

        .td-id { font-family: 'Outfit', sans-serif; font-size: 12.5px; color: var(--text-muted); font-weight: 600; }

        .td-name { font-weight: 500; }

        .gender-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }

        .gender-pill.male   { background: var(--blue-light); color: #1e40af; }
        .gender-pill.female { background: #fce7f3; color: #9d174d; }

        .action-btn {
            width: 30px; height: 30px; border-radius: 7px;
            border: 1px solid var(--border); background: white;
            color: var(--text-mid); font-size: 12px;
            cursor: pointer; display: inline-flex;
            align-items: center; justify-content: center;
            transition: all 0.2s;
        }

        .action-btn:hover { background: var(--navy); color: white; border-color: var(--navy); }
        .action-btn.edit:hover  { background: var(--blue); border-color: var(--blue); }
        .action-btn.delete:hover { background: var(--rose); border-color: var(--rose); }

        .action-btns { display: flex; gap: 5px; }

        /* ── PAGINATION ── */
        .panel-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center;
            justify-content: space-between; flex-wrap: wrap; gap: 12px;
        }

        .per-page {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--text-muted);
        }

        .per-page select {
            padding: 6px 10px; border: 1px solid var(--border);
            border-radius: 8px; font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark); background: var(--slate-light);
            outline: none; cursor: pointer;
        }

        .per-page select:focus { border-color: var(--teal); }

        /* ── EMPTY ── */
        .empty-state { text-align: center; padding: 52px 20px; }
        .empty-icon {
            width: 68px; height: 68px; border-radius: 18px;
            background: var(--slate-light); display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 26px; color: var(--text-muted); margin-bottom: 14px;
        }
        .empty-title { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 600; margin-bottom: 5px; }
        .empty-msg   { font-size: 13.5px; color: var(--text-muted); }

        /* ── MODAL SYSTEM ── */
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
            width: 90%; max-width: 480px;
            max-height: 90vh; overflow-y: auto;
            scrollbar-width: none;
            animation: modalIn 0.25s cubic-bezier(0.175,0.885,0.32,1.275) both;
        }

        .modal-box.sm { max-width: 400px; }
        .modal-box.lg { max-width: 560px; }
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
            color: var(--text-muted); font-size: 13px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: all 0.2s;
        }

        .modal-close:hover { background: var(--rose-light); color: var(--rose); border-color: var(--rose); }

        .modal-body { padding: 18px 24px 24px; }

        /* ── FORM ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid .span2 { grid-column: span 2; }

        .form-group { display: flex; flex-direction: column; gap: 5px; }

        .form-label {
            font-size: 11.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.07em;
            color: var(--text-muted);
        }

        .form-control {
            padding: 9px 12px; border: 1px solid var(--border);
            border-radius: 9px; font-size: 13.5px;
            font-family: 'DM Sans', sans-serif; color: var(--text-dark);
            background: var(--slate-light); transition: all 0.2s; outline: none;
        }

        .form-control:focus {
            background: white; border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14,165,160,0.12);
        }

        .error-msg { font-size: 11.5px; color: var(--rose); }

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

        /* ── VIEW DETAILS ── */
        .detail-grid { display: flex; flex-direction: column; gap: 0; }

        .detail-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 11px 0; border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px;
        }

        .detail-row:last-child { border-bottom: none; }
        .detail-lbl { color: var(--text-muted); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.06em; }
        .detail-val { color: var(--text-dark); font-weight: 500; text-align: right; }

        /* ── FLASH ── */
        .flash-alert {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px; border-radius: 10px;
            font-size: 13.5px; margin-bottom: 18px;
        }

        .flash-alert.success { background: var(--green-light); color: #065f46; }

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

        /* ── ANIM ── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .anim     { animation: fadeUp 0.4s ease both; }
        .delay-1  { animation-delay: 0.07s; }
        .delay-2  { animation-delay: 0.13s; }

        @media (max-width: 768px) {
            .topnav { padding: 0 20px; }
            .page { padding: 22px 18px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-grid .span2 { grid-column: span 1; }
            .search-input { width: 100%; }
        }
    </style>
</head>
<body>

    <!-- TOP NAV -->
    <nav class="topnav">
        <div class="topnav-left">
            <div class="brand-badge"><i class="fas fa-shield-alt"></i></div>
            <div>
                <div class="brand-text">B-DEAMS</div>
                <div class="brand-sub">Evacuation Alert System</div>
            </div>
            <div class="nav-divider"></div>
            <div class="page-crumb">
                <i class="fas fa-users" style="font-size:12px;"></i>
                <span>Residents</span>
            </div>
        </div>
        <a href="{{ route('resident.index') }}" class="nav-back">
            <i class="fas fa-chevron-left"></i> Dashboard
        </a>
    </nav>

    <!-- PAGE -->
    <div class="page">

        @if(session('Success'))
        <div class="flash-alert success anim" id="flashAlert">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('Success') }}</span>
        </div>
        @endif

        <!-- Stat Strip -->
        <div class="stat-strip anim delay-1">
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--navy);"></div>
                <div>
                    <div class="chip-val">{{ number_format($totalResidents) }}</div>
                    <div class="chip-lbl">Total Residents</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--blue);"></div>
                <div>
                    <div class="chip-val">{{ isset($maleCount) ? number_format($maleCount) : 0 }}</div>
                    <div class="chip-lbl">Male</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:#ec4899;"></div>
                <div>
                    <div class="chip-val">{{ isset($femaleCount) ? number_format($femaleCount) : 0 }}</div>
                    <div class="chip-lbl">Female</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--amber);"></div>
                <div>
                    <div class="chip-val">{{ isset($seniorMale) ? number_format($seniorMale) : 0 }}</div>
                    <div class="chip-lbl">Senior Male</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:#f97316;"></div>
                <div>
                    <div class="chip-val">{{ isset($seniorFemale) ? number_format($seniorFemale) : 0 }}</div>
                    <div class="chip-lbl">Senior Female</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--green);"></div>
                <div>
                    <div class="chip-val">{{ isset($childMale) ? number_format($childMale) : 0 }}</div>
                    <div class="chip-lbl">Child Male</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--teal);"></div>
                <div>
                    <div class="chip-val">{{ isset($childFemale) ? number_format($childFemale) : 0 }}</div>
                    <div class="chip-lbl">Child Female</div>
                </div>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="panel anim delay-2">
            <!-- Toolbar -->
            <div class="panel-toolbar">
                <div class="toolbar-left">
                    <!-- Purok Filter -->
                    <div class="filter-dropdown" id="purokDropdown">
                        <button type="button" class="filter-btn" id="purokBtn">
                            <i class="fas fa-map-pin" style="font-size:11px;color:var(--teal);"></i>
                            Purok <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-panel">
                            <div class="dropdown-opt selected" data-value="ALL">All Purok</div>
                            <div class="dropdown-opt" data-value="Purok I">Purok I</div>
                            <div class="dropdown-opt" data-value="Purok II">Purok II</div>
                            <div class="dropdown-opt" data-value="Purok III">Purok III</div>
                            <div class="dropdown-opt" data-value="Purok IV">Purok IV</div>
                            <div class="dropdown-opt" data-value="Purok V">Purok V</div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-dropdown" id="categoryDropdown">
                        <button type="button" class="filter-btn" id="categoryBtn">
                            <i class="fas fa-filter" style="font-size:11px;color:var(--teal);"></i>
                            Category <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-panel">
                            <div class="dropdown-opt selected" data-value="ALL">All Residents</div>
                            <div class="dropdown-opt" data-value="SENIOR MALE">Senior Male</div>
                            <div class="dropdown-opt" data-value="SENIOR FEMALE">Senior Female</div>
                            <div class="dropdown-opt" data-value="MALE">Male</div>
                            <div class="dropdown-opt" data-value="FEMALE">Female</div>
                            <div class="dropdown-opt" data-value="CHILD MALE">Child Male</div>
                            <div class="dropdown-opt" data-value="CHILD FEMALE">Child Female</div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="search-wrap">
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" class="search-input"
                               placeholder="Search residents…"
                               value="{{ request('search') }}"
                               oninput="refreshFilters()" />
                    </div>
                </div>

                <div class="toolbar-right">
                    <button class="btn-add" onclick="openAddModal()">
                        <i class="fas fa-user-plus"></i> Add Resident
                    </button>
                    <button class="btn-export" onclick="exportToCSV()">
                        <i class="fas fa-file-csv"></i> Export
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-wrap">
                <table class="data-table" id="residentsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th class="sortable" onclick="sortTable(1,'string')">Last Name <i class="fas fa-sort" style="opacity:0.4;margin-left:4px;"></i></th>
                            <th class="sortable" onclick="sortTable(2,'string')">First Name <i class="fas fa-sort" style="opacity:0.4;margin-left:4px;"></i></th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Added On</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residents as $resident)
                        <tr data-gender="{{ $resident->gender ?? '' }}">
                            <td class="td-id">{{ str_pad($resident->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="td-name">{{ $resident->qty }}</td>
                            <td>{{ $resident->name }}</td>
                            <td>{{ $resident->price }}</td>
                            <td>
                                @if($resident->gender)
                                <span class="gender-pill {{ strtolower($resident->gender) === 'male' ? 'male' : 'female' }}">
                                    <i class="fas fa-{{ strtolower($resident->gender) === 'male' ? 'mars' : 'venus' }}" style="font-size:10px;"></i>
                                    {{ $resident->gender }}
                                </span>
                                @else
                                <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>
                            <td style="color:var(--text-mid);">{{ $resident->description ?? '—' }}</td>
                            <td style="color:var(--text-mid);font-size:13px;">{{ $resident->contact_number ?? '—' }}</td>
                            <td style="color:var(--text-muted);font-size:12.5px;">{{ $resident->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="action-btns" style="justify-content:flex-end;">
                                    <button class="action-btn" onclick="openViewModal({{ $resident->id }})" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn edit" title="Edit"
                                        onclick="openEditModal('{{ route('resident.update', $resident->id) }}','{{ addslashes($resident->name) }}','{{ $resident->qty }}','{{ $resident->price }}','{{ addslashes($resident->description) }}','{{ $resident->gender }}','{{ $resident->contact_number }}')">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="action-btn delete" title="Delete"
                                        onclick="openDeleteModal('{{ route('resident.destroy', $resident->id) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-users"></i></div>
                                    <div class="empty-title">No Residents Found</div>
                                    <div class="empty-msg">Add your first resident using the button above.</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer / Pagination -->
            <div class="panel-footer">
                <div class="per-page">
                    <span>Show</span>
                    <select onchange="changePerPage(this.value)">
                        <option value="10"  {{ request('per_page')==10  ?'selected':'' }}>10</option>
                        <option value="25"  {{ request('per_page')==25  ?'selected':'' }}>25</option>
                        <option value="50"  {{ request('per_page')==50  ?'selected':'' }}>50</option>
                        <option value="100" {{ request('per_page')==100 ?'selected':'' }}>100</option>
                    </select>
                    <span>per page</span>
                </div>
                <div style="font-size:12.5px;color:var(--text-muted);">
                    {{ $residents->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div><!-- /page -->

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-circle-check"></i>
        <span id="toast-msg">Done!</span>
    </div>

    <!-- ══ ADD RESIDENT MODAL ══ -->
    <div class="modal-backdrop" id="addBackdrop">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Add New Resident</div>
                    <div class="modal-head-sub">Fill in the details to register a resident.</div>
                </div>
                <button class="modal-close" onclick="closeAddModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('resident.store') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Maria" value="{{ old('name') }}">
                            @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="qty" class="form-control" placeholder="e.g. Santos" value="{{ old('qty') }}">
                            @error('qty')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Age</label>
                            <input type="text" name="price" class="form-control" placeholder="e.g. 34" value="{{ old('price') }}">
                            @error('price')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="" disabled selected>Select…</option>
                                <option value="Male"   {{ old('gender')=='Male'?'selected':'' }}>Male</option>
                                <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
                            </select>
                            @error('gender')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address (Purok)</label>
                            <select name="description" class="form-control">
                                <option value="" disabled selected>Select Purok…</option>
                                @foreach(['Purok I','Purok II','Purok III','Purok IV','Purok V'] as $p)
                                <option value="{{ $p }}" {{ old('description')==$p?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                            @error('description')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" placeholder="e.g. 09..." value="{{ old('contact_number') }}">
                            @error('contact_number')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeAddModal()">Cancel</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-floppy-disk"></i> Save Resident
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══ EDIT RESIDENT MODAL ══ -->
    <div class="modal-backdrop" id="editBackdrop">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Edit Resident</div>
                    <div class="modal-head-sub">Update the resident's information below.</div>
                </div>
                <button class="modal-close" onclick="closeEditModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="editResidentForm" method="POST" onsubmit="return confirmEdit(event)">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="qty" id="edit_qty" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Age</label>
                            <input type="text" name="price" id="edit_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="edit_gender" class="form-control">
                                <option value="" disabled>Select…</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address (Purok)</label>
                            <select name="description" id="edit_description" class="form-control">
                                <option value="" disabled>Select Purok…</option>
                                @foreach(['Purok I','Purok II','Purok III','Purok IV','Purok V'] as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="edit_contact_number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-floppy-disk"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══ CONFIRM EDIT MODAL ══ -->
    <div class="modal-backdrop" id="confirmBackdrop">
        <div class="modal-box sm">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Confirm Changes</div>
                    <div class="modal-head-sub">Please verify the details before saving.</div>
                </div>
                <button class="modal-close" onclick="closeConfirmModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="detail-grid">
                    <div class="detail-row"><span class="detail-lbl">First Name</span><span class="detail-val" id="confirm_name">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Last Name</span><span class="detail-val" id="confirm_qty">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Age</span><span class="detail-val" id="confirm_price">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Address</span><span class="detail-val" id="confirm_desc">—</span></div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" onclick="closeConfirmModal()">Back</button>
                    <button class="btn-submit" onclick="submitEditForm()">
                        <i class="fas fa-check"></i> Confirm & Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ VIEW RESIDENT MODAL ══ -->
    <div class="modal-backdrop" id="viewBackdrop">
        <div class="modal-box sm">
            <div class="modal-head">
                <div class="modal-head-title">Resident Details</div>
                <button class="modal-close" onclick="closeViewModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="detail-grid">
                    <div class="detail-row"><span class="detail-lbl">ID</span><span class="detail-val" id="view_id">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">First Name</span><span class="detail-val" id="view_name">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Last Name</span><span class="detail-val" id="view_qty">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Age</span><span class="detail-val" id="view_price">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Address</span><span class="detail-val" id="view_description">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Contact</span><span class="detail-val" id="view_contact_number">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Added On</span><span class="detail-val" id="view_created">—</span></div>
                    <div class="detail-row"><span class="detail-lbl">Last Updated</span><span class="detail-val" id="view_updated">—</span></div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" onclick="closeViewModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ DELETE MODAL ══ -->
    <div class="modal-backdrop" id="deleteBackdrop">
        <div class="modal-box sm">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Delete Resident</div>
                    <div class="modal-head-sub">This action cannot be undone.</div>
                </div>
                <button class="modal-close" onclick="closeDeleteModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13.5px;color:var(--text-mid);line-height:1.6;margin-bottom:4px;">
                    Are you sure you want to permanently delete this resident?
                </p>
                <div class="modal-footer">
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-submit danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ── Modal helpers ──
        function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }

        ['addBackdrop','editBackdrop','confirmBackdrop','viewBackdrop','deleteBackdrop'].forEach(id => {
            document.getElementById(id).addEventListener('click', e => { if (e.target.id===id) closeModal(id); });
        });

        function openAddModal()       { openModal('addBackdrop'); }
        function closeAddModal()      { closeModal('addBackdrop'); }
        function closeEditModal()     { closeModal('editBackdrop'); }
        function closeConfirmModal()  { closeModal('confirmBackdrop'); }
        function closeViewModal()     { closeModal('viewBackdrop'); }
        function closeDeleteModal()   { closeModal('deleteBackdrop'); }

        function openDeleteModal(action) {
            document.getElementById('deleteForm').action = action;
            openModal('deleteBackdrop');
        }

        function openEditModal(action, name, qty, price, description, gender, contact='') {
            document.getElementById('editResidentForm').action = action;
            document.getElementById('edit_name').value           = name;
            document.getElementById('edit_qty').value            = qty;
            document.getElementById('edit_price').value          = price;
            document.getElementById('edit_description').value    = description;
            document.getElementById('edit_gender').value         = gender || '';
            document.getElementById('edit_contact_number').value = contact;
            openModal('editBackdrop');
        }

        function confirmEdit(e) {
            e.preventDefault();
            document.getElementById('confirm_name').textContent  = document.getElementById('edit_name').value;
            document.getElementById('confirm_qty').textContent   = document.getElementById('edit_qty').value;
            document.getElementById('confirm_price').textContent = document.getElementById('edit_price').value;
            document.getElementById('confirm_desc').textContent  = document.getElementById('edit_description').value || '—';
            openModal('confirmBackdrop');
            return false;
        }

        function submitEditForm() {
            closeConfirmModal();
            document.getElementById('editResidentForm').submit();
        }

        function openViewModal(id) {
            fetch(`/residents/${id}`)
                .then(r => r.json())
                .then(d => {
                    document.getElementById('view_id').textContent           = d.id;
                    document.getElementById('view_name').textContent         = d.name;
                    document.getElementById('view_qty').textContent          = d.qty;
                    document.getElementById('view_price').textContent        = d.price;
                    document.getElementById('view_description').textContent  = d.description || '—';
                    document.getElementById('view_contact_number').textContent = d.contact_number || '—';
                    document.getElementById('view_created').textContent      = d.created_at;
                    document.getElementById('view_updated').textContent      = d.updated_at;
                    openModal('viewBackdrop');
                })
                .catch(() => alert('Error loading resident details.'));
        }

        // ── Filter dropdowns ──
        let currentPurok    = 'ALL';
        let currentCategory = 'ALL';

        function setupDropdown(dropdownId, btnId, onSelect) {
            const dd  = document.getElementById(dropdownId);
            const btn = document.getElementById(btnId);
            btn.addEventListener('click', e => { e.stopPropagation(); dd.classList.toggle('open'); });
            document.addEventListener('click', () => dd.classList.remove('open'));
            dd.querySelectorAll('.dropdown-opt').forEach(opt => {
                opt.addEventListener('click', e => {
                    e.stopPropagation();
                    dd.querySelectorAll('.dropdown-opt').forEach(o => o.classList.remove('selected'));
                    opt.classList.add('selected');
                    onSelect(opt.getAttribute('data-value'), opt.textContent.trim());
                    dd.classList.remove('open');
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            setupDropdown('purokDropdown', 'purokBtn', (val, label) => {
                currentPurok = val;
                document.getElementById('purokBtn').innerHTML =
                    `<i class="fas fa-map-pin" style="font-size:11px;color:var(--teal);"></i> ${label} <i class="fas fa-chevron-down"></i>`;
                const btn = document.getElementById('purokBtn');
                btn.classList.toggle('active', val !== 'ALL');
                refreshFilters();
            });

            setupDropdown('categoryDropdown', 'categoryBtn', (val, label) => {
                currentCategory = val;
                document.getElementById('categoryBtn').innerHTML =
                    `<i class="fas fa-filter" style="font-size:11px;color:var(--teal);"></i> ${label} <i class="fas fa-chevron-down"></i>`;
                const btn = document.getElementById('categoryBtn');
                btn.classList.toggle('active', val !== 'ALL');
                refreshFilters();
            });

            // Flash auto-dismiss
            const flash = document.getElementById('flashAlert');
            if (flash) { setTimeout(() => { flash.style.opacity='0'; flash.style.transition='opacity 0.4s'; setTimeout(()=>flash.remove(),400); }, 4000); }
        });

        function refreshFilters() {
            const q    = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#residentsTable tbody tr');
            rows.forEach(row => {
                if (!row.cells[1]) return;
                let matchSearch = false;
                for (let c of row.cells) { if (c.textContent.toLowerCase().includes(q)) { matchSearch = true; break; } }

                const purokTxt = row.cells[5]?.textContent.trim() || '';
                const matchPurok = currentPurok === 'ALL' || purokTxt === currentPurok;

                const age    = parseInt(row.cells[3]?.textContent.trim(), 10);
                const gender = (row.getAttribute('data-gender') || '').toUpperCase();
                const isMale   = gender === 'MALE';
                const isFemale = gender === 'FEMALE';
                const isChild  = !isNaN(age) && age < 18;
                const isSenior = !isNaN(age) && age >= 60;

                let matchCat = true;
                switch(currentCategory) {
                    case 'SENIOR MALE':   matchCat = isSenior && isMale;   break;
                    case 'SENIOR FEMALE': matchCat = isSenior && isFemale; break;
                    case 'MALE':          matchCat = isMale;               break;
                    case 'FEMALE':        matchCat = isFemale;             break;
                    case 'CHILD MALE':    matchCat = isChild && isMale;    break;
                    case 'CHILD FEMALE':  matchCat = isChild && isFemale;  break;
                }

                row.style.display = (matchSearch && matchPurok && matchCat) ? '' : 'none';
            });
        }

        function changePerPage(val) {
            const p = new URLSearchParams(window.location.search);
            p.set('per_page', val);
            window.location.search = p.toString();
        }

        function sortTable(col, type) {
            const table = document.getElementById('residentsTable');
            const tbody = table.tBodies[0];
            const rows  = Array.from(tbody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');
            const prev  = table.getAttribute('data-sort-col');
            const dir   = prev == col && table.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
            rows.sort((a, b) => {
                const av = a.children[col]?.textContent.trim() || '';
                const bv = b.children[col]?.textContent.trim() || '';
                if (type === 'number') { return dir==='asc' ? parseFloat(av)-parseFloat(bv) : parseFloat(bv)-parseFloat(av); }
                return dir==='asc' ? av.localeCompare(bv) : bv.localeCompare(av);
            });
            rows.forEach(r => tbody.appendChild(r));
            table.setAttribute('data-sort-col', col);
            table.setAttribute('data-sort-dir', dir);
        }

        // ── Export to CSV function ──
        function exportToCSV() {
            const table = document.getElementById('residentsTable');
            const rows = table.querySelectorAll('tbody tr');
            const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
            
            if (visibleRows.length === 0) {
                showToast('No data to export');
                return;
            }

            // Create CSV content
            let csvContent = 'ID,Last Name,First Name,Age,Gender,Address,Contact,Added On\n';
            
            visibleRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    cells[0]?.textContent.trim() || '',
                    cells[1]?.textContent.trim() || '',
                    cells[2]?.textContent.trim() || '',
                    cells[3]?.textContent.trim() || '',
                    cells[4]?.textContent.trim().replace(/\s+/g, ' ').trim() || '',
                    cells[5]?.textContent.trim() || '',
                    cells[6]?.textContent.trim() || '',
                    cells[7]?.textContent.trim() || ''
                ];
                
                // Escape quotes and wrap in quotes if contains comma
                const escapedRow = rowData.map(cell => {
                    if (cell.includes(',') || cell.includes('"')) {
                        return '"' + cell.replace(/"/g, '""') + '"';
                    }
                    return cell;
                });
                
                csvContent += escapedRow.join(',') + '\n';
            });

            // Create download link
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            // Generate filename with timestamp
            const timestamp = new Date().toISOString().replace(/[:.]/g, '-').slice(0, 19);
            link.setAttribute('href', url);
            link.setAttribute('download', `residents_export_${timestamp}.csv`);
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showToast('Export completed successfully');
        }

        // ── Toast helper ──
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-msg');
            toastMsg.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>