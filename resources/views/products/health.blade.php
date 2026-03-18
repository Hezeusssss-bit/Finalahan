<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Health Center</title>
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
.main-content { margin-left: 280px; flex: 1; padding: 35px; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; }

/* Header */
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 30px 35px; background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); border: 1px solid rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
.header h1 { color: #1e293b; font-size: 36px; font-weight: 800; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.5px; }
.header-icons { display: flex; gap: 20px; align-items: center; }
.icon-btn { width: 50px; height: 50px; border-radius: 15px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: relative; overflow: hidden; text-decoration: none; }
.icon-btn::before { content: ''; position: absolute; top: 50%; left: 50%; width: 0; height: 0; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; transform: translate(-50%, -50%); transition: all 0.4s ease; }
.icon-btn:hover::before { width: 100%; height: 100%; }
.icon-btn:hover { transform: translateY(-5px) scale(1.05); box-shadow: 0 15px 40px rgba(59, 130, 246, 0.3); border-color: transparent; }
.icon-btn:hover i { color: white; transform: scale(1.1); position: relative; z-index: 1; }
.icon-btn i { color: #64748b; font-size: 20px; transition: all 0.4s ease; position: relative; z-index: 1; }

/* Container */
.container { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

/* Facility Info Section */
.facility-info { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
.facility-details { }
.facility-details h2 { color: #1a1a2e; font-size: 24px; margin-bottom: 15px; }
.facility-details p { color: #666; line-height: 1.6; margin-bottom: 10px; }
.facility-image { background: #f8f9fa; border-radius: 12px; display: flex; align-items: center; justify-content: center; min-height: 200px; }
.facility-image i { font-size: 80px; color: #1a1a2e; }

/* Features Grid */
.features-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
.feature-card { background: #f8f9fa; border-radius: 12px; padding: 20px; border: 2px solid #e9ecef; transition: all 0.3s ease; cursor: pointer; }
.feature-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #1a1a2e; }
.feature-icon { font-size: 32px; color: #1a1a2e; margin-bottom: 10px; }
.feature-title { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
.feature-description { font-size: 14px; color: #666; line-height: 1.5; margin-bottom: 10px; }
.feature-status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.status-available { background: #d4edda; color: #155724; }
.status-unavailable { background: #f8d7da; color: #721c24; }
.status-maintenance { background: #fff3cd; color: #856404; }

/* Emergency Info */
.emergency-info { background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 12px; padding: 20px; margin-top: 20px; }
.emergency-info h3 { color: #721c24; font-size: 18px; margin-bottom: 10px; }
.emergency-info p { color: #721c24; line-height: 1.6; }

/* Back Button */
.back-btn { display: inline-flex; align-items: center; gap: 8px; color: #1a1a2e; text-decoration: none; font-weight: 600; margin-bottom: 20px; transition: all 0.3s ease; }
.back-btn:hover { color: #007bff; transform: translateX(-2px); }

/* Responsive */
@media (max-width: 768px) {
  .sidebar { width: 70px; }
  .logo span, .nav-item span { display: none; }
  .main-content { margin-left: 70px; padding: 20px; }
  .facility-info { grid-template-columns: 1fr; }
  .features-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo"><i class="fas fa-store"></i> <span>Logo</span></div>
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
      <a href="{{ route('program.evacuee') }}" class="nav-item">
        <i class="fas fa-users"></i>
        <span>Evacuee Program</span>
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
      <a href="#" class="nav-item">
        <i class="fas fa-calendar-alt"></i>
        <span>Events</span>
      </a>
      <a href="{{ route('facilities') }}" class="nav-item active">
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
    <h1>Health Center</h1>
  </div>

  <div class="container">
    <a href="{{ route('facilities') }}" class="back-btn">
      <i class="fas fa-arrow-left"></i>
      Back to Facilities
    </a>
    
    <div class="facility-info">
      <div class="facility-details">
        <h2>Barangay Health Center</h2>
        <p><strong>Primary Purpose:</strong> Medical facility providing basic healthcare services and emergency response</p>
        <p><strong>Services:</strong> Basic medical care, maternal care, immunization, and health education</p>
        <p><strong>Operating Hours:</strong> 24/7 Emergency Services, Regular Hours: 8:00 AM - 5:00 PM</p>
        <p><strong>Emergency Hotline:</strong> (123) 456-7890</p>
        <p><strong>Location:</strong> Strategic location with easy emergency vehicle access</p>
      </div>
      <div class="facility-image">
        <i class="fas fa-hospital"></i>
      </div>
    </div>

    <h2 style="margin: 30px 0 20px 0; color: #1a1a2e;">Available Services</h2>
    
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-stethoscope"></i></div>
        <div class="feature-title">General Consultation</div>
        <div class="feature-description">Basic medical consultation and diagnosis for common health concerns</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-ambulance"></i></div>
        <div class="feature-title">Emergency Services</div>
        <div class="feature-description">24/7 emergency medical response and first aid treatment</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-baby"></i></div>
        <div class="feature-title">Maternal & Child Care</div>
        <div class="feature-description">Pre-natal, post-natal care and pediatric services</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-syringe"></i></div>
        <div class="feature-title">Immunization</div>
        <div class="feature-description">Regular immunization programs for children and adults</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-capsules"></i></div>
        <div class="feature-title">Pharmacy</div>
        <div class="feature-description">Essential medicines and medical supplies available</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-microscope"></i></div>
        <div class="feature-title">Laboratory</div>
        <div class="feature-description">Basic laboratory tests and diagnostic services</div>
        <span class="feature-status status-maintenance">Under Maintenance</span>
      </div>

      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-tooth"></i></div>
        <div class="feature-title">Dental Services</div>
        <div class="feature-description">Basic dental check-ups and minor dental procedures</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-heartbeat"></i></div>
        <div class="feature-title">Health Programs</div>
        <div class="feature-description">Regular health education and wellness programs</div>
        <span class="feature-status status-available">Available</span>
      </div>
    </div>

    <div class="emergency-info">
      <h3><i class="fas fa-exclamation-triangle"></i> Emergency Contact Information</h3>
      <p><strong>Emergency Hotline:</strong> (123) 456-7890 (Available 24/7)</p>
      <p><strong>For Medical Emergencies:</strong> Contact the health center immediately or call the emergency hotline. Our medical staff is trained to handle various emergency situations and can coordinate with nearby hospitals for more serious cases.</p>
      <p><strong>Ambulance Service:</strong> Emergency transport is available for critical cases requiring hospital care.</p>
    </div>
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
