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
    echo "<div class='output-header'>📡 SMS Transmission Log</div>";
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

    echo "\n✅ All messages sent successfully.";
    echo "</pre>";
    echo "</div>";

    echo "<style>
        .output-container {
            background: #f0f2f5; /* Light grey background from dashboard */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); /* Softer shadow */
            overflow: hidden;
        }
        
        .output-header.sidebar { 
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
        
        .output-content {
            padding: 20px;
            font-size: 14px;
            font-family: 'Consolas', 'Monaco', monospace;
            color: #333;
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

    <html>

    <head>

        <title>Send SMS to All Residents</title>

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                margin: 0; 
                padding: 20px;
                background: #f0f2f5; /* Light grey background from dashboard */
                min-height: 100vh;
            }
            
            .container { 
                max-width: 800px; 
                margin: 0 auto; 
                background: white;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.08); /* Softer shadow */
                overflow: hidden;
            }
            
            .header {
                background: linear-gradient(45deg, #4a007c, #7b1fa2); /* Darker purple gradient */
                color: white;
                padding: 30px;
                text-align: center;
                position: relative;
            }
            
            .back-btn {
                position: absolute;
                left: 30px;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255, 255, 255, 0.2);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.3);
                padding: 10px 15px;
                border-radius: 8px;
                text-decoration: none;
                font-size: 14px;
                font-weight: 600;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            .back-btn:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-50%) translateY(-2px);
                text-decoration: none;
                color: white;
            }
            
            .header h2 {
                font-size: 28px;
                font-weight: 600;
                margin-bottom: 10px;
            }
            
            .header p {
                opacity: 0.9;
                font-size: 14px;
            }
            
            .form-container {
                padding: 40px;
            }
            
            .form-group {
                margin-bottom: 25px;
            }
            
            .purok-selector {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 25px;
                border: 1px solid #e1e5e9;
            }
            
            select {
                width: 100%;
                padding: 12px;
                border: 1px solid #e1e5e9;
                border-radius: 8px;
                font-size: 14px;
                font-family: inherit;
                background: white;
                transition: all 0.3s ease;
            }
            
            select:focus {
                outline: none;
                border-color: #7b1fa2;
                box-shadow: 0 0 0 3px rgba(123, 31, 162, 0.1);
            }
            
            .residents-display {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 25px;
                border: 1px solid #e1e5e9;
                max-height: 300px;
                overflow-y: auto;
            }
            
            .resident-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px;
                background: white;
                border-radius: 8px;
                margin-bottom: 10px;
                border: 1px solid #e1e5e9;
                transition: all 0.3s ease;
            }
            
            .resident-item:hover {
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                transform: translateY(-1px);
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
                background: linear-gradient(45deg, #4a007c, #7b1fa2);
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
                color: #333;
                font-weight: 600;
            }
            
            .resident-details p {
                margin: 4px 0 0 0;
                font-size: 12px;
                color: #666;
            }
            
            .evacuation-status {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
            }
            
            .status-evacuated {
                background: #fee2e2;
                color: #dc2626;
            }
            
            .status-not-evacuated {
                background: #dcfce7;
                color: #16a34a;
            }
            
            label {
                display: block;
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
                font-size: 14px;
            }
            
            textarea { 
                width: 100%; 
                height: 150px;
                padding: 15px;
                border: 1px solid #e1e5e9;
                border-radius: 10px;
                font-size: 14px;
                font-family: inherit;
                resize: vertical;
                transition: all 0.3s ease;
            }
            
            textarea:focus {
                outline: none;
                border-color: #7b1fa2; /* Purple accent from dashboard */
                box-shadow: 0 0 0 3px rgba(123, 31, 162, 0.1);
            }
            
            textarea::placeholder {
                color: #999;
            }
            
            .quick-actions {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 25px;
                border: 1px solid #e1e5e9;
            }
            
            .quick-actions strong {
                display: block;
                margin-bottom: 15px;
                color: #333;
                font-size: 14px;
            }
            
            .alert-btn { 
                padding: 12px 20px; 
                margin: 5px; 
                background: linear-gradient(45deg, #4a007c, #7b1fa2); /* Purple gradient matching dashboard */
                color: white; 
                border: none; 
                cursor: pointer; 
                border-radius: 8px;
                font-weight: 600;
                font-size: 13px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(123, 31, 162, 0.3);
            }
            
            .alert-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(123, 31, 162, 0.4);
            }
            
            .submit-btn {
                width: 100%;
                padding: 15px;
                background: linear-gradient(45deg, #4a007c, #7b1fa2); /* Matching purple gradient */
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 10px 25px rgba(123, 31, 162, 0.3);
            }
            
            .submit-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 15px 35px rgba(123, 31, 162, 0.4);
            }
            
            .emergency-indicator {
                display: inline-block;
                background: #4a007c; /* Dark purple matching sidebar */
                color: white;
                padding: 8px 15px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                margin-bottom: 20px;
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0.7; }
                100% { opacity: 1; }
            }
        </style>

    </head>

    <body>

        <div class="container">
            <div class="header">
                <a href="{{ route('resident.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
                <h2>Emergency SMS System</h2>
                <p>Send critical alerts to all residents instantly</p>
            </div>
            
            <div class="form-container">
                <div class="emergency-indicator">🚨 EMERGENCY MODE</div>
                
                <div class="purok-selector">
                    <label for="purok">Select Purok:</label>
                    <select id="purok" name="purok" onchange="loadResidents()">
                        <option value="">Choose a Purok...</option>
                        <?php foreach($puroks as $purok): ?>
                            <option value="<?php echo htmlspecialchars($purok); ?>"><?php echo htmlspecialchars($purok); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="residents-display" id="residentsDisplay" style="display: none;">
                    <h3 style="margin-bottom: 15px; color: #333; font-size: 16px;">Residents in Selected Purok</h3>
                    <div id="residentsList">
                        <!-- Residents will be loaded here via JavaScript -->
                    </div>
                </div>
                
                <form method="POST">
                    @csrf
                    <input type="hidden" name="purok" id="selectedPurok" value="">
                    
                    <div class="form-group">
                        <label for="message">Emergency Message:</label>
                        <textarea name="message" id="message" required placeholder="Type your emergency message here...">Advisory: Please prepare for a possible disaster. Ensure your emergency kits are ready (water, food, first aid, batteries). Be ready for possible evacuation anytime.</textarea>
                    </div>
                    
                    <div class="quick-actions">
                        <strong>Quick Alert Templates:</strong>
                        <button type="button" class="alert-btn" onclick="setEarlyEvacuationMessage()">🚨 EARLY EVACUATION ALERT</button>
                        <button type="button" class="alert-btn" onclick="setPurok1Message()">📍 PUROK 1</button>
                        <button type="button" class="alert-btn" onclick="setPurok2Message()">📍 PUROK 2</button>
                        <button type="button" class="alert-btn" onclick="setPurok3Message()">📍 PUROK 3</button>
                        <button type="button" class="alert-btn" onclick="setPurok4Message()">📍 PUROK 4</button>
                        <button type="button" class="alert-btn" onclick="setPurok5Message()">📍 PUROK 5</button>
                    </div>

                    <button type="submit" class="submit-btn">📡 SEND EMERGENCY SMS TO ALL RESIDENTS</button>
                </form>
            </div>
        </div>
        
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
            const submitBtn = document.querySelector('.submit-btn');
            
            const selectedPurok = purokSelect.value;
            
            // Update hidden field and button text
            selectedPurokHidden.value = selectedPurok;
            if (selectedPurok) {
                submitBtn.textContent = `📡 SEND EMERGENCY SMS TO ${selectedPurok.toUpperCase()}`;
            } else {
                submitBtn.textContent = '📡 SEND EMERGENCY SMS TO ALL RESIDENTS';
            }
            
            if (selectedPurok === '') {
                residentsDisplay.style.display = 'none';
                return;
            }
            
            // Show loading state
            residentsDisplay.style.display = 'block';
            residentsList.innerHTML = '<p style="text-align: center; color: #666;">Loading residents...</p>';
            
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
                            residentsList.innerHTML = '<p style="text-align: center; color: #dc2626;">Invalid response format</p>';
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        residentsList.innerHTML = '<p style="text-align: center; color: #dc2626;">Error parsing response</p>';
                    }
                } else {
                    residentsList.innerHTML = '<p style="text-align: center; color: #dc2626;">Error loading residents (Status: ' + xhr.status + ')</p>';
                }
            };
            
            xhr.onerror = function() {
                console.error('Network error occurred');
                residentsList.innerHTML = '<p style="text-align: center; color: #dc2626;">Network error</p>';
            };
            
            console.log('Requesting residents for purok:', selectedPurok);
            xhr.send();
        }
        
        function displayResidents(residents) {
            const residentsList = document.getElementById('residentsList');
            
            if (residents.length === 0) {
                residentsList.innerHTML = '<p style="text-align: center; color: #666;">No residents found in this purok</p>';
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