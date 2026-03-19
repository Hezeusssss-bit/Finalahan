<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>BARANGAY DISASTER EVACUATION ALERT MANAGEMENT SYSTEM</title>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<!-- jsPDF for PDF generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- jsPDF AutoTable plugin for tables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<!-- SheetJS for Excel and CSV generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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

.nav-item.active::before {
    display: none;
}

.nav-item.active i {
    color: #fff;
    transform: scale(1.1);
}

.sidebar-footer { 
    margin-top: auto; 
    padding: 25px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.3);
}

.sidebar-footer .nav-item {
    margin: 3px 0;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
}

.sidebar-footer .nav-item:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(5px);
    box-shadow: none;
}

.sidebar-footer .nav-item.active {
    background: rgba(255, 255, 255, 0.1);
    box-shadow: none;
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

.header-icons { 
    display: flex; 
    gap: 20px; 
    align-items: center; 
}

.icon-btn { 
    width: 50px; 
    height: 50px; 
    border-radius: 15px; 
    background: white; 
    border: 1px solid #e2e8f0; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    cursor: pointer; 
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
    text-decoration: none;
}

.icon-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: all 0.4s ease;
}

.icon-btn:hover::before {
    width: 100%;
    height: 100%;
}

.icon-btn:hover { 
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 40px rgba(59, 130, 246, 0.3);
    border-color: transparent;
}

.icon-btn:hover i {
    color: white;
    transform: scale(1.1);
    position: relative;
    z-index: 1;
}

.icon-btn i { 
    color: #64748b; 
    font-size: 20px;
    transition: all 0.4s ease;
    position: relative;
    z-index: 1;
}

