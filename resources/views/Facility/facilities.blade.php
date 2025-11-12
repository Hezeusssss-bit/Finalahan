<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Facilities Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
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
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.header h1 { color: #1a1a2e; font-size: 28px; font-weight: 700; }
.header-icons { display: flex; gap: 15px; align-items: center; }
.icon-btn { width: 40px; height: 40px; border-radius: 50%; background: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.icon-btn:hover { background: #f5f5f5; transform: translateY(-2px); }
.icon-btn i { color: #333; font-size: 16px; }

/* Container */
.container { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

.facility-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
.facility-card { background: #f8f9fa; border-radius: 12px; padding: 20px; border: 2px solid #e9ecef; transition: all 0.3s ease; }
.facility-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #1a1a2e; }
.facility-icon { font-size: 48px; color: #1a1a2e; margin-bottom: 15px; }
.facility-title { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
.facility-description { font-size: 14px; color: #666; line-height: 1.6; }
.facility-status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-top: 10px; }
.status-available { background: #d4edda; color: #155724; }
.status-maintenance { background: #fff3cd; color: #856404; }

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
  <div class="logo"><i class="fas fa-store"></i> <span>Logo</span></div>
  <nav class="nav-menu">
    <a href="{{ route('resident.index') }}" class="nav-item"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
    <a href="{{ route('facilities') }}" class="nav-item active"><i class="fas fa-building"></i><span>Facilities</span></a>
        <a href="" class="nav-item"><i class="fas fa-users"></i><span>View Evacuee</span></a>
  </nav>
  <div class="sidebar-footer">
    <a href="#" class="nav-item"><i class="fas fa-cog"></i><span>Settings</span></a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-item" style="background:none;border:none;width:100%;text-align:left;">
        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
      </button>
    </form>
  </div>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <h1>Facility Management</h1>
  </div>

  <div class="container">
    <h2 style="margin-bottom: 20px; color: #1a1a2e;">Available Facilities</h2>
    
    <div class="facility-grid">
      <a href="{{ route('community') }}" class="facility-card" style="text-decoration: none; color: inherit;">
        <div class="facility-icon"><i class="fas fa-home"></i></div>
        <div class="facility-title">Community Center</div>
        <div class="facility-description">Main gathering space for community events, meetings, and activities.</div>
        <span class="facility-status status-available">Available</span>
      </a>

      <a href="{{ route('health') }}" class="facility-card" style="text-decoration: none; color: inherit;">
        <div class="facility-icon"><i class="fas fa-hospital"></i></div>
        <div class="facility-title">Health Center</div>
        <div class="facility-description">Medical facility providing basic healthcare services and emergency response.</div>
        <span class="facility-status status-available">Available</span>
      </a>

      <a href="{{ route('school') }}" class="facility-card" style="text-decoration: none; color: inherit;">
        <div class="facility-icon"><i class="fas fa-school"></i></div>
        <div class="facility-title">Schools</div>
        <div class="facility-description">For Evacuation and Emergency Response</div>
        <span class="facility-status status-available">Available</span>
      </a>


      <a href="{{ route('shelter') }}" class="facility-card" style="text-decoration: none; color: inherit;">
        <div class="facility-icon"><i class="fas fa-shield-alt"></i></div>
        <div class="facility-title">Emergency Shelter</div>
        <div class="facility-description">Designated safe area for calamity evacuation and emergency situations.</div>
        <span class="facility-status status-available">Available</span>
      </a>



    </div>
  </div>
</div>

</body>
</html>
