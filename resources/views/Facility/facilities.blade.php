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
.header-icons { display: flex; gap: 15px; align-items: center; }
.icon-btn { width: 40px; height: 40px; border-radius: 50%; background: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.icon-btn:hover { background: #f5f5f5; transform: translateY(-2px); }
.icon-btn i { color: #333; font-size: 16px; }

/* Add Facility Button */
.btn-add {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    font-size: 15px;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-add:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.btn-add i {
    font-size: 16px;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1000;
    display: none;
    backdrop-filter: blur(5px);
}

.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 16px;
    padding: 30px;
    z-index: 1001;
    max-height: 90vh;
    overflow-y: auto;
    width: 90%;
    max-width: 600px;
    display: none;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.modal::-webkit-scrollbar {
    width: 6px;
}

.modal::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.modal::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.modal::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.modal-header {
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 20px;
    margin-bottom: 25px;
}

.modal-header button:hover {
    background: #f0f0f0;
    transform: rotate(90deg);
}

input:focus, textarea:focus, select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar { width: 70px; }
  .logo span, .nav-item span { display: none; }
  .main-content { margin-left: 70px; padding: 20px; }
  
  .modal {
    width: 95%;
    padding: 20px;
    margin: 10px;
  }
  
  .btn-add {
    padding: 10px 16px;
    font-size: 14px;
  }
}
.container { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

.facility-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
.facility-card { background: #f8f9fa; border-radius: 12px; padding: 20px; border: 2px solid #e9ecef; transition: all 0.3s ease; position: relative; }
.facility-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #1a1a2e; }
.facility-icon { font-size: 48px; color: #1a1a2e; margin-bottom: 15px; }
.facility-title { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
.facility-description { font-size: 14px; color: #666; line-height: 1.6; }
.facility-status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-top: 10px; }

.action-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.edit-btn:hover {
    background: #2563eb !important;
}

.delete-btn:hover {
    background: #dc2626 !important;
}
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
    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
      <h1>Facility Management</h1>
      <button class="btn-add" onclick="openAddFacilityModal()">
        <i class="fas fa-plus"></i>
        Add Facility
      </button>
    </div>
  </div>

  <div class="container">
    <h2 style="margin-bottom: 20px; color: #1a1a2e;">Available Facilities</h2>
    
    <div class="facility-grid">
      @forelse($facilities as $facility)
        <div class="facility-card" style="text-decoration: none; color: inherit; cursor: pointer; position: relative;">
          <div class="facility-icon"><i class="{{ $facility->icon }}"></i></div>
          <div class="facility-title">{{ $facility->name }}</div>
          <div class="facility-description">{{ $facility->description }}</div>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
            <span class="facility-status" style="background: {{ $facility->status_color }}; color: {{ $facility->status_text_color }};">
              {{ $facility->status_label }}
            </span>
            <span class="facility-capacity" style="font-size: 14px; color: #555; font-weight: 600;">
                <i class="fas fa-users" style="margin-right: 5px; color: #3b82f6;"></i>
                Capacity: {{ $facility->capacity ?? 'N/A' }}
            </span>
          </div>
          <div class="facility-actions" style="display: flex; gap: 8px; opacity: 1; transition: all 0.3s ease; margin-top: 10px;">
            <button onclick="editFacility({{ $facility->id }})" class="action-btn edit-btn" title="Edit Facility" style="background: #3b82f6; color: white; border: none; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;">
              <i class="fas fa-edit" style="font-size: 12px;"></i>
            </button>
            <button onclick="deleteFacility({{ $facility->id }}, '{{ $facility->name }}')" class="action-btn delete-btn" title="Delete Facility" style="background: #ef4444; color: white; border: none; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;">
              <i class="fas fa-trash" style="font-size: 12px;"></i>
            </button>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
          <i class="fas fa-building" style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;"></i>
          <h3 style="margin-bottom: 10px; color: #333;">No Facilities Yet</h3>
          <p>Click the "Add Facility" button to add your first facility.</p>
        </div>
      @endforelse

      <!-- Keep existing hardcoded facilities as fallback -->
      @if($facilities->count() === 0)
        <a href="{{ route('school') }}" class="facility-card" style="text-decoration: none; color: inherit;">
          <div class="facility-icon"><i class="fas fa-school"></i></div>
          <div class="facility-title">Schools</div>
          <div class="facility-description">For Evacuation and Emergency Response</div>
          <span class="facility-status status-available">Available</span>
        </a>
      @endif
    </div>
  </div>
</div>

<!-- Add Facility Modal -->
<div class="modal-overlay" id="facilityModalOverlay" style="display: none;"></div>
<div class="modal" id="facilityModal" style="display: none; max-width: 600px;">
    <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0; color: #1e293b; font-size: 24px; font-weight: 700;">Add New Facility</h2>
        <button type="button" onclick="closeFacilityModal()" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #666; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;">&times;</button>
    </div>
    
    <form id="facilityForm" onsubmit="submitFacility(event)">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Facility Name</label>
            <input type="text" id="facilityName" name="name" required style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s ease;" placeholder="Enter facility name">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Status</label>
            <select id="facilityStatus" name="status" required style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; background: white; transition: all 0.3s ease;">
                <option value="">Select status...</option>
                <option value="available">Available</option>
                <option value="maintenance">Under Maintenance</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Capacity</label>
            <input type="number" id="facilityCapacity" name="capacity" required min="1" style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s ease;" placeholder="Enter evacuation area capacity">
        </div>
        
        <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <button type="button" onclick="closeFacilityModal()" style="background: #f8f9fa; border: 2px solid #e5e7eb; color: #333; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 15px; transition: all 0.3s ease;">Cancel</button>
            <button type="submit" class="btn-add" style="padding: 12px 28px;">
                <i class="fas fa-save"></i>
                Save Facility
            </button>
        </div>
    </form>
</div>

<!-- Edit Facility Modal -->
<div class="modal-overlay" id="editFacilityModalOverlay" style="display: none;"></div>
<div class="modal" id="editFacilityModal" style="display: none; max-width: 600px;">
    <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0; color: #1e293b; font-size: 24px; font-weight: 700;">Edit Facility</h2>
        <button type="button" onclick="closeEditFacilityModal()" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #666; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;">&times;</button>
    </div>
    
    <form id="editFacilityForm" onsubmit="updateFacility(event)">
        @csrf
        <input type="hidden" id="editFacilityId" name="id">
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Facility Name</label>
            <input type="text" id="editFacilityName" name="name" required style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s ease;" placeholder="Enter facility name">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Status</label>
            <select id="editFacilityStatus" name="status" required style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; background: white; transition: all 0.3s ease;">
                <option value="">Select status...</option>
                <option value="available">Available</option>
                <option value="maintenance">Under Maintenance</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Capacity</label>
            <input type="number" id="editFacilityCapacity" name="capacity" required min="1" style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s ease;" placeholder="Enter evacuation area capacity">
        </div>
        
        <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <button type="button" onclick="closeEditFacilityModal()" style="background: #f8f9fa; border: 2px solid #e5e7eb; color: #333; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 15px; transition: all 0.3s ease;">Cancel</button>
            <button type="submit" class="btn-add" style="padding: 12px 28px;">
                <i class="fas fa-save"></i>
                Update Facility
            </button>
        </div>
    </form>
</div>

<script>
function confirmLogout(button) {
  if (confirm('Are you sure you want to logout?')) {
    button.closest('form').submit();
  }
}

// Facility Modal Functions
function openAddFacilityModal() {
    document.getElementById('facilityModalOverlay').style.display = 'block';
    document.getElementById('facilityModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Reset form
    document.getElementById('facilityForm').reset();
}

function closeFacilityModal() {
    document.getElementById('facilityModalOverlay').style.display = 'none';
    document.getElementById('facilityModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function submitFacility(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    submitBtn.disabled = true;
    
    // Send AJAX request
    fetch('/facilities', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showSuccessMessage('Facility added successfully!');
            
            // Close modal and reset form
            closeFacilityModal();
            
            // Optionally refresh the page or add the new facility to the grid
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            // Show validation errors
            let errorMessage = 'Please fix the following errors:\n';
            for (const [field, errors] of Object.entries(data.errors)) {
                errorMessage += `\n• ${errors.join(', ')}`;
            }
            alert(errorMessage);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the facility. Please try again.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function showSuccessMessage(message) {
    const successDiv = document.createElement('div');
    successDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        z-index: 2000;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideIn 0.3s ease;
    `;
    successDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    
    document.body.appendChild(successDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        successDiv.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            successDiv.remove();
        }, 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Close modal when clicking overlay
document.getElementById('facilityModalOverlay').addEventListener('click', closeFacilityModal);

// Edit Facility Function
function editFacility(facilityId) {
    // Fetch facility data from server
    fetch(`/facilities/${facilityId}/edit`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Populate edit form with facility data
            document.getElementById('editFacilityId').value = data.facility.id;
            document.getElementById('editFacilityName').value = data.facility.name;
            document.getElementById('editFacilityStatus').value = data.facility.status;
            document.getElementById('editFacilityCapacity').value = data.facility.capacity || '';
            
            // Store initial values for change detection
            window.initialEditValues = {
                name: data.facility.name,
                status: data.facility.status,
                capacity: data.facility.capacity || ''
            };
            
            // Initially disable the update button
            const updateBtn = document.querySelector('#editFacilityForm button[type="submit"]');
            updateBtn.disabled = true;
            updateBtn.style.opacity = '0.5';
            updateBtn.style.cursor = 'not-allowed';
            
            // Add change listeners
            addEditFormListeners();
            
            // Open edit modal
            document.getElementById('editFacilityModalOverlay').style.display = 'block';
            document.getElementById('editFacilityModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        } else {
            alert('Error: ' + (data.message || 'Failed to load facility data'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while loading facility data. Please try again.');
    });
}

// Add change listeners to edit form
function addEditFormListeners() {
    const nameInput = document.getElementById('editFacilityName');
    const statusSelect = document.getElementById('editFacilityStatus');
    const capacityInput = document.getElementById('editFacilityCapacity');
    const updateBtn = document.querySelector('#editFacilityForm button[type="submit"]');
    
    function checkForChanges() {
        const hasChanges = 
            nameInput.value !== window.initialEditValues.name ||
            statusSelect.value !== window.initialEditValues.status ||
            capacityInput.value !== window.initialEditValues.capacity;
        
        // Enable/disable button based on changes
        if (hasChanges) {
            updateBtn.disabled = false;
            updateBtn.style.opacity = '1';
            updateBtn.style.cursor = 'pointer';
        } else {
            updateBtn.disabled = true;
            updateBtn.style.opacity = '0.5';
            updateBtn.style.cursor = 'not-allowed';
        }
    }
    
    // Add input event listeners
    nameInput.addEventListener('input', checkForChanges);
    statusSelect.addEventListener('change', checkForChanges);
    capacityInput.addEventListener('input', checkForChanges);
}

// Close Edit Facility Modal
function closeEditFacilityModal() {
    document.getElementById('editFacilityModalOverlay').style.display = 'none';
    document.getElementById('editFacilityModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Update Facility Function
function updateFacility(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const facilityId = formData.get('id');
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    submitBtn.disabled = true;
    
    // Convert FormData to object and add _method for PUT
    const formDataObj = {};
    formData.forEach((value, key) => {
        formDataObj[key] = value;
    });
    formDataObj._method = 'PUT';
    
    // Send PUT request
    fetch(`/facilities/${facilityId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formDataObj)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showSuccessMessage('Facility updated successfully!');
            
            // Close modal and reset form
            closeEditFacilityModal();
            
            // Reload page to show updated data
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            // Show validation errors
            let errorMessage = 'Please fix the following errors:\n';
            for (const [field, errors] of Object.entries(data.errors)) {
                errorMessage += `\n• ${errors.join(', ')}`;
            }
            alert(errorMessage);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the facility. Please try again.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Delete Facility Function
function deleteFacility(facilityId, facilityName) {
    if (confirm(`Are you sure you want to delete "${facilityName}"?\n\nThis action cannot be undone.`)) {
        // Show loading state
        const facilityCard = event.target.closest('.facility-card');
        facilityCard.style.opacity = '0.5';
        facilityCard.style.pointerEvents = 'none';
        
        // Send DELETE request
        fetch(`/facilities/${facilityId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                               document.querySelector('input[name="_token"]')?.value,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showSuccessMessage('Facility deleted successfully!');
                
                // Remove the facility card with animation
                facilityCard.style.transition = 'all 0.3s ease';
                facilityCard.style.transform = 'scale(0.8)';
                facilityCard.style.opacity = '0';
                
                setTimeout(() => {
                    facilityCard.remove();
                }, 300);
            } else {
                // Show error message
                alert('Error: ' + (data.message || 'Failed to delete facility'));
                // Reset the card state
                facilityCard.style.opacity = '1';
                facilityCard.style.pointerEvents = 'auto';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the facility. Please try again.');
            // Reset the card state
            facilityCard.style.opacity = '1';
            facilityCard.style.pointerEvents = 'auto';
        });
    }
}
</script>

</body>
</html>
