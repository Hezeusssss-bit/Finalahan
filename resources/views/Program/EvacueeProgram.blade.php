<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Evacuee Program</title>
<!-- Font Awesome -->
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
.header-icons { display: flex; gap: 12px; align-items: center; }
.icon-btn { width: 40px; height: 40px; border-radius: 50%; background: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.icon-btn i { color: #333; font-size: 16px; }
.icon-btn:hover { background: #f5f5f5; transform: translateY(-2px); }

/* Back button */
.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 999px; border: 1px solid #e5e7eb; background: #fff; color: #1a1a2e; text-decoration: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform .15s ease, box-shadow .15s ease, background .15s ease; font-weight: 600; font-size: 14px; }
.btn-back:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); background:#f9fafb; }
.btn-back i { font-size: 14px; color:#1a1a2e; }

/* Container */
.container { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

/* Toolbar */
.toolbar { display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-top:20px; }
.toolbar .select, .toolbar .search { border:1px solid #e5e7eb; background:#fff; color:#1a1a2e; border-radius:10px; padding:10px 12px; font-size:14px; }
.toolbar .search { min-width: 240px; }
.btn { display:inline-flex; align-items:center; gap:8px; padding:8px 14px; border-radius:12px; border:1px solid #e5e7eb; text-decoration:none; font-weight:800; font-size:12px; text-transform:uppercase; letter-spacing:1px; }
.btn.add { background:#e9ecef; color:#1a1a2e; }
.btn.export { background:#17002B; color:#fff; border-color:#17002B; }
.btn.export i { font-size:13px; }

/* Table */
.table-wrap { margin-top:16px; border:1px solid #eee; border-radius:12px; overflow:hidden; }
table { width:100%; border-collapse:collapse; background:#fff; }
thead th { background:#fafafa; color:#6b7280; font-size:12px; letter-spacing:0.6px; text-transform:uppercase; text-align:left; padding:14px 16px; }
tbody td { padding:14px 16px; border-top:1px solid #f1f5f9; color:#111827; font-size:14px; }
.actions { display:flex; align-items:center; gap:14px; }
.actions a { color:#6b7280; text-decoration:none; font-size:16px; }
.actions a:hover { color:#111827; }

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
  padding: 20px;
  box-sizing: border-box;
}

.modal {
  background: white;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 800px;
  max-height: 90vh;
  overflow-y: auto;
  transform: translateY(20px) scale(0.98);
  opacity: 0;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.1);
  position: relative;
  margin: 0;
  padding: 24px;
  box-sizing: border-box;
  will-change: transform, opacity;
}

.modal-overlay.active {
  opacity: 1;
  visibility: visible;
}

.modal-overlay.active .modal {
  transform: translateY(0) scale(1);
  opacity: 1;
}

/* Ensure modal is centered on all screen sizes */
@media (max-width: 768px) {
  .modal {
    width: 95%;
    max-height: 85vh;
    padding: 16px;
  }
}

/* Floating Alert */
.alert { position: fixed; top: 20px; right: 20px; background-color: #17002B; color: #ffffff; padding: 15px 25px; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px #17002B; z-index: 9999; opacity: 0; animation: slideIn 0.5s forwards; }
.alert.success { background-color: #17002B; color: #fff; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
@keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }
.alert.hide { animation: slideOut 0.5s forwards; }

/* Quick Actions Hover Effects */
.quick-action { transition: all 0.3s ease; }
.quick-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #1a1a2e !important; }

/* Analytics Cards Hover */
.analytics-card { transition: all 0.3s ease; }
.analytics-card:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }

/* Activity Item Hover */
.activity-item { transition: background 0.2s ease; }
.activity-item:hover { background: #f8f9fa; border-radius: 6px; }

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
    <a href="#" class="nav-item active"><i class="fas fa-boxes"></i><span>Evacuee Program</span></a>
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
    <div style="display: flex; align-items: center; gap: 15px;">
      <a href="{{ url()->previous() }}" class="icon-btn" style="text-decoration: none;" title="Go back">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h1>Evacuee Program</h1>
    </div>
  </div>

  <div class="container">
    <h2 style="margin-bottom:10px;color:#1a1a2e;">Static Evacuee Program Page</h2>
    <p style="color:#555;">This is a placeholder for the Evacuee Program. Replace with dynamic content and components later.</p>
    <div style="margin-top:20px; display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:16px;">
      <div class="analytics-card" style="background:#fff;border:1px solid #eee;border-radius:12px;padding:16px;">
        <div style="font-weight:700;color:#1a1a2e;margin-bottom:6px;">Total Evacuees</div>
        <div style="font-size:28px;font-weight:800;color:#17002B;">128</div>
      </div>
      <div class="analytics-card" style="background:#fff;border:1px solid #eee;border-radius:12px;padding:16px;">
        <div style="font-weight:700;color:#1a1a2e;margin-bottom:6px;">Shelters</div>
        <div style="font-size:28px;font-weight:800;color:#17002B;">6</div>
      </div>
      <div class="analytics-card" style="background:#fff;border:1px solid #eee;border-radius:12px;padding:16px;">
        <div style="font-weight:700;color:#1a1a2e;margin-bottom:6px;">Available Beds</div>
        <div style="font-size:28px;font-weight:800;color:#17002B;">72</div>
      </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
      <select class="select">
        <option>PUROK</option>
        <option>Purok I</option>
        <option>Purok II</option>
        <option>Purok III</option>
        <option>Purok IV</option>
        <option>Purok V</option>
      </select>
      <select class="select">
        <option>RESIDENTS</option>
        <option>All</option>
        <option>Heads</option>
        <option>Dependents</option>
      </select>
      <input type="text" class="search" placeholder="Search" />
      <div style="margin-left:auto; display:flex; gap:10px;">
        <a href="#" class="btn add" onclick="openAddEvacueeModal()">ADD +</a>
        <a href="#" class="btn export"><i class="fas fa-download"></i> EXPORT</a>
      </div>
    </div>

    <!-- Table -->
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Fullname</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Evacuation Status</th>
            <th>Evacuation Area</th>
            <th>Room Number</th>
            <th>Recieve Program</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>0001</td>
            <td>Juan Dela Cruz</td>
            <td>34</td>
            <td>Male</td>
            <td>Evacuated</td>
            <td>Barangay Hall</td>
            <td>Room 3B</td>
            <td>Yes</td>
            <td>
              <div class="actions">
                <a href="#" title="View"><i class="fas fa-eye"></i></a>
                <a href="#" title="Edit"><i class="fas fa-pen-to-square"></i></a>
                <a href="#" title="Delete"><i class="fas fa-trash"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="9" style="text-align:center; color:#9ca3af; padding:12px 16px; font-size:12px;">Static preview row. Replace with dynamic data later.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Evacuee Modal -->
<div class="modal-overlay" id="addEvacueeOverlay">
  <div class="modal" id="addEvacueeModal">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
      <h3 style="margin:0; color:#1a1a2e;">Add New Evacuee</h3>
      <button onclick="closeAddEvacueeModal()" class="icon-btn" aria-label="Close" style="width:36px;height:36px;"><i class="fas fa-times"></i></button>
    </div>
    
    <div style="background:#fafafa; border:1px dashed #e5e7eb; border-radius:12px; padding:20px;">
      <form id="addEvacueeForm" style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Full Name</label>
          <input type="text" name="fullname" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;" />
        </div>
        
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Age</label>
          <input type="number" name="age" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;" />
        </div>
        
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Gender</label>
          <select name="gender" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;">
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Evacuation Status</label>
          <select name="status" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;">
            <option value="" disabled selected>Select Status</option>
            <option value="Evacuated">Evacuated</option>
            <option value="Relocated">Relocated</option>
            <option value="Returned">Returned</option>
          </select>
        </div>
        
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Evacuation Area</label>
          <select name="area" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;">
            <option value="" disabled selected>Select Area</option>
            <option value="Barangay Hall">Barangay Hall</option>
            <option value="Evacuation Center 1">Evacuation Center 1</option>
            <option value="Evacuation Center 2">Evacuation Center 2</option>
            <option value="School Gym">School Gym</option>
          </select>
        </div>
        
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Room Number</label>
          <input type="text" name="room" placeholder="e.g., Room 3B" style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;" />
        </div>
        
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Purok</label>
          <select name="purok" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;">
            <option value="" disabled selected>Select Purok</option>
            <option value="Purok I">Purok I</option>
            <option value="Purok II">Purok II</option>
            <option value="Purok III">Purok III</option>
            <option value="Purok IV">Purok IV</option>
            <option value="Purok V">Purok V</option>
          </select>
        </div>
        
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Assistance Received</label>
          <select name="program_received" style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;">
            <option value="Yes">Yes</option>
            <option value="No" selected>No</option>
          </select>
        </div>
        
        <div style="grid-column: 1 / -1; display:flex; justify-content:flex-end; gap:10px; margin-top:10px;">
          <button type="button" onclick="closeAddEvacueeModal()" style="padding:10px 14px; border-radius:8px; border:1px solid #d1d5db; background:#f5f5f5; cursor:pointer; font-weight:600;">Cancel</button>
          <button type="submit" style="padding:10px 14px; border-radius:8px; border:1px solid #17002B; background:#17002B; color:white; cursor:pointer; font-weight:600;">Save Evacuee</button>
        </div>
      </form>
    

@if(session('Success'))
  <div class="alert success" id="successAlert">{{ session('Success') }}</div>
@endif

<script>
// Function to open the add evacuee modal
function openAddEvacueeModal() {
  const modal = document.getElementById('addEvacueeModal');
  const overlay = document.getElementById('addEvacueeOverlay');
  
  // Show modal and overlay with animation
  overlay.classList.add('active');
  document.body.style.overflow = 'hidden';
}

// Function to close the add evacuee modal
function closeAddEvacueeModal() {
  const overlay = document.getElementById('addEvacueeOverlay');
  overlay.classList.remove('active');
  document.body.style.overflow = 'auto';
  document.getElementById('addEvacueeForm').reset();
}

// Close modal when clicking outside
window.onclick = function(event) {
  const overlay = document.getElementById('addEvacueeOverlay');
  if (event.target === overlay) {
    closeAddEvacueeModal();
  }
}

// Handle form submission
const form = document.getElementById('addEvacueeForm');
if (form) {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    // Here you would typically send the form data to your server
    // For now, we'll just close the modal and show a success message
    closeAddEvacueeModal();
    showAlert('Evacuee added successfully!', 'success');
  });
}

// Function to show alert message
function showAlert(message, type = 'success') {
  const alertDiv = document.createElement('div');
  alertDiv.className = `alert ${type}`;
  alertDiv.textContent = message;
  document.body.appendChild(alertDiv);
  
  // Trigger reflow
  void alertDiv.offsetWidth;
  
  // Add show class
  alertDiv.style.animation = 'slideIn 0.5s forwards';
  
  // Remove alert after 3 seconds
  setTimeout(() => {
    alertDiv.style.animation = 'slideOut 0.5s forwards';
    setTimeout(() => alertDiv.remove(), 500);
  }, 3000);
}

// Auto-hide success message after 3 seconds
setTimeout(() => {
  const alert = document.getElementById('successAlert');
  if (alert) {
    alert.style.animation = 'slideOut 0.5s forwards';
    setTimeout(() => alert.remove(), 500);
  }
}, 3000);
</script>

<script>
setTimeout(()=>{
  const alert = document.getElementById('successAlert') || document.getElementById('welcomeAlert');
  if(alert){ alert.classList.add('hide'); setTimeout(()=>alert.remove(),500); }
},3000);
</script>
</body>
</html>
