<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Create Employee Assignment - B-DEAMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; margin: 0; }

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
}

.header h1 { 
    color: #1e293b; 
    font-size: 36px; 
    font-weight: 800;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 30px;
    color: #6b7280;
    font-size: 14px;
}

.breadcrumb a {
    color: #3b82f6;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

/* Panel */
.panel { 
    background: white; 
    border-radius: 14px; 
    padding: 30px; 
    box-shadow: 0 10px 24px rgba(0,0,0,0.06);
}

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

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
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

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .main-content { padding: 20px; }
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>

<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <h1>Create Employee Assignment</h1>
  </div>

  <div class="breadcrumb">
    <a href="{{ route('resident.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
    <a href="{{ route('employee-assignments.index') }}">Employee Assignments</a>
    <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
    <span>Create Assignment</span>
  </div>

  <div class="panel">
    @if($errors->any())
      <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
        <ul style="margin: 0; padding-left: 20px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('employee-assignments.store') }}">
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
        <label for="shift">Shift *</label>
        <select id="shift" name="shift" class="form-control" required>
          @foreach($shifts as $shift)
            <option value="{{ $shift }}">{{ ucfirst($shift) }} ({{ $shift == 'morning' ? '6AM - 2PM' : ($shift == 'afternoon' ? '2PM - 10PM' : '10PM - 6AM') }})</option>
          @endforeach
        </select>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="assignment_date">Assignment Date *</label>
          <input type="date" id="assignment_date" name="assignment_date" class="form-control" required min="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="start_time">Start Time *</label>
          <input type="time" id="start_time" name="start_time" class="form-control" required>
        </div>
      </div>

      <div class="form-group">
        <label for="end_time">End Time *</label>
        <input type="time" id="end_time" name="end_time" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="responsibilities">Responsibilities</label>
        <textarea id="responsibilities" name="responsibilities" rows="4" class="form-control" placeholder="e.g., Organize residents, manage supplies, maintain order..."></textarea>
      </div>

      <div class="form-group">
        <label for="notes">Additional Notes</label>
        <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="Any additional instructions or notes..."></textarea>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i>
          Create Assignment
        </button>
        <a href="{{ route('employee-assignments.index') }}" class="btn btn-secondary">
          <i class="fas fa-times"></i>
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>

<script>
function confirmLogout(button) {
  if (confirm('Are you sure you want to logout?')) {
    button.closest('form').submit();
  }
}

// Set default values based on shift
document.getElementById('shift').addEventListener('change', function() {
  const shift = this.value;
  const startTimeInput = document.getElementById('start_time');
  const endTimeInput = document.getElementById('end_time');
  
  switch(shift) {
    case 'morning':
      startTimeInput.value = '06:00';
      endTimeInput.value = '14:00';
      break;
    case 'afternoon':
      startTimeInput.value = '14:00';
      endTimeInput.value = '22:00';
      break;
    case 'night':
      startTimeInput.value = '22:00';
      endTimeInput.value = '06:00';
      break;
  }
});

// Set today's date as default
document.getElementById('assignment_date').value = new Date().toISOString().split('T')[0];
</script>
</body>
</html>
