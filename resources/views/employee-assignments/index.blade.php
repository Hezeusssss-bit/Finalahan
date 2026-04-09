<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Employee Assignments — B-DEAMS</title>
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


        /* ── MAIN ── */
        .main {
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
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn { 
            padding: 9px 20px; 
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
            text-decoration: none;
        }

        .btn:hover { background: var(--navy-mid); }
        .btn.green { background: var(--green); }
        .btn.green:hover { background: #059669; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-mid);
        }

        .btn-outline:hover {
            background: var(--slate-light);
            border-color: var(--slate-light);
        }

        .btn-outline.teal {
            color: var(--teal);
            border-color: var(--teal);
        }

        .btn-outline.teal:hover {
            background: var(--teal-light);
        }

        .btn-outline.dark {
            color: var(--text-light);
            border-color: var(--slate-dark);
            background: var(--slate-dark);
        }

        .btn-outline.dark:hover {
            background: var(--slate-mid);
            border-color: var(--slate-mid);
        }

        /* ── PANEL ── */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
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
        .panel-body { padding: 20px 24px; }

        /* ── TABLE ── */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
        }
        
        .table th, .table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        .table th {
            background: var(--slate-light);
            font-weight: 600;
            color: var(--text-dark);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .table tr:hover {
            background: var(--slate-light);
        }
        
        .table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-active {
            background: var(--green-light);
            color: #065f46;
        }

        .status-completed {
            background: var(--slate-light);
            color: var(--text-mid);
        }

        .status-cancelled {
            background: var(--rose-light);
            color: #9f1239;
        }

        /* ── EMPLOYEE ROWS ── */
        .employee-row {
            margin-bottom: 12px;
        }

        .employee-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: all 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .employee-header:hover {
            border-color: var(--teal);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 160, 0.15);
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .employee-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
            font-family: 'Outfit', sans-serif;
        }

        .employee-details h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            font-family: 'Outfit', sans-serif;
        }

        .employee-details p {
            margin: 0;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .assignment-count {
            background: var(--teal-light);
            color: var(--teal);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
        }

        .chevron {
            color: var(--text-muted);
            font-size: 14px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-mid);
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: var(--teal);
            color: white;
        }

        .pagination .current {
            background: var(--teal);
            color: white;
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

        .modal-backdrop.show { display: flex; }

        .modal-box {
            background: white;
            border-radius: 18px;
            width: 90%;
            max-width: 600px;
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

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-top: 18px;
        }

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
        @media (max-width: 768px) {
            .main { padding: 24px 20px; }
        }

</style>
</head>
<body>

    <!-- ══ MAIN CONTENT ══ -->
    <main class="main">
        <!-- Page Header -->
        <div class="page-header anim" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p class="page-eyebrow">Management</p>
                <h1 class="page-title">
                    <i class="fas fa-user-check"></i>
                    Employee Assignments
                </h1>
            </div>
            <div style="margin-top: -20px;">
                <a href="{{ route('resident.index') }}" class="btn btn-outline dark">
                    <i class="fas fa-arrow-left"></i>
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="flash-alert success anim">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        <!-- Employee Assignments Panel -->
        <div class="panel anim delay-1">
            <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="panel-title">
                    <i class="fas fa-user-check"></i> Employee Assignments
                </div>
                <button class="btn btn-outline teal" onclick="openCreateModal()">
                    <i class="fas fa-plus"></i>
                    New Assignment
                </button>
            </div>
        <div class="panel anim delay-1">
            <div class="panel-body">

                @if($assignments->count() > 0)
                    <?php 
                        // Group assignments by employee
                        $groupedAssignments = [];
                        foreach ($assignments as $assignment) {
                            $employeeId = $assignment->employee_id;
                            if (!isset($groupedAssignments[$employeeId])) {
                                $groupedAssignments[$employeeId] = [
                                    'employee' => $assignment->employee,
                                    'assignments' => []
                                ];
                            }
                            $groupedAssignments[$employeeId]['assignments'][] = $assignment;
                        }
                    ?>

                    @foreach($groupedAssignments as $employeeId => $data)
                        <div class="employee-row">
                            <a href="{{ route('employee-assignments.employee', $data['employee']) }}" class="employee-header">
                                <div class="employee-info">
                                    <div class="employee-avatar">
                                        {{ strtoupper(substr($data['employee']->name, 0, 1)) }}
                                    </div>
                                    <div class="employee-details">
                                        <h3>{{ $data['employee']->name }}</h3>
                                        <p>{{ $data['employee']->position }}</p>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="assignment-count">{{ count($data['assignments']) }} {{ count($data['assignments']) == 1 ? 'Assignment' : 'Assignments' }}</span>
                                    <i class="fas fa-chevron-right chevron"></i>
                                </div>
                            </a>
                        </div>
                    @endforeach

                @else
                    <div style="text-align: center; padding: 60px 20px; color: var(--text-muted);">
                        <i class="fas fa-user-check" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.3;"></i>
                        <h3 style="margin-bottom: 8px; color: var(--text-mid); font-family: 'Outfit', sans-serif;">No Employee Assignments</h3>
                        <p>Get started by creating your first employee assignment.</p>
                        <button type="button" class="btn" onclick="openCreateModal()">
                            <i class="fas fa-plus"></i>
                            Create Assignment
                        </button>
                    </div>
                @endif
            </div>
        </div>

    </main>

    <!-- ══ CREATE ASSIGNMENT MODAL ══ -->
    <div class="modal-backdrop" id="createAssignmentModal">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Assign Employee to Evacuation Center</div>
                    <div class="modal-head-sub">Assign an employee to manage residents at a specific evacuation center</div>
                </div>
                <button class="modal-close" onclick="closeCreateModal()"><i class="fas fa-xmark"></i></button>
            </div>
            
            <div class="modal-body">
                @if($errors->any())
                    <div class="flash-alert error">
                        <i class="fas fa-triangle-exclamation"></i>
                        <span>
                            @foreach($errors->all() as $error)
                                {{ $error }}@if(!$loop->last), @endif
                            @endforeach
                        </span>
                    </div>
                @endif

                <form id="createAssignmentForm" method="POST" action="{{ route('employee-assignments.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="employee_id" class="form-label">Select Employee</label>
                        <select id="employee_id" name="employee_id" class="form-control" required>
                            <option value="">Choose an employee...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->position }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="evacuation_center" class="form-label">Evacuation Center</label>
                        <select id="evacuation_center" name="evacuation_center" class="form-control" required>
                            <option value="">Select evacuation center...</option>
                            @foreach($evacuationCenters as $center)
                                <option value="{{ $center }}">{{ $center }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="responsibilities" class="form-label">Responsibilities</label>
                        <textarea id="responsibilities" name="responsibilities" class="form-control" placeholder="e.g., Organize residents, manage supplies, maintain order..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Additional Notes</label>
                        <textarea id="notes" name="notes" class="form-control" placeholder="Any additional instructions or notes..."></textarea>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeCreateModal()">Cancel</button>
                        <button type="submit" class="btn-submit green">Create Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>

    <script>
        const csrf = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ── Modal helpers ──
        function openModal(id)  { document.getElementById(id).classList.add('show'); document.body.style.overflow = 'hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('show'); document.body.style.overflow = ''; }

        // Modal functionality
        function openCreateModal() {
            openModal('createAssignmentModal');
        }

        function closeCreateModal() {
            closeModal('createAssignmentModal');
            
            // Reset form
            document.getElementById('createAssignmentForm').reset();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const createModal = document.getElementById('createAssignmentModal');
            
            if (event.target == createModal) {
                closeCreateModal();
            }
        }

        // Handle form submission with AJAX (optional - for better UX)
        document.getElementById('createAssignmentForm').addEventListener('submit', function(e) {
            // You can add AJAX submission here if you want to avoid page reload
            // For now, let it submit normally
        });
    </script>
