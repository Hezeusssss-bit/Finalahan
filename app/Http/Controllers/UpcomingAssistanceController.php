<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Evacuee;
use Illuminate\Http\Request;

class UpcomingAssistanceController extends Controller
{
    public function index()
    {
        // Get total residents
        $totalResidents = Resident::count();
        
        // Get total evacuees
        $totalEvacuees = Evacuee::count();
        
        // Get all residents for analytics
        $residents = Resident::all();
        
        // Get assistance requirements using the same logic as ProductController
        $assistanceRequirements = $this->calculateDashboardAssistanceRequirements(
            \App\Models\Program::where('status', 'upcoming')->orderBy('start_date', 'asc')->get()
        );
        
        return view('UpcomingAssistanceRequirements', compact(
            'totalResidents',
            'totalEvacuees', 
            'residents',
            'assistanceRequirements'
        ));
    }
    
    /**
     * Calculate assistance requirements for dashboard display (same as ProductController)
     */
    private function calculateDashboardAssistanceRequirements($programs)
    {
        $requirements = [];
        
        // Get evacuee data for DSS calculations (same logic as program.blade.php)
        $evacueesData = \App\Models\Evacuee::with('resident')
            ->where('evacuation_status', '!=', 'Released')
            ->get();
        
        $evacuees = collect();
        
        foreach ($evacueesData as $evacuee) {
            $resident = $evacuee->resident;
            
            if ($resident) {
                $evacuees->push([
                    'id' => $evacuee->id,
                    'family_head_name' => $resident->family_head_fullname ?? 'Unknown',
                    'gender' => $resident->gender ?? 'Male',
                    'age' => $resident->family_head_age ?? 0,
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : null,
                    'total_members' => $this->calculateTotalFamilyMembers($resident),
                    'dependent_count' => $this->calculateTotalFamilyMembers($resident) - 1,
                    'contact_number' => $resident->contact_number ?? '',
                    'purok' => $resident->description ?? '',
                    'has_pregnant' => $resident->wife_pregnant ?? false,
                    'has_pwd' => $this->hasPWDInFamily($resident)
                ]);
            }
        }
        
        foreach ($programs as $program) {
            if (!$program->location) continue;
            
            $purok = $program->location;
            $programType = strtolower($program->title);
            
            // Check if this is an Evacuee Program for DSS calculations
            if ($program->title === 'Evacuee Program') {
                // Get evacuee data for this evacuation area (same logic as program.blade.php)
                $areaEvacuees = $evacuees->filter(function($e) use ($program) {
                    $evacuationArea = is_array($e) ? ($e['evacuation_area'] ?? null) : ($e->evacuation_area ?? null);
                    return $evacuationArea === $program->location;
                });
                
                // Calculate DSS metrics (same as program.blade.php)
                $totalEvacuees = $areaEvacuees->count();
                $seniorCount = $areaEvacuees->filter(function($e) { 
                    $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                    return $age >= 60; 
                })->count();
                $infantCount = $areaEvacuees->filter(function($e) { 
                    $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                    return $age <= 5; 
                })->count();
                $pregnantCount = $areaEvacuees->filter(function($e) { 
                    $hasPregnant = is_array($e) ? ($e['has_pregnant'] ?? false) : ($e->has_pregnant ?? false);
                    return $hasPregnant; 
                })->count();
                $pwdCount = $areaEvacuees->filter(function($e) { 
                    $hasPwd = is_array($e) ? ($e['has_pwd'] ?? false) : ($e->has_pwd ?? false);
                    return $hasPwd; 
                })->count();
                
                // Calculate exact DSS needs (enhanced calculations)
                $totalFamilyMembers = $areaEvacuees->sum(function($e) { 
                    return is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1); 
                });
                
                // Detailed meal calculations by age group
                $dailyMeals = $areaEvacuees->sum(function($e) {
                    $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                    $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                    
                    $mealsPerPerson = 3;
                    if ($age <= 2) $mealsPerPerson = 6;  // Infants: 6 small meals
                    else if ($age <= 5) $mealsPerPerson = 5;  // Toddlers: 3 meals + 2 snacks
                    else if ($age <= 12) $mealsPerPerson = 4;  // Children: 3 meals + 1 snack
                    else if ($age <= 17) $mealsPerPerson = 3;  // Teens: 3 meals
                    else if ($age >= 60) $mealsPerPerson = 4;  // Seniors: 3 meals + 1 snack
                    return $mealsPerPerson * $totalMembers;
                });
                
                // Water needs (4L per person, plus extra for vulnerable groups)
                $waterNeeded = $areaEvacuees->sum(function($e) { 
                    $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                    $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                    $baseWater = $totalMembers * 4;
                    
                    // Extra water for infants, seniors, and pregnant women
                    if ($age <= 5) $baseWater += 2;  // Infants/toddlers need extra water
                    if ($age >= 60) $baseWater += 1;  // Seniors need extra water
                    
                    return $baseWater; 
                });
                
                // Detailed supply calculations
                $hygieneKits = max(1, ceil($totalFamilyMembers * 0.8));
                $blankets = max(2, ceil($totalFamilyMembers * 0.7));
                $firstAidKits = max(1, ceil($totalFamilyMembers / 8)); // 1 per 8 people
                
                // Additional specific needs
                $babyFormula = $areaEvacuees->sum(function($e) {
                    $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                    $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                    return ($age <= 2) ? $totalMembers * 3 : 0; // 3 cans per infant per day
                });
                
                $diapers = $areaEvacuees->sum(function($e) {
                    $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                    $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                    return ($age <= 2) ? $totalMembers * 8 : 0; // 8 diapers per infant per day
                });
                
                $adultDiapers = $seniorCount * 2; // 2 per senior per day
                
                $medicineKits = max(1, ceil(($seniorCount + $pwdCount) * 1.5));
                $wheelchairs = max(1, ceil($pwdCount * 0.4));
                $walkingCanes = max(1, ceil($seniorCount * 0.6));
                
                // Food supplies (3-day stock)
                $riceKilos = $totalFamilyMembers * 2; // 2kg per person for 3 days
                $cannedGoods = $totalFamilyMembers * 6; // 6 cans per person for 3 days
                $instantNoodles = $totalFamilyMembers * 9; // 9 packs per person for 3 days
                
                // Clothing needs by age group
                $clothingNeeds = [
                    'adult_clothes' => 0,
                    'children_clothes' => 0,
                    'infant_clothes' => 0,
                    'senior_clothes' => 0
                ];
                
                foreach ($areaEvacuees as $e) {
                    $age = is_array($e) ? ($e['age'] ?? 0) : ($e->age ?? 0);
                    $totalMembers = is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
                    
                    if ($age <= 2) {
                        $clothingNeeds['infant_clothes'] += $totalMembers * 3; // 3 sets per infant
                    } elseif ($age <= 12) {
                        $clothingNeeds['children_clothes'] += $totalMembers * 2; // 2 sets per child
                    } elseif ($age >= 60) {
                        $clothingNeeds['senior_clothes'] += $totalMembers * 2; // 2 sets per senior
                    } else {
                        $clothingNeeds['adult_clothes'] += $totalMembers * 2; // 2 sets per adult
                    }
                }
                
                // Sanitation supplies
                $toiletPaper = max(1, ceil($totalFamilyMembers * 2)); // 2 rolls per person
                $soapBars = max(1, ceil($totalFamilyMembers * 1.5)); // 1.5 bars per person
                $sanitizer = max(1, ceil($totalFamilyMembers)); // 1 bottle per person
                
                // Shelter supplies
                $sleepingMats = $totalFamilyMembers; // 1 per person
                $tarpaulins = max(2, ceil($totalFamilyMembers / 4)); // 1 per 4 people
                $rope = max(1, ceil($totalFamilyMembers / 10)); // 1 per 10 people
                
                $programRequirements = [
                    'purok' => $purok,
                    'program_title' => $program->title,
                    'start_date' => $program->start_date->format('M d, Y'),
                    'total_residents' => $totalEvacuees, // Use actual evacuee count
                    'pwd_count' => $pwdCount,
                    'senior_count' => $seniorCount,
                    'pregnant_count' => $pregnantCount,
                    'dss_metrics' => [
                        'daily_meals' => $dailyMeals,
                        'water_needed' => $waterNeeded,
                        'hygiene_kits' => $hygieneKits,
                        'blankets' => $blankets,
                        'first_aid_kits' => $firstAidKits,
                        'infant_count' => $infantCount,
                        'baby_formula' => $babyFormula,
                        'diapers' => $diapers,
                        'adult_diapers' => $adultDiapers,
                        'medicine_kits' => $medicineKits,
                        'wheelchairs' => $wheelchairs,
                        'walking_canes' => $walkingCanes,
                        'rice_kilos' => $riceKilos,
                        'canned_goods' => $cannedGoods,
                        'instant_noodles' => $instantNoodles,
                        'clothing_needs' => $clothingNeeds,
                        'toilet_paper' => $toiletPaper,
                        'soap_bars' => $soapBars,
                        'sanitizer' => $sanitizer,
                        'sleeping_mats' => $sleepingMats,
                        'tarpaulins' => $tarpaulins,
                        'rope' => $rope
                    ]
                ];
            } else {
                // Handle regular programs with existing logic
                $residents = Resident::where('description', $purok)->get();
                $totalResidentsInPurok = $residents->count();
                
                $seniorCount = $residents->filter(function($r) {
                    return ($r->family_head_age >= 60) || 
                           ($r->wife_age >= 60) || 
                           ($r->grandmother_age >= 60) || 
                           ($r->grandfather_age >= 60);
                })->count();
                
                $pregnantCount = $residents->where('wife_pregnant', true)->count();
                
                $pwdCount = $residents->filter(function($r) {
                    return $r->family_head_pwd || $r->wife_pwd || $r->son_pwd || 
                           $r->daughter_pwd || $r->grandmother_pwd || $r->grandfather_pwd;
                })->count();
                
                // Calculate basic needs for regular programs
                $dailyMeals = $totalResidentsInPurok * 3;
                $waterNeeded = $totalResidentsInPurok * 4;
                $hygieneKits = max(1, ceil($totalResidentsInPurok * 0.8));
                $blankets = max(1, ceil($totalResidentsInPurok * 0.7));
                $firstAidKits = max(1, ceil($totalResidentsInPurok / 10));
                
                $programRequirements = [
                    'purok' => $purok,
                    'program_title' => $program->title,
                    'start_date' => $program->start_date->format('M d, Y'),
                    'total_residents' => $totalResidentsInPurok,
                    'pwd_count' => $pwdCount,
                    'senior_count' => $seniorCount,
                    'pregnant_count' => $pregnantCount,
                    'specific_needs' => [
                        'daily_meals' => $dailyMeals,
                        'water_needed' => $waterNeeded,
                        'hygiene_kits' => $hygieneKits,
                        'blankets' => $blankets,
                        'first_aid_kits' => $firstAidKits,
                        'medicine_kits_needed' => max(1, ceil(($seniorCount + $pwdCount) * 0.8)),
                        'food_packages_needed' => $totalResidentsInPurok,
                        'rice_kilos_needed' => $totalResidentsInPurok * 2,
                        'canned_goods_needed' => $totalResidentsInPurok * 3,
                        'wheelchairs_needed' => max(1, ceil($pwdCount * 0.3)),
                        'walking_aids_needed' => max(1, ceil($seniorCount * 0.4))
                    ]
                ];
            }
            
            $requirements[] = $programRequirements;
        }
        
        return $requirements;
    }
    
    /**
     * Calculate total family members for a resident
     */
    private function calculateTotalFamilyMembers($resident)
    {
        $count = 1; // Family head
        
        if ($resident->wife_fullname) $count++;
        if ($resident->son_fullname) $count++;
        if ($resident->daughter_fullname) $count++;
        if ($resident->grandmother_fullname) $count++;
        if ($resident->grandfather_fullname) $count++;
        
        return $count;
    }
    
    /**
     * Check if family has any PWD members
     */
    private function hasPWDInFamily($resident)
    {
        return $resident->family_head_pwd || 
               $resident->wife_pwd || 
               $resident->son_pwd || 
               $resident->daughter_pwd || 
               $resident->grandmother_pwd || 
               $resident->grandfather_pwd;
    }
}
