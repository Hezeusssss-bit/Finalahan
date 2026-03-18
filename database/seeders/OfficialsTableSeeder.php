<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data
        DB::table('officials')->delete();
        DB::table('kagawads')->delete();
        
        // Insert sample officials
        DB::table('officials')->insert([
            [
                'first_name' => 'Juan',
                'middle_name' => null,
                'last_name' => 'Dela Cruz',
                'position' => 'Barangay Captain',
                'purok' => 'Purok 1',
                'contact_number' => '09123456789',
                'email' => 'juan.delacruz@barangay.gov.ph',
                'term_start' => '2023-01-01',
                'term_end' => '2026-12-31',
                'is_active' => true,
                'notes' => null,
                'photo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Maria',
                'middle_name' => null,
                'last_name' => 'Santos',
                'position' => 'Barangay Secretary',
                'purok' => 'Purok 2',
                'contact_number' => '09123456790',
                'email' => 'maria.santos@barangay.gov.ph',
                'term_start' => '2024-01-01',
                'term_end' => '2027-12-31',
                'is_active' => true,
                'notes' => null,
                'photo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Roberto',
                'middle_name' => null,
                'last_name' => 'Reyes',
                'position' => 'Barangay Treasurer',
                'purok' => 'Purok 3',
                'contact_number' => '09123456788',
                'email' => 'roberto.reyes@barangay.gov.ph',
                'term_start' => '2023-06-01',
                'term_end' => '2026-06-30',
                'is_active' => true,
                'notes' => null,
                'photo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
        // Insert sample kagawads
        DB::table('kagawads')->insert([
            [
                'name' => 'Antonio Cruz',
                'position' => 'Kagawad Member',
                'contact_number' => '09123456791',
                'email' => 'antonio.cruz@barangay.gov.ph',
                'address' => '321 Mango St, Purok 1',
                'term_start' => '2023-01-01',
                'term_end' => '2025-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Elena Garcia',
                'position' => 'Kagawad Member',
                'contact_number' => '09123456792',
                'email' => 'elena.garcia@barangay.gov.ph',
                'address' => '654 Coconut St, Purok 2',
                'term_start' => '2024-01-01',
                'term_end' => '2026-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Felipe Reyes',
                'position' => 'Kagawad Member',
                'contact_number' => '09123456793',
                'email' => 'felipe.reyes@barangay.gov.ph',
                'address' => '987 Banana St, Purok 3',
                'term_start' => '2023-06-01',
                'term_end' => '2026-06-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Carmela Santos',
                'position' => 'Kagawad Secretary',
                'contact_number' => '09123456794',
                'email' => 'carmela.santos@barangay.gov.ph',
                'address' => '147 Papaya St, Purok 1',
                'term_start' => '2024-01-01',
                'term_end' => '2027-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
