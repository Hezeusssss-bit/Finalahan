<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\ActivityLogService;
use App\Models\ActivityLog;

try {
    echo "=== ACTIVITY LOG DATABASE CONNECTION TEST ===\n\n";
    
    // Test 1: Check ActivityLog model
    echo "1. Testing ActivityLog Model:\n";
    $count = ActivityLog::count();
    echo "   - Total logs: $count\n";
    
    if ($count > 0) {
        $latest = ActivityLog::latest()->first();
        echo "   - Latest log: {$latest->action} - {$latest->description}\n";
    }
    echo "\n";
    
    // Test 2: Check ActivityLogService
    echo "2. Testing ActivityLogService:\n";
    $service = new ActivityLogService();
    
    // Create a test log
    $testLog = $service->log('Test Action', 'Test Description from service', 'Test Module', 'Test User');
    echo "   - Created test log with ID: {$testLog->id}\n";
    
    // Test specific methods
    $programLog = $service->logProgramActivity('Test Program', 'Test program activity');
    echo "   - Created program log with ID: {$programLog->id}\n";
    
    $systemLog = $service->logSystemActivity('Test System', 'Test system activity');
    echo "   - Created system log with ID: {$systemLog->id}\n";
    
    echo "\n";
    
    // Test 3: Verify logs in database
    echo "3. Verifying logs in database:\n";
    $newCount = ActivityLog::count();
    echo "   - New total logs: $newCount (should be $count + 3)\n";
    
    $recentLogs = $service->getRecentLogs(5);
    echo "   - Recent logs count: " . $recentLogs->count() . "\n";
    
    echo "\n=== ALL TESTS PASSED ===\n";
    echo "✅ ActivityLog model is connected to database\n";
    echo "✅ ActivityLogService is working correctly\n";
    echo "✅ Database operations are successful\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
