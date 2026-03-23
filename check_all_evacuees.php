<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Evacuee;
use App\Models\Resident;

echo "=== Checking All Evacuee Records ===\n";

// Show all evacuees in the system
$allEvacuees = Evacuee::with('resident')->get();

echo "Total evacuee records: " . $allEvacuees->count() . "\n\n";

foreach ($allEvacuees as $evacuee) {
    echo "Evacuee ID: {$evacuee->id}\n";
    echo "Resident: {$evacuee->resident->name}\n";
    echo "Status: {$evacuee->evacuation_status}\n";
    echo "Area: {$evacuee->evacuation_area}\n";
    echo "Date: " . ($evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : 'N/A') . "\n";
    echo "Released: " . ($evacuee->released_at ? 'YES' : 'NO') . "\n";
    echo "-------------------\n";
}

echo "\n=== Check Complete ===\n";
