<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Evacuee;
use App\Models\Resident;

echo "=== Checking Evacuee Status ===\n";

// Find Christian Kyle Candido (assuming ID 1, adjust as needed)
$resident = Resident::where('name', 'like', '%Christian%')->first();

if ($resident) {
    echo "Found resident: {$resident->name} (ID: {$resident->id})\n";
    
    $evacuee = Evacuee::where('resident_id', $resident->id)->first();
    
    if ($evacuee) {
        echo "Evacuee record found:\n";
        echo "  - ID: {$evacuee->id}\n";
        echo "  - Status: {$evacuee->evacuation_status}\n";
        echo "  - Released At: " . ($evacuee->released_at ? $evacuee->released_at->format('Y-m-d H:i:s') : 'NULL') . "\n";
        echo "  - Is Evacuated (not released): " . (($evacuee->evacuation_status !== 'Released') ? 'YES' : 'NO') . "\n";
    } else {
        echo "No evacuee record found\n";
    }
} else {
    echo "Resident not found\n";
}

echo "\n=== Test Complete ===\n";
