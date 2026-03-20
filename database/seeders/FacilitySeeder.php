<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities = [
            [
                'name' => 'Central Philippines State University',
                'description' => 'Main evacuation center with multiple rooms and facilities',
                'icon' => 'fas fa-university',
                'status' => 'available',
                'capacity' => 150,
            ],
            [
                'name' => 'Hinigaran Elementary School - B',
                'description' => 'Elementary school building used as evacuation center',
                'icon' => 'fas fa-school',
                'status' => 'available',
                'capacity' => 75,
            ],
            [
                'name' => 'Hinigaran National High School',
                'description' => 'High school building with large classrooms for evacuation',
                'icon' => 'fas fa-graduation-cap',
                'status' => 'available',
                'capacity' => 100,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate(
                ['name' => $facility['name']],
                $facility
            );
        }
    }
}
