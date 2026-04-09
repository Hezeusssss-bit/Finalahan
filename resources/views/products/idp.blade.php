<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>IDP's Management - B-DEAMS</title>
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

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* Sidebar */
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

        /* Main */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 36px 40px;
            min-height: 100vh;
        }

        /* Page Header */
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

        /* Panel */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
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

/* Stats */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

.stat-card {
    background: var(--white);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid var(--border);
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}
            padding: 24px;
            border: 1px solid var(--border);
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: var(--slate-light);
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-mid);
            border-bottom: 1px solid var(--border);
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            color: var(--text-dark);
        }

        .data-table tr:hover {
            background: var(--slate-light);
        }

        .data-table th:nth-child(1) { width: 5%; }  /* ID */
        .data-table th:nth-child(2) { width: 25%; } /* Name */
        .data-table th:nth-child(3) { width: 10%; } /* Age */
        .data-table th:nth-child(4) { width: 12%; } /* Gender */
        .data-table th:nth-child(5) { width: 18%; } /* Contact Number */
        .data-table th:nth-child(6) { width: 20%; } /* Facility */
        .data-table th:nth-child(7) { width: 10%; } /* Actions */

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--navy);
            color: white;
        }

        .btn-primary:hover { background: var(--navy-mid); }

        .btn-teal {
            background: var(--teal);
            color: white;
        }

        .btn-teal:hover { background: #0d9488; }

        .btn-sm {
            padding: 6px 10px;
            font-size: 12px;
        }

        .btn-info {
            background: var(--blue);
            color: white;
        }

        .btn-info:hover { background: #2563eb; }

        .btn-warning {
            background: var(--amber);
            color: white;
        }

        .btn-warning:hover { background: #d97706; }

        .btn-danger {
            background: var(--rose);
            color: white;
        }

        .btn-danger:hover { background: #dc2626; }

        /* Badges */
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-male {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-female {
            background: #fce7f3;
            color: #be185d;
        }

        .badge-other {
            background: #f3f4f6;
            color: #6b7280;
        }

        .badge-active {
            background: var(--green-light);
            color: #059669;
        }

        .badge-relocated {
            background: var(--blue-light);
            color: #1d4ed8;
        }

        .badge-returned {
            background: var(--amber-light);
            color: #d97706;
        }

        .badge-rehabilitated {
            background: var(--teal-light);
            color: #0d9488;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .action-buttons form {
            margin: 0;
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-backdrop.open {
            opacity: 1;
            visibility: visible;
        }

        .modal-box {
            background: white;
            border-radius: 18px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

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

        .form-control:disabled {
            background: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
            border-color: #e9ecef;
        }

        #specialNeedsDetailsGroup {
            transition: opacity 0.3s ease;
        }

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
            align-items: center;
            gap: 12px;
            padding: 20px 26px 26px;
            border-top: 1px solid var(--border);
            margin-top: 0;
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            white-space: nowrap;
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
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            min-height: 40px;
            white-space: nowrap;
        }

        .btn-submit:hover { background: var(--navy-mid); }
        
        .btn-submit:disabled {
            background: var(--slate-light);
            color: var(--text-muted);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-submit:disabled:hover {
            background: var(--slate-light);
            color: var(--text-muted);
        }

        /* IDP Details Modal Styles */
        .idp-details {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .details-row {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .details-group {
            flex: 1;
            min-width: 250px;
        }

        .details-group h4 {
            margin: 0 0 16px 0;
            color: var(--text-dark);
            font-size: 16px;
            font-weight: 600;
            border-bottom: 2px solid var(--teal);
            padding-bottom: 8px;
        }

        .detail-item {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .detail-item strong {
            color: var(--text-dark);
            font-weight: 600;
            min-width: 140px;
            flex-shrink: 0;
        }

        .detail-item span {
            color: var(--text-mid);
        }

        /* Toast Notifications */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--green);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast i {
            font-size: 16px;
        }

        /* Flash Alert */
        .flash-alert {
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
        }

        .flash-alert.success {
            background: var(--green-light);
            color: #059669;
            border: 1px solid #10b981;
        }

        /* Responsive */
        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .main { margin-left: 0; padding: 24px 20px; }
            .stats-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .modal-box { width: 95%; margin: 20px; }
            .toast {
                right: 10px;
                left: 10px;
                transform: translateY(-100%);
            }
            .toast.show {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
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
            <a href="{{ route('resident.index') }}" class="nav-link">
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
            <a href="{{ route('idps') }}" class="nav-link active">
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

    <!-- Main Content -->
    <main class="main">

        <!-- Page Header -->
        <div class="page-header">
            <p class="page-eyebrow">Services</p>
            <h1 class="page-title">IDP's Management</h1>
        </div>

        <!-- Flash -->
        @if(session('success'))
        <div class="flash-alert success">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ number_format($totalIdps) }}</div>
                <div class="stat-label">Total IDP's</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($thisMonthIdps) }}</div>
                <div class="stat-label">This Month</div>
            </div>
        </div>

        <!-- IDP's Table -->
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-users"></i> Internally Displaced Persons
                </div>
                <button class="btn btn-teal" onclick="openIdpModal()">
                    <i class="fas fa-plus"></i> Add New IDP
                </button>
            </div>
            <div class="panel-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Contact Number</th>
                            <th>Facility</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($idps as $idp)
                        <tr class="idp-row" onclick="viewIdpDetails({{ $idp->id }})" style="cursor: pointer;">
                            <td>{{ $idp->id }}</td>
                            <td>{{ $idp->full_name }}</td>
                            <td>{{ $idp->age }}</td>
                            <td>
                                <span class="badge badge-{{ $idp->gender }}">
                                    {{ ucfirst($idp->gender) }}
                                </span>
                            </td>
                            <td>{{ $idp->contact_number ?? 'N/A' }}</td>
                            <td>{{ $idp->facility ?? 'N/A' }}</td>
                            <td>
                                <div class="action-buttons" onclick="event.stopPropagation();">
                                    <button class="btn btn-sm btn-warning" title="Edit" onclick="openEditIdpModal({{ $idp->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Release" onclick="openReleaseConfirmModal({{ $idp->id }})">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-inbox" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                                No IDP records found. Click "Add New IDP" to register the first IDP.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

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

    <!-- IDP Modal -->
    <div class="modal-backdrop" id="idpModal">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Add New IDP</div>
                    <div class="modal-head-sub">Register an Internally Displaced Person</div>
                </div>
                <button class="modal-close" onclick="closeIdpModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <form id="idpForm" action="{{ route('idps.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Last Name *</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Suffix</label>
                            <input type="text" name="suffix" class="form-control" placeholder="Jr., Sr., III">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Age *</label>
                            <input type="number" name="age" class="form-control" min="0" max="120" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender *</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Birth Date</label>
                            <input type="date" name="birth_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" placeholder="09XXXXXXXXX">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Original Address *</label>
                        <textarea name="original_address" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Displacement Date *</label>
                            <input type="date" name="displacement_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Facility</label>
                            <input type="text" name="facility" class="form-control" placeholder="Enter facility name (Optional)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Occupation</label>
                            <input type="text" name="occupation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Education Level</label>
                            <select name="education_level" class="form-control">
                                <option value="">Select Education</option>
                                <option value="none">No Formal Education</option>
                                <option value="elementary">Elementary</option>
                                <option value="high-school">High School</option>
                                <option value="college">College</option>
                                <option value="vocational">Vocational</option>
                                <option value="graduate">Graduate Studies</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Has Special Needs?</label>
                            <div class="radio-group">
                                <label class="radio-opt">
                                    <input type="radio" name="has_special_needs" value="1" onchange="toggleSpecialNeedsDetails()">
                                    <span>Yes</span>
                                </label>
                                <label class="radio-opt">
                                    <input type="radio" name="has_special_needs" value="0" checked onchange="toggleSpecialNeedsDetails()">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="specialNeedsDetailsGroup">
                        <label class="form-label">Special Needs Details</label>
                        <textarea name="special_needs_details" id="specialNeedsDetails" class="form-control" rows="2" placeholder="Describe special needs if any" disabled></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-submit">Save IDP</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit IDP Modal -->
    <div class="modal-backdrop" id="editIdpModal">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Edit IDP</div>
                    <div class="modal-head-sub">Update IDP information</div>
                </div>
                <button class="modal-close" onclick="closeEditIdpModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <form id="editIdpForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="editIdpId">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="first_name" id="editFirstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" id="editMiddleName" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Last Name *</label>
                            <input type="text" name="last_name" id="editLastName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Suffix</label>
                            <input type="text" name="suffix" id="editSuffix" class="form-control" placeholder="Jr., Sr., III">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Age *</label>
                            <input type="number" name="age" id="editAge" class="form-control" min="0" max="120" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender *</label>
                            <select name="gender" id="editGender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Birth Date</label>
                            <input type="date" name="birth_date" id="editBirthDate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="editContactNumber" class="form-control" placeholder="09XXXXXXXXX">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Original Address *</label>
                        <textarea name="original_address" id="editOriginalAddress" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Displacement Date *</label>
                            <input type="date" name="displacement_date" id="editDisplacementDate" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Facility</label>
                            <input type="text" name="facility" id="editFacility" class="form-control" placeholder="Enter facility name (Optional)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Occupation</label>
                            <input type="text" name="occupation" id="editOccupation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Education Level</label>
                            <select name="education_level" id="editEducationLevel" class="form-control">
                                <option value="">Select Education</option>
                                <option value="none">No Formal Education</option>
                                <option value="elementary">Elementary</option>
                                <option value="high-school">High School</option>
                                <option value="college">College</option>
                                <option value="vocational">Vocational</option>
                                <option value="graduate">Graduate Studies</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Has Special Needs?</label>
                            <div class="radio-group">
                                <label class="radio-opt">
                                    <input type="radio" name="has_special_needs" value="1" id="editHasSpecialNeedsYes" onchange="toggleEditSpecialNeedsDetails()">
                                    <span>Yes</span>
                                </label>
                                <label class="radio-opt">
                                    <input type="radio" name="has_special_needs" value="0" id="editHasSpecialNeedsNo" checked onchange="toggleEditSpecialNeedsDetails()">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="editSpecialNeedsDetailsGroup">
                        <label class="form-label">Special Needs Details</label>
                        <textarea name="special_needs_details" id="editSpecialNeedsDetails" class="form-control" rows="2" placeholder="Describe special needs if any" disabled></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-submit" id="updateIdpBtn">Update IDP</button>
                </div>
            </form>
        </div>
    </div>

    <!-- IDP Details Modal -->
    <div class="modal-backdrop" id="idpDetailsModal">
        <div class="modal-box" style="max-width: 600px;">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">IDP Details</div>
                    <div class="modal-head-sub">View IDP information</div>
                </div>
                <button class="modal-close" onclick="closeIdpDetailsModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div id="idpDetailsContent">
                    <!-- Details will be populated here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background: var(--slate-light); color: var(--text-dark);" onclick="closeIdpDetailsModal()">Close</button>
            </div>
        </div>
    </div>

    
    <!-- Release Confirmation Modal -->
    <div class="modal-backdrop" id="releaseConfirmModal">
        <div class="modal-box" style="max-width: 400px;">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Release IDP</div>
                    <div class="modal-head-sub">Confirm release action</div>
                </div>
                <button class="modal-close" onclick="closeReleaseConfirmModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body" style="text-align: center; padding: 30px 20px;">
                <i class="fas fa-sign-out-alt" style="font-size: 48px; color: var(--red); margin-bottom: 20px; display: block;"></i>
                <h3 style="margin: 0 0 15px 0; color: var(--text-dark);">Release IDP Record</h3>
                <p style="margin: 0 0 10px 0; color: var(--text-muted);">Are you sure you want to release this IDP record?</p>
                <p style="margin: 0; color: var(--text-muted); font-size: 14px;">This action cannot be undone.</p>
            </div>
            <div class="modal-footer" style="display: flex; gap: 10px; justify-content: center; padding: 20px;">
                <button type="button" class="btn" style="background: var(--slate-light); color: var(--text-dark);" onclick="closeReleaseConfirmModal()">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmReleaseBtn">Release IDP</button>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openIdpModal() {
            document.getElementById('idpModal').classList.add('open');
            // Initialize special needs details state
            toggleSpecialNeedsDetails();
        }

        function closeIdpModal() {
            document.getElementById('idpModal').classList.remove('open');
            document.getElementById('idpForm').reset();
        }

        // Edit modal functions
        function openEditIdpModal(id) {
            // Fetch IDP data via AJAX
            fetch(`/idps/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('IDP data received:', data); // Debug log
                    
                    if (!data.success) {
                        throw new Error(data.message || 'Error loading IDP data');
                    }
                    
                    // Populate form fields
                    const idpData = data.data;
                    document.getElementById('editIdpId').value = idpData.id;
                    document.getElementById('editFirstName').value = idpData.first_name;
                    document.getElementById('editMiddleName').value = idpData.middle_name || '';
                    document.getElementById('editLastName').value = idpData.last_name;
                    document.getElementById('editSuffix').value = idpData.suffix || '';
                    document.getElementById('editAge').value = idpData.age;
                    document.getElementById('editGender').value = idpData.gender;
                    document.getElementById('editBirthDate').value = idpData.birth_date || '';
                    document.getElementById('editContactNumber').value = idpData.contact_number || '';
                    document.getElementById('editOriginalAddress').value = idpData.original_address;
                    document.getElementById('editDisplacementDate').value = idpData.displacement_date;
                    document.getElementById('editFacility').value = idpData.facility || '';
                    document.getElementById('editOccupation').value = idpData.occupation || '';
                    document.getElementById('editEducationLevel').value = idpData.education_level || '';
                    document.getElementById('editSpecialNeedsDetails').value = idpData.special_needs_details || '';
                    
                    // Set special needs radio buttons
                    if (idpData.has_special_needs) {
                        document.getElementById('editHasSpecialNeedsYes').checked = true;
                    } else {
                        document.getElementById('editHasSpecialNeedsNo').checked = true;
                    }
                    
                    // Set form action
                    document.getElementById('editIdpForm').action = `/idps/${id}`;
                    document.getElementById('editIdpForm').setAttribute('data-id', id);
                    
                    // Initialize special needs details state
                    toggleEditSpecialNeedsDetails();
                    
                    // Initialize form change tracking
                    initializeEditFormTracking();
                    
                    // Open modal
                    document.getElementById('editIdpModal').classList.add('open');
                })
                .catch(error => {
                    console.error('Error fetching IDP data:', error);
                    alert('Error loading IDP data: ' + error.message + '. Please try again.');
                });
        }

        function closeEditIdpModal() {
            document.getElementById('editIdpModal').classList.remove('open');
            document.getElementById('editIdpForm').reset();
            resetEditFormState();
        }

        // Track form changes
        let originalFormData = {};
        let formHasChanges = false;

        function resetEditFormState() {
            originalFormData = {};
            formHasChanges = false;
            updateUpdateButtonState();
        }

        function updateUpdateButtonState() {
            const updateBtn = document.getElementById('updateIdpBtn');
            if (formHasChanges) {
                updateBtn.disabled = false;
                updateBtn.textContent = 'Update IDP';
            } else {
                updateBtn.disabled = true;
                updateBtn.textContent = 'No Changes';
            }
        }

        function trackFormChanges() {
            const currentFormData = new FormData(document.getElementById('editIdpForm'));
            formHasChanges = false;
            
            for (let [key, value] of currentFormData.entries()) {
                if (originalFormData[key] !== value) {
                    formHasChanges = true;
                    break;
                }
            }
            
            updateUpdateButtonState();
        }

        // Add event listeners to all form inputs
        function initializeEditFormTracking() {
            const form = document.getElementById('editIdpForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                input.addEventListener('input', trackFormChanges);
                input.addEventListener('change', trackFormChanges);
            });
            
            // Store initial form data
            setTimeout(() => {
                const formData = new FormData(form);
                for (let [key, value] of formData.entries()) {
                    originalFormData[key] = value;
                }
                updateUpdateButtonState();
            }, 100);
        }

        // IDP Details modal functions
        function viewIdpDetails(id) {
            // Fetch IDP data via AJAX
            fetch(`/idps/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Error loading IDP data');
                    }
                    
                    const idpData = data.data;
                    
                    // Create details HTML
                    const detailsHtml = `
                        <div class="idp-details">
                            <div class="details-row">
                                <div class="details-group">
                                    <h4>Personal Information</h4>
                                    <div class="detail-item">
                                        <strong>ID:</strong> ${idpData.id}
                                    </div>
                                    <div class="detail-item">
                                        <strong>Name:</strong> ${idpData.first_name} ${idpData.middle_name || ''} ${idpData.last_name} ${idpData.suffix || ''}
                                    </div>
                                    <div class="detail-item">
                                        <strong>Age:</strong> ${idpData.age}
                                    </div>
                                    <div class="detail-item">
                                        <strong>Gender:</strong> ${idpData.gender}
                                    </div>
                                    ${idpData.birth_date ? `<div class="detail-item"><strong>Birth Date:</strong> ${idpData.birth_date}</div>` : ''}
                                    ${idpData.contact_number ? `<div class="detail-item"><strong>Contact Number:</strong> ${idpData.contact_number}</div>` : ''}
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="details-group">
                                    <h4>Location Information</h4>
                                    <div class="detail-item">
                                        <strong>Original Address:</strong> ${idpData.original_address}
                                    </div>
                                    <div class="detail-item">
                                        <strong>Displacement Date:</strong> ${idpData.displacement_date}
                                    </div>
                                    ${idpData.facility ? `<div class="detail-item"><strong>Facility:</strong> ${idpData.facility}</div>` : ''}
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="details-group">
                                    <h4>Additional Information</h4>
                                    ${idpData.occupation ? `<div class="detail-item"><strong>Occupation:</strong> ${idpData.occupation}</div>` : ''}
                                    ${idpData.education_level ? `<div class="detail-item"><strong>Education Level:</strong> ${idpData.education_level}</div>` : ''}
                                    <div class="detail-item">
                                        <strong>Has Special Needs:</strong> ${idpData.has_special_needs ? 'Yes' : 'No'}
                                    </div>
                                    ${idpData.special_needs_details ? `<div class="detail-item"><strong>Special Needs Details:</strong> ${idpData.special_needs_details}</div>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Populate modal content
                    document.getElementById('idpDetailsContent').innerHTML = detailsHtml;
                    
                    // Open modal
                    document.getElementById('idpDetailsModal').classList.add('open');
                })
                .catch(error => {
                    console.error('Error fetching IDP data:', error);
                    alert('Error loading IDP data: ' + error.message + '. Please try again.');
                });
        }

        function closeIdpDetailsModal() {
            document.getElementById('idpDetailsModal').classList.remove('open');
        }

        // Release confirmation modal functions
        function openReleaseConfirmModal(id) {
            document.getElementById('confirmReleaseBtn').setAttribute('data-id', id);
            document.getElementById('releaseConfirmModal').classList.add('open');
        }

        function closeReleaseConfirmModal() {
            document.getElementById('releaseConfirmModal').classList.remove('open');
        }

        // Logout modal functions
        function openLogoutModal() {
            document.getElementById('logoutBackdrop').classList.add('open');
        }

        function closeLogoutModal() {
            document.getElementById('logoutBackdrop').classList.remove('open');
        }

        // Delete IDP function (now called from confirmation modal)
        function deleteIdp(id) {
            fetch(`/idps/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Close confirmation modal
                    closeReleaseConfirmModal();
                    // Show success message
                    showToast(data.message || 'IDP released successfully!');
                    // Reload page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    alert('Error releasing IDP: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error releasing IDP:', error);
                alert('Error releasing IDP: ' + error.message + '. Please try again.');
            });
        }

        // Toggle special needs details field based on radio button selection
        function toggleSpecialNeedsDetails() {
            const hasSpecialNeedsYes = document.querySelector('input[name="has_special_needs"][value="1"]:checked');
            const specialNeedsDetails = document.getElementById('specialNeedsDetails');
            const specialNeedsDetailsGroup = document.getElementById('specialNeedsDetailsGroup');
            
            if (hasSpecialNeedsYes) {
                // Enable the field if "Yes" is selected
                specialNeedsDetails.disabled = false;
                specialNeedsDetailsGroup.style.opacity = '1';
                specialNeedsDetailsGroup.style.pointerEvents = 'auto';
            } else {
                // Disable the field if "No" is selected
                specialNeedsDetails.disabled = true;
                specialNeedsDetails.value = ''; // Clear the value
                specialNeedsDetailsGroup.style.opacity = '0.5';
                specialNeedsDetailsGroup.style.pointerEvents = 'none';
            }
        }

        // Toggle special needs details field for edit modal
        function toggleEditSpecialNeedsDetails() {
            const hasSpecialNeedsYes = document.querySelector('input[name="has_special_needs"][value="1"]:checked');
            const specialNeedsDetails = document.getElementById('editSpecialNeedsDetails');
            const specialNeedsDetailsGroup = document.getElementById('editSpecialNeedsDetailsGroup');
            
            if (hasSpecialNeedsYes) {
                // Enable the field if "Yes" is selected
                specialNeedsDetails.disabled = false;
                specialNeedsDetailsGroup.style.opacity = '1';
                specialNeedsDetailsGroup.style.pointerEvents = 'auto';
            } else {
                // Disable the field if "No" is selected
                specialNeedsDetails.disabled = true;
                specialNeedsDetails.value = ''; // Clear the value
                specialNeedsDetailsGroup.style.opacity = '0.5';
                specialNeedsDetailsGroup.style.pointerEvents = 'none';
            }
        }

        // Show toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast show';
            toast.innerHTML = `<i class="fas fa-circle-check"></i><span>${message}</span>`;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Close modal on backdrop click
        document.getElementById('idpModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeIdpModal();
            }
        });

        document.getElementById('editIdpModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditIdpModal();
            }
        });

        document.getElementById('releaseConfirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReleaseConfirmModal();
            }
        });

        // Handle confirmation button click
        document.getElementById('confirmReleaseBtn').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            deleteIdp(id);
        });

        // Handle form submission with AJAX
        document.getElementById('idpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route('idps.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showToast(data.message || 'IDP added successfully!');
                    // Close modal
                    closeIdpModal();
                    // Reload page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Show error messages
                    if (data.errors) {
                        let errorMessage = 'Please fix the following errors:\n';
                        for (const [field, messages] of Object.entries(data.errors)) {
                            errorMessage += `${field}: ${messages.join(', ')}\n`;
                        }
                        alert(errorMessage);
                    } else {
                        alert('Error adding IDP: ' + (data.message || 'Unknown error'));
                    }
                }
            })
            .catch(error => {
                console.error('Error adding IDP:', error);
                alert('Error adding IDP. Please try again.');
            });
        });

        document.getElementById('editIdpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const id = this.getAttribute('data-id');
            
            fetch(`/idps/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-HTTP-Method-Override': 'PUT'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showToast(data.message || 'IDP updated successfully!');
                    // Close modal
                    closeEditIdpModal();
                    // Reload page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Show error messages
                    if (data.errors) {
                        let errorMessage = 'Please fix the following errors:\n';
                        for (const [field, messages] of Object.entries(data.errors)) {
                            errorMessage += `${field}: ${messages.join(', ')}\n`;
                        }
                        alert(errorMessage);
                    } else {
                        alert('Error updating IDP: ' + (data.message || 'Unknown error'));
                    }
                }
            })
            .catch(error => {
                console.error('Error updating IDP:', error);
                alert('Error updating IDP. Please try again.');
            });
        });
    </script>

</body>
</html>
