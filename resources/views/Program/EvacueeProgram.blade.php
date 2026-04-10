<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Evacuee Program Management - B-DEAMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f0f4f8;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* MAIN */
        .main {
            width: 100%;
            padding: 36px 40px;
            min-height: 100vh;
        }

        /* PAGE HEADER */
        .page-header {
            margin-bottom: 32px;
        }

        /* BACK BUTTON */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            background: var(--navy-mid);
            color: var(--white);
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .back-button:hover {
            background: var(--navy);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .back-button i {
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .back-button:hover i {
            transform: translateX(-2px);
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

        /* STAT CARDS */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 26px 28px;
            border: 1px solid var(--border);
            text-decoration: none;
            display: block;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.navy::before { background: var(--navy); }
        .stat-card.teal::before  { background: var(--teal); }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .stat-row-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon-wrap {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon-wrap.navy { background: #e8ecf0; color: var(--navy); }
        .stat-icon-wrap.teal { background: var(--teal-light); color: var(--teal); }

        .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 44px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
            margin-top: 18px;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 13.5px;
            color: var(--text-muted);
        }

        /* PANEL */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .panel-head {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-title {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .panel-title i { color: var(--teal); font-size: 14px; }
        .panel-body { padding: 20px 24px; }

        /* Toolbar */
        .toolbar { display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:20px; }

        .toolbar .select, .toolbar .search { border:1px solid var(--border); background:var(--white); color:var(--text-dark); border-radius:10px; padding:10px 12px; font-size:14px; }

        .toolbar .search { min-width: 240px; }

        .btn { display:inline-flex; align-items:center; gap:8px; padding:8px 14px; border-radius:12px; border:1px solid var(--border); text-decoration:none; font-weight:600; font-size:12px; text-transform:uppercase; letter-spacing:0.5px; cursor:pointer; transition:all 0.2s; }

        .btn.add { background:var(--slate-light); color:var(--text-dark); }

        .btn.export { background:var(--navy); color:var(--white); border-color:var(--navy); }

        .btn.export i { font-size:13px; }

        .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        /* Table */
        .table-wrap { margin-top:16px; border:1px solid var(--border); border-radius:12px; overflow:hidden; }

        table { width:100%; border-collapse:collapse; background:var(--white); }

        thead th { background:var(--slate-light); color:var(--text-muted); font-size:12px; letter-spacing:0.6px; text-transform:uppercase; text-align:left; padding:14px 16px; }

        tbody td { padding:14px 16px; border-top:1px solid var(--border); color:var(--text-dark); font-size:14px; }

        .actions { display:flex; align-items:center; gap:14px; }

        .actions a { color:var(--text-muted); text-decoration:none; font-size:16px; transition:color 0.2s; }

        .actions a:hover { color:var(--text-dark); }

        /* Modal Styles */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 500;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-backdrop.open { display: flex; }

        .modal-box {
            background: white;
            border-radius: 18px;
            width: 90%;
            max-width: 800px;
            max-height: 88vh;
            overflow-y: auto;
            scrollbar-width: none;
            animation: modalIn 0.25s cubic-bezier(0.175,0.885,0.32,1.275) both;
        }

        .modal-box::-webkit-scrollbar { display: none; }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-head {
            padding: 22px 26px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            position: sticky;
            top: 0;
            background: white;
            border-radius: 18px 18px 0 0;
            z-index: 10;
        }

        .modal-head-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .modal-head-sub { font-size: 12.5px; color: var(--text-muted); margin-top: 3px; }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--slate-light);
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .modal-close:hover { background: var(--rose-light); color: var(--rose); border-color: var(--rose); }

        .modal-body { padding: 20px 26px 26px; }

        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-muted);
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
            padding: 10px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            background: var(--slate-light);
            transition: all 0.2s;
            outline: none;
        }

        .form-control:focus {
            background: white;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14, 165, 160, 0.12);
        }

        textarea.form-control { resize: vertical; min-height: 80px; }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-top: 18px;
        }

        .btn-cancel {
            padding: 9px 20px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--slate-light);
            color: var(--text-mid);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover { background: var(--border); }

        .btn-submit {
            padding: 9px 24px;
            border-radius: 10px;
            border: none;
            background: var(--navy);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-submit:hover { background: var(--navy-mid); }
        .btn-submit.green { background: var(--green); }
        .btn-submit.green:hover { background: #059669; }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

        /* Flash Alert */
        .flash-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 22px;
            animation: fadeUp 0.3s ease both;
        }

        .flash-alert.success { background: var(--green-light); color: #065f46; }
        .flash-alert.error   { background: var(--rose-light);  color: #9f1239; }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: var(--navy);
            color: white;
            padding: 14px 22px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 9999;
            transform: translateY(80px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: none;
        }

        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { color: var(--teal); }

        /* ANIMATIONS */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(100px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(100px); }
        }

        .anim       { animation: fadeUp 0.4s ease both; }
        .delay-1    { animation-delay: 0.07s; }
        .delay-2    { animation-delay: 0.13s; }
        .delay-3    { animation-delay: 0.19s; }
        .delay-4    { animation-delay: 0.25s; }

        /* Floating Alert */
        .alert { position: fixed; top: 20px; right: 20px; background-color: var(--navy); color: #ffffff; padding: 15px 25px; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px var(--navy); z-index: 9999; opacity: 0; animation: slideIn 0.5s forwards; }

        .alert.success { background-color: var(--green); color: #fff; }

        .alert.hide { animation: slideOut 0.5s forwards; }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .stats-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .main { padding: 24px 20px; }
            .stats-row { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .toolbar .search { min-width: auto; }
        }
    </style>
</head>

<body>

    
    <!-- MAIN CONTENT -->
    <main class="main">

        <!-- Page Header -->
        <div class="page-header anim">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p class="page-eyebrow">Program Management</p>
                    <h1 class="page-title">Evacuee Program</h1>
                </div>
                <a href="{{ route('resident.index') }}" class="back-button">
                    <i class="fas fa-chevron-left"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- Flash -->
        @if(session('Success'))
        <div class="flash-alert success anim">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('Success') }}</span>
        </div>
        @endif

        <!-- Stats -->
        <div class="stats-row anim delay-1">
            <div class="stat-card navy">
                <div class="stat-row-inner">
                    <div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-icon-wrap navy">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalEvacuees) }}</div>
                <div class="stat-label">Current Evacuees</div>
            </div>

            <div class="stat-card teal">
                <div class="stat-row-inner">
                    <div>
                        <div class="stat-label">Facilities</div>
                    </div>
                    <div class="stat-icon-wrap teal">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalShelters) }}</div>
                <div class="stat-label">Available Shelters</div>
            </div>
        </div>

        <!-- DSS Section for Evacuee Management -->
        <div class="panel anim delay-2" style="margin-bottom: 24px;">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-brain" style="color: var(--teal);"></i> 
                    Decision Support System - Evacuee Aid Management
                </div>
                <button class="btn export" onclick="exportDSSReport()">
                    <i class="fas fa-download"></i> EXPORT
                </button>
            </div>
            <div class="panel-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px;">
                    
                    <!-- Food Supply Status -->
                    <div style="background: var(--slate-light); border-radius: 12px; padding: 16px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 32px; height: 32px; background: var(--green-light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-utensils" style="color: var(--green); font-size: 14px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 14px; color: var(--text-dark);">Food Supply Status</div>
                                <div style="font-size: 11px; color: var(--text-muted);">Daily meal planning</div>
                            </div>
                        </div>
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <span style="font-size: 12px; color: var(--text-muted);">Supply Coverage</span>
                                <span style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--green);" id="foodCoverage">{{ number_format($dssMetrics['food_supply_coverage'], 0) }}%</span>
                            </div>
                            <div style="width: 100%; height: 8px; background: var(--border); border-radius: 4px; overflow: hidden;">
                                <div style="width: {{ $dssMetrics['food_supply_coverage'] }}%; height: 100%; background: linear-gradient(90deg, var(--green), #34d399); transition: width 0.3s;" id="foodBar"></div>
                            </div>
                        </div>
                        <div style="font-size: 12px; color: var(--text-mid); line-height: 1.5;">
                            <strong>Status:</strong> <span id="foodStatus">Sufficient for 5 days. Restock needed by Friday.</span>
                        </div>
                    </div>

                    <!-- Clothing Inventory -->
                    <div style="background: var(--slate-light); border-radius: 12px; padding: 16px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 32px; height: 32px; background: var(--blue-light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-tshirt" style="color: var(--blue); font-size: 14px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 14px; color: var(--text-dark);">Clothing Inventory</div>
                                <div style="font-size: 11px; color: var(--text-muted);">Essential clothing items</div>
                            </div>
                        </div>
                        <div style="margin-bottom: 12px;">
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-size: 12px;">
                                <div style="background: white; padding: 8px; border-radius: 6px; border: 1px solid var(--border);">
                                    <div style="color: var(--text-muted); font-size: 10px;">Adult Clothes</div>
                                    <div style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-dark);" id="adultClothes">{{ $dssMetrics['clothing_inventory_adult'] }}</div>
                                </div>
                                <div style="background: white; padding: 8px; border-radius: 6px; border: 1px solid var(--border);">
                                    <div style="color: var(--text-muted); font-size: 10px;">Children (0-5)</div>
                                    <div style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-dark);" id="childClothes0_5">{{ $dssMetrics['clothing_inventory_children_0_5'] }}</div>
                                </div>
                                <div style="background: white; padding: 8px; border-radius: 6px; border: 1px solid var(--border);">
                                    <div style="color: var(--text-muted); font-size: 10px;">Children (6-12)</div>
                                    <div style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-dark);" id="childClothes6_12">{{ $dssMetrics['clothing_inventory_children_6_12'] }}</div>
                                </div>
                                <div style="background: white; padding: 8px; border-radius: 6px; border: 1px solid var(--border);">
                                    <div style="color: var(--text-muted); font-size: 10px;">Children (13-17)</div>
                                    <div style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-dark);" id="childClothes13_17">{{ $dssMetrics['clothing_inventory_children_13_17'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div style="font-size: 12px; color: var(--text-mid); line-height: 1.5;">
                            <strong>Need:</strong> <span id="clothingNeeds">@if($dssMetrics['clothing_inventory_children_6_12'] > 0) Priority: {{ $dssMetrics['clothing_inventory_children_6_12'] }} children (6-12 years) need clothing. @else No children aged 6-12 currently in evacuation center. @endif</span>
                        </div>
                    </div>

                    <!-- Medical Supplies -->
                    <div style="background: var(--slate-light); border-radius: 12px; padding: 16px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 32px; height: 32px; background: var(--rose-light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-medkit" style="color: var(--rose); font-size: 14px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 14px; color: var(--text-dark);">Medical Supplies</div>
                                <div style="font-size: 11px; color: var(--text-muted);">Health & hygiene items</div>
                            </div>
                        </div>
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <span style="font-size: 12px; color: var(--text-muted);">Stock Level</span>
                                <span style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--rose);" id="medicalStock">{{ number_format($dssMetrics['medical_supply_level'], 0) }}%</span>
                            </div>
                            <div style="width: 100%; height: 8px; background: var(--border); border-radius: 4px; overflow: hidden;">
                                <div style="width: {{ $dssMetrics['medical_supply_level'] }}%; height: 100%; background: linear-gradient(90deg, var(--rose), #fb7185); transition: width 0.3s;" id="medicalBar"></div>
                            </div>
                        </div>
                        <div style="font-size: 12px; color: var(--text-mid); line-height: 1.5;">
                            <strong>Alert:</strong> <span id="medicalAlert">Critical: First aid kits running low.</span>
                        </div>
                    </div>

                    <!-- Shelter Capacity -->
                    <div style="background: var(--slate-light); border-radius: 12px; padding: 16px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 32px; height: 32px; background: var(--amber-light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-home" style="color: var(--amber); font-size: 14px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 14px; color: var(--text-dark);">Shelter Capacity</div>
                                <div style="font-size: 11px; color: var(--text-muted);">Occupancy rate</div>
                            </div>
                        </div>
                        <div style="margin-bottom: 12px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 12px;">
                                <div style="background: white; padding: 8px; border-radius: 6px; border: 1px solid var(--border);">
                                    <div style="color: var(--text-muted); font-size: 10px;">Occupied</div>
                                    <div style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-dark);" id="occupiedSpaces">{{ $totalEvacuees }}</div>
                                </div>
                                <div style="background: white; padding: 8px; border-radius: 6px; border: 1px solid var(--border);">
                                    <div style="color: var(--text-muted); font-size: 10px;">Available</div>
                                    <div style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-dark);" id="availableSpaces">{{ $dssMetrics['available_spaces'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div style="font-size: 12px; color: var(--text-mid); line-height: 1.5;">
                            <strong>Status:</strong> <span id="shelterStatus">{{ number_format($dssMetrics['occupancy_rate'], 0) }}% occupied. {{ $dssMetrics['occupancy_rate'] > 80 ? 'Critical capacity - prepare overflow areas.' : 'Monitor capacity closely.' }}</span>
                        </div>
                    </div>

                </div>

                <!-- Aid Distribution Planning -->
                <div style="background: var(--white); border-radius: 12px; padding: 20px; border: 1px solid var(--border); margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--teal), var(--blue)); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-hands-helping" style="color: white; font-size: 16px;"></i>
                        </div>
                        <div>
                            <div style="font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 600; color: var(--text-dark);">Aid Distribution Planning</div>
                            <div style="font-size: 12px; color: var(--text-muted); margin-top: 1px;">Smart allocation based on evacuee needs</div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 16px;">
                        <div style="text-align: center; padding: 12px; background: var(--slate-light); border-radius: 8px;">
                            <div style="font-size: 20px; font-weight: 700; color: var(--green);" id="dailyMeals">{{ number_format($dssMetrics['daily_meals_needed']) }}</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Daily Meals Needed</div>
                        </div>
                        <div style="text-align: center; padding: 12px; background: var(--slate-light); border-radius: 8px;">
                            <div style="font-size: 20px; font-weight: 700; color: var(--blue);" id="waterSupply">{{ number_format($dssMetrics['daily_water_requirement']) }}L</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Daily Water Requirement</div>
                        </div>
                        <div style="text-align: center; padding: 12px; background: var(--slate-light); border-radius: 8px;">
                            <div style="font-size: 20px; font-weight: 700; color: var(--amber);" id="hygieneKits">{{ number_format($dssMetrics['hygiene_kits_needed']) }}</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Hygiene Kits Needed</div>
                        </div>
                        <div style="text-align: center; padding: 12px; background: var(--slate-light); border-radius: 8px;">
                            <div style="font-size: 20px; font-weight: 700; color: var(--rose);" id="blanketSupply">{{ number_format($dssMetrics['blankets_needed']) }}</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Blankets Required</div>
                        </div>
                    </div>

                    <div style="background: var(--slate-light); border-radius: 8px; padding: 12px; margin-bottom: 16px;">
                        <div style="font-weight: 600; color: var(--text-dark); margin-bottom: 8px; font-size: 13px;">Priority Distribution Actions:</div>
                        <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: var(--text-mid); line-height: 1.6;">
                            <li id="priority1" style="margin-bottom: 4px;">Distribute emergency food packs to elderly and children first</li>
                            <li id="priority2" style="margin-bottom: 4px;">Set up additional water stations in high-occupancy areas</li>
                            <li id="priority3" style="margin-bottom: 4px;">Deploy medical team for health screening and first aid</li>
                            <li id="priority4">Arrange clothing distribution based on family size and ages</li>
                        </ul>
                    </div>

                    <canvas id="aidDistributionChart" width="400" height="200" style="width: 100%; height: 200px; background: white; border-radius: 8px; border: 1px solid var(--border);"></canvas>
                </div>

                <!-- DSS Action Buttons -->
                <div style="display: flex; justify-content: flex-end; align-items: center;">
                    <div style="font-size: 12px; color: var(--text-muted);">
                        <i class="fas fa-info-circle"></i> Last updated: <span id="lastUpdate">{{ now()->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="panel anim delay-2">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-users"></i> Evacuee Management
                </div>
            </div>
            <div class="panel-body">
                <p style="color:var(--text-muted); margin-bottom:20px;">Manage evacuees, track shelter capacity, and monitor evacuation status.</p>

                <!-- Toolbar -->
                <div class="toolbar">
                    <select class="select" id="evacuationAreaFilter" onchange="filterByEvacuationArea()">
                        <option value="">EVACUATION AREA</option>
                        @forelse($facilities as $facility)
                            <option value="{{ $facility['name'] }}">{{ $facility['name'] }} - {{ $facility['available_spaces'] }} Available</option>
                        @empty
                            <option value="Purok I">Purok I</option>
                            <option value="Purok II">Purok II</option>
                            <option value="Purok III">Purok III</option>
                            <option value="Purok IV">Purok IV</option>
                            <option value="Purok V">Purok V</option>
                        @endforelse
                    </select>

                    <input type="text" class="search" id="searchInput" placeholder="Search" onkeyup="searchEvacuees()" />

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
                                                <a href="#" title="View" onclick="viewEvacueeDetails('{{ $evacuee['id'] }}', '{{ $evacuee['fullname'] }}', '{{ $evacuee['age'] }}', '{{ $evacuee['gender'] }}', '{{ $evacuee['evacuation_status'] }}', '{{ $evacuee['evacuation_area'] }}', '{{ $evacuee['room_number'] ?? 'N/A' }}', '{{ $evacuee['evacuation_date'] }}')"><i class="fas fa-eye"></i></a>
                                                <a href="#" title="Release" onclick="event.preventDefault(); releaseEvacuee('{{ $evacuee['id'] }}', '{{ $evacuee['fullname'] }}')" style="color: #f59e0b;"><i class="fas fa-door-open"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" style="text-align:center; color:var(--text-muted); padding:12px 16px; font-size:12px;">No evacuees found. Add evacuees to see them here.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>



<!-- Export Preview Modal -->
<div class="modal-backdrop" id="exportPreviewOverlay">
    <div class="modal-box" id="exportPreviewModal">
        <div class="modal-head">
            <div>
                <div class="modal-head-title">Export Evacuees Data</div>
                <div class="modal-head-sub">Download evacuee information in CSV format</div>
            </div>
            <button class="modal-close" onclick="closeExportPreviewModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="background:var(--slate-light); border:1px solid var(--border); border-radius:12px; padding:20px; margin-bottom:20px;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                    <div style="background:var(--navy); color:var(--white); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-file-csv"></i>
                    </div>
                    <div>
                        <div style="font-weight:600; color:var(--text-dark); font-size:16px;">CSV Export Summary</div>
                        <div style="color:var(--text-muted); font-size:14px;">Preview of data to be exported</div>
                    </div>
                </div>
                
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:15px; margin-bottom:15px;">
                    <div style="text-align:center; padding:15px; background:var(--white); border-radius:8px; border:1px solid var(--border);">
                        <div id="totalEvacueesCount" style="font-size:24px; font-weight:700; color:var(--navy);">0</div>
                        <div style="font-size:12px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Total Evacuees</div>
                    </div>
                    <div style="text-align:center; padding:15px; background:var(--white); border-radius:8px; border:1px solid var(--border);">
                        <div id="totalSheltersCount" style="font-size:24px; font-weight:700; color:var(--navy);">0</div>
                        <div style="font-size:12px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Shelters</div>
                    </div>
                </div>
                
                <div style="background:var(--white); border:1px solid var(--border); border-radius:8px; padding:15px;">
                    <div style="font-weight:600; color:var(--text-dark); margin-bottom:10px; font-size:14px;">Data Fields Included:</div>
                    <div style="display:flex; flex-wrap:wrap; gap:8px;">
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">ID</span>
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Fullname</span>
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Age</span>
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Gender</span>
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Evacuation Status</span>
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Evacuation Area</span>
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Room Number</span>
                        <span style="background:var(--slate-light); color:var(--text-mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500;">Evacuation Date</span>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeExportPreviewModal()">Cancel</button>
                <button type="button" class="btn-submit" onclick="proceedWithExport()">
                    <i class="fas fa-download"></i> Download CSV
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Add Evacuee Modal -->
<div class="modal-backdrop" id="addEvacueeOverlay">
    <div class="modal-box" id="addEvacueeModal">
        <div class="modal-head">
            <div>
                <div class="modal-head-title">Add New Evacuee</div>
                <div class="modal-head-sub">Register residents for evacuation</div>
            </div>
            <button class="modal-close" onclick="closeAddEvacueeModal()"><i class="fas fa-xmark"></i></button>
        </div>

    

    <div class="modal-body">
            <form id="addEvacueeForm" method="POST" action="{{ route('program.evacuee.store') }}" style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                @csrf

                <div class="form-group">
                    <label class="form-label">Purok <span style="color:var(--rose);">*</span></label>
                    <select id="purokSelect" name="purok" required class="form-control" onchange="loadResidentsByPurok(); checkFormValidity()">
                        <option value="" disabled selected>Select Purok</option>
                        <option value="Purok I">Purok I</option>
                        <option value="Purok II">Purok II</option>
                        <option value="Purok III">Purok III</option>
                        <option value="Purok IV">Purok IV</option>
                        <option value="Purok V">Purok V</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Evacuation Status <span style="color:var(--rose);">*</span></label>
                    <select name="status" required class="form-control" onchange="checkFormValidity()">
                        <option value="" disabled selected>Select Status</option>
                        <option value="Evacuated">Evacuated</option>
                        <option value="Relocated">Relocated</option>
                        <option value="Returned">Returned</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Evacuation Area <span style="color:var(--rose);">*</span></label>
                    <select name="area" id="evacuationAreaSelect" required class="form-control" onchange="loadFacilityCapacity(); checkFormValidity()">
                        <option value="" disabled selected>Select Area</option>
                        @forelse($facilities as $facility)
                            <option value="{{ $facility['name'] }}">{{ $facility['name'] }} - {{ $facility['available_spaces'] }} Available</option>
                        @empty
                            <option value="Barangay Hall">Barangay Hall</option>
                            <option value="Evacuation Center 1">Evacuation Center 1</option>
                            <option value="Evacuation Center 2">Evacuation Center 2</option>
                            <option value="School Gym">School Gym</option>
                        @endforelse
                    </select>
                    <!-- Capacity Display -->
                    <div id="capacityDisplay" style="display:none; margin-top:8px; padding:8px; border-radius:6px; font-size:12px;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Room Number <span style="color:var(--rose);">*</span></label>
                    <select name="room" required class="form-control" onchange="checkFormValidity()">
                        <option value="" disabled selected>Select Room</option>
                        <option value="Room 1A">Room 1A</option>
                        <option value="Room 1B">Room 1B</option>
                        <option value="Room 2A">Room 2A</option>
                        <option value="Room 2B">Room 2B</option>
                        <option value="Room 3A">Room 3A</option>
                        <option value="Room 3B">Room 3B</option>
                        <option value="Room 4A">Room 4A</option>
                        <option value="Room 4B">Room 4B</option>
                        <option value="Room 5A">Room 5A</option>
                        <option value="Room 5B">Room 5B</option>
                        <option value="Multipurpose Hall">Multipurpose Hall</option>
                        <option value="Main Hall">Main Hall</option>
                        <option value="Conference Room">Conference Room</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Evacuation Date</label>
                    <input type="date" name="evacuation_date" required class="form-control" onchange="checkFormValidity()" />
                </div>

                <!-- Residents Preview Section -->
                <div id="residentsPreview" style="grid-column: 1 / -1; display:none; margin-top:10px;">
                    <div style="background:var(--white); border:1px solid var(--border); border-radius:8px; padding:15px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <label style="font-weight:600; color:var(--text-dark);">Residents to be Added:</label>
                            <span id="residentCount" style="background:var(--navy); color:var(--white); padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600;">0 residents</span>
                        </div>
                        <div id="residentsList" style="max-height:150px; overflow-y:auto;">
                            <!-- Residents will be listed here -->
                        </div>
                    </div>
                </div>

                <input type="hidden" id="residentsData" name="residents_data" />

                <div class="modal-footer" style="grid-column: 1 / -1;">
                    <button type="button" class="btn-cancel" onclick="closeAddEvacueeModal()">Cancel</button>
                    <button type="submit" class="btn-submit" id="saveBtn" disabled>Save Evacuees</button>
                </div>
            </form>
        </div>

    



@if(session('Success'))

  <div class="flash-alert success anim">
    <i class="fas fa-circle-check"></i>
    <span>{{ session('Success') }}</span>
  </div>

@endif

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-circle-check"></i>
        <span id="toast-msg">Done!</span>
    </div>



<script>

// Function to open the add evacuee modal
function openAddEvacueeModal() {
  const modal = document.getElementById('addEvacueeModal');
  const overlay = document.getElementById('addEvacueeOverlay');
  
  // Show modal and overlay with animation
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';

  

  // Auto-fill evacuation date with today's date

  const today = new Date().toISOString().split('T')[0];

  const evacuationDateInput = document.querySelector('input[name="evacuation_date"]');

  if (evacuationDateInput) {

    evacuationDateInput.value = today;

  }

  

  // Clear any previously selected purok to force refresh

  const purokSelect = document.getElementById('purokSelect');

  const residentsPreview = document.getElementById('residentsPreview');

  const residentsList = document.getElementById('residentsList');

  const residentCount = document.getElementById('residentCount');

  const saveBtn = document.getElementById('saveBtn');

  

  // Reset form and residents preview

  purokSelect.value = '';

  residentsPreview.style.display = 'none';

  residentsList.innerHTML = '';

  residentCount.textContent = '0 residents';

  saveBtn.disabled = true;

  currentResidents = [];
  
  // Check form validity on modal open
  checkFormValidity();

}

// Function to close the add evacuee modal
function closeAddEvacueeModal() {
  const overlay = document.getElementById('addEvacueeOverlay');
  overlay.classList.remove('open');
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



// Check form validity function
function checkFormValidity() {
  const purok = document.getElementById('purokSelect').value;
  const status = document.querySelector('select[name="status"]').value;
  const area = document.getElementById('evacuationAreaSelect').value;
  const date = document.querySelector('input[name="evacuation_date"]').value;
  const room = document.querySelector('select[name="room"]').value;
  const saveBtn = document.getElementById('saveBtn');
  
  // Enable button only if all required fields are filled AND there are residents AND capacity is available
  const allFieldsFilled = purok && status && area && date && room;
  const hasResidents = currentResidents.length > 0;
  
  // Check capacity availability
  let hasCapacity = true;
  const capacityDisplay = document.getElementById('capacityDisplay');
  if (capacityDisplay && capacityDisplay.style.display !== 'none') {
    // Look for "Available: X spaces" text and extract the number
    const capacityText = capacityDisplay.textContent;
    const availableMatch = capacityText.match(/Available:\s*(\d+)\s+spaces/);
    if (availableMatch) {
      const availableSpaces = parseInt(availableMatch[1]);
      hasCapacity = availableSpaces > 0;
    }
  }
  
  if (allFieldsFilled && hasResidents && hasCapacity) {
    saveBtn.disabled = false;
    saveBtn.style.opacity = '1';
    saveBtn.style.cursor = 'pointer';
  } else {
    saveBtn.disabled = true;
    saveBtn.style.opacity = '0.5';
    saveBtn.style.cursor = 'not-allowed';
  }
}

// Store fetched residents

let currentResidents = [];

let allResidentsByPurok = {};



// Filter by evacuation area

function filterByEvacuationArea() {

  const selectedArea = document.getElementById('evacuationAreaFilter').value;

  const tableRows = document.querySelectorAll('tbody tr');

  // Calculate DSS metrics for filtered evacuees
  let filteredEvacueeCount = 0;
  let filteredSeniorCount = 0;
  let filteredChild0_5Count = 0;
  let filteredChild6_12Count = 0;
  let filteredChild13_17Count = 0;
  let filteredMaleCount = 0;
  let filteredFemaleCount = 0;
  let filteredDailyMeals = 0;

  tableRows.forEach(row => {

    if (row.querySelector('td[colspan]')) {
      // Skip "No evacuees found" rows
      return;
    }

    const evacuationAreaCell = row.cells[5]; // Evacuation Area is column 5 (0-indexed)
    const evacuationArea = evacuationAreaCell ? evacuationAreaCell.textContent.trim() : '';
    const ageCell = row.cells[3]; // Age is column 3 (0-indexed)
    const genderCell = row.cells[4]; // Gender is column 4 (0-indexed)

    const isVisible = (selectedArea === '' || evacuationArea === selectedArea);
    row.style.display = isVisible ? '' : 'none';

    if (isVisible) {
      // Count visible evacuees for DSS
      filteredEvacueeCount++;
      
      const age = parseInt(ageCell.textContent.trim(), 10);
      const gender = genderCell.textContent.trim();
      
      if (age >= 60) {
        filteredSeniorCount++;
      } else if (age < 18) {
        if (age <= 5) {
          filteredChild0_5Count++;
        } else if (age >= 6 && age <= 12) {
          filteredChild6_12Count++;
        } else if (age >= 13 && age <= 17) {
          filteredChild13_17Count++;
        }
      }
      
      if (gender.toLowerCase() === 'male') {
        filteredMaleCount++;
      } else {
        filteredFemaleCount++;
      }
      
      // Calculate meals for this evacuee
      if (age <= 2) {
        filteredDailyMeals += 6; // Infants: 6 small meals per day
      } else if (age <= 12) {
        filteredDailyMeals += 5; // Children: 3 meals + 2 snacks
      } else if (age <= 17) {
        filteredDailyMeals += 3; // Teens: 3 meals per day
      } else {
        filteredDailyMeals += 3; // Adults: 3 meals per day
      }
    }
  });

  // Update DSS display with filtered data
  if (selectedArea === '') {
    // Reset to show all data when filter is cleared
    resetDSSToAllData();
  } else {
    updateDSSForFilteredArea(filteredEvacueeCount, filteredSeniorCount, filteredChild0_5Count, filteredChild6_12Count, filteredChild13_17Count, filteredMaleCount, filteredFemaleCount, filteredDailyMeals, selectedArea);
  }

  // Show message if no results
  const visibleRows = Array.from(tableRows).filter(row => 
    row.style.display !== 'none' && !row.querySelector('td[colspan]')
  );

  const existingNoResults = document.querySelector('tbody tr td[colspan]');
  if (visibleRows.length === 0 && !existingNoResults) {
    const tbody = document.querySelector('tbody');
    const noResultsRow = document.createElement('tr');
    noResultsRow.innerHTML = `
      <td colspan="9" style="text-align:center; color:#9ca3af; padding:12px 16px; font-size:12px;">
        No evacuees found in "${selectedArea || 'selected area'}"
      </td>
    `;
    tbody.appendChild(noResultsRow);
  } else if (visibleRows.length > 0 && existingNoResults) {
    existingNoResults.parentElement.remove();
  }
  
  // Refresh capacity display if the same area is selected in the add form
  if (selectedArea) {
    const evacuationAreaSelect = document.getElementById('evacuationAreaSelect');
    if (evacuationAreaSelect && evacuationAreaSelect.value === selectedArea) {
      // Refresh the capacity display for this area
      loadFacilityCapacity();
    }
  }
}

function updateDSSForFilteredArea(evacueeCount, seniorCount, child0_5Count, child6_12Count, child13_17Count, maleCount, femaleCount, dailyMeals, selectedArea) {
  // Update DSS title to show filtered area
  const dssTitle = document.querySelector('.panel-title');
  if (selectedArea) {
    dssTitle.innerHTML = `<i class="fas fa-brain" style="color: var(--teal);"></i> Decision Support System - ${selectedArea}`;
  } else {
    dssTitle.innerHTML = '<i class="fas fa-brain" style="color: var(--teal);"></i> Decision Support System - Evacuee Aid Management';
  }

  // Calculate filtered metrics
  const filteredMetrics = {
    evacueeCount: evacueeCount,
    daily_meals_needed: dailyMeals,
    daily_water_requirement: evacueeCount * 4,
    hygiene_kits_needed: Math.ceil(evacueeCount * 0.8),
    blankets_needed: Math.ceil(evacueeCount * 0.7),
    clothing_inventory_adult: Math.ceil(evacueeCount * 0.6),
    clothing_inventory_children_0_5: child0_5Count,
    clothing_inventory_children_6_12: child6_12Count,
    clothing_inventory_children_13_17: child13_17Count,
    available_spaces: 'N/A', // Not applicable for filtered view
    occupancy_rate: 'N/A', // Not applicable for filtered view
    food_supply_coverage: Math.max(30, 100 - (evacueeCount / 10) * 20), // Simulated
    medical_supply_level: Math.max(25, 95 - (evacueeCount / 10) * 15), // Simulated
  };

  // Update display elements
  if (document.getElementById('dailyMeals')) {
    document.getElementById('dailyMeals').textContent = filteredMetrics.daily_meals_needed.toLocaleString();
  }
  if (document.getElementById('waterSupply')) {
    document.getElementById('waterSupply').textContent = filteredMetrics.daily_water_requirement.toLocaleString() + 'L';
  }
  if (document.getElementById('hygieneKits')) {
    document.getElementById('hygieneKits').textContent = filteredMetrics.hygiene_kits_needed.toLocaleString();
  }
  if (document.getElementById('blanketSupply')) {
    document.getElementById('blanketSupply').textContent = filteredMetrics.blankets_needed.toLocaleString();
  }

  // Update clothing inventory
  if (document.getElementById('adultClothes')) {
    document.getElementById('adultClothes').textContent = filteredMetrics.clothing_inventory_adult.toLocaleString();
  }
  if (document.getElementById('childClothes0_5')) {
    document.getElementById('childClothes0_5').textContent = filteredMetrics.clothing_inventory_children_0_5.toLocaleString();
  }
  if (document.getElementById('childClothes6_12')) {
    document.getElementById('childClothes6_12').textContent = filteredMetrics.clothing_inventory_children_6_12.toLocaleString();
  }
  if (document.getElementById('childClothes13_17')) {
    document.getElementById('childClothes13_17').textContent = filteredMetrics.clothing_inventory_children_13_17.toLocaleString();
  }

  // Update shelter info
  if (document.getElementById('occupiedSpaces')) {
    document.getElementById('occupiedSpaces').textContent = evacueeCount.toLocaleString();
  }
  if (document.getElementById('availableSpaces')) {
    document.getElementById('availableSpaces').textContent = filteredMetrics.available_spaces;
  }
  if (document.getElementById('shelterStatus')) {
    document.getElementById('shelterStatus').textContent = selectedArea ? `${evacueeCount} evacuees in ${selectedArea}` : 'Show all evacuation areas';
  }

  // Update supply levels
  if (document.getElementById('foodCoverage')) {
    document.getElementById('foodCoverage').textContent = Math.round(filteredMetrics.food_supply_coverage) + '%';
    document.getElementById('foodBar').style.width = filteredMetrics.food_supply_coverage + '%';
  }
  if (document.getElementById('medicalStock')) {
    document.getElementById('medicalStock').textContent = Math.round(filteredMetrics.medical_supply_level) + '%';
    document.getElementById('medicalBar').style.width = filteredMetrics.medical_supply_level + '%';
  }

  // Update clothing needs recommendation
  if (document.getElementById('clothingNeeds')) {
    let clothingNeed;
    if (child6_12Count > 0) {
      clothingNeed = `Priority: Clothing needed for ${child6_12Count} children aged 6-12 years in ${selectedArea}.`;
    } else if (child0_5Count > 0) {
      clothingNeed = `Urgent: Baby clothes needed for ${child0_5Count} children (0-5 years) in ${selectedArea}.`;
    } else if (child13_17Count > 0) {
      clothingNeed = `Priority: Teen clothing needed for ${child13_17Count} adolescents (13-17 years) in ${selectedArea}.`;
    } else if (seniorCount > 0) {
      clothingNeed = `Focus on adult clothing for ${seniorCount} elderly evacuees in ${selectedArea}.`;
    } else {
      clothingNeed = selectedArea ? `No specific clothing needs identified in ${selectedArea}.` : 'Current clothing inventory adequate for all evacuees.';
    }
    document.getElementById('clothingNeeds').textContent = clothingNeed;
  }

  // Update timestamp
  if (document.getElementById('lastUpdate')) {
    document.getElementById('lastUpdate').textContent = new Date().toLocaleString();
  }
}

function resetDSSToAllData() {
  // Get original metrics from controller
  const originalMetrics = @json($dssMetrics);
  
  // Reset DSS title
  const dssTitle = document.querySelector('.panel-title');
  dssTitle.innerHTML = '<i class="fas fa-brain" style="color: var(--teal);"></i> Decision Support System - Evacuee Aid Management';

  // Reset all display elements to original values
  if (document.getElementById('dailyMeals')) {
    document.getElementById('dailyMeals').textContent = originalMetrics.daily_meals_needed.toLocaleString();
  }
  if (document.getElementById('waterSupply')) {
    document.getElementById('waterSupply').textContent = originalMetrics.daily_water_requirement.toLocaleString() + 'L';
  }
  if (document.getElementById('hygieneKits')) {
    document.getElementById('hygieneKits').textContent = originalMetrics.hygiene_kits_needed.toLocaleString();
  }
  if (document.getElementById('blanketSupply')) {
    document.getElementById('blanketSupply').textContent = originalMetrics.blankets_needed.toLocaleString();
  }

  // Reset clothing inventory
  if (document.getElementById('adultClothes')) {
    document.getElementById('adultClothes').textContent = originalMetrics.clothing_inventory_adult.toLocaleString();
  }
  if (document.getElementById('childClothes0_5')) {
    document.getElementById('childClothes0_5').textContent = originalMetrics.clothing_inventory_children_0_5.toLocaleString();
  }
  if (document.getElementById('childClothes6_12')) {
    document.getElementById('childClothes6_12').textContent = originalMetrics.clothing_inventory_children_6_12.toLocaleString();
  }
  if (document.getElementById('childClothes13_17')) {
    document.getElementById('childClothes13_17').textContent = originalMetrics.clothing_inventory_children_13_17.toLocaleString();
  }

  // Reset shelter info
  if (document.getElementById('occupiedSpaces')) {
    document.getElementById('occupiedSpaces').textContent = @json($totalEvacuees);
  }
  if (document.getElementById('availableSpaces')) {
    document.getElementById('availableSpaces').textContent = originalMetrics.available_spaces.toLocaleString();
  }
  if (document.getElementById('shelterStatus')) {
    const occupancyRate = Math.round(originalMetrics.occupancy_rate);
    document.getElementById('shelterStatus').textContent = `${occupancyRate}% occupied. ${occupancyRate > 80 ? 'Critical capacity - prepare overflow areas.' : 'Monitor capacity closely.'}`;
  }

  // Reset supply levels
  if (document.getElementById('foodCoverage')) {
    document.getElementById('foodCoverage').textContent = Math.round(originalMetrics.food_supply_coverage) + '%';
    document.getElementById('foodBar').style.width = originalMetrics.food_supply_coverage + '%';
  }
  if (document.getElementById('medicalStock')) {
    document.getElementById('medicalStock').textContent = Math.round(originalMetrics.medical_supply_level) + '%';
    document.getElementById('medicalBar').style.width = originalMetrics.medical_supply_level + '%';
  }

  // Reset clothing needs recommendation
  if (document.getElementById('clothingNeeds')) {
    let clothingNeed;
    if (originalMetrics.clothing_inventory_children_6_12 > 0) {
      clothingNeed = `Priority: Clothing needed for ${originalMetrics.clothing_inventory_children_6_12} children aged 6-12 years.`;
    } else if (originalMetrics.clothing_inventory_children_0_5 > 0) {
      clothingNeed = `Urgent: Baby clothes needed for ${originalMetrics.clothing_inventory_children_0_5} children (0-5 years).`;
    } else if (originalMetrics.clothing_inventory_children_13_17 > 0) {
      clothingNeed = `Priority: Teen clothing needed for ${originalMetrics.clothing_inventory_children_13_17} adolescents (13-17 years).`;
    } else if (originalMetrics.senior_count > 0) {
      clothingNeed = `Focus on adult clothing for ${originalMetrics.senior_count} elderly evacuees.`;
    } else {
      clothingNeed = 'Current clothing inventory adequate for all evacuees.';
    }
    document.getElementById('clothingNeeds').textContent = clothingNeed;
  }

  // Update timestamp
  if (document.getElementById('lastUpdate')) {
    document.getElementById('lastUpdate').textContent = new Date().toLocaleString();
  }
}

// Search evacuees function
function searchEvacuees() {
  const searchTerm = document.getElementById('searchInput').value.toLowerCase();
  const tableRows = document.querySelectorAll('tbody tr');

  // Calculate DSS metrics for searched evacuees
  let searchedEvacueeCount = 0;
  let searchedSeniorCount = 0;
  let searchedChild0_5Count = 0;
  let searchedChild6_12Count = 0;
  let searchedChild13_17Count = 0;
  let searchedMaleCount = 0;
  let searchedFemaleCount = 0;
  let searchedDailyMeals = 0;

  tableRows.forEach(row => {
    if (row.querySelector('td[colspan]')) {
      // Skip "No evacuees found" rows
      return;
    }
    
    // Get text content from all cells except the action column (last column)
    const rowText = Array.from(row.cells)
      .slice(0, -1) // Exclude action column
      .map(cell => cell.textContent.toLowerCase())
      .join(' ');
    
    const isVisible = rowText.includes(searchTerm);
    row.style.display = isVisible ? '' : 'none';

    if (isVisible) {
      // Count visible evacuees for DSS
      searchedEvacueeCount++;
      
      const ageCell = row.cells[3]; // Age is column 3 (0-indexed)
      const genderCell = row.cells[4]; // Gender is column 4 (0-indexed)
      
      const age = parseInt(ageCell.textContent.trim(), 10);
      const gender = genderCell.textContent.trim();
      
      if (age >= 60) {
        searchedSeniorCount++;
      } else if (age < 18) {
        if (age <= 5) {
          searchedChild0_5Count++;
        } else if (age >= 6 && age <= 12) {
          searchedChild6_12Count++;
        } else if (age >= 13 && age <= 17) {
          searchedChild13_17Count++;
        }
      }
      
      if (gender.toLowerCase() === 'male') {
        searchedMaleCount++;
      } else {
        searchedFemaleCount++;
      }
      
      // Calculate meals for this evacuee
      if (age <= 2) {
        searchedDailyMeals += 6; // Infants: 6 small meals per day
      } else if (age <= 12) {
        searchedDailyMeals += 5; // Children: 3 meals + 2 snacks
      } else if (age <= 17) {
        searchedDailyMeals += 3; // Teens: 3 meals per day
      } else {
        searchedDailyMeals += 3; // Adults: 3 meals per day
      }
    }
  });

  // Update DSS display with searched data
  updateDSSForFilteredArea(searchedEvacueeCount, searchedSeniorCount, searchedChild0_5Count, searchedChild6_12Count, searchedChild13_17Count, searchedMaleCount, searchedFemaleCount, searchedDailyMeals, searchTerm ? `Search: "${searchTerm}"` : '');

  // Show message if no results
  const visibleRows = Array.from(tableRows).filter(row => 
    row.style.display !== 'none' && !row.querySelector('td[colspan]')
  );
  
  const existingNoResults = document.querySelector('tbody tr td[colspan]');
  if (visibleRows.length === 0 && !existingNoResults) {
    const tbody = document.querySelector('tbody');
    const noResultsRow = document.createElement('tr');
    noResultsRow.innerHTML = `
      <td colspan="9" style="text-align:center; color:#9ca3af; padding:12px 16px; font-size:12px;">
        No evacuees found matching "${searchTerm}"
      </td>
    `;
    tbody.appendChild(noResultsRow);
  } else if (visibleRows.length > 0 && existingNoResults) {
    existingNoResults.parentElement.remove();
  }
}

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

        // Check form validity instead of just enabling button
        checkFormValidity();

      } else {

        residentsList.innerHTML = '<div style="padding:20px; text-align:center; color:#9ca3af;">No residents found in this purok</div>';

        residentCount.textContent = '0 residents';

        residentsData.value = '';

        // Check form validity (will disable button since no residents)
        checkFormValidity();

      }

    })

    .catch(error => {

      console.error('Error fetching residents:', error);

      residentsList.innerHTML = '<div style="padding:20px; text-align:center; color:#dc2626;">Error loading residents. Please try again.</div>';

      residentCount.textContent = '0 residents';

      // Check form validity (will disable button due to error)
      checkFormValidity();

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

        // Refresh capacity display if evacuation area is selected
        const evacuationAreaSelect = document.getElementById('evacuationAreaSelect');
        if (evacuationAreaSelect.value) {
          loadFacilityCapacity();
        }

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
          <a href="#" title="View" onclick="viewEvacueeDetails('${data.id}', '${data.fullname}', '${data.age}', '${data.gender}', '${data.evacuation_status}', '${data.area}', '${data.room || 'N/A'}', '${data.evacuation_date || 'N/A'}')"><i class="fas fa-eye"></i></a>
          <a href="#" title="Release" onclick="event.preventDefault(); releaseEvacuee('${data.id}', '${data.fullname}')" style="color: #f59e0b;"><i class="fas fa-door-open"></i></a>
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

// Check for released evacuees on page load
function hideReleasedEvacuees() {
  // Clear old localStorage data to ensure accuracy
  localStorage.removeItem('releasedEvacuees');
  
  // Update count to match server data
  updateTotalEvacueesCount();
}

// Run on page load
document.addEventListener('DOMContentLoaded', function() {
  hideReleasedEvacuees();
  
  // Auto-refresh capacity display if evacuation area is pre-selected
  const evacuationAreaSelect = document.getElementById('evacuationAreaSelect');
  if (evacuationAreaSelect && evacuationAreaSelect.value) {
    loadFacilityCapacity();
  }
});

// View Evacuee Details Function
function viewEvacueeDetails(id, fullname, age, gender, evacuationStatus, evacuationArea, roomNumber, evacuationDate) {
  // Create a detailed view modal or alert with all evacuee information
  const detailsHTML = `
    <div style="max-width: 500px; margin: 0 auto;">
      <h3 style="color: #333; margin-bottom: 20px;">👤 Evacuee Details</h3>
      <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px; margin-bottom: 8px;">
          <strong style="color: #666;">ID:</strong>
          <span>${id}</span>
        </div>
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px; margin-bottom: 8px;">
          <strong style="color: #666;">Full Name:</strong>
          <span>${fullname}</span>
        </div>
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px; margin-bottom: 8px;">
          <strong style="color: #666;">Age:</strong>
          <span>${age}</span>
        </div>
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px; margin-bottom: 8px;">
          <strong style="color: #666;">Gender:</strong>
          <span>${gender}</span>
        </div>
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px; margin-bottom: 8px;">
          <strong style="color: #666;">Evacuation Status:</strong>
          <span><span style="background: #e3f2fd; color: #1976d2; padding: 2px 8px; border-radius: 4px; font-size: 12px;">${evacuationStatus}</span></span>
        </div>
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px; margin-bottom: 8px;">
          <strong style="color: #666;">Evacuation Area:</strong>
          <span>${evacuationArea}</span>
        </div>
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px; margin-bottom: 8px;">
          <strong style="color: #666;">Room Number:</strong>
          <span>${roomNumber}</span>
        </div>
        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px;">
          <strong style="color: #666;">Evacuation Date:</strong>
          <span>${evacuationDate}</span>
        </div>
      </div>
      <div style="text-align: center; margin-top: 20px;">
        <button onclick="closeViewModal()" style="background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Close</button>
      </div>
    </div>
  `;
  
  // Create a simple modal overlay to display the details
  const modalOverlay = document.createElement('div');
  modalOverlay.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10000;
    padding: 20px;
  `;
  
  const modalContent = document.createElement('div');
  modalContent.innerHTML = detailsHTML;
  modalContent.style.cssText = `
    background: white;
    border-radius: 12px;
    max-width: 90%;
    max-height: 90%;
    overflow-y: auto;
    animation: slideIn 0.3s ease;
  `;
  
  modalOverlay.appendChild(modalContent);
  document.body.appendChild(modalOverlay);
  
  // Store reference to modal for closing
  window.currentViewModal = modalOverlay;
  
  // Close modal when clicking overlay
  modalOverlay.addEventListener('click', function(e) {
    if (e.target === modalOverlay) {
      closeViewModal();
    }
  });
  
  // Add animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes slideIn {
      from { transform: translateY(-30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  `;
  document.head.appendChild(style);
}

// Close View Modal Function
function closeViewModal() {
  if (window.currentViewModal) {
    window.currentViewModal.remove();
    window.currentViewModal = null;
  }
}

// Release Evacuee Function
function releaseEvacuee(evacueeId, evacueeName) {
  // Create confirmation modal
  const modalHTML = `
    <div style="max-width: 400px; margin: 0 auto;">
      <h3 style="color: #333; margin-bottom: 20px;">🚪 Release Evacuee</h3>
      <div style="background: #fef3c7; padding: 20px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 20px;">
        <p style="margin: 0; color: #92400e;">Are you sure you want to release <strong>${evacueeName}</strong> from the evacuation area?</p>
        <p style="margin: 10px 0 0 0; font-size: 14px; color: #78350f;">This action will mark them as safely released and update their status.</p>
      </div>
      
      <div style="text-align: left; margin: 20px 0;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Release Time:</label>
        <input type="time" id="releaseTime" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
      </div>
      
      <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
        <button onclick="closeReleaseModal()" style="background: #6b7280; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Cancel</button>
        <button onclick="confirmRelease('${evacueeId}')" style="background: #f59e0b; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Release Evacuee</button>
      </div>
    </div>
  `;
  
  // Create modal overlay
  const modalOverlay = document.createElement('div');
  modalOverlay.id = 'releaseModalOverlay';
  modalOverlay.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10000;
    padding: 20px;
  `;
  
  const modalContent = document.createElement('div');
  modalContent.innerHTML = modalHTML;
  modalContent.style.cssText = `
    background: white;
    border-radius: 12px;
    max-width: 90%;
    max-height: 90%;
    overflow-y: auto;
    animation: slideIn 0.3s ease;
  `;
  
  modalOverlay.appendChild(modalContent);
  document.body.appendChild(modalOverlay);
  
  // Set current time as default
  const now = new Date();
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');
  document.getElementById('releaseTime').value = `${hours}:${minutes}`;
  
  // Close modal when clicking overlay
  modalOverlay.addEventListener('click', function(e) {
    if (e.target === modalOverlay) {
      closeReleaseModal();
    }
  });
}

// Close Release Modal Function
function closeReleaseModal() {
  const modal = document.getElementById('releaseModalOverlay');
  if (modal) {
    modal.remove();
  }
}

// Confirm Release Function
function confirmRelease(evacueeId) {
  const releaseTime = document.getElementById('releaseTime').value;
  
  if (!releaseTime) {
    alert('Please select a release time');
    return;
  }
  
  // Show loading state
  const confirmBtn = event.target;
  const originalText = confirmBtn.innerHTML;
  confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
  confirmBtn.disabled = true;
  
  // Get the evacuation area from the table row before making the API call
  const row = document.querySelector(`tr:has([onclick*="${evacueeId}"])`);
  let evacuationArea = null;
  if (row) {
    const evacuationAreaCell = row.cells[5]; // Evacuation Area is column 5 (0-indexed)
    evacuationArea = evacuationAreaCell ? evacuationAreaCell.textContent.trim() : null;
  }
  
  // Make actual API call to update database
  fetch(`/evacuees/${evacueeId}/release`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value
    },
    body: JSON.stringify({
      release_time: releaseTime
    })
  })
  .then(response => {
    if (response.ok) {
      return response.json();
    } else {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
  })
  .then(data => {
    if (data.success) {
      // Show success message
      showAlert('Evacuee successfully released from evacuation area');
      
      // Close modal
      closeReleaseModal();
      
      // Remove row from table
      if (row) {
        // Add fade out animation
        row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        // Remove row after animation
        setTimeout(() => {
          row.remove();
          
          // Check if table is empty and show message if needed
          const tbody = document.querySelector('tbody');
          const remainingRows = tbody.querySelectorAll('tr:not([style*="display: none"])');
          if (remainingRows.length === 0) {
            const noResultsRow = document.createElement('tr');
            noResultsRow.innerHTML = `
              <td colspan="9" style="text-align:center; color:#9ca3af; padding:12px 16px; font-size:12px;">
                No evacuees found. Add evacuees to see them here.
              </td>
            `;
            tbody.appendChild(noResultsRow);
          }
        }, 300);
      }
      
      // Update total evacuees count from server
      updateTotalEvacueesCount();
      
      // Refresh capacity display for the evacuation area if it's currently selected in the form
      if (evacuationArea) {
        const evacuationAreaSelect = document.getElementById('evacuationAreaSelect');
        if (evacuationAreaSelect.value === evacuationArea) {
          // Refresh the capacity display for this area
          loadFacilityCapacity();
        }
      }
    } else {
      // Show error message
      showAlert(data.message || 'Failed to release evacuee', 'error');
    }
  })
  .catch(error => {
    console.error('Error releasing evacuee:', error);
    showAlert('Failed to release evacuee. Please try again.', 'error');
  })
  .finally(() => {
    confirmBtn.innerHTML = originalText;
    confirmBtn.disabled = false;
  });
}

// Update Total Evacuees Count Function
function updateTotalEvacueesCount() {
  // Fetch accurate count from server
  fetch('/api/evacuees/statistics')
    .then(response => response.json())
    .then(data => {
      // Update the main analytics card
      const mainCountElement = document.querySelector('.analytics-card div[style*="font-size:28px"]');
      if (mainCountElement && data.totalEvacuees !== undefined) {
        mainCountElement.textContent = data.totalEvacuees;
      }
      
      // Update the export modal count
      const sidebarCountElement = document.getElementById('totalEvacueesCount');
      if (sidebarCountElement && data.totalEvacuees !== undefined) {
        sidebarCountElement.textContent = data.totalEvacuees;
      }
    })
    .catch(error => {
      console.error('Error fetching evacuee count:', error);
    });
}

// Modern modal functions
function openModal(id) {
  document.getElementById(id).classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
  document.body.style.overflow = '';
}

// Export modal functions
function showExportPreview() {
  openModal('exportPreviewOverlay');
  loadExportStatistics();
}

function closeExportPreviewModal() {
  closeModal('exportPreviewOverlay');
}

// Toast notification function
function showToast(msg, icon = 'fas fa-circle-check') {
  const t = document.getElementById('toast');
  t.querySelector('i').className = icon;
  document.getElementById('toast-msg').textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3200);
}

// Update showAlert to use toast instead
function showAlert(message, type = 'success') {
  showToast(message, type === 'error' ? 'fas fa-triangle-exclamation' : 'fas fa-circle-check');
}

// Modal click outside handlers
['exportPreviewOverlay', 'addEvacueeOverlay'].forEach(id => {
  document.getElementById(id).addEventListener('click', e => { 
    if (e.target.id === id) closeModal(id); 
  });
});

// Flash auto-dismiss
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.flash-alert').forEach(el => {
    setTimeout(() => { 
      el.style.opacity='0'; 
      el.style.transition='opacity 0.4s'; 
      setTimeout(()=>el.remove(),400); 
    }, 4000);
  });
});

        // ── DSS Functions for Evacuee Aid Management ──
        function refreshDSS() {
            showToast('Refreshing DSS analysis...');
            
            // Animate progress bars
            const foodBar = document.getElementById('foodBar');
            const medicalBar = document.getElementById('medicalBar');
            
            foodBar.style.width = '0%';
            medicalBar.style.width = '0%';
            
            setTimeout(() => {
                // Use real metrics from controller with slight variations for simulation
                const dssMetrics = @json($dssMetrics);
                const evacueeCount = @json($totalEvacuees);
                
                // Add small variations to simulate real-time changes
                const foodVariation = (Math.random() * 10 - 5); // -5 to +5
                const medicalVariation = (Math.random() * 10 - 5); // -5 to +5
                
                const newFoodCoverage = Math.max(20, Math.min(100, dssMetrics.food_supply_coverage + foodVariation));
                const newMedicalStock = Math.max(20, Math.min(100, dssMetrics.medical_supply_level + medicalVariation));
                
                foodBar.style.width = newFoodCoverage + '%';
                medicalBar.style.width = newMedicalStock + '%';
                document.getElementById('foodCoverage').textContent = Math.round(newFoodCoverage) + '%';
                document.getElementById('medicalStock').textContent = Math.round(newMedicalStock) + '%';
                
                // Update calculations
                updateAidCalculations();
                updateDSSRecommendations();
                drawAidDistributionChart();
                
                // Update timestamp
                document.getElementById('lastUpdate').textContent = new Date().toLocaleString();
                
                showToast('DSS analysis updated successfully');
            }, 1000);
        }

        function updateAidCalculations() {
            const evacueeCount = @json($totalEvacuees);
            const dssMetrics = @json($dssMetrics);
            
            // Update with real metrics from controller
            document.getElementById('dailyMeals').textContent = dssMetrics.daily_meals_needed.toLocaleString();
            document.getElementById('waterSupply').textContent = dssMetrics.daily_water_requirement.toLocaleString() + 'L';
            document.getElementById('hygieneKits').textContent = dssMetrics.hygiene_kits_needed.toLocaleString();
            document.getElementById('blanketSupply').textContent = dssMetrics.blankets_needed.toLocaleString();
            
            // Update clothing inventory
            document.getElementById('adultClothes').textContent = dssMetrics.clothing_inventory_adult.toLocaleString();
            document.getElementById('childClothes0_5').textContent = dssMetrics.clothing_inventory_children_0_5.toLocaleString();
            document.getElementById('childClothes6_12').textContent = dssMetrics.clothing_inventory_children_6_12.toLocaleString();
            document.getElementById('childClothes13_17').textContent = dssMetrics.clothing_inventory_children_13_17.toLocaleString();
            
            // Update available spaces
            document.getElementById('availableSpaces').textContent = dssMetrics.available_spaces.toLocaleString();
            
            // Update shelter status with real occupancy rate
            const occupancyRate = Math.round(dssMetrics.occupancy_rate);
            document.getElementById('shelterStatus').textContent = `${occupancyRate}% occupied. ${occupancyRate > 80 ? 'Critical capacity - prepare overflow areas.' : 'Monitor capacity closely.'}`;
            
            // Update supply levels
            document.getElementById('foodCoverage').textContent = Math.round(dssMetrics.food_supply_coverage) + '%';
            document.getElementById('foodBar').style.width = dssMetrics.food_supply_coverage + '%';
            
            document.getElementById('medicalStock').textContent = Math.round(dssMetrics.medical_supply_level) + '%';
            document.getElementById('medicalBar').style.width = dssMetrics.medical_supply_level + '%';
        }

        function updateDSSRecommendations() {
            const evacueeCount = @json($totalEvacuees);
            const dssMetrics = @json($dssMetrics);
            
            // Intelligent recommendations based on real data
            let foodStatus, clothingNeed, medicalAlert, priorities;
            
            // Food status based on supply coverage
            if (dssMetrics.food_supply_coverage > 70) {
                foodStatus = `Sufficient for ${Math.floor(dssMetrics.food_supply_coverage / 20)} days. Monitor consumption patterns.`;
            } else if (dssMetrics.food_supply_coverage > 50) {
                foodStatus = 'Adequate for 3-4 days. Schedule restock by mid-week.';
            } else if (dssMetrics.food_supply_coverage > 30) {
                foodStatus = 'Low stock: 2 days remaining. Expedite resupply immediately.';
            } else {
                foodStatus = 'Critical: Less than 24 hours of food. Emergency restock required.';
            }
            
            // Clothing needs based on actual children age groups
            if (dssMetrics.clothing_inventory_children_6_12 > 0) {
                clothingNeed = `Priority: Clothing needed for ${dssMetrics.clothing_inventory_children_6_12} children aged 6-12 years.`;
            } else if (dssMetrics.clothing_inventory_children_0_5 > 0) {
                clothingNeed = `Urgent: Baby clothes and diapers needed for ${dssMetrics.clothing_inventory_children_0_5} children (0-5 years).`;
            } else if (dssMetrics.clothing_inventory_children_13_17 > 0) {
                clothingNeed = `Priority: Teen clothing needed for ${dssMetrics.clothing_inventory_children_13_17} adolescents (13-17 years).`;
            } else if (dssMetrics.senior_count > 0) {
                clothingNeed = `Focus on adult clothing for ${dssMetrics.senior_count} elderly evacuees.`;
            } else {
                clothingNeed = 'Current clothing inventory adequate for all evacuees.';
            }
            
            // Medical alerts based on supply level and vulnerable groups
            if (dssMetrics.medical_supply_level < 40) {
                medicalAlert = `Critical: Only ${dssMetrics.first_aid_kits_needed} first aid kits available for ${evacueeCount} evacuees.`;
            } else if (dssMetrics.chronic_medication_patients > 5) {
                medicalAlert = `Warning: ${dssMetrics.chronic_medication_patients} patients need chronic medication refills.`;
            } else if (dssMetrics.pregnant_women_count > 2) {
                medicalAlert = `Attention: ${dssMetrics.pregnant_women_count} pregnant women need prenatal care supplies.`;
            } else {
                medicalAlert = 'Monitor medical supplies daily. Stock levels adequate.';
            }
            
            // Priority actions based on occupancy and needs
            if (dssMetrics.occupancy_rate > 85) {
                priorities = [
                    'Activate overflow shelter locations immediately',
                    'Prioritize vulnerable groups for relocation',
                    'Deploy additional medical personnel',
                    'Set up temporary distribution points'
                ];
            } else if (dssMetrics.occupancy_rate > 70) {
                priorities = [
                    `Prepare backup shelters for ${dssMetrics.available_spaces} additional evacuees`,
                    'Enhance medical monitoring for elderly and children',
                    'Optimize aid distribution schedules',
                    'Coordinate with neighboring barangays'
                ];
            } else {
                priorities = [
                    'Maintain current aid distribution schedule',
                    'Focus on vulnerable group assistance',
                    'Regular health monitoring and screening',
                    'Community volunteer coordination'
                ];
            }
            
            // Update DOM elements
            document.getElementById('foodStatus').textContent = foodStatus;
            document.getElementById('clothingNeeds').textContent = clothingNeed;
            document.getElementById('medicalAlert').textContent = medicalAlert;
            
            document.getElementById('priority1').textContent = priorities[0];
            document.getElementById('priority2').textContent = priorities[1];
            document.getElementById('priority3').textContent = priorities[2];
            document.getElementById('priority4').textContent = priorities[3];
        }

        function drawAidDistributionChart() {
            const canvas = document.getElementById('aidDistributionChart');
            const ctx = canvas.getContext('2d');
            
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Sample data for aid distribution
            const data = [
                { label: 'Food', value: 35, color: '#10b981' },
                { label: 'Water', value: 25, color: '#3b82f6' },
                { label: 'Clothing', value: 20, color: '#8b5cf6' },
                { label: 'Medical', value: 15, color: '#ef4444' },
                { label: 'Other', value: 5, color: '#f59e0b' }
            ];
            
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = Math.min(centerX, centerY) - 40;
            
            let currentAngle = -Math.PI / 2;
            
            data.forEach((segment, index) => {
                const sliceAngle = (segment.value / 100) * 2 * Math.PI;
                
                // Draw pie slice
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
                ctx.lineTo(centerX, centerY);
                ctx.fillStyle = segment.color;
                ctx.fill();
                
                // Draw label
                const labelAngle = currentAngle + sliceAngle / 2;
                const labelX = centerX + Math.cos(labelAngle) * (radius * 0.7);
                const labelY = centerY + Math.sin(labelAngle) * (radius * 0.7);
                
                ctx.fillStyle = 'white';
                ctx.font = 'bold 11px DM Sans';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(segment.value + '%', labelX, labelY);
                
                currentAngle += sliceAngle;
            });
            
            // Draw legend
            ctx.font = '11px DM Sans';
            ctx.textAlign = 'left';
            let legendY = 20;
            
            data.forEach(segment => {
                ctx.fillStyle = segment.color;
                ctx.fillRect(10, legendY - 8, 12, 12);
                
                ctx.fillStyle = '#374151';
                ctx.fillText(segment.label + ' (' + segment.value + '%)', 28, legendY);
                legendY += 20;
            });
        }

        function generateAidDistributionPlan() {
            showToast('Generating aid distribution plan...');
            
            setTimeout(() => {
                const evacueeCount = {{ $totalEvacuees }};
                const planContent = `AID DISTRIBUTION PLAN - B-DEAMS
Generated: ${new Date().toLocaleString()}
Current Evacuees: ${evacueeCount}

=== IMMEDIATE ACTIONS (Next 24 Hours) ===
1. FOOD DISTRIBUTION
   • Emergency food packs: ${evacueeCount * 3} meals
   • Distribution points: 4 stations
   • Priority: Elderly, children, pregnant women
   • Schedule: 6AM, 12PM, 6PM

2. WATER SUPPLY
   • Daily requirement: ${evacueeCount * 4} liters
   • Water stations: 6 locations
   • Purification tablets: ${Math.ceil(evacueeCount * 2)} units
   • Storage capacity: 2000L

3. CLOTHING DISTRIBUTION
   • Adult clothing needed: ${Math.ceil(evacueeCount * 0.6)} sets
   • Children clothing needed: ${Math.ceil(evacueeCount * 0.4)} sets
   • Special needs: Diapers, baby formula
   • Distribution method: Family-based allocation

4. MEDICAL SUPPLIES
   • First aid kits: ${Math.ceil(evacueeCount / 10)} kits
   • Prescription medications: 7-day supply
   • Hygiene kits: ${Math.ceil(evacueeCount * 0.8)} kits
   • Medical personnel: 2 doctors, 4 nurses

=== SHELTER MANAGEMENT ===
• Current occupancy: ${Math.round((evacueeCount / 500) * 100)}%
• Available spaces: ${500 - evacueeCount}
• Overflow capacity: 200 additional spaces
• Sanitation facilities: 8 bathrooms, 4 showers

=== LOGISTICS COORDINATION ===
• Supply trucks: 3 vehicles scheduled
• Volunteer teams: 15 people per shift
• Communication: 2-way radios, mobile phones
• Security: 6 personnel per location

=== MONITORING & REPORTING ===
• Daily headcount: 6AM and 6PM
• Supply inventory: Real-time tracking
• Health monitoring: Temperature checks twice daily
• Incident reporting: Immediate escalation protocol

=== CONTACT INFORMATION ===
• Emergency Coordinator: [Contact Number]
• Medical Team Lead: [Contact Number]
• Supply Manager: [Contact Number]
• 24/7 Hotline: [Emergency Number]`;
                
                downloadFile('aid_distribution_plan.txt', planContent);
                showToast('Aid distribution plan generated and downloaded');
            }, 1500);
        }

        function generateNeedsAssessment() {
            showToast('Generating comprehensive needs assessment...');
            
            setTimeout(() => {
                const evacueeCount = {{ $totalEvacuees }};
                const assessmentContent = `EVACUEE NEEDS ASSESSMENT - B-DEAMS
Assessment Date: ${new Date().toLocaleString()}
Total Evacuees: ${evacueeCount}

=== CRITICAL NEEDS ANALYSIS ===

1. FOOD SECURITY
   Status: ${Math.random() > 0.5 ? 'CRITICAL' : 'MODERATE'}
   Daily Requirement: ${evacueeCount * 3} meals
   Current Stock: ${Math.floor(evacueeCount * 2.5)} meals
   Gap: ${evacueCount * 0.5} meals needed
   Priority Level: HIGH

2. WATER AND SANITATION
   Status: ${Math.random() > 0.6 ? 'ADEQUATE' : 'INSUFFICIENT'}
   Daily Requirement: ${evacueeCount * 4} liters
   Current Supply: ${Math.floor(evacueeCount * 3.5)} liters
   Gap: ${evacueeCount * 0.5} liters needed
   Sanitation Facilities: ${Math.ceil(evacueeCount / 25)} units needed

3. SHELTER CAPACITY
   Status: ${Math.random() > 0.7 ? 'OVERCROWDED' : 'MANAGEABLE'}
   Current Occupancy: ${Math.round((evacueeCount / 500) * 100)}%
   Available Spaces: ${500 - evacueeCount}
   Overflow Risk: ${evacueeCount > 450 ? 'HIGH' : 'LOW'}

4. MEDICAL REQUIREMENTS
   Status: ${Math.random() > 0.4 ? 'URGENT' : 'STABLE'}
   First Aid Kits: ${Math.ceil(evacueeCount / 10)} needed
   Chronic Medications: ${Math.ceil(evacueeCount * 0.15)} patients
   Mental Health Support: ${Math.ceil(evacueeCount * 0.2)} sessions needed
   Emergency Medical Transport: 2 vehicles on standby

=== VULNERABLE GROUPS ASSESSMENT ===

1. ELDERLY (60+ years)
   Estimated Count: ${Math.ceil(evacueeCount * 0.25)}
   Special Needs: Medication, mobility assistance, special diet
   Required Support: ${Math.ceil(evacueeCount * 0.05)} dedicated caregivers

2. CHILDREN (0-12 years)
   Estimated Count: ${Math.ceil(evacueeCount * 0.35)}
   Special Needs: Baby formula, diapers, child-friendly food
   Required Support: ${Math.ceil(evacueeCount * 0.1)} child care workers

3. PREGNANT WOMEN
   Estimated Count: ${Math.ceil(evacueeCount * 0.08)}
   Special Needs: Prenatal care, nutrition supplements
   Required Support: ${Math.ceil(evacueeCount * 0.02)} midwives/nurses

4. PERSONS WITH DISABILITIES
   Estimated Count: ${Math.ceil(evacueeCount * 0.12)}
   Special Needs: Accessible facilities, assistive devices
   Required Support: ${Math.ceil(evacueeCount * 0.03)} specialized assistants

=== SUPPLY CHAIN ANALYSIS ===

IMMEDIATE NEEDS (Next 48 hours):
• Emergency food rations: ${evacueeCount * 2} packs
• Bottled water: ${evacueeCount * 8} liters
• Blankets: ${Math.ceil(evacueeCount * 0.8)} pieces
• Hygiene kits: ${Math.ceil(evacueeCount * 0.7)} kits

MEDIUM-TERM NEEDS (Next 7 days):
• Fresh food supplies: Weekly restock required
• Medical supplies: Full inventory replenishment
• Clothing replacements: Seasonal requirements
• Educational materials: ${Math.ceil(evacueeCount * 0.3)} sets

=== RECOMMENDATIONS ===

1. IMMEDIATE ACTIONS:
   • Activate emergency procurement protocol
   • Deploy additional medical personnel
   • Establish overflow shelter locations
   • Implement rationing if necessary

2. RESOURCE OPTIMIZATION:
   • Centralize distribution points
   • Implement digital tracking system
   • Coordinate with neighboring barangays
   • Engage community volunteers

3. MONITORING FRAMEWORK:
   • Daily needs assessment updates
   • Real-time inventory tracking
   • Community feedback mechanisms
   • Regular health monitoring

=== CONTACT DIRECTORY ===
Emergency Operations Center: [Phone Number]
Medical Emergency: [Phone Number]
Supply Coordinator: [Phone Number]
Shelter Management: [Phone Number]
Psychosocial Support: [Phone Number]`;
                
                downloadFile('needs_assessment.txt', assessmentContent);
                showToast('Needs assessment report generated and downloaded');
            }, 1500);
        }

        function optimizeResourceAllocation() {
            showToast('Optimizing resource allocation...');
            
            setTimeout(() => {
                const evacueeCount = {{ $totalEvacuees }};
                const optimizationContent = `RESOURCE ALLOCATION OPTIMIZATION - B-DEAMS
Analysis Date: ${new Date().toLocaleString()}
Current Evacuees: ${evacueeCount}

=== OPTIMIZATION ANALYSIS ===

CURRENT ALLOCATION EFFICIENCY: ${Math.floor(Math.random() * 20) + 75}%

=== FOOD DISTRIBUTION OPTIMIZATION ===

Current Model: Centralized Distribution
Efficiency Score: ${Math.floor(Math.random() * 15) + 70}%

Recommended Improvements:
• Establish 4 distribution points instead of 2
• Implement family-based rationing system
• Schedule distribution at 6AM, 12PM, 6PM
• Priority lanes for elderly and disabled

Expected Improvement: +${Math.floor(Math.random() * 15) + 20}% efficiency

=== SHELTER SPACE OPTIMIZATION ===

Current Utilization: ${Math.round((evacueeCount / 500) * 100)}%
Optimization Potential: ${Math.floor(Math.random() * 10) + 15}%

Recommendations:
• Reorganize sleeping arrangements by family units
• Create dedicated areas for vulnerable groups
• Implement rotational cleaning schedules
• Establish quiet zones for elderly and infants

Space Savings: ${Math.floor(Math.random() * 50) + 30} additional spaces

=== MEDICAL RESOURCE OPTIMIZATION ===

Current Response Time: ${Math.floor(Math.random() * 10) + 5} minutes
Target Response Time: 3 minutes

Optimization Strategy:
• Deploy medical stations in each shelter zone
• Implement triage system for emergencies
• Establish 24/7 medical hotline
• Train community health workers

Coverage Improvement: ${Math.floor(Math.random() * 25) + 40}%

=== SUPPLY CHAIN OPTIMIZATION ===

Current Delivery Frequency: Daily
Optimized Frequency: Twice daily

Inventory Management:
• Implement real-time tracking system
• Set automatic reorder triggers at 30% capacity
• Establish backup supplier network
• Create emergency procurement protocols

Cost Savings: ${Math.floor(Math.random() * 15) + 10}% reduction

=== HUMAN RESOURCE OPTIMIZATION ===

Current Volunteer Utilization: ${Math.floor(Math.random() * 20) + 60}%
Optimized Utilization: ${Math.floor(Math.random() * 20) + 85}%

Staffing Recommendations:
• Implement shift scheduling system
• Cross-train volunteers for multiple roles
• Establish team leader structure
• Create skill-based assignment system

Productivity Gain: ${Math.floor(Math.random() * 30) + 25}%

=== TECHNOLOGY INTEGRATION ===

Digital Solutions:
• Mobile app for evacuee registration
• QR code system for aid distribution
• Real-time inventory management
• Automated reporting dashboard

Implementation Timeline: 2 weeks
Expected ROI: ${Math.floor(Math.random() * 40) + 60}% within 6 months

=== MONITORING & EVALUATION ===

Key Performance Indicators:
• Aid distribution time: Target < 30 minutes
• Shelter occupancy rate: Maintain < 90%
• Medical response time: Target < 5 minutes
• Supply availability: Maintain > 85%

Review Schedule:
• Daily operational briefing
• Weekly performance review
• Monthly optimization assessment
• Quarterly strategic planning

=== IMPLEMENTATION ROADMAP ===

Phase 1 (Immediate - 24 hours):
• Reorganize distribution points
• Implement priority lanes
• Deploy additional medical stations

Phase 2 (Short-term - 1 week):
• Install tracking systems
• Train volunteers on new protocols
• Establish backup supply chains

Phase 3 (Medium-term - 1 month):
• Full technology integration
• Process automation
• Performance optimization

=== EXPECTED OUTCOMES ===

Efficiency Improvements:
• ${Math.floor(Math.random() * 20) + 30}% faster aid distribution
• ${Math.floor(Math.random() * 15) + 25}% better resource utilization
• ${Math.floor(Math.random() * 10) + 40}% improved response time
• ${Math.floor(Math.random() * 20) + 20}% cost reduction

Quality Improvements:
• Enhanced evacuee satisfaction
• Reduced waiting times
• Better health outcomes
• Improved shelter conditions`;
                
                downloadFile('resource_optimization.txt', optimizationContent);
                showToast('Resource optimization plan generated and downloaded');
            }, 1500);
        }

        function downloadFile(filename, content) {
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        function exportDSSReport() {
            showToast('Generating comprehensive evacuee needs report...');
            
            setTimeout(() => {
                const evacueeCount = @json($totalEvacuees);
                const dssMetrics = @json($dssMetrics);
                
                const reportContent = `EVACUEE NEEDS ASSESSMENT REPORT
B-DEAMS - Barangay Disaster Evacuation Alert Management System
Generated: ${new Date().toLocaleString()}
Report Type: Comprehensive Evacuee Needs Analysis

=== EXECUTIVE SUMMARY ===
Total Evacuees: ${evacueeCount}
Current Shelter Occupancy: ${Math.round(dssMetrics.occupancy_rate)}%
Available Shelter Spaces: ${dssMetrics.available_spaces}
Active Evacuation Centers: {{ $totalShelters }}

=== EVACUEE DEMOGRAPHICS ===
Male Population: ${dssMetrics.male_count} (${Math.round((dssMetrics.male_count / evacueeCount) * 100)}%)
Female Population: ${dssMetrics.female_count} (${Math.round((dssMetrics.female_count / evacueeCount) * 100)}%)

=== VULNERABLE GROUPS ANALYSIS ===

1. ELDERLY POPULATION (60+ years)
   Count: ${dssMetrics.senior_count} evacuees
   Percentage: ${Math.round((dssMetrics.senior_count / evacueeCount) * 100)}% of total
   Special Requirements:
   - Chronic medication management: ${dssMetrics.chronic_medication_patients} patients
   - Mobility assistance: ${Math.ceil(dssMetrics.senior_count * 0.3)} individuals
   - Special dietary needs: ${Math.ceil(dssMetrics.senior_count * 0.4)} individuals
   - 24/7 monitoring: ${Math.ceil(dssMetrics.senior_count * 0.2)} high-risk cases

2. CHILDREN POPULATION (0-17 years)
   Total Count: ${dssMetrics.child_count} evacuees
   Percentage: ${Math.round((dssMetrics.child_count / evacueeCount) * 100)}% of total
   
   Age Group Breakdown:
   - Infants/Toddlers (0-5 years): ${dssMetrics.clothing_inventory_children_0_5} children
   - School Age (6-12 years): ${dssMetrics.clothing_inventory_children_6_12} children
   - Teenagers (13-17 years): ${dssMetrics.clothing_inventory_children_13_17} children
   
   Special Requirements:
   - Baby formula and diapers: ${dssMetrics.clothing_inventory_children_0_5} infants/toddlers
   - Child-friendly meals: ${dssMetrics.child_count} children
   - Educational activities: ${Math.ceil(dssMetrics.child_count * 0.8)} children
   - Child care supervision: ${Math.ceil(dssMetrics.child_count * 0.4)} dedicated caregivers
   - School supplies: ${dssMetrics.clothing_inventory_children_6_12} school-aged children
   - Teen support: ${dssMetrics.clothing_inventory_children_13_17} adolescents

3. PREGNANT WOMEN
   Estimated Count: ${dssMetrics.pregnant_women_count}
   Special Requirements:
   - Prenatal vitamins and supplements
   - Regular health check-ups
   - Nutritional food assistance
   - Comfortable resting areas
   - Emergency birth preparation

4. PERSONS WITH DISABILITIES
   Estimated Count: ${dssMetrics.disabled_persons_count}
   Special Requirements:
   - Accessible facilities and pathways
   - Assistive devices maintenance
   - Personal care assistance
   - Medical equipment support
   - Specialized transportation

=== IMMEDIATE NEEDS ASSESSMENT ===

FOOD REQUIREMENTS:
- Daily Meals Needed: ${dssMetrics.daily_meals_needed} meals (age-appropriate portions)
- Weekly Food Supply: ${dssMetrics.weekly_food_requirement} meals

MEAL REQUIREMENTS BY AGE GROUP:
- Infants/Toddlers (0-5 years): ${dssMetrics.infant_daily_meals} meals (6 small meals per day)
- Children (6-12 years): ${dssMetrics.child_daily_meals} meals (3 meals + 2 snacks per day)
- Teenagers (13-17 years): ${dssMetrics.teen_daily_meals} meals (3 meals per day)
- Adults (18+ years): ${dssMetrics.adult_daily_meals} meals (3 meals per day)

Special Dietary Requirements:
- Elderly soft food: ${Math.ceil(dssMetrics.senior_count * 0.4)} portions
- Baby formula: ${dssMetrics.clothing_inventory_children_0_5} bottles daily
- Child-friendly meals: ${dssMetrics.child_count} portions
- Medical diet: ${dssMetrics.chronic_medication_patients} special meals
- Kitchen Equipment: 4 portable cooking stations needed
- Food Storage: Refrigeration for ${Math.ceil(evacueeCount * 0.3)} cubic meters

WATER AND SANITATION:
- Daily Water Requirement: ${dssMetrics.daily_water_requirement} liters
- Weekly Water Supply: ${dssMetrics.weekly_water_requirement} liters
- Drinking Water Stations: 6 stations required
- Water Purification: ${Math.ceil(evacueeCount * 2)} purification tablets needed
- Bathing Facilities: ${Math.ceil(evacueeCount / 15)} shower stations
- Toilets: ${Math.ceil(evacueeCount / 20)} toilet facilities needed
- Hand Washing Stations: 8 stations with soap and sanitizer

SHELTER AND COMFORT NEEDS:
- Sleeping Arrangements: ${evacueeCount} sleeping spaces
- Blankets Required: ${dssMetrics.blankets_needed} pieces
- Pillows: ${Math.ceil(evacueeCount * 0.8)} pillows
- Mats/Flooring: ${Math.ceil(evacueeCount * 0.3)} additional mats
- Privacy Screens: ${Math.ceil(evacueeCount / 10)} family partitions
- Lighting: 24-hour illumination in common areas

CLOTHING REQUIREMENTS:
- Adult Clothing: ${dssMetrics.clothing_inventory_adult} sets
- Children Clothing by Age Group:
  * Infants/Toddlers (0-5 years): ${dssMetrics.clothing_inventory_children_0_5} sets
  * School Age (6-12 years): ${dssMetrics.clothing_inventory_children_6_12} sets
  * Teenagers (13-17 years): ${dssMetrics.clothing_inventory_children_13_17} sets
- Undergarments: ${evacueeCount * 3} sets (3-day supply)
- Footwear: ${Math.ceil(evacueeCount * 1.2)} pairs
- Rain gear: ${Math.ceil(evacueeCount * 0.5)} sets
- Warm clothing: ${Math.ceil(evacueeCount * 0.7)} sets
- Special Clothing Needs:
  * Baby clothes and diapers: ${dssMetrics.clothing_inventory_children_0_5} sets
  * School uniforms: ${dssMetrics.clothing_inventory_children_6_12} sets
  * Teen appropriate clothing: ${dssMetrics.clothing_inventory_children_13_17} sets

=== MEDICAL AND HEALTH NEEDS ===

FIRST AID AND EMERGENCY:
- First Aid Kits: ${dssMetrics.first_aid_kits_needed} kits
- Emergency Medical Transport: 2 vehicles on standby
- Triage Area: 1 designated space for medical assessment
- Isolation Area: ${Math.ceil(evacueeCount * 0.05)} beds for contagious cases

CHRONIC MEDICATION MANAGEMENT:
- Patients needing chronic medication: ${dssMetrics.chronic_medication_patients}
- Medication Storage: Refrigerated storage for temperature-sensitive drugs
- Medication Schedule: 4-time daily administration tracking
- Emergency Medication: 72-hour supply for all chronic conditions

MENTAL HEALTH AND PSYCHOSOCIAL:
- Counseling Sessions Needed: ${dssMetrics.mental_health_sessions_needed} sessions
- Mental Health Professionals: ${Math.ceil(dssMetrics.mental_health_sessions_needed / 8)} counselors
- Quiet Rooms: 2 designated spaces for counseling
- Group Therapy: Daily support groups for evacuees
- Child Psychosocial Support: ${Math.ceil(dssMetrics.child_count * 0.3)} children needing special attention

MATERNAL AND CHILD HEALTH:
- Pregnant Women Monitoring: ${dssMetrics.pregnant_women_count} women
- Postnatal Care: ${Math.ceil(dssMetrics.pregnant_women_count * 0.3)} new mothers
- Infant Care Supplies: Diapers, formula, baby clothes
- Vaccination Updates: Children immunization status review
- Pediatric Care: ${dssMetrics.child_count} children requiring health monitoring

=== HYGIENE AND SANITATION ===

PERSONAL HYGIENE:
- Hygiene Kits: ${dssMetrics.hygiene_kits_needed} complete kits
- Soap Bars: ${evacueeCount * 2} bars (2-week supply)
- Toothpaste and Toothbrushes: ${evacueeCount} sets
- Shampoo and Conditioner: ${Math.ceil(evacueeCount * 0.8)} bottles
- Feminine Hygiene Products: ${Math.ceil(dssMetrics.female_count * 0.6)} packages
- Adult Diapers: ${Math.ceil(dssMetrics.senior_count * 0.2)} packages

ENVIRONMENTAL SANITATION:
- Waste Management: ${Math.ceil(evacueeCount / 25)} waste bins
- Disinfectant Supplies: 20 liters of disinfectant solution
- Cleaning Equipment: Mops, buckets, cleaning supplies
- Pest Control: Monthly pest control services
- Ventilation: Air circulation systems for enclosed spaces

=== COMMUNICATION AND INFORMATION ===

EVACUEE COMMUNICATION:
- Information Board: 1 central announcement board
- Family Contact: Communication hub for family reunification
- Emergency Hotline: 24/7 helpline for evacuee concerns
- Language Support: Translation services for non-local evacuees
- Special Needs Communication: ${dssMetrics.disabled_persons_count} individuals needing assistance

STAFF AND VOLUNTEER COORDINATION:
- Medical Staff: 2 doctors, 4 nurses per shift
- Social Workers: ${Math.ceil(evacueeCount / 50)} social workers
- Volunteer Coordinators: 3 team leaders
- Security Personnel: 6 guards per location
- Kitchen Staff: ${Math.ceil(evacueeCount / 100)} kitchen helpers

=== LOGISTICS AND TRANSPORTATION ===

SUPPLY CHAIN REQUIREMENTS:
- Daily Food Deliveries: 3 deliveries per day
- Water Tanker Services: 2 tankers per day
- Medical Supply Resupply: Weekly inventory restock
- Waste Collection: Daily waste removal services
- Laundry Services: ${Math.ceil(evacueeCount / 25)} laundry loads per day

TRANSPORTATION NEEDS:
- Medical Transport: 2 ambulances on standby
- Supply Transport: 3 delivery vehicles
- Staff Transport: Shuttle services for relief workers
- Emergency Evacuation: 4 vehicles for medical emergencies
- Family Reunification: Transport for family visits

=== SPECIAL CONSIDERATIONS ===

CULTURAL AND RELIGIOUS NEEDS:
- Prayer Space: 1 quiet area for religious activities
- Dietary Restrictions: Halal/Kosher/vegetarian meal options
- Cultural Sensitivity: Training for staff on cultural practices
- Language Support: Translation for diverse evacuee population

EDUCATION AND CHILD DEVELOPMENT:
- Temporary Learning Space: 1 area for children's education
- Educational Materials: ${dssMetrics.child_count} learning kits
- Recreational Activities: Games and activities for children
- Child Protection: Safe spaces and child protection protocols

SECURITY AND SAFETY:
- 24/7 Security: Security personnel deployment
- Fire Safety: Fire extinguishers and evacuation routes
- Emergency Exits: Clear marking and accessibility
- Crowd Control: Management of high-traffic areas
- Lost and Found: Central location for recovered items

=== RECOMMENDATIONS ===

IMMEDIATE ACTIONS (Next 24 Hours):
1. Prioritize medical needs for vulnerable groups
2. Establish family registration and tracking system
3. Set up dedicated areas for elderly and children
4. Deploy additional medical personnel if needed
5. Ensure adequate water and sanitation facilities

SHORT-TERM ACTIONS (Next 7 Days):
1. Implement mental health support programs
2. Establish educational activities for children
3. Create sustainable supply chain management
4. Develop family reunification procedures
5. Set up long-term shelter management protocols

MEDIUM-TERM ACTIONS (Next 30 Days):
1. Develop community integration programs
2. Establish permanent health monitoring systems
3. Create livelihood support programs
4. Implement disaster preparedness training
5. Coordinate with government agencies for long-term support

=== CONTACT DIRECTORY ===
Emergency Operations Center: [Phone Number]
Medical Emergency: [Phone Number]
Mental Health Support: [Phone Number]
Social Services: [Phone Number]
Family Reunification: [Phone Number]
Supply Coordinator: [Phone Number]
Volunteer Hotline: [Phone Number]

=== REPORT SUMMARY ===
This comprehensive needs assessment provides a detailed analysis of the current requirements for ${evacueeCount} evacuees in the evacuation center. The report identifies critical needs across multiple categories and provides actionable recommendations for ensuring the health, safety, and well-being of all evacuees during their stay.

Key Priority Areas:
1. Medical care for vulnerable groups (${dssMetrics.senior_count + dssMetrics.child_count} individuals)
2. Adequate food and water supplies (${dssMetrics.daily_meals_needed} meals, ${dssMetrics.daily_water_requirement}L water daily)
3. Mental health and psychosocial support (${dssMetrics.mental_health_sessions_needed} sessions needed)
4. Proper sanitation and hygiene facilities (${dssMetrics.hygiene_kits_needed} kits required)
5. Family support and reunification services

Next Review: ${new Date(Date.now() + 24 * 60 * 60 * 1000).toLocaleString()}
Report Generated by: B-DEAMS Decision Support System`;
                
                downloadFile('evacuee_needs_assessment.txt', reportContent);
                showToast('Evacuee needs assessment report generated and downloaded');
            }, 1500);
        }

        // Initialize DSS on page load
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                updateAidCalculations();
                updateDSSRecommendations();
                drawAidDistributionChart();
            }, 500);
        });
</script>
