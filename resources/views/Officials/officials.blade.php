<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officials - MSWD</title>
    <!-- Font Awesome -->
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
            margin-bottom: 50px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .nav-menu { flex: 1; }
        .nav-item { 
            color: #999; 
            padding: 15px 30px; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            transition: all 0.3s ease; 
            cursor: pointer; 
            font-size: 15px; 
        }
        .nav-item i { width: 20px; text-align: center; }
        .nav-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .nav-item.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 3px solid #fff; }
        .sidebar-footer { margin-top: auto; }

        /* Main Content */
        .main-content { 
            margin-left: 250px; 
            flex: 1; 
            padding: 30px 40px; 
        }

        /* Header */
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
        }
        .header h1 { 
            color: #1a1a2e; 
            font-size: 28px; 
            font-weight: 700; 
            margin: 0;
        }
        
        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .icon-btn:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
        }
        
        .icon-btn i {
            color: #333;
            font-size: 16px;
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
        <div class="logo"><i class="fas fa-store"></i> <span>MSWD</span></div>
        <nav class="nav-menu">
            <a href="{{ route('resident.index') }}" class="nav-item"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
            <a href="{{ route('officials') }}" class="nav-item active"><i class="fas fa-user-tie"></i><span>Officials</span></a>
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
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ url()->previous() }}" class="icon-btn" style="text-decoration: none;" title="Go back">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1>Officials</h1>
            </div>
            <button id="manageOfficialsBtn" class="btn btn-primary" style="background: #1a1a2e; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 8px; position: relative; z-index: 1;">
                <i class="fas fa-user-plus"></i> Manage Officials
            </button>
        </div>
        
        <!-- Analytics Section -->
        <div class="analytics-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- Captain Analytics -->
            <div class="analytics-card" style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0 0 5px 0; color: #1a1a2e; font-size: 16px; font-weight: 600;">Barangay Captain</h3>
                        <p style="margin: 0; color: #666; font-size: 14px;">Current Term: 2023-2025</p>
                    </div>
                    <div style="background: #e6f7ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-crown" style="font-size: 24px; color: #1a1a2e;"></i>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #888;">Total Captains</p>
                        <p style="margin: 5px 0 0 0; font-size: 24px; font-weight: 600; color: #1a1a2e;">1</p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #888;">Years Served</p>
                        <p style="margin: 5px 0 0 0; font-size: 24px; font-weight: 600; color: #1a1a2e;">2</p>
                    </div>
                </div>
            </div>

            <!-- Kagawad Analytics -->
            <div class="analytics-card" style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0 0 5px 0; color: #1a1a2e; font-size: 16px; font-weight: 600;">Barangay Kagawad</h3>
                        <p style="margin: 0; color: #666; font-size: 14px;">Current Term: 2023-2025</p>
                    </div>
                    <div style="background: #f0f9ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="font-size: 24px; color: #1a1a2e;"></i>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #888;">Total Kagawad</p>
                        <p style="margin: 5px 0 0 0; font-size: 24px; font-weight: 600; color: #1a1a2e;">7</p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #888;">Average Term</p>
                        <p style="margin: 5px 0 0 0; font-size: 24px; font-weight: 600; color: #1a1a2e;">3.5<span style="font-size: 14px; color: #888;">yrs</span></p>
                    </div>
                </div>
            </div>

            <!-- Term Analytics -->
            <div class="analytics-card" style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0 0 5px 0; color: #1a1a2e; font-size: 16px; font-weight: 600;">Term Analytics</h3>
                        <p style="margin: 0; color: #666; font-size: 14px;">Current Term Progress</p>
                    </div>
                    <div style="background: #f5f3ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chart-line" style="font-size: 24px; color: #1a1a2e;"></i>
                    </div>
                </div>
                <div style="margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-size: 12px; color: #888;">Term Progress</span>
                        <span style="font-size: 12px; font-weight: 600; color: #1a1a2e;">50%</span>
                    </div>
                    <div style="height: 6px; background: #f0f0f0; border-radius: 3px; overflow: hidden; margin-bottom: 15px;">
                        <div style="width: 50%; height: 100%; background: #1a1a2e; border-radius: 3px 0 0 3px;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <p style="margin: 0; font-size: 12px; color: #888;">Start Date</p>
                            <p style="margin: 5px 0 0 0; font-size: 14px; font-weight: 600; color: #1a1a2e;">Jun 30, 2023</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 12px; color: #888; text-align: right;">End Date</p>
                            <p style="margin: 5px 0 0 0; font-size: 14px; font-weight: 600; color: #1a1a2e; text-align: right;">Jun 30, 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="officials-container" style="margin-top: 20px;">
            <!-- Captain Section -->
            <div class="officials-section" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; overflow: hidden;">
                <div class="section-header" style="background: #1a1a2e; color: white; padding: 15px 20px; font-weight: 600; font-size: 18px;">
                    <i class="fas fa-crown" style="margin-right: 10px;"></i> Barangay Captain
                </div>
                <div class="officials-list" id="captain-list" style="padding: 20px;">
                    <!-- Captain will be listed here -->
                    <div class="no-officials" style="text-align: center; color: #666; padding: 20px 0;">
                        <i class="fas fa-user-tie" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        <p>No captain assigned yet</p>
                    </div>
                </div>
            </div>

            <!-- Kagawad Section -->
            <div class="officials-section" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; overflow: hidden;">
                <div class="section-header" style="background: #1a1a2e; color: white; padding: 15px 20px; font-weight: 600; font-size: 18px;">
                    <i class="fas fa-users" style="margin-right: 10px;"></i> Barangay Kagawad
                </div>
                <div class="officials-list" id="kagawad-list" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
                    <!-- Kagawad will be listed here -->
                    <div class="no-officials" style="text-align: center; color: #666; padding: 20px 0; grid-column: 1 / -1;">
                        <i class="fas fa-users" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        <p>No kagawad assigned yet</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manage Officials Modal -->
        <div id="manageOfficialsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
            <div style="background: white; border-radius: 8px; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
                <div style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; color: #1a1a2e;">Manage Officials</h3>
                    <button onclick="closeManageOfficialsModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #666;">&times;</button>
                </div>
                <div style="padding: 20px;">
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Position</label>
                        <select id="officialPosition" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 15px;">
                            <option value="captain">Barangay Captain</option>
                            <option value="kagawad">Barangay Kagawad</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Full Name</label>
                        <input type="text" id="officialName" class="form-control" placeholder="Enter full name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Contact Number</label>
                        <input 
                            type="tel" 
                            id="officialContact" 
                            class="form-control" 
                            placeholder="Enter contact number" 
                            pattern="[0-9]*" 
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                            maxlength="11"
                        >
                        <small style="display: block; margin-top: 5px; color: #666; font-size: 12px;">Numbers only, maximum 11 digits</small>
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Term</label>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <select id="termStart" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    <option value="">Start Year</option>
                                </select>
                            </div>
                            <div style="display: flex; align-items: center; color: #666;">to</div>
                            <div style="flex: 1;">
                                <select id="termEnd" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    <option value="">End Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px;">
                        <button onclick="closeManageOfficialsModal()" style="padding: 10px 20px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;">Cancel</button>
                        <button onclick="saveOfficial()" style="padding: 10px 20px; background: #1a1a2e; color: white; border: none; border-radius: 4px; cursor: pointer;">Save Official</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Officials data store (in a real app, this would come from a database)
        let officials = {
            captain: null,
            kagawad: []
        };

        // DOM Elements
        const modal = document.getElementById('manageOfficialsModal');
        const captainList = document.getElementById('captain-list');
        const kagawadList = document.getElementById('kagawad-list');

        // Modal Functions
        function openManageOfficialsModal() {
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
            } else {
                console.error('Modal element not found');
            }
        }

        function closeManageOfficialsModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
            // Reset form
            document.getElementById('officialName').value = '';
            document.getElementById('officialContact').value = '';
            document.getElementById('officialPosition').value = 'captain';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === modal) {
                closeManageOfficialsModal();
            }
        }

        // Generate year options for term selection
        function generateYearOptions() {
            const currentYear = new Date().getFullYear();
            const startYear = 2020; // You can adjust this as needed
            const yearSelects = document.querySelectorAll('select[id^="term"]');
            
            yearSelects.forEach(select => {
                select.innerHTML = ''; // Clear existing options
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = select.id === 'termStart' ? 'Start Year' : 'End Year';
                select.appendChild(defaultOption);
                
                for (let year = currentYear + 5; year >= startYear; year--) {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    select.appendChild(option);
                }
            });
        }

        // Save Official Function
        function saveOfficial() {
            const position = document.getElementById('officialPosition').value;
            const name = document.getElementById('officialName').value.trim();
            const contact = document.getElementById('officialContact').value.trim();
            const termStart = document.getElementById('termStart').value;
            const termEnd = document.getElementById('termEnd').value;

            // Basic validation
            if (!name) {
                alert('Please enter the official\'s name');
                return;
            }
            if (!termStart || !termEnd) {
                alert('Please select both start and end years for the term');
                return;
            }
            if (parseInt(termStart) >= parseInt(termEnd)) {
                alert('End year must be after start year');
                return;
            }

            const official = {
                id: Date.now(),
                name: name,
                contact: contact,
                position: position,
                termStart: termStart,
                termEnd: termEnd,
                startDate: new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
            };

            if (position === 'captain') {
                officials.captain = official;
                updateCaptainDisplay();
            } else {
                officials.kagawad.push(official);
                updateKagawadDisplay();
            }

            // Close modal and reset form
            closeManageOfficialsModal();
            updateAnalytics();
        }

        // Update Captain Display
        function updateCaptainDisplay() {
            if (officials.captain) {
                captainList.innerHTML = `
                    <div class="official-card" style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                            <div style="background: #e6f7ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-crown" style="font-size: 24px; color: #1a1a2e;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="margin: 0 0 5px 0; color: #1a1a2e; font-size: 18px;">${officials.captain.name}</h3>
                                <p style="margin: 0 0 5px 0; color: #666; font-size: 14px;">
                                    <i class="fas fa-phone-alt" style="margin-right: 5px;"></i>${officials.captain.contact || 'N/A'}
                                </p>
                                <div style="display: flex; align-items: center; gap: 10px; background: #f8f9fa; padding: 5px 10px; border-radius: 4px; margin-top: 8px; font-size: 12px;">
                                    <span style="color: #1a1a2e; font-weight: 500;">Term:</span>
                                    <span style="color: #1890ff; background: #e6f7ff; padding: 2px 8px; border-radius: 10px; font-weight: 500;">
                                        ${officials.captain.termStart} - ${officials.captain.termEnd}
                                    </span>
                                    <span style="color: ${new Date().getFullYear() > officials.captain.termEnd ? '#ff4d4f' : '#52c41a'}; font-weight: 500;">
                                        ${new Date().getFullYear() > officials.captain.termEnd ? 'Term Ended' : 'Active'}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 10px;">
                            <span>Since: ${officials.captain.startDate}</span>
                            <button onclick="deleteOfficial('captain', ${officials.captain.id})" style="background: none; border: none; color: #ff4d4f; cursor: pointer; font-size: 12px;">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </div>
                    </div>
                `;
            } else {
                captainList.innerHTML = `
                    <div class="no-officials" style="text-align: center; color: #666; padding: 20px 0;">
                        <i class="fas fa-user-tie" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        <p>No captain assigned yet</p>
                    </div>
                `;
            }
        }

        // Update Kagawad Display
        function updateKagawadDisplay() {
            if (officials.kagawad && officials.kagawad.length > 0) {
                kagawadList.innerHTML = officials.kagawad.map(kagawad => {
                    if (!kagawad) return '';
                    const isTermActive = kagawad.termEnd ? (new Date().getFullYear() <= kagawad.termEnd) : false;
                    return `
                    <div class="official-card" style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
                            <div style="background: #f0f9ff; min-width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: #1a1a2e;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="margin: 0 0 3px 0; color: #1a1a2e; font-size: 16px;">${kagawad.name || 'Unnamed Official'}</h4>
                                <p style="margin: 0 0 5px 0; color: #666; font-size: 13px;">
                                    <i class="fas fa-phone-alt" style="margin-right: 3px; font-size: 12px;"></i>${kagawad.contact || 'N/A'}
                                </p>
                                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 5px; margin-top: 5px;">
                                    <span style="font-size: 11px; color: #1a1a2e; background: #f0f9ff; padding: 2px 8px; border-radius: 10px;">
                                        ${kagawad.termStart || 'N/A'} - ${kagawad.termEnd || 'N/A'}
                                    </span>
                                    <span style="font-size: 11px; color: ${isTermActive ? '#52c41a' : '#ff4d4f'}; font-weight: 500;">
                                        ${isTermActive ? 'Active' : 'Term Ended'}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; border-top: 1px solid #eee; padding-top: 8px;">
                            <span>Since: ${kagawad.startDate || 'N/A'}</span>
                            <button onclick="deleteOfficial('kagawad', ${kagawad.id || 0})" style="background: none; border: none; color: #ff4d4f; cursor: pointer; font-size: 11px; display: flex; align-items: center; gap: 3px;">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </div>
                    </div>`;
                }).filter(Boolean).join('');
            } else {
                kagawadList.innerHTML = `
                    <div class="no-officials" style="text-align: center; color: #666; padding: 20px 0; grid-column: 1 / -1;">
                        <i class="fas fa-users" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        <p>No kagawad assigned yet</p>
                    </div>
                `;
            }
        }

        // Delete Official Function
        function deleteOfficial(type, id) {
            if (confirm('Are you sure you want to remove this official?')) {
                if (type === 'captain') {
                    officials.captain = null;
                    updateCaptainDisplay();
                } else {
                    officials.kagawad = officials.kagawad.filter(k => k.id !== id);
                    updateKagawadDisplay();
                }
                updateAnalytics();
            }
        }

        // Update Analytics
        function updateAnalytics() {
            // In a real app, you would update analytics based on the officials data
            // For now, we'll just log the current state
            console.log('Officials updated:', officials);
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listener to the button
            const manageBtn = document.getElementById('manageOfficialsBtn');
            if (manageBtn) {
                manageBtn.addEventListener('click', openManageOfficialsModal);
            } else {
                console.error('Manage Officials button not found');
            }
            
            // Make sure modal is accessible
            const modal = document.getElementById('manageOfficialsModal');
            if (!modal) {
                console.error('Modal element not found');
            }
            generateYearOptions();
            updateCaptainDisplay();
            updateKagawadDisplay();
            updateAnalytics();
            
            // Auto-update end year when start year changes
            document.getElementById('termStart').addEventListener('change', function() {
                const startYear = parseInt(this.value);
                const endYearSelect = document.getElementById('termEnd');
                if (startYear && (!endYearSelect.value || parseInt(endYearSelect.value) <= startYear)) {
                    endYearSelect.value = startYear + 3; // Default 3-year term
                }
            });
        });

        function openLogoutModal() {
            // Add your logout modal logic here
            console.log('Logout clicked');
        }
    </script>
</body>
</html>
