<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use Carbon\Carbon;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing programs
        Program::query()->delete();
        
        // Create sample programs
        $programs = [
            [
                'title' => 'Clean-up Drive',
                'description' => 'Barangay-wide clean-up activity focusing on streets and waterways to maintain cleanliness and environmental health.',
                'location' => 'Purok V',
                'start_date' => Carbon::today()->addDays(7), // Next week
                'end_date' => Carbon::today()->addDays(8),
                'status' => 'upcoming'
            ],
            [
                'title' => 'Medical Mission',
                'description' => 'Basic health check-ups and free medicines provided to residents, focusing on preventive healthcare.',
                'location' => 'Purok II',
                'start_date' => Carbon::today()->subDays(30), // Last month
                'end_date' => Carbon::today()->subDays(29),
                'status' => 'completed'
            ],
            [
                'title' => 'Youth Sports League',
                'description' => 'Weekly sports activities for youth development and physical fitness, promoting healthy lifestyle.',
                'location' => 'Purok III',
                'start_date' => Carbon::today()->subDays(7), // Started last week
                'end_date' => Carbon::today()->addDays(23), // Ends next month
                'status' => 'ongoing'
            ],
            [
                'title' => 'Disaster Preparedness Training',
                'description' => 'Training sessions on emergency response, first aid, and disaster preparedness for all residents.',
                'location' => 'Community Center',
                'start_date' => Carbon::today()->addDays(14), // In 2 weeks
                'end_date' => Carbon::today()->addDays(15),
                'status' => 'upcoming'
            ],
            [
                'title' => 'Senior Citizens Outreach',
                'description' => 'Regular visits and assistance programs for elderly residents, including health monitoring and social activities.',
                'location' => 'Purok I',
                'start_date' => Carbon::today()->subDays(3), // Started 3 days ago
                'end_date' => null, // Ongoing
                'status' => 'ongoing'
            ]
        ];
        
        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
