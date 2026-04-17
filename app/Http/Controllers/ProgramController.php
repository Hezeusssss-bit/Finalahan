<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Resident;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    protected $activityLogService;
    
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }
    /**
     * Display the program management page
     */
    public function index()
    {
        // Update all program statuses first to ensure they're current
        $programs = Program::all();
        foreach ($programs as $program) {
            $program->updateStatusAutomatically();
            $program->save();
        }
        
        // Get programs by status
        $upcomingPrograms = Program::upcoming()->orderBy('start_date', 'asc')->get();
        $ongoingPrograms = Program::ongoing()->orderBy('start_date', 'asc')->get();
        $completedPrograms = Program::completed()->orderBy('end_date', 'desc')->get();
        
        // Calculate assistance requirements for upcoming and ongoing programs
        $upcomingRequirements = $this->calculateAssistanceRequirements($upcomingPrograms);
        $ongoingRequirements = $this->calculateAssistanceRequirements($ongoingPrograms);
        
        // Combine all assistance requirements for the Assistance Requirements Details section
        $allAssistanceRequirements = array_merge(
            $upcomingRequirements,
            $ongoingRequirements
        );
        
        // Get facilities for evacuee program selection
        $facilities = \App\Models\Facility::select('id', 'name', 'capacity', 'status')
            ->where('status', 'available')
            ->orderBy('name')
            ->get();
        
        // Get evacuee data for DSS analytics (same logic as EvacueeProgram)
        $evacueesData = \App\Models\Evacuee::with('resident')
            ->where('evacuation_status', '!=', 'Released')
            ->get();
        
        $evacuees = collect();
        
        foreach ($evacueesData as $evacuee) {
            $resident = $evacuee->resident;
            
            if ($resident) {
                // Create evacuee record for family head
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
        
        // Calculate vulnerable groups data (same as home.blade.php)
        $residents = \App\Models\Resident::all();
        $totalPregnant = 0;
        $totalPWD = 0;
        $totalSeniors = 0;
        $totalChildren = 0;
        
        foreach($residents as $resident) {
            // Count pregnant women
            if ($resident->wife_pregnant && $resident->wife_fullname) {
                $totalPregnant++;
            }
            
            // Count PWD
            if ($resident->family_head_pwd || $resident->wife_pwd || $resident->son_pwd || 
                $resident->daughter_pwd || $resident->grandmother_pwd || $resident->grandfather_pwd ||
                $resident->pwd_in_family === 'Yes') {
                $totalPWD++;
            }
            
            // Count seniors (60+)
            if ($resident->family_head_age >= 60 && $resident->family_head_fullname) $totalSeniors++;
            if ($resident->wife_age >= 60 && $resident->wife_fullname) $totalSeniors++;
            if ($resident->grandmother_age >= 60 && $resident->grandmother_fullname) $totalSeniors++;
            if ($resident->grandfather_age >= 60 && $resident->grandfather_fullname) $totalSeniors++;
            
            // Count children (<18)
            if ($resident->family_head_age < 18 && $resident->family_head_fullname) $totalChildren++;
            if ($resident->wife_age < 18 && $resident->wife_fullname) $totalChildren++;
            if ($resident->son_age < 18 && $resident->son_fullname) $totalChildren++;
            if ($resident->daughter_age < 18 && $resident->daughter_fullname) $totalChildren++;
        }
        
        $vulnerableGroups = [
            'pregnant_count' => $totalPregnant,
            'pwd_count' => $totalPWD,
            'senior_count' => $totalSeniors,
            'children_count' => $totalChildren,
            'total_vulnerable' => $totalPregnant + $totalPWD + $totalSeniors + $totalChildren
        ];
        
        // Get all unique puroks from residents
        $databasePuroks = \App\Models\Resident::whereNotNull('description')
            ->where('description', '!=', '')
            ->distinct()
            ->pluck('description')
            ->sort()
            ->values();
        
        // Standard puroks that should always be available
        $standardPuroks = collect(['Purok I', 'Purok II', 'Purok III', 'Purok IV', 'Purok V']);
        
        // Merge database puroks with standard puroks, remove duplicates, and sort
        $allPuroks = $databasePuroks->merge($standardPuroks)
            ->unique()
            ->sort()
            ->values();
        
        return view('Program.program', compact('upcomingPrograms', 'ongoingPrograms', 'completedPrograms', 'upcomingRequirements', 'ongoingRequirements', 'facilities', 'evacuees', 'allAssistanceRequirements', 'vulnerableGroups', 'allPuroks'));
    }
    
    /**
     * Store a new program
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);
        
        // Status will be automatically set by the model
        $program = Program::create($validated);
        
        // Log program creation
        $this->logActivity(
            'Program Created',
            "New program '{$validated['title']}' created" . ($validated['location'] ? " at {$validated['location']}" : ""),
            'Programs'
        );
        
        return redirect()->route('program.index')->with('Success', 'Program added successfully!');
    }
    
    /**
     * Update a program
     */
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);
        
        $program->update($validated);
        
        // Log program update
        $this->logActivity(
            'Program Updated',
            "Program '{$validated['title']}' updated" . ($validated['location'] ? " - Location: {$validated['location']}" : ""),
            'Programs'
        );
        
        return redirect()->route('program.index')->with('Success', 'Program updated successfully!');
    }
    
    /**
     * Delete a program
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        
        // Log program deletion
        $this->logActivity(
            'Program Deleted',
            "Program '{$program->title}' deleted",
            'Programs'
        );
        
        $program->delete();
        
        return redirect()->route('program.index')->with('Success', 'Program deleted successfully!');
    }
    
    /**
     * Get program data for AJAX requests
     */
    public function getProgram($id)
    {
        $program = Program::findOrFail($id);
        return response()->json($program);
    }
    
    /**
     * Update all program statuses (can be called via cron job or scheduled task)
     */
    public function updateAllStatuses()
    {
        $programs = Program::all();
        
        foreach ($programs as $program) {
            $program->updateStatusAutomatically();
            $program->save();
        }
        
        return response()->json(['message' => 'All program statuses updated successfully']);
    }
    
    /**
     * Calculate assistance requirements by purok for different program types
     */
    private function calculateAssistanceRequirements($programs)
    {
        $requirements = [];
        
        foreach ($programs as $program) {
            if (!$program->location) continue;
            
            $purok = $program->location;
            $programType = strtolower($program->title);
            
            // Get all residents in this purok
            $residents = Resident::where('description', $purok)->get();
            
            $pwdCount = 0;
            $seniorCount = 0;
            $pregnantCount = 0;
            $totalResidents = $residents->count();
            
            foreach ($residents as $resident) {
                // Count PWD (Persons with Disabilities)
                if ($resident->family_head_pwd || $resident->wife_pwd || $resident->son_pwd || 
                    $resident->daughter_pwd || $resident->grandmother_pwd || $resident->grandfather_pwd ||
                    $resident->pwd_in_family === 'Yes') {
                    $pwdCount++;
                }
                
                // Count Senior Citizens (60 years and above)
                if ($resident->family_head_age >= 60) $seniorCount++;
                if ($resident->wife_age >= 60) $seniorCount++;
                if ($resident->grandmother_age >= 60) $seniorCount++;
                if ($resident->grandfather_age >= 60) $seniorCount++;
                
                // Count Pregnant Women
                if ($resident->wife_pregnant) $pregnantCount++;
            }
            
            // Calculate specific requirements based on program type
            $programRequirements = [
                'purok' => $purok,
                'program_title' => $program->title,
                'total_residents' => $totalResidents,
                'pwd_count' => $pwdCount,
                'senior_count' => $seniorCount,
                'pregnant_count' => $pregnantCount,
            ];
            
            // Specific assistance needs based on program type
            if (strpos($programType, 'pwd') !== false || strpos($programType, 'assistance') !== false) {
                $programRequirements['assistance_type'] = 'PWD Assistance';
                $programRequirements['specific_needs'] = [
                    'wheelchairs_needed' => max(1, floor($pwdCount * 0.3)),
                    'walking_aids_needed' => max(1, floor($pwdCount * 0.5)),
                    'medical_supplies_needed' => $pwdCount * 2, // 2 supplies per PWD
                    'transportation_assistance' => $pwdCount
                ];
            }
            
            if (strpos($programType, 'senior') !== false || strpos($programType, 'outreach') !== false) {
                $programRequirements['assistance_type'] = 'Senior Citizen Outreach';
                $programRequirements['specific_needs'] = [
                    'medicine_kits_needed' => $seniorCount,
                    'blood_pressure_monitors' => max(1, floor($seniorCount * 0.2)),
                    'reading_glasses_needed' => max(1, floor($seniorCount * 0.4)),
                    'mobility_aids_needed' => max(1, floor($seniorCount * 0.3))
                ];
            }
            
            if (strpos($programType, 'medical') !== false || strpos($programType, 'health') !== false) {
                $programRequirements['assistance_type'] = 'Medical Mission';
                $programRequirements['specific_needs'] = [
                    'basic_medicine_kits' => $totalResidents,
                    'vitamin_supplements' => $totalResidents,
                    'first_aid_kits' => max(1, floor($totalResidents * 0.3)),
                    'medical_consultations' => $totalResidents
                ];
            }
            
            if (strpos($programType, 'food') !== false || strpos($programType, 'distribution') !== false) {
                $programRequirements['assistance_type'] = 'Food Distribution';
                $programRequirements['specific_needs'] = [
                    'food_packages_needed' => $totalResidents,
                    'rice_kilos_needed' => $totalResidents * 5, // 5 kilos per person
                    'canned_goods_needed' => $totalResidents * 3,
                    'drinking_water_liters' => $totalResidents * 10
                ];
            }
            
            $requirements[] = $programRequirements;
        }
        
        return $requirements;
    }
    
    /**
     * Calculate total family members
     */
    private function calculateTotalFamilyMembers($resident)
    {
        $count = 0;
        
        if ($resident->family_head_fullname) $count++;
        if ($resident->wife_fullname) $count++;
        if ($resident->son_fullname) $count++;
        if ($resident->daughter_fullname) $count++;
        if ($resident->grandmother_fullname) $count++;
        if ($resident->grandfather_fullname) $count++;
        
        return $count;
    }
    
    /**
     * Check if family has PWD member
     */
    private function hasPWDInFamily($resident)
    {
        return ($resident->family_head_pwd || $resident->wife_pwd || $resident->son_pwd || 
                $resident->daughter_pwd || $resident->grandmother_pwd || $resident->grandfather_pwd ||
                $resident->pwd_in_family === 'Yes');
    }
    
    /**
     * Log system activity
     */
    private function logActivity($action, $description, $module = 'Programs')
    {
        $performedBy = 'Admin';
        
        // Try to get authenticated user, fallback to 'Admin'
        if (Auth::check()) {
            $performedBy = Auth::user()->name ?? Auth::user()->email ?? 'Admin';
        }
        
        $this->activityLogService->log($action, $description, $module, $performedBy);
    }
}
