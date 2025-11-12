<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Venue</title>
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
    .btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 999px; border: 1px solid #e5e7eb; background: #fff; color: #1a1a2e; text-decoration: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform .15s ease, box-shadow .15s ease, background .15s ease; font-weight: 600; font-size: 14px; }
    .btn-back:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); background:#f9fafb; }
    .btn-back i { font-size: 14px; color:#1a1a2e; }

    /* Form Styles */
    .form-container { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); max-width: 800px; margin: 0 auto; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #1a1a2e; }
    .btn { padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; border: none; display: inline-flex; align-items: center; gap: 8px; }
    .btn-primary { background: #1a1a2e; color: white; }
    .btn-primary:hover { background: #2a2a3e; transform: translateY(-1px); }
    .btn-secondary { background: #f5f5f5; color: #333; }
    .btn-secondary:hover { background: #e5e5e5; }
    .full-width { grid-column: 1 / -1; }
    .text-center { text-align: center; }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar { width: 70px; }
        .logo span, .nav-item span { display: none; }
        .main-content { margin-left: 70px; padding: 20px; }
        .form-grid { grid-template-columns: 1fr; }
    }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo"><i class="fas fa-store"></i> <span>Logo</span></div>
        <nav class="nav-menu">
            <a href="{{ route('resident.index') }}" class="nav-item"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
            <a href="{{ route('services.assignvenue') }}" class="nav-item active"><i class="fas fa-map-marker-alt"></i><span>Assign Venue</span></a>
            <a href="#" class="nav-item"><i class="fas fa-users"></i><span>IDP's</span></a>
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
            <h1>Assign Venue</h1>
            <a href="{{ route('services') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Back to Services
            </a>
        </div>

        <div class="form-container">
            <form action="{{ route('services.assignvenue.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="resident_name">Resident Name</label>
                        <input type="text" id="resident_name" name="resident_name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" id="contact_number" name="contact_number" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="event_type">Event Type</label>
                        <select id="event_type" name="event_type" class="form-control" required>
                            <option value="">Select Event Type</option>
                            <option value="wedding">Wedding</option>
                            <option value="birthday">Birthday</option>
                            <option value="meeting">Barangay Meeting</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="venue">Select Venue</label>
                        <select id="venue" name="venue" class="form-control" required>
                            <option value="">Select Venue</option>
                            <option value="barangay_hall">Barangay Hall</option>
                            <option value="covered_court">Covered Court</option>
                            <option value="multi_purpose_hall">Multi-Purpose Hall</option>
                            <option value="open_field">Open Field</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="event_date">Event Date</label>
                        <input type="date" id="event_date" name="event_date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="form-control" required>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="purpose">Purpose/Description</label>
                        <textarea id="purpose" name="purpose" rows="3" class="form-control" required></textarea>
                    </div>
                </div>
                
                <div class="form-group text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Venue Assignment
                    </button>
                    <a href="{{ route('services') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert success" id="successAlert" style="position: fixed; top: 20px; right: 20px; padding: 15px 25px; background: #4CAF50; color: white; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 1000; animation: slideIn 0.5s forwards;">
        {{ session('success') }}
    </div>
    @endif

    <script>
    // Auto-hide success message after 3 seconds
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.animation = 'fadeOut 0.5s forwards';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);

    // Animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(100px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(100px); }
        }
    `;
    document.head.appendChild(style);
    </script>
</body>
</html>
