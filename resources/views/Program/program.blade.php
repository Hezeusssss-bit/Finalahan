<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Program Management</title>
<!-- Font Awesome -->
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

/* Container */
.container { 
    background: white; 
    border-radius: 24px; 
    padding: 40px; 
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    position: relative;
    overflow: hidden;
}

.container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8, #3b82f6);
    animation: shimmer 3s linear infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Alert */
.alert { 
    position: fixed; 
    top: 20px; 
    right: 20px; 
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); 
    color: #ffffff; 
    padding: 15px 25px; 
    border-radius: 12px; 
    font-weight: 600; 
    box-shadow: 0 8px 30px rgba(59, 130, 246, 0.3); 
    z-index: 9999; 
    opacity: 0; 
    animation: slideIn 0.5s forwards; 
}

@keyframes slideIn { 
    from { opacity: 0; transform: translateX(100px); } 
    to { opacity: 1; transform: translateX(0); } 
}

@keyframes slideOut { 
    from { opacity: 1; transform: translateX(0); } 
    to { opacity: 0; transform: translateX(100px); } 
}

.alert.hide { animation: slideOut 0.5s forwards; }

/* Program Sections */
.program-section {
    margin-bottom: 40px;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
}

.section-title {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.upcoming-icon { background: #fef3c7; color: #d97706; }
.ongoing-icon { background: #dbeafe; color: #2563eb; }
.completed-icon { background: #dcfce7; color: #16a34a; }

.program-count {
    background: #f1f5f9;
    color: #64748b;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

/* Program Cards */
.program-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.program-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.program-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
}

.program-card:hover::before {
    transform: scaleX(1);
}

.program-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.program-location {
    color: #64748b;
    font-size: 14px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.program-description {
    color: #475569;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 16px;
}

.program-dates {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    font-size: 13px;
    color: #64748b;
}

.program-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-upcoming { background: #fef3c7; color: #d97706; }
.status-ongoing { background: #dbeafe; color: #2563eb; }
.status-completed { background: #dcfce7; color: #16a34a; }

.program-actions {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-edit:hover { border-color: #3b82f6; color: #3b82f6; }
.btn-delete:hover { border-color: #ef4444; color: #ef4444; }

/* Add Program Button */
.btn-add-program {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-add-program:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

/* Modal */
.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    width: 600px;
    max-width: 90%;
    padding: 30px;
    display: none;
    z-index: 2000;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 1999;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.modal-title {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
}

.modal-close {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: #f1f5f9;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 25px;
}

.btn-cancel {
    padding: 12px 24px;
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f1f5f9;
}

.btn-submit {
    padding: 12px 24px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #64748b;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-text {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.empty-subtext {
    font-size: 14px;
    opacity: 0.7;
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
      <a href="{{ route('program.index') }}" class="nav-item active">
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
    <div style="display: flex; align-items: center; gap: 15px;">
      <a href="{{ url()->previous() }}" class="icon-btn">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h1>Program Management</h1>
    </div>
    <div class="header-icons">
      <button onclick="openAddProgramModal()" class="btn-add-program">
        <i class="fas fa-plus"></i>
        Add Program
      </button>
    </div>
  </div>

  @if(session('Success'))
    <div class="alert" id="successAlert">{{ session('Success') }}</div>
  @endif

  <div class="container">
    <!-- Upcoming Programs -->
    <div class="program-section">
      <div class="section-header">
        <div class="section-title">
          <div class="section-icon upcoming-icon">
            <i class="fas fa-clock"></i>
          </div>
          Upcoming Programs
        </div>
        <div class="program-count">{{ $upcomingPrograms->count() }} Programs</div>
      </div>
      
      @if($upcomingPrograms->count() > 0)
        <div class="program-grid">
          @foreach($upcomingPrograms as $program)
            <div class="program-card">
              <div class="program-title">{{ $program->title }}</div>
              <div class="program-location">
                <i class="fas fa-map-marker-alt"></i>
                {{ $program->location }}
              </div>
              <div class="program-description">{{ $program->description }}</div>
              <div class="program-dates">
                <span>Start: {{ $program->start_date->format('M d, Y') }}</span>
                @if($program->end_date)
                  <span>End: {{ $program->end_date->format('M d, Y') }}</span>
                @endif
              </div>
              <div class="program-status status-upcoming">
                {{ $program->getStatusLabel() }}
              </div>
              <div class="program-actions">
                <a href="#" onclick="editProgram({{ $program->id }})" class="btn-icon btn-edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('program.destroy', $program->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this program?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-icon btn-delete" style="background: none; border: none; cursor: pointer; padding: 5px; margin: 0 2px; border-radius: 4px; transition: all 0.2s;">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <div class="empty-icon">
            <i class="fas fa-calendar-plus"></i>
          </div>
          <div class="empty-text">No upcoming programs</div>
          <div class="empty-subtext">Add your first program to get started</div>
        </div>
      @endif
    </div>

    <!-- Ongoing Programs -->
    <div class="program-section">
      <div class="section-header">
        <div class="section-title">
          <div class="section-icon ongoing-icon">
            <i class="fas fa-play-circle"></i>
          </div>
          On-Going Programs
        </div>
        <div class="program-count">{{ $ongoingPrograms->count() }} Programs</div>
      </div>
      
      @if($ongoingPrograms->count() > 0)
        <div class="program-grid">
          @foreach($ongoingPrograms as $program)
            <div class="program-card">
              <div class="program-title">{{ $program->title }}</div>
              <div class="program-location">
                <i class="fas fa-map-marker-alt"></i>
                {{ $program->location }}
              </div>
              <div class="program-description">{{ $program->description }}</div>
              <div class="program-dates">
                <span>Started: {{ $program->start_date->format('M d, Y') }}</span>
                @if($program->end_date)
                  <span>Until: {{ $program->end_date->format('M d, Y') }}</span>
                @endif
              </div>
              <div class="program-status status-ongoing">
                {{ $program->getStatusLabel() }}
              </div>
              <div class="program-actions">
                <a href="#" onclick="editProgram({{ $program->id }})" class="btn-icon btn-edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('program.destroy', $program->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this program?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-icon btn-delete" style="background: none; border: none; cursor: pointer; padding: 5px; margin: 0 2px; border-radius: 4px; transition: all 0.2s;">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <div class="empty-icon">
            <i class="fas fa-hourglass-half"></i>
          </div>
          <div class="empty-text">No ongoing programs</div>
          <div class="empty-subtext">Programs will appear here when their start date arrives</div>
        </div>
      @endif
    </div>

    <!-- Completed Programs -->
    <div class="program-section">
      <div class="section-header">
        <div class="section-title">
          <div class="section-icon completed-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          Completed Programs
        </div>
        <div class="program-count">{{ $completedPrograms->count() }} Programs</div>
      </div>
      
      @if($completedPrograms->count() > 0)
        <div class="program-grid">
          @foreach($completedPrograms as $program)
            <div class="program-card">
              <div class="program-title">{{ $program->title }}</div>
              <div class="program-location">
                <i class="fas fa-map-marker-alt"></i>
                {{ $program->location }}
              </div>
              <div class="program-description">{{ $program->description }}</div>
              <div class="program-dates">
                <span>Completed: {{ $program->end_date ? $program->end_date->format('M d, Y') : $program->start_date->format('M d, Y') }}</span>
              </div>
              <div class="program-status status-completed">
                {{ $program->getStatusLabel() }}
              </div>
              <div class="program-actions">
                <a href="#" onclick="editProgram({{ $program->id }})" class="btn-icon btn-edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('program.destroy', $program->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this program?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-icon btn-delete" style="background: none; border: none; cursor: pointer; padding: 5px; margin: 0 2px; border-radius: 4px; transition: all 0.2s;">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <div class="empty-icon">
            <i class="fas fa-flag-checkered"></i>
          </div>
          <div class="empty-text">No completed programs</div>
          <div class="empty-subtext">Completed programs will appear here</div>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Add Program Modal -->
<div class="modal-overlay" id="addProgramOverlay" onclick="closeAddProgramModal()"></div>
<div class="modal" id="addProgramModal">
  <div class="modal-header">
    <h3 class="modal-title">Add New Program</h3>
    <button onclick="closeAddProgramModal()" class="modal-close">
      <i class="fas fa-times"></i>
    </button>
  </div>
  
  <form action="{{ route('program.store') }}" method="POST" id="programForm">
    @csrf
    <div class="form-group">
      <label class="form-label">Program Title *</label>
      <select name="title" class="form-input" required id="programTitleSelect">
        <option value="">Select a program type...</option>
        <option value="Medical Mission">Medical Mission</option>
        <option value="Clean-up Drive">Clean-up Drive</option>
        <option value="Youth Sports League">Youth Sports League</option>
        <option value="Disaster Preparedness Training">Disaster Preparedness Training</option>
        <option value="Senior Citizens Outreach">Senior Citizens Outreach</option>
        <option value="Food Distribution Program">Food Distribution Program</option>
        <option value="Health and Wellness Campaign">Health and Wellness Campaign</option>
        <option value="Educational Assistance Program">Educational Assistance Program</option>
        <option value="Infrastructure Development">Infrastructure Development</option>
        <option value="Environmental Protection">Environmental Protection</option>
        <option value="Community Building Activity">Community Building Activity</option>
        <option value="Livelihood Training Program">Livelihood Training Program</option>
        <option value="Others">Others</option>
      </select>
    </div>
    
    <div class="form-group" id="customProgramGroup" style="display: none;">
      <label class="form-label">Custom Program Name *</label>
      <input type="text" name="custom_title" class="form-input" id="customProgramInput" placeholder="Enter custom program name...">
    </div>
    
    <div class="form-group">
      <label class="form-label">Purok (Optional)</label>
      <select name="location" class="form-input">
        <option value="">Select a Purok...</option>
        <option value="Purok I">Purok I</option>
        <option value="Purok II">Purok II</option>
        <option value="Purok III">Purok III</option>
        <option value="Purok IV">Purok IV</option>
        <option value="Purok V">Purok V</option>
      </select>
    </div>
    
    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-input form-textarea" placeholder="Describe the program details..."></textarea>
    </div>
    
    <div class="form-group">
      <label class="form-label">Start Date *</label>
      <input type="date" name="start_date" class="form-input" required>
    </div>
    
    <div class="form-group">
      <label class="form-label">End Date (Optional)</label>
      <input type="date" name="end_date" class="form-input">
    </div>
    
    <div class="modal-footer">
      <button type="button" onclick="closeAddProgramModal()" class="btn-cancel">Cancel</button>
      <button type="submit" class="btn-submit" id="submitBtn" onclick="console.log('Form submitted - Action:', document.querySelector('#programForm').action); console.log('Method field:', document.querySelector('#programForm input[name="_method"]?.value);">Add Program</button>
    </div>
  </form>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal-overlay" id="logoutModalOverlay" onclick="closeLogoutModal()"></div>
<div class="modal" id="logoutModal">
  <div class="modal-header">
    <h3 class="modal-title">Log Out</h3>
    <button onclick="closeLogoutModal()" class="modal-close">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to log out?</p>
  </div>
  <div class="modal-footer">
    <button type="button" onclick="closeLogoutModal()" class="btn-cancel">Cancel</button>
    <button type="button" class="btn-submit" style="background: #dc2626;" onclick="document.getElementById('logoutForm').submit()">Yes, Log Out</button>
  </div>
</div>

<script>
function openLogoutModal() {
    document.getElementById('logoutModal').style.display = 'block';
    document.getElementById('logoutModalOverlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
    document.getElementById('logoutModalOverlay').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Modal functions
function openAddProgramModal() {
    // Reset modal to add mode
    document.querySelector('#addProgramModal .modal-title').textContent = 'Add New Program';
    document.querySelector('#addProgramModal form').action = '{{ route("program.store") }}';
    document.getElementById('submitBtn').textContent = 'Add Program';
    
    // Remove method field if exists
    let methodField = document.querySelector('#addProgramModal form input[name="_method"]');
    if (methodField) {
        methodField.remove();
    }
    
    // Reset form
    document.querySelector('#addProgramModal form').reset();
    
    document.getElementById('addProgramModal').style.display = 'block';
    document.getElementById('addProgramOverlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function openEditProgramModal() {
    // This function is called after editProgram has set up the modal
    document.getElementById('addProgramModal').style.display = 'block';
    document.getElementById('addProgramOverlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeAddProgramModal() {
    document.getElementById('addProgramModal').style.display = 'none';
    document.getElementById('addProgramOverlay').style.display = 'none';
    document.body.style.overflow = 'auto';
    
    // Reset to add mode when closing
    document.querySelector('#addProgramModal .modal-title').textContent = 'Add New Program';
    document.querySelector('#addProgramModal form').action = '{{ route("program.store") }}';
    document.getElementById('submitBtn').textContent = 'Add Program';
    
    // Remove method field if exists
    let methodField = document.querySelector('#addProgramModal form input[name="_method"]');
    if (methodField) {
        methodField.remove();
    }
    
    // Reset form
    document.querySelector('#addProgramModal form').reset();
}

// Alert auto-hide
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.classList.add('hide');
        setTimeout(() => alert.remove(), 500);
    }
}, 5000);

// Program actions
function editProgram(id) {
    // Fetch program data from API
    fetch(`/program/${id}`)
        .then(response => response.json())
        .then(program => {
            // Populate edit modal fields
            document.querySelector('#addProgramModal .modal-title').textContent = 'Edit Program';
            document.querySelector('#addProgramModal form').action = `/program/${id}`;
            document.getElementById('submitBtn').textContent = 'Update Program';
            
            // Add method field for PUT request
            let methodField = document.querySelector('#addProgramModal form input[name="_method"]');
            if (!methodField) {
                methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                document.querySelector('#addProgramModal form').appendChild(methodField);
            }
            methodField.value = 'PUT';
            
            // Populate form fields
            document.querySelector('select[name="title"]').value = program.title;
            document.querySelector('select[name="location"]').value = program.location || '';
            document.querySelector('textarea[name="description"]').value = program.description || '';
            
            // Format dates for input fields (YYYY-MM-DD format)
            if (program.start_date) {
                const startDate = new Date(program.start_date);
                document.querySelector('input[name="start_date"]').value = startDate.toISOString().split('T')[0];
            }
            
            if (program.end_date) {
                const endDate = new Date(program.end_date);
                document.querySelector('input[name="end_date"]').value = endDate.toISOString().split('T')[0];
            } else {
                document.querySelector('input[name="end_date"]').value = '';
            }
            
            openEditProgramModal();
        })
        .catch(error => {
            console.error('Error fetching program:', error);
            alert('Error loading program data. Please try again.');
        });
}

// Remove old placeholder functions
function deleteProgram(id) {
    // This function is no longer needed as we use form submission
}

function confirmLogout(button) {
    if (confirm('Are you sure you want to logout?')) {
        button.closest('form').submit();
    }
}

// Auto-update statuses every minute
setInterval(() => {
    fetch('/program/update-statuses', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Statuses updated:', data.message);
        // Optionally refresh the page or update the UI
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error updating statuses:', error);
    });
}, 60000); // Update every minute

// Handle Program Title dropdown change
document.addEventListener('DOMContentLoaded', function() {
    const programTitleSelect = document.getElementById('programTitleSelect');
    const customProgramGroup = document.getElementById('customProgramGroup');
    const customProgramInput = document.getElementById('customProgramInput');
    
    if (programTitleSelect && customProgramGroup) {
        programTitleSelect.addEventListener('change', function() {
            if (this.value === 'Others') {
                customProgramGroup.style.display = 'block';
                customProgramInput.required = true;
            } else {
                customProgramGroup.style.display = 'none';
                customProgramInput.required = false;
                customProgramInput.value = '';
            }
        });
        
        // Handle form submission to use custom title if "Others" is selected
        const programForm = document.getElementById('programForm');
        if (programForm) {
            programForm.addEventListener('submit', function(e) {
                if (programTitleSelect.value === 'Others' && customProgramInput.value.trim()) {
                    // Create a hidden input for the custom title
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'title';
                    hiddenInput.value = customProgramInput.value.trim();
                    
                    // Replace the original title select value
                    programTitleSelect.name = 'title_original';
                    programTitleSelect.removeAttribute('required');
                    
                    programForm.appendChild(hiddenInput);
                }
            });
        }
    }
});
</script>

</body>
</html>
