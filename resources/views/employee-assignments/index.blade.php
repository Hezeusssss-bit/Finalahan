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
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from { filter: drop-shadow(0 4px 8px rgba(59, 130, 246, 0.4)); }
    to { filter: drop-shadow(0 4px 12px rgba(59, 130, 246, 0.6)); }
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
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-section-title::before {
    content: '';
    width: 3px;
    height: 3px;
    background: #3b82f6;
    border-radius: 50%;
    display: inline-block;
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
    overflow: hidden;
}

.nav-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
    transition: left 0.6s;
}

.nav-item:hover::before {
    left: 100%;
}

.nav-item i { 
    width: 24px; 
    text-align: center; 
    font-size: 18px;
    color: rgba(255, 255, 255, 0.6);
    transition: all 0.4s ease;
}

.nav-item:hover { 
    background: rgba(59, 130, 246, 0.15); 
    color: #fff;
    transform: translateX(8px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
}

.nav-item:hover i {
    color: #60a5fa;
    transform: scale(1.15) rotate(5deg);
}

.nav-item.active { 
    color: #fff; 
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); 
    box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
    font-weight: 600;
    transform: translateX(5px);
}

.nav-item.active i {
    color: #fff;
    transform: scale(1.1);
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

/* Responsive */
@media (max-width: 768px) {
    .sidebar { width: 70px; }
    .logo span, .nav-item span { display: none; }
    .main-content { margin-left: 70px; padding: 20px; }
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
    <h1>Employee Assignments</h1>
    <a href="{{ route('employee-assignments.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i>
      New Assignment
    </a>
  </div>

  <div class="panel">
    @if(session('success'))
      <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981;">
        {{ session('success') }}
      </div>
    @endif

    @if($assignments->count() > 0)
      <table class="table">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Evacuation Center</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($assignments as $assignment)
            <tr>
              <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                  <div style="width: 32px; height: 32px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="color: #6b7280;"></i>
                  </div>
                  <div>
                    <div style="font-weight: 600; color: #374151;">{{ $assignment->employee->name }}</div>
                    <div style="font-size: 12px; color: #6b7280;">{{ $assignment->employee->position }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $assignment->evacuation_center }}</td>
              <td>
                <span class="status-badge status-{{ $assignment->status }}">
                  {{ $assignment->getStatusLabel() }}
                </span>
              </td>
              <td>
                <div style="display: flex; gap: 8px;">
                  <a href="{{ route('employee-assignments.edit', $assignment) }}" style="color: #3b82f6; text-decoration: none;">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form method="POST" action="{{ route('employee-assignments.destroy', $assignment) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer;">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="pagination">
        {{ $assignments->links() }}
      </div>
    @else
      <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
        <i class="fas fa-user-check" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
        <h3 style="margin-bottom: 8px; color: #374151;">No Employee Assignments</h3>
        <p>Get started by creating your first employee assignment.</p>
        <a href="{{ route('employee-assignments.create') }}" class="btn btn-primary" style="margin-top: 16px;">
          <i class="fas fa-plus"></i>
          Create Assignment
        </a>
      </div>
    @endif
  </div>
</div>

<script>
function confirmLogout(button) {
  if (confirm('Are you sure you want to logout?')) {
    button.closest('form').submit();
  }
}
</script>
</body>
</html>
