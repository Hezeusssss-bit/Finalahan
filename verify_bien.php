<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Evacuee;
use App\Models\Resident;

echo "=== Verifying Bien Marjon Availability ===\n";

// Find Bien Marjon Pacione
$resident = Resident::where('name', 'like', '%Bien Marjon%')->first();

if ($resident) {
    echo "Resident: {$resident->name} (ID: {$resident->id})\n";
    
    // Test the exact logic from getResidentsByPurok
    $evacuee = \App\Models\Evacuee::where('resident_id', $resident->id)->first();
    $isEvacuated = $evacuee && $evacuee->evacuation_status !== 'Released' ? true : false;
    $evacuationStatus = $evacuee ? $evacuee->evacuation_status : null;
    
    echo "Current evacuee status: {$evacuationStatus}\n";
    echo "Is evacuated (not released): " . ($isEvacuated ? 'YES' : 'NO') . "\n";
    echo "Should show 'Already Evacuated': " . ($isEvacuated ? 'YES' : 'NO') . "\n";
    echo "Should show 'Available': " . ($isEvacuated ? 'NO' : 'YES') . "\n";
    
    if (!$isEvacuated) {
        echo "✅ SUCCESS: Bien Marjon will now appear as AVAILABLE!\n";
    } else {
        echo "❌ ISSUE: Bien Marjon still shows as evacuated\n";
    }
} else {
    echo "Resident not found\n";
}

echo "\n=== Verification Complete ===\n";
