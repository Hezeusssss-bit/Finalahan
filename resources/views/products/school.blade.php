<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>School Facilities</title>
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

/* School Info Section */
.school-info { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
.school-details { }
.school-details h2 { color: #1a1a2e; font-size: 24px; margin-bottom: 15px; }
.school-details p { color: #666; line-height: 1.6; margin-bottom: 10px; }
.school-image { background: #f8f9fa; border-radius: 12px; display: flex; align-items: center; justify-content: center; min-height: 200px; }
.school-image i { font-size: 80px; color: #1a1a2e; }

/* Features Grid */
.features-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
.feature-card { background: #f8f9fa; border-radius: 12px; padding: 20px; border: 2px solid #e9ecef; transition: all 0.3s ease; }
.feature-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #1a1a2e; }
.feature-icon { font-size: 32px; color: #1a1a2e; margin-bottom: 10px; }
.feature-title { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
.feature-description { font-size: 14px; color: #666; line-height: 1.5; margin-bottom: 10px; }
.feature-status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.status-available { background: #d4edda; color: #155724; }
.status-unavailable { background: #f8d7da; color: #721c24; }
.status-maintenance { background: #fff3cd; color: #856404; }

/* Inspect Modal */
.inspect-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 1000; }
.inspect-modal { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; border-radius: 12px; padding: 24px; width: 520px; max-width: 92%; display: none; z-index: 1001; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
.inspect-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.inspect-title { font-size: 20px; font-weight: 700; color: #1a1a2e; }
.inspect-actions-inline { display: flex; align-items: center; gap: 10px; }
.inspect-edit { background: transparent; border: none; font-size: 18px; cursor: pointer; color: #1a1a2e; }
.inspect-close { background: transparent; border: none; font-size: 20px; cursor: pointer; color: #333; }
.inspect-body { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 14px; }
.inspect-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
.inspect-label { color: #555; font-weight: 600; }
.inspect-value { color: #1a1a2e; text-align: right; }
.inspect-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 14px; }
.inspect-btn { padding: 10px 16px; border-radius: 8px; border: 1px solid #e9ecef; background: #f8f9fa; cursor: pointer; font-weight: 600; }
.inspect-btn.primary { background: #1a1a2e; color: #fff; border-color: #1a1a2e; }
.inspect-select { display: none; margin-top: 8px; }
.inspect-select select { width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #e0e0e0; background: #fff; }
.inspect-input { display: none; margin-top: 6px; }
.inspect-input input { width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #e0e0e0; background: #fff; }

/* Emergency Info */
.emergency-info { background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 12px; padding: 20px; margin-top: 20px; }
.emergency-info h3 { color: #856404; font-size: 18px; margin-bottom: 10px; }
.emergency-info p { color: #856404; line-height: 1.6; }

/* Back Button */
.back-btn { display: inline-flex; align-items: center; gap: 8px; color: #1a1a2e; text-decoration: none; font-weight: 600; margin-bottom: 20px; transition: all 0.3s ease; }
.back-btn:hover { color: #007bff; transform: translateX(-2px); }

/* Responsive */
@media (max-width: 768px) {
  .sidebar { width: 70px; }
  .logo span, .nav-item span { display: none; }
  .main-content { margin-left: 70px; padding: 20px; }
  .school-info { grid-template-columns: 1fr; }
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
    <h1>School Facilities</h1>
  
  </div>

  <!-- Inspect Modal -->
  <div class="inspect-overlay" id="inspectOverlay"></div>
  <div class="inspect-modal" id="inspectModal">
    <div class="inspect-header">
      <div class="inspect-title" id="inspectTitle">School Details</div>
      <div class="inspect-actions-inline">
        <button class="inspect-edit" id="inspectEdit" title="Edit"><i class="fas fa-pen"></i></button>
        <button class="inspect-close" id="inspectClose" aria-label="Close">&times;</button>
      </div>
    </div>
    <div class="inspect-body">
      <div class="inspect-row"><span class="inspect-label">Status:</span><span class="inspect-value"><span id="inspectStatus" class="feature-status">-</span></span></div>
      <div class="inspect-select" id="inspectStatusSelectWrap">
        <select id="inspectStatusSelect">
          <option value="available">Available</option>
          <option value="maintenance">Under Maintenance</option>
          <option value="unavailable">Unavailable</option>
        </select>
      </div>
      <div class="inspect-row"><span class="inspect-label">Number of Family:</span><span class="inspect-value" id="inspectFamilies">-</span></div>
      <div class="inspect-input" id="inspectFamiliesInputWrap"><input type="number" id="inspectFamiliesInput" min="0" /></div>
      <div class="inspect-row"><span class="inspect-label">Number of Rooms:</span><span class="inspect-value" id="inspectRooms">-</span></div>
      <div class="inspect-input" id="inspectRoomsInputWrap"><input type="number" id="inspectRoomsInput" min="0" /></div>
      <div class="inspect-row"><span class="inspect-label">Number of Buildings:</span><span class="inspect-value" id="inspectBuildings">-</span></div>
      <div class="inspect-input" id="inspectBuildingsInputWrap"><input type="number" id="inspectBuildingsInput" min="0" /></div>
    </div>
    <div class="inspect-actions">
      <button class="inspect-btn" id="inspectCancel">Close</button>
      <button class="inspect-btn primary" id="inspectOk">OK</button>
    </div>
  </div>

  <div class="container">
    <a href="{{ route('facilities') }}" class="back-btn">
      <i class="fas fa-arrow-left"></i>
      Back to Facilities
    </a>
    
    <div class="school-info">
      <div class="school-details">
        <h2>Community School</h2>
        <p><strong>Primary Purpose:</strong> Educational facility serving the community</p>
        <p><strong>Emergency Role:</strong> Designated evacuation center and emergency response hub</p>
        <p><strong>Capacity:</strong> Can accommodate up to 500 people during emergencies</p>
        <p><strong>Location:</strong> Central area of the community for easy access</p>
      </div>
      <div class="school-image">
        <i class="fas fa-school"></i>
      </div>
    </div>

    <h2 style="margin: 30px 0 20px 0; color: #1a1a2e;">Available Features</h2>
    
    <div class="features-grid">
      <div class="feature-card inspect-card" data-name="Hinigaran National High School" data-families="250" data-rooms="35" data-buildings="4" data-status="available">
        <div class="feature-icon"><i class="fas fa-school"></i></div>
        <div class="feature-title">Hinigaran National High School</div>
        <div class="feature-description"> Address : 7V83+P53, Barangay III, Hinigaran, Negros Occidental</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card inspect-card" data-name="Hinigaran Institute" data-families="180" data-rooms="22" data-buildings="3" data-status="maintenance">
        <div class="feature-icon"><i class="fas fa-school"></i></div>
        <div class="feature-title">Hinigaran Institute </div>
        <div class="feature-description">Address : 7VG3+28Q, Lopez Jaena St, Barangay 1, Hinigaran, Negros Occidental</div>
        <span class="feature-status status-maintenance">Under Maintenance</span>
      </div>

      <div class="feature-card inspect-card" data-name="Madeline Academy" data-families="120" data-rooms="18" data-buildings="2" data-status="available">
        <div class="feature-icon"><i class="fas fa-school"></i></div>
        <div class="feature-title">Madeline Academy</div>
        <div class="feature-description">Address : 7VC2+MG7, Rizal Street, Negros South Road, Hinigaran, 6106 Negros Occidental</div>
        <span class="feature-status status-available">Available</span>
      </div>

      <div class="feature-card inspect-card" data-name="Hinigaran Elementary School A" data-families="90" data-rooms="14" data-buildings="2" data-status="unavailable">
        <div class="feature-icon"><i class="fas fa-school"></i></div>
        <div class="feature-title"> Hinigaran Elementary School A</div>
        <div class="feature-description">Address : 7VC2+Q7G, Osmeña St, Hinigaran, 6106 Negros Occidental</div>
        <span class="feature-status status-unavailable">Unavailable</span>
      </div>

      <div class="feature-card inspect-card" data-name="Hinigaran Elementary School B" data-families="95" data-rooms="15" data-buildings="2" data-status="available">
        <div class="feature-icon"><i class="fas fa-school"></i></div>
        <div class="feature-title">Hinigaran Elementary School B</div>
        <div class="feature-description">Address : 7VC2+623, Rizal St, Hinigaran, Negros Occidental</div>
        <span class="feature-status status-available">Available</span>
      </div>

    </div>

    <div class="emergency-info">
      <h3><i class="fas fa-exclamation-triangle"></i> Emergency Procedures</h3>
      <p>In case of emergency or natural disaster, this school serves as a primary evacuation center. Residents should follow evacuation routes and report to the main office for registration and assistance. Emergency supplies and temporary shelter are available for affected families.</p>
    </div>
  </div>
</div>

</body>
</html>

<script>
// Modal elements
const overlay = document.getElementById('inspectOverlay');
const modal = document.getElementById('inspectModal');
const titleEl = document.getElementById('inspectTitle');
const familiesEl = document.getElementById('inspectFamilies');
const roomsEl = document.getElementById('inspectRooms');
const buildingsEl = document.getElementById('inspectBuildings');
const closeBtn = document.getElementById('inspectClose');
const cancelBtn = document.getElementById('inspectCancel');
const okBtn = document.getElementById('inspectOk');
const editBtn = document.getElementById('inspectEdit');
const statusBadge = document.getElementById('inspectStatus');
const statusSelectWrap = document.getElementById('inspectStatusSelectWrap');
const statusSelect = document.getElementById('inspectStatusSelect');
const famBadge = document.getElementById('inspectFamilies');
const roomsBadge = document.getElementById('inspectRooms');
const bldgBadge = document.getElementById('inspectBuildings');
const famWrap = document.getElementById('inspectFamiliesInputWrap');
const roomsWrap = document.getElementById('inspectRoomsInputWrap');
const bldgWrap = document.getElementById('inspectBuildingsInputWrap');
const famInput = document.getElementById('inspectFamiliesInput');
const roomsInput = document.getElementById('inspectRoomsInput');
const bldgInput = document.getElementById('inspectBuildingsInput');

function openInspect(name, families, rooms, buildings){
  titleEl.textContent = name;
  familiesEl.textContent = families;
  roomsEl.textContent = rooms;
  buildingsEl.textContent = buildings;
  famInput.value = families;
  roomsInput.value = rooms;
  bldgInput.value = buildings;
  // status text/class
  var statusText = '-';
  var statusClass = '';
  if (currentCard) {
    var status = currentCard.getAttribute('data-status');
    if (status === 'available') { statusText = 'Available'; statusClass = 'status-available'; }
    else if (status === 'maintenance') { statusText = 'Under Maintenance'; statusClass = 'status-maintenance'; }
    else if (status === 'unavailable') { statusText = 'Unavailable'; statusClass = 'status-unavailable'; }
  }
  var statusEl = document.getElementById('inspectStatus');
  statusEl.textContent = statusText;
  statusEl.className = 'feature-status ' + statusClass;
  // sync select value
  var statusVal = 'available';
  if (currentCard) { statusVal = currentCard.getAttribute('data-status') || 'available'; }
  statusSelect.value = statusVal;
  overlay.style.display = 'block';
  modal.style.display = 'block';
}

function closeInspect(){
  overlay.style.display = 'none';
  modal.style.display = 'none';
}

// Attach click handlers to cards
var currentCard = null;
document.querySelectorAll('.inspect-card').forEach(function(card){
  card.addEventListener('click', function(){
    currentCard = card;
    openInspect(
      card.getAttribute('data-name'),
      card.getAttribute('data-families'),
      card.getAttribute('data-rooms'),
      card.getAttribute('data-buildings')
    );
  });
});

// Close actions
overlay.addEventListener('click', closeInspect);
closeBtn.addEventListener('click', closeInspect);
cancelBtn.addEventListener('click', closeInspect);
okBtn.addEventListener('click', closeInspect);

// Escape key
document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeInspect(); });

// Toggle edit mode for status
var editMode = false;
function setEditMode(on) {
  editMode = !!on;
  statusSelectWrap.style.display = editMode ? 'block' : 'none';
  statusBadge.style.display = editMode ? 'none' : 'inline-block';
  famWrap.style.display = editMode ? 'block' : 'none';
  roomsWrap.style.display = editMode ? 'block' : 'none';
  bldgWrap.style.display = editMode ? 'block' : 'none';
  famBadge.style.display = editMode ? 'none' : 'inline-block';
  roomsBadge.style.display = editMode ? 'none' : 'inline-block';
  bldgBadge.style.display = editMode ? 'none' : 'inline-block';
}

editBtn.addEventListener('click', function(){
  setEditMode(!editMode);
});

// Persist selection back to card and badge when modal closes or when value changes
statusSelect.addEventListener('change', function(){
  var val = statusSelect.value;
  var text = val === 'available' ? 'Available' : (val === 'maintenance' ? 'Under Maintenance' : 'Unavailable');
  var cls = val === 'available' ? 'status-available' : (val === 'maintenance' ? 'status-maintenance' : 'status-unavailable');
  statusBadge.textContent = text;
  statusBadge.className = 'feature-status ' + cls;
  if (currentCard) {
    currentCard.setAttribute('data-status', val);
    // also update the card's visible badge if present
    var cardBadge = currentCard.querySelector('.feature-status');
    if (cardBadge) {
      cardBadge.textContent = text;
      cardBadge.className = 'feature-status ' + cls;
    }
  }
});

// Sync numeric edits
function syncNumeric(field, val){
  var n = parseInt(val, 10);
  if (isNaN(n) || n < 0) return;
  if (!currentCard) return;
  if (field === 'families') { famBadge.textContent = n; currentCard.setAttribute('data-families', String(n)); }
  if (field === 'rooms') { roomsBadge.textContent = n; currentCard.setAttribute('data-rooms', String(n)); }
  if (field === 'buildings') { bldgBadge.textContent = n; currentCard.setAttribute('data-buildings', String(n)); }
}

famInput.addEventListener('input', function(){ syncNumeric('families', famInput.value); });
roomsInput.addEventListener('input', function(){ syncNumeric('rooms', roomsInput.value); });
bldgInput.addEventListener('input', function(){ syncNumeric('buildings', bldgInput.value); });

// Ensure edit mode off when opening/closing
function resetModalState(){ setEditMode(false); }
function closeInspect(){ overlay.style.display = 'none'; modal.style.display = 'none'; resetModalState(); }
// override earlier closeInspect definition moved below to include reset

// Logout confirmation function
function confirmLogout(button) {
  if (confirm('Are you sure you want to logout?')) {
    button.closest('form').submit();
  }
}
</script>

</body>
</html>
