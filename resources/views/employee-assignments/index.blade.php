<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Employee Assignments - B-DEAMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: #f1f1f1; }
::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: #555; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: #f5f5f5; min-height: 100vh; margin: 0; }


/* Main Content */
.main-content { 
    padding: 35px; 
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
}

/* Header */
.header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 40px;
    padding: 30px 35px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.header h1 { 
    color: #1e293b; 
    font-size: 36px; 
    font-weight: 800;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.5px;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

/* Panel */
.panel { 
    background: white; 
    border-radius: 14px; 
    padding: 25px; 
    box-shadow: 0 10px 24px rgba(0,0,0,0.06); 
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th,
.table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tr:hover {
    background: #f8f9fa;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-completed {
    background: #e5e7eb;
    color: #374151;
}

.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

/* Employee Row Styles */
.employee-row {
    margin-bottom: 8px;
}

.employee-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.employee-header:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border-color: #3b82f6;
    transform: translateX(4px);
}

.employee-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.employee-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 16px;
}

.employee-details h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
}

.employee-details p {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
    margin-top: 2px;
}

.assignment-count {
    background: #eff6ff;
    color: #1d4ed8;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.chevron {
    color: #6b7280;
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
    border-radius: 6px;
    text-decoration: none;
    color: #374151;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination a:hover {
    background: #3b82f6;
    color: white;
}

.pagination .current {
    background: #3b82f6;
    color: white;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 16px;
    padding: 0;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease;
    /* Hide scrollbar for Chrome, Safari and Opera */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.modal-content::-webkit-scrollbar {
    display: none; /* Chrome, Safari and Opera */
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    padding: 24px 30px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 16px 16px 0 0;
}

.modal-header h2 {
    margin: 0;
    color: #1e293b;
    font-size: 20px;
    font-weight: 700;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    color: #6b7280;
    cursor: pointer;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #f3f4f6;
    color: #374151;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    padding: 20px 30px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: #f8fafc;
    border-radius: 0 0 16px 16px;
}

/* Form Styles for Modal */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

</style>
</head>
<body>


<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <div style="display: flex; align-items: center; gap: 20px;">
      <a href="{{ route('resident.index') }}" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: white; color: black; text-decoration: none; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
        <i class="fas fa-arrow-left" style="font-size: 16px;"></i>
      </a>
      <h1 style="margin: 0;">Employee Assignments</h1>
    </div>
    <button type="button" class="btn btn-primary" onclick="openCreateModal()">
      <i class="fas fa-plus"></i>
      New Assignment
    </button>
  </div>

  <div class="panel">
    @if(session('success'))
      <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981;">
        {{ session('success') }}
      </div>
    @endif

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
      <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
        <i class="fas fa-user-check" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
        <h3 style="margin-bottom: 8px; color: #374151;">No Employee Assignments</h3>
        <p>Get started by creating your first employee assignment.</p>
        <button type="button" class="btn btn-primary" onclick="openCreateModal()">
          <i class="fas fa-plus"></i>
          Create Assignment
        </button>
      </div>
    @endif
  </div>

  </div>

  <!-- Create Assignment Modal -->
  <div id="createAssignmentModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Assign Employee to Evacuation Center</h2>
        <button type="button" class="modal-close" onclick="closeCreateModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        @if($errors->any())
          <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
            <ul style="margin: 0; padding-left: 20px;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="createAssignmentForm" method="POST" action="{{ route('employee-assignments.store') }}">
          @csrf
          
          <div class="form-group">
            <label for="employee_id">Select Employee *</label>
            <select id="employee_id" name="employee_id" class="form-control" required>
              <option value="">Choose an employee...</option>
              @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->position }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="evacuation_center">Evacuation Center *</label>
            <select id="evacuation_center" name="evacuation_center" class="form-control" required>
              <option value="">Select evacuation center...</option>
              @foreach($evacuationCenters as $center)
                <option value="{{ $center }}">{{ $center }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="responsibilities">Responsibilities</label>
            <textarea id="responsibilities" name="responsibilities" rows="4" class="form-control" placeholder="e.g., Organize residents, manage supplies, maintain order..."></textarea>
          </div>

          <div class="form-group">
            <label for="notes">Additional Notes</label>
            <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="Any additional instructions or notes..."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">
          <i class="fas fa-times"></i>
          Cancel
        </button>
        <button type="submit" form="createAssignmentForm" class="btn btn-primary">
          <i class="fas fa-save"></i>
          Create Assignment
        </button>
      </div>
    </div>
  </div>

</body>
</html>

<script>
// Modal functionality
function openCreateModal() {
    document.getElementById('createAssignmentModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createAssignmentModal').classList.remove('show');
    document.body.style.overflow = 'auto';
    
    // Reset form
    document.getElementById('createAssignmentForm').reset();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('createAssignmentModal');
    if (event.target == modal) {
        closeCreateModal();
    }
}

// Handle form submission with AJAX (optional - for better UX)
document.getElementById('createAssignmentForm').addEventListener('submit', function(e) {
    // You can add AJAX submission here if you want to avoid page reload
    // For now, let it submit normally
});
</script>
