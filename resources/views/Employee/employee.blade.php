<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Management - MSWD</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        body {
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }
        
        .btn {
            background: #1a1a2e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .panel {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            margin: 0 2px;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .btn-icon:hover {
            background: rgba(0, 0, 0, 0.05);
        }
        
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
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        .modal::-webkit-scrollbar {
            display: none;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
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
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            margin-right: 15px;
            vertical-align: middle;
        }
        
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .back-button i {
            font-size: 18px;
            color: #4A4A4A;
        }
        
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="header" style="display: flex; align-items: center; padding: 20px;">
        <a href="{{ route('resident.index') }}" class="back-button">
            <i class="fas fa-chevron-left"></i>
        </a>
    </div>
<div class="main-content">
    <div class="header">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
            <h1>Employee Management</h1>
            <button class="btn" style="display: flex; align-items: center; gap: 8px;" onclick="openAddEmployeeModal()">
                <i class="fas fa-user-plus"></i>
                Add Employee
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert" style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert" style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel full" style="margin-top: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="font-weight: 700; color: #333; font-size: 16px;">Employee List</div>
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                <input type="text" id="searchEmployee" placeholder="Search employees..." style="width: 100%; padding: 8px 15px 8px 40px; border: 1px solid #e9ecef; border-radius: 4px; font-size: 14px;">
            </div>
        </div>

        <div class="table-responsive" style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #495057;">Name</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #495057;">Position</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #495057;">Department</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #495057;">Email</th>
                        <th style="padding: 12px 15px; text-align: right; font-weight: 600; color: #495057;">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    @forelse($employees as $employee)
                    <tr style="border-bottom: 1px solid #f1f1f1;">
                        <td style="padding: 12px 15px;">{{ $employee->name }}</td>
                        <td style="padding: 12px 15px;">{{ $employee->position }}</td>
                        <td style="padding: 12px 15px;">{{ $employee->department }}</td>
                        <td style="padding: 12px 15px;">{{ $employee->email }}</td>
                        <td style="padding: 12px 15px; text-align: right; position: relative;">
                            <button onclick="editEmployee({{ $employee->id }});" class="btn-icon" title="Edit">
                                <i class="fas fa-edit" style="color: #4e73df;"></i>
                            </button>
                            <button onclick="openAssignmentModal({{ $employee->id }}, '{{ $employee->name }}')" class="btn-icon" title="Assign Task" style="background: #28a745; border: 1px solid #28a745;">
                                <i class="fas fa-user-check" style="color: white;"></i>
                            </button>
                            <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete">
                                    <i class="fas fa-trash-alt" style="color: #e74a3b;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d;">
                            No employees found. Click "Add Employee" to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; color: #6c757d; font-size: 14px;">
            <div>Showing {{ $employees->count() }} of {{ $employees->count() }} employees</div>
        </div>
    </div>
</div>

<!-- Add/Edit Employee Modal -->
<div class="modal-overlay" id="employeeModalOverlay" style="display: none;"></div>
<div class="modal" id="employeeModal" style="display: none; max-width: 500px;">
    <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #1a1a2e;" id="modalTitle">Add New Employee</h2>
        <button onclick="closeEmployeeModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #666;">&times;</button>
    </div>
    <form id="employeeForm" action="{{ route('employee.store') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <input type="hidden" id="employeeId" name="employee_id">
        <input type="hidden" id="formMethod" name="_method" value="POST">
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="fullName" style="display: block; margin-bottom: 5px; font-weight: 500;">Full Name</label>
            <input type="text" id="fullName" name="name" required class="form-control" placeholder="Enter full name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
            <input type="email" id="email" name="email" required class="form-control" placeholder="Enter email" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: 500;">Password</label>
            <input type="password" id="password" name="password" required class="form-control" placeholder="Enter password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: 500;">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control" placeholder="Confirm password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="position" style="display: block; margin-bottom: 5px; font-weight: 500;">Position</label>
            <select id="position" name="position" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background: white;">
                <option value="">Select position</option>
                <option value="Administrator">Administrator</option>
                <option value="Staff">Staff</option>
                <option value="Manager">Manager</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Officer">Officer</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="department" style="display: block; margin-bottom: 5px; font-weight: 500;">Department</label>
            <input type="text" id="department" name="department" required class="form-control" placeholder="Enter department" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="contact_number" style="display: block; margin-bottom: 5px; font-weight: 500;">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Enter contact number" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="address" style="display: block; margin-bottom: 5px; font-weight: 500;">Address</label>
            <textarea id="address" name="address" class="form-control" placeholder="Enter address" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"></textarea>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="hire_date" style="display: block; margin-bottom: 5px; font-weight: 500;">Hire Date</label>
            <input type="date" id="hire_date" name="hire_date" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee;">
            <button type="button" class="btn btn-outline" onclick="closeEmployeeModal()" style="background: #f8f9fa; border: 1px solid #ddd; color: #333; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Cancel</button>
            <button type="submit" class="btn" style="background: #1a1a2e; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer;" onclick="console.log('Submit button clicked')">Save Employee</button>
        </div>
    </form>
