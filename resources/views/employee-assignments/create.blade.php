<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Create Employee Assignment - B-DEAMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: #f5f5f5; min-height: 100vh; margin: 0; display: flex; }

/* Sidebar */
.sidebar { 
    width: 280px; 
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); 
    min-height: 100vh; 
    max-height: 100vh;
    overflow-y: auto;
    padding: 0; 
    position: fixed; 
    left: 0; 
    top: 0; 
    display: flex; 
    flex-direction: column;
    box-shadow: 6px 0 30px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    border-right: 1px solid rgba(255, 255, 255, 0.1);
}

.logo { 
    color: #fff; 
    font-size: 28px; 
    font-weight: 800; 
    padding: 30px; 
    margin-bottom: 10px; 
    display: flex; 
    align-items: center; 
    gap: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.03);
}

.logo i { 
    color: #3b82f6; 
    font-size: 32px;
    filter: drop-shadow(0 4px 8px rgba(59, 130, 246, 0.4));
}

.nav-section {
    margin-bottom: 25px;
    padding: 0 20px;
}

.nav-section-title {
    color: rgba(255, 255, 255, 0.4);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    padding: 0 15px;
    margin-bottom: 12px;
}

.nav-menu { 
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item { 
    color: rgba(255, 255, 255, 0.8); 
    padding: 14px 20px; 
    text-decoration: none; 
    display: flex; 
    align-items: center; 
    gap: 15px; 
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
    cursor: pointer; 
    font-size: 15px;
    font-weight: 500;
    position: relative;
    margin: 3px 0;
    border-radius: 12px;
}

.nav-item:hover { 
    background: rgba(59, 130, 246, 0.15); 
    color: #fff;
    transform: translateX(8px);
}

.nav-item.active { 
    color: #fff; 
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); 
    font-weight: 600;
    transform: translateX(5px);
}

/* Main Content */
.main-content { 
    margin-left: 280px; 
    flex: 1; 
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
    .sidebar { width: 70px; }
    .logo span, .nav-item span { display: none; }
    .main-content { margin-left: 70px; padding: 20px; }
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo">
    <i class="fas fa-shield-alt"></i> 
    <span>B-DEAMS</span>
  </div>
  
  <!-- Main Navigation -->
  <div class="nav-section">
    <div class="nav-section-title">Main</div>
    <nav class="nav-menu">
      <a href="{{ route('resident.index') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('program.index') }}" class="nav-item">
        <i class="fas fa-tasks"></i>
        <span>Programs</span>
      </a>
    </nav>
  </div>

  <!-- Services Section -->
  <div class="nav-section">
    <div class="nav-section-title">Services</div>
    <nav class="nav-menu">
      <a href="{{ route('services') }}" class="nav-item">
        <i class="fas fa-concierge-bell"></i>
        <span>Services</span>
      </a>
      <a href="{{ route('tryall') }}" class="nav-item">
        <i class="fas fa-sms"></i>
        <span>SMS Alert</span>
      </a>
      <a href="{{ route('facilities') }}" class="nav-item">
        <i class="fas fa-building"></i>
        <span>Facilities</span>
      </a>
    </nav>
  </div>

  <!-- System Section -->
  <div class="sidebar-footer">
    <div class="nav-section">
      <div class="nav-section-title">System</div>
      <nav class="nav-menu">
        <a href="{{ route('activity-logs.index') }}" class="nav-item">
          <i class="fas fa-cog"></i>
          <span>Activity Log</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="button" class="nav-item" style="background:none;border:none;width:100%;text-align:left;" onclick="confirmLogout(this)">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
          </button>
        </form>
      </nav>
    </div>
  </div>
</div>

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
