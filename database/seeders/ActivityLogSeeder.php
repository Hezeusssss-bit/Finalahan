<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing activity logs
        ActivityLog::query()->delete();
        
        // Get some sample programs to create activity logs for
        $programs = Program::all();
        
        if ($programs->isEmpty()) {
            // Create some sample programs first
            $this->createSamplePrograms();
            $programs = Program::all();
        }
        
        // Create sample activity logs
        $activities = [
            [
                'action' => 'Program Completed',
                'description' => 'Medical Mission program was completed successfully',
                'module' => 'Programs',
                'performed_by' => 'Admin',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'action' => 'Program Created',
                'description' => 'Clean-up Drive program was created',
                'module' => 'Programs',
                'performed_by' => 'Admin',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'action' => 'Program Updated',
                'description' => 'Youth Sports League schedule was updated',
                'module' => 'Programs',
                'performed_by' => 'Admin',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'action' => 'Program Deleted',
                'description' => 'Old training program was removed',
                'module' => 'Programs',
                'performed_by' => 'Admin',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'action' => 'System Maintenance',
                'description' => 'Database backup completed successfully',
                'module' => 'System',
                'performed_by' => 'System',
                'created_at' => Carbon::now()->subHours(6),
            ],
            [
                'action' => 'Employee Added',
                'description' => 'New employee John Doe was added to the system',
                'module' => 'Employee',
                'performed_by' => 'Admin',
                'created_at' => Carbon::now()->subHours(12),
            ],
        ];
        
        foreach ($activities as $activity) {
            ActivityLog::create($activity);
        }
    }
    
    /**
     * Create sample programs for activity logs
     */
    private function createSamplePrograms()
    {
        $samplePrograms = [
            [
                'title' => 'Medical Mission',
                'description' => 'Free medical check-up and medicine distribution',
                'location' => 'Purok II',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(2),
                'status' => 'completed',
            ],
            [
                'title' => 'Clean-up Drive',
                'description' => 'Community cleanliness campaign',
                'location' => 'Purok V',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->subDays(4),
                'status' => 'completed',
            ],
            [
                'title' => 'Youth Sports League',
                'description' => 'Basketball tournament for youth development',
                'location' => 'Purok III',
                'start_date' => Carbon::now()->subDays(3),
                'end_date' => Carbon::now()->addDays(7),
                'status' => 'ongoing',
            ],
        ];
        
        foreach ($samplePrograms as $program) {
            Program::create($program);
        }
    }
}
