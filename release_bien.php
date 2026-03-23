<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Evacuee;
use App\Models\Resident;

echo "=== Releasing Bien Marjon Pacione ===\n";

// Find Bien Marjon Pacione
$resident = Resident::where('name', 'like', '%Bien Marjon%')->first();

if ($resident) {
    echo "Resident: {$resident->name} (ID: {$resident->id})\n";
    
    $evacuee = Evacuee::where('resident_id', $resident->id)->first();
    
    if ($evacuee) {
        echo "Current evacuee status: {$evacuee->evacuation_status}\n";
        echo "Current area: {$evacuee->evacuation_area}\n";
        echo "Evacuation date: {$evacuee->evacuation_date->format('Y-m-d')}\n";
        
        // Update to released status
        $evacuee->evacuation_status = 'Released';
        $evacuee->released_at = now();
        $evacuee->release_time = now()->format('H:i');
        $evacuee->notes = 'Released from evacuation - no longer in area';
        $evacuee->save();
        
        echo "✅ Updated to: Released\n";
        echo "✅ Released at: " . $evacuee->released_at->format('Y-m-d H:i:s') . "\n";
        echo "✅ Release time: " . $evacuee->release_time . "\n";
        echo "\nNow Bien Marjon should appear as AVAILABLE in Add Evacuee modal!\n";
    } else {
        echo "No evacuee record found\n";
    }
} else {
    echo "Resident not found\n";
}

echo "\n=== Release Complete ===\n";
