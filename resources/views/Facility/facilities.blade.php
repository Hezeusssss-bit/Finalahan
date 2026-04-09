<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Facilities Management — B-DEAMS</title>
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
        .main-content {
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

        /* ── MODAL ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 500;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.open { display: flex; }

        .modal {
            background: white;
            border-radius: 18px;
            width: 90%;
            max-width: 500px;
            max-height: 88vh;
            overflow-y: auto;
            scrollbar-width: none;
            animation: modalIn 0.25s cubic-bezier(0.175,0.885,0.32,1.275) both;
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 501;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25), 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .modal::-webkit-scrollbar { display: none; }

        @keyframes modalIn {
            from { opacity: 0; transform: translate(-50%, -50%) translateY(20px) scale(0.97); }
            to   { opacity: 1; transform: translate(-50%, -50%) translateY(0) scale(1); }
        }

        @keyframes modalPopIn {
            0% { 
                opacity: 0; 
                transform: scale(0.3) rotate(-2deg); 
                filter: blur(4px);
            }
            50% { 
                opacity: 0.8; 
                transform: scale(1.05) rotate(1deg); 
                filter: blur(0px);
            }
            100% { 
                opacity: 1; 
                transform: scale(1) rotate(0deg); 
                filter: blur(0px);
            }
        }

        @keyframes backdropFadeIn {
            from { 
                opacity: 0; 
                backdrop-filter: blur(0px); 
            }
            to { 
                opacity: 1; 
                backdrop-filter: blur(2px); 
            }
        }

        .modal-header {
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

        .modal-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

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

        /* ── MODAL BACKDROP (for logout modal) ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 500;
            display: none;
            align-items: center;
            justify-content: center;
            animation: backdropFadeIn 0.2s ease-out both;
        }

        .modal-backdrop.open { 
            display: flex;
            animation: backdropFadeIn 0.2s ease-out both;
        }

        .modal-box {
            background: white;
            border-radius: 18px;
            width: 90%;
            max-width: 500px;
            max-height: 88vh;
            overflow-y: auto;
            scrollbar-width: none;
            animation: modalPopIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25), 0 10px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 501;
            margin: auto;
        }

        .modal-box::-webkit-scrollbar { display: none; }

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

        .btn-add {
            padding: 9px 24px;
            border-radius: 10px;
            border: none;
            background: #0f172a;
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

        .btn-add:hover { background: #1e293b; }
        .btn-add:disabled { opacity: 0.6; cursor: not-allowed; }

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

        /* ── FACILITY GRID ── */
        .facility-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .facility-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            color: inherit;
        }

        .facility-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-color: var(--teal);
        }

        .facility-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
            background: var(--teal-light);
            color: var(--teal);
        }

        .facility-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .facility-description {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .facility-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .facility-capacity {
            font-size: 13px;
            color: var(--text-mid);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }

        .facility-capacity i {
            color: var(--blue);
            font-size: 12px;
        }

        .facility-actions {
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .facility-card:hover .facility-actions {
            opacity: 1;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 12px;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .edit-btn {
            background: var(--blue);
            color: white;
        }

        .edit-btn:hover {
            background: #2563eb;
        }

        .delete-btn {
            background: var(--rose);
            color: white;
        }

        .delete-btn:hover {
            background: #dc2626;
        }

        .status-available { background: var(--green-light); color: #065f46; }
        .status-maintenance { background: var(--amber-light); color: #92400e; }
        .status-unavailable { background: var(--rose-light); color: #9f1239; }

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
        @media (max-width: 1024px) {
            .facility-grid { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
        }

        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .main-content { margin-left: 0; padding: 24px 20px; }
            .facility-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('facilities') }}" class="nav-link active">
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
    <main class="main-content">

        <!-- Page Header -->
        <div class="page-header anim">
            <p class="page-eyebrow">Services</p>
            <h1 class="page-title">Facility Management</h1>
        </div>

        <!-- Facilities Panel -->
        <div class="panel anim delay-1">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-building"></i> Available Facilities
                </div>
                <button class="btn-add" onclick="openAddFacilityModal()">
                    <i class="fas fa-plus"></i>
                    Add Facility
                </button>
            </div>
            <div class="panel-body">
                <div class="facility-grid">
                    @forelse($facilities as $facility)
                        <div class="facility-card">
                            <div class="facility-icon">
                                <i class="{{ $facility->icon }}"></i>
                            </div>
                            <div class="facility-title">{{ $facility->name }}</div>
                            <div class="facility-description">{{ $facility->description }}</div>
                            <div class="facility-status status-{{ $facility->status }}">
                                {{ $facility->status_label }}
                            </div>
                            <div class="facility-capacity">
                                <i class="fas fa-users"></i>
                                Capacity: {{ $facility->capacity ?? 'N/A' }}
                            </div>
                            <div class="facility-actions">
                                <button onclick="editFacility({{ $facility->id }})" class="action-btn edit-btn" title="Edit Facility">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteFacility({{ $facility->id }}, '{{ $facility->name }}')" class="action-btn delete-btn" title="Delete Facility">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);">
                            <i class="fas fa-building" style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;"></i>
                            <h3 style="margin-bottom: 10px; color: var(--text-dark); font-family: 'Outfit', sans-serif;">No Facilities Yet</h3>
                            <p>Click the "Add Facility" button to add your first facility.</p>
                        </div>
                    @endforelse

                    <!-- Keep existing hardcoded facilities as fallback -->
                    @if($facilities->count() === 0)
                        <a href="{{ route('school') }}" class="facility-card" style="text-decoration: none; color: inherit;">
                            <div class="facility-icon"><i class="fas fa-school"></i></div>
                            <div class="facility-title">Schools</div>
                            <div class="facility-description">For Evacuation and Emergency Response</div>
                            <span class="facility-status status-available">Available</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </main>

    <!-- ══ ADD FACILITY MODAL ══ -->
    <div class="modal-overlay" id="facilityModalOverlay" style="display: none;"></div>
    <div class="modal" id="facilityModal" style="display: none;">
        <div class="modal-header">
            <h2>Add New Facility</h2>
            <button class="modal-close" onclick="closeFacilityModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <form id="facilityForm" onsubmit="submitFacility(event)">
                @csrf
                <div class="form-group">
                    <label class="form-label">Facility Name</label>
                    <input type="text" id="facilityName" name="name" required class="form-control" placeholder="Enter facility name">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="facilityStatus" name="status" required class="form-control">
                        <option value="">Select status...</option>
                        <option value="available">Available</option>
                        <option value="maintenance">Under Maintenance</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Capacity</label>
                    <input type="number" id="facilityCapacity" name="capacity" required min="1" class="form-control" placeholder="Enter evacuation area capacity">
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeFacilityModal()">Cancel</button>
                    <button type="submit" class="btn-add">
                        <i class="fas fa-save"></i>
                        Save Facility
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ EDIT FACILITY MODAL ══ -->
    <div class="modal-overlay" id="editFacilityModalOverlay" style="display: none;"></div>
    <div class="modal" id="editFacilityModal" style="display: none;">
        <div class="modal-header">
            <h2>Edit Facility</h2>
            <button class="modal-close" onclick="closeEditFacilityModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <form id="editFacilityForm" onsubmit="updateFacility(event)">
                @csrf
                <input type="hidden" id="editFacilityId" name="id">
                
                <div class="form-group">
                    <label class="form-label">Facility Name</label>
                    <input type="text" id="editFacilityName" name="name" required class="form-control" placeholder="Enter facility name">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="editFacilityStatus" name="status" required class="form-control">
                        <option value="">Select status...</option>
                        <option value="available">Available</option>
                        <option value="maintenance">Under Maintenance</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Capacity</label>
                    <input type="number" id="editFacilityCapacity" name="capacity" required min="1" class="form-control" placeholder="Enter evacuation area capacity">
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditFacilityModal()">Cancel</button>
                    <button type="submit" class="btn-add">
                        <i class="fas fa-save"></i>
                        Update Facility
                    </button>
                </div>
            </form>
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

<script>
// Logout Modal Functions
function openLogoutModal()    { openModal('logoutBackdrop'); }
function closeLogoutModal()   { closeModal('logoutBackdrop'); }

// Facility Modal Functions
function openAddFacilityModal() {
    document.getElementById('facilityModalOverlay').classList.add('open');
    document.getElementById('facilityModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Reset form
    document.getElementById('facilityForm').reset();
}

function closeFacilityModal() {
    document.getElementById('facilityModalOverlay').classList.remove('open');
    document.getElementById('facilityModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function submitFacility(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    submitBtn.disabled = true;
    
    // Send AJAX request
    fetch('/facilities', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showSuccessMessage('Facility added successfully!');
            
            // Close modal and reset form
            closeFacilityModal();
            
            // Optionally refresh the page or add the new facility to the grid
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            // Show validation errors
            let errorMessage = 'Please fix the following errors:\n';
            for (const [field, errors] of Object.entries(data.errors)) {
                errorMessage += `\n• ${errors.join(', ')}`;
            }
            alert(errorMessage);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the facility. Please try again.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function showSuccessMessage(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'toast show';
    successDiv.innerHTML = `<i class="fas fa-circle-check"></i><span>${message}</span>`;
    
    document.body.appendChild(successDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        successDiv.classList.remove('show');
        setTimeout(() => {
            successDiv.remove();
        }, 300);
    }, 3000);
}

// Close modal when clicking overlay
document.getElementById('facilityModalOverlay').addEventListener('click', closeFacilityModal);
document.getElementById('editFacilityModalOverlay').addEventListener('click', closeEditFacilityModal);

// Add logout backdrop click handler
document.getElementById('logoutBackdrop').addEventListener('click', e => { if (e.target.id === 'logoutBackdrop') closeModal('logoutBackdrop'); });

// Modal helpers
function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }

// Edit Facility Function
function editFacility(facilityId) {
    // Fetch facility data from server
    fetch(`/facilities/${facilityId}/edit`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Populate edit form with facility data
            document.getElementById('editFacilityId').value = data.facility.id;
            document.getElementById('editFacilityName').value = data.facility.name;
            document.getElementById('editFacilityStatus').value = data.facility.status;
            document.getElementById('editFacilityCapacity').value = data.facility.capacity || '';
            
            // Store initial values for change detection
            window.initialEditValues = {
                name: data.facility.name,
                status: data.facility.status,
                capacity: data.facility.capacity || ''
            };
            
            // Initially disable the update button
            const updateBtn = document.querySelector('#editFacilityForm button[type="submit"]');
            updateBtn.disabled = true;
            updateBtn.style.opacity = '0.5';
            updateBtn.style.cursor = 'not-allowed';
            
            // Add change listeners
            addEditFormListeners();
            
            // Open edit modal
            document.getElementById('editFacilityModalOverlay').classList.add('open');
            document.getElementById('editFacilityModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        } else {
            alert('Error: ' + (data.message || 'Failed to load facility data'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while loading facility data. Please try again.');
    });
}

// Add change listeners to edit form
function addEditFormListeners() {
    const nameInput = document.getElementById('editFacilityName');
    const statusSelect = document.getElementById('editFacilityStatus');
    const capacityInput = document.getElementById('editFacilityCapacity');
    const updateBtn = document.querySelector('#editFacilityForm button[type="submit"]');
    
    function checkForChanges() {
        const hasChanges = 
            nameInput.value !== window.initialEditValues.name ||
            statusSelect.value !== window.initialEditValues.status ||
            capacityInput.value !== window.initialEditValues.capacity;
        
        // Enable/disable button based on changes
        if (hasChanges) {
            updateBtn.disabled = false;
            updateBtn.style.opacity = '1';
            updateBtn.style.cursor = 'pointer';
        } else {
            updateBtn.disabled = true;
            updateBtn.style.opacity = '0.5';
            updateBtn.style.cursor = 'not-allowed';
        }
    }
    
    // Add input event listeners
    nameInput.addEventListener('input', checkForChanges);
    statusSelect.addEventListener('change', checkForChanges);
    capacityInput.addEventListener('input', checkForChanges);
}

// Close Edit Facility Modal
function closeEditFacilityModal() {
    document.getElementById('editFacilityModalOverlay').classList.remove('open');
    document.getElementById('editFacilityModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Update Facility Function
function updateFacility(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const facilityId = formData.get('id');
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    submitBtn.disabled = true;
    
    // Convert FormData to object and add _method for PUT
    const formDataObj = {};
    formData.forEach((value, key) => {
        formDataObj[key] = value;
    });
    formDataObj._method = 'PUT';
    
    // Send PUT request
    fetch(`/facilities/${facilityId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formDataObj)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showSuccessMessage('Facility updated successfully!');
            
            // Close modal and reset form
            closeEditFacilityModal();
            
            // Reload page to show updated data
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            // Show validation errors
            let errorMessage = 'Please fix the following errors:\n';
            for (const [field, errors] of Object.entries(data.errors)) {
                errorMessage += `\n• ${errors.join(', ')}`;
            }
            alert(errorMessage);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the facility. Please try again.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Delete Facility Function
function deleteFacility(facilityId, facilityName) {
    if (confirm(`Are you sure you want to delete "${facilityName}"?\n\nThis action cannot be undone.`)) {
        // Show loading state
        const facilityCard = event.target.closest('.facility-card');
        facilityCard.style.opacity = '0.5';
        facilityCard.style.pointerEvents = 'none';
        
        // Send DELETE request
        fetch(`/facilities/${facilityId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                               document.querySelector('input[name="_token"]')?.value,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showSuccessMessage('Facility deleted successfully!');
                
                // Remove the facility card with animation
                facilityCard.style.transition = 'all 0.3s ease';
                facilityCard.style.transform = 'scale(0.8)';
                facilityCard.style.opacity = '0';
                
                setTimeout(() => {
                    facilityCard.remove();
                }, 300);
            } else {
                // Show error message
                alert('Error: ' + (data.message || 'Failed to delete facility'));
                // Reset the card state
                facilityCard.style.opacity = '1';
                facilityCard.style.pointerEvents = 'auto';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the facility. Please try again.');
            // Reset the card state
            facilityCard.style.opacity = '1';
            facilityCard.style.pointerEvents = 'auto';
        });
    }
}
</script>

</body>
</html>
