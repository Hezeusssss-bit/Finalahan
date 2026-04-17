<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

echo "Puroks in database:\n";
$puroks = \App\Models\Resident::whereNotNull('description')
    ->where('description', '!=', '')
    ->distinct()
    ->pluck('description')
    ->sort()
    ->toArray();

foreach ($puroks as $purok) {
    echo $purok . "\n";
}

echo "\nTotal unique puroks: " . count($puroks);
?>
