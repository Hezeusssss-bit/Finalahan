<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAssignment;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    protected $activityLogService;
    
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }
    /**
     * Display the employee management page
     */
    public function index()
    {
        $employees = Employee::orderBy('name')->get();
        return view('Employee.employee', compact('employees'));
    }
    
    /**
     * Store a new employee
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email',
                'password' => 'required|string|min:6|confirmed',
                'position' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'contact_number' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'status' => 'required|in:active,inactive,on_leave',
                'hire_date' => 'nullable|date'
            ]);
            
            // Hash password before storing
            $validated['password'] = bcrypt($validated['password']);
            
            Employee::create($validated);
            
            // Log employee addition
            $this->logActivity(
                'Employee Added',
                "New employee '{$validated['name']}' added as {$validated['position']} in {$validated['department']}",
                'Employee'
            );
            
            return redirect()->route('employee.employee')->with('success', 'Employee added successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors for debugging
            \Log::error('Validation errors: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log other errors
            \Log::error('Store employee error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while adding employee.');
        }
    }
    
    /**
     * Update an employee
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive,on_leave',
            'hire_date' => 'nullable|date'
        ]);
        
        $employee->update($validated);
        
        return redirect()->route('employee.employee')->with('success', 'Employee updated successfully!');
    }
    
    /**
     * Delete an employee
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        
        return redirect()->route('employee.employee')->with('success', 'Employee deleted successfully!');
    }
    
    /**
     * Display the employee dashboard
     */
    public function dashboard()
    {
        // Get current logged-in employee from session
        $employeeId = session('employee_id');
        $employee = null;
        $employeeAssignments = collect([]);
        
        // Initialize variables to avoid undefined variable errors
        $totalAssignments = 0;
        $completedAssignments = 0;
        $activeAssignments = 0;
        
        // Debug logging
        \Log::info('Dashboard access - Session employee_id: ' . ($employeeId ?? 'NOT SET'));
        \Log::info('Dashboard access - Session loggedIn: ' . (session('loggedIn') ? 'YES' : 'NO'));
        
        if ($employeeId) {
            $employee = Employee::find($employeeId);
            \Log::info('Employee found: ' . ($employee ? 'YES - ID: ' . $employee->id . ', Name: ' . $employee->name : 'NO'));
            
            if ($employee) {
                $employeeAssignments = EmployeeAssignment::where('employee_id', $employee->id)
                    ->where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                $totalAssignments = EmployeeAssignment::where('employee_id', $employee->id)->count();
                $completedAssignments = EmployeeAssignment::where('employee_id', $employee->id)->where('status', 'completed')->count();
                $activeAssignments = EmployeeAssignment::where('employee_id', $employee->id)->where('status', 'active')->count();
                
                \Log::info('Active assignments found: ' . $employeeAssignments->count());
            }
        }
        
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $inactiveEmployees = Employee::where('status', 'inactive')->count();
        $onLeaveEmployees = Employee::where('status', 'on_leave')->count();
        
        $recentEmployees = Employee::orderBy('created_at', 'desc')->take(5)->get();
        $employeesByDepartment = Employee::select('department', \DB::raw('count(*) as count'))
            ->groupBy('department')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('Employee.dashboard', compact(
            'totalEmployees',
            'activeEmployees', 
            'inactiveEmployees',
            'onLeaveEmployees',
            'recentEmployees',
            'employeesByDepartment',
            'employeeAssignments',
            'totalAssignments',
            'completedAssignments',
            'activeAssignments'
        ));
    }
    
    /**
     * Get employee data for AJAX requests
     */
    public function getEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }
    
    /**
     * Display the employee assignment history
     */
    public function history()
    {
        // Get current logged-in employee from session
        $employeeId = session('employee_id');
        $employee = null;
        $completedAssignments = collect([]);
        $activeAssignments = collect([]);
        
        if ($employeeId) {
            $employee = Employee::find($employeeId);
            
            if ($employee) {
                $completedAssignments = EmployeeAssignment::where('employee_id', $employee->id)
                    ->where('status', 'completed')
                    ->orderBy('updated_at', 'desc')
                    ->get();
                    
                $activeAssignments = EmployeeAssignment::where('employee_id', $employee->id)
                    ->where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        
        $totalAssignments = $completedAssignments->count() + $activeAssignments->count();
        
        return view('Employee.history', compact(
            'completedAssignments',
            'activeAssignments',
            'totalAssignments'
        ));
    }
    
    /**
     * Export evacuees data from employee's assigned areas to CSV
     */
    public function exportEvacuees()
    {
        try {
            // Get current logged-in employee from session
            $employeeId = session('employee_id');
            
            if (!$employeeId) {
                return redirect()->route('login')->with('error', 'Please login to access this feature.');
            }
            
            $employee = Employee::find($employeeId);
            
            if (!$employee) {
                return redirect()->route('login')->with('error', 'Employee not found.');
            }
            
            // Get assigned areas for this employee
            $assignedAreas = EmployeeAssignment::where('employee_id', $employee->id)
                ->where('status', 'active')
                ->pluck('evacuation_center')
                ->toArray();
            
            if (empty($assignedAreas)) {
                return redirect()->back()->with('error', 'No assigned evacuation centers found.');
            }
            
            // Get evacuees from assigned areas (excluding released)
            $evacuees = \App\Models\Evacuee::with('resident')
                ->whereIn('evacuation_area', $assignedAreas)
                ->where('evacuation_status', '!=', 'Released')
                ->get()
                ->map(function($evacuee) {
                    return [
                        'ID' => str_pad($evacuee->id, 4, '0', STR_PAD_LEFT),
                        'Fullname' => $evacuee->resident->name ?? 'N/A',
                        'Age' => $evacuee->resident->price ?? 'N/A',
                        'Gender' => $evacuee->resident->gender ?? 'N/A',
                        'Evacuation Status' => $evacuee->evacuation_status,
                        'Evacuation Area' => $evacuee->evacuation_area,
                        'Room Number' => $evacuee->room_number ?? 'N/A',
                        'Evacuation Date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : 'N/A'
                    ];
                });

            // Log export activity
            $this->logActivity(
                'Evacuees Data Exported by Employee',
                "Employee '{$employee->name}' exported {$evacuees->count()} evacuee records from assigned areas",
                'Employee'
            );

            // Generate CSV filename with timestamp and employee info
            $filename = 'evacuees_export_' . $employee->name . '_' . date('Y-m-d_H-i-s') . '.csv';
            
            // Set headers for CSV download
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];

            // Create CSV content
            $callback = function() use ($evacuees) {
                $file = fopen('php://output', 'w');
                
                // Add UTF-8 BOM for proper character encoding in Excel
                fwrite($file, "\xEF\xBB\xBF");
                
                // Add header row
                if ($evacuees->isNotEmpty()) {
                    fputcsv($file, array_keys($evacuees->first()));
                }
                
                // Add data rows
                foreach ($evacuees as $evacuee) {
                    fputcsv($file, $evacuee);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            \Log::error('Employee export evacuees error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while exporting evacuee data.');
        }
    }
    
    /**
     * Log system activity
     */
    private function logActivity($action, $description, $module = 'Employee')
    {
        $performedBy = 'Admin';
        
        // Try to get authenticated user, fallback to 'Admin'
        if (Auth::check()) {
            $performedBy = Auth::user()->name ?? Auth::user()->email ?? 'Admin';
        }
        
        $this->activityLogService->log($action, $description, $module, $performedBy);
    }
}
