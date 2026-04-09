<?php

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {

    $message = $_POST['message'];
    $selectedPurok = $_POST['purok'] ?? '';
    
    $conn = new mysqli("localhost","root","","mswd");
    
    $url = "https://www.iprogsms.com/api/v1/sms_messages";
    $api_token = "4c6d97157878d401afe5862e8360c89034b1857b";
    
    // Filter by selected purok if provided
    if (!empty($selectedPurok)) {
        $query = "SELECT contact_number FROM residents WHERE contact_number IS NOT NULL AND description = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $selectedPurok);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        echo "Sending SMS to residents in: $selectedPurok\n";
    } else {
        $query = "SELECT contact_number FROM residents WHERE contact_number IS NOT NULL";
        $result = $conn->query($query);
        echo "Sending SMS to ALL residents\n";
    }

    // Debug: Check how many residents we found
    $residentCount = $result->num_rows;

    echo "<div class='output-container'>";
    echo "<div class='output-header'>? SMS Transmission Log</div>";
    echo "<pre class='output-content'>";
    echo "Found {$residentCount} residents with contact numbers.\n";
    
    if ($residentCount == 0) {
        echo "No residents found with contact numbers.\n";
    }

    while($row = $result->fetch_assoc()){
        $phone = $row['contact_number']; // Fixed: use contact_number instead of phone
        
        echo "Processing phone: {$phone}\n";

        $data = [
            'api_token' => $api_token,
            'message' => $message,
            'phone_number' => $phone
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            echo "Curl error: " . curl_error($ch) . "\n";
        } else {
            echo "SMS API Response (HTTP {$httpCode}): " . $response . "\n";
        }

        curl_close($ch);

        echo "SMS sent to ".$phone."\n";

        sleep(1); // prevents API blocking
    }

    echo "\n? All messages sent successfully.";
    echo "</pre>";
    echo "</div>";

    echo "<style>
        .output-container {
            background: #f0f4f8;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            margin: 20px;
        }
        
        .output-header {
            background: var(--navy);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
        }
        
        .output-content {
            padding: 20px;
            font-size: 14px;
            font-family: 'Consolas', 'Monaco', monospace;
            color: var(--text-dark);
            background: white;
            margin: 0;
        }
    </style>";

} else {

    // Display the form

    // Get distinct puroks from residents table
    $conn = new mysqli("localhost","root","","mswd");
    $purok_query = "SELECT DISTINCT description as purok FROM residents WHERE description IS NOT NULL AND description != '' ORDER BY description";
    $purok_result = $conn->query($purok_query);
    $puroks = [];
    while($row = $purok_result->fetch_assoc()){
        // Extract purok from description (assuming format like "Purok I" or similar)
        $purok_name = trim($row['purok']);
        if(!empty($purok_name)) {
            $puroks[] = $purok_name;
        }
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>SMS Alert - B-DEAMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

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
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }


        /* MAIN */
        .main {
            padding: 36px 40px;
            min-height: 100vh;
        }

        /* PAGE HEADER */
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

        /* PANEL */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
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
        .panel-body { padding: 24px; }

        /* FORM COMPONENTS */
        .form-group { margin-bottom: 20px; }

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

        textarea.form-control { resize: vertical; min-height: 120px; }

        /* BUTTONS */
        .btn {
            padding: 9px 20px;
            border-radius: 10px;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--navy);
            color: white;
        }

        .btn-primary:hover { background: var(--navy-mid); }

        .btn-teal {
            background: var(--teal);
            color: white;
        }

        .btn-teal:hover { background: #0d8780; }

        .btn-rose {
            background: var(--rose);
            color: white;
        }

        .btn-rose:hover { background: #e11d48; }

        .btn-amber {
            background: var(--amber);
            color: white;
        }

        .btn-amber:hover { background: #d97706; }

        .btn-block {
            width: 100%;
            justify-content: center;
            padding: 12px 24px;
            font-size: 14px;
        }

        /* QUICK ACTIONS GRID */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }

        /* RESIDENTS DISPLAY */
        .residents-display {
            background: var(--slate-light);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .residents-display::-webkit-scrollbar { display: none; }

        .resident-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: white;
            border-radius: 10px;
            margin-bottom: 8px;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .resident-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .resident-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .resident-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .resident-details h4 {
            margin: 0;
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .resident-details p {
            margin: 2px 0 0 0;
            font-size: 12px;
            color: var(--text-muted);
        }

        .evacuation-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-evacuated {
            background: var(--rose-light);
            color: #be123c;
        }

        .status-not-evacuated {
            background: var(--green-light);
            color: #059669;
        }

        /* EMERGENCY INDICATOR */
        .emergency-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--rose);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* ANIMATIONS */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .anim       { animation: fadeUp 0.4s ease both; }
        .delay-1    { animation-delay: 0.07s; }
        .delay-2    { animation-delay: 0.13s; }
        .delay-3    { animation-delay: 0.19s; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .main { padding: 24px 20px; }
            .quick-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>


    <!-- MAIN CONTENT -->
    <main class="main">

        <!-- Page Header -->
        <div class="page-header anim">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                <div>
                    <p class="page-eyebrow">Emergency Services</p>
                    <h1 class="page-title">SMS Alert System</h1>
                </div>
                <a href="{{ route('services') }}" class="back-button">
                    <i class="fas fa-chevron-left"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- SMS Alert Panel -->
        <div class="panel anim delay-1">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-sms"></i> Emergency SMS Broadcasting
                </div>
            </div>
            <div class="panel-body">
                <div class="emergency-indicator">
                    <i class="fas fa-exclamation-triangle"></i> EMERGENCY MODE
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="purok">Target Purok</label>
                    <select id="purok" class="form-control" name="purok" onchange="loadResidents()">
                        <option value="">All Puroks (Global Alert)</option>
                        <?php foreach($puroks as $purok): ?>
                            <option value="<?php echo htmlspecialchars($purok); ?>"><?php echo htmlspecialchars($purok); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="residents-display" id="residentsDisplay" style="display: none;">
                    <div style="font-weight: 600; color: var(--text-dark); margin-bottom: 12px; font-size: 14px;">
                        <i class="fas fa-users" style="color: var(--teal); margin-right: 6px;"></i>
                        Residents in Selected Purok
                    </div>
                    <div id="residentsList">
                        <!-- Residents will be loaded here via JavaScript -->
                    </div>
                </div>
                
                <form method="POST">
                    @csrf
                    <input type="hidden" name="purok" id="selectedPurok" value="">
                    
                    <div class="form-group">
                        <label class="form-label" for="message">Emergency Message Content</label>
                        <textarea name="message" id="message" class="form-control" required placeholder="Type your emergency message here...">Advisory: Please prepare for a possible disaster. Ensure your emergency kits are ready (water, food, first aid, batteries). Be ready for possible evacuation anytime.</textarea>
                    </div>
                    
                    <div style="margin-bottom: 24px;">
                        <div style="font-weight: 600; color: var(--text-dark); margin-bottom: 12px; font-size: 14px;">
                            <i class="fas fa-bolt" style="color: var(--amber); margin-right: 6px;"></i>
                            Quick Alert Templates
                        </div>
                        <div class="quick-grid">
                            <button type="button" class="btn btn-rose" onclick="setEarlyEvacuationMessage()">
                                <i class="fas fa-exclamation-triangle"></i> Early Evacuation
                            </button>
                            <button type="button" class="btn btn-amber" onclick="setPurok1Message()">
                                <i class="fas fa-map-marker-alt"></i> Purok 1
                            </button>
                            <button type="button" class="btn btn-amber" onclick="setPurok2Message()">
                                <i class="fas fa-map-marker-alt"></i> Purok 2
                            </button>
                            <button type="button" class="btn btn-amber" onclick="setPurok3Message()">
                                <i class="fas fa-map-marker-alt"></i> Purok 3
                            </button>
                            <button type="button" class="btn btn-amber" onclick="setPurok4Message()">
                                <i class="fas fa-map-marker-alt"></i> Purok 4
                            </button>
                            <button type="button" class="btn btn-amber" onclick="setPurok5Message()">
                                <i class="fas fa-map-marker-alt"></i> Purok 5
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i>
                        <span id="submitBtnText">? SEND EMERGENCY SMS TO ALL RESIDENTS</span>
                    </button>
                </form>
            </div>
        </div>

    </main>
    
    <script>
        function updateMessage(template) {
            const messageField = document.getElementById('message');
            const messages = {
                'evacuation': ' IMMEDIATE EVACUATION ALERT: Emergency situation detected in your area. EVACUATE NOW to designated evacuation center: [CENTER NAME]. Bring: emergency kit, important documents, medications, water, and food for 3 days. Lock your home. Follow designated evacuation routes. DO NOT DELAY. Contact: [EMERGENCY HOTLINE]. Stay safe and help others if possible.',
                'typhoon': ' TYPHOON WARNING: Signal No. [X] raised. Secure loose objects, stay indoors, and avoid unnecessary travel. Stock up on food and water. Monitor updates from local authorities.',
                'flood': ' FLOOD WARNING: Water levels rising in your area. Move to higher ground immediately. Turn off electricity and gas. Avoid walking or driving through flood waters.',
                'earthquake': ' EARTHQUAKE ALERT: Strong earthquake detected. Drop, Cover, and Hold On. After shaking stops, check for injuries and damage. Be prepared for aftershocks.',
                'fire': ' FIRE EMERGENCY: Fire reported in your vicinity. Evacuate immediately using nearest exit. Do not use elevators. Call emergency services if safe to do so.',
                'meeting': ' COMMUNITY MEETING: Important community meeting scheduled on [Date] at [Time] at [Location]. Your attendance is highly appreciated. Thank you.',
                'health': ' HEALTH ADVISORY: Important health announcement regarding [Issue]. Please take necessary precautions. For medical concerns, contact your local health center.',
                'custom': ''
            };
            
            // Clear message field first
            messageField.value = '';
            
            // Set the message immediately when template is selected
            if (template && messages[template]) {
                messageField.value = messages[template];
                // Trigger input event to ensure any listeners are notified
                messageField.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }
        
        function setEmergencyMessage() {
            document.getElementById('message').value = ' IMMEDIATE EVACUATION ALERT: Emergency situation detected in your area. EVACUATE NOW to designated evacuation center: [CENTER NAME]. Bring: emergency kit, important documents, medications, water, and food for 3 days. Lock your home. Follow designated evacuation routes. DO NOT DELAY. Contact: [EMERGENCY HOTLINE]. Stay safe and help others if possible.';
        }
        
        function setTyphoonMessage() {
            document.getElementById('message').value = ' TYPHOON WARNING: Signal No. [X] raised. Secure loose objects, stay indoors, and avoid unnecessary travel. Stock up on food and water. Monitor updates from local authorities.';
        }
        
        function setFloodMessage() {
            document.getElementById('message').value = ' FLOOD WARNING: Water levels rising in your area. Move to higher ground immediately. Turn off electricity and gas. Avoid walking or driving through flood waters.';
        }
        
        function setEarlyEvacuationMessage() {
            document.getElementById('message').value = ' EARLY EVACUATION ALERT: All residents are advised to evacuate immediately due to potential danger. Proceed to the nearest evacuation center. Vehicles are waiting at designated exits. Stay calm and follow instructions.';
        }
        
        function setPurok1Message() {
            document.getElementById('message').value = 'PUROK 1 ALERT: Attention all residents of Purok 1! This is an automated emergency notification. Please be advised of important community updates or emergency instructions. Follow all safety protocols and await further instructions from barangay officials. Stay safe and look out for your neighbors.';
        }
        
        function setPurok2Message() {
            document.getElementById('message').value = 'PUROK 2 ALERT: Important notice for all Purok 2 residents. Emergency response team is available to assist you. Please remain calm and follow official guidance. Keep your emergency kits ready and stay informed through official channels.';
        }
        
        function setPurok3Message() {
            document.getElementById('message').value = 'PUROK 3 ALERT: Attention residents of Purok 3. This is an automated alert system message. Please check on elderly neighbors and ensure your family is prepared. Follow evacuation routes if instructed and contact barangay hall for assistance.';
        }
        
        function setPurok4Message() {
            document.getElementById('message').value = 'PUROK 4 ALERT: Important message for all Purok 4 households. Emergency services are on standby. Please secure your belongings, prepare for possible evacuation, and stay tuned for further updates from local authorities.';
        }
        
        function setPurok5Message() {
            document.getElementById('message').value = 'PUROK 5 ALERT: Automated alert for Purok 5 residents. Your safety is our priority. Please follow all emergency procedures, keep communication lines open, and cooperate with barangay officials. Emergency assistance is available if needed.';
        }
        
        function loadResidents() {
            const purokSelect = document.getElementById('purok');
            const residentsDisplay = document.getElementById('residentsDisplay');
            const residentsList = document.getElementById('residentsList');
            const selectedPurokHidden = document.getElementById('selectedPurok');
            const submitBtnText = document.getElementById('submitBtnText');
            
            const selectedPurok = purokSelect.value;
            
            // Update hidden field and button text
            selectedPurokHidden.value = selectedPurok;
            if (selectedPurok) {
                submitBtnText.textContent = `? SEND EMERGENCY SMS TO ${selectedPurok.toUpperCase()}`;
            } else {
                submitBtnText.textContent = '? SEND EMERGENCY SMS TO ALL RESIDENTS';
            }
            
            if (selectedPurok === '') {
                residentsDisplay.style.display = 'none';
                return;
            }
            
            // Show loading state
            residentsDisplay.style.display = 'block';
            residentsList.innerHTML = '<p style="text-align: center; color: var(--text-muted);">Loading residents...</p>';
            
            // Create AJAX request to get residents for selected purok using Laravel route
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/api/residents/by-purok?purok=' + encodeURIComponent(selectedPurok), true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                console.log('Response status:', xhr.status);
                console.log('Response text:', xhr.responseText);
                
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.residents) {
                            displayResidents(response.residents);
                        } else {
                            residentsList.innerHTML = '<p style="text-align: center; color: var(--rose);">Invalid response format</p>';
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        residentsList.innerHTML = '<p style="text-align: center; color: var(--rose);">Error parsing response</p>';
                    }
                } else {
                    residentsList.innerHTML = '<p style="text-align: center; color: var(--rose);">Error loading residents (Status: ' + xhr.status + ')</p>';
                }
            };
            
            xhr.onerror = function() {
                console.error('Network error occurred');
                residentsList.innerHTML = '<p style="text-align: center; color: var(--rose);">Network error</p>';
            };
            
            console.log('Requesting residents for purok:', selectedPurok);
            xhr.send();
        }
        
        function displayResidents(residents) {
            const residentsList = document.getElementById('residentsList');
            
            if (residents.length === 0) {
                residentsList.innerHTML = '<p style="text-align: center; color: var(--text-muted);">No residents found in this purok</p>';
                return;
            }
            
            let html = '';
            residents.forEach(function(resident) {
                const initials = resident.name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2);
                const contactNumber = resident.contact_number || 'N/A';
                const isEvacuated = resident.evacuation_status === 'Evacuated';
                
                html += `
                    <div class="resident-item">
                        <div class="resident-info">
                            <div class="resident-avatar">${initials}</div>
                            <div class="resident-details">
                                <h4>${resident.name}</h4>
                                <p>${contactNumber}</p>
                            </div>
                        </div>
                        <span class="evacuation-status ${isEvacuated ? 'status-evacuated' : 'status-not-evacuated'}">
                            ${isEvacuated ? 'Already Evacuated' : 'Not Evacuated'}
                        </span>
                    </div>
                `;
            });
            
            residentsList.innerHTML = html;
        }
    </script>

</body>

</html>

    <?php

}

?>
