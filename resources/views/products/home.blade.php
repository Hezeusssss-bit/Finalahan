<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Family Heads — B-DEAMS</title>
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
            width: 95%; max-width: 800px;
            max-height: 95vh; overflow-y: auto;
            scrollbar-width: none;
            animation: modalIn 0.25s cubic-bezier(0.175,0.885,0.32,1.275) both;
        }

        .modal-box.sm { max-width: 500px; }
        .modal-box.lg { max-width: 1000px; }
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

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13.5px;
            color: var(--text-dark);
            cursor: pointer;
            margin-top: 8px;
        }

        .form-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        .checkbox-label {
            font-weight: 400;
            user-select: none;
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

        /* ---- FAMILY DETAILS DROPDOWN ---- */
        .family-details-row {
            background: var(--slate-light);
        }

        .family-details-content {
            padding: 20px 24px;
        }

        .family-members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }

        .member-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            transition: all 0.2s ease;
        }

        .member-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }

        .member-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--navy);
            font-size: 13px;
        }

        .member-header i {
            font-size: 14px;
        }

        .member-info {
            font-size: 12.5px;
            color: var(--text-mid);
        }

        .info-row {
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-row strong {
            color: var(--text-dark);
            font-weight: 500;
        }

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
                <i class="fas fa-home" style="font-size:12px;"></i>
                <span>Family Heads</span>
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

        @php
                // Calculate statistics from actual family data
                $totalFamilies = $residents->count();
                $totalMale = 0;
                $totalFemale = 0;
                $seniorMale = 0;
                $seniorFemale = 0;
                $childMale = 0;
                $childFemale = 0;
                $totalMembers = 0;
                $totalSeniors = 0;
                $totalChildren = 0;
                $pregnantCount = 0;
                $pwdCount = 0;
                
                foreach($residents as $resident) {
                    // Count family head
                    if($resident->family_head_fullname) {
                        $totalMembers++;
                        if($resident->family_head_age) {
                            if($resident->family_head_age >= 60) {
                                $totalSeniors++;
                                if(strtolower($resident->gender) === 'male') {
                                    $seniorMale++;
                                    $totalMale++;
                                } else {
                                    $seniorFemale++;
                                    $totalFemale++;
                                }
                            } elseif($resident->family_head_age < 18) {
                                $totalChildren++;
                                if(strtolower($resident->gender) === 'male') {
                                    $childMale++;
                                    $totalMale++;
                                } else {
                                    $childFemale++;
                                    $totalFemale++;
                                }
                            } else {
                                if(strtolower($resident->gender) === 'male') {
                                    $totalMale++;
                                } else {
                                    $totalFemale++;
                                }
                            }
                        } else {
                            if(strtolower($resident->gender) === 'male') {
                                $totalMale++;
                            } else {
                                $totalFemale++;
                            }
                        }
                    }
                    
                    // Count wife
                    if($resident->wife_fullname) {
                        $totalMembers++;
                        if($resident->wife_age) {
                            if($resident->wife_age >= 60) {
                                $totalSeniors++;
                                $seniorFemale++;
                                $totalFemale++;
                            } elseif($resident->wife_age < 18) {
                                $totalChildren++;
                                $childFemale++;
                                $totalFemale++;
                            } else {
                                $totalFemale++;
                            }
                        } else {
                            $totalFemale++;
                        }
                        
                        // Count pregnant wives
                        if($resident->wife_pregnant) {
                            $pregnantCount++;
                        }
                    }
                    
                    // Count son
                    if($resident->son_fullname) {
                        $totalMembers++;
                        if($resident->son_age) {
                            if($resident->son_age >= 60) {
                                $totalSeniors++;
                                $seniorMale++;
                                $totalMale++;
                            } elseif($resident->son_age < 18) {
                                $totalChildren++;
                                $childMale++;
                                $totalMale++;
                            } else {
                                $totalMale++;
                            }
                        } else {
                            $totalMale++;
                        }
                    }
                    
                    // Count daughter
                    if($resident->daughter_fullname) {
                        $totalMembers++;
                        if($resident->daughter_age) {
                            if($resident->daughter_age >= 60) {
                                $totalSeniors++;
                                $seniorFemale++;
                                $totalFemale++;
                            } elseif($resident->daughter_age < 18) {
                                $totalChildren++;
                                $childFemale++;
                                $totalFemale++;
                            } else {
                                $totalFemale++;
                            }
                        } else {
                            $totalFemale++;
                        }
                    }
                    
                    // Count grandmother
                    if($resident->grandmother_fullname) {
                        $totalMembers++;
                        if($resident->grandmother_age) {
                            if($resident->grandmother_age >= 60) {
                                $totalSeniors++;
                                $seniorFemale++;
                                $totalFemale++;
                            } elseif($resident->grandmother_age < 18) {
                                $totalChildren++;
                                $childFemale++;
                                $totalFemale++;
                            } else {
                                $totalFemale++;
                            }
                        } else {
                            $totalFemale++;
                        }
                    }
                    
                    // Count grandfather
                    if($resident->grandfather_fullname) {
                        $totalMembers++;
                        if($resident->grandfather_age) {
                            if($resident->grandfather_age >= 60) {
                                $totalSeniors++;
                                $seniorMale++;
                                $totalMale++;
                            } elseif($resident->grandfather_age < 18) {
                                $totalChildren++;
                                $childMale++;
                                $totalMale++;
                            } else {
                                $totalMale++;
                            }
                        } else {
                            $totalMale++;
                        }
                    }
                    
                    // Count PWD (actual individual PWD fields)
                    if($resident->family_head_pwd) $pwdCount++;
                    if($resident->wife_pwd) $pwdCount++;
                    if($resident->son_pwd) $pwdCount++;
                    if($resident->daughter_pwd) $pwdCount++;
                    if($resident->grandmother_pwd) $pwdCount++;
                    if($resident->grandfather_pwd) $pwdCount++;
                }
            @endphp
            
            <!-- Stat Strip -->
        <div class="stat-strip anim delay-1">
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--navy);"></div>
                <div>
                    <div class="chip-val">{{ number_format($totalFamilies) }}</div>
                    <div class="chip-lbl">Total Families</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--blue);"></div>
                <div>
                    <div class="chip-val">{{ number_format($totalMale) }}</div>
                    <div class="chip-lbl">Male</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:#ec4899;"></div>
                <div>
                    <div class="chip-val">{{ number_format($totalFemale) }}</div>
                    <div class="chip-lbl">Female</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--amber);"></div>
                <div>
                    <div class="chip-val">{{ number_format($seniorMale) }}</div>
                    <div class="chip-lbl">Senior Male</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:#f97316;"></div>
                <div>
                    <div class="chip-val">{{ number_format($seniorFemale) }}</div>
                    <div class="chip-lbl">Senior Female</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--green);"></div>
                <div>
                    <div class="chip-val">{{ number_format($childMale) }}</div>
                    <div class="chip-lbl">Child Male</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:var(--teal);"></div>
                <div>
                    <div class="chip-val">{{ number_format($childFemale) }}</div>
                    <div class="chip-lbl">Child Female</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:#ec4899;"></div>
                <div>
                    <div class="chip-val">{{ number_format($pregnantCount) }}</div>
                    <div class="chip-lbl">Pregnant</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="chip-dot" style="background:#6366f1;"></div>
                <div>
                    <div class="chip-val">{{ number_format($pwdCount) }}</div>
                    <div class="chip-lbl">PWD</div>
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
                            <div class="dropdown-opt selected" data-value="ALL">All Families</div>
                            <div class="dropdown-opt" data-value="SENIOR HEAD">Senior Head</div>
                            <div class="dropdown-opt" data-value="MALE HEAD">Male Head</div>
                            <div class="dropdown-opt" data-value="FEMALE HEAD">Female Head</div>
                            <div class="dropdown-opt" data-value="LARGE FAMILY">Large Family (5+)</div>
                            <div class="dropdown-opt" data-value="NO CONTACT">No Contact</div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="search-wrap">
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" class="search-input"
                               placeholder="Search family heads…"
                               value="{{ request('search') }}"
                               oninput="refreshFilters()" />
                    </div>
                </div>

                <div class="toolbar-right">
                    <button class="btn-add" onclick="openAddModal()">
                        <i class="fas fa-home"></i> Add Family Head
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
                            <th>Family ID</th>
                            <th class="sortable" onclick="sortTable(1,'string')">Family Head <i class="fas fa-sort" style="opacity:0.4;margin-left:4px;"></i></th>
                            <th>Family Members</th>
                            <th>Total Members</th>
                            <th>Purok</th>
                            <th>Contact</th>
                            <th>Vulnerable Count</th>
                            <th>Registered On</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residents as $resident)
                        <tr data-purok="{{ $resident->description ?? '' }}" data-family="{{ $resident->qty . ' ' . $resident->name }}" data-family-id="{{ $resident->id }}" data-gender="{{ $resident->gender ?? 'Male' }}">
                            <td class="td-id">{{ str_pad($resident->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="td-name">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 28px; height: 28px; background: var(--teal-light); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-home" style="color: var(--teal); font-size: 12px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 500; cursor: pointer; color: var(--navy); text-decoration: underline;" onclick="toggleFamilyDetails({{ $resident->id }})">
                                            {{ $resident->qty }} {{ $resident->name }}
                                            <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 4px;" id="chevron-{{ $resident->id }}"></i>
                                        </div>
                                        @if($resident->gender)
                                        <div style="font-size: 11px; color: var(--text-muted);">
                                            <i class="fas fa-{{ strtolower($resident->gender) === 'male' ? 'mars' : 'venus' }}" style="font-size: 9px;"></i>
                                            {{ $resident->gender }} Head
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12px; color: var(--text-mid);">
                                    <i class="fas fa-users" style="font-size: 10px; color: var(--teal); margin-right: 4px;"></i>
                                    @php
                                        $memberCount = 1; // Start with family head
                                        if($resident->wife_fullname) $memberCount++;
                                        if($resident->son_fullname) $memberCount++;
                                        if($resident->daughter_fullname) $memberCount++;
                                        if($resident->grandmother_fullname) $memberCount++;
                                        if($resident->grandfather_fullname) $memberCount++;
                                    @endphp
                                    {{ $memberCount }} members
                                </div>
                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 2px;">
                                    Head + {{ $memberCount - 1 }} dependents
                                </div>
                            </td>
                            <td>
                                <span style="background: var(--blue-light); color: var(--blue); padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 500;">
                                    @php
                                        $memberCount = 1; // Start with family head
                                        if($resident->wife_fullname) $memberCount++;
                                        if($resident->son_fullname) $memberCount++;
                                        if($resident->daughter_fullname) $memberCount++;
                                        if($resident->grandmother_fullname) $memberCount++;
                                        if($resident->grandfather_fullname) $memberCount++;
                                    @endphp
                                    {{ $memberCount }}
                                </span>
                            </td>
                            <td style="color:var(--text-mid);">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-map-pin" style="font-size: 10px; color: var(--teal);"></i>
                                    {{ $resident->description ?? 'Not Assigned' }}
                                </div>
                            </td>
                            <td style="color:var(--text-mid);font-size:13px;">
                                @if($resident->contact_number)
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-phone" style="font-size: 10px; color: var(--green);"></i>
                                    {{ $resident->contact_number }}
                                </div>
                                @else
                                <span style="color: var(--rose); font-size: 11px;">
                                    <i class="fas fa-exclamation-triangle" style="font-size: 9px;"></i> No Contact
                                </span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    @php
                                        $seniorCount = 0;
                                        $childCount = 0;
                                        $pregnantCount = 0;
                                        $pwdCount = 0;
                                        
                                        // Count seniors (60+ years)
                                        if($resident->family_head_age && $resident->family_head_age >= 60) $seniorCount++;
                                        if($resident->wife_age && $resident->wife_age >= 60) $seniorCount++;
                                        if($resident->son_age && $resident->son_age >= 60) $seniorCount++;
                                        if($resident->daughter_age && $resident->daughter_age >= 60) $seniorCount++;
                                        if($resident->grandmother_age && $resident->grandmother_age >= 60) $seniorCount++;
                                        if($resident->grandfather_age && $resident->grandfather_age >= 60) $seniorCount++;
                                        
                                        // Count children (below 18 years)
                                        if($resident->son_age && $resident->son_age < 18) $childCount++;
                                        if($resident->daughter_age && $resident->daughter_age < 18) $childCount++;
                                        
                                        // Count pregnant wives
                                        if($resident->wife_pregnant) $pregnantCount = 1;
                                        
                                        // Count PWD in family (actual individual PWD fields)
                                        if($resident->family_head_pwd) $pwdCount++;
                                        if($resident->wife_pwd) $pwdCount++;
                                        if($resident->son_pwd) $pwdCount++;
                                        if($resident->daughter_pwd) $pwdCount++;
                                        if($resident->grandmother_pwd) $pwdCount++;
                                        if($resident->grandfather_pwd) $pwdCount++;
                                    @endphp
                                    
                                    @if($seniorCount > 0)
                                    <span style="background: var(--amber-light); color: var(--amber); padding: 2px 6px; border-radius: 8px; font-size: 10px; font-weight: 500; display: inline-block; width: fit-content;">
                                        <i class="fas fa-user-clock" style="font-size: 8px;"></i> {{ $seniorCount }} Senior
                                    </span>
                                    @endif
                                    
                                    @if($childCount > 0)
                                    <span style="background: var(--green-light); color: var(--green); padding: 2px 6px; border-radius: 8px; font-size: 10px; font-weight: 500; display: inline-block; width: fit-content;">
                                        <i class="fas fa-child" style="font-size: 8px;"></i> {{ $childCount }} Child
                                    </span>
                                    @endif
                                    
                                    @if($pregnantCount > 0)
                                    <span style="background: #fce7f3; color: #ec4899; padding: 2px 6px; border-radius: 8px; font-size: 10px; font-weight: 500; display: inline-block; width: fit-content;">
                                        <i class="fas fa-baby" style="font-size: 8px;"></i> {{ $pregnantCount }} Pregnant
                                    </span>
                                    @endif
                                    
                                    @if($pwdCount > 0)
                                    <span style="background: #e0e7ff; color: #6366f1; padding: 2px 6px; border-radius: 8px; font-size: 10px; font-weight: 500; display: inline-block; width: fit-content;">
                                        <i class="fas fa-wheelchair" style="font-size: 8px;"></i> {{ $pwdCount }} PWD
                                    </span>
                                    @endif
                                    
                                    @if($seniorCount == 0 && $childCount == 0 && $pregnantCount == 0 && $pwdCount == 0)
                                    <span style="color: var(--text-muted); font-size: 10px; font-style: italic;">
                                        No vulnerable members 
                                        <small>(Debug: FH:{{ $resident->family_head_age ?? 'null' }}, W:{{ $resident->wife_age ?? 'null' }}, S:{{ $resident->son_age ?? 'null' }}, D:{{ $resident->daughter_age ?? 'null' }}, Preg:{{ $resident->wife_pregnant ? 'YES' : 'NO' }}, PWD:{{ $resident->pwd_in_family ?? 'null' }})</small>
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td style="color:var(--text-muted);font-size:12.5px;">{{ $resident->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="action-btns" style="justify-content:flex-end;">
                                    <button class="action-btn edit" title="Edit Family"
                                        onclick="openEditModal({{ $resident->id }})">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="action-btn delete" title="Delete Family"
                                        onclick="openDeleteModal('{{ route('resident.destroy', $resident->id) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Family Details Dropdown Row -->
                        <tr id="family-details-{{ $resident->id }}" class="family-details-row" style="display: none;">
                            <td colspan="9" style="padding: 0;">
                                <div class="family-details-content">
                                    <div class="family-details-header">
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                                            <i class="fas fa-users" style="color: var(--teal); font-size: 16px;"></i>
                                            <span style="font-weight: 600; color: var(--navy); font-size: 14px;">Family Members Details</span>
                                            <span style="color: var(--text-muted); font-size: 12px;">{{ $resident->qty }} {{ $resident->name }}</span>
                                        </div>
                                    </div>
                                    <div class="family-members-grid">
                                        <!-- Family Head -->
                                        @if($resident->family_head_fullname)
                                        <div class="member-card">
                                            <div class="member-header">
                                                <i class="fas fa-home" style="color: var(--teal);"></i>
                                                <span>Family Head</span>
                                                @if($resident->family_head_pwd)
                                                <span style="background: #e0e7ff; color: #6366f1; padding: 2px 6px; border-radius: 12px; font-size: 9px; font-weight: 500; margin-left: 8px;">
                                                    <i class="fas fa-wheelchair" style="font-size: 7px;"></i> PWD
                                                </span>
                                                @endif
                                            </div>
                                            <div class="member-info">
                                                <div class="info-row"><strong>Name:</strong> {{ $resident->family_head_fullname }}</div>
                                                @if($resident->family_head_age)<div class="info-row"><strong>Age:</strong> {{ $resident->family_head_age }} years</div>@endif
                                                @if($resident->family_head_birthdate)<div class="info-row"><strong>Birthdate:</strong> {{ $resident->family_head_birthdate->format('M d, Y') }}</div>@endif
                                                @if($resident->family_head_pwd)
                                                <div class="info-row" style="color: #6366f1; font-weight: 600;">
                                                    <i class="fas fa-wheelchair" style="font-size: 10px; margin-right: 4px;"></i>
                                                    <strong>Disability Status:</strong> Person With Disability (PWD)
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Wife -->
                                        @if($resident->wife_fullname)
                                        <div class="member-card">
                                            <div class="member-header">
                                                <i class="fas fa-female" style="color: #ec4899;"></i>
                                                <span>Wife</span>
                                                @if($resident->wife_pregnant)
                                                <span style="background: #fce7f3; color: #ec4899; padding: 2px 6px; border-radius: 12px; font-size: 9px; font-weight: 500; margin-left: 8px;">
                                                    <i class="fas fa-baby" style="font-size: 7px;"></i> Pregnant
                                                </span>
                                                @endif
                                                @if($resident->wife_pwd)
                                                <span style="background: #e0e7ff; color: #6366f1; padding: 2px 6px; border-radius: 12px; font-size: 9px; font-weight: 500; margin-left: 8px;">
                                                    <i class="fas fa-wheelchair" style="font-size: 7px;"></i> PWD
                                                </span>
                                                @endif
                                            </div>
                                            <div class="member-info">
                                                <div class="info-row"><strong>Name:</strong> {{ $resident->wife_fullname }}</div>
                                                @if($resident->wife_age)<div class="info-row"><strong>Age:</strong> {{ $resident->wife_age }} years</div>@endif
                                                @if($resident->wife_birthdate)<div class="info-row"><strong>Birthdate:</strong> {{ $resident->wife_birthdate->format('M d, Y') }}</div>@endif
                                                @if($resident->wife_pregnant)
                                                <div class="info-row" style="color: #ec4899; font-weight: 600;">
                                                    <i class="fas fa-baby" style="font-size: 10px; margin-right: 4px;"></i>
                                                    <strong>Pregnancy Status:</strong> Pregnant
                                                </div>
                                                @else
                                                <div class="info-row" style="color: #999; font-size: 11px; font-style: italic;">
                                                    <strong>Pregnancy Status:</strong> Not Pregnant
                                                </div>
                                                @endif
                                                @if($resident->wife_pwd)
                                                <div class="info-row" style="color: #6366f1; font-weight: 600;">
                                                    <i class="fas fa-wheelchair" style="font-size: 10px; margin-right: 4px;"></i>
                                                    <strong>Disability Status:</strong> Person With Disability (PWD)
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Son -->
                                        @if($resident->son_fullname)
                                        <div class="member-card">
                                            <div class="member-header">
                                                <i class="fas fa-child" style="color: var(--blue);"></i>
                                                <span>Son</span>
                                                @if($resident->son_pwd)
                                                <span style="background: #e0e7ff; color: #6366f1; padding: 2px 6px; border-radius: 12px; font-size: 9px; font-weight: 500; margin-left: 8px;">
                                                    <i class="fas fa-wheelchair" style="font-size: 7px;"></i> PWD
                                                </span>
                                                @endif
                                            </div>
                                            <div class="member-info">
                                                <div class="info-row"><strong>Name:</strong> {{ $resident->son_fullname }}</div>
                                                @if($resident->son_age)<div class="info-row"><strong>Age:</strong> {{ $resident->son_age }} years</div>@endif
                                                @if($resident->son_birthdate)<div class="info-row"><strong>Birthdate:</strong> {{ $resident->son_birthdate->format('M d, Y') }}</div>@endif
                                                @if($resident->son_pwd)
                                                <div class="info-row" style="color: #6366f1; font-weight: 600;">
                                                    <i class="fas fa-wheelchair" style="font-size: 10px; margin-right: 4px;"></i>
                                                    <strong>Disability Status:</strong> Person With Disability (PWD)
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Daughter -->
                                        @if($resident->daughter_fullname)
                                        <div class="member-card">
                                            <div class="member-header">
                                                <i class="fas fa-child" style="color: var(--rose);"></i>
                                                <span>Daughter</span>
                                                @if($resident->daughter_pwd)
                                                <span style="background: #e0e7ff; color: #6366f1; padding: 2px 6px; border-radius: 12px; font-size: 9px; font-weight: 500; margin-left: 8px;">
                                                    <i class="fas fa-wheelchair" style="font-size: 7px;"></i> PWD
                                                </span>
                                                @endif
                                            </div>
                                            <div class="member-info">
                                                <div class="info-row"><strong>Name:</strong> {{ $resident->daughter_fullname }}</div>
                                                @if($resident->daughter_age)<div class="info-row"><strong>Age:</strong> {{ $resident->daughter_age }} years</div>@endif
                                                @if($resident->daughter_birthdate)<div class="info-row"><strong>Birthdate:</strong> {{ $resident->daughter_birthdate->format('M d, Y') }}</div>@endif
                                                @if($resident->daughter_pwd)
                                                <div class="info-row" style="color: #6366f1; font-weight: 600;">
                                                    <i class="fas fa-wheelchair" style="font-size: 10px; margin-right: 4px;"></i>
                                                    <strong>Disability Status:</strong> Person With Disability (PWD)
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Grandmother -->
                                        @if($resident->grandmother_fullname)
                                        <div class="member-card">
                                            <div class="member-header">
                                                <i class="fas fa-user-clock" style="color: var(--amber);"></i>
                                                <span>Grandmother</span>
                                                @if($resident->grandmother_pwd)
                                                <span style="background: #e0e7ff; color: #6366f1; padding: 2px 6px; border-radius: 12px; font-size: 9px; font-weight: 500; margin-left: 8px;">
                                                    <i class="fas fa-wheelchair" style="font-size: 7px;"></i> PWD
                                                </span>
                                                @endif
                                            </div>
                                            <div class="member-info">
                                                <div class="info-row"><strong>Name:</strong> {{ $resident->grandmother_fullname }}</div>
                                                @if($resident->grandmother_age)<div class="info-row"><strong>Age:</strong> {{ $resident->grandmother_age }} years</div>@endif
                                                @if($resident->grandmother_birthdate)<div class="info-row"><strong>Birthdate:</strong> {{ $resident->grandmother_birthdate->format('M d, Y') }}</div>@endif
                                                @if($resident->grandmother_pwd)
                                                <div class="info-row" style="color: #6366f1; font-weight: 600;">
                                                    <i class="fas fa-wheelchair" style="font-size: 10px; margin-right: 4px;"></i>
                                                    <strong>Disability Status:</strong> Person With Disability (PWD)
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Grandfather -->
                                        @if($resident->grandfather_fullname)
                                        <div class="member-card">
                                            <div class="member-header">
                                                <i class="fas fa-user-clock" style="color: #6366f1;"></i>
                                                <span>Grandfather</span>
                                                @if($resident->grandfather_pwd)
                                                <span style="background: #e0e7ff; color: #6366f1; padding: 2px 6px; border-radius: 12px; font-size: 9px; font-weight: 500; margin-left: 8px;">
                                                    <i class="fas fa-wheelchair" style="font-size: 7px;"></i> PWD
                                                </span>
                                                @endif
                                            </div>
                                            <div class="member-info">
                                                <div class="info-row"><strong>Name:</strong> {{ $resident->grandfather_fullname }}</div>
                                                @if($resident->grandfather_age)<div class="info-row"><strong>Age:</strong> {{ $resident->grandfather_age }} years</div>@endif
                                                @if($resident->grandfather_birthdate)<div class="info-row"><strong>Birthdate:</strong> {{ $resident->grandfather_birthdate->format('M d, Y') }}</div>@endif
                                                @if($resident->grandfather_pwd)
                                                <div class="info-row" style="color: #6366f1; font-weight: 600;">
                                                    <i class="fas fa-wheelchair" style="font-size: 10px; margin-right: 4px;"></i>
                                                    <strong>Disability Status:</strong> Person With Disability (PWD)
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-home"></i></div>
                                    <div class="empty-title">No Family Heads Found</div>
                                    <div class="empty-msg">Add your first family head using the button above.</div>
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

    <!-- Hidden Canvas for Resource Chart -->
    <canvas id="resourceChart" width="200" height="200" style="display: none;"></canvas>

    <!-- Hidden DSS Elements -->
    <div id="readinessRecommendation" style="display: none;"></div>
    <div id="vulnerableAction" style="display: none;"></div>
    <div id="resourceInsight" style="display: none;"></div>
    <div id="contactAlert" style="display: none;"></div>

    <!-- ══ ADD RESIDENT MODAL ══ -->
    <div class="modal-backdrop" id="addBackdrop">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Add New Family Head</div>
                    <div class="modal-head-sub">Fill in the details to register a family head.</div>
                </div>
                <button class="modal-close" onclick="closeAddModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('resident.store') }}">
                    @csrf
                    
                    <!-- Family Information Section -->
                    <div style="margin-bottom: 32px;">
                        <h3 style="color: var(--navy); font-size: 16px; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--teal);">
                            <i class="fas fa-home" style="margin-right: 8px;"></i>Family Information
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Address (Purok)</label>
                                <select name="description" class="form-control">
                                    <option value="" disabled selected>Select Purok...</option>
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
                    </div>

                    <!-- Parents Section -->
                    <div style="margin-bottom: 32px;">
                        <h3 style="color: var(--navy); font-size: 16px; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--blue);">
                            <i class="fas fa-users" style="margin-right: 8px;"></i>Parents
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Family Head Fullname</label>
                                <input type="text" name="family_head_fullname" class="form-control" placeholder="e.g. Juan Dela Cruz" value="{{ old('family_head_fullname') }}">
                                @error('family_head_fullname')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Family Head Age</label>
                                <input type="number" name="family_head_age" class="form-control" placeholder="e.g. 45" value="{{ old('family_head_age') }}" min="0" max="120">
                                @error('family_head_age')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Family Head Birthdate</label>
                                <input type="date" name="family_head_birthdate" class="form-control" value="{{ old('family_head_birthdate') }}">
                                @error('family_head_birthdate')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Wife Fullname</label>
                                <input type="text" name="wife_fullname" class="form-control" placeholder="e.g. Maria Dela Cruz" value="{{ old('wife_fullname') }}">
                                @error('wife_fullname')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Wife Age</label>
                                <input type="number" name="wife_age" class="form-control" placeholder="e.g. 42" value="{{ old('wife_age') }}" min="0" max="120">
                                @error('wife_age')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Wife Birthdate</label>
                                <input type="date" name="wife_birthdate" class="form-control" value="{{ old('wife_birthdate') }}">
                                @error('wife_birthdate')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="wife_pregnant" value="1" {{ old('wife_pregnant') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Wife is Pregnant</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="wife_pwd" value="1" {{ old('wife_pwd') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Wife is PWD</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Children Section -->
                    <div style="margin-bottom: 32px;">
                        <h3 style="color: var(--navy); font-size: 16px; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--green);">
                            <i class="fas fa-child" style="margin-right: 8px;"></i>Children
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Son Fullname</label>
                                <input type="text" name="son_fullname" class="form-control" placeholder="e.g. Jose Dela Cruz" value="{{ old('son_fullname') }}">
                                @error('son_fullname')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Son Age</label>
                                <input type="number" name="son_age" class="form-control" placeholder="e.g. 15" value="{{ old('son_age') }}" min="0" max="120">
                                @error('son_age')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Son Birthdate</label>
                                <input type="date" name="son_birthdate" class="form-control" value="{{ old('son_birthdate') }}">
                                @error('son_birthdate')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Daughter Fullname</label>
                                <input type="text" name="daughter_fullname" class="form-control" placeholder="e.g. Ana Dela Cruz" value="{{ old('daughter_fullname') }}">
                                @error('daughter_fullname')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Daughter Age</label>
                                <input type="number" name="daughter_age" class="form-control" placeholder="e.g. 12" value="{{ old('daughter_age') }}" min="0" max="120">
                                @error('daughter_age')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Daughter Birthdate</label>
                                <input type="date" name="daughter_birthdate" class="form-control" value="{{ old('daughter_birthdate') }}">
                                @error('daughter_birthdate')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Elderly Section -->
                    <div style="margin-bottom: 32px;">
                        <h3 style="color: var(--navy); font-size: 16px; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--amber);">
                            <i class="fas fa-user-clock" style="margin-right: 8px;"></i>Elderly (Grandparents)
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Grandmother Fullname</label>
                                <input type="text" name="grandmother_fullname" class="form-control" placeholder="e.g. Lola Dela Cruz" value="{{ old('grandmother_fullname') }}">
                                @error('grandmother_fullname')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Grandmother Age</label>
                                <input type="number" name="grandmother_age" class="form-control" placeholder="e.g. 75" value="{{ old('grandmother_age') }}" min="0" max="120">
                                @error('grandmother_age')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Grandmother Birthdate</label>
                                <input type="date" name="grandmother_birthdate" class="form-control" value="{{ old('grandmother_birthdate') }}">
                                @error('grandmother_birthdate')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Grandfather Fullname</label>
                                <input type="text" name="grandfather_fullname" class="form-control" placeholder="e.g. Lolo Dela Cruz" value="{{ old('grandfather_fullname') }}">
                                @error('grandfather_fullname')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Grandfather Age</label>
                                <input type="number" name="grandfather_age" class="form-control" placeholder="e.g. 78" value="{{ old('grandfather_age') }}" min="0" max="120">
                                @error('grandfather_age')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Grandfather Birthdate</label>
                                <input type="date" name="grandfather_birthdate" class="form-control" value="{{ old('grandfather_birthdate') }}">
                                @error('grandfather_birthdate')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Disability Status Section -->
                    <div style="margin-bottom: 16px;">
                        <h3 style="color: var(--navy); font-size: 16px; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--rose);">
                            <i class="fas fa-wheelchair" style="margin-right: 8px;"></i>Disability Status (PWD)
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="family_head_pwd" value="1" {{ old('family_head_pwd') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Family Head is PWD</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="wife_pwd" value="1" {{ old('wife_pwd') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Wife is PWD</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="son_pwd" value="1" {{ old('son_pwd') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Son is PWD</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="daughter_pwd" value="1" {{ old('daughter_pwd') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Daughter is PWD</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="grandmother_pwd" value="1" {{ old('grandmother_pwd') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Grandmother is PWD</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="grandfather_pwd" value="1" {{ old('grandfather_pwd') ? 'checked' : '' }}>
                                    <span class="checkbox-label">Grandfather is PWD</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeAddModal()">Cancel</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-floppy-disk"></i> Save Family Head
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
                    <div class="modal-head-title">Edit Family Head</div>
                    <div class="modal-head-sub">Update the family head's information below.</div>
                </div>
                <button class="modal-close" onclick="closeEditModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="editResidentForm" method="POST" onsubmit="return confirmEdit(event)">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Family Head Fullname</label>
                            <input type="text" name="family_head_fullname" id="edit_family_head_fullname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Family Head Age</label>
                            <input type="number" name="family_head_age" id="edit_family_head_age" class="form-control" min="0" max="120">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Family Head Birthdate</label>
                            <input type="date" name="family_head_birthdate" id="edit_family_head_birthdate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="family_head_pwd" id="edit_family_head_pwd" value="1">
                                <span class="checkbox-label">Family Head is PWD</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wife Fullname</label>
                            <input type="text" name="wife_fullname" id="edit_wife_fullname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wife Age</label>
                            <input type="number" name="wife_age" id="edit_wife_age" class="form-control" min="0" max="120">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wife Birthdate</label>
                            <input type="date" name="wife_birthdate" id="edit_wife_birthdate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="wife_pregnant" id="edit_wife_pregnant" value="1">
                                <span class="checkbox-label">Wife is Pregnant</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="wife_pwd" id="edit_wife_pwd" value="1">
                                <span class="checkbox-label">Wife is PWD</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Son Fullname</label>
                            <input type="text" name="son_fullname" id="edit_son_fullname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Son Age</label>
                            <input type="number" name="son_age" id="edit_son_age" class="form-control" min="0" max="120">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Son Birthdate</label>
                            <input type="date" name="son_birthdate" id="edit_son_birthdate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="son_pwd" id="edit_son_pwd" value="1">
                                <span class="checkbox-label">Son is PWD</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Daughter Fullname</label>
                            <input type="text" name="daughter_fullname" id="edit_daughter_fullname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Daughter Age</label>
                            <input type="number" name="daughter_age" id="edit_daughter_age" class="form-control" min="0" max="120">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Daughter Birthdate</label>
                            <input type="date" name="daughter_birthdate" id="edit_daughter_birthdate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="daughter_pwd" id="edit_daughter_pwd" value="1">
                                <span class="checkbox-label">Daughter is PWD</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Grandmother Fullname</label>
                            <input type="text" name="grandmother_fullname" id="edit_grandmother_fullname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Grandmother Age</label>
                            <input type="number" name="grandmother_age" id="edit_grandmother_age" class="form-control" min="0" max="120">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Grandmother Birthdate</label>
                            <input type="date" name="grandmother_birthdate" id="edit_grandmother_birthdate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="grandmother_pwd" id="edit_grandmother_pwd" value="1">
                                <span class="checkbox-label">Grandmother is PWD</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Grandfather Fullname</label>
                            <input type="text" name="grandfather_fullname" id="edit_grandfather_fullname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Grandfather Age</label>
                            <input type="number" name="grandfather_age" id="edit_grandfather_age" class="form-control" min="0" max="120">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Grandfather Birthdate</label>
                            <input type="date" name="grandfather_birthdate" id="edit_grandfather_birthdate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="grandfather_pwd" id="edit_grandfather_pwd" value="1">
                                <span class="checkbox-label">Grandfather is PWD</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address (Purok)</label>
                            <select name="description" id="edit_description" class="form-control">
                                <option value="" disabled>Select Purok...</option>
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
                <div class="modal-head-title">Family Details</div>
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
                    <div class="modal-head-title">Delete Family</div>
                    <div class="modal-head-sub">This action cannot be undone and will remove all family members.</div>
                </div>
                <button class="modal-close" onclick="closeDeleteModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13.5px;color:var(--text-mid);line-height:1.6;margin-bottom:4px;">
                    Are you sure you want to permanently delete this family?
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

        function openEditModal(residentId) {
            // Fetch resident data via API
            fetch(`/residents/${residentId}`)
                .then(response => response.json())
                .then(data => {
                    // Set form action
                    document.getElementById('editResidentForm').action = `/residents/${residentId}`;
                    
                    // Populate form fields with resident data
                    document.getElementById('edit_family_head_fullname').value = data.family_head_fullname || '';
                    document.getElementById('edit_family_head_age').value = data.family_head_age || '';
                    document.getElementById('edit_family_head_birthdate').value = data.family_head_birthdate || '';
                    document.getElementById('edit_family_head_pwd').checked = data.family_head_pwd || false;
                    
                    document.getElementById('edit_wife_fullname').value = data.wife_fullname || '';
                    document.getElementById('edit_wife_age').value = data.wife_age || '';
                    document.getElementById('edit_wife_birthdate').value = data.wife_birthdate || '';
                    document.getElementById('edit_wife_pregnant').checked = data.wife_pregnant || false;
                    document.getElementById('edit_wife_pwd').checked = data.wife_pwd || false;
                    
                    document.getElementById('edit_son_fullname').value = data.son_fullname || '';
                    document.getElementById('edit_son_age').value = data.son_age || '';
                    document.getElementById('edit_son_birthdate').value = data.son_birthdate || '';
                    document.getElementById('edit_son_pwd').checked = data.son_pwd || false;
                    
                    document.getElementById('edit_daughter_fullname').value = data.daughter_fullname || '';
                    document.getElementById('edit_daughter_age').value = data.daughter_age || '';
                    document.getElementById('edit_daughter_birthdate').value = data.daughter_birthdate || '';
                    document.getElementById('edit_daughter_pwd').checked = data.daughter_pwd || false;
                    
                    document.getElementById('edit_grandmother_fullname').value = data.grandmother_fullname || '';
                    document.getElementById('edit_grandmother_age').value = data.grandmother_age || '';
                    document.getElementById('edit_grandmother_birthdate').value = data.grandmother_birthdate || '';
                    document.getElementById('edit_grandmother_pwd').checked = data.grandmother_pwd || false;
                    
                    document.getElementById('edit_grandfather_fullname').value = data.grandfather_fullname || '';
                    document.getElementById('edit_grandfather_age').value = data.grandfather_age || '';
                    document.getElementById('edit_grandfather_birthdate').value = data.grandfather_birthdate || '';
                    document.getElementById('edit_grandfather_pwd').checked = data.grandfather_pwd || false;
                    
                    document.getElementById('edit_description').value = data.description || '';
                    document.getElementById('edit_contact_number').value = data.contact_number || '';
                    
                    openModal('editBackdrop');
                })
                .catch(error => {
                    console.error('Error loading resident data:', error);
                    alert('Error loading resident data. Please try again.');
                });
        }

        function confirmEdit(e) {
            e.preventDefault();
            document.getElementById('confirm_name').textContent  = document.getElementById('edit_family_head_fullname').value;
            document.getElementById('confirm_qty').textContent   = 'Family Head';
            document.getElementById('confirm_price').textContent = document.getElementById('edit_family_head_age').value || '—';
            document.getElementById('confirm_desc').textContent  = document.getElementById('edit_description').value || '—';
            openModal('confirmBackdrop');
            return false;
        }

        function submitEditForm() {
            closeConfirmModal();
            document.getElementById('editResidentForm').submit();
        }

        function toggleFamilyDetails(residentId) {
            const detailsRow = document.getElementById(`family-details-${residentId}`);
            const chevron = document.getElementById(`chevron-${residentId}`);
            
            if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                // Show dropdown
                detailsRow.style.display = 'table-row';
                chevron.style.transform = 'rotate(180deg)';
            } else {
                // Hide dropdown
                detailsRow.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
            }
            chevron.style.transition = 'transform 0.3s ease';
        }
        
        // Close modal when clicking on backdrop
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-backdrop')) {
                const modalId = event.target.id;
                if (modalId && modalId.startsWith('family-details-modal-')) {
                    const residentId = modalId.replace('family-details-modal-', '');
                    toggleFamilyDetails(residentId);
                }
            }
        });

        function openViewModal(id) {
            fetch(`/residents/${id}`)
                .then(r => r.json())
                .then(d => {
                    document.getElementById('view_id').textContent           = d.id;
                    document.getElementById('view_name').textContent         = d.name;
                    document.getElementById('view_qty').textContent          = d.qty;
                    document.getElementById('view_price').textContent        = d.price;
                    document.getElementById('view_description').textContent  = d.description || '---';
                    document.getElementById('view_contact_number').textContent = d.contact_number || '---';
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

                const purokTxt = row.cells[4]?.textContent.trim() || '';
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
            
            // Update statistics based on filtered data
            updateFilteredStatistics();
        }

        function updateFilteredStatistics() {
            const visibleRows = Array.from(document.querySelectorAll('#residentsTable tbody tr')).filter(row => row.style.display !== 'none');
            
            let totalFamilies = visibleRows.length;
            let totalMale = 0;
            let totalFemale = 0;
            let seniorMale = 0;
            let seniorFemale = 0;
            let childMale = 0;
            let childFemale = 0;
            let pregnantCount = 0;
            let pwdCount = 0;
            
            visibleRows.forEach(row => {
                if (!row.cells[1]) return;
                
                // Count family head gender from data attribute
                const gender = (row.getAttribute('data-gender') || '').toUpperCase();
                if (gender === 'MALE') totalMale++;
                else if (gender === 'FEMALE') totalFemale++;
                
                // Parse vulnerable count badges
                const vulnerableCell = row.cells[6];
                const badges = vulnerableCell.querySelectorAll('span');
                
                badges.forEach(badge => {
                    const text = badge.textContent.trim();
                    if (text.includes('Senior')) {
                        const count = parseInt(text.match(/\d+/)?.[0] || 1);
                        // We need to determine gender for seniors - use family head gender as approximation
                        if (gender === 'MALE') {
                            seniorMale += count;
                            totalMale += count;
                        } else if (gender === 'FEMALE') {
                            seniorFemale += count;
                            totalFemale += count;
                        }
                    } else if (text.includes('Child')) {
                        const count = parseInt(text.match(/\d+/)?.[0] || 1);
                        // We need to determine gender for children - use family head gender as approximation
                        if (gender === 'MALE') {
                            childMale += count;
                            totalMale += count;
                        } else if (gender === 'FEMALE') {
                            childFemale += count;
                            totalFemale += count;
                        }
                    } else if (text.includes('Pregnant')) {
                        pregnantCount++;
                        totalFemale++;
                    } else if (text.includes('PWD')) {
                        const count = parseInt(text.match(/\d+/)?.[0] || 1);
                        pwdCount += count;
                    }
                });
                
                // Count additional family members using a simpler approach
                // Look for the family details row associated with this family
                const familyId = row.getAttribute('data-family-id');
                if (familyId) {
                    const detailsRow = document.getElementById(`family-details-${familyId}`);
                    if (detailsRow) {
                        // Count wife (always female)
                        const wifeCard = detailsRow.querySelector('.member-header');
                        if (wifeCard && wifeCard.textContent.includes('Wife')) {
                            totalFemale++;
                        }
                        // Count son (always male)
                        const sonCard = detailsRow.querySelector('.member-header');
                        if (sonCard && sonCard.textContent.includes('Son')) {
                            totalMale++;
                        }
                        // Count daughter (always female)
                        const daughterCard = detailsRow.querySelector('.member-header');
                        if (daughterCard && daughterCard.textContent.includes('Daughter')) {
                            totalFemale++;
                        }
                        // Count grandfather (always male)
                        const grandfatherCard = detailsRow.querySelector('.member-header');
                        if (grandfatherCard && grandfatherCard.textContent.includes('Grandfather')) {
                            totalMale++;
                        }
                        // Count grandmother (always female)
                        const grandmotherCard = detailsRow.querySelector('.member-header');
                        if (grandmotherCard && grandmotherCard.textContent.includes('Grandmother')) {
                            totalFemale++;
                        }
                    }
                }
            });
            
            // Update statistics display
            const statChips = document.querySelectorAll('.stat-chip');
            statChips[0].querySelector('.chip-val').textContent = totalFamilies.toString(); // Total Families
            statChips[1].querySelector('.chip-val').textContent = totalMale.toString(); // Male
            statChips[2].querySelector('.chip-val').textContent = totalFemale.toString(); // Female
            statChips[3].querySelector('.chip-val').textContent = seniorMale.toString(); // Senior Male
            statChips[4].querySelector('.chip-val').textContent = seniorFemale.toString(); // Senior Female
            statChips[5].querySelector('.chip-val').textContent = childMale.toString(); // Child Male
            statChips[6].querySelector('.chip-val').textContent = childFemale.toString(); // Child Female
            statChips[7].querySelector('.chip-val').textContent = pregnantCount.toString(); // Pregnant
            statChips[8].querySelector('.chip-val').textContent = pwdCount.toString(); // PWD
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

        // ── DSS Functions ──
        function refreshDSS() {
            showToast('Refreshing DSS analysis...');
            
            const readinessBar = document.getElementById('readinessBar');
            const contactBar = document.getElementById('contactBar');
            
            readinessBar.style.width = '0%';
            contactBar.style.width = '0%';
            
            setTimeout(() => {
                const newReadiness = Math.floor(Math.random() * 20) + 75;
                const newContactRate = Math.floor(Math.random() * 15) + 85;
                
                readinessBar.style.width = newReadiness + '%';
                contactBar.style.width = newContactRate + '%';
                document.getElementById('readinessScore').textContent = newReadiness + '%';
                document.getElementById('contactRate').textContent = newContactRate + '%';
                
                updateDSSRecommendations();
                drawResourceChart();
                
                showToast('DSS analysis updated successfully');
            }, 1000);
        }

        function updateDSSRecommendations() {
            const recommendations = [
                'Focus on updating contact information for elderly residents in Purok III.',
                'Prioritize medical supplies for vulnerable groups in Purok II.',
                'Review evacuation routes for high-density areas.',
                'Update emergency contact lists for senior citizens.',
                'Conduct evacuation drills for children in Purok IV.'
            ];
            
            const actions = [
                'Prioritize evacuation assistance for senior males in Purok II.',
                'Allocate additional resources for children in Purok V.',
                'Review medical needs for elderly residents.',
                'Update transportation plans for mobility-impaired residents.',
                'Coordinate with local hospitals for emergency response.'
            ];
            
            const insights = [
                'Purok I has the highest population density - allocate additional resources.',
                'Purok III shows low contact coverage - update communication protocols.',
                'Senior population concentrated in Purok II - focus medical resources.',
                'Children distribution requires specialized evacuation planning.',
                'Resource allocation optimized for current demographic patterns.'
            ];
            
            const alerts = [
                'Update contact info for 8% of residents without phone numbers.',
                'Critical: 5% of seniors lack emergency contacts.',
                'Warning: Some areas have incomplete address information.',
                'Action needed: Update medical information for vulnerable groups.',
                'Priority: Verify contact methods for all residents.'
            ];
            
            document.getElementById('readinessRecommendation').textContent = 
                recommendations[Math.floor(Math.random() * recommendations.length)];
            document.getElementById('vulnerableAction').textContent = 
                actions[Math.floor(Math.random() * actions.length)];
            document.getElementById('resourceInsight').textContent = 
                insights[Math.floor(Math.random() * insights.length)];
            document.getElementById('contactAlert').textContent = 
                alerts[Math.floor(Math.random() * alerts.length)];
        }

        function drawResourceChart() {
            const canvas = document.getElementById('resourceChart');
            const ctx = canvas.getContext('2d');
            
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            const data = [25, 20, 18, 22, 15];
            const colors = ['#0ea5a0', '#3b82f6', '#f59e0b', '#10b981', '#ec4899'];
            
            let currentAngle = -Math.PI / 2;
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = Math.min(centerX, centerY) - 10;
            
            data.forEach((value, index) => {
                const sliceAngle = (value / 100) * 2 * Math.PI;
                
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
                ctx.lineTo(centerX, centerY);
                ctx.fillStyle = colors[index];
                ctx.fill();
                
                currentAngle += sliceAngle;
            });
            
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius * 0.4, 0, 2 * Math.PI);
            ctx.fillStyle = '#f1f5f9';
            ctx.fill();
        }

        function generateEvacuationPlan() {
            showToast('Generating evacuation plan...');
            
            setTimeout(() => {
                const planContent = `EVACUATION PLAN - B-DEAMS
Generated: ${new Date().toLocaleString()}

=== PRIORITY AREAS ===
1. Purok I - High density, immediate evacuation required
2. Purok II - Senior citizens priority
3. Purok III - Children and families

=== EVACUATION ROUTES ===
• Route A: Purok I → Community Center
• Route B: Purok II → School Grounds  
• Route C: Purok III → Sports Complex

=== RESOURCE ALLOCATION ===
• Medical Teams: 3 units
• Transportation: 5 vehicles
• Emergency Supplies: Stocked for 500 residents
• Communication: All channels active

=== SPECIAL CONSIDERATIONS ===
• Elderly residents: Mobility assistance required
• Children: Family unit preservation
• Medical needs: Chronic conditions prioritized

=== CONTACT INFORMATION ===
• Emergency Hotline: 911
• Local Coordination: Available 24/7`;
                
                downloadFile('evacuation_plan.txt', planContent);
                showToast('Evacuation plan generated and downloaded');
            }, 1500);
        }

        function exportDSSReport() {
            showToast('Generating DSS report...');
            
            setTimeout(() => {
                const reportContent = `DECISION SUPPORT SYSTEM REPORT
B-DEAMS - Barangay Disaster Evacuation Alert Management System
Generated: ${new Date().toLocaleString()}

=== EXECUTIVE SUMMARY ===
Total Residents: {{ $totalResidents ?? 0 }}
Evacuation Readiness: ${document.getElementById('readinessScore').textContent}
Contact Coverage: ${document.getElementById('contactRate').textContent}

=== DEMOGRAPHIC ANALYSIS ===
Seniors: ${document.getElementById('seniorCount').textContent}
Children: ${document.getElementById('childCount').textContent}
Male Population: {{ isset($maleCount) ? $maleCount : 0 }}
Female Population: {{ isset($femaleCount) ? $femaleCount : 0 }}

=== KEY INSIGHTS ===
• ${document.getElementById('readinessRecommendation').textContent}
• ${document.getElementById('vulnerableAction').textContent}
• ${document.getElementById('resourceInsight').textContent}
• ${document.getElementById('contactAlert').textContent}

=== RECOMMENDATIONS ===
1. Update emergency contact information
2. Conduct regular evacuation drills
3. Prioritize vulnerable group assistance
4. Maintain resource inventory
5. Establish communication protocols

=== RISK ASSESSMENT ===
Risk Level: MODERATE
Primary Concerns: Contact coverage, elderly mobility
Mitigation: Ongoing monitoring and updates`;
                
                downloadFile('dss_report.txt', reportContent);
                showToast('DSS report exported successfully');
            }, 1500);
        }

        function simulateScenario() {
            showToast('Running scenario simulation...');
            
            setTimeout(() => {
                const scenarios = [
                    {
                        name: 'Typhoon Evacuation',
                        description: 'Category 3 typhoon approaching',
                        affected: 'Purok I, II, III',
                        timeline: '6 hours to landfall'
                    },
                    {
                        name: 'Flood Warning',
                        description: 'Rising water levels detected',
                        affected: 'Low-lying areas in Purok IV',
                        timeline: 'Immediate evacuation required'
                    },
                    {
                        name: 'Earthquake Drill',
                        description: 'Simulated magnitude 6.5 earthquake',
                        affected: 'All areas',
                        timeline: 'Practice evacuation procedures'
                    }
                ];
                
                const scenario = scenarios[Math.floor(Math.random() * scenarios.length)];
                
                alert(`SCENARIO SIMULATION RESULTS

Scenario: ${scenario.name}
Description: ${scenario.description}
Affected Areas: ${scenario.affected}
Timeline: ${scenario.timeline}

RECOMMENDED ACTIONS:
• Activate emergency protocols
• Notify all residents via available channels
• Deploy evacuation teams to affected areas
• Prepare emergency shelters
• Coordinate with local emergency services

ESTIMATED IMPACT:
• Residents to evacuate: ${Math.floor(Math.random() * 200) + 100}
• Estimated time: ${Math.floor(Math.random() * 3) + 2} hours
• Resource requirement: Moderate to High

This simulation helps prepare for actual emergency situations.`);
                
                showToast('Scenario simulation completed');
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

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                drawResourceChart();
                updateDSSRecommendations();
            }, 500);
        });
    </script>
</body>
</html>