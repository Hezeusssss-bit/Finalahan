<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Evacuee;
use App\Models\Resident;

echo "=== Debugging Bien Marjon Pacione Status ===\n";

// Find Bien Marjon Pacione
$resident = Resident::where('name', 'like', '%Bien Marjon%')->first();

if ($resident) {
    echo "Resident: {$resident->name} (ID: {$resident->id})\n";
    echo "Purok: {$resident->description}\n";
    
    // Check all evacuee records for this resident
    $evacuees = Evacuee::where('resident_id', $resident->id)->get();
    
    echo "Evacuee records found: " . $evacuees->count() . "\n";
    
    foreach ($evacuees as $evacuee) {
        echo "  - ID: {$evacuee->id}\n";
        echo "  - Status: {$evacuee->evacuation_status}\n";
        echo "  - Area: {$evacuee->evacuation_area}\n";
        echo "  - Released At: " . ($evacuee->released_at ? $evacuee->released_at->format('Y-m-d H:i:s') : 'NULL') . "\n";
        echo "  - Evacuation Date: " . ($evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : 'NULL') . "\n";
        echo "  ---\n";
    }
    
    // Test the exact logic from getResidentsByPurok
    $latestEvacuee = \App\Models\Evacuee::where('resident_id', $resident->id)->first();
    $isEvacuated = $latestEvacuee && $latestEvacuee->evacuation_status !== 'Released' ? true : false;
    $evacuationStatus = $latestEvacuee ? $latestEvacuee->evacuation_status : null;
    
    echo "\nLogic Result:\n";
    echo "Latest evacuee status: {$evacuationStatus}\n";
    echo "Is evacuated (not released): " . ($isEvacuated ? 'YES' : 'NO') . "\n";
    echo "Should show 'Already Evacuated': " . ($isEvacuated ? 'YES' : 'NO') . "\n";
    
} else {
    echo "Resident not found\n";
}

echo "\n=== Debug Complete ===\n";
