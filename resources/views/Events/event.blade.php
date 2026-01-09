<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - MSWD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
            background: #f5f5f5; 
            min-height: 100vh; 
            margin: 0; 
            display: flex; 
        }

        /* Sidebar */
        .sidebar { 
            width: 250px; 
            background: #1a1a2e; 
            min-height: 100vh; 
            padding: 30px 0; 
            position: fixed; 
            left: 0; 
            top: 0; 
            display: flex; 
            flex-direction: column; 
        }
        .logo { 
            color: #fff; 
            font-size: 24px; 
            font-weight: 700; 
            padding: 0 30px; 
            margin-bottom: 30px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .nav-menu { 
            flex: 1; 
            padding: 0 15px;
        }
        .nav-item { 
            color: #999; 
            padding: 15px 30px; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            transition: all 0.3s ease; 
            cursor: pointer; 
            border-radius: 6px;
            margin: 5px 15px;
        }
        .nav-item:hover, .nav-item.active { 
            background: rgba(255, 255, 255, 0.1); 
            color: #fff; 
        }
        .nav-item i { 
            width: 20px; 
            text-align: center; 
            font-size: 18px;
        }
        .sidebar-footer {
            padding: 15px 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .header h1 {
            color: #1a1a2e;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .btn {
            background: #1a1a2e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #1a1a2e;
        }
        
        .btn i {
            font-size: 14px;
        }
        
        /* Events Grid */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .event-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .event-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .event-image {
            height: 180px;
            background: #f0f0f0;
            position: relative;
            overflow: hidden;
        }
        
        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .event-date {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
        }
        
        .event-details {
            padding: 20px;
        }
        
        .event-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #1a1a2e;
        }
        
        .event-meta {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 13px;
            color: #666;
            gap: 15px;
        }
        
        .event-meta i {
            color: #1a1a2e;
            width: 16px;
            text-align: center;
        }
        
        .event-description {
            color: #666;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        .no-events {
            text-align: center;
            padding: 50px 20px;
            color: #888;
            grid-column: 1 / -1;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .no-events i {
            font-size: 48px;
            color: #e0e0e0;
            margin-bottom: 15px;
        }
        
        .no-events h3 {
            color: #555;
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .no-events p {
            color: #888;
            font-size: 14px;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h2 {
            margin: 0;
            font-size: 18px;
            color: #1a1a2e;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1a1a2e;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 15px 20px;
            border-top: 1px solid #eee;
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid #ddd;
            color: #555;
        }
        
        .btn-outline:hover {
            background: #f5f5f5;
            color: #333;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .events-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-calendar-alt"></i>
            <span>MSWD</span>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('resident.index') }}" class="nav-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('events') }}" class="nav-item active">
                <i class="fas fa-calendar-alt"></i>
                <span>Events</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ url()->previous() }}" class="icon-btn" style="text-decoration: none;" title="Go back">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1>Upcoming Events</h1>
            </div>
            <button class="btn" onclick="openAddEventModal()">
                <i class="fas fa-plus"></i> Add Event
            </button>
        </div>

        <div class="events-grid">
            <!-- Event cards will be dynamically loaded here -->
            <div class="no-events">
                <i class="fas fa-calendar-plus"></i>
                <h3>No events scheduled</h3>
                <p>Click the 'Add Event' button to create your first event.</p>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div id="addEventModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Event</h2>
                <button type="button" onclick="closeAddEventModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #666;">&times;</button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="form-group">
                        <label for="eventTitle">Event Title</label>
                        <input type="text" id="eventTitle" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Date & Time</label>
                        <input type="datetime-local" id="eventDate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="eventLocation">Location</label>
                        <input type="text" id="eventLocation" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDescription">Description</label>
                        <textarea id="eventDescription" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="closeAddEventModal()">Cancel</button>
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Save Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to open the add event modal
        function openAddEventModal() {
            document.getElementById('addEventModal').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }
        
        // Function to close the add event modal
        function closeAddEventModal() {
            document.getElementById('addEventModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
        
        // Function to handle form submission
        document.getElementById('eventForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically send the data to your server
            // For now, we'll just show a success message
            alert('Event saved successfully!');
            closeAddEventModal();
        });
        
        // Close modal when clicking outside of it or pressing Escape key
        window.onclick = function(event) {
            const modal = document.getElementById('addEventModal');
            if (event.target === modal) {
                closeAddEventModal();
            }
        };
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAddEventModal();
            }
        });
        
        // Toggle mobile sidebar
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const menuBtn = document.querySelector('.menu-btn');
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && event.target !== menuBtn) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>
