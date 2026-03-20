<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>Evacuee Program</title>

<!-- Font Awesome -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

* { margin: 0; padding: 0; box-sizing: border-box; }

body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: #f5f5f5; min-height: 100vh; margin: 0; }






/* Main Content */

.main-content { flex: 1; padding: 30px 40px; }



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


</style>

</head>

<body>



<!-- Main Content -->

<div class="main-content">

  <div class="header">

    <div style="display: flex; align-items: center; gap: 15px;">

      <a href="{{ route('resident.index') }}" class="icon-btn" style="text-decoration: none;" title="Go back">

        <i class="fas fa-arrow-left"></i>

      </a>

      <h1> Total Evacuees</h1>

    </div>

  </div>



  <div class="container">

    <h2 style="margin-bottom:10px;color:#1a1a2e;">Evacuee Management</h2>

    <p style="color:#555;">Manage evacuees, track shelter capacity, and monitor evacuation status.</p>

    <div style="margin-top:20px; display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:16px;">

      <div class="analytics-card" style="background:#fff;border:1px solid #eee;border-radius:12px;padding:16px;">

        <div style="font-weight:700;color:#1a1a2e;margin-bottom:6px;">Total Evacuees</div>

        <div style="font-size:28px;font-weight:800;color:#17002B;">{{ $totalEvacuees }}</div>

      </div>

      <div class="analytics-card" style="background:#fff;border:1px solid #eee;border-radius:12px;padding:16px;">

        <div style="font-weight:700;color:#1a1a2e;margin-bottom:6px;">Shelters</div>

        <div style="font-size:28px;font-weight:800;color:#17002B;">{{ $totalShelters }}</div>

      </div>

    </div>



    <!-- Toolbar -->

    <div class="toolbar">

      <select class="select">

        <option>EVACUATION AREA</option>

        @forelse($facilities as $facility)
          <option>{{ $facility->name }}</option>
        @empty
          <option>Purok I</option>
          <option>Purok II</option>
          <option>Purok III</option>
          <option>Purok IV</option>
          <option>Purok V</option>
        @endforelse

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

        <a href="#" class="btn export" onclick="showExportPreview()"><i class="fas fa-download"></i> EXPORT</a>

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

            <th>Evacuation Date</th>

            <th>Action</th>

          </tr>

        </thead>

        <tbody>
          @if($evacuees->count() > 0)
            @foreach($evacuees as $evacuee)
              <tr>
                <td>{{ str_pad($evacuee['id'], 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $evacuee['fullname'] }}</td>
                <td>{{ $evacuee['age'] }}</td>
                <td>{{ $evacuee['gender'] }}</td>
                <td>{{ $evacuee['evacuation_status'] }}</td>
                <td>{{ $evacuee['evacuation_area'] }}</td>
                <td>{{ $evacuee['room_number'] ?? '-' }}</td>
                <td>{{ $evacuee['evacuation_date'] }}</td>
                <td>
                  <div class="actions">
                    <a href="#" title="View"><i class="fas fa-eye"></i></a>
                    <a href="#" title="Edit"><i class="fas fa-pen-to-square"></i></a>
                    <a href="#" title="Delete"><i class="fas fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="9" style="text-align:center; color:#9ca3af; padding:12px 16px; font-size:12px;">No evacuees found. Add evacuees to see them here.</td>
            </tr>
          @endif
        </tbody>

      </table>

    </div>

  </div>

</div>



<!-- Export Preview Modal -->

<div class="modal-overlay" id="exportPreviewOverlay">

  <div class="modal" id="exportPreviewModal">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">

      <h3 style="margin:0; color:#1a1a2e;">Export Evacuees Data</h3>

      <button onclick="closeExportPreviewModal()" class="icon-btn" aria-label="Close" style="width:36px;height:36px;"><i class="fas fa-times"></i></button>

    </div>

    

    <div style="background:#fafafa; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:20px;">

      <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">

        <div style="background:#17002B; color:#fff; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center;">

          <i class="fas fa-file-csv"></i>

        </div>

        <div>

          <div style="font-weight:600; color:#1a1a2e; font-size:16px;">CSV Export Summary</div>

          <div style="color:#6b7280; font-size:14px;">Preview of data to be exported</div>

        </div>

      </div>

      

      <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:15px; margin-bottom:15px;">

        <div style="text-align:center; padding:15px; background:#fff; border-radius:8px; border:1px solid #e5e7eb;">

          <div id="totalEvacueesCount" style="font-size:24px; font-weight:700; color:#17002B;">0</div>

          <div style="font-size:12px; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Total Evacuees</div>

        </div>

        <div style="text-align:center; padding:15px; background:#fff; border-radius:8px; border:1px solid #e5e7eb;">

          <div id="totalSheltersCount" style="font-size:24px; font-weight:700; color:#17002B;">0</div>

          <div style="font-size:12px; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Shelters</div>

        </div>

      </div>

      

      <div style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:15px;">

        <div style="font-weight:600; color:#1a1a2e; margin-bottom:10px; font-size:14px;">Data Fields Included:</div>

        <div style="display:flex; flex-wrap:wrap; gap:8px;">

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">ID</span>

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Fullname</span>

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Age</span>

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Gender</span>

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Evacuation Status</span>

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Evacuation Area</span>

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Room Number</span>

          <span style="background:#f3f4f6; color:#374151; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Evacuation Date</span>

        </div>

      </div>

    </div>

    

    <div style="display:flex; justify-content:flex-end; gap:10px;">

      <button type="button" onclick="closeExportPreviewModal()" style="padding:10px 14px; border-radius:8px; border:1px solid #d1d5db; background:#f5f5f5; cursor:pointer; font-weight:600;">Cancel</button>

      <button type="button" onclick="proceedWithExport()" style="padding:10px 14px; border-radius:8px; border:1px solid #17002B; background:#17002B; color:white; cursor:pointer; font-weight:600; display:flex; align-items:center; gap:8px;">

        <i class="fas fa-download"></i> Download CSV

      </button>

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

      <form id="addEvacueeForm" method="POST" action="{{ route('program.evacuee.store') }}" style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
        @csrf

        <div style="display:flex; flex-direction:column; gap:6px;">

          <label>Purok <span style="color:#dc2626">*</span></label>

          <select id="purokSelect" name="purok" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;" onchange="loadResidentsByPurok()">

            <option value="" disabled selected>Select Purok</option>

            <option value="Purok I">Purok I</option>

            <option value="Purok II">Purok II</option>

            <option value="Purok III">Purok III</option>

            <option value="Purok IV">Purok IV</option>

            <option value="Purok V">Purok V</option>

          </select>

        </div>

        

        <div style="display:flex; flex-direction:column; gap:6px;">

          <label>Evacuation Status <span style="color:#dc2626">*</span></label>

          <select name="status" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;">

            <option value="" disabled selected>Select Status</option>

            <option value="Evacuated">Evacuated</option>

            <option value="Relocated">Relocated</option>

            <option value="Returned">Returned</option>

          </select>

        </div>

        

        <div style="display:flex; flex-direction:column; gap:6px;">

          <label>Evacuation Area <span style="color:#dc2626">*</span></label>

          <select name="area" id="evacuationAreaSelect" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;" onchange="loadFacilityCapacity()">

            <option value="" disabled selected>Select Area</option>

            @forelse($facilities as $facility)
              <option value="{{ $facility->name }}">{{ $facility->name }}</option>
            @empty
              <option value="Barangay Hall">Barangay Hall</option>
              <option value="Evacuation Center 1">Evacuation Center 1</option>
              <option value="Evacuation Center 2">Evacuation Center 2</option>
              <option value="School Gym">School Gym</option>
            @endforelse

          </select>

          <!-- Capacity Display -->
          <div id="capacityDisplay" style="display:none; margin-top:8px; padding:8px; border-radius:6px; font-size:12px;">
            
          </div>

        </div>

        

        <div style="display:flex; flex-direction:column; gap:6px;">

          <label>Room Number</label>

          <input type="text" name="room" placeholder="e.g., Room 3B" style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px;" />

        </div>

        

        <div style="display:flex; flex-direction:column; gap:6px;">

          <label>Evacuation Date</label>

          <input type="date" name="evacuation_date" required style="border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; width:100%;" />

        </div>

        

        <!-- Residents Preview Section -->

        <div id="residentsPreview" style="grid-column: 1 / -1; display:none; margin-top:10px;">

          <div style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:15px;">

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">

              <label style="font-weight:600; color:#1a1a2e;">Residents to be Added:</label>

              <span id="residentCount" style="background:#17002B; color:#fff; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600;">0 residents</span>

            </div>

            <div id="residentsList" style="max-height:150px; overflow-y:auto;">

              <!-- Residents will be listed here -->

            </div>

          </div>

        </div>

        

        <input type="hidden" id="residentsData" name="residents_data" />

        

        <div style="grid-column: 1 / -1; display:flex; justify-content:flex-end; gap:10px; margin-top:10px;">

          <button type="button" onclick="closeAddEvacueeModal()" style="padding:10px 14px; border-radius:8px; border:1px solid #d1d5db; background:#f5f5f5; cursor:pointer; font-weight:600;">Cancel</button>

          <button type="submit" id="saveBtn" style="padding:10px 14px; border-radius:8px; border:1px solid #17002B; background:#17002B; color:white; cursor:pointer; font-weight:600;" disabled>Save Evacuees</button>

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

  

  // Auto-fill evacuation date with today's date

  const today = new Date().toISOString().split('T')[0];

  const evacuationDateInput = document.querySelector('input[name="evacuation_date"]');

  if (evacuationDateInput) {

    evacuationDateInput.value = today;

  }

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



// Logout confirmation function

function confirmLogout(button) {

  if (confirm('Are you sure you want to logout?')) {

    button.closest('form').submit();

  }

}



// Store fetched residents

let currentResidents = [];

let allResidentsByPurok = {};



// Load residents by selected purok

function loadResidentsByPurok() {

  const purokSelect = document.getElementById('purokSelect');

  const residentsPreview = document.getElementById('residentsPreview');

  const residentsList = document.getElementById('residentsList');

  const residentCount = document.getElementById('residentCount');

  const residentsData = document.getElementById('residentsData');

  const saveBtn = document.getElementById('saveBtn');

  

  const selectedPurok = purokSelect.value;

  

  if (!selectedPurok) {

    residentsPreview.style.display = 'none';

    saveBtn.disabled = true;

    currentResidents = [];

    return;

  }

  

  // Show loading state

  residentsList.innerHTML = '<div style="padding:20px; text-align:center; color:#6b7280;"><i class="fas fa-spinner fa-spin"></i> Loading residents...</div>';

  residentsPreview.style.display = 'block';

  

  // Fetch residents from database

  fetch(`/api/residents/by-purok?purok=${encodeURIComponent(selectedPurok)}`)

    .then(response => response.json())

    .then(data => {

      // When filtering by specific Purok, data comes as { "residents": [...] }

      currentResidents = data.residents || [];

      

      // Display residents

      residentsList.innerHTML = '';

      if (currentResidents.length > 0) {

        currentResidents.forEach(resident => {

          const item = document.createElement('div');

          item.style.cssText = 'padding:8px 0; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;';

          // Add visual indicator for evacuation status

          const statusIndicator = resident.is_evacuated ? 

            '<span style="color:#dc2626; font-size:11px; margin-left:8px;"><i class="fas fa-exclamation-triangle"></i> Already Evacuated</span>' : 

            '<span style="color:#16a34a; font-size:11px; margin-left:8px;"><i class="fas fa-check-circle"></i> Available</span>';

          item.innerHTML = `

            <span style="font-size:14px; color:#374151;">${resident.name} ${resident.qty ? resident.qty : ''} <span style="color:#6b7280; font-size:12px;">(${resident.age} yrs, ${resident.gender})</span></span>

            ${statusIndicator}

          `;

          residentsList.appendChild(item);

        });

        

        residentCount.textContent = `${currentResidents.length} resident${currentResidents.length > 1 ? 's' : ''}`;

        residentsData.value = JSON.stringify(currentResidents);

        saveBtn.disabled = false;

      } else {

        residentsList.innerHTML = '<div style="padding:20px; text-align:center; color:#9ca3af;">No residents found in this purok</div>';

        residentCount.textContent = '0 residents';

        residentsData.value = '';

        saveBtn.disabled = true;

      }

    })

    .catch(error => {

      console.error('Error fetching residents:', error);

      residentsList.innerHTML = '<div style="padding:20px; text-align:center; color:#dc2626;">Error loading residents. Please try again.</div>';

      residentCount.textContent = '0 residents';

      saveBtn.disabled = true;

    });

}

// Load facility capacity information

function loadFacilityCapacity() {

  const evacuationAreaSelect = document.getElementById('evacuationAreaSelect');

  const capacityDisplay = document.getElementById('capacityDisplay');

  

  const selectedFacility = evacuationAreaSelect.value;

  

  if (!selectedFacility) {

    capacityDisplay.style.display = 'none';

    return;

  }

  

  // Show loading state

  capacityDisplay.style.display = 'block';

  capacityDisplay.innerHTML = '<div style="text-align:center; color:#6b7280;"><i class="fas fa-spinner fa-spin"></i> Loading capacity info...</div>';

  

  // Fetch facility capacity from API

  fetch(`/api/facilities/${encodeURIComponent(selectedFacility)}/capacity`)

    .then(response => response.json())

    .then(data => {

      if (data.success) {

        const facility = data.facility;

        let capacityHtml = '';

        if (facility.capacity) {

          const occupancyColor = facility.occupancy_percentage > 90 ? '#dc2626' : 

                               facility.occupancy_percentage > 75 ? '#f59e0b' : '#16a34a';

          const statusText = facility.occupancy_percentage > 90 ? 'Near Full' : 

                            facility.occupancy_percentage > 75 ? 'Getting Full' : 'Available';

          capacityHtml = `
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
              <span style="font-weight:600; color:#374151;">Capacity:</span>
              <span style="color:#6b7280;">${facility.current_occupancy} / ${facility.capacity}</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
              <span style="font-weight:600; color:#374151;">Available:</span>
              <span style="color:${facility.available_spaces > 0 ? '#16a34a' : '#dc2626'}; font-weight:600;">
                ${facility.available_spaces} spaces
              </span>
            </div>
            <div style="margin-top:6px;">
              <div style="background:#e5e7eb; border-radius:4px; height:8px; overflow:hidden;">
                <div style="background:${occupancyColor}; height:100%; width:${facility.occupancy_percentage}%; transition:width 0.3s ease;"></div>
              </div>
              <div style="display:flex; justify-content:space-between; margin-top:2px;">
                <span style="font-size:10px; color:#6b7280;">${facility.occupancy_percentage}% occupied</span>
                <span style="font-size:10px; color:${occupancyColor}; font-weight:600;">${statusText}</span>
              </div>
            </div>
          `;

          // Add warning if near capacity
          if (facility.occupancy_percentage > 90) {
            capacityHtml += `
              <div style="margin-top:6px; padding:4px 6px; background:#fef2f2; border:1px solid #fecaca; border-radius:4px; color:#dc2626; font-size:11px;">
                <i class="fas fa-exclamation-triangle"></i> This evacuation center is almost full!
              </div>
            `;
          } else if (facility.occupancy_percentage > 75) {
            capacityHtml += `
              <div style="margin-top:6px; padding:4px 6px; background:#fffbeb; border:1px solid #fed7aa; border-radius:4px; color:#d97706; font-size:11px;">
                <i class="fas fa-info-circle"></i> This evacuation center is getting full
              </div>
            `;
          }

        } else {

          capacityHtml = `
            <div style="color:#6b7280; font-style:italic;">
              <i class="fas fa-info-circle"></i> No capacity limit set for this facility
            </div>
          `;

        }

        capacityDisplay.innerHTML = capacityHtml;

        // Set background color based on availability
        if (facility.capacity) {
          capacityDisplay.style.background = facility.occupancy_percentage > 90 ? '#fef2f2' : 

                                         facility.occupancy_percentage > 75 ? '#fffbeb' : '#f0fdf4';

          capacityDisplay.style.border = facility.occupancy_percentage > 90 ? '1px solid #fecaca' : 

                                         facility.occupancy_percentage > 75 ? '1px solid #fed7aa' : '1px solid #bbf7d0';
        } else {
          capacityDisplay.style.background = '#f8fafc';
          capacityDisplay.style.border = '1px solid #e2e8f0';
        }

      } else {

        capacityDisplay.innerHTML = `
          <div style="color:#dc2626; font-size:11px;">
            <i class="fas fa-exclamation-triangle"></i> Could not load capacity information
          </div>
        `;

        capacityDisplay.style.background = '#fef2f2';
        capacityDisplay.style.border = '1px solid #fecaca';

      }

    })

    .catch(error => {

      console.error('Error fetching facility capacity:', error);

      capacityDisplay.innerHTML = `
        <div style="color:#dc2626; font-size:11px;">
          <i class="fas fa-exclamation-triangle"></i> Error loading capacity information
        </div>
      `;

      capacityDisplay.style.background = '#fef2f2';
      capacityDisplay.style.border = '1px solid #fecaca';

    });

}



// Update form submission to handle multiple evacuees

const form = document.getElementById('addEvacueeForm');

if (form) {

  form.addEventListener('submit', function(e) {

    e.preventDefault();
    
    if (currentResidents.length === 0) {

      showAlert('Please select a purok with residents', 'error');

      return;

    }
    
    // Send data to server as form data

    const formData = new FormData(form);
    
    fetch('{{ route("program.evacuee.store") }}', {

      method: 'POST',

      headers: {

        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

      },

      body: formData

    })

    .then(response => response.json())

    .then(data => {

      if (data.success) {

        closeAddEvacueeModal();

        showAlert(data.message, 'success');

        // Reload page after a short delay to show updated counts

        setTimeout(() => {

          window.location.reload();

        }, 1500);

      } else {

        showAlert(data.message, 'error');

      }

    })

    .catch(error => {

      console.error('Error:', error);

      showAlert('Error adding evacuees', 'error');

    });

  });

}



// Add evacuees to the table (demo function)

function addEvacueesToTable(data) {

  const tbody = document.querySelector('table tbody');

  const lastRow = tbody.querySelector('tr:last-child');

  

  // Remove the "Static preview row" if it exists

  if (lastRow && lastRow.querySelector('td[colspan]')) {

    lastRow.remove();

  }

  

  // Add new rows for each resident

  data.residents.forEach(resident => {

    const newRow = document.createElement('tr');

    const nextId = String(tbody.children.length + 1).padStart(4, '0');

    newRow.innerHTML = `

      <td>${nextId}</td>

      <td>${resident.name}</td>

      <td>${resident.age}</td>

      <td>${resident.gender}</td>

      <td>${data.status}</td>

      <td>${data.area}</td>

      <td>${data.room || '-'}</td>

      <td>${data.evacuation_date || '-'}</td>

      <td>

        <div class="actions">

          <a href="#" title="View"><i class="fas fa-eye"></i></a>

          <a href="#" title="Edit"><i class="fas fa-pen-to-square"></i></a>

          <a href="#" title="Delete"><i class="fas fa-trash"></i></a>

        </div>

      </td>

    `;

    tbody.appendChild(newRow);

  });

}

// Export Preview Modal Functions

function showExportPreview() {

  const modal = document.getElementById('exportPreviewModal');

  const overlay = document.getElementById('exportPreviewOverlay');

  

  // Show modal and overlay with animation

  overlay.classList.add('active');

  document.body.style.overflow = 'hidden';

  

  // Load export statistics

  loadExportStatistics();

}

function closeExportPreviewModal() {

  const overlay = document.getElementById('exportPreviewOverlay');

  overlay.classList.remove('active');

  document.body.style.overflow = 'auto';

}

function loadExportStatistics() {

  // Fetch current evacuee data for preview

  fetch('/api/evacuees/statistics')

    .then(response => response.json())

    .then(data => {

      document.getElementById('totalEvacueesCount').textContent = data.totalEvacuees || 0;

      document.getElementById('totalSheltersCount').textContent = data.totalShelters || 0;

    })

    .catch(error => {

      console.error('Error loading export statistics:', error);

      // Fallback to current page data

      const totalEvacuees = {{ $totalEvacuees ?? 0 }};

      const totalShelters = {{ $totalShelters ?? 0 }};

      document.getElementById('totalEvacueesCount').textContent = totalEvacuees;

      document.getElementById('totalSheltersCount').textContent = totalShelters;

    });

}

function proceedWithExport() {

  closeExportPreviewModal();

  // Trigger the actual download

  window.location.href = '{{ route("program.evacuee.export") }}';

  

  // Show success message

  setTimeout(() => {

    showAlert('Export started. Your download will begin shortly.', 'success');

  }, 500);

}

// Close modal when clicking outside

window.onclick = function(event) {

  const exportOverlay = document.getElementById('exportPreviewOverlay');

  const addOverlay = document.getElementById('addEvacueeOverlay');

  

  if (event.target === exportOverlay) {

    closeExportPreviewModal();

  }

  if (event.target === addOverlay) {

    closeAddEvacueeModal();

  }

}

</script>



<script>

setTimeout(()=>{

  const alert = document.getElementById('successAlert') || document.getElementById('welcomeAlert');

  if(alert){ alert.classList.add('hide'); setTimeout(()=>alert.remove(),500); }

},3000);

</script>

</body>

</html>

