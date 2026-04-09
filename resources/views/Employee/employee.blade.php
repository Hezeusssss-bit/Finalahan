<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Employee Management — B-DEAMS</title>
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
        
        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            margin: 0 2px;
            border-radius: 8px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }
        
        .btn-icon:hover {
            background: var(--slate-light);
            transform: translateY(-1px);
        }
        
        .btn-icon.edit:hover i { color: var(--blue); }
        .btn-icon.delete:hover i { color: var(--rose); }
        .btn-icon.assign:hover i { color: var(--green); }
        
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
        
        .pagination {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            gap: 10px;
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            background: var(--navy-mid);
            color: var(--white);
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .back-button:hover {
            background: var(--navy);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .back-button i {
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .back-button:hover i {
            transform: translateX(-2px);
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
            .main { padding: 24px 20px; }
            .stats-row { grid-template-columns: 1fr; }
            .quick-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>


    <!-- ══ MAIN CONTENT ══ -->
    <main class="main">
        <!-- Page Header -->
        <div class="page-header anim">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p class="page-eyebrow">Administration</p>
                    <h1 class="page-title">Employee Management</h1>
                </div>
                <a href="{{ route('resident.index') }}" class="back-button">
                    <i class="fas fa-chevron-left"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="flash-alert success anim">
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        @if(session('error'))
        <div class="flash-alert error anim">
            <i class="fas fa-triangle-exclamation"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif
        
        @if($errors->any())
        <div class="flash-alert error anim">
            <i class="fas fa-triangle-exclamation"></i>
            <span>
                @foreach($errors->all() as $error)
                    {{ $error }}@if(!$loop->last), @endif
                @endforeach
            </span>
        </div>
        @endif

        <!-- Employee List Panel -->
        <div class="panel anim delay-1">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-users"></i> Employee List
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="position: relative; width: 300px;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" id="searchEmployee" placeholder="Search employees..." class="form-control" style="padding-left: 40px;">
                    </div>
                    <button class="btn" onclick="openAddEmployeeModal()">
                        <i class="fas fa-user-plus"></i>
                        Add Employee
                    </button>
                </div>
            </div>
            <div class="panel-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody">
                        @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->department }}</td>
                            <td>{{ $employee->email }}</td>
                            <td style="text-align: right;">
                                <button onclick="editEmployee({{ $employee->id }});" class="btn-icon edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openAssignmentModal({{ $employee->id }}, '{{ $employee->name }}')" class="btn-icon assign" title="Assign Task">
                                    <i class="fas fa-user-check"></i>
                                </button>
                                <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.3;"></i>
                                <div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No employees found</div>
                                <div style="font-size: 14px; opacity: 0.7;">Click "Add Employee" to get started.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; color: var(--text-muted); font-size: 14px;">
                    <div>Showing {{ $employees->count() }} employees</div>
                </div>
            </div>
        </div>

    </main>

    <!-- ══ EMPLOYEE MODAL ══ -->
    <div class="modal-backdrop" id="employeeModalOverlay">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title" id="modalTitle">Add New Employee</div>
                    <div class="modal-head-sub">Fill in the employee details below</div>
                </div>
                <button class="modal-close" onclick="closeEmployeeModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="employeeForm" action="{{ route('employee.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="employeeId" name="employee_id">
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    
                    <div class="form-group">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" id="fullName" name="name" required class="form-control" placeholder="Enter full name">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" required class="form-control" placeholder="Enter email">
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" required class="form-control" placeholder="Enter password">
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control" placeholder="Confirm password">
                    </div>
                    
                    <div class="form-group">
                        <label for="position" class="form-label">Position</label>
                        <select id="position" name="position" required class="form-control">
                            <option value="">Select position</option>
                            <option value="Staff">Staff</option>

                        </select>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Enter contact number">
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" name="address" class="form-control" placeholder="Enter address"></textarea>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="hire_date" class="form-label">Hire Date</label>
                        <input type="date" id="hire_date" name="hire_date" class="form-control">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeEmployeeModal()">Cancel</button>
                        <button type="submit" class="btn-submit">Save Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Include any additional scripts here -->
<script>
    const csrf = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ── Modal helpers ──
    function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }

    document.addEventListener('DOMContentLoaded', function() {
        ['employeeModalOverlay','assignmentModalOverlay'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('click', e => { if (e.target.id === id) closeModal(id); });
            }
        });
    });

// Employee CRUD operations
function openAddEmployeeModal() {
    document.getElementById('modalTitle').textContent = 'Add New Employee';
    document.getElementById('employeeForm').reset();
    document.getElementById('employeeId').value = '';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('employeeForm').action = '{{ route("employee.store") }}';

    // Set current date for hire_date
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months start at 0!
    const dd = String(today.getDate()).padStart(2, '0');
    document.getElementById('hire_date').value = `${yyyy}-${mm}-${dd}`;

    openModal('employeeModalOverlay');
}

function closeEmployeeModal() {
    closeModal('employeeModalOverlay');
}

function editEmployee(employeeId) {
    // Fetch employee data from API
    fetch(`{{ route('employee.get', ':id') }}`.replace(':id', employeeId))
        .then(response => response.json())
        .then(employee => {
            document.getElementById('modalTitle').textContent = 'Edit Employee';
            document.getElementById('employeeId').value = employee.id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('employeeForm').action = `{{ route('employee.update', ':id') }}`.replace(':id', employee.id);
            
            // Populate form fields
            document.getElementById('fullName').value = employee.name;
            document.getElementById('email').value = employee.email;
            document.getElementById('position').value = employee.position;
            document.getElementById('contact_number').value = employee.contact_number || '';
            document.getElementById('address').value = employee.address || '';
            document.getElementById('hire_date').value = employee.hire_date || '';
            
            openModal('employeeModalOverlay');
        })
        .catch(error => {
            console.error('Error fetching employee:', error);
            alert('Error loading employee data. Please try again.');
        });
}

// Remove old JavaScript simulation code
// The employee data is now loaded from the backend
</script>

<style>
.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.btn-outline {
    background: #fff;
    border: 1px solid #dee2e6;
    color: #6c757d;
}

.btn-outline:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
}

.btn-icon {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    margin: 0 2px;
    border-radius: 4px;
    transition: all 0.2s;
    position: relative;
    z-index: 10;
    pointer-events: auto;
}

.btn-icon:hover {
    background: rgba(0, 0, 0, 0.05);
}

.pagination {
    display: flex;
    align-items: center;
}

.table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    text-align: left;
    padding: 12px 15px;
}