/* Dashboard Cards */
.cards { display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
.card { flex: 1 1 260px; background: #fff; border-radius: 14px; padding: 18px; box-shadow: 0 10px 24px rgba(0,0,0,0.06); min-height: 96px; display: flex; flex-direction: column; justify-content: space-between; }
.card.primary { background: #1a1126; color: #fff; box-shadow: 0 10px 24px rgba(26,17,38,0.35); }
.card .title { font-weight: 700; font-size: 14px; color: #232323; }
.card.primary .title { color: #fff; }
.card .cta { align-self: flex-end; font-size: 12px; font-weight: 600; color: #666; text-decoration: none; cursor: pointer; }
.card.primary .cta { color: #fff; }

/* Panels */
.panel-row { display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
.panel { background: #fff; border-radius: 14px; padding: 18px; box-shadow: 0 10px 24px rgba(0,0,0,0.06); min-height: 220px; flex: 1 1 520px; }
.panel.small { flex: 1 1 280px; min-height: 220px; }
.panel.full { min-height: 140px; }

/* Hide scrollbar for Recent Activities */
.recent-activities-container::-webkit-scrollbar {
    display: none;
}

.recent-activities-container {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

/* Floating Alert */
.alert { position: fixed; top: 20px; right: 20px; background-color: #17002B; color: #ffffff; padding: 15px 25px; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px #17002B; z-index: 9999; opacity: 0; animation: slideIn 0.5s forwards; }
.alert.success { background-color: #17002B; color: #fff; }
@keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }
.alert.hide { animation: slideOut 0.5s forwards; }

/* Logout Modal */
.modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: none;
  z-index: 1000;
}
.modal {
  position: fixed;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
  border-radius: 12px;
  padding: 30px;
  width: 400px;
  max-width: 90%;
  display: none;
  z-index: 1001;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  text-align: center;
}
.modal h2 {
  margin-bottom: 10px;
  font-size: 22px;
  color: #1a1a2e;
}
.modal p {
  margin-bottom: 25px;
  color: #555;
  font-size: 15px;
}
.modal-buttons {
  display: flex;
  justify-content: center;
  gap: 15px;
}
.modal-buttons button {
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 14px;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
}
.btn-cancel {
  background: #f5f5f5;
  color: #333;
}
.btn-cancel:hover {
  background: #e5e5e5;
}
.btn-logout-confirm {
  background: #f44336;
  color: #fff;
}
.btn-logout-confirm:hover {
  background: #d32f2f;
  transform: translateY(-2px);
}

/* Quick Actions Hover Effects */
.quick-action {
  transition: all 0.3s ease;
}
.quick-action:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  border-color: #1a1a2e !important;
}

/* Analytics Cards Hover */
.analytics-card {
  transition: all 0.3s ease;
}
.analytics-card:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Activity Item Hover */
.activity-item {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  padding: 12px 16px;
  margin: 4px 0;
  border-radius: 8px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  background: #ffffff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  border-left: 4px solid transparent;
}

.activity-item:hover {
  background: #f0f4ff;
  transform: translateX(4px);
  box-shadow: 0 4px 12px rgba(74, 106, 247, 0.1);
  border-left-color: #4a6cf7;
}
  border-radius: 6px;
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar { width: 70px; }
  .logo span, .nav-item span { display: none; }
  .main-content { margin-left: 70px; padding: 20px; }
  
  /* Dropdown styles */
  .dropdown {
    position: relative;
  }
  
  .dropdown-menu {
    display: none;
    position: absolute;
    left: 0;
    top: 100%;
    background: #fff;
    min-width: 220px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    border-radius: 10px;
    z-index: 1000;
    padding: 8px 0;
    margin-top: 8px;
    border: 1px solid #e5e5e5;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
    overflow: hidden;
  }
  
  .dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
    animation: fadeInUp 0.25s ease-out;
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .dropdown-item {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    color: #4a5568;
    text-decoration: none;
    transition: all 0.25s ease;
    font-size: 14px;
    position: relative;
    border-left: 3px solid transparent;
  }
  
  .dropdown-item:hover {
    background: linear-gradient(90deg, rgba(74, 85, 104, 0.05), transparent);
    color: #1a1a2e;
    padding-left: 25px;
    border-left-color: #4a6cf7;
  }
  
  .dropdown-item i {
    width: 22px;
    margin-right: 12px;
    color: #718096;
    text-align: center;
    font-size: 16px;
    transition: all 0.25s ease;
  }
  
  .dropdown-item:hover i {
    color: #4a6cf7;
    transform: scale(1.1);
  }
  
  .dropdown-toggle {
    cursor: pointer;
    position: relative;
    transition: all 0.25s ease;
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
      <a href="{{ route('resident.index') }}" class="nav-item active">
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
    <h1>Dashboard</h1>
  </div>
  @if(session('Success'))
    <div class="alert success" id="successAlert">{{ session('Success') }}</div>
  @endif


  <!-- Dashboard Cards beside the sidebar -->
  <div class="cards" style="margin-top: 16px;">
    <div class="card primary">
      <div class="title">Total Residents</div>
      <a href="{{ route('home') }}" class="cta">View all</a>
    </div>
    <div class="card">
      <div class="title">Total Evacuee</div>
      <a href="{{ route('program.evacuee') }}" class="cta">View all</a>
    </div>
    <div class="card">
      <div class="title">SMS Alert</div>
      <a href="{{ route('tryall') }}" class="cta">View all</a>
    </div>
  </div>

  <div class="panel-row">
    <div class="panel">
      <div style="font-weight:700;color:#333;margin-bottom:15px;font-size:16px;">📊 Analytics & Insights</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:15px;">
        <div class="analytics-card" style="background:#f8f9fa;padding:12px;border-radius:8px;text-align:center;">
          <div style="font-size:24px;font-weight:700;color:#1a1a2e;">{{ $totalResidents ?? 0 }}</div>
          <div style="font-size:12px;color:#666;">Total Residents</div>
        </div>
        <div class="analytics-card" style="background:#f8f9fa;padding:12px;border-radius:8px;text-align:center;">
          <div style="font-size:24px;font-weight:700;color:#28a745;">{{ $newThisMonth ?? 0 }}</div>
          <div style="font-size:12px;color:#666;">New This Month</div>
        </div>
      </div>
      @php
        $totalResidents = $totalResidents ?? 0;
        $newThisMonth = $newThisMonth ?? 0;
        $growthRate = $totalResidents > 0 ? round(($newThisMonth / $totalResidents) * 100, 1) : 0;
        $trend = $growthRate > 10 ? 'high' : ($growthRate > 5 ? 'moderate' : 'low');
      @endphp
      <div style="background:#e3f2fd;padding:10px;border-radius:6px;border-left:4px solid #2196f3;">
        <div style="font-size:13px;color:#1976d2;font-weight:600;">📈 Growth Rate</div>
        <div style="font-size:18px;font-weight:700;color:#1976d2;">+{{ $growthRate }}%</div>
      </div>
    </div>
    <div class="panel small">
      <div style="font-weight:700;color:#333;margin-bottom:15px;font-size:16px;">🕒 Recent Activities</div>
      <div class="recent-activities-container" style="max-height:200px;overflow-y:auto;">
        @forelse($recentActivities as $activity)
        <div class="activity-item" style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;">
          <div style="width:8px;height:8px;background:{{ $activity['color'] }};border-radius:50%;"></div>
          <div style="flex:1;">
            <div style="font-size:13px;color:#333;">{{ $activity['description'] }}</div>
            <div style="font-size:11px;color:#666;">{{ $activity['time_ago'] }}</div>
          </div>
        </div>
        @empty
        <div style="text-align:center;color:#666;padding:20px;font-size:13px;">
          No recent activities
        </div>
        @endforelse
      </div>
    </div>
  </div>

  
  <div class="panel full">
    <div style="font-weight:700;color:#333;margin-bottom:15px;font-size:16px;">📋 Quick Actions</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;">
      <a href="#" onclick="openReportModal()" class="quick-action" style="background:#f8f9fa;padding:15px;border-radius:8px;text-decoration:none;color:#333;border:1px solid #e9ecef;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-chart-bar" style="color:#17a2b8;font-size:18px;"></i>
        <div>
          <div style="font-weight:600;font-size:14px;">Generate Report</div>
          <div style="font-size:12px;color:#666;">Export resident data</div>
        </div>
      </a>
      <a href="{{ route('employee.employee') }}" class="quick-action" style="background:#f8f9fa;padding:15px;border-radius:8px;text-decoration:none;color:#333;border:1px solid #e9ecef;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-users" style="color:#6c757d;font-size:18px;"></i>
        <div>
          <div style="font-weight:600;font-size:14px;">Employee Management</div>
          <div style="font-size:12px;color:#666;">Manage employees and access</div>
        </div>
      </a>
      <a href="{{ route('employee-assignments.index') }}" class="quick-action" style="background:#f8f9fa;padding:15px;border-radius:8px;text-decoration:none;color:#333;border:1px solid #e9ecef;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-list-alt" style="color:#6f42c1;font-size:18px;"></i>
        <div>
          <div style="font-weight:600;font-size:14px;">Employee Assignments</div>
          <div style="font-size:12px;color:#666;">View all employee assignments</div>
        </div>
      </a>
    </div>
  </div>
</div>

<!-- Report Generation Modal -->
<div class="modal-overlay" id="reportModalOverlay"></div>
<div class="modal" id="reportModal" style="width: 500px;">
  <h2>📊 Generate Report</h2>
  <p>Select the type of report you want to generate:</p>
  
  <div style="text-align: left; margin: 20px 0;">
    <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333;">Report Type:</label>
    <select id="reportType" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
      <option value="">Select a report type...</option>
      <option value="residents">👥 All Residents Report</option>
      <option value="evacuees">🚨 Evacuees Report</option>
      <option value="programs">📋 Programs Report</option>
      <option value="facilities">🏢 Facilities Report</option>
      <option value="activities">📝 Activity Logs Report</option>
      <option value="summary">📈 Dashboard Summary Report</option>
    </select>
  </div>
  
  <div style="text-align: left; margin: 20px 0;">
    <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333;">Format:</label>
    <div style="display: flex; gap: 15px;">
      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
        <input type="radio" name="format" value="pdf" checked>
        <span>📄 PDF</span>
      </label>
      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
        <input type="radio" name="format" value="csv">
        <span>📋 CSV</span>
      </label>
      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
        <input type="radio" name="format" value="print">
        <span>🖨️ Print</span>
      </label>
    </div>
  </div>
  
  <div class="modal-buttons">
    <button class="btn-cancel" onclick="closeReportModal()">Cancel</button>
    <button class="btn-logout-confirm" onclick="generateReport()" style="background: #28a745;">Generate Report</button>
  </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal-overlay" id="logoutModalOverlay"></div>
<div class="modal" id="logoutModal">
  <h2>Log Out</h2>
  <p>Are you sure you want to log out?</p>
  <div class="modal-buttons">
    <button class="btn-cancel" onclick="closeLogoutModal()">Cancel</button>
    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn-logout-confirm">Yes, Log Out</button>
    </form>
  </div>
</div>

<!-- Employee Assignment Modal -->
<div class="modal-overlay" id="assignmentModalOverlay"></div>
<div class="modal" id="assignmentModal" style="width: 600px; max-height: 80vh; overflow-y: auto;">
  <h2>👥 Assign Employee to Evacuation Center</h2>
  <p>Assign an employee to manage and organize residents at a specific evacuation center.</p>
  
  <form id="assignmentForm" onsubmit="submitAssignment(event)">
    @csrf
    <div style="text-align: left; margin: 20px 0;">
      <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Select Employee:</label>
      <select id="employee_id" name="employee_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
        <option value="">Choose an employee...</option>
        @foreach(App\Models\Employee::where('status', 'active')->get() as $employee)
        <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->position }}</option>
        @endforeach
      </select>
    </div>
    
    <div style="text-align: left; margin: 20px 0;">
      <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Evacuation Center:</label>
      <select id="evacuation_center" name="evacuation_center" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
        <option value="">Select evacuation center...</option>
        <option value="Barangay Hall Evacuation Center">Barangay Hall Evacuation Center</option>
        <option value="Community Center Evacuation">Community Center Evacuation</option>
        <option value="School Gymnasium">School Gymnasium</option>
        <option value="Sports Complex">Sports Complex</option>
        <option value="Multi-Purpose Hall">Multi-Purpose Hall</option>
      </select>
    </div>
    
    <div style="text-align: left; margin: 20px 0;">
      <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Responsibilities:</label>
      <textarea id="responsibilities" name="responsibilities" rows="3" placeholder="e.g., Organize residents, manage supplies, maintain order..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;"></textarea>
    </div>
    
    <div style="text-align: left; margin: 20px 0;">
      <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Additional Notes:</label>
      <textarea id="notes" name="notes" rows="2" placeholder="Any additional instructions or notes..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;"></textarea>
    </div>
    
    <div class="modal-buttons">
      <button type="button" class="btn-cancel" onclick="closeAssignmentModal()">Cancel</button>
      <button type="submit" class="btn-logout-confirm" style="background: #28a745;">Assign Employee</button>
    </div>
  </form>
</div>

<script>
function closeReportModal() {
  document.getElementById('reportModalOverlay').style.display = 'none';
  document.getElementById('reportModal').style.display = 'none';
}

function openReportModal() {
  document.getElementById('reportModalOverlay').style.display = 'block';
  document.getElementById('reportModal').style.display = 'block';
}

function generateExcelReport(reportType, reportName) {
  // Sample data for demonstration
  const sampleData = {
    residents: [
      { id: 1, name: 'Juan Dela Cruz', age: 35, address: 'Brgy. Masagana', contact: '09123456789' },
      { id: 2, name: 'Maria Santos', age: 28, address: 'Brgy. Poblacion', contact: '09987654321' },
      { id: 3, name: 'Roberto Reyes', age: 42, address: 'Brgy. San Isidro', contact: '09123456788' }
    ],
    evacuees: [
      { id: 1, name: 'Ana Garcia', family: 4, center: 'Evacuation Center A', date: '2024-01-15' },
      { id: 2, name: 'Carlos Mendoza', family: 3, center: 'Evacuation Center B', date: '2024-01-16' }
    ],
    programs: [
      { id: 1, name: 'Disaster Preparedness Training', participants: 45, date: '2024-01-10', status: 'Completed' },
      { id: 2, name: 'Emergency Response Drill', participants: 32, date: '2024-01-20', status: 'Ongoing' }
    ],
    facilities: [
      { id: 1, name: 'Evacuation Center A', capacity: 100, current: 45, status: 'Operational' },
      { id: 2, name: 'Evacuation Center B', capacity: 75, current: 30, status: 'Operational' }
    ],
    activities: [
      { id: 1, action: 'Resident Registration', user: 'Admin', date: '2024-01-15 10:30' },
      { id: 2, action: 'SMS Alert Sent', user: 'Staff', date: '2024-01-15 14:20' }
    ],
    summary: {
      totalResidents: 1250,
      totalEvacuees: 78,
      activePrograms: 5,
      operationalFacilities: 3,
      recentActivities: 23
    }
  };
  
  // Create workbook
  const wb = XLSX.utils.book_new();
  
  // Add summary sheet
  const summaryData = [
    ['Report Name', reportName],
    ['Generated Date', new Date().toLocaleDateString()],
    ['Generated Time', new Date().toLocaleTimeString()],
    ['Report Type', reportType.charAt(0).toUpperCase() + reportType.slice(1)],
    [],
    ['Summary Statistics']
  ];
  
  // Add specific summary data based on report type
  switch(reportType) {
    case 'residents':
      summaryData.push(['Total Residents', sampleData.residents.length]);
      summaryData.push(['Report Period', 'All registered residents']);
      break;
    case 'evacuees':
      const totalEvacuees = sampleData.evacuees.reduce((sum, e) => sum + e.family, 0);
      summaryData.push(['Total Evacuees', totalEvacuees]);
      summaryData.push(['Families Affected', sampleData.evacuees.length]);
      break;
    case 'programs':
      const totalParticipants = sampleData.programs.reduce((sum, p) => sum + p.participants, 0);
      summaryData.push(['Total Programs', sampleData.programs.length]);
      summaryData.push(['Total Participants', totalParticipants]);
      break;
    case 'facilities':
      const totalCapacity = sampleData.facilities.reduce((sum, f) => sum + f.capacity, 0);
      const currentOccupancy = sampleData.facilities.reduce((sum, f) => sum + f.current, 0);
      summaryData.push(['Total Facilities', sampleData.facilities.length]);
      summaryData.push(['Total Capacity', totalCapacity]);
      summaryData.push(['Current Occupancy', currentOccupancy]);
      break;
    case 'activities':
      summaryData.push(['Total Activities', sampleData.activities.length]);
      summaryData.push(['Report Period', 'Recent activities']);
      break;
    case 'summary':
      summaryData.push(['Total Residents', sampleData.summary.totalResidents]);
      summaryData.push(['Total Evacuees', sampleData.summary.totalEvacuees]);
      summaryData.push(['Active Programs', sampleData.summary.activePrograms]);
      summaryData.push(['Operational Facilities', sampleData.summary.operationalFacilities]);
      summaryData.push(['Recent Activities', sampleData.summary.recentActivities]);
      break;
  }
  
  const summaryWS = XLSX.utils.aoa_to_sheet(summaryData);
  XLSX.utils.book_append_sheet(wb, summaryWS, 'Summary');
  
  // Add data sheet based on report type
  if (reportType !== 'summary') {
    let dataWS;
    let sheetName;
    
    switch(reportType) {
      case 'residents':
        const residentData = [
          ['ID', 'Name', 'Age', 'Address', 'Contact']
        ];
        sampleData.residents.forEach(r => {
          residentData.push([r.id, r.name, r.age, r.address, r.contact]);
        });
        dataWS = XLSX.utils.aoa_to_sheet(residentData);
        sheetName = 'Residents';
        break;
        
      case 'evacuees':
        const evacueeData = [
          ['ID', 'Family Head', 'Family Members', 'Evacuation Center', 'Date Registered']
        ];
        sampleData.evacuees.forEach(e => {
          evacueeData.push([e.id, e.name, e.family, e.center, e.date]);
        });
        dataWS = XLSX.utils.aoa_to_sheet(evacueeData);
        sheetName = 'Evacuees';
        break;
        
      case 'programs':
        const programData = [
          ['ID', 'Program Name', 'Participants', 'Date', 'Status']
        ];
        sampleData.programs.forEach(p => {
          programData.push([p.id, p.name, p.participants, p.date, p.status]);
        });
        dataWS = XLSX.utils.aoa_to_sheet(programData);
        sheetName = 'Programs';
        break;
        
      case 'facilities':
        const facilityData = [
          ['ID', 'Facility Name', 'Capacity', 'Current Occupancy', 'Status']
        ];
        sampleData.facilities.forEach(f => {
          facilityData.push([f.id, f.name, f.capacity, f.current, f.status]);
        });
        dataWS = XLSX.utils.aoa_to_sheet(facilityData);
        sheetName = 'Facilities';
        break;
        
      case 'activities':
        const activityData = [
          ['ID', 'Action', 'User', 'Date & Time']
        ];
        sampleData.activities.forEach(a => {
          activityData.push([a.id, a.action, a.user, a.date]);
        });
        dataWS = XLSX.utils.aoa_to_sheet(activityData);
        sheetName = 'Activities';
        break;
    }
    
    if (dataWS) {
      XLSX.utils.book_append_sheet(wb, dataWS, sheetName);
    }
  }
  
  // Save Excel file
  const fileName = `${reportName.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.xlsx`;
  XLSX.writeFile(wb, fileName);
}

function generateCSVReport(reportType, reportName) {
  // Sample data for demonstration
  const sampleData = {
    residents: [
      { id: 1, name: 'Juan Dela Cruz', age: 35, address: 'Brgy. Masagana', contact: '09123456789' },
      { id: 2, name: 'Maria Santos', age: 28, address: 'Brgy. Poblacion', contact: '09987654321' },
      { id: 3, name: 'Roberto Reyes', age: 42, address: 'Brgy. San Isidro', contact: '09123456788' }
    ],
    evacuees: [
      { id: 1, name: 'Ana Garcia', family: 4, center: 'Evacuation Center A', date: '2024-01-15' },
      { id: 2, name: 'Carlos Mendoza', family: 3, center: 'Evacuation Center B', date: '2024-01-16' }
    ],
    programs: [
      { id: 1, name: 'Disaster Preparedness Training', participants: 45, date: '2024-01-10', status: 'Completed' },
      { id: 2, name: 'Emergency Response Drill', participants: 32, date: '2024-01-20', status: 'Ongoing' }
    ],
    facilities: [
      { id: 1, name: 'Evacuation Center A', capacity: 100, current: 45, status: 'Operational' },
      { id: 2, name: 'Evacuation Center B', capacity: 75, current: 30, status: 'Operational' }
    ],
    activities: [
      { id: 1, action: 'Resident Registration', user: 'Admin', date: '2024-01-15 10:30' },
      { id: 2, action: 'SMS Alert Sent', user: 'Staff', date: '2024-01-15 14:20' }
    ],
    summary: {
      totalResidents: 1250,
      totalEvacuees: 78,
      activePrograms: 5,
      operationalFacilities: 3,
      recentActivities: 23
    }
  };
  
  let csvContent = '';
  let fileName = '';
  
  // Add header information
  csvContent += `Report Name,${reportName}\n`;
  csvContent += `Generated Date,${new Date().toLocaleDateString()}\n`;
  csvContent += `Generated Time,${new Date().toLocaleTimeString()}\n`;
  csvContent += `Report Type,${reportType.charAt(0).toUpperCase() + reportType.slice(1)}\n`;
  csvContent += `\n`;
  
  // Add data based on report type
  switch(reportType) {
    case 'residents':
      csvContent += 'ID,Name,Age,Address,Contact\n';
      sampleData.residents.forEach(r => {
        csvContent += `${r.id},"${r.name}",${r.age},"${r.address}","${r.contact}"\n`;
      });
      fileName = 'Residents_Report';
      break;
      
    case 'evacuees':
      csvContent += 'ID,Family Head,Family Members,Evacuation Center,Date Registered\n';
      sampleData.evacuees.forEach(e => {
        csvContent += `${e.id},"${e.name}",${e.family},"${e.center}",${e.date}\n`;
      });
      fileName = 'Evacuees_Report';
      break;
      
    case 'programs':
      csvContent += 'ID,Program Name,Participants,Date,Status\n';
      sampleData.programs.forEach(p => {
        csvContent += `${p.id},"${p.name}",${p.participants},${p.date},"${p.status}"\n`;
      });
      fileName = 'Programs_Report';
      break;
      
    case 'facilities':
      csvContent += 'ID,Facility Name,Capacity,Current Occupancy,Status\n';
      sampleData.facilities.forEach(f => {
        csvContent += `${f.id},"${f.name}",${f.capacity},${f.current},"${f.status}"\n`;
      });
      fileName = 'Facilities_Report';
      break;
      
    case 'activities':
      csvContent += 'ID,Action,User,Date & Time\n';
      sampleData.activities.forEach(a => {
        csvContent += `${a.id},"${a.action}","${a.user}","${a.date}"\n`;
      });
      fileName = 'Activities_Report';
      break;
      
    case 'summary':
      csvContent += 'Metric,Value\n';
      csvContent += `Total Residents,${sampleData.summary.totalResidents}\n`;
      csvContent += `Total Evacuees,${sampleData.summary.totalEvacuees}\n`;
      csvContent += `Active Programs,${sampleData.summary.activePrograms}\n`;
      csvContent += `Operational Facilities,${sampleData.summary.operationalFacilities}\n`;
      csvContent += `Recent Activities,${sampleData.summary.recentActivities}\n`;
      fileName = 'Dashboard_Summary';
      break;
  }
  
  // Create and download CSV file
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const link = document.createElement('a');
  const url = URL.createObjectURL(blob);
  
  link.setAttribute('href', url);
  link.setAttribute('download', `${fileName}_${new Date().toISOString().split('T')[0]}.csv`);
  link.style.visibility = 'hidden';
  
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

function generatePDFReport(reportType, reportName) {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  
  // Sample data for demonstration
  const sampleData = {
    residents: [
      { id: 1, name: 'Juan Dela Cruz', age: 35, address: 'Brgy. Masagana', contact: '09123456789' },
      { id: 2, name: 'Maria Santos', age: 28, address: 'Brgy. Poblacion', contact: '09987654321' },
      { id: 3, name: 'Roberto Reyes', age: 42, address: 'Brgy. San Isidro', contact: '09123456788' }
    ],
    evacuees: [
      { id: 1, name: 'Ana Garcia', family: 4, center: 'Evacuation Center A', date: '2024-01-15' },
      { id: 2, name: 'Carlos Mendoza', family: 3, center: 'Evacuation Center B', date: '2024-01-16' }
    ],
    programs: [
      { id: 1, name: 'Disaster Preparedness Training', participants: 45, date: '2024-01-10', status: 'Completed' },
      { id: 2, name: 'Emergency Response Drill', participants: 32, date: '2024-01-20', status: 'Ongoing' }
    ],
    facilities: [
      { id: 1, name: 'Evacuation Center A', capacity: 100, current: 45, status: 'Operational' },
      { id: 2, name: 'Evacuation Center B', capacity: 75, current: 30, status: 'Operational' }
    ],
    activities: [
      { id: 1, action: 'Resident Registration', user: 'Admin', date: '2024-01-15 10:30' },
      { id: 2, action: 'SMS Alert Sent', user: 'Staff', date: '2024-01-15 14:20' }
    ],
    summary: {
      totalResidents: 1250,
      totalEvacuees: 78,
      activePrograms: 5,
      operationalFacilities: 3,
      recentActivities: 23
    }
  };
  
  // Add header
  doc.setFontSize(20);
  doc.setTextColor(26, 26, 46);
  doc.text(reportName, 105, 20, { align: 'center' });
  
  doc.setFontSize(12);
  doc.setTextColor(100, 100, 100);
  doc.text(`Generated on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}`, 105, 30, { align: 'center' });
  
  let yPosition = 50;
  
  switch(reportType) {
    case 'residents':
      // Summary section
      doc.setFontSize(14);
      doc.setTextColor(0, 0, 0);
      doc.text('Residents Summary', 20, yPosition);
      yPosition += 10;
      
      doc.setFontSize(11);
      doc.setTextColor(60, 60, 60);
      doc.text(`Total Residents: ${sampleData.residents.length}`, 20, yPosition);
      yPosition += 7;
      doc.text('Report Period: All registered residents', 20, yPosition);
      yPosition += 15;
      
      // Table
      doc.setFontSize(12);
      doc.setTextColor(0, 0, 0);
      doc.text('Resident Details', 20, yPosition);
      yPosition += 10;
      
      const residentColumns = ['ID', 'Name', 'Age', 'Address', 'Contact'];
      const residentRows = sampleData.residents.map(r => [r.id.toString(), r.name, r.age.toString(), r.address, r.contact]);
      
      doc.autoTable({
        head: [residentColumns],
        body: residentRows,
        startY: yPosition,
        theme: 'grid',
        styles: { fontSize: 10, cellPadding: 3 },
        headStyles: { fillColor: [26, 26, 46], textColor: 255 },
        alternateRowStyles: { fillColor: [245, 245, 245] }
      });
      break;
      
    case 'evacuees':
      // Summary section
      doc.setFontSize(14);
      doc.setTextColor(0, 0, 0);
      doc.text('Evacuees Summary', 20, yPosition);
      yPosition += 10;
      
      doc.setFontSize(11);
      doc.setTextColor(60, 60, 60);
      const totalEvacuees = sampleData.evacuees.reduce((sum, e) => sum + e.family, 0);
      doc.text(`Total Evacuees: ${totalEvacuees}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Families Affected: ${sampleData.evacuees.length}`, 20, yPosition);
      yPosition += 15;
      
      // Table
      doc.setFontSize(12);
      doc.setTextColor(0, 0, 0);
      doc.text('Evacuee Details', 20, yPosition);
      yPosition += 10;
      
      const evacueeColumns = ['ID', 'Family Head', 'Family Members', 'Evacuation Center', 'Date Registered'];
      const evacueeRows = sampleData.evacuees.map(e => [e.id.toString(), e.name, e.family.toString(), e.center, e.date]);
      
      doc.autoTable({
        head: [evacueeColumns],
        body: evacueeRows,
        startY: yPosition,
        theme: 'grid',
        styles: { fontSize: 10, cellPadding: 3 },
        headStyles: { fillColor: [26, 26, 46], textColor: 255 },
        alternateRowStyles: { fillColor: [245, 245, 245] }
      });
      break;
      
    case 'programs':
      // Summary section
      doc.setFontSize(14);
      doc.setTextColor(0, 0, 0);
      doc.text('Programs Summary', 20, yPosition);
      yPosition += 10;
      
      doc.setFontSize(11);
      doc.setTextColor(60, 60, 60);
      const totalParticipants = sampleData.programs.reduce((sum, p) => sum + p.participants, 0);
      doc.text(`Total Programs: ${sampleData.programs.length}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Total Participants: ${totalParticipants}`, 20, yPosition);
      yPosition += 15;
      
      // Table
      doc.setFontSize(12);
      doc.setTextColor(0, 0, 0);
      doc.text('Program Details', 20, yPosition);
      yPosition += 10;
      
      const programColumns = ['ID', 'Program Name', 'Participants', 'Date', 'Status'];
      const programRows = sampleData.programs.map(p => [p.id.toString(), p.name, p.participants.toString(), p.date, p.status]);
      
      doc.autoTable({
        head: [programColumns],
        body: programRows,
        startY: yPosition,
        theme: 'grid',
        styles: { fontSize: 10, cellPadding: 3 },
        headStyles: { fillColor: [26, 26, 46], textColor: 255 },
        alternateRowStyles: { fillColor: [245, 245, 245] }
      });
      break;
      
    case 'facilities':
      // Summary section
      doc.setFontSize(14);
      doc.setTextColor(0, 0, 0);
      doc.text('Facilities Summary', 20, yPosition);
      yPosition += 10;
      
      doc.setFontSize(11);
      doc.setTextColor(60, 60, 60);
      const totalCapacity = sampleData.facilities.reduce((sum, f) => sum + f.capacity, 0);
      const currentOccupancy = sampleData.facilities.reduce((sum, f) => sum + f.current, 0);
      doc.text(`Total Facilities: ${sampleData.facilities.length}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Total Capacity: ${totalCapacity}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Current Occupancy: ${currentOccupancy}`, 20, yPosition);
      yPosition += 15;
      
      // Table
      doc.setFontSize(12);
      doc.setTextColor(0, 0, 0);
      doc.text('Facility Details', 20, yPosition);
      yPosition += 10;
      
      const facilityColumns = ['ID', 'Facility Name', 'Capacity', 'Current Occupancy', 'Status'];
      const facilityRows = sampleData.facilities.map(f => [f.id.toString(), f.name, f.capacity.toString(), f.current.toString(), f.status]);
      
      doc.autoTable({
        head: [facilityColumns],
        body: facilityRows,
        startY: yPosition,
        theme: 'grid',
        styles: { fontSize: 10, cellPadding: 3 },
        headStyles: { fillColor: [26, 26, 46], textColor: 255 },
        alternateRowStyles: { fillColor: [245, 245, 245] }
      });
      break;
      
    case 'activities':
      // Summary section
      doc.setFontSize(14);
      doc.setTextColor(0, 0, 0);
      doc.text('Activity Logs Summary', 20, yPosition);
      yPosition += 10;
      
      doc.setFontSize(11);
      doc.setTextColor(60, 60, 60);
      doc.text(`Total Activities: ${sampleData.activities.length}`, 20, yPosition);
      yPosition += 7;
      doc.text('Report Period: Recent activities', 20, yPosition);
      yPosition += 15;
      
      // Table
      doc.setFontSize(12);
      doc.setTextColor(0, 0, 0);
      doc.text('Activity Details', 20, yPosition);
      yPosition += 10;
      
      const activityColumns = ['ID', 'Action', 'User', 'Date & Time'];
      const activityRows = sampleData.activities.map(a => [a.id.toString(), a.action, a.user, a.date]);
      
      doc.autoTable({
        head: [activityColumns],
        body: activityRows,
        startY: yPosition,
        theme: 'grid',
        styles: { fontSize: 10, cellPadding: 3 },
        headStyles: { fillColor: [26, 26, 46], textColor: 255 },
        alternateRowStyles: { fillColor: [245, 245, 245] }
      });
      break;
      
    case 'summary':
      // Summary section
      doc.setFontSize(14);
      doc.setTextColor(0, 0, 0);
      doc.text('Dashboard Summary', 20, yPosition);
      yPosition += 15;
      
      doc.setFontSize(11);
      doc.setTextColor(60, 60, 60);
      doc.text(`Total Residents: ${sampleData.summary.totalResidents}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Total Evacuees: ${sampleData.summary.totalEvacuees}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Active Programs: ${sampleData.summary.activePrograms}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Operational Facilities: ${sampleData.summary.operationalFacilities}`, 20, yPosition);
      yPosition += 7;
      doc.text(`Recent Activities: ${sampleData.summary.recentActivities}`, 20, yPosition);
      yPosition += 15;
      
      // System Overview
      doc.setFontSize(12);
      doc.setTextColor(0, 0, 0);
      doc.text('System Overview', 20, yPosition);
      yPosition += 10;
      
      doc.setFontSize(10);
      doc.setTextColor(60, 60, 60);
      const overviewText = 'This report provides a comprehensive overview of the Barangay Disaster Evacuation Alert Management System as of ' + new Date().toLocaleDateString() + '. The system is actively monitoring and managing disaster preparedness activities, resident information, and emergency response operations.';
      
      const splitText = doc.splitTextToSize(overviewText, 170);
      doc.text(splitText, 20, yPosition);
      break;
  }
  
  // Add footer
  const pageHeight = doc.internal.pageSize.height;
  doc.setFontSize(9);
  doc.setTextColor(150, 150, 150);
  doc.text('BARANGAY DISASTER EVACUATION ALERT MANAGEMENT SYSTEM', 105, pageHeight - 10, { align: 'center' });
  
  // Save the PDF
  const fileName = `${reportName.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.pdf`;
  doc.save(fileName);
}

function printReport(reportType, reportName) {
  // Create a new window for printing
  const printWindow = window.open('', '_blank');
  
  // Generate sample report content based on type
  const reportContent = generateReportContent(reportType, reportName);
  
  // Write the HTML content to the new window
  printWindow.document.write(`
    <!DOCTYPE html>
    <html>
    <head>
      <title>${reportName}</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          margin: 20px;
          line-height: 1.6;
        }
        .header {
          text-align: center;
          border-bottom: 2px solid #333;
          padding-bottom: 20px;
          margin-bottom: 30px;
        }
        .header h1 {
          color: #1a1a2e;
          margin: 0;
        }
        .header p {
          color: #666;
          margin: 5px 0 0 0;
        }
        .section {
          margin-bottom: 25px;
        }
        .section h2 {
          color: #333;
          border-bottom: 1px solid #ddd;
          padding-bottom: 5px;
        }
        table {
          width: 100%;
          border-collapse: collapse;
          margin-bottom: 20px;
        }
        th, td {
          border: 1px solid #ddd;
          padding: 8px;
          text-align: left;
        }
        th {
          background-color: #f5f5f5;
          font-weight: bold;
        }
        .summary {
          background-color: #f9f9f9;
          padding: 15px;
          border-radius: 5px;
          margin-bottom: 20px;
        }
        .footer {
          margin-top: 40px;
          padding-top: 20px;
          border-top: 1px solid #ddd;
          text-align: center;
          color: #666;
          font-size: 12px;
        }
        @media print {
          body { margin: 15px; }
          .no-print { display: none; }
        }
      </style>
    </head>
    <body>
      ${reportContent}
      <div class="footer">
        <p>Generated on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}</p>
        <p>BARANGAY DISASTER EVACUATION ALERT MANAGEMENT SYSTEM</p>
      </div>
    </body>
    </html>
  `);
  
  printWindow.document.close();
  
  // Wait for content to load, then trigger print
  setTimeout(() => {
    printWindow.print();
    printWindow.close();
  }, 500);
}

function generateReportContent(reportType, reportName) {
  const currentDate = new Date().toLocaleDateString();
  
  // Sample data for demonstration
  const sampleData = {
    residents: [
      { id: 1, name: 'Juan Dela Cruz', age: 35, address: 'Brgy. Masagana', contact: '09123456789' },
      { id: 2, name: 'Maria Santos', age: 28, address: 'Brgy. Poblacion', contact: '09987654321' },
      { id: 3, name: 'Roberto Reyes', age: 42, address: 'Brgy. San Isidro', contact: '09123456788' }
    ],
    evacuees: [
      { id: 1, name: 'Ana Garcia', family: 4, center: 'Evacuation Center A', date: '2024-01-15' },
      { id: 2, name: 'Carlos Mendoza', family: 3, center: 'Evacuation Center B', date: '2024-01-16' }
    ],
    programs: [
      { id: 1, name: 'Disaster Preparedness Training', participants: 45, date: '2024-01-10', status: 'Completed' },
      { id: 2, name: 'Emergency Response Drill', participants: 32, date: '2024-01-20', status: 'Ongoing' }
    ],
    facilities: [
      { id: 1, name: 'Evacuation Center A', capacity: 100, current: 45, status: 'Operational' },
      { id: 2, name: 'Evacuation Center B', capacity: 75, current: 30, status: 'Operational' }
    ],
    activities: [
      { id: 1, action: 'Resident Registration', user: 'Admin', date: '2024-01-15 10:30' },
      { id: 2, action: 'SMS Alert Sent', user: 'Staff', date: '2024-01-15 14:20' }
    ],
    summary: {
      totalResidents: 1250,
      totalEvacuees: 78,
      activePrograms: 5,
      operationalFacilities: 3,
      recentActivities: 23
    }
  };
  
  let content = `
    <div class="header">
      <h1>${reportName}</h1>
      <p>Generated on ${currentDate}</p>
    </div>
  `;
  
  switch(reportType) {
    case 'residents':
      content += `
        <div class="section">
          <h2>Residents Summary</h2>
          <div class="summary">
            <p><strong>Total Residents:</strong> ${sampleData.residents.length}</p>
            <p><strong>Report Period:</strong> All registered residents</p>
          </div>
        </div>
        <div class="section">
          <h2>Resident Details</h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Contact</th>
              </tr>
            </thead>
            <tbody>
              ${sampleData.residents.map(r => `
                <tr>
                  <td>${r.id}</td>
                  <td>${r.name}</td>
                  <td>${r.age}</td>
                  <td>${r.address}</td>
                  <td>${r.contact}</td>
                </tr>
              `).join('')}
            </tbody>
          </table>
        </div>
      `;
      break;
      
    case 'evacuees':
      content += `
        <div class="section">
          <h2>Evacuees Summary</h2>
          <div class="summary">
            <p><strong>Total Evacuees:</strong> ${sampleData.evacuees.reduce((sum, e) => sum + e.family, 0)}</p>
            <p><strong>Families Affected:</strong> ${sampleData.evacuees.length}</p>
          </div>
        </div>
        <div class="section">
          <h2>Evacuee Details</h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Family Head</th>
                <th>Family Members</th>
                <th>Evacuation Center</th>
                <th>Date Registered</th>
              </tr>
            </thead>
            <tbody>
              ${sampleData.evacuees.map(e => `
                <tr>
                  <td>${e.id}</td>
                  <td>${e.name}</td>
                  <td>${e.family}</td>
                  <td>${e.center}</td>
                  <td>${e.date}</td>
                </tr>
              `).join('')}
            </tbody>
          </table>
        </div>
      `;
      break;
      
    case 'programs':
      content += `
        <div class="section">
          <h2>Programs Summary</h2>
          <div class="summary">
            <p><strong>Total Programs:</strong> ${sampleData.programs.length}</p>
            <p><strong>Total Participants:</strong> ${sampleData.programs.reduce((sum, p) => sum + p.participants, 0)}</p>
          </div>
        </div>
        <div class="section">
          <h2>Program Details</h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Program Name</th>
                <th>Participants</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              ${sampleData.programs.map(p => `
                <tr>
                  <td>${p.id}</td>
                  <td>${p.name}</td>
                  <td>${p.participants}</td>
                  <td>${p.date}</td>
                  <td>${p.status}</td>
                </tr>
              `).join('')}
            </tbody>
          </table>
        </div>
      `;
      break;
      
    case 'facilities':
      content += `
        <div class="section">
          <h2>Facilities Summary</h2>
          <div class="summary">
            <p><strong>Total Facilities:</strong> ${sampleData.facilities.length}</p>
            <p><strong>Total Capacity:</strong> ${sampleData.facilities.reduce((sum, f) => sum + f.capacity, 0)}</p>
            <p><strong>Current Occupancy:</strong> ${sampleData.facilities.reduce((sum, f) => sum + f.current, 0)}</p>
          </div>
        </div>
        <div class="section">
          <h2>Facility Details</h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Facility Name</th>
                <th>Capacity</th>
                <th>Current Occupancy</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              ${sampleData.facilities.map(f => `
                <tr>
                  <td>${f.id}</td>
                  <td>${f.name}</td>
                  <td>${f.capacity}</td>
                  <td>${f.current}</td>
                  <td>${f.status}</td>
                </tr>
              `).join('')}
            </tbody>
          </table>
        </div>
      `;
      break;
      
    case 'activities':
      content += `
        <div class="section">
          <h2>Activity Logs Summary</h2>
          <div class="summary">
            <p><strong>Total Activities:</strong> ${sampleData.activities.length}</p>
            <p><strong>Report Period:</strong> Recent activities</p>
          </div>
        </div>
        <div class="section">
          <h2>Activity Details</h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Action</th>
                <th>User</th>
                <th>Date & Time</th>
              </tr>
            </thead>
            <tbody>
              ${sampleData.activities.map(a => `
                <tr>
                  <td>${a.id}</td>
                  <td>${a.action}</td>
                  <td>${a.user}</td>
                  <td>${a.date}</td>
                </tr>
              `).join('')}
            </tbody>
          </table>
        </div>
      `;
      break;
      
    case 'summary':
      content += `
        <div class="section">
          <h2>Dashboard Summary</h2>
          <div class="summary">
            <p><strong>Total Residents:</strong> ${sampleData.summary.totalResidents}</p>
            <p><strong>Total Evacuees:</strong> ${sampleData.summary.totalEvacuees}</p>
            <p><strong>Active Programs:</strong> ${sampleData.summary.activePrograms}</p>
            <p><strong>Operational Facilities:</strong> ${sampleData.summary.operationalFacilities}</p>
            <p><strong>Recent Activities:</strong> ${sampleData.summary.recentActivities}</p>
          </div>
        </div>
        <div class="section">
          <h2>System Overview</h2>
          <p>This report provides a comprehensive overview of the Barangay Disaster Evacuation Alert Management System as of ${currentDate}.</p>
          <p>The system is actively monitoring and managing disaster preparedness activities, resident information, and emergency response operations.</p>
        </div>
      `;
      break;
  }
  
  return content;
}

function generateReport() {
  const reportType = document.getElementById('reportType').value;
  const format = document.querySelector('input[name="format"]:checked').value;
  
  if (!reportType) {
    alert('⚠️ Please select a report type.');
    return;
  }
  
  // Show loading message
  const generateBtn = event.target;
  const originalText = generateBtn.innerHTML;
  generateBtn.innerHTML = '⏳ Generating...';
  generateBtn.disabled = true;
  
  // Simulate report generation (in real app, this would be an API call)
  setTimeout(() => {
    const reportNames = {
      residents: 'All Residents Report',
      evacuees: 'Evacuees Report', 
      programs: 'Programs Report',
      facilities: 'Facilities Report',
      activities: 'Activity Logs Report',
      summary: 'Dashboard Summary Report'
    };
    
    const formatIcons = {
      pdf: '📄',
      excel: '📊',
      csv: '📋',
      print: '🖨️'
    };
    
    alert(`✅ Report Generated Successfully!\n\n${formatIcons[format]} ${reportNames[reportType]}\nFormat: ${format.toUpperCase()}\nDate: ${new Date().toLocaleDateString()}\n\n${format === 'print' ? '🖨️ Opening print dialog... The report has been formatted for printing and will open in your browser\'s print preview.' : format === 'pdf' ? '📄 Downloading PDF... The report is being generated and will download automatically.' : format === 'excel' ? '📊 Downloading Excel... The spreadsheet is being generated and will download automatically.' : format === 'csv' ? '📋 Downloading CSV... The data file is being generated and will download automatically.' : 'The report has been prepared and is ready for download. In a real implementation, this would trigger a file download or send the report via email.'}`);
    
    // Handle different formats
    if (format === 'print') {
      printReport(reportType, reportNames[reportType]);
    } else if (format === 'pdf') {
      generatePDFReport(reportType, reportNames[reportType]);
    } else if (format === 'excel') {
      generateExcelReport(reportType, reportNames[reportType]);
    } else if (format === 'csv') {
      generateCSVReport(reportType, reportNames[reportType]);
    }
    
    // Reset button
    generateBtn.innerHTML = originalText;
    generateBtn.disabled = false;
    
    // Close modal
    closeReportModal();
    
    // Reset form
    document.getElementById('reportType').value = '';
    document.querySelector('input[name="format"][value="pdf"]').checked = true;
  }, 2000);
}

function openLogoutModal() {
  document.getElementById('logoutModalOverlay').style.display = 'block';
  document.getElementById('logoutModal').style.display = 'block';
}

function closeLogoutModal() {
  document.getElementById('logoutModalOverlay').style.display = 'none';
  document.getElementById('logoutModal').style.display = 'none';
}


setTimeout(()=>{
  const alert = document.getElementById('successAlert') || document.getElementById('welcomeAlert');
  if(alert){ alert.classList.add('hide'); setTimeout(()=>alert.remove(),500); }
},3000);

// Program dropdown functionality
const programDropdown = document.querySelector('.dropdown');
const programToggle = programDropdown.querySelector('.dropdown-toggle');
const programMenu = programDropdown.querySelector('.dropdown-menu');

// Toggle dropdown on click
programToggle.addEventListener('click', function(e) {
  e.preventDefault();
  const isOpen = programMenu.style.display === 'block';
  programMenu.style.display = isOpen ? 'none' : 'block';
  programMenu.style.opacity = isOpen ? '0' : '1';
  programMenu.style.transform = isOpen ? 'translateY(10px)' : 'translateY(0)';
  programMenu.style.pointerEvents = isOpen ? 'none' : 'auto';
});

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
  if (!programDropdown.contains(e.target)) {
    programMenu.style.display = 'none';
    programMenu.style.opacity = '0';
    programMenu.style.transform = 'translateY(10px)';
    programMenu.style.pointerEvents = 'none';
  }
});

document.addEventListener('DOMContentLoaded', function() {
  // Existing code...
});

// Logout confirmation function
function confirmLogout(button) {
  if (confirm('Are you sure you want to logout?')) {
    button.closest('form').submit();
  }
}

// Employee Assignment Modal Functions
function openAssignmentModal() {
  document.getElementById('assignmentModalOverlay').style.display = 'block';
  document.getElementById('assignmentModal').style.display = 'block';
}

function closeAssignmentModal() {
  document.getElementById('assignmentModalOverlay').style.display = 'none';
  document.getElementById('assignmentModal').style.display = 'none';
  
  // Reset form
  document.getElementById('assignmentForm').reset();
}

function submitAssignment(event) {
  event.preventDefault();
  
  if (!event.target) {
    console.error('Event target is null');
    showAlert('error', 'An error occurred. Please try again.');
    return;
  }
  
  const formData = new FormData(event.target);
  const submitBtn = event.target.querySelector('button[type="submit"]');
  
  if (!submitBtn) {
    console.error('Submit button not found');
    showAlert('error', 'An error occurred. Please try again.');
    return;
  }
  
  const originalText = submitBtn.innerHTML;
  
  // Show loading state
  submitBtn.innerHTML = 'Assigning...';
  submitBtn.disabled = true;
  
  // Send AJAX request
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                     document.querySelector('input[name="_token"]')?.value;
  
  if (!csrfToken) {
    console.error('CSRF token not found');
    showAlert('error', 'Security token error. Please refresh the page and try again.');
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
    return;
  }
  
  fetch('/employee-assignments', {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Show success message
      showAlert('success', data.message);
      
      // Close modal and reset form
      closeAssignmentModal();
      
      // Optionally refresh the page or update the assignments list
      setTimeout(() => {
        if (confirm('Employee assigned successfully! Would you like to view all assignments?')) {
          window.location.href = '/employee-assignments';
        }
      }, 1000);
    } else {
      // Show validation errors
      let errorMessage = 'Please fix the following errors:\n';
      for (const [field, errors] of Object.entries(data.errors)) {
        errorMessage += `\n• ${errors.join(', ')}`;
      }
      showAlert('error', errorMessage);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showAlert('error', 'An error occurred while assigning the employee. Please try again.');
  })
  .finally(() => {
    // Reset button
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  });
}

// Helper function to show alerts
function showAlert(type, message) {
  const alertDiv = document.createElement('div');
  alertDiv.className = `alert ${type}`;
  alertDiv.textContent = message;
  alertDiv.style.position = 'fixed';
  alertDiv.style.top = '20px';
  alertDiv.style.right = '20px';
  alertDiv.style.zIndex = '9999';
  alertDiv.style.padding = '15px 25px';
  alertDiv.style.borderRadius = '10px';
  alertDiv.style.fontWeight = '600';
  alertDiv.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
  
  if (type === 'success') {
    alertDiv.style.backgroundColor = '#28a745';
    alertDiv.style.color = '#fff';
  } else {
    alertDiv.style.backgroundColor = '#dc3545';
    alertDiv.style.color = '#fff';
  }
  
  document.body.appendChild(alertDiv);
  
  // Animate in
  setTimeout(() => {
    alertDiv.style.opacity = '1';
    alertDiv.style.transform = 'translateX(0)';
  }, 100);
  
  // Remove after 5 seconds
  setTimeout(() => {
    alertDiv.style.opacity = '0';
    alertDiv.style.transform = 'translateX(100px)';
    setTimeout(() => {
      if (alertDiv.parentNode) {
        alertDiv.parentNode.removeChild(alertDiv);
      }
    }, 500);
  }, 5000);
}
</script>
</body>
</html>
