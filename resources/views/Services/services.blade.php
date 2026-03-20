<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Barangay Officials</title>
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

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, rgba(255,255,255,0.3), transparent);
}

.stat-card h3 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    opacity: 0.9;
}

.stat-card .number {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 5px;
}

.stat-card .icon {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 48px;
    opacity: 0.2;
}

/* Container */
.container { 
    background: white; 
    border-radius: 20px; 
    padding: 30px; 
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); 
    border: 1px solid rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    margin-bottom: 30px;
}

/* Officials Sections */
.officials-section {
    margin-bottom: 40px;
}

.section-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 15px 15px 0 0;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 0;
}

.officials-list {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0 0 15px 15px;
    padding: 20px;
}

.official-card {
    display: flex;
    align-items: center;
    padding: 20px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    background: #fafafa;
}

.official-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    background: white;
}

.official-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    overflow: hidden;
}

.official-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.official-photo .default-icon {
    color: white;
    font-size: 32px;
}

.official-info {
    flex: 1;
}

.official-name {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 5px;
}

.official-position {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 8px;
}

.official-details {
    display: flex;
    gap: 20px;
    margin-bottom: 8px;
}

.official-details span {
    font-size: 13px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 5px;
}

.official-details i {
    color: #3b82f6;
    width: 16px;
}

.official-status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.empty-state i {
    font-size: 48px;
    color: #d1d5db;
    margin-bottom: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar { width: 70px; }
    .logo span, .nav-item span { display: none; }
    .main-content { margin-left: 70px; padding: 20px; }
    .stats-grid { grid-template-columns: 1fr; }
}

/* Premium Modal Styles - Glassmorphism */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 2000;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.modal-overlay.active {
    display: flex;
    opacity: 1;
}

.modal {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
    border-radius: 24px;
    padding: 0;
    width: 90%;
    max-width: 650px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 
        0 25px 80px rgba(0, 0, 0, 0.25),
        0 10px 30px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.4);
    transform: scale(0.9) translateY(20px);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.modal-overlay.active .modal {
    transform: scale(1) translateY(0);
}

.modal-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: white;
    padding: 28px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
}

.modal-header h2 {
    color: white;
    font-size: 26px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.modal-header h2::before {
    content: '\f234';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    font-size: 24px;
    background: linear-gradient(135deg, #60a5fa, #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.close-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 24px;
    cursor: pointer;
    color: rgba(255, 255, 255, 0.8);
    padding: 0;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.close-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.4);
    color: #fca5a5;
    transform: rotate(90deg);
}

.modal form {
    padding: 32px;
    max-height: calc(90vh - 100px);
    overflow-y: auto;
}

.form-group {
    margin-bottom: 24px;
}

.form-group label {
    display: block;
    color: #374151;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 14px;
    letter-spacing: 0.3px;
}

.form-group input:not([type="checkbox"]),
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e5e7eb;
    border-radius: 14px;
    font-size: 15px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: inherit;
    background: #fafafa;
    color: #1f2937;
}

.form-group input:hover:not([type="checkbox"]),
.form-group select:hover,
.form-group textarea:hover {
    border-color: #d1d5db;
    background: #f9fafb;
}

.form-group input:focus:not([type="checkbox"]),
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), 0 4px 12px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.form-group select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 20px;
    padding-right: 45px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
    border-radius: 14px;
    border: 2px solid #86efac;
    transition: all 0.3s ease;
}

.checkbox-group:hover {
    border-color: #4ade80;
    box-shadow: 0 4px 12px rgba(74, 222, 128, 0.15);
}

.checkbox-group input[type="checkbox"] {
    width: 24px;
    height: 24px;
    cursor: pointer;
    accent-color: #10b981;
    border-radius: 6px;
}

.checkbox-group label {
    margin: 0;
    font-weight: 600;
    color: #166534;
    cursor: pointer;
    user-select: none;
}

.form-actions {
    display: flex;
    gap: 14px;
    justify-content: flex-end;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 2px solid #f3f4f6;
}

.btn-secondary {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #4b5563;
    border: 2px solid #d1d5db;
    padding: 14px 28px;
    border-radius: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
    border-color: #9ca3af;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s ease;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e3a8a 100%);
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.btn-primary:active {
    transform: translateY(0) scale(0.98);
}

.modal form::-webkit-scrollbar {
    width: 8px;
}

.modal form::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.modal form::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #3b82f6, #8b5cf6);
    border-radius: 4px;
}

