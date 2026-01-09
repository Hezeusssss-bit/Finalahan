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
        <div class="alert success">{{ session('success') }}</div>
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
                    <!-- Employee data will be loaded here via JavaScript -->
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d;">
                            No employees found. Click "Add Employee" to get started.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; color: #6c757d; font-size: 14px;">
            <div>Showing <span id="showingCount">0</span> of <span id="totalCount">0</span> employees</div>
            <div class="pagination">
                <button class="btn btn-outline" id="prevPage" disabled>Previous</button>
                <span style="margin: 0 15px;">Page <span id="currentPage">1</span></span>
                <button class="btn btn-outline" id="nextPage" disabled>Next</button>
            </div>
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
    <form id="employeeForm" onsubmit="saveEmployee(event)" style="margin-top: 20px;">
        <input type="hidden" id="employeeId">
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="fullName" style="display: block; margin-bottom: 5px; font-weight: 500;">Full Name</label>
            <input type="text" id="fullName" required class="form-control" placeholder="Enter full name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
            <input type="email" id="email" required class="form-control" placeholder="Enter email" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="position" style="display: block; margin-bottom: 5px; font-weight: 500;">Position</label>
            <select id="position" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background: white;">
                <option value="">Select position</option>
                <option value="admin">Administrator</option>
                <option value="staff">Staff</option>
                <option value="manager">Manager</option>
                <option value="supervisor">Supervisor</option>
                <option value="officer">Officer</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="department" style="display: block; margin-bottom: 5px; font-weight: 500;">Department</label>
            <input type="text" id="department" required class="form-control" placeholder="Enter department" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee;">
            <button type="button" class="btn btn-outline" onclick="closeEmployeeModal()" style="background: #f8f9fa; border: 1px solid #ddd; color: #333; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Cancel</button>
            <button type="submit" class="btn" style="background: #1a1a2e; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer;">Save Employee</button>
        </div>
    </form>
</div>

<!-- Include any additional scripts here -->
<script>
// Sample employee data (replace with actual API calls in production)
let employees = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
const employeeTableBody = document.getElementById('employeeTableBody');
const searchInput = document.getElementById('searchEmployee');
const prevPageBtn = document.getElementById('prevPage');
const nextPageBtn = document.getElementById('nextPage');
const currentPageSpan = document.getElementById('currentPage');
const showingCountSpan = document.getElementById('showingCount');
const totalCountSpan = document.getElementById('totalCount');

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Load employees (in a real app, this would be an API call)
    loadEmployees();
    
    // Add event listeners
    searchInput.addEventListener('input', filterEmployees);
    prevPageBtn.addEventListener('click', goToPrevPage);
    nextPageBtn.addEventListener('click', goToNextPage);
});

// Load employees (simulated)
function loadEmployees() {
    // In a real app, you would fetch this from your API
    // For now, we'll use sample data
    employees = [];
    
    // Uncomment the line below to add sample data
    // employees = generateSampleEmployees(25);
    
    renderEmployees();
}

