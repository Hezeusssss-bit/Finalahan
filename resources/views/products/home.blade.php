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
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: #f1f1f1; }
::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: #555; }
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

/* Floating Alert */
.alert { position: fixed; top: 20px; right: 20px; background-color: #17002B; color: #ffffff; padding: 15px 25px; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px #17002B; z-index: 9999; opacity: 0; animation: slideIn 0.5s forwards; }
.alert.success { background-color: #17002B; color: #fff; }
@keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }
.alert.hide { animation: slideOut 0.5s forwards; }

/* Filter & Search Section */
.filter-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
.filter-left { display: flex; gap: 10px; align-items: center; }
.filter-btn { padding: 10px 20px; border-radius: 8px; border: 1px solid #ddd; background: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; }
.filter-btn:hover { background: #1a1a2e; color: #fff; border-color: #1a1a2e; }
.dropdown { position: relative; }
.dropdown-menu { position: absolute; top: 110%; left: 0; background: #fff; border: 1px solid #e5e5e5; border-radius: 8px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); min-width: 180px; padding: 8px; display: none; z-index: 50; }
.dropdown.open .dropdown-menu { display: block; }
.dropdown-item { padding: 10px 12px; border-radius: 6px; font-size: 14px; color: #333; cursor: pointer; }
.dropdown-item:hover { background: #f5f5f5; }
.search-container { position: relative; display: flex; align-items: center; }
.search-container i { position: absolute; left: 15px; color: #999; font-size: 14px; }
.search-container input { padding: 10px 15px 10px 40px; border-radius: 8px; border: 1px solid #ddd; font-size: 14px; width: 300px; transition: all 0.3s ease; }
.search-container input:focus { outline: none; border-color: #1a1a2e; box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.1); }
.filter-right { display: flex; gap: 10px; }
.btn-add { padding: 10px 20px; border-radius: 8px; background: #fff; border: 1px solid #ddd; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; color: #333; display: flex; align-items: center; gap: 8px; }
.btn-add:hover { background: #1a1a2e; color: #fff; border-color: #1a1a2e; }
.btn-export { padding: 10px 20px; border-radius: 8px; background: #1a1a2e; border: none; color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; }
.btn-export:hover { background: #0f0f1e; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(26, 26, 46, 0.3); }

/* Table */
.table-wrapper { overflow-x: auto; border-radius: 10px; border: 1px solid #e5e5e5; }
table { width: 100%; border-collapse: collapse; }
thead { background: #fafafa; border-bottom: 2px solid #e5e5e5; }
th { padding: 15px; text-align: left; font-size: 12px; font-weight: 700; color: #666; text-transform: uppercase; letter-spacing: 0.5px; }
th.sortable { cursor: pointer; user-select: none; }
th.sortable:hover { background: #f0f0f0; }
td { padding: 18px 15px; border-bottom: 1px solid #f0f0f0; font-size: 14px; color: #333; }
tbody tr { transition: background 0.2s ease; }
tbody tr:hover { background: #fafafa; }
.actions { display: flex; gap: 10px; justify-content: flex-start; }
.btn-icon { background: none; border: none; cursor: pointer; font-size: 16px; padding: 6px; border-radius: 6px; transition: all 0.3s ease; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
.btn-icon.view { color: #666; }
.btn-icon.view:hover { background: #f0f0f0; color: #1a1a2e; }
.btn-icon.edit { color: #666; }
.btn-icon.edit:hover { background: #e3f2fd; color: #2196f3; }
.btn-icon.delete { color: #666; }
.btn-icon.delete:hover { background: #ffebee; color: #f44336; }

/* Pagination */
.pagination-container { display: flex; justify-content: space-between; align-items: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e5e5; }
.per-page-selector { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #666; }
.per-page-selector select { padding: 8px 12px; border-radius: 6px; border: 1px solid #e5e5e5; background: #fff; font-size: 14px; cursor: pointer; transition: all 0.3s ease; }
.per-page-selector select:focus { outline: none; border-color: #1a1a2e; box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.1); }
.per-page-selector select:hover { border-color: #1a1a2e; }
.pagination { display: flex; gap: 5px; list-style: none; padding: 0; margin: 0; }
.pagination li { display: inline-block; }
.pagination .page-link { display: flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 10px; border-radius: 6px; background: #fff; color: #333; border: 1px solid #ddd; text-decoration: none; font-weight: 500; font-size: 13px; transition: all 0.3s ease; }
.pagination .page-link:hover { background: #f5f5f5; border-color: #999; }
.pagination .active .page-link { background: #1a1a2e; color: #fff; border-color: #1a1a2e; pointer-events: none; }
.pagination .disabled .page-link { opacity: 0.4; pointer-events: none; cursor: not-allowed; }

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

/* Modal form inputs */
.modal form div { display: flex; flex-direction: column; gap: 6px; margin-bottom: 12px; }
.modal label { font-size: 13px; color: #555; font-weight: 700; }
.modal input[type="text"],
.modal input[type="number"],
.modal input[type="email"],
.modal input[type="password"] {
  padding: 12px 14px;
  border: 1px solid #e5e5e5;
  border-radius: 10px;
  background: #fafafa;
  font-size: 14px;
  color: #333;
  transition: all 0.2s ease;
}
.modal select {
  padding: 12px 14px;
  border: 1px solid #e5e5e5;
  border-radius: 10px;
  background: #fafafa;
  font-size: 14px;
  color: #333;
  transition: all 0.2s ease;
}
.modal input[type="text"]:focus,
.modal input[type="number"]:focus,
.modal input[type="email"]:focus,
.modal input[type="password"]:focus {
  outline: none;
  border-color: #1a1a2e;
  box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.1);
  background: #fff;
}
.modal select:focus {
  outline: none;
  border-color: #1a1a2e;
  box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.1);
  background: #fff;
}
.error-message { color: #f44336; font-size: 12px; }

/* Resident Details Modal */
.resident-details { margin: 20px 0; }
.detail-row { 
  display: flex; 
  justify-content: space-between; 
  align-items: center; 
  padding: 12px 0; 
  border-bottom: 1px solid #f0f0f0; 
}
.detail-row:last-child { border-bottom: none; }
.detail-row label { 
  font-weight: 600; 
  color: #333; 
  font-size: 14px; 
  min-width: 120px; 
}
.detail-row span { 
  color: #666; 
  font-size: 14px; 
  text-align: right; 
  flex: 1; 
  margin-left: 20px; 
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar { width: 70px; }
  .logo span, .nav-item span { display: none; }
  .main-content { margin-left: 70px; padding: 20px; }
  .filter-section { flex-direction: column; align-items: stretch; }
  .search-container input { width: 100%; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo"><i class="fas fa-store"></i> <span>Logo</span></div>
  <nav class="nav-menu">
    <a href="{{ route('resident.index') }}" class="nav-item active"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
    <a href="{{ route('services') }}" class="nav-item"><i class="fas fa-boxes"></i><span>Services</span></a>
    <a href="#" class="nav-item"><i class="fas fa-users"></i><span>Events</span></a>
  </nav>
  <div class="sidebar-footer">
    <a href="#" class="nav-item"><i class="fas fa-cog"></i><span>Settings</span></a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="button" class="nav-item" style="background:none;border:none;width:100%;text-align:left;" onclick="confirmLogout(this)">
        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
      </button>
    </form>
  </div>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <h1>Total Residents</h1>
  </div>

  @if(session('Success'))
    <div class="alert success" id="successAlert">{{ session('Success') }}</div>
  @endif

  <div class="container">
    <!-- Filter & Search -->
    <div class="filter-section">
      <div class="filter-left">
        <div class="dropdown" id="purokDropdown">
          <button type="button" class="filter-btn" id="purokBtn">PUROK <i class="fas fa-chevron-down"></i></button>
          <div class="dropdown-menu">
            <div class="dropdown-item" data-value="ALL">ALL PUROK</div>
            <div class="dropdown-item" data-value="Purok I">Purok I</div>
            <div class="dropdown-item" data-value="Purok II">Purok II</div>
            <div class="dropdown-item" data-value="Purok III">Purok III</div>
            <div class="dropdown-item" data-value="Purok IV">Purok IV</div>
            <div class="dropdown-item" data-value="Purok V">Purok V</div>
          </div>
        </div>
        <div class="dropdown" id="categoryDropdown">
          <button type="button" class="filter-btn" id="categoryBtn">RESIDENTS<i class="fas fa-chevron-down"></i></button>
          <div class="dropdown-menu">
            <div class="dropdown-item" data-value="ALL">ALL RESIDENTS</div>
            <div class="dropdown-item" data-value="SENIOR MALE">SENIOR MALE</div>
            <div class="dropdown-item" data-value="SENIOR FEMALE">SENIOR FEMALE</div>
            <div class="dropdown-item" data-value="MALE">MALE</div>
            <div class="dropdown-item" data-value="FEMALE">FEMALE</div>
            <div class="dropdown-item" data-value="CHILD MALE">CHILD MALE</div>
            <div class="dropdown-item" data-value="CHILD FEMALE">CHILD FEMALE</div>
          </div>
        </div>
        <div class="search-container">
          <i class="fas fa-search"></i>
          <input type="text" id="searchInput" placeholder="Search" value="{{ request('search') }}" onkeyup="liveSearch()" />
        </div>
      </div>
      <div class="filter-right">
        <button class="btn-add" onclick="openAddModal()">ADD <i class="fas fa-plus"></i></button>
        <button class="btn-export">EXPORT <i class="fas fa-download"></i></button>
      </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
      <table id="residentsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th class="sortable" onclick="sortTable(1,'string')">LASTNAME <i class="fas fa-sort sort-arrow"></i></th>
            <th class="sortable" onclick="sortTable(2,'string')">FIRSTNAME <i class="fas fa-sort sort-arrow"></i></th>
            <th>AGE</th>
            <th>GENDER</th>
            <th>ADDRESS</th>
            <th>CONTACT NUMBER</th>
            <th>ADDED ON</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
          @forelse($residents as $resident)
          <tr data-gender="{{ $resident->gender ?? '' }}">
            <td>{{ $resident->id }}</td>
            <td>{{ $resident->qty }}</td>
            <td>{{ $resident->name }}</td>
            <td>{{ $resident->price }}</td>
            <td>{{ $resident->gender ?? '-' }}</td>
            <td>{{ $resident->description }}</td>
            <td>{{ $resident->contact_number ?? '-' }}</td>
            <td>{{ $resident->created_at->format('M d, Y') }}</td>
            <td>
              <div class="actions">
                <button type="button" class="btn-icon view" onclick="openViewModal({{ $resident->id }})"><i class="fas fa-eye"></i></button>
                <button type="button" class="btn-icon edit" onclick="openEditModal('{{ route('resident.update', $resident->id) }}','{{ addslashes($resident->name) }}','{{ $resident->qty }}','{{ $resident->price }}','{{ addslashes($resident->description) }}','{{ $resident->gender }}','{{ $resident->contact_number }}')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn-icon delete" onclick="openDeleteModal('{{ route('resident.destroy', $resident->id) }}')"><i class="fas fa-trash"></i></button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" style="text-align:center;color:#999;">No residents found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
      <div class="per-page-selector">
        <span>Show</span>
        <select onchange="changePerPage(this.value)">
          <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
          <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>
          <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
          <option value="100" {{ request('per_page')==100?'selected':'' }}>100</option>
        </select>
        <span>per page</span>
        <span style="margin-left:16px;color:#666;">Total Residents: <strong>{{ number_format($totalResidents) }}</strong></span>
        <span style="margin-left:16px;color:#666;">Male: <strong>{{ isset($maleCount) ? number_format($maleCount) : '0' }}</strong></span>
        <span style="margin-left:16px;color:#666;">Female: <strong>{{ isset($femaleCount) ? number_format($femaleCount) : '0' }}</strong></span>
        <span style="margin-left:16px;color:#666;">Senior Male: <strong>{{ isset($seniorMale) ? number_format($seniorMale) : '0' }}</strong></span>
        <span style="margin-left:16px;color:#666;">Senior Female: <strong>{{ isset($seniorFemale) ? number_format($seniorFemale) : '0' }}</strong></span>
        <span style="margin-left:16px;color:#666;">Child Male: <strong>{{ isset($childMale) ? number_format($childMale) : '0' }}</strong></span>
        <span style="margin-left:16px;color:#666;">Child Female: <strong>{{ isset($childFemale) ? number_format($childFemale) : '0' }}</strong></span>
      </div>
      {{ $residents->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>

<!-- Add Resident Modal -->
<div class="modal-overlay" id="addResidentOverlay"></div>
<div class="modal" id="addResidentModal">
  <h2>Create New Resident</h2>
  <form method="POST" action="{{ route('resident.store') }}">
    @csrf
    <div>
      <label>Firstname  </label>
      <input type="text" name="name" placeholder="First name" value="{{ old('name') }}">
      @error('name')<div class="error-message">{{ $message }}</div>@enderror
    </div>
    <div>
      <label>Lastname</label>
      <input type="text" name="qty" placeholder="Lastname" value="{{ old('qty') }}">
      @error('qty')<div class="error-message">{{ $message }}</div>@enderror
    </div>
    <div>
      <label>Age</label>
      <input type="text" name="price" placeholder="Age" value="{{ old('price') }}">
      @error('price')<div class="error-message">{{ $message }}</div>@enderror
    </div>
    <div>
      <label>Address</label>
      <select name="description">
        <option value="" disabled {{ old('description') ? '' : 'selected' }}>Select Purok</option>
        <option value="Purok I" {{ old('description') == 'Purok I' ? 'selected' : '' }}>Purok I</option>
        <option value="Purok II" {{ old('description') == 'Purok II' ? 'selected' : '' }}>Purok II</option>
        <option value="Purok III" {{ old('description') == 'Purok III' ? 'selected' : '' }}>Purok III</option>
        <option value="Purok IV" {{ old('description') == 'Purok IV' ? 'selected' : '' }}>Purok IV</option>
        <option value="Purok V" {{ old('description') == 'Purok V' ? 'selected' : '' }}>Purok V</option>
      </select>
      @error('description')<div class="error-message">{{ $message }}</div>@enderror
    </div>
    <div>
      <label>Gender</label>
      <select name="gender">
        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
      </select>
      @error('gender')<div class="error-message">{{ $message }}</div>@enderror
    </div>
    <div>
      <label>Contact Number</label>
      <input type="text" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number') }}">
      @error('contact_number')<div class="error-message">{{ $message }}</div>@enderror
    </div>
    <div class="modal-buttons" style="margin-top:15px;">
      <button type="submit" class="btn-add">Save</button>
      <button type="button" class="btn-cancel" onclick="closeAddModal()">Cancel</button>
    </div>
  </form>
</div>

  <!-- Edit Resident Modal (same design as Add) -->
  <div class="modal-overlay" id="editResidentOverlay" onclick="closeEditModal()"></div>
  <div class="modal" id="editResidentModal">
    <h2>Update Resident</h2>
    <form id="editResidentForm" method="POST" onsubmit="return confirmEdit()">
      @csrf
      @method('PUT')
      <div>
        <label>Firstname</label>
        <input type="text" name="name" id="edit_name" placeholder="First name" required>
        @error('name')<div class="error-message">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Lastname</label>
        <input type="text" name="qty" id="edit_qty" placeholder="Lastname" required>
        @error('qty')<div class="error-message">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Age</label>
        <input type="text" name="price" id="edit_price" placeholder="Age" required>
        @error('price')<div class="error-message">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Address</label>
        <select name="description" id="edit_description">
          <option value="" disabled>Select Purok</option>
          <option value="Purok I">Purok I</option>
          <option value="Purok II">Purok II</option>
          <option value="Purok III">Purok III</option>
          <option value="Purok IV">Purok IV</option>
          <option value="Purok V">Purok V</option>
        </select>
        @error('description')<div class="error-message">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Gender</label>
        <select name="gender" id="edit_gender">
          <option value="" disabled>Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
        @error('gender')<div class="error-message">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Contact Number</label>
        <input type="text" name="contact_number" id="edit_contact_number" placeholder="Contact Number" value="">
        @error('contact_number')<div class="error-message">{{ $message }}</div>@enderror
      </div>
      <div class="modal-buttons" style="margin-top:15px;">
        <button type="submit" class="btn-add">Save Changes</button>
        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
      </div>
    </form>
  </div>

<!-- View Details Modal -->
<div class="modal-overlay" id="viewResidentOverlay"></div>
<div class="modal" id="viewResidentModal">
  <h2>Resident Details</h2>
  <div class="resident-details">
    <div class="detail-row">
      <label>ID:</label>
      <span id="view_id">-</span>
    </div>
    <div class="detail-row">
      <label>First Name:</label>
      <span id="view_name">-</span>
    </div>
    <div class="detail-row">
      <label>Last Name:</label>
      <span id="view_qty">-</span>
    </div>
    <div class="detail-row">
      <label>Age:</label>
      <span id="view_price">-</span>
    </div>
    <div class="detail-row">
      <label>Address:</label>
      <span id="view_description">-</span>
    </div>
    <div class="detail-row">
      <label>Contact Number:</label>
      <span id="view_contact_number">-</span>
    </div>
    <div class="detail-row">
      <label>Created:</label>
      <span id="view_created">-</span>
    </div>
    <div class="detail-row">
      <label>Last Updated:</label>
      <span id="view_updated">-</span>
    </div>
  </div>
  <div class="modal-buttons">
    <button class="btn-cancel" onclick="closeViewModal()">Close</button>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal-overlay" id="modalOverlay" onclick="closeDeleteModal()"></div>
<div class="modal" id="deleteModal">
  <h2>Delete Resident</h2>
  <p>Are you sure you want to delete this resident? This action cannot be undone.</p>
  <div class="modal-buttons">
    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
    <form id="deleteForm" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn-confirm">Delete</button>
    </form>
  </div>
</div>

<!-- Edit Confirmation Modal -->
<div class="modal-overlay" id="editConfirmOverlay" onclick="closeEditConfirmModal()"></div>
<div class="modal" id="editConfirmModal">
  <h2>Confirm Changes</h2>
  <p style="margin-bottom: 15px;">Please confirm the following details are correct:</p>
  <div class="resident-details">
    <div class="detail-row">
      <label>Firstname:</label>
      <span id="confirm_name">-</span>
    </div>
    <div class="detail-row">
      <label>Lastname:</label>
      <span id="confirm_qty">-</span>
    </div>
    <div class="detail-row">
      <label>Age:</label>
      <span id="confirm_price">-</span>
    </div>
    <div class="detail-row">
      <label>Address:</label>
      <span id="confirm_description">-</span>
    </div>
  </div>
  <div class="modal-buttons" style="margin-top: 20px;">
    <button class="btn-cancel" onclick="closeEditConfirmModal()">Cancel</button>
    <button class="btn-add" onclick="submitEditForm()">Save Changes</button>
  </div>
</div>

<script>
function openDeleteModal(action) {
  document.getElementById('deleteForm').action = action;
  document.getElementById('modalOverlay').style.display = 'block';
  document.getElementById('deleteModal').style.display = 'block';
}
function closeDeleteModal() {
  document.getElementById('modalOverlay').style.display = 'none';
  document.getElementById('deleteModal').style.display = 'none';
}
function openAddModal() {
  document.getElementById('addResidentOverlay').style.display = 'block';
  document.getElementById('addResidentModal').style.display = 'block';
}
function closeAddModal() {
  document.getElementById('addResidentOverlay').style.display = 'none';
  document.getElementById('addResidentModal').style.display = 'none';
}
function openEditModal(action, name, qty, price, description, gender, contactNumber = '') {
  document.getElementById('editResidentOverlay').style.display = 'block';
  document.getElementById('editResidentModal').style.display = 'block';
  const form = document.getElementById('editResidentForm');
  form.action = action;
  document.getElementById('edit_name').value = name;
  document.getElementById('edit_qty').value = qty;
  document.getElementById('edit_price').value = price;
  document.getElementById('edit_description').value = description;
  document.getElementById('edit_contact_number').value = contactNumber || '';
  if (gender) { document.getElementById('edit_gender').value = gender; }
}
function closeEditModal() {
  document.getElementById('editResidentOverlay').style.display = 'none';
  document.getElementById('editResidentModal').style.display = 'none';
}
function confirmEdit() {
  // Prevent default form submission
  event.preventDefault();
  
  // Get form values
  const firstname = document.getElementById('edit_name').value;
  const lastname = document.getElementById('edit_qty').value;
  const age = document.getElementById('edit_price').value;
  const address = document.getElementById('edit_description').value || 'Not specified';
  
  // Populate confirmation modal
  document.getElementById('confirm_name').textContent = firstname;
  document.getElementById('confirm_qty').textContent = lastname;
  document.getElementById('confirm_price').textContent = age;
  document.getElementById('confirm_description').textContent = address;
  
  // Show confirmation modal
  document.getElementById('editConfirmOverlay').style.display = 'block';
  document.getElementById('editConfirmModal').style.display = 'block';
  
  return false;
}
function closeEditConfirmModal() {
  document.getElementById('editConfirmOverlay').style.display = 'none';
  document.getElementById('editConfirmModal').style.display = 'none';
}
function submitEditForm() {
  // Close confirmation modal
  closeEditConfirmModal();
  // Submit the form
  document.getElementById('editResidentForm').submit();
}
function openViewModal(residentId) {
  // Fetch resident details via AJAX
  fetch(`/residents/${residentId}`)
    .then(response => response.json())
    .then(data => {
      document.getElementById('view_id').textContent = data.id;
      document.getElementById('view_name').textContent = data.name;
      document.getElementById('view_qty').textContent = data.qty;
      document.getElementById('view_price').textContent = data.price;
      document.getElementById('view_description').textContent = data.description || '-';
      document.getElementById('view_contact_number').textContent = data.contact_number || '-';
      document.getElementById('view_created').textContent = data.created_at;
      document.getElementById('view_updated').textContent = data.updated_at;
      
      document.getElementById('viewResidentOverlay').style.display = 'block';
      document.getElementById('viewResidentModal').style.display = 'block';
    })
    .catch(error => {
      console.error('Error fetching resident details:', error);
      alert('Error loading resident details');
    });
}
function closeViewModal() {
  document.getElementById('viewResidentOverlay').style.display = 'none';
  document.getElementById('viewResidentModal').style.display = 'none';
}
function confirmLogout(button) {
  if(confirm('Are you sure you want to log out?')) button.closest('form').submit();
}
setTimeout(()=>{
  const alert = document.getElementById('successAlert') || document.getElementById('welcomeAlert');
  if(alert){ alert.classList.add('hide'); setTimeout(()=>alert.remove(),500); }
},3000);
let currentPurokFilter = 'ALL';
let currentCategoryFilter = 'ALL';
function refreshFilters(){
  const input = document.getElementById('searchInput').value.toLowerCase();
  const tbody = document.getElementById('residentsTable').getElementsByTagName('tbody')[0];
  const rows = tbody.getElementsByTagName('tr');
  for(let row of rows){
    let matchesSearch = false;
    for(let cell of row.getElementsByTagName('td')){
      if(cell.textContent.toLowerCase().includes(input)) { matchesSearch = true; break; }
    }
    const purokText = row.children[5]?.textContent.trim() || '';
    const matchesPurok = currentPurokFilter === 'ALL' || purokText === currentPurokFilter;
    // Category filter (requires age and optionally gender in data-gender)
    const ageText = row.children[3]?.textContent.trim() || '';
    const age = parseInt(ageText, 10);
    const gender = (row.getAttribute('data-gender') || '').toUpperCase();
    const isChild = !isNaN(age) && age < 18;
    const isSenior = !isNaN(age) && age >= 60;
    const isMale = gender === 'MALE' || gender === 'M';
    const isFemale = gender === 'FEMALE' || gender === 'F';

    let matchesCategory = true; // default when ALL
    switch(currentCategoryFilter){
      case 'SENIOR MALE': matchesCategory = isSenior && isMale; break;
      case 'SENIOR FEMALE': matchesCategory = isSenior && isFemale; break;
      case 'MALE': matchesCategory = isMale; break;
      case 'FEMALE': matchesCategory = isFemale; break;
      case 'CHILD MALE': matchesCategory = isChild && isMale; break;
      case 'CHILD FEMALE': matchesCategory = isChild && isFemale; break;
      default: matchesCategory = true; // ALL
    }
    row.style.display = (matchesSearch && matchesPurok) ? '' : 'none';
    if(row.style.display !== 'none' && !matchesCategory){ row.style.display = 'none'; }
  }
}
function liveSearch(){
  refreshFilters();
}

document.addEventListener('DOMContentLoaded', function(){
  const dropdown = document.getElementById('purokDropdown');
  const btn = document.getElementById('purokBtn');
  btn.addEventListener('click', function(e){
    e.stopPropagation();
    dropdown.classList.toggle('open');
  });
  document.addEventListener('click', function(){
    dropdown.classList.remove('open');
  });
  dropdown.querySelectorAll('.dropdown-item').forEach(function(item){
    item.addEventListener('click', function(e){
      e.stopPropagation();
      const value = this.getAttribute('data-value');
      currentPurokFilter = value;
      btn.innerHTML = value + ' <i class="fas fa-chevron-down"></i>';
      dropdown.classList.remove('open');
      refreshFilters();
    });
  });
});

document.addEventListener('DOMContentLoaded', function(){
  const dropdown = document.getElementById('categoryDropdown');
  const btn = document.getElementById('categoryBtn');
  btn.addEventListener('click', function(e){
    e.stopPropagation();
    dropdown.classList.toggle('open');
  });
  document.addEventListener('click', function(){
    dropdown.classList.remove('open');
  });
  dropdown.querySelectorAll('.dropdown-item').forEach(function(item){
    item.addEventListener('click', function(e){
      e.stopPropagation();
      const value = this.getAttribute('data-value');
      currentCategoryFilter = value;
      btn.innerHTML = value + ' <i class="fas fa-chevron-down"></i>';
      dropdown.classList.remove('open');
      refreshFilters();
    });
  });
});

function changePerPage(value){
  const params = new URLSearchParams(window.location.search);
  params.set('per_page', value);
  window.location.search = params.toString();
}

// Sort table by column index and type ('string' or 'number')
function sortTable(columnIndex, type){
  const table = document.getElementById('residentsTable');
  const tbody = table.tBodies[0];
  const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');
  const current = table.getAttribute('data-sort-col');
  const dir = current == columnIndex && table.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
  rows.sort((a,b)=>{
    const av = a.children[columnIndex].textContent.trim();
    const bv = b.children[columnIndex].textContent.trim();
    if(type==='number'){
      const an = parseFloat(av) || 0; const bn = parseFloat(bv) || 0;
      return dir==='asc' ? an-bn : bn-an;
    }
    return dir==='asc' ? av.localeCompare(bv) : bv.localeCompare(av);
  });
  rows.forEach(r=>tbody.appendChild(r));
  table.setAttribute('data-sort-col', columnIndex);
  table.setAttribute('data-sort-dir', dir);
}
</script>
</body>
</html>
