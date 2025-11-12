<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Add Program</title>
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
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.header h1 { color: #1a1a2e; font-size: 28px; font-weight: 700; }

/* Back button */
.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 999px; border: 1px solid #e5e7eb; background: #fff; color: #1a1a2e; text-decoration: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform .15s ease, box-shadow .15s ease, background .15s ease; font-weight: 600; font-size: 14px; }
.btn-back:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); background:#f9fafb; }
.btn-back i { font-size: 14px; color:#1a1a2e; }

/* Container */
.container { background: #fff; border-radius: 15px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

/* Card sample */
.program-card { background:#fff; border:1px solid #eee; border-radius:12px; padding:16px; max-width: 360px; }
.program-card h3 { font-weight:800; color:#17002B; font-size:20px; margin-bottom: 6px; }
.program-card .row { margin-top:6px; color:#555; }
.program-card .row strong { color:#1a1a2e; }
.program-card .status { margin-top:6px; font-weight:700; }
.program-card .status.completed { color:#16a34a; }
.program-card p { margin-top:10px; color:#444; }
.program-card .meta { margin-top:8px; color:#777; font-size:13px; }

/* Layout */
.grid { display:grid; grid-template-columns: 1fr; gap:20px; }
@media(min-width: 920px){ .grid { grid-template-columns: 380px 1fr; } }
.form { background:#fafafa; border:1px dashed #e5e7eb; border-radius:12px; padding:16px; }
.form h4 { margin-bottom:10px; color:#1a1a2e; }
.form .field { display:flex; flex-direction:column; gap:6px; margin-bottom:12px; }
.form input, .form select, .form textarea { border:1px solid #d1d5db; border-radius:8px; padding:10px; font-size:14px; }
.form button { align-self:flex-start; padding:10px 14px; border-radius:10px; border:1px solid #d1d5db; background:#e9ecef; font-weight:700; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo"><i class="fas fa-store"></i> <span>Logo</span></div>
  <nav class="nav-menu">
    <a href="{{ route('resident.index') }}" class="nav-item"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
    <a href="{{ route('program') }}" class="nav-item active"><i class="fas fa-boxes"></i><span>Programs</span></a>
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
    <h1>Add Program</h1>
    <a href="{{ route('program') }}" class="btn-back" title="Back to Programs">
      <i class="fas fa-arrow-left"></i>
      Back
    </a>
  </div>

  <div class="container">
    <div class="grid">
      <!-- Sample card preview (static to match provided design) -->
      <div class="program-card">
        <h3>Medical Mission</h3>
        <div class="row">Location: <strong>Purok II</strong></div>
        <div class="status completed">Status: Completed</div>
        <p>Basic health check-ups and free medicines were provided to residents.</p>
        <div class="meta">Date: 2025-10-10</div>
      </div>

      <!-- Placeholder form (static for now) -->
      <div class="form">
        <h4>New Program (static prototype)</h4>
        <div class="field">
          <label>Title</label>
          <input type="text" placeholder="e.g., Medical Mission" />
        </div>
        <div class="field">
          <label>Location</label>
          <select name="location" required>
            <option value="" disabled selected>Select Purok</option>
            <option value="Purok I">Purok I</option>
            <option value="Purok II">Purok II</option>
            <option value="Purok III">Purok III</option>
            <option value="Purok IV">Purok IV</option>
            <option value="Purok V">Purok V</option>
          </select>
        </div>
        <div class="field">
          <label>Status</label>
          <select>
            <option>Upcoming</option>
            <option>Ongoing</option>
            <option>Completed</option>
          </select>
        </div>
        <div class="field">
          <label>Description</label>
          <textarea rows="4" placeholder="Short description..."></textarea>
        </div>
        <div class="field">
          <label>Date</label>
          <input type="date" />
        </div>
        <button type="button">Save (static)</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