// Render employees in the table
function renderEmployees() {
    const filteredEmployees = filterEmployees();
    const start = (currentPage - 1) * itemsPerPage;
    const paginatedEmployees = filteredEmployees.slice(start, start + itemsPerPage);
    
    // Update table
    if (paginatedEmployees.length > 0) {
        let html = '';
        paginatedEmployees.forEach(emp => {
            html += `
                <tr style="border-bottom: 1px solid #f1f1f1;">
                    <td style="padding: 12px 15px;">${emp.name}</td>
                    <td style="padding: 12px 15px;">${emp.position}</td>
                    <td style="padding: 12px 15px;">${emp.department}</td>
                    <td style="padding: 12px 15px;">${emp.email}</td>
                    <td style="padding: 12px 15px; text-align: right;">
                        <button onclick="editEmployee('${emp.id}');" class="btn-icon" title="Edit">
                            <i class="fas fa-edit" style="color: #4e73df;"></i>
                        </button>
                        <button onclick="deleteEmployee('${emp.id}');" class="btn-icon" title="Delete">
                            <i class="fas fa-trash-alt" style="color: #e74a3b;"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        employeeTableBody.innerHTML = html;
    } else {
        employeeTableBody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d;">
                    No employees found. Try adjusting your search or add a new employee.
                </td>
            </tr>
        `;
    }
    
    // Update pagination
    updatePagination(filteredEmployees.length);
    
    // Update counts
    showingCountSpan.textContent = paginatedEmployees.length;
    totalCountSpan.textContent = filteredEmployees.length;
}

// Filter employees based on search input
function filterEmployees() {
    const searchTerm = searchInput.value.toLowerCase();
    const filtered = employees.filter(emp => 
        emp.name.toLowerCase().includes(searchTerm) ||
        emp.email.toLowerCase().includes(searchTerm) ||
        emp.position.toLowerCase().includes(searchTerm) ||
        emp.department.toLowerCase().includes(searchTerm)
    );
    
    // Reset to first page when filtering
    currentPage = 1;
    currentPageSpan.textContent = currentPage;
    
    renderEmployees();
    return filtered;
}

// Pagination functions
function goToPrevPage() {
    if (currentPage > 1) {
        currentPage--;
        currentPageSpan.textContent = currentPage;
        renderEmployees();
    }
}

function goToNextPage() {
    const totalPages = Math.ceil(employees.length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        currentPageSpan.textContent = currentPage;
        renderEmployees();
    }
}

function updatePagination(totalItems) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    
    prevPageBtn.disabled = currentPage === 1;
    nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
}

// Employee CRUD operations
function openAddEmployeeModal() {
    document.getElementById('modalTitle').textContent = 'Add New Employee';
    document.getElementById('employeeForm').reset();
    document.getElementById('employeeId').value = '';
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
    // In a real app, you would fetch the employee data from your API
    const employee = employees.find(emp => emp.id === employeeId);
    
    if (employee) {
        document.getElementById('modalTitle').textContent = 'Edit Employee';
        document.getElementById('employeeId').value = employee.id;
        document.getElementById('fullName').value = employee.name;
        document.getElementById('email').value = employee.email;
        document.getElementById('position').value = employee.position;
        document.getElementById('department').value = employee.department;
        
        document.getElementById('employeeModalOverlay').style.display = 'block';
        document.getElementById('employeeModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function saveEmployee(event) {
    event.preventDefault();
    
    const employeeData = {
        id: document.getElementById('employeeId').value || generateId(),
        name: document.getElementById('fullName').value,
        email: document.getElementById('email').value,
        position: document.getElementById('position').value,
        department: document.getElementById('department').value
    };
    
    // In a real app, you would send this to your API
    const existingIndex = employees.findIndex(emp => emp.id === employeeData.id);
    
    if (existingIndex >= 0) {
        // Update existing employee
        employees[existingIndex] = employeeData;
    } else {
        // Add new employee
        employees.push(employeeData);
    }
    
    // Show success message
    alert('Employee saved successfully!');
    
    // Close modal and refresh the list
    closeEmployeeModal();
    renderEmployees();
}

function deleteEmployee(employeeId) {
    if (confirm('Are you sure you want to delete this employee?')) {
        // In a real app, you would call your API to delete the employee
        employees = employees.filter(emp => emp.id !== employeeId);
        renderEmployees();
        alert('Employee deleted successfully!');
    }
}

// Helper functions
function generateId() {
    return 'emp-' + Math.random().toString(36).substr(2, 9);
}

function generateSampleEmployees(count) {
    const positions = ['Admin', 'Staff', 'Manager', 'Supervisor', 'Officer'];
    const departments = ['HR', 'IT', 'Finance', 'Operations', 'Marketing'];
    const firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Lisa', 'James', 'Maria'];
    const lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
    
    const sampleEmployees = [];
    
    for (let i = 1; i <= count; i++) {
        const firstName = firstNames[Math.floor(Math.random() * firstNames.length)];
        const lastName = lastNames[Math.floor(Math.random() * lastNames.length)];
        
        sampleEmployees.push({
            id: 'emp' + i,
            name: `${firstName} ${lastName}`,
            email: `${firstName.toLowerCase()}.${lastName.toLowerCase()}@example.com`,
            position: positions[Math.floor(Math.random() * positions.length)],
            department: departments[Math.floor(Math.random() * departments.length)]
        });
    }
    
    return sampleEmployees;
}
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
        // Sample employee data (for demo purposes)
        let employees = [];
        let currentPage = 1;
        const itemsPerPage = 10;

        // DOM Elements
        const employeeTableBody = document.getElementById('employeeTableBody');
        const searchInput = document.getElementById('searchEmployee');
        const prevPageBtn = document.getElementById('prevPage');
        const nextPageBtn = document.getElementById('nextPage');
        const currentPageSpan = document.getElementById('currentPage');
        const showingCountSpan = document.getElementById('showingCount');
        const totalCountSpan = document.getElementById('totalCount');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Load employees (in a real app, this would be an API call)
            loadEmployees();
            
            // Add event listeners
            if (searchInput) {
                searchInput.addEventListener('input', filterEmployees);
            }
            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', goToPrevPage);
            }
            if (nextPageBtn) {
                nextPageBtn.addEventListener('click', goToNextPage);
            }
        });

        // Load employees (simulated)
        function loadEmployees() {
            // In a real app, you would fetch this from your API
            // For now, we'll use sample data
            employees = [];
            renderEmployees();
        }

        // Render employees in the table
        function renderEmployees() {
            const filteredEmployees = filterEmployees();
            const start = (currentPage - 1) * itemsPerPage;
            const paginatedEmployees = filteredEmployees.slice(start, start + itemsPerPage);
            
            // Update table
            if (paginatedEmployees.length > 0) {
                let html = '';
                paginatedEmployees.forEach(emp => {
                    html += `
                        <tr>
                            <td>${emp.name}</td>
                            <td>${emp.position}</td>
                            <td>${emp.department}</td>
                            <td>${emp.email}</td>
                            <td style="text-align: right;">
                                <button onclick="editEmployee('${emp.id}')" class="btn-icon" title="Edit">
                                    <i class="fas fa-edit" style="color: #4e73df;"></i>
                                </button>
                                <button onclick="deleteEmployee('${emp.id}')" class="btn-icon" title="Delete">
                                    <i class="fas fa-trash-alt" style="color: #e74a3b;"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                if (employeeTableBody) {
                    employeeTableBody.innerHTML = html;
                }
            } else {
                if (employeeTableBody) {
                    employeeTableBody.innerHTML = `
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d;">
                                No employees found. Click "Add Employee" to get started.
                            </td>
                        </tr>
                    `;
                }
            }
            
            // Update pagination
            updatePagination(filteredEmployees.length);
            
            // Update counts
            if (showingCountSpan && totalCountSpan) {
                showingCountSpan.textContent = paginatedEmployees.length;
                totalCountSpan.textContent = filteredEmployees.length;
            }
        }

        // Filter employees based on search input
        function filterEmployees() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            const filtered = employees.filter(emp => 
                emp.name.toLowerCase().includes(searchTerm) ||
                emp.email.toLowerCase().includes(searchTerm) ||
                emp.position.toLowerCase().includes(searchTerm) ||
                emp.department.toLowerCase().includes(searchTerm)
            );
            
            // Reset to first page when filtering
            currentPage = 1;
            if (currentPageSpan) {
                currentPageSpan.textContent = currentPage;
            }
            
            renderEmployees();
            return filtered;
        }

        // Pagination functions
        function goToPrevPage() {
            if (currentPage > 1) {
                currentPage--;
                if (currentPageSpan) {
                    currentPageSpan.textContent = currentPage;
                }
                renderEmployees();
            }
        }

        function goToNextPage() {
            const totalPages = Math.ceil(employees.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                if (currentPageSpan) {
                    currentPageSpan.textContent = currentPage;
                }
                renderEmployees();
            }
        }

        function updatePagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            
            if (prevPageBtn) {
                prevPageBtn.disabled = currentPage === 1;
            }
            if (nextPageBtn) {
                nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
            }
        }

        // Employee CRUD operations
        function openAddEmployeeModal() {
            document.getElementById('modalTitle').textContent = 'Add New Employee';
            document.getElementById('employeeForm').reset();
            document.getElementById('employeeId').value = '';
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
            // In a real app, you would fetch the employee data from your API
            const employee = employees.find(emp => emp.id === employeeId);
            
            if (employee) {
                document.getElementById('modalTitle').textContent = 'Edit Employee';
                document.getElementById('employeeId').value = employee.id;
                document.getElementById('fullName').value = employee.name;
                document.getElementById('email').value = employee.email;
                document.getElementById('position').value = employee.position;
                document.getElementById('department').value = employee.department;
                
                document.getElementById('employeeModalOverlay').style.display = 'block';
                document.getElementById('employeeModal').style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        }

        function saveEmployee(event) {
            event.preventDefault();
            
            const employeeData = {
                id: document.getElementById('employeeId').value || generateId(),
                name: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                position: document.getElementById('position').value,
                department: document.getElementById('department').value
            };
            
            // In a real app, you would send this to your API
            const existingIndex = employees.findIndex(emp => emp.id === employeeData.id);
            
            if (existingIndex >= 0) {
                // Update existing employee
                employees[existingIndex] = employeeData;
            } else {
                // Add new employee
                employees.push(employeeData);
            }
            
            // Show success message
            alert('Employee saved successfully!');
            
            // Close modal and refresh the list
            closeEmployeeModal();
            renderEmployees();
        }

        function deleteEmployee(employeeId) {
            if (confirm('Are you sure you want to delete this employee?')) {
                // In a real app, you would call your API to delete the employee
                employees = employees.filter(emp => emp.id !== employeeId);
                renderEmployees();
                alert('Employee deleted successfully!');
            }
        }

        // Helper functions
        function generateId() {
            return 'emp-' + Math.random().toString(36).substr(2, 9);
        }

        function generateSampleEmployees(count) {
            const positions = ['Admin', 'Staff', 'Manager', 'Supervisor', 'Officer'];
            const departments = ['HR', 'IT', 'Finance', 'Operations', 'Marketing'];
            const firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Lisa', 'James', 'Maria'];
            const lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
            
            const sampleEmployees = [];
            
            for (let i = 1; i <= count; i++) {
                const firstName = firstNames[Math.floor(Math.random() * firstNames.length)];
                const lastName = lastNames[Math.floor(Math.random() * lastNames.length)];
                
                sampleEmployees.push({
                    id: 'emp' + i,
                    name: `${firstName} ${lastName}`,
                    email: `${firstName.toLowerCase()}.${lastName.toLowerCase()}@example.com`,
                    position: positions[Math.floor(Math.random() * positions.length)],
                    department: departments[Math.floor(Math.random() * departments.length)]
                });
            }
            
            return sampleEmployees;
        }
    </script>
</body>
</html>