th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
    border-bottom: 1px solid #e9ecef;
}

tr:not(:last-child) {
    border-bottom: 1px solid #f1f1f1;
}

tr:hover {
    background-color: #f8f9fa;
}

/* Modal styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: none;
}

.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 8px;
    padding: 25px;
    z-index: 1001;
    max-height: 90vh;
    overflow-y: auto;
    width: 90%;
    max-width: 600px;
    display: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal {
        width: 95%;
        padding: 15px;
    }
    
    th, td {
        padding: 10px 8px;
    }
    
    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .header h1 {
        font-size: 20px;
    }
}
</style>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchEmployee');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#employeeTableBody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
            
            // Add form submission listener for debugging
            const employeeForm = document.getElementById('employeeForm');
            if (employeeForm) {
                employeeForm.addEventListener('submit', function(e) {
                    console.log('Form submitting!');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    // Let the form submit normally
                });
            }
        });
    </script>
    
    <!-- ══ ASSIGNMENT MODAL ══ -->
    <div class="modal-backdrop" id="assignmentModalOverlay">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <div class="modal-head-title">Assign Employee to Evacuation Center</div>
                    <div class="modal-head-sub">Assign an employee to manage residents at a specific evacuation center</div>
                </div>
                <button class="modal-close" onclick="closeAssignmentModal()"><i class="fas fa-xmark"></i></button>
            </div>
            
            <div class="modal-body">
                <form id="assignmentForm" onsubmit="submitAssignment(event)">
                    @csrf
                    <input type="hidden" id="employeeId" name="employee_id">
                    
                    <div class="form-group">
                        <label for="employeeName" class="form-label">Select Employee</label>
                        <select id="employeeName" name="employee_name" required class="form-control">
                            <option value="">Choose an employee...</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="evacuationCenter" class="form-label">Evacuation Center</label>
                        <select id="evacuationCenter" name="evacuation_center" required class="form-control">
                            <option value="">Select evacuation center...</option>
                            <option value="Barangay Hall Evacuation Center">Barangay Hall Evacuation Center</option>
                            <option value="Community Center Evacuation">Community Center Evacuation</option>
                            <option value="School Gymnasium">School Gymnasium</option>
                            <option value="Sports Complex">Sports Complex</option>
                            <option value="Multi-Purpose Hall">Multi-Purpose Hall</option>
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
                        <button type="button" class="btn-cancel" onclick="closeAssignmentModal()">Cancel</button>
                        <button type="submit" class="btn-submit green">Assign Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<script>
function openAssignmentModal(employeeId, employeeName) {
    console.log('Assignment button clicked!', employeeId, employeeName);
    
    // Fetch facilities from API
    fetch('/facilities/api')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Get the evacuation center select element
                const evacuationCenterSelect = document.getElementById('evacuationCenter');
                
                // Clear existing options
                evacuationCenterSelect.innerHTML = '<option value="">Select evacuation center...</option>';
                
                // Add facilities as options
                data.facilities.forEach(facility => {
                    const option = document.createElement('option');
                    option.value = facility.id;
                    option.textContent = facility.name;
                    evacuationCenterSelect.appendChild(option);
                });
                
                console.log('Facilities loaded and dropdown populated');
            } else {
                console.error('Failed to load facilities');
                alert('Error loading facilities. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading facilities. Please try again.');
        });
    
    // Set employee ID and populate employee dropdown
    document.getElementById('employeeId').value = employeeId;
    
    // Simple population of employee dropdown
    const employeeSelect = document.getElementById('employeeName');
    if (employeeSelect) {
        employeeSelect.innerHTML = `<option value="${employeeId}" selected>${employeeName}</option>`;
    }
    
    // Open modal
    openModal('assignmentModalOverlay');
}

function closeAssignmentModal() {
    closeModal('assignmentModalOverlay');
    document.getElementById('assignmentForm').reset();
}

function submitAssignment(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Update employee_id from the dropdown selection
    const employeeSelect = document.getElementById('employeeName');
    const evacuationCenterSelect = document.getElementById('evacuationCenter');
    formData.set('employee_id', employeeSelect.value);
    
    // Add evacuation center data if selected
    if (evacuationCenterSelect && evacuationCenterSelect.value) {
        formData.set('evacuation_center', evacuationCenterSelect.value);
    }
    
    // Show loading state
    submitBtn.innerHTML = 'Assigning...';
    submitBtn.disabled = true;
    
    // Send AJAX request
    fetch('/employee-assignments', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert('Task assigned successfully!');
            
            // Close modal and reset form
            closeAssignmentModal();
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
        alert('An error occurred while assigning the task. Please try again.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

</script>
</body>
</html>
