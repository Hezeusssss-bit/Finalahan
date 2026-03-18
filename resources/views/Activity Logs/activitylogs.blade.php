<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Activity Logs - YOTS</title>
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
    border-radius: 12px; 
    margin-bottom: 4px;
    font-weight: 500;
    font-size: 14px;
}

.nav-item:hover { 
    background: rgba(59, 130, 246, 0.15); 
    color: #fff; 
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

.nav-item i { 
    width: 20px; 
    text-align: center; 
    font-size: 16px;
}

.sidebar-content {
    flex: 1;
    overflow-y: auto;
    padding-bottom: 20px;
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

/* Main Content */
.main-content { 
    margin-left: 0; 
    flex: 1; 
    padding: 35px; 
    background: #f8fafc;
    min-height: 100vh;
}

.header {
    background: #fff;
    padding: 25px 30px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    border: 1px solid rgba(226, 232, 240, 0.8);
}

.header h1 {
    color: #1e293b;
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}

/* Card Styles */
.card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(226, 232, 240, 0.8);
    overflow: hidden;
    margin-bottom: 30px;
}

.card-header {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    padding: 20px 25px;
    border: none;
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-body {
    padding: 25px;
}

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.table th,
.table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.table th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    color: #6b7280;
    font-size: 14px;
}

.table tbody tr:hover {
    background: #f9fafb;
}

.table-bordered {
    border: 1px solid #e5e7eb;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #e5e7eb;
}

.table-striped tbody tr:nth-child(odd) {
    background: #f9fafb;
}

.text-center {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
  .main-content { padding: 20px; }
  .header h1 { font-size: 22px; }
  .card-body { padding: 15px; }
}

/* Back Button Hover Effect */
.back-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  background: #f8f9fa;
}
</style>
</head>
<body>


<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; align-items: center; gap: 15px;">
        <a href="{{ route('resident.index') }}" class="back-button" style="
          display: flex;
          justify-content: center;
          align-items: center;
          width: 40px;
          height: 40px;
          background: #ffffff;
          color: #333;
          text-decoration: none;
          border-radius: 50%;
          font-size: 18px;
          transition: all 0.3s ease;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        ">
          <i class="fas fa-arrow-left"></i>
        </a>
        <h1>Activity Logs</h1>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <i class="fas fa-history"></i>
        System Activity Logs
      </h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Action</th>
              <th>Description</th>
              <th>IP Address</th>
              <th>Date & Time</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($logs) && count($logs) > 0)
              @foreach($logs as $log)
              <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->user_name ?? 'N/A' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->ip_address }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
              </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" class="text-center">No activity logs found.</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function confirmLogout(button) {
  if(confirm('Are you sure you want to logout?')) {
    button.closest('form').submit();
  }
}
</script>

</body>
</html>
