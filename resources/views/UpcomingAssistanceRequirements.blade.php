<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upcoming Assistance Requirements - B-DEAMS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --navy: #0d1b2a;
            --navy-mid: #1b2e42;
            --navy-light: #243447;
            --teal: #0ea5a0;
            --teal-light: #e0f7f6;
            --amber: #f59e0b;
            --amber-light: #fef3c7;
            --rose: #f43f5e;
            --rose-light: #ffe4e6;
            --green: #10b981;
            --green-light: #d1fae5;
            --blue: #3b82f6;
            --blue-light: #dbeafe;
            --slate-light: #f1f5f9;
            --white: #ffffff;
            --border: #e2e8f0;
            --text-dark: #0f172a;
            --text-mid: #475569;
            --text-muted: #94a3b8;
            --sidebar-w: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f0f4f8;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        
        /* Main Content */
        .main {
            margin-left: 0;
            flex: 1;
            padding: 36px 40px;
            min-height: 100vh;
            width: 100%;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 32px;
        }

        .page-eyebrow {
            font-size: 11.5px;
            font-weight: 500;
            color: var(--teal);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 6px;
        }

        .page-title {
            font-family: 'Outfit', sans-serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb a:hover {
            color: var(--teal);
        }

        .breadcrumb .separator {
            color: var(--text-muted);
        }

        .breadcrumb .current {
            color: var(--text-dark);
            font-weight: 500;
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-mid);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 24px;
        }

        .back-btn:hover {
            background: var(--slate-light);
            color: var(--teal);
            border-color: var(--teal);
        }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-mid);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.teal { background: var(--teal-light); color: var(--teal); }
        .stat-icon.blue { background: var(--blue-light); color: var(--blue); }
        .stat-icon.amber { background: var(--amber-light); color: var(--amber); }
        .stat-icon.rose { background: var(--rose-light); color: var(--rose); }

        .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Requirements Table */
        .requirements-container {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .requirements-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .requirements-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-controls {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 8px 12px 8px 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            width: 250px;
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--teal);
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .filter-btn {
            padding: 8px 16px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-mid);
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            background: var(--slate-light);
            border-color: var(--teal);
            color: var(--teal);
        }

        .filter-btn.active {
            background: var(--teal);
            color: white;
            border-color: var(--teal);
        }

        .requirements-table {
            width: 100%;
            border-collapse: collapse;
        }

        .requirements-table th {
            background: var(--slate-light);
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-mid);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
        }

        .requirements-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            color: var(--text-dark);
        }

        .requirements-table tr:hover {
            background: var(--slate-light);
        }

        .program-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: var(--teal-light);
            color: var(--teal);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .program-badge.evacuee {
            background: var(--rose-light);
            color: var(--rose);
        }

        .location-info {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-mid);
            font-size: 13px;
        }

        .date-info {
            font-size: 13px;
            color: var(--text-muted);
        }

        .needs-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .need-tag {
            padding: 3px 8px;
            background: var(--slate-light);
            border-radius: 4px;
            font-size: 11px;
            color: var(--text-mid);
        }

        .need-tag.critical {
            background: var(--rose-light);
            color: var(--rose);
        }

        .need-tag.urgent {
            background: var(--amber-light);
            color: var(--amber);
        }

        .priority-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .priority-badge.high {
            background: var(--rose-light);
            color: var(--rose);
        }

        .priority-badge.medium {
            background: var(--amber-light);
            color: var(--amber);
        }

        .priority-badge.low {
            background: var(--green-light);
            color: var(--green);
        }

        .actions-cell {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 10px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: var(--teal);
            color: white;
            border-color: var(--teal);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-mid);
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 24px;
        }

        /* Loading State */
        .loading-state {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
        }

        .loading-state i {
            font-size: 32px;
            margin-bottom: 12px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main {
                padding: 20px;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .filter-controls {
                flex-direction: column;
                gap: 8px;
            }

            .search-box input {
                width: 200px;
            }

            .requirements-table {
                font-size: 12px;
            }

            .requirements-table th,
            .requirements-table td {
                padding: 8px;
            }

            .needs-tags {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <main class="main">
        <!-- Breadcrumb -->


        <!-- Page Header -->
        <header class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
            <div>
                <h1 class="page-title">DSS Analytics Dashboard</h1>
            </div>
            
            <!-- Back Button -->
            <a href="{{ route('resident.index') }}" class="back-btn" style="
                background: linear-gradient(135deg, var(--teal) 0%, #0d9488 100%);
                color: white;
                padding: 8px 16px;
                border-radius: 8px;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                font-weight: 500;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 2px 4px rgba(14, 165, 160, 0.2);
                border: none;
                cursor: pointer;
            " onmouseover="
                this.style.background = 'linear-gradient(135deg, #0d9488 0%, #0f766e 100%)';
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(14, 165, 160, 0.3)';
            " onmouseout="
                this.style.background = 'linear-gradient(135deg, var(--teal) 0%, #0d9488 100%)';
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 4px rgba(14, 165, 160, 0.2)';
            " onmousedown="
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 6px rgba(14, 165, 160, 0.4)';
            " onmouseup="
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(14, 165, 160, 0.3)';
            ">
                <i class="fas fa-arrow-left" style="font-size: 11px;"></i>
                <span>Back to Dashboard</span>
            </a>
        </header>

        <!-- Statistics Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Programs</div>
                    <div class="stat-icon teal">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <div class="stat-value" id="totalPrograms">-</div>
                <div class="stat-label">Upcoming assistance programs</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Families</div>
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value" id="totalFamilies">-</div>
                <div class="stat-label">Families requiring assistance</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">High Priority</div>
                    <div class="stat-icon amber">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-value" id="highPriority">-</div>
                <div class="stat-label">Programs needing immediate attention</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Evacuee Programs</div>
                    <div class="stat-icon rose">
                        <i class="fas fa-person-shelter"></i>
                    </div>
                </div>
                <div class="stat-value" id="evacueePrograms">-</div>
                <div class="stat-label">Emergency response programs</div>
            </div>
        </div>

        <!-- Analytics Sections -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
            <!-- Evacuation Area Analytics -->
            <div class="panel" style="border-radius: 12px;">
                <div style="padding: 16px; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h3 style="color: var(--navy); font-size: 14px; font-weight: 600; margin: 0;">
                            <i class="fas fa-building" style="color: var(--teal); margin-right: 6px;"></i>
                            Evacuation Area Analytics
                        </h3>
                        <button onclick="refreshEvacuationAnalytics()" style="background: var(--teal); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='#0d9488'" onmouseout="this.style.background='var(--teal)'">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>
                </div>
                <div style="padding: 16px;">
                    <div id="evacuationAreaAnalytics">
                        <!-- Evacuation area analytics will be loaded here -->
                        <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                            <i class="fas fa-spinner fa-spin" style="font-size: 20px; margin-bottom: 8px;"></i>
                            <div style="font-size: 12px;">Loading evacuation area analytics...</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Insights & Recommendations -->
            <div class="panel" style="border-radius: 12px;">
                <div style="padding: 16px; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h3 style="color: var(--navy); font-size: 14px; font-weight: 600; margin: 0;">
                            <i class="fas fa-lightbulb" style="color: var(--amber); margin-right: 6px;"></i>
                            Key Insights & Recommendations
                        </h3>
                        <button onclick="refreshRecommendations()" style="background: var(--teal); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='#0d9488'" onmouseout="this.style.background='var(--teal)'">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>
                </div>
                <div style="padding: 16px;">
                    <!-- Evacuee-Specific Insights -->
                    <div style="background: var(--rose-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--rose); margin-bottom: 16px;">
                        <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">
                            <i class="fas fa-exclamation-triangle" style="color: var(--rose); margin-right: 4px; font-size: 11px;"></i>
                            Evacuee Response Priority
                        </div>
                        <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">
                            <div style="margin-bottom: 4px;">
                                <strong>Immediate Action Required:</strong> {{ $totalEvacuees > 0 ? 'Activate emergency protocols for ' . $totalEvacuees . ' evacuees' : 'No active evacuees' }}
                            </div>
                            <div style="margin-bottom: 4px;">
                                <strong>Shelter Capacity:</strong> {{ $totalEvacuees > 0 ? round(($totalEvacuees / 500) * 100) . '% occupancy - ' . ($totalEvacuees > 400 ? 'CRITICAL' : 'MANAGEABLE') : 'No current occupancy' }}
                            </div>
                            <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">
                                <i class="fas fa-chart-line" style="margin-right: 2px;"></i>
                                Based on real-time evacuee data analysis
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                        @php
                            // Dynamic DSS: Analyze actual family data from residents to recommend programs
                            $purokAnalytics = [];
                            
                            // Initialize purok data structure
                            $puroks = ['Purok I', 'Purok II', 'Purok III', 'Purok IV', 'Purok V'];
                            
                            foreach($puroks as $purok) {
                                $purokAnalytics[$purok] = [
                                    'total_families' => 0,
                                    'senior_count' => 0,
                                    'child_count' => 0,
                                    'pregnant_count' => 0,
                                    'pwd_count' => 0,
                                    'no_contact_count' => 0,
                                    'large_family_count' => 0,
                                    'recommendations' => []
                                ];
                            }
                            
                            // Analyze actual resident data
                            if(isset($residents)) {
                                foreach($residents as $resident) {
                                    $purok = $resident->description ?? 'Unassigned';
                                    
                                    if(!isset($purokAnalytics[$purok])) {
                                        $purokAnalytics[$purok] = [
                                            'total_families' => 0,
                                            'senior_count' => 0,
                                            'child_count' => 0,
                                            'pregnant_count' => 0,
                                            'pwd_count' => 0,
                                            'no_contact_count' => 0,
                                            'large_family_count' => 0,
                                            'recommendations' => []
                                        ];
                                    }
                                    
                                    $purokAnalytics[$purok]['total_families']++;
                                    
                                    // Count demographics
                                    if($resident->family_head_age >= 60) $purokAnalytics[$purok]['senior_count']++;
                                    if($resident->wife_age >= 60) $purokAnalytics[$purok]['senior_count']++;
                                    if($resident->family_head_age < 18 && $resident->family_head_age > 0) $purokAnalytics[$purok]['child_count']++;
                                    if($resident->wife_age < 18 && $resident->wife_age > 0) $purokAnalytics[$purok]['child_count']++;
                                    
                                    // Check other family members
                                    $otherMembers = ['son', 'daughter', 'grandmother', 'grandfather'];
                                    foreach($otherMembers as $member) {
                                        $ageField = $member . '_age';
                                        if($resident->$ageField) {
                                            if($resident->$ageField >= 60) $purokAnalytics[$purok]['senior_count']++;
                                            if($resident->$ageField < 18 && $resident->$ageField > 0) $purokAnalytics[$purok]['child_count']++;
                                        }
                                    }
                                    
                                    if($resident->wife_pregnant) $purokAnalytics[$purok]['pregnant_count']++;
                                    
                                    // Check PWD
                                    if($resident->family_head_pwd || $resident->wife_pwd || $resident->son_pwd || 
                                       $resident->daughter_pwd || $resident->grandmother_pwd || $resident->grandfather_pwd) {
                                        $purokAnalytics[$purok]['pwd_count']++;
                                    }
                                    
                                    // Check contact info
                                    if(!$resident->contact_number) $purokAnalytics[$purok]['no_contact_count']++;
                                    
                                    // Count family members for large family detection
                                    $familySize = 1; // family head
                                    if($resident->wife_fullname) $familySize++;
                                    
                                    foreach($otherMembers as $member) {
                                        $nameField = $member . '_fullname';
                                        if($resident->$nameField) $familySize++;
                                    }
                                    
                                    if($familySize >= 5) $purokAnalytics[$purok]['large_family_count']++;
                                    
                                    // Generate recommendations based on demographics
                                    $recommendations = [];
                                    
                                    if($purokAnalytics[$purok]['senior_count'] > 0) {
                                        $recommendations[] = 'Senior Citizen Care';
                                        $recommendations[] = 'Medical Mission';
                                    }
                                    
                                    if($purokAnalytics[$purok]['child_count'] > 0) {
                                        $recommendations[] = 'Child Protection';
                                        $recommendations[] = 'Educational Support';
                                    }
                                    
                                    if($purokAnalytics[$purok]['pregnant_count'] > 0) {
                                        $recommendations[] = 'Maternal Health';
                                        $recommendations[] = 'Nutrition Program';
                                    }
                                    
                                    if($purokAnalytics[$purok]['pwd_count'] > 0) {
                                        $recommendations[] = 'PWD Assistance';
                                        $recommendations[] = 'Accessibility Programs';
                                    }
                                    
                                    if($purokAnalytics[$purok]['large_family_count'] > 0) {
                                        $recommendations[] = 'Food Security';
                                        $recommendations[] = 'Livelihood Training';
                                    }
                                    
                                    if($purokAnalytics[$purok]['no_contact_count'] > 0) {
                                        $recommendations[] = 'Community Outreach';
                                        $recommendations[] = 'Contact Registration';
                                    }
                                    
                                    $purokAnalytics[$purok]['recommendations'] = array_unique($recommendations);
                                }
                            }
                        @endphp
                        
                        @foreach($purokAnalytics as $purok => $analytics)
                            @if($analytics['total_families'] > 0)
                                <div style="background: var(--slate-light); padding: 14px; border-radius: 8px; border-left: 4px solid var(--amber);">
                                    <div style="font-weight: 600; color: var(--navy); font-size: 13px; margin-bottom: 6px;">
                                        <i class="fas fa-map-marker-alt" style="color: var(--amber); margin-right: 4px; font-size: 11px;"></i>
                                        {{ $purok }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--text-mid); line-height: 1.4;">
                                        <div style="margin-bottom: 4px;">
                                            @php
                                                $purokRecommendations = 'No specific recommendations';
                                                $purokRecs = $analytics['recommendations'] ?? [];
                                                if(!empty($purokRecs) && is_array($purokRecs)) {
                                                    $purokRecommendations = implode(', ', array_slice($purokRecs, 0, 2));
                                                    if(count($purokRecs) > 2) {
                                                        $purokRecommendations .= ' +' . (count($purokRecs) - 2) . ' more';
                                                    }
                                                }
                                            @endphp
                                            {{ $purokRecommendations }}
                                        </div>
                                        <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">
                                            <i class="fas fa-chart-line" style="margin-right: 2px;"></i>
                                            Based on family data analysis
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Requirements Table -->
        <div class="requirements-container">
            <div class="requirements-header">
                <h2 class="requirements-title">
                    <i class="fas fa-clipboard-list" style="color: var(--teal);"></i>
                    Assistance Requirements Details
                </h2>
                <div class="filter-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search programs...">
                    </div>
                    <select class="filter-btn" id="priorityFilter">
                        <option value="">All Priorities</option>
                        <option value="high">High Priority</option>
                        <option value="medium">Medium Priority</option>
                        <option value="low">Low Priority</option>
                    </select>
                    <select class="filter-btn" id="programFilter">
                        <option value="">All Programs</option>
                        <option value="evacuee">Evacuee Programs</option>
                        <option value="regular">Regular Programs</option>
                    </select>
                </div>
            </div>

            <div class="requirements-body">
                <div id="loadingState" class="loading-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading assistance requirements...</p>
                </div>

                <div id="requirementsContent" style="display: none;">
                    <table class="requirements-table">
                        <thead>
                            <tr>
                                <th>Program Details</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Families</th>
                                <th>Priority</th>
                                <th>Needs</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="requirementsTableBody">
                            <!-- Requirements will be loaded here -->
                        </tbody>
                    </table>

                    <div id="emptyState" class="empty-state" style="display: none;">
                        <i class="fas fa-clipboard-check"></i>
                        <h3>No Upcoming Requirements</h3>
                        <p>There are currently no upcoming assistance requirements.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Real data from controller - same as dashboard
        const rawRequirements = @json($assistanceRequirements);
        
        // Transform data to match expected format
        let allRequirements = rawRequirements.map((req, index) => {
            const isEvacuee = req.program_title === 'Evacuee Program';
            
            // Determine priority based on program type and other factors
            let priority = 'medium';
            if (isEvacuee) {
                priority = 'high'; // Evacuee programs are always high priority
            } else if (req.total_residents > 30) {
                priority = 'medium';
            } else {
                priority = 'low';
            }
            
            // Transform specific needs to match expected format
            let specific_needs = {};
            
            if (isEvacuee && req.dss_metrics) {
                // Use DSS metrics for evacuee programs
                specific_needs = {
                    daily_meals: req.dss_metrics.daily_meals,
                    water_needed: req.dss_metrics.water_needed,
                    hygiene_kits: req.dss_metrics.hygiene_kits,
                    blankets: req.dss_metrics.blankets,
                    baby_formula: req.dss_metrics.baby_formula,
                    medicine_kits: req.dss_metrics.medicine_kits,
                    first_aid_kits: req.dss_metrics.first_aid_kits,
                    diapers: req.dss_metrics.diapers,
                    adult_diapers: req.dss_metrics.adult_diapers,
                    wheelchairs: req.dss_metrics.wheelchairs,
                    walking_canes: req.dss_metrics.walking_canes,
                    rice_kilos: req.dss_metrics.rice_kilos,
                    canned_goods: req.dss_metrics.canned_goods,
                    instant_noodles: req.dss_metrics.instant_noodles,
                    toilet_paper: req.dss_metrics.toilet_paper,
                    soap_bars: req.dss_metrics.soap_bars,
                    sanitizer: req.dss_metrics.sanitizer,
                    sleeping_mats: req.dss_metrics.sleeping_mats,
                    tarpaulins: req.dss_metrics.tarpaulins,
                    rope: req.dss_metrics.rope,
                    infant_count: req.dss_metrics.infant_count,
                    clothing_needs: req.dss_metrics.clothing_needs
                };
            } else if (req.specific_needs) {
                // Use specific needs for regular programs
                specific_needs = req.specific_needs;
            }
            
            return {
                id: index + 1,
                program_title: req.program_title,
                purok: req.purok,
                start_date: req.start_date,
                total_residents: req.total_residents,
                priority: priority,
                is_evacuee: isEvacuee,
                specific_needs: specific_needs,
                pwd_count: req.pwd_count || 0,
                senior_count: req.senior_count || 0,
                pregnant_count: req.pregnant_count || 0
            };
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadRequirements();
            setupEventListeners();
            loadEvacuationAreaAnalytics(); // Load analytics on page load
        });

        function setupEventListeners() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', filterRequirements);
            
            // Filter functionality
            document.getElementById('priorityFilter').addEventListener('change', filterRequirements);
            document.getElementById('programFilter').addEventListener('change', filterRequirements);
        }

        function loadRequirements() {
            // Use real data from controller - no need to simulate loading
            displayRequirements(allRequirements);
            updateStatistics();
            
            // Hide loading, show content
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('requirementsContent').style.display = 'block';
        }

        function displayRequirements(requirements) {
            const tbody = document.getElementById('requirementsTableBody');
            const emptyState = document.getElementById('emptyState');
            
            if (requirements.length === 0) {
                tbody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            tbody.innerHTML = requirements.map(req => createRequirementRow(req)).join('');
        }

        function createRequirementRow(req) {
            const needsTags = createNeedsTags(req);
            const priorityClass = req.priority;
            
            return `
                <tr>
                    <td>
                        <div class="program-badge ${req.is_evacuee ? 'evacuee' : ''}">
                            <i class="fas fa-${req.is_evacuee ? 'person-shelter' : 'calendar-alt'}"></i>
                            ${req.program_title}
                        </div>
                    </td>
                    <td>
                        <div class="location-info">
                            <i class="fas fa-map-marker-alt"></i>
                            ${req.purok}
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            ${formatDate(req.start_date)}
                        </div>
                    </td>
                    <td>
                        <strong>${req.total_residents}</strong> families
                    </td>
                    <td>
                        <span class="priority-badge ${priorityClass}">${req.priority}</span>
                    </td>
                    <td>
                        <div class="needs-tags">
                            ${needsTags}
                        </div>
                    </td>
                    <td>
                        <div class="actions-cell">
                            <button class="action-btn" onclick="viewDetails(${req.id})">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="action-btn" onclick="editRequirement(${req.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }

        function createNeedsTags(req) {
            const needs = [];
            
            // Handle evacuee program DSS metrics
            if (req.is_evacuee) {
                if (req.specific_needs.daily_meals) {
                    needs.push(`<span class="need-tag critical">${req.specific_needs.daily_meals} meals/day</span>`);
                }
                if (req.specific_needs.water_needed) {
                    needs.push(`<span class="need-tag urgent">${req.specific_needs.water_needed}L water</span>`);
                }
                if (req.specific_needs.hygiene_kits) {
                    needs.push(`<span class="need-tag">${req.specific_needs.hygiene_kits} hygiene kits</span>`);
                }
                if (req.specific_needs.blankets) {
                    needs.push(`<span class="need-tag">${req.specific_needs.blankets} blankets</span>`);
                }
                if (req.specific_needs.first_aid_kits) {
                    needs.push(`<span class="need-tag">${req.specific_needs.first_aid_kits} first aid kits</span>`);
                }
                if (req.specific_needs.baby_formula) {
                    needs.push(`<span class="need-tag critical">${req.specific_needs.baby_formula} formula</span>`);
                }
                if (req.specific_needs.diapers) {
                    needs.push(`<span class="need-tag urgent">${req.specific_needs.diapers} diapers</span>`);
                }
                if (req.specific_needs.adult_diapers) {
                    needs.push(`<span class="need-tag">${req.specific_needs.adult_diapers} adult diapers</span>`);
                }
                if (req.specific_needs.medicine_kits) {
                    needs.push(`<span class="need-tag">${req.specific_needs.medicine_kits} medicine kits</span>`);
                }
                if (req.specific_needs.wheelchairs) {
                    needs.push(`<span class="need-tag">${req.specific_needs.wheelchairs} wheelchairs</span>`);
                }
                if (req.specific_needs.walking_canes) {
                    needs.push(`<span class="need-tag">${req.specific_needs.walking_canes} walking canes</span>`);
                }
                if (req.specific_needs.rice_kilos) {
                    needs.push(`<span class="need-tag">${req.specific_needs.rice_kilos}kg rice</span>`);
                }
                if (req.specific_needs.canned_goods) {
                    needs.push(`<span class="need-tag">${req.specific_needs.canned_goods} canned goods</span>`);
                }
                if (req.specific_needs.instant_noodles) {
                    needs.push(`<span class="need-tag">${req.specific_needs.instant_noodles} noodles</span>`);
                }
                if (req.specific_needs.toilet_paper) {
                    needs.push(`<span class="need-tag">${req.specific_needs.toilet_paper} toilet paper</span>`);
                }
                if (req.specific_needs.soap_bars) {
                    needs.push(`<span class="need-tag">${req.specific_needs.soap_bars} soap bars</span>`);
                }
                if (req.specific_needs.sanitizer) {
                    needs.push(`<span class="need-tag">${req.specific_needs.sanitizer} sanitizer</span>`);
                }
                if (req.specific_needs.sleeping_mats) {
                    needs.push(`<span class="need-tag">${req.specific_needs.sleeping_mats} sleeping mats</span>`);
                }
                if (req.specific_needs.tarpaulins) {
                    needs.push(`<span class="need-tag">${req.specific_needs.tarpaulins} tarpaulins</span>`);
                }
                if (req.specific_needs.rope) {
                    needs.push(`<span class="need-tag">${req.specific_needs.rope} rope</span>`);
                }
            } else {
                // Handle regular program needs
                if (req.specific_needs.daily_meals) {
                    needs.push(`<span class="need-tag critical">${req.specific_needs.daily_meals} meals/day</span>`);
                }
                if (req.specific_needs.water_needed) {
                    needs.push(`<span class="need-tag urgent">${req.specific_needs.water_needed}L water</span>`);
                }
                if (req.specific_needs.medicine_kits || req.specific_needs.medicine_kits_needed) {
                    const kits = req.specific_needs.medicine_kits || req.specific_needs.medicine_kits_needed;
                    needs.push(`<span class="need-tag">${kits} medicine kits</span>`);
                }
                if (req.specific_needs.basic_medicine_kits) {
                    needs.push(`<span class="need-tag">${req.specific_needs.basic_medicine_kits} medicine kits</span>`);
                }
                if (req.specific_needs.food_packages_needed) {
                    needs.push(`<span class="need-tag">${req.specific_needs.food_packages_needed} food packs</span>`);
                }
                if (req.specific_needs.rice_kilos_needed) {
                    needs.push(`<span class="need-tag">${req.specific_needs.rice_kilos_needed}kg rice</span>`);
                }
                if (req.specific_needs.canned_goods_needed) {
                    needs.push(`<span class="need-tag">${req.specific_needs.canned_goods_needed} canned goods</span>`);
                }
                if (req.specific_needs.wheelchairs_needed) {
                    needs.push(`<span class="need-tag">${req.specific_needs.wheelchairs_needed} wheelchairs</span>`);
                }
                if (req.specific_needs.walking_aids_needed) {
                    needs.push(`<span class="need-tag">${req.specific_needs.walking_aids_needed} walking aids</span>`);
                }
                if (req.specific_needs.blood_pressure_monitors) {
                    needs.push(`<span class="need-tag">${req.specific_needs.blood_pressure_monitors} BP monitors</span>`);
                }
                if (req.specific_needs.reading_glasses_needed) {
                    needs.push(`<span class="need-tag">${req.specific_needs.reading_glasses_needed} reading glasses</span>`);
                }
                if (req.specific_needs.vitamin_supplements) {
                    needs.push(`<span class="need-tag">${req.specific_needs.vitamin_supplements} vitamins</span>`);
                }
                if (req.specific_needs.first_aid_kits) {
                    needs.push(`<span class="need-tag">${req.specific_needs.first_aid_kits} first aid kits</span>`);
                }
                if (req.specific_needs.medical_consultations) {
                    needs.push(`<span class="need-tag">${req.specific_needs.medical_consultations} consultations</span>`);
                }
                if (req.specific_needs.medical_supplies_needed) {
                    needs.push(`<span class="need-tag">${req.specific_needs.medical_supplies_needed} medical supplies</span>`);
                }
                if (req.specific_needs.transportation_assistance) {
                    needs.push(`<span class="need-tag">${req.specific_needs.transportation_assistance} transport</span>`);
                }
                if (req.specific_needs.drinking_water_liters) {
                    needs.push(`<span class="need-tag urgent">${req.specific_needs.drinking_water_liters}L water</span>`);
                }
            }
            
            // Limit to first 8 needs to avoid clutter
            return needs.slice(0, 8).join('');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }

        function updateStatistics() {
            const totalPrograms = allRequirements.length;
            const totalFamilies = allRequirements.reduce((sum, req) => sum + req.total_residents, 0);
            const highPriority = allRequirements.filter(req => req.priority === 'high').length;
            const evacueePrograms = allRequirements.filter(req => req.is_evacuee).length;
            
            document.getElementById('totalPrograms').textContent = totalPrograms;
            document.getElementById('totalFamilies').textContent = totalFamilies;
            document.getElementById('highPriority').textContent = highPriority;
            document.getElementById('evacueePrograms').textContent = evacueePrograms;
        }

        function filterRequirements() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const priorityFilter = document.getElementById('priorityFilter').value;
            const programFilter = document.getElementById('programFilter').value;
            
            let filtered = allRequirements.filter(req => {
                const matchesSearch = req.program_title.toLowerCase().includes(searchTerm) ||
                                    req.purok.toLowerCase().includes(searchTerm);
                const matchesPriority = !priorityFilter || req.priority === priorityFilter;
                const matchesProgram = !programFilter || 
                                    (programFilter === 'evacuee' && req.is_evacuee) ||
                                    (programFilter === 'regular' && !req.is_evacuee);
                
                return matchesSearch && matchesPriority && matchesProgram;
            });
            
            displayRequirements(filtered);
        }

        let currentModalId = null;

        function viewDetails(id) {
            const requirement = allRequirements.find(req => req.id === id);
            if (requirement) {
                currentModalId = id;
                
                const modalContent = document.getElementById('modalContent');
                const priorityClass = requirement.priority === 'HIGH' ? 'priority-high' : 
                                    requirement.priority === 'MEDIUM' ? 'priority-medium' : 'priority-low';
                
                // Generate detailed needs breakdown
                let needsBreakdown = '';
                let demographicsSection = '';
                
                if (requirement.is_evacuee && requirement.specific_needs) {
                    // Evacuee Program - Comprehensive DSS Display
                    const needs = requirement.specific_needs;
                    
                    // Essential Supplies Section
                    needsBreakdown = `
                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                            <h4 style="color: var(--navy); font-size: 14px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-boxes" style="color: var(--teal);"></i>
                                Essential Supplies
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--teal);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--teal); margin-bottom: 2px;">${needs.daily_meals || 0}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Daily Meals</div>
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--blue);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--blue); margin-bottom: 2px;">${needs.water_needed || 0}L</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Water/Day</div>
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--amber);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--amber); margin-bottom: 2px;">${needs.hygiene_kits || 0}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Hygiene Kits</div>
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--rose);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--rose); margin-bottom: 2px;">${needs.blankets || 0}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Blankets</div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                            <h4 style="color: var(--navy); font-size: 14px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-medkit" style="color: var(--rose);"></i>
                                Medical & Health Supplies
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">First Aid Kits</span>
                                    <span style="font-weight: 600; color: var(--navy);">${needs.first_aid_kits || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Medicine Kits</span>
                                    <span style="font-weight: 600; color: var(--navy);">${needs.medicine_kits || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Wheelchairs</span>
                                    <span style="font-weight: 600; color: var(--navy);">${needs.wheelchairs || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Walking Canes</span>
                                    <span style="font-weight: 600; color: var(--navy);">${needs.walking_canes || 0}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                            <h4 style="color: var(--navy); font-size: 14px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-baby" style="color: var(--amber);"></i>
                                Infant & Baby Care
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Baby Formula</span>
                                    <span style="font-weight: 600; color: var(--amber);">${needs.baby_formula || 0} cans</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Diapers</span>
                                    <span style="font-weight: 600; color: var(--amber);">${needs.diapers || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Adult Diapers</span>
                                    <span style="font-weight: 600; color: var(--amber);">${needs.adult_diapers || 0}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                            <h4 style="color: var(--navy); font-size: 14px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-utensils" style="color: var(--green);"></i>
                                Food Supplies (3-Day Stock)
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Rice</span>
                                    <span style="font-weight: 600; color: var(--green);">${needs.rice_kilos || 0}kg</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Canned Goods</span>
                                    <span style="font-weight: 600; color: var(--green);">${needs.canned_goods || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Instant Noodles</span>
                                    <span style="font-weight: 600; color: var(--green);">${needs.instant_noodles || 0}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px;">
                            <h4 style="color: var(--navy); font-size: 14px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-home" style="color: var(--blue);"></i>
                                Shelter & Sanitation
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Sleeping Mats</span>
                                    <span style="font-weight: 600; color: var(--blue);">${needs.sleeping_mats || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Tarpaulins</span>
                                    <span style="font-weight: 600; color: var(--blue);">${needs.tarpaulins || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Toilet Paper</span>
                                    <span style="font-weight: 600; color: var(--blue);">${needs.toilet_paper || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Soap Bars</span>
                                    <span style="font-weight: 600; color: var(--blue);">${needs.soap_bars || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Sanitizer</span>
                                    <span style="font-weight: 600; color: var(--blue);">${needs.sanitizer || 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 8px 12px; border-radius: 6px;">
                                    <span style="font-size: 12px; color: var(--text-mid);">Rope</span>
                                    <span style="font-weight: 600; color: var(--blue);">${needs.rope || 0}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Demographics Section for Evacuee Programs
                    demographicsSection = `
                        <div style="background: var(--rose-light); padding: 16px; border-radius: 12px; margin-bottom: 16px; border-left: 4px solid var(--rose);">
                            <h4 style="color: var(--navy); font-size: 14px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-users" style="color: var(--rose);"></i>
                                Vulnerable Groups Demographics
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                                <div style="text-align: center; background: white; padding: 10px; border-radius: 8px;">
                                    <div style="font-size: 20px; font-weight: 700; color: var(--rose); margin-bottom: 2px;">${requirement.senior_count || 0}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Senior Citizens</div>
                                </div>
                                <div style="text-align: center; background: white; padding: 10px; border-radius: 8px;">
                                    <div style="font-size: 20px; font-weight: 700; color: var(--amber); margin-bottom: 2px;">${needs.infant_count || 0}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Infants (0-5)</div>
                                </div>
                                <div style="text-align: center; background: white; padding: 10px; border-radius: 8px;">
                                    <div style="font-size: 20px; font-weight: 700; color: var(--teal); margin-bottom: 2px;">${requirement.pregnant_count || 0}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Pregnant Women</div>
                                </div>
                                <div style="text-align: center; background: white; padding: 10px; border-radius: 8px;">
                                    <div style="font-size: 20px; font-weight: 700; color: var(--blue); margin-bottom: 2px;">${requirement.pwd_count || 0}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">PWD Residents</div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                } else if (requirement.specific_needs) {
                    // Regular Program - Basic Needs Display
                    const needs = requirement.specific_needs;
                    
                    needsBreakdown = `
                        <div style="background: var(--slate-light); padding: 16px; border-radius: 12px;">
                            <h4 style="color: var(--navy); font-size: 14px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clipboard-list" style="color: var(--teal);"></i>
                                Program Requirements
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                                ${needs.daily_meals ? `
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--teal);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--teal); margin-bottom: 2px;">${needs.daily_meals}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Daily Meals</div>
                                </div>` : ''}
                                ${needs.water_needed ? `
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--blue);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--blue); margin-bottom: 2px;">${needs.water_needed}L</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Water/Day</div>
                                </div>` : ''}
                                ${needs.hygiene_kits ? `
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--amber);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--amber); margin-bottom: 2px;">${needs.hygiene_kits}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Hygiene Kits</div>
                                </div>` : ''}
                                ${needs.blankets ? `
                                <div style="background: white; padding: 10px; border-radius: 8px; border-left: 4px solid var(--rose);">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--rose); margin-bottom: 2px;">${needs.blankets}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Blankets</div>
                                </div>` : ''}
                            </div>
                            
                            ${needs.medicine_kits_needed || needs.basic_medicine_kits ? `
                            <div style="margin-top: 16px;">
                                <h5 style="font-size: 12px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">Medical Supplies</h5>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px;">
                                    ${needs.medicine_kits_needed ? `
                                    <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 6px 10px; border-radius: 6px;">
                                        <span style="font-size: 11px; color: var(--text-mid);">Medicine Kits</span>
                                        <span style="font-weight: 600; color: var(--navy);">${needs.medicine_kits_needed}</span>
                                    </div>` : ''}
                                    ${needs.basic_medicine_kits ? `
                                    <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 6px 10px; border-radius: 6px;">
                                        <span style="font-size: 11px; color: var(--text-mid);">Basic Medicine Kits</span>
                                        <span style="font-weight: 600; color: var(--navy);">${needs.basic_medicine_kits}</span>
                                    </div>` : ''}
                                </div>
                            </div>` : ''}
                            
                            ${needs.food_packages_needed || needs.rice_kilos_needed || needs.canned_goods_needed ? `
                            <div style="margin-top: 16px;">
                                <h5 style="font-size: 12px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">Food Supplies</h5>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px;">
                                    ${needs.food_packages_needed ? `
                                    <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 6px 10px; border-radius: 6px;">
                                        <span style="font-size: 11px; color: var(--text-mid);">Food Packages</span>
                                        <span style="font-weight: 600; color: var(--green);">${needs.food_packages_needed}</span>
                                    </div>` : ''}
                                    ${needs.rice_kilos_needed ? `
                                    <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 6px 10px; border-radius: 6px;">
                                        <span style="font-size: 11px; color: var(--text-mid);">Rice</span>
                                        <span style="font-weight: 600; color: var(--green);">${needs.rice_kilos_needed}kg</span>
                                    </div>` : ''}
                                    ${needs.canned_goods_needed ? `
                                    <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 6px 10px; border-radius: 6px;">
                                        <span style="font-size: 11px; color: var(--text-mid);">Canned Goods</span>
                                        <span style="font-weight: 600; color: var(--green);">${needs.canned_goods_needed}</span>
                                    </div>` : ''}
                                </div>
                            </div>` : ''}
                        </div>
                    `;
                } else {
                    needsBreakdown = `
                        <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                            <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                            <div style="font-size: 13px;">No specific requirements recorded</div>
                        </div>
                    `;
                }
                
                modalContent.innerHTML = `
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Program Title</div>
                            <div class="detail-value">
                                ${requirement.program_title}
                                ${requirement.is_evacuee ? '<span style="background: var(--teal); color: white; padding: 2px 6px; border-radius: 4px; font-size: 9px; margin-left: 6px;"><i class="fas fa-brain" style="font-size: 8px; margin-right: 1px;"></i>DSS</span>' : ''}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Location</div>
                            <div class="detail-value">${requirement.purok}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Start Date</div>
                            <div class="detail-value">${formatDate(requirement.start_date)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Total Families</div>
                            <div class="detail-value">${requirement.total_residents}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Priority Level</div>
                            <div class="detail-value">
                                <span class="priority-badge ${priorityClass.toLowerCase()}">${requirement.priority}</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Program Type</div>
                            <div class="detail-value">
                                <span class="program-badge ${requirement.is_evacuee ? 'evacuee' : ''}">
                                    <i class="fas fa-${requirement.is_evacuee ? 'person-shelter' : 'calendar-alt'}"></i>
                                    ${requirement.is_evacuee ? 'Evacuee Program' : 'Regular Program'}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    ${demographicsSection}
                    
                    <div style="margin-top: 20px;">
                        <div class="detail-label" style="margin-bottom: 12px; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-clipboard-check" style="color: var(--teal);"></i>
                            Detailed Requirements Breakdown
                        </div>
                        ${needsBreakdown}
                    </div>
                `;
                
                document.getElementById('detailsModal').classList.add('open');
            }
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.remove('open');
            currentModalId = null;
        }

        function editRequirement(id) {
            const requirement = allRequirements.find(req => req.id === id);
            if (requirement) {
                closeDetailsModal();
                showToast(`Edit functionality for: ${requirement.program_title} - This would open an edit form or navigate to edit page.`);
            }
        }

        // Evacuation Area Analytics Functions (mirroring dashboard logic)
        function loadEvacuationAreaAnalytics() {
            const analyticsContent = document.getElementById('evacuationAreaAnalytics');
            
            analyticsContent.innerHTML = `
                <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                    <i class="fas fa-spinner fa-spin" style="font-size: 20px; margin-bottom: 8px;"></i>
                    <div style="font-size: 12px;">Loading evacuation area analytics...</div>
                </div>
            `;
            
            // Fetch fresh data from backend using same API as dashboard
            fetch('/api/analytics-data')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Use the same accurate DSS metrics as dashboard
                        const areaAnalysis = analyzeEvacuationAreas(data.evacuees, data.facilities, data.dssMetrics);
                        displayEvacuationAreaAnalytics(areaAnalysis, data.dssMetrics);
                    } else {
                        throw new Error(data.message || 'Failed to load analytics');
                    }
                })
                .catch(error => {
                    console.error('Error loading evacuation area analytics:', error);
                    displayEmptyAnalytics();
                });
        } 

        function analyzeEvacuationAreas(evacuees, facilities, dssMetrics = {}) {
            // Group evacuees by evacuation area
            const areaGroups = {};
            
            evacuees.forEach(evacuee => {
                const area = evacuee.evacuation_area || 'Unknown';
                
                if (!areaGroups[area]) {
                    areaGroups[area] = {
                        area: area,
                        totalEvacuees: 0,
                        totalFamilyMembers: 0,
                        seniors: 0,
                        children: 0,
                        infants: 0,
                        pregnant: 0,
                        pwd: 0,
                        dailyMeals: 0,
                        waterNeeded: 0,
                        hygieneKits: 0,
                        blankets: 0,
                        capacity: 0,
                        availableSpace: 0,
                        occupancyRate: 0,
                        recommendations: []
                    };
                }
                
                areaGroups[area].totalEvacuees++;
                areaGroups[area].totalFamilyMembers += evacuee.total_members || 1;
                
                // Count demographics
                const age = evacuee.age || 0;
                if (age >= 60) areaGroups[area].seniors++;
                if (age <= 17 && age > 0) areaGroups[area].children++;
                if (age <= 5) areaGroups[area].infants++;
                
                if (evacuee.has_pregnant) areaGroups[area].pregnant++;
                if (evacuee.has_pwd) areaGroups[area].pwd++;
                
                // Calculate basic needs
                const familySize = evacuee.total_members || 1;
                areaGroups[area].dailyMeals += familySize * 3;
                areaGroups[area].waterNeeded += familySize * 4;
                areaGroups[area].hygieneKits += Math.ceil(familySize * 0.8);
                areaGroups[area].blankets += Math.ceil(familySize * 0.7);
            });
            
            // Add facility capacity information
            facilities.forEach(facility => {
                const facilityName = facility.name;
                if (areaGroups[facilityName]) {
                    areaGroups[facilityName].capacity = facility.capacity || 0;
                    areaGroups[facilityName].availableSpace = (facility.capacity || 0) - areaGroups[facilityName].totalFamilyMembers;
                    areaGroups[facilityName].occupancyRate = facility.capacity > 0 ? 
                        (areaGroups[facilityName].totalFamilyMembers / facility.capacity) * 100 : 0;
                }
            });
            
            // Generate recommendations for each area
            Object.keys(areaGroups).forEach(area => {
                const data = areaGroups[area];
                const recommendations = [];
                
                // Critical recommendations
                if (data.occupancyRate > 90) {
                    recommendations.push({
                        type: 'critical',
                        text: 'Capacity critical - consider overflow shelter',
                        icon: 'exclamation-triangle'
                    });
                }
                
                if (data.infants > 0) {
                    recommendations.push({
                        type: 'warning',
                        text: `Need baby supplies for ${data.infants} infants`,
                        icon: 'baby'
                    });
                }
                
                if (data.pregnant > 0) {
                    recommendations.push({
                        type: 'info',
                        text: `Prenatal care needed for ${data.pregnant} pregnant women`,
                        icon: 'heartbeat'
                    });
                }
                
                if (data.pwd > 0) {
                    recommendations.push({
                        type: 'info',
                        text: `Accessibility support for ${data.pwd} PWD residents`,
                        icon: 'wheelchair'
                    });
                }
                
                if (data.seniors > 0) {
                    recommendations.push({
                        type: 'info',
                        text: `Senior care for ${data.seniors} elderly residents`,
                        icon: 'user-friends'
                    });
                }
                
                // Resource recommendations
                if (data.waterNeeded > 100) {
                    recommendations.push({
                        type: 'warning',
                        text: `High water demand: ${data.waterNeeded}L/day`,
                        icon: 'tint'
                    });
                }
                
                areaGroups[area].recommendations = recommendations;
            });
            
            return areaGroups;
        }

        function displayEvacuationAreaAnalytics(areaAnalysis, dssMetrics = {}) {
            const analyticsContent = document.getElementById('evacuationAreaAnalytics');
            
            if (Object.keys(areaAnalysis).length === 0) {
                displayEmptyAnalytics();
                return;
            }
            
            let html = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px;">';
            
            Object.values(areaAnalysis).forEach(area => {
                const occupancyClass = area.occupancyRate > 90 ? 'var(--rose)' : 
                                     area.occupancyRate > 70 ? 'var(--amber)' : 'var(--green)';
                
                html += `
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <div style="font-weight: 600; color: var(--navy); font-size: 13px;">
                                <i class="fas fa-map-marker-alt" style="color: var(--teal); margin-right: 4px;"></i>
                                ${area.area}
                            </div>
                            <div style="font-size: 10px; padding: 2px 6px; background: ${occupancyClass}20; color: ${occupancyClass}; border-radius: 4px; font-weight: 500;">
                                ${Math.round(area.occupancyRate)}% full
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                            <div style="text-align: center; padding: 6px; background: var(--slate-light); border-radius: 6px;">
                                <div style="font-size: 16px; font-weight: 700; color: var(--navy);">${area.totalEvacuees}</div>
                                <div style="font-size: 9px; color: var(--text-muted);">Families</div>
                            </div>
                            <div style="text-align: center; padding: 6px; background: var(--slate-light); border-radius: 6px;">
                                <div style="font-size: 16px; font-weight: 700; color: var(--teal);">${area.totalFamilyMembers}</div>
                                <div style="font-size: 9px; color: var(--text-muted);">People</div>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px;">
                            <div style="text-align: center; padding: 4px; background: #fef3c7; border-radius: 4px;">
                                <div style="font-size: 12px; font-weight: 600; color: #92400e;">${area.dailyMeals}</div>
                                <div style="font-size: 8px; color: var(--text-muted);">Meals/day</div>
                            </div>
                            <div style="text-align: center; padding: 4px; background: #dbeafe; border-radius: 4px;">
                                <div style="font-size: 12px; font-weight: 600; color: #1d4ed8;">${area.waterNeeded}L</div>
                                <div style="font-size: 8px; color: var(--text-muted);">Water/day</div>
                            </div>
                        </div>
                        
                        ${area.recommendations.length > 0 ? `
                            <div style="border-top: 1px solid var(--border); padding-top: 6px;">
                                <div style="font-size: 9px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Top Recommendation</div>
                                <div style="font-size: 10px; color: var(--text-mid); line-height: 1.3;">
                                    <i class="fas fa-${area.recommendations[0].icon}" style="color: ${area.recommendations[0].type === 'critical' ? 'var(--rose)' : area.recommendations[0].type === 'warning' ? 'var(--amber)' : 'var(--green)'}; margin-right: 2px; font-size: 8px;"></i>
                                    ${area.recommendations[0].text}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                `;
            });
            
            html += '</div>';
            analyticsContent.innerHTML = html;
        }

        function displayEmptyAnalytics() {
            const analyticsContent = document.getElementById('evacuationAreaAnalytics');
            analyticsContent.innerHTML = `
                <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                    <i class="fas fa-building" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                    <div style="font-size: 12px; font-weight: 600; margin-bottom: 4px;">No Evacuation Data Available</div>
                    <div style="font-size: 10px;">No active evacuees in evacuation areas</div>
                </div>
            `;
        }

        // Refresh function for Evacuation Area Analytics
        function refreshEvacuationAnalytics() {
            showToast('Refreshing evacuation area analytics...');
            loadEvacuationAreaAnalytics();
        }

        // Refresh function for Key Insights & Recommendations
        function refreshRecommendations() {
            showToast('Refreshing recommendations...');
            // Reload the page to get fresh recommendations data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Toast notification function
        function showToast(message) {
            // Create toast if it doesn't exist
            if (!document.getElementById('toast')) {
                const toast = document.createElement('div');
                toast.id = 'toast';
                toast.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: var(--navy);
                    color: white;
                    padding: 12px 20px;
                    border-radius: 8px;
                    font-size: 14px;
                    z-index: 9999;
                    transform: translateY(80px);
                    opacity: 0;
                    transition: all 0.3s ease;
                `;
                document.body.appendChild(toast);
            }
            
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
            
            setTimeout(() => {
                toast.style.transform = 'translateY(80px)';
                toast.style.opacity = '0';
            }, 3000);
        }
    </script>

    <!-- Details Modal -->
    <div id="detailsModal" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Assistance Requirement Details</h3>
                <button class="modal-close" onclick="closeDetailsModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeDetailsModal()">Close</button>
                <button class="btn-primary" onclick="editRequirement(currentModalId)">
                    <i class="fas fa-edit"></i> Edit
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Modal Styles */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-backdrop.open {
            display: flex;
        }

        .modal-box {
            background: white;
            border-radius: 18px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: var(--slate-light);
            color: var(--text-dark);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-secondary {
            background: var(--slate-light);
            color: var(--text-dark);
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--teal) 0%, #0d9488 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 160, 0.3);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .detail-item {
            padding: 12px;
            background: var(--slate-light);
            border-radius: 8px;
        }

        .detail-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 4px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
        }

        .priority-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .priority-high {
            background: var(--rose-light);
            color: #9f1239;
        }

        .priority-medium {
            background: var(--amber-light);
            color: #92400e;
        }

        .priority-low {
            background: var(--green-light);
            color: #065f46;
        }
    </style>
</body>
</html>
