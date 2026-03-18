<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeAssignment;

echo "=== DEBUGGING DASHBOARD ISSUE ===\n";

try {
    // Check current authenticated user simulation
    echo "1. Checking users table:\n";
    $users = User::all();
    foreach ($users as $user) {
        echo "   User ID: {$user->id}, Name: {$user->name}, Email: {$user->email}\n";
    }
    
    echo "\n2. Checking employees table:\n";
    $employees = Employee::all();
    foreach ($employees as $employee) {
        echo "   Employee ID: {$employee->id}, Name: {$employee->name}, Email: {$employee->email}\n";
    }
    
    echo "\n3. Checking assignments table:\n";
    $assignments = EmployeeAssignment::all();
    foreach ($assignments as $assignment) {
        echo "   Assignment ID: {$assignment->id}, Employee ID: {$assignment->employee_id}, Center: {$assignment->evacuation_center}\n";
    }
    
    echo "\n4. Testing dashboard logic for each user:\n";
    foreach ($users as $user) {
        echo "\n   For user: {$user->email}\n";
        
        // This is the exact logic from the controller
        $employeeAssignments = collect([]);
        $employee = Employee::where('email', $user->email)->first();
        
        if ($employee) {
            echo "   Found employee: {$employee->name} (ID: {$employee->id})\n";
            $employeeAssignments = EmployeeAssignment::where('employee_id', $employee->id)
                ->orderBy('created_at', 'desc')
                ->get();
            echo "   Assignments count: " . $employeeAssignments->count() . "\n";
        } else {
            echo "   No employee found for this user!\n";
        }
        
        // Check what would be displayed
        if ($employeeAssignments->count() > 0) {
            echo "   SHOULD SHOW ASSIGNMENTS\n";
        } else {
            echo "   WOULD SHOW 'NO ASSIGNMENTS YET'\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
