<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>{{ $employee->name }}'s Assignments - B-DEAMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: #f1f1f1; }
::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: #555; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: #f5f5f5; min-height: 100vh; margin: 0; }

/* Main Content */
.main-content { 
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

.employee-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.employee-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 24px;
}

.employee-details h1 {
    color: #1e293b; 
    font-size: 28px; 
    font-weight: 700;
    margin: 0 0 4px 0;
}

.employee-details p {
    color: #6b7280;
    font-size: 16px;
    margin: 0;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

/* Section Styles */
.section {
    background: white; 
    border-radius: 14px; 
    padding: 25px; 
    box-shadow: 0 10px 24px rgba(0,0,0,0.06); 
    margin-bottom: 20px;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f3f4f6;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-count {
    background: #f3f4f6;
    color: #6b7280;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

/* Assignment Cards */
.assignment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
}

.assignment-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s ease;
    position: relative;
}

.assignment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border-color: #3b82f6;
}

.assignment-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    border-radius: 12px 0 0 12px;
}

.assignment-card.active::before {
    background: #16a34a;
}

.assignment-card.completed::before {
    background: #6b7280;
}

.assignment-card.cancelled::before {
    background: #dc2626;
}

.assignment-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 15px;
}

.assignment-title {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 5px;
}

.assignment-location {
    font-size: 14px;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 6px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-completed {
    background: #e5e7eb;
    color: #374151;
}

.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.assignment-details {
    margin: 15px 0;
}

.assignment-details p {
    font-size: 13px;
    color: #6b7280;
    margin: 5px 0;
    line-height: 1.5;
}

.assignment-details strong {
    color: #374151;
}

.assignment-actions {
    display: flex;
    gap: 8px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.edit-btn {
    background: #eff6ff;
    color: #1d4ed8;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.edit-btn:hover {
    background: #1d4ed8;
    color: white;
}

.delete-btn {
    background: #fef2f2;
    color: #dc2626;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.delete-btn:hover {
    background: #dc2626;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6b7280;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 18px;
    margin-bottom: 8px;
    color: #374151;
}

.empty-state p {
    font-size: 14px;
}

@media (max-width: 768px) {
    .main-content {
        padding: 20px;
    }
    
    .header {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }
    
    .assignment-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>

<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <div style="display: flex; align-items: center; gap: 20px;">
      <a href="{{ route('employee-assignments.index') }}" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: white; color: black; text-decoration: none; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
        <i class="fas fa-arrow-left" style="font-size: 16px;"></i>
      </a>
      <div class="employee-info">
        <div class="employee-avatar">
          {{ strtoupper(substr($employee->name, 0, 1)) }}
        </div>
        <div class="employee-details">
          <h1>{{ $employee->name }}</h1>
          <p>{{ $employee->position }}</p>
        </div>
      </div>
    </div>
    <div style="display: flex; gap: 12px;">

    </div>
  </div>

  <!-- Active Assignments -->
  <div class="section">
    <div class="section-header">
      <div class="section-title">
        <i class="fas fa-clock" style="color: #16a34a;"></i>
        Active Assignments
      </div>
      <span class="section-count">{{ $activeAssignments->count() }}</span>
    </div>
    
    @if($activeAssignments->count() > 0)
      <div class="assignment-grid">
        @foreach($activeAssignments as $assignment)
          <div class="assignment-card active">
            <div class="assignment-header">
              <div>
                <div class="assignment-title">{{ $assignment->purok }}</div>
                <div class="assignment-location">
                  <i class="fas fa-map-marker-alt"></i>
                  {{ $assignment->purok }}
                </div>
              </div>
              <span class="status-badge status-active">
                {{ $assignment->getStatusLabel() }}
              </span>
            </div>
            
            <div class="assignment-details">
              @if($assignment->responsibilities)
                <p><strong>Responsibilities:</strong> {{ $assignment->responsibilities }}</p>
              @endif
              @if($assignment->notes)
                <p><strong>Notes:</strong> {{ $assignment->notes }}</p>
              @endif
              <p><strong>Assigned:</strong> {{ $assignment->created_at->format('M d, Y') }}</p>
            </div>
            
            <div class="assignment-actions">
              <a href="{{ route('employee-assignments.edit', $assignment) }}" class="edit-btn">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('employee-assignments.destroy', $assignment) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">
                  <i class="fas fa-trash"></i> Delete
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <i class="fas fa-clock"></i>
        <h3>No Active Assignments</h3>
        <p>This employee currently has no active assignments.</p>
      </div>
    @endif
  </div>

  <!-- Completed Assignments -->
  <div class="section">
    <div class="section-header">
      <div class="section-title">
        <i class="fas fa-check-circle" style="color: #6b7280;"></i>
        Completed Assignments
      </div>
      <span class="section-count">{{ $completedAssignments->count() }}</span>
    </div>
    
    @if($completedAssignments->count() > 0)
      <div class="assignment-grid">
        @foreach($completedAssignments as $assignment)
          <div class="assignment-card completed">
            <div class="assignment-header">
              <div>
                <div class="assignment-title">{{ $assignment->purok }}</div>
                <div class="assignment-location">
                  <i class="fas fa-map-marker-alt"></i>
                  {{ $assignment->purok }}
                </div>
              </div>
              <span class="status-badge status-completed">
                {{ $assignment->getStatusLabel() }}
              </span>
            </div>
            
            <div class="assignment-details">
              @if($assignment->responsibilities)
                <p><strong>Responsibilities:</strong> {{ $assignment->responsibilities }}</p>
              @endif
              @if($assignment->notes)
                <p><strong>Notes:</strong> {{ $assignment->notes }}</p>
              @endif
              <p><strong>Assigned:</strong> {{ $assignment->created_at->format('M d, Y') }}</p>
            </div>
            
            <div class="assignment-actions">
              <a href="{{ route('employee-assignments.edit', $assignment) }}" class="edit-btn">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('employee-assignments.destroy', $assignment) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">
                  <i class="fas fa-trash"></i> Delete
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <i class="fas fa-check-circle"></i>
        <h3>No Completed Assignments</h3>
        <p>This employee hasn't completed any assignments yet.</p>
      </div>
    @endif
  </div>

  <!-- Cancelled Assignments -->
  @if($cancelledAssignments->count() > 0)
  <div class="section">
    <div class="section-header">
      <div class="section-title">
        <i class="fas fa-times-circle" style="color: #dc2626;"></i>
        Cancelled Assignments
      </div>
      <span class="section-count">{{ $cancelledAssignments->count() }}</span>
    </div>
    
    <div class="assignment-grid">
      @foreach($cancelledAssignments as $assignment)
        <div class="assignment-card cancelled">
          <div class="assignment-header">
            <div>
              <div class="assignment-title">{{ $assignment->evacuation_center }}</div>
              <div class="assignment-location">
                <i class="fas fa-map-marker-alt"></i>
                {{ $assignment->evacuation_center }}
              </div>
            </div>
            <span class="status-badge status-cancelled">
              {{ $assignment->getStatusLabel() }}
            </span>
          </div>
          
          <div class="assignment-details">
            @if($assignment->responsibilities)
              <p><strong>Responsibilities:</strong> {{ $assignment->responsibilities }}</p>
            @endif
            @if($assignment->notes)
              <p><strong>Notes:</strong> {{ $assignment->notes }}</p>
            @endif
            <p><strong>Assigned:</strong> {{ $assignment->created_at->format('M d, Y') }}</p>
          </div>
          
          <div class="assignment-actions">
            <a href="{{ route('employee-assignments.edit', $assignment) }}" class="edit-btn">
              <i class="fas fa-edit"></i> Edit
            </a>
            <form method="POST" action="{{ route('employee-assignments.destroy', $assignment) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this assignment?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete-btn">
                <i class="fas fa-trash"></i> Delete
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  @endif

</div>

</body>
</html>
