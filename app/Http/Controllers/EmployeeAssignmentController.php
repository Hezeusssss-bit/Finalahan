<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeAssignmentController extends Controller
{
    public function index()
    {
        $assignments = EmployeeAssignment::with('employee')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('employee-assignments.index', compact('assignments'));
    }
    
    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        $evacuationCenters = [
            'Barangay Hall Evacuation Center',
            'Community Center Evacuation',
            'School Gymnasium',
            'Sports Complex',
            'Multi-Purpose Hall'
        ];
        $shifts = ['morning', 'afternoon', 'night'];
        
        return view('employee-assignments.create', compact('employees', 'evacuationCenters', 'shifts'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'evacuation_center' => 'required|string|max:255',
            'responsibilities' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $assignment = EmployeeAssignment::create($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Employee assigned successfully!',
            'assignment' => $assignment->load('employee')
        ]);
    }
    
    public function edit(EmployeeAssignment $assignment)
    {
        $employees = Employee::where('status', 'active')->get();
        $evacuationCenters = [
            'Barangay Hall Evacuation Center',
            'Community Center Evacuation',
            'School Gymnasium',
            'Sports Complex',
            'Multi-Purpose Hall'
        ];
        $shifts = ['morning', 'afternoon', 'night'];
        
        return view('employee-assignments.edit', compact('assignment', 'employees', 'evacuationCenters', 'shifts'));
    }
    
    public function update(Request $request, EmployeeAssignment $assignment)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'evacuation_center' => 'required|string|max:255',
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
}
