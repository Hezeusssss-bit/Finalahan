<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAssignment;
use App\Models\Facility;
use App\Models\Program;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeAssignmentController extends Controller
{
    public function index()
    {
        $assignments = EmployeeAssignment::with('employee')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Data needed for create modal form
        $employees = Employee::where('status', 'active')->get();
        $facilities = Facility::orderBy('name')->get();
        $evacuationCenters = $facilities->pluck('name')->toArray();
        $shifts = ['morning', 'afternoon', 'night'];
        
        // Get upcoming programs for purok selection
        $upcomingPrograms = Program::upcoming()->orderBy('start_date', 'asc')->get();
        
        // Calculate assistance requirements for upcoming programs
        $upcomingRequirements = $this->calculateAssistanceRequirements($upcomingPrograms);
            
        return view('employee-assignments.index', compact('assignments', 'employees', 'evacuationCenters', 'shifts', 'upcomingPrograms', 'upcomingRequirements'));
    }
    
    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        $facilities = Facility::orderBy('name')->get();
        $evacuationCenters = $facilities->pluck('name')->toArray();
        $shifts = ['morning', 'afternoon', 'night'];
        
        // Get upcoming programs for purok selection
        $upcomingPrograms = Program::upcoming()->orderBy('start_date', 'asc')->get();
        
        // Calculate assistance requirements for upcoming programs
        $upcomingRequirements = $this->calculateAssistanceRequirements($upcomingPrograms);
        
        return view('employee-assignments.create', compact('employees', 'evacuationCenters', 'shifts', 'upcomingPrograms', 'upcomingRequirements'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'purok' => 'required|string|max:255',
            'responsibilities' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            // Check if request expects JSON (AJAX) or regular form submission
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            } else {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        
        $assignment = EmployeeAssignment::create($request->all());
        
        // Check if request expects JSON (AJAX) or regular form submission
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee assigned successfully!',
                'assignment' => $assignment->load('employee')
            ]);
        } else {
            return redirect()->route('employee-assignments.index')
                ->with('success', 'Employee assignment created successfully!');
        }
    }
    
    public function edit(EmployeeAssignment $assignment)
    {
        $employees = Employee::where('status', 'active')->get();
        $facilities = Facility::orderBy('name')->get();
        $evacuationCenters = $facilities->pluck('name')->toArray();
        $shifts = ['morning', 'afternoon', 'night'];
        
        // Get upcoming programs for purok selection
        $upcomingPrograms = Program::upcoming()->orderBy('start_date', 'asc')->get();
        
        // Calculate assistance requirements for upcoming programs
        $upcomingRequirements = $this->calculateAssistanceRequirements($upcomingPrograms);
        
        return view('employee-assignments.edit', compact('assignment', 'employees', 'evacuationCenters', 'shifts', 'upcomingPrograms', 'upcomingRequirements'));
    }
    
    public function update(Request $request, EmployeeAssignment $assignment)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'purok' => 'required|string|max:255',
            'responsibilities' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $assignment->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Assignment updated successfully!',
            'assignment' => $assignment->load('employee')
        ]);
    }
    
    public function destroy(EmployeeAssignment $assignment)
    {
        $assignment->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Assignment deleted successfully!'
        ]);
    }
    
    public function getAssignmentsForDate($date)
    {
        $assignments = EmployeeAssignment::with('employee')
            ->whereDate('assignment_date', $date)
            ->orderBy('start_time')
            ->get();
            
        return response()->json($assignments);
    }
    
    public function getEmployeeAssignments($employeeId)
    {
        $assignments = EmployeeAssignment::where('employee_id', $employeeId)
            ->whereDate('assignment_date', '>=', now()->format('Y-m-d'))
            ->orderBy('assignment_date')
            ->orderBy('start_time')
            ->get();
            
        return response()->json($assignments);
    }
    
    public function showEmployeeAssignments(Employee $employee)
    {
        $assignments = EmployeeAssignment::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $activeAssignments = $assignments->where('status', 'active');
        $completedAssignments = $assignments->where('status', 'completed');
        $cancelledAssignments = $assignments->where('status', 'cancelled');
            
        return view('employee-assignments.employee', compact('employee', 'activeAssignments', 'completedAssignments', 'cancelledAssignments'));
    }
    
    public function complete(EmployeeAssignment $assignment)
    {
        try {
            // Only allow the assigned employee to mark their own assignment as complete
            $employeeId = session('employee_id');
            if (!$employeeId || $assignment->employee_id != $employeeId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }
            
            // Only allow completion of active assignments
            if ($assignment->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only active assignments can be marked as completed.'
                ], 422);
            }
            
            $assignment->update(['status' => 'completed']);
            
            return response()->json([
                'success' => true,
                'message' => 'Assignment marked as completed successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while completing the assignment.'
            ], 500);
        }
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
}
