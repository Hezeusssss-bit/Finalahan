<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - YOTS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f6fa;
        }
        .sidebar {
            background-color: #1a1a2e;
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .nav-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .dropdown-content {
            display: none;
            padding-left: 20px;
        }
        .dropdown.active .dropdown-content {
            display: block;
        }
        .insights-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
        }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: #f5f5f5; min-height: 100vh; margin: 0; display: flex; }

/* Sidebar */
.sidebar { width: 250px; background: #1a1a2e; min-height: 100vh; padding: 30px 0; position: fixed; left: 0; top: 0; display: flex; flex-direction: column; }
.logo { color: #fff; font-size: 24px; font-weight: 700; padding: 0 30px; margin-bottom: 50px; display: flex; align-items: center; gap: 10px; }
.nav-menu { flex: 1; }
.nav-item { color: #999; padding: 15px 30px; text-decoration: none; display: flex; align-items: center; gap: 10px; transition: all 0.3s ease; cursor: pointer; font-size: 15px; }
.nav-item i { width: 20px; text-align: center; }
.nav-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
.nav-item.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 3px solid #fff; }
.sidebar-footer { margin-top: auto; }

/* Main Content */
.main-content { margin-left: 250px; flex: 1; padding: 30px 40px; }

/* Header */
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header h1 { color: #1a1a2e; font-size: 28px; font-weight: 700; }
.header-icons { display: flex; gap: 12px; align-items: center; }
.icon-btn { width: 40px; height: 40px; border-radius: 50%; background: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.icon-btn i { color: #333; font-size: 16px; }
.icon-btn:hover { background: #f5f5f5; transform: translateY(-2px); }

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
  <div class="logo"><i class="fas fa-store"></i> <span>MSWD</span></div>
  <nav class="nav-menu">
    <a href="#" class="nav-item active">
      <i class="fas fa-chart-line"></i>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('program') }}" class="nav-item"><i class="fas fa-chart-line"></i><span>Programs</span></a>
    <a href="{{ route('services') }}" class="nav-item"><i class="fas fa-boxes"></i><span>Services</span></a>
    <a href="{{ route('events') }}" class="nav-item"><i class="fas fa-calendar-alt"></i><span>Events</span></a>
  </nav>
  <div class="sidebar-footer">
    <a href="#" class="nav-item"><i class="fas fa-cog"></i><span>Settings</span></a>
    <button type="button" class="nav-item" style="background:none;border:none;width:100%;text-align:left;" onclick="openLogoutModal()">
      <i class="fas fa-sign-out-alt"></i><span>Logout</span>
    </button>
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
      <div class="title">Total Facilities</div>
      <a href="{{ route('facilities') }}" class="cta">View all</a>
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
      <div style="max-height:200px;overflow-y:auto;">
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

  <!-- Intelligent Decision Support Panel -->
  <div class="panel full" style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:#fff;margin-bottom:20px;">
    <div style="font-weight:700;margin-bottom:15px;font-size:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-brain"></i> Intelligent Insights & Recommendations
    </div>
    @php
      $insights = [];
      
      // Calamity Preparedness & Emergency Response Insights
      
      // Critical: High resident count requires robust emergency plans
      if($totalResidents > 20) {
        $insights[] = [
          'type' => 'critical',
          'icon' => 'fa-triangle-exclamation',
          'title' => 'Emergency Evacuation Plan Required',
          'message' => "With {$totalResidents} residents, you need a comprehensive evacuation plan. Ensure all residents know evacuation routes and assembly points.",
          'action' => 'Review Evacuation Procedures'
        ];
      }
      
      // New residents need emergency briefing
      if($newThisMonth > 0) {
        $insights[] = [
          'type' => 'warning',
          'icon' => 'fa-house-tsunami',
          'title' => 'Disaster Preparedness Orientation',
          'message' => "{$newThisMonth} new residents need emergency preparedness training. Brief them on calamity protocols, evacuation routes, and emergency contacts.",
          'action' => 'Schedule Safety Orientation'
        ];
      }
      
      // Regular check recommendation
      $insights[] = [
        'type' => 'info',
        'icon' => 'fa-kit-medical',
        'title' => 'Emergency Supplies Check',
        'message' => 'Conduct monthly inspection of emergency supplies: first aid kits, flashlights, water, food rations, and communication devices.',
        'action' => 'Inspect Emergency Kit'
      ];
      
      // Communication system readiness
      $insights[] = [
        'type' => 'info',
        'icon' => 'fa-tower-broadcast',
        'title' => 'Emergency Alert System',
        'message' => 'Test your emergency communication system regularly. Ensure all residents have working contact numbers and know emergency hotlines.',
        'action' => 'Test Alert System'
      ];
      
      // Disaster preparedness recommendation
      if($totalResidents > 0) {
        $insights[] = [
          'type' => 'success',
          'icon' => 'fa-shield-heart',
          'title' => 'Community Resilience Building',
          'message' => 'Organize regular disaster preparedness drills. Practice earthquake, fire, and flood response scenarios with all residents.',
          'action' => 'Schedule Disaster Drill'
        ];
      }
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:12px;">
      @foreach($insights as $insight)
      <div style="background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);padding:15px;border-radius:10px;border:1px solid rgba(255,255,255,0.2);">
        <div style="display:flex;align-items:start;gap:12px;">
          <div style="background:rgba(255,255,255,0.25);width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas {{ $insight['icon'] }}" style="font-size:18px;"></i>
          </div>
          <div style="flex:1;">
            <div style="font-weight:700;font-size:14px;margin-bottom:6px;">{{ $insight['title'] }}</div>
            <div style="font-size:12px;line-height:1.5;opacity:0.95;margin-bottom:10px;">{{ $insight['message'] }}</div>
            <button onclick="handleInsightAction('{{ $insight['action'] }}')" style="background:rgba(255,255,255,0.25);border:1px solid rgba(255,255,255,0.3);color:#fff;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:600;cursor:pointer;transition:all 0.3s;">
              {{ $insight['action'] }} →
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div class="panel full">
    <div style="font-weight:700;color:#333;margin-bottom:15px;font-size:16px;">📋 Quick Actions</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;">
      <a href="{{ route('home') }}" class="quick-action" style="background:#f8f9fa;padding:15px;border-radius:8px;text-decoration:none;color:#333;border:1px solid #e9ecef;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-users" style="color:#1a1a2e;font-size:18px;"></i>
        <div>
          <div style="font-weight:600;font-size:14px;">Manage Residents</div>
          <div style="font-size:12px;color:#666;">View and edit residents</div>
        </div>
      </a>
      <a href="{{ route('resident.create') }}" class="quick-action" style="background:#f8f9fa;padding:15px;border-radius:8px;text-decoration:none;color:#333;border:1px solid #e9ecef;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-user-plus" style="color:#28a745;font-size:18px;"></i>
        <div>
          <div style="font-weight:600;font-size:14px;">Add New Resident</div>
          <div style="font-size:12px;color:#666;">Register new resident</div>
        </div>
      </a>
      <a href="#" class="quick-action" style="background:#f8f9fa;padding:15px;border-radius:8px;text-decoration:none;color:#333;border:1px solid #e9ecef;display:flex;align-items:center;gap:10px;">
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
    </div>
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

<script>
function openLogoutModal() {
  document.getElementById('logoutModalOverlay').style.display = 'block';
  document.getElementById('logoutModal').style.display = 'block';
}

function closeLogoutModal() {
  document.getElementById('logoutModalOverlay').style.display = 'none';
  document.getElementById('logoutModal').style.display = 'none';
}

// Calamity-Focused Intelligent Decision Support Handler
function handleInsightAction(action) {
  const actions = {
    'Review Evacuation Procedures': () => {
      alert('🚨 EVACUATION PROCEDURES\n\n' +
            'CRITICAL ACTIONS:\n\n' +
            '✓ Map all evacuation routes\n' +
            '✓ Designate 3 assembly points\n' +
            '✓ Assign evacuation coordinators\n' +
            '✓ Post evacuation maps in visible areas\n' +
            '✓ Conduct headcount procedures\n' +
            '✓ Identify residents needing assistance\n\n' +
            'EMERGENCY HOTLINES:\n' +
            '• NDRRMC: 911\n' +
            '• Red Cross: 143\n' +
            '• Fire: 160\n\n' +
            'Redirecting to resident management...');
      window.location.href = '{{ route("home") }}';
    },
    'Schedule Safety Orientation': () => {
      alert('🎓 DISASTER PREPAREDNESS ORIENTATION\n\n' +
            'TOPICS TO COVER:\n\n' +
            '1. EARTHQUAKE RESPONSE\n' +
            '   • Drop, Cover, Hold On\n' +
            '   • Safe zones in building\n' +
            '   • Post-quake procedures\n\n' +
            '2. FIRE SAFETY\n' +
            '   • Fire escape routes\n' +
            '   • Use of fire extinguishers\n' +
            '   • Stop, Drop, Roll technique\n\n' +
            '3. FLOOD PREPAREDNESS\n' +
            '   • Evacuation triggers\n' +
            '   • Emergency go-bag essentials\n' +
            '   • High ground locations\n\n' +
            '4. EMERGENCY CONTACTS\n' +
            '   • Local emergency services\n' +
            '   • Family contact tree\n\n' +
            'Setting up orientation schedule...');
      window.location.href = '{{ route("home") }}';
    },
    'Inspect Emergency Kit': () => {
      alert('🏥 EMERGENCY KIT INSPECTION CHECKLIST\n\n' +
            'ESSENTIAL SUPPLIES (Check Monthly):\n\n' +
            '□ First Aid Kit (bandages, antiseptic, medications)\n' +
            '□ Flashlights + Extra Batteries\n' +
            '□ Portable Radio (battery/solar powered)\n' +
            '□ Drinking Water (3-day supply per person)\n' +
            '□ Non-perishable Food (canned goods, biscuits)\n' +
            '□ Emergency Whistle\n' +
            '□ Matches in waterproof container\n' +
            '□ Important Documents (sealed plastic)\n' +
            '□ Cash + Coins\n' +
            '□ Multi-tool/Swiss Knife\n' +
            '□ Blankets/Sleeping Bags\n' +
            '□ Hygiene Supplies\n' +
            '□ Mobile Power Banks\n\n' +
            'INSPECT: Replace expired items immediately!\n\n' +
            'Opening resident records...');
      window.location.href = '{{ route("home") }}';
    },
    'Test Alert System': () => {
      alert('📡 EMERGENCY COMMUNICATION SYSTEM TEST\n\n' +
            'TESTING PROCEDURES:\n\n' +
            '1. SMS ALERT SYSTEM\n' +
            '   • Verify all resident phone numbers\n' +
            '   • Send test alert message\n' +
            '   • Confirm receipt rate\n\n' +
            '2. SIREN/ALARM SYSTEM\n' +
            '   • Test alarm audibility\n' +
            '   • Check battery backup\n' +
            '   • Ensure 360° coverage\n\n' +
            '3. COMMUNITY ALERT NETWORK\n' +
            '   • Floor/building coordinators\n' +
            '   • Door-to-door notification plan\n' +
            '   • Megaphone availability\n\n' +
            '4. EMERGENCY HOTLINES\n' +
            '   • Test all posted numbers\n' +
            '   • Update contact list\n\n' +
            'NEXT: Schedule monthly communication drills\n\n' +
            'Accessing resident contacts...');
      window.location.href = '{{ route("home") }}';
    },
    'Schedule Disaster Drill': () => {
      alert('🏃 DISASTER PREPAREDNESS DRILL\n\n' +
            'DRILL SCENARIOS TO PRACTICE:\n\n' +
            '🌊 FLOOD DRILL\n' +
            '   • Vertical evacuation to upper floors\n' +
            '   • Securing important documents\n' +
            '   • Shutting off utilities\n\n' +
            '🔥 FIRE DRILL\n' +
            '   • Evacuation within 3 minutes\n' +
            '   • Using fire exits (not elevators)\n' +
            '   • Assembly point roll call\n\n' +
            '⚡ EARTHQUAKE DRILL\n' +
            '   • Drop, Cover, Hold On practice\n' +
            '   • Safe zone identification\n' +
            '   • Post-quake evacuation\n\n' +
            '🌪️ TYPHOON PREPAREDNESS\n' +
            '   • Securing outdoor items\n' +
            '   • Window reinforcement\n' +
            '   • Shelter-in-place procedures\n\n' +
            'FREQUENCY: Conduct drills quarterly\n' +
            'TIMING: Unannounced for realism\n\n' +
            'Organizing drill schedule...');
      window.location.href = '{{ route("home") }}';
    }
  };
  
  const handler = actions[action];
  if (handler) {
    handler();
  } else {
    alert('⚠️ Feature Coming Soon!\n\nThis calamity preparedness feature is being developed.\n\nIn the meantime, please consult with your local disaster risk reduction office for guidance.');
  }
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
</script>
</body>
</html>
