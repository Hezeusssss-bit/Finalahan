<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== DATABASE CONNECTION CHECK ===\n";
    echo "Database: " . DB::connection()->getDatabaseName() . "\n\n";
    
    echo "=== ALL TABLES AND RECORD COUNTS ===\n";
    $tables = ['activity_logs', 'employees', 'evacuees', 'kagawads', 'migrations', 'officials', 'password_resets', 'personal_access_tokens', 'programs', 'residents', 'users'];
    
    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "$table: $count records\n";
            
            if ($count > 0 && in_array($table, ['officials', 'kagawads', 'programs', 'residents', 'employees'])) {
                $sample = DB::table($table)->limit(2)->get();
                echo "  Sample records:\n";
                foreach ($sample as $record) {
                    echo "  - ";
                    if (isset($record->first_name) && isset($record->last_name)) {
                        echo "{$record->first_name} {$record->last_name}";
                    } elseif (isset($record->name)) {
                        echo $record->name;
                    } elseif (isset($record->title)) {
                        echo $record->title;
                    } else {
                        echo "ID: {$record->id}";
                    }
                    echo "\n";
                }
            }
        } catch (Exception $e) {
            echo "$table: Error - " . $e->getMessage() . "\n";
        }
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
