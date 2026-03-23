<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Evacuee;
use App\Models\Resident;

echo "=== Manually Releasing Christian Kyle ===\n";

// Find Christian Kyle Candido
$resident = Resident::where('name', 'like', '%Christian%')->first();

if ($resident) {
    echo "Found resident: {$resident->name} (ID: {$resident->id})\n";
    
    $evacuee = Evacuee::where('resident_id', $resident->id)->first();
    
    if ($evacuee) {
        echo "Current evacuee status: {$evacuee->evacuation_status}\n";
        
        // Update the evacuee to released status
        $evacuee->evacuation_status = 'Released';
        $evacuee->released_at = now();
        $evacuee->release_time = now()->format('H:i');
        $evacuee->notes = 'Test release for functionality';
        $evacuee->save();
        
        echo "Updated evacuee status to: Released\n";
        echo "Released at: " . $evacuee->released_at->format('Y-m-d H:i:s') . "\n";
        echo "Release time: " . $evacuee->release_time . "\n";
    } else {
        echo "No evacuee record found\n";
    }
} else {
    echo "Resident not found\n";
}

echo "\n=== Test Complete ===\n";