.alert {
    position: fixed;
    top: 24px;
    right: 24px;
    padding: 18px 28px;
    border-radius: 16px;
    font-weight: 600;
    z-index: 3000;
    animation: slideInRight 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert::before {
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    font-size: 20px;
}

.alert-success {
    background: linear-gradient(135deg, rgba(220, 252, 231, 0.95) 0%, rgba(187, 247, 208, 0.95) 100%);
    color: #166534;
    border-color: #86efac;
}

.alert-success::before {
    content: '\f00c';
    color: #22c55e;
}

.alert-error {
    background: linear-gradient(135deg, rgba(254, 226, 226, 0.95) 0%, rgba(254, 202, 202, 0.95) 100%);
    color: #991b1b;
    border-color: #fca5a5;
}

.alert-error::before {
    content: '\f071';
    color: #ef4444;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%) scale(0.8);
        opacity: 0;
    }
    to {
        transform: translateX(0) scale(1);
        opacity: 1;
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

  <div class="nav-section">
    <div class="nav-section-title">Services</div>
    <nav class="nav-menu">
      <a href="{{ route('services') }}" class="nav-item active">
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

  <div class="sidebar-footer">
    <div class="nav-section">
      <div class="nav-section-title">System</div>
      <nav class="nav-menu">
        <a href="{{ route('activity-logs.index') }}" class="nav-item">
          <i class="fas fa-cog"></i>
          <span>Activity Log</span>
        </a>
        <form id="logoutForm" method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="button" class="nav-item" style="background:none;border:none;width:100%;text-align:left;" onclick="openLogoutModal()">
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
    <h1>Barangay Officials</h1>
    <button onclick="openModal()" class="btn btn-primary">
      <i class="fas fa-plus"></i> Add Official
    </button>
  </div>

  <!-- Stats Cards -->
  <div class="stats-grid">
    <div class="stat-card">
      <h3>Total Officials</h3>
      <div class="number">{{ $officials->count() }}</div>
      <i class="fas fa-users icon"></i>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
      <h3>Active Officials</h3>
      <div class="number">{{ $officials->where('is_active', true)->count() }}</div>
      <i class="fas fa-check-circle icon"></i>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
      <h3>Barangay Captain</h3>
      <div class="number">{{ $captains->count() }}</div>
      <i class="fas fa-crown icon"></i>
    </div>
  </div>

  <!-- Barangay Captain Section -->
  <div class="container">
    <div class="officials-section">
      <div class="section-header">
        <i class="fas fa-crown"></i> Barangay Captain
      </div>
      <div class="officials-list">
        @forelse($captains as $official)
          <div class="official-card">
            <div class="official-photo">
              @if($official->photo_path)
                <img src="{{ asset('storage/' . $official->photo_path) }}" alt="{{ $official->full_name }}">
              @else
                <i class="fas fa-user default-icon"></i>
              @endif
            </div>
            <div class="official-info">
              <div class="official-name">{{ $official->full_name }}</div>
              <div class="official-position">Barangay Captain</div>
              <div class="official-details">
                <span><i class="fas fa-map-marker-alt"></i> {{ $official->purok ?: 'Not Assigned' }}</span>
                @if($official->contact_number)
                  <span><i class="fas fa-phone"></i> {{ $official->contact_number }}</span>
                @endif
              </div>
              <div class="official-status {{ $official->is_active ? 'status-active' : 'status-inactive' }}">
                {{ $official->is_active ? 'Active' : 'Inactive' }}
              </div>
            </div>
          </div>
        @empty
          <div class="empty-state">
            <i class="fas fa-crown"></i>
            <h3>No Barangay Captain</h3>
            <p>No captain has been added yet.</p>
          </div>
        @endforelse
      </div>
    </div>

    <!-- Other Officials Section -->
    <div class="officials-section">
      <div class="section-header">
        <i class="fas fa-users"></i> Other Officials
      </div>
      <div class="officials-list">
        @forelse($otherOfficials as $official)
          <div class="official-card">
            <div class="official-photo">
              @if($official->photo_path)
                <img src="{{ asset('storage/' . $official->photo_path) }}" alt="{{ $official->full_name }}">
              @else
                <i class="fas fa-user default-icon"></i>
              @endif
            </div>
            <div class="official-info">
              <div class="official-name">{{ $official->full_name }}</div>
              <div class="official-position">{{ $official->position }}</div>
              <div class="official-details">
                <span><i class="fas fa-map-marker-alt"></i> {{ $official->purok ?: 'Not Assigned' }}</span>
                @if($official->contact_number)
                  <span><i class="fas fa-phone"></i> {{ $official->contact_number }}</span>
                @endif
              </div>
              <div class="official-status {{ $official->is_active ? 'status-active' : 'status-inactive' }}">
                {{ $official->is_active ? 'Active' : 'Inactive' }}
              </div>
            </div>
          </div>
        @empty
          <div class="empty-state">
            <i class="fas fa-users"></i>
            <h3>No Other Officials</h3>
            <p>No other officials have been added yet.</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Add Official Modal -->
<div id="addOfficialModal" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <h2>Add New Official</h2>
      <button onclick="closeModal()" class="close-btn">&times;</button>
    </div>
    
    <form id="addOfficialForm">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label for="first_name">First Name *</label>
          <input type="text" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name *</label>
          <input type="text" id="last_name" name="last_name" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="middle_name">Middle Name</label>
        <input type="text" id="middle_name" name="middle_name">
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="position">Position *</label>
          <select id="position" name="position" required>
            <option value="">Select Position</option>
            <option value="Captain">Captain</option>
            <option value="Kagawad">Kagawad</option>
            <option value="Secretary">Secretary</option>
            <option value="Treasurer">Treasurer</option>
            <option value="SK Chairman">SK Chairman</option>
          </select>
        </div>
        <div class="form-group">
          <label for="purok">Purok *</label>
          <select id="purok" name="purok" required>
            <option value="">Select Purok</option>
            <option value="Purok I">Purok I</option>
            <option value="Purok II">Purok II</option>
            <option value="Purok III">Purok III</option>
            <option value="Purok IV">Purok IV</option>
            <option value="Purok V">Purok V</option>
          </select>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="contact_number">Contact Number</label>
          <input type="text" id="contact_number" name="contact_number">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email">
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="term_start">Term Start *</label>
          <input type="date" id="term_start" name="term_start" required>
        </div>
        <div class="form-group">
          <label for="term_end">Term End *</label>
          <input type="date" id="term_end" name="term_end" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="notes">Notes</label>
        <textarea id="notes" name="notes" placeholder="Additional notes..."></textarea>
      </div>
      
      <div class="form-group checkbox-group">
        <input type="checkbox" id="is_active" name="is_active" checked>
        <label for="is_active">Active</label>
      </div>
      
      <div class="form-actions">
        <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Save Official
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <h2>Log Out</h2>
      <button onclick="closeLogoutModal()" class="close-btn">&times;</button>
    </div>
    
    <form style="padding: 32px;">
      <p style="margin-bottom: 24px; font-size: 16px; color: #374151;">Are you sure you want to log out?</p>
      
      <div class="form-actions">
        <button type="button" onclick="closeLogoutModal()" class="btn btn-secondary">Cancel</button>
        <button type="button" class="btn btn-primary" style="background: #dc2626; border-color: #dc2626;" onclick="document.getElementById('logoutForm').submit()">Yes, Log Out</button>
      </div>
    </form>
  </div>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<script>
// Logout Modal Functions
function openLogoutModal() {
  document.getElementById('logoutModal').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeLogoutModal() {
  document.getElementById('logoutModal').classList.remove('active');
  document.body.style.overflow = '';
}

// Modal Functions
function openModal() {
  document.getElementById('addOfficialModal').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('addOfficialModal').classList.remove('active');
  document.body.style.overflow = '';
  document.getElementById('addOfficialForm').reset();
}

// Close modal when clicking outside
document.getElementById('addOfficialModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeModal();
  }
});

// Form Submission
document.getElementById('addOfficialForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const data = Object.fromEntries(formData.entries());
  data.is_active = document.getElementById('is_active').checked;
  
  fetch('{{ route('services.officials.store') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      showAlert('success', result.message);
      closeModal();
      // Reload page after 1 second to show new official
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    } else {
      showAlert('error', 'Error adding official. Please try again.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showAlert('error', 'Error adding official. Please check your input.');
  });
});

// Alert Function
function showAlert(type, message) {
  const container = document.getElementById('alertContainer');
  const alert = document.createElement('div');
  alert.className = `alert alert-${type}`;
  alert.textContent = message;
  container.appendChild(alert);
  
  setTimeout(() => {
    alert.remove();
  }, 5000);
}

// Logout confirmation
function confirmLogout(button) {
  if (confirm('Are you sure you want to logout?')) {
    button.closest('form').submit();
  }
}
</script>

</body>
</html>
