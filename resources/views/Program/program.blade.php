<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Residents List</title>
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

/* Add Program button (pill) */
.btn-add { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 12px; background: #e9ecef; border: 1px solid #d1d5db; color: #1a1a2e; text-decoration: none; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; font-size: 12px; }
.btn-add:hover { background: #e5e7eb; }

/* Container */
.container { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

/* Floating Alert */
.alert { position: fixed; top: 20px; right: 20px; background-color: #17002B; color: #ffffff; padding: 15px 25px; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px #17002B; z-index: 9999; opacity: 0; animation: slideIn 0.5s forwards; }
.alert.success { background-color: #17002B; color: #fff; }
@keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }
.alert.hide { animation: slideOut 0.5s forwards; }

/* Delete & Add Modal */
.modal { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); width: 400px; max-width: 90%; padding: 30px; display: none; z-index: 2000; }
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 1999; }
.modal h2 { margin: 0 0 10px; font-size: 22px; color: #1a1a2e; }
.modal p { margin-bottom: 25px; color: #666; font-size: 15px; }
.modal-buttons { display: flex; justify-content: flex-end; gap: 10px; }
.modal-buttons button { padding: 10px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 14px; }
.btn-cancel { background: #f5f5f5; color: #333; }
.btn-cancel:hover { background: #e5e5e5; }
.btn-confirm { background: #f44336; color: #fff; }
.btn-confirm:hover { background: #d32f2f; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3); }

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
  transition: background 0.2s ease;
}
.activity-item:hover {
  background: #f8f9fa;
  border-radius: 6px;
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
  <div class="logo"><i class="fas fa-store"></i> <span>Logo</span></div>
  <nav class="nav-menu">
    <a href="{{ route('resident.index') }}" class="nav-item"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
    <a href="{{ route('program.evacuee') }}" class="nav-item "><i class="fas fa-boxes"></i><span>Evacuee Program</span></a>
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
      <a href="{{ url()->previous() }}" class="icon-btn" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h1>Program</h1>
    </div>
  </div>
  @if(session('Success'))
    <div class="alert success" id="successAlert">{{ session('Success') }}</div>
  @endif

  <div class="container">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:10px;">
      <h2 style="margin:0;color:#1a1a2e;">Community Programs</h2>
      <a href="javascript:void(0)" onclick="openAddProgramModal()" class="btn-add" title="Add Program">ADD +</a>
    </div>
    <div style="margin-top: 24px;">
      <!-- Upcoming Programs -->
      <div style="margin-bottom: 24px;">
        <h3 style="color: #1a1a2e; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 16px;">Upcoming Programs</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
          <!-- Sample Upcoming Program -->
          <div class="analytics-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
            <div style="font-weight:800;color:#17002B;font-size:18px;">Clean-up Drive</div>
            <div style="margin-top:6px;color:#555;">Location: <span style="font-weight:600;color:#1a1a2e;">Purok V</span></div>
            <div style="margin-top:6px;color:#d97706;font-weight:700;">Status: Upcoming</div>
            <p style="margin-top:10px;color:#444;">Barangay-wide clean-up activity focusing on streets and waterways.</p>
            <div style="margin-top:8px;color:#777;font-size:13px;">Starts: 2025-12-15</div>
          </div>
          <!-- Add more upcoming programs here -->
        </div>
      </div>

      <!-- Ongoing Programs -->
      <div style="margin-bottom: 24px;">
        <h3 style="color: #1a1a2e; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 16px;">Ongoing Programs</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
          <!-- Sample Ongoing Program -->
          <div class="analytics-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
            <div style="font-weight:800;color:#17002B;font-size:18px;">Youth Sports League</div>
            <div style="margin-top:6px;color:#555;">Location: <span style="font-weight:600;color:#1a1a2e;">Purok III</span></div>
            <div style="margin-top:6px;color:#2563eb;font-weight:700;">Status: Ongoing</div>
            <p style="margin-top:10px;color:#444;">Weekly sports activities for youth development and physical fitness.</p>
            <div style="margin-top:8px;color:#777;font-size:13px;">Until: 2025-12-30</div>
          </div>
          <!-- Add more ongoing programs here -->
        </div>
      </div>

      <!-- Completed Programs -->
      <div>
        <h3 style="color: #1a1a2e; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 16px;">Completed Programs</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
          <!-- Sample Completed Program -->
          <div class="analytics-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
            <div style="font-weight:800;color:#17002B;font-size:18px;">Medical Mission</div>
            <div style="margin-top:6px;color:#555;">Location: <span style="font-weight:600;color:#1a1a2e;">Purok II</span></div>
            <div style="margin-top:6px;color:#16a34a;font-weight:700;">Status: Completed</div>
            <p style="margin-top:10px;color:#444;">Basic health check-ups and free medicines were provided to residents.</p>
            <div style="margin-top:8px;color:#777;font-size:13px;">Completed: 2025-10-10</div>
          </div>
          <!-- Add more completed programs here -->
        </div>
      </div>
    </div>
  </div>

<!-- Add Program Modal -->
<div class="modal-overlay" id="addProgramOverlay"></div>
<div class="modal" id="addProgramModal" style="max-width: 980px; width: 95%;">
  <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
    <h3 style="margin:0; color:#1a1a2e;">Add Program</h3>
    <button onclick="closeAddProgramModal()" class="icon-btn" aria-label="Close" style="width:36px;height:36px;"><i class="fas fa-times"></i></button>
  </div>
  <div style="display:grid; grid-template-columns: 1fr; gap:20px;">
    <div style="background:#fafafa; border:1px dashed #e5e7eb; border-radius:12px; padding:16px;">
      <div style="margin-bottom:10px; color:#1a1a2e; font-weight:700;">New Program (static prototype)</div>
      <div style="display:flex; flex-direction:column; gap:10px;">
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Title</label>
          <input type="text" placeholder="e.g., Medical Mission" style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;" />
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Location</label>
          <select name="location" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;">
            <option value="" disabled selected>Select Purok</option>
            <option value="Purok I">Purok I</option>
            <option value="Purok II">Purok II</option>
            <option value="Purok III">Purok III</option>
            <option value="Purok IV">Purok IV</option>
            <option value="Purok V">Purok V</option>
          </select>
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Status</label>
          <select style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;">
            <option>Upcoming</option>
            <option>Ongoing</option>
            <option>Completed</option>
          </select>
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Description</label>
          <textarea rows="4" placeholder="Short description..." style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;"></textarea>
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label>Date</label>
          <input type="date" style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;" />
        </div>
        <div>
          <button type="button" style="padding:10px 14px; border-radius:10px; border:1px solid #d1d5db; background:#e9ecef; font-weight:700;">Save (static)</button>
        </div>
      </div>
    </div>
  </div>
  <div style="margin-top:12px; text-align:right;">
    <button onclick="closeAddProgramModal()" class="btn-cancel" style="padding:10px 14px;">Close</button>
  </div>
  
</div>

<script>
setTimeout(()=>{
  const alert = document.getElementById('successAlert') || document.getElementById('welcomeAlert');
  if(alert){ alert.classList.add('hide'); setTimeout(()=>alert.remove(),500); }
},3000);

function openAddProgramModal(){
  const overlay = document.getElementById('addProgramOverlay');
  const modal = document.getElementById('addProgramModal');
  if(overlay) overlay.style.display = 'block';
  if(modal) modal.style.display = 'block';
}

function closeAddProgramModal(){
  const overlay = document.getElementById('addProgramOverlay');
  const modal = document.getElementById('addProgramModal');
  if(overlay) overlay.style.display = 'none';
  if(modal) modal.style.display = 'none';
}

document.getElementById('addProgramOverlay')?.addEventListener('click', closeAddProgramModal);
</script>
</body>
</html>
