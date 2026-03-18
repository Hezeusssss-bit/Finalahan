<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

try {
    $tables = DB::select('SHOW TABLES');
    echo "Database Tables:\n";
    echo "================\n";
    
    foreach ($tables as $table) {
        $tableName = $table->Tables_in_mswd;
        if (strpos($tableName, 'official') !== false || strpos($tableName, 'kagawad') !== false) {
            echo "- {$tableName}\n";
        }
    }
    echo "================\n";
    
    // Check if officials table exists
    $officialsTable = DB::select('SHOW TABLES LIKE "%official%"');
    echo "\nOfficials-related tables:\n";
    foreach ($officialsTable as $table) {
        echo "- " . $table->Tables_in_mswd . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
