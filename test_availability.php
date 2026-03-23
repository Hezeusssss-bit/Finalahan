<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Evacuee;
use App\Models\Resident;

echo "=== Testing getResidentsByPurok Logic ===\n";

// Test the logic from getResidentsByPurok method
$resident = Resident::where('name', 'like', '%Christian%')->first();

if ($resident) {
    echo "Resident: {$resident->name} (ID: {$resident->id})\n";
    
    // This is the exact logic from getResidentsByPurok
    $evacuee = \App\Models\Evacuee::where('resident_id', $resident->id)->first();
    $isEvacuated = $evacuee && $evacuee->evacuation_status !== 'Released' ? true : false;
    $evacuationStatus = $evacuee ? $evacuee->evacuation_status : null;
    
    echo "Evacuee Status: {$evacuationStatus}\n";
    echo "Is Evacuated (not released): " . ($isEvacuated ? 'YES' : 'NO') . "\n";
    echo "Should be available for re-evacuation: " . ($isEvacuated ? 'NO' : 'YES') . "\n";
    
    if (!$isEvacuated) {
        echo "✅ SUCCESS: Christian Kyle should now appear as AVAILABLE in the Add Evacuee modal!\n";
    } else {
        echo "❌ ISSUE: Christian Kyle is still marked as evacuated\n";
    }
} else {
    echo "Resident not found\n";
}

echo "\n=== Test Complete ===\n";