</div>

<!-- Include any additional scripts here -->
<script>
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

    document.getElementById('employeeModalOverlay').style.display = 'block';
    document.getElementById('employeeModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeEmployeeModal() {
    document.getElementById('employeeModalOverlay').style.display = 'none';
    document.getElementById('employeeModal').style.display = 'none';
    document.body.style.overflow = 'auto';
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
            document.getElementById('department').value = employee.department;
            document.getElementById('contact_number').value = employee.contact_number || '';
            document.getElementById('address').value = employee.address || '';
            document.getElementById('hire_date').value = employee.hire_date || '';
            
            document.getElementById('employeeModalOverlay').style.display = 'block';
            document.getElementById('employeeModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
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
    
    <!-- Assignment Modal -->
<div class="modal-overlay" id="assignmentModalOverlay" style="display: none;"></div>
<div class="modal" id="assignmentModal" style="display: none; max-width: 500px;">
    <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #1a1a2e; font-size: 24px; font-weight: 600;">Assign Employee to Evacuation Center</h2>
        <button type="button" onclick="closeAssignmentModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #666;">&times;</button>
    </div>
    
    <p style="color: #666; margin-bottom: 25px; font-size: 14px; line-height: 1.5;">Assign an employee to manage and organize residents at a specific evacuation center.</p>
    
    <form id="assignmentForm" onsubmit="submitAssignment(event)">
        @csrf
        <input type="hidden" id="employeeId" name="employee_id">
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Select Employee</label>
            <select id="employeeName" name="employee_name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background: white;">
                <option value="">Choose an employee...</option>
            </select>
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Evacuation Center</label>
            <select id="evacuationCenter" name="evacuation_center" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background: white;">
                <option value="">Select evacuation center...</option>
                <option value="Barangay Hall Evacuation Center">Barangay Hall Evacuation Center</option>
                <option value="Community Center Evacuation">Community Center Evacuation</option>
                <option value="School Gymnasium">School Gymnasium</option>
                <option value="Sports Complex">Sports Complex</option>
                <option value="Multi-Purpose Hall">Multi-Purpose Hall</option>
            </select>
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Responsibilities</label>
            <textarea id="responsibilities" name="responsibilities" rows="4" placeholder="e.g., Organize residents, manage supplies, maintain order..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical; min-height: 100px;"></textarea>
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Additional Notes</label>
            <textarea id="notes" name="notes" rows="3" placeholder="Any additional instructions or notes..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical; min-height: 80px;"></textarea>
        </div>
        
        <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
            <button type="button" onclick="closeAssignmentModal()" class="btn btn-outline" style="background: #f8f9fa; border: 1px solid #ddd; color: #333; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500;">Cancel</button>
            <button type="submit" class="btn" style="background: #28a745; color: white; border: none; padding: 10px 24px; border-radius: 6px; cursor: pointer; font-weight: 500;">Assign Task</button>
        </div>
    </form>
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
    
    // Simple modal opening - just set display to block
    const overlay = document.getElementById('assignmentModalOverlay');
    const modal = document.getElementById('assignmentModal');
    
    if (overlay && modal) {
        console.log('Elements found, opening modal');
        document.getElementById('employeeId').value = employeeId;
        
        // Simple population of employee dropdown
        const employeeSelect = document.getElementById('employeeName');
        if (employeeSelect) {
            employeeSelect.innerHTML = `<option value="${employeeId}" selected>${employeeName}</option>`;
        }
        
        overlay.style.display = 'block';
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        console.log('Modal should be visible now');
    } else {
        console.error('Modal elements not found!');
        alert('Error: Modal not found');
    }
}

function closeAssignmentModal() {
    document.getElementById('assignmentModalOverlay').style.display = 'none';
    document.getElementById('assignmentModal').style.display = 'none';
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
