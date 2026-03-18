<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Seeder;

// Include the OfficialsTableSeeder
$seeder = new \Database\Seeders\OfficialsTableSeeder();
$seeder->run();

echo "Officials data seeded successfully!\n";
