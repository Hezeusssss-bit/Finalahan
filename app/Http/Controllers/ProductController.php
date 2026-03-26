<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Evacuee;
use App\Models\Facility;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $activityLogService;
    
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }
    // 🔑 Login POST
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Dummy account
        $dummyEmail = 'kyle@kyle';
        $dummyPassword = 'kyle';

        if ($credentials['email'] === $dummyEmail && $credentials['password'] === $dummyPassword) {
            session(['loggedIn' => true]);
            
            // Log login activity
            $this->logActivity('login', 'Admin logged into the system');
            
            return redirect()->route('resident.index')->with('Success', 'Welcome Admin!');
        }

        // Check if it's an employee login
        $employee = \App\Models\Employee::where('email', $credentials['email'])->first();
        if ($employee && \Hash::check($credentials['password'], $employee->password)) {
            session(['loggedIn' => true, 'employee_id' => $employee->id]);
            
            // Log login activity
            $this->logActivity('login', "Employee '{$employee->name}' logged into the system");
            
            return redirect()->route('employee.dashboard')->with('Success', 'Welcome to Employee Dashboard!');
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials.',
        ]);
    }

    // 🔑 Logout
    public function logout()
    {
        session()->forget('loggedIn');
        return redirect()->route('login')->with('Success', 'Logged out successfully.');
    }

    // 🔑 Login page
    public function login()
    {
        return view('products.login');
    }

    // 📌 INDEX with Search + Pagination
public function index(Request $request)
{
    $search = $request->input('search');

    $query = Resident::query();

    if ($search) {
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    }

    // Paginate with 5 items per page and keep search query across pages
    $residents = $query->orderBy('created_at', 'desc')->paginate(5)->appends($request->all());

    // Analytics data
    $totalResidents = Resident::count();
    $newThisMonth = Resident::whereMonth('created_at', now()->month)
                           ->whereYear('created_at', now()->year)
                           ->count();

    // Recent Activities - Get real activities from database
    $recentActivities = $this->getRecentActivities();

    return view('products.index', [
        'residents' => $residents,
        'totalResidents' => $totalResidents,
        'newThisMonth' => $newThisMonth,
        'recentActivities' => $recentActivities
    ]);
}


    // 📌 CREATE page
    public function create()
    {
        return view('products.create');
    }

    // 📌 STORE new product
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            // qty now represents Lastname
            'qty' => 'required|string',
            // price now represents Age
            'price' => 'required|integer',
            // description now represents Address
            'description' => 'nullable|string',
            'gender' => 'required|in:Male,Female',
            'contact_number' => 'nullable|string|max:20'
        ]);

        $resident = Resident::create($data);
        
        // Log activity
        $this->logActivity('resident_added', "New resident '{$resident->name}' added to the system");

        return redirect(route('home'))->with('Success', 'Resident Created Successfully');
    }

    // 📌 SHOW single resident details (for view button)
    public function show(Resident $resident)
    {
        return response()->json([
            'id' => $resident->id,
            'name' => $resident->name,
            'qty' => $resident->qty,
            'price' => $resident->price,
            'description' => $resident->description,
            'created_at' => $resident->created_at->format('M d, Y h:i A'),
            'updated_at' => $resident->updated_at->format('M d, Y h:i A')
        ]);
    }

    // 📌 EDIT page
    public function edit(Resident $resident)
    {
        return view('products.edit', ['product' => $resident]);
    }

    // 📌 UPDATE product
    public function update(Resident $resident, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|string',
            'price' => 'required|integer',
            'description' => "nullable",
            'gender' => 'nullable|in:Male,Female',
            'contact_number' => 'nullable|string|max:20'
        ]);

        $resident->update($data);
        
        // Log activity
        $this->logActivity('resident_updated', "Resident '{$resident->name}' information updated");
        
        return redirect(route('home'))->with('Success', 'Resident Updated Successfully');
    }

    // 📌 DESTROY product
    public function destroy(Resident $resident){
        $residentName = $resident->name; // Store name before deletion
        $resident->delete();
        
        // Log activity
        $this->logActivity('resident_deleted', "Resident '{$residentName}' deleted from the system");
        
        return redirect(route('home'))->with('Success', 'Resident Deleted Successfully');
    }

    public function home(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        if ($perPage <= 0) { $perPage = 10; }
        if ($perPage > 100) { $perPage = 100; }
        $residents = \App\Models\Resident::orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->all());
        $totalResidents = Resident::count();
        $maleCount = 0;
        $femaleCount = 0;
        $seniorMale = 0;
        $seniorFemale = 0;
        $childMale = 0;
        $childFemale = 0;
        if (Schema::hasColumn('residents', 'gender')) {
            $maleCount = Resident::where('gender', 'Male')->count();
            $femaleCount = Resident::where('gender', 'Female')->count();
            if (Schema::hasColumn('residents', 'price')) {
                $seniorMale = Resident::where('gender', 'Male')->where('price', '>=', 60)->count();
                $seniorFemale = Resident::where('gender', 'Female')->where('price', '>=', 60)->count();
                $childMale = Resident::where('gender', 'Male')->where('price', '<', 18)->count();
                $childFemale = Resident::where('gender', 'Female')->where('price', '<', 18)->count();
            }
        }
        return view('products.home', compact('residents', 'totalResidents', 'maleCount', 'femaleCount', 'seniorMale', 'seniorFemale', 'childMale', 'childFemale'));
    }

    public function facilities()
    {
        // Get all facilities from database
        $facilities = Facility::orderBy('created_at', 'desc')->get();
        $totalFacilities = $facilities->count();
        return view('Facility.facilities', compact('totalFacilities', 'facilities'));
    }

    public function getFacilitiesApi()
    {
        try {
            $facilities = Facility::select('id', 'name')->orderBy('name')->get();
            
            return response()->json([
                'success' => true,
                'facilities' => $facilities
            ]);

        } catch (\Exception $e) {
            \Log::error('Get facilities API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch facilities.'
            ], 500);
        }
    }

    public function storeFacility(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:available,maintenance,unavailable',
                'capacity' => 'required|integer|min:1',
            ]);

            // Set default icon and description since they're removed from form
            $validated['icon'] = 'fas fa-building';
            $validated['description'] = 'Facility for community use and emergency response';

            $facility = Facility::create($validated);

            // Log activity
            $this->logActivity('create', "New facility '{$facility->name}' was added");

            return response()->json([
                'success' => true,
                'message' => 'Facility added successfully!',
                'facility' => $facility
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Store facility error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the facility. Please try again.'
            ], 500);
        }
    }

    public function deleteFacility($id)
    {
        try {
            $facility = Facility::findOrFail($id);
            $facilityName = $facility->name;
            
            $facility->delete();

            // Log activity
            $this->logActivity('delete', "Facility '{$facilityName}' was deleted");

            return response()->json([
                'success' => true,
                'message' => 'Facility deleted successfully!'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Facility not found.'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Delete facility error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the facility. Please try again.'
            ], 500);
        }
    }

    public function updateFacility(Request $request, $id)
    {
        try {
            $facility = Facility::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:available,maintenance,unavailable',
                'capacity' => 'required|integer|min:1',
            ]);

            // Keep existing icon and description
            $validated['icon'] = $facility->icon;
            $validated['description'] = $facility->description;

            $facility->update($validated);

            // Log activity
            $this->logActivity('update', "Facility '{$facility->name}' was updated");

            return response()->json([
                'success' => true,
                'message' => 'Facility updated successfully!',
                'facility' => $facility
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Facility not found.'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Update facility error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the facility. Please try again.'
            ], 500);
        }
    }

    public function editFacility($id)
    {
        try {
            $facility = Facility::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'facility' => $facility
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Facility not found.'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Edit facility error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading facility data.'
            ], 500);
        }
    }

    public function communityCenter()
    {
        return view('products.community');
    }

    public function healthCenter()
    {
        return view('products.health');
    }

    public function emergencyShelter()
    {
        return view('products.shelter');
    }

    public function school()
    {
        return view('products.school');
    }

    public function tryAll()
    {
        return view('SMS.tryall');
    }

    /**
     * Get residents grouped by purok for evacuee modal
     */
    public function getResidentsByPurok(Request $request)
    {
        // If a specific purok is requested, return only those residents
        if ($request->has('purok')) {
            $requestedPurok = $request->input('purok');
            
            $residents = Resident::select('id', 'name', 'qty', 'price', 'gender', 'description', 'contact_number')
                ->where('description', $requestedPurok)
                ->get()
                ->map(function($resident) {
                    // Check if resident is already evacuated and not released
                    $evacuee = \App\Models\Evacuee::where('resident_id', $resident->id)
                        ->where('evacuation_status', '!=', 'Released')
                        ->first();
                    $isEvacuated = $evacuee ? true : false;
                    $evacuationStatus = $evacuee ? $evacuee->evacuation_status : null;
                    
                    return [
                        'id' => $resident->id,
                        'name' => $resident->name,
                        'qty' => $resident->qty,
                        'price' => $resident->price,
                        'age' => $resident->price,
                        'gender' => $resident->gender,
                        'description' => $resident->description,
                        'contact_number' => $resident->contact_number,
                        'evacuation_status' => $evacuationStatus,
                        'is_evacuated' => $isEvacuated
                    ];
                });
                
            return response()->json(['residents' => $residents]);
        }
        
        // Original functionality - return all residents grouped by purok
        $residents = Resident::select('id', 'name', 'qty', 'price', 'gender', 'description')
            ->get()
            ->map(function($resident) {
                // Extract purok from address/description
                $purok = 'Unassigned';
                if (preg_match('/Purok\s*(I|II|III|IV|V|1|2|3|4|5)/i', $resident->description, $matches)) {
                    $purokMap = ['1' => 'Purok I', '2' => 'Purok II', '3' => 'Purok III', '4' => 'Purok IV', '5' => 'Purok V',
                                 'I' => 'Purok I', 'II' => 'Purok II', 'III' => 'Purok III', 'IV' => 'Purok IV', 'V' => 'Purok V'];
                    $purok = $purokMap[strtoupper($matches[1])] ?? 'Unassigned';
                }
                
                // Check if resident is already evacuated and not released
                $evacuee = \App\Models\Evacuee::where('resident_id', $resident->id)->first();
                $isEvacuated = $evacuee && $evacuee->evacuation_status !== 'Released' ? true : false;
                
                return [
                    'id' => $resident->id,
                    'name' => $resident->name . ' ' . $resident->qty,
                    'age' => $resident->price,
                    'gender' => $resident->gender,
                    'purok' => $purok,
                    'is_evacuated' => $isEvacuated
                ];
            })
            ->groupBy('purok');

        return response()->json($residents);
    }

    /**
     * Log system activity
     */
    private function logActivity($action, $description, $module = 'System')
    {
        $performedBy = 'Admin';
        
        // Try to get authenticated user, fallback to 'Admin'
        if (Auth::check()) {
            $performedBy = Auth::user()->name ?? Auth::user()->email ?? 'Admin';
        }
        
        $this->activityLogService->log($action, $description, $module, $performedBy);
    }

    /**
     * Get recent activities for dashboard
     */
    private function getRecentActivities()
    {
        // Return activities from ActivityLogService
        return $this->activityLogService->getRecentLogs(7);
    }

    /**
     * Show evacuee program page with real counts
     */
    public function evacueeProgram()
    {
        // Get total evacuees count (excluding released)
        $totalEvacuees = Evacuee::where('evacuation_status', '!=', 'Released')->count();
        
        // Get unique shelters count (excluding released)
        $totalShelters = Evacuee::where('evacuation_status', '!=', 'Released')->distinct('evacuation_area')->count('evacuation_area');
        
        // Get all evacuees with their resident data (excluding released)
        $evacuees = Evacuee::with('resident')
            ->where('evacuation_status', '!=', 'Released')
            ->get()
            ->map(function($evacuee) {
            return [
                'id' => $evacuee->id,
                'fullname' => $evacuee->resident->name . ' ' . $evacuee->resident->qty,
                'age' => $evacuee->resident->price,
                'gender' => $evacuee->resident->gender,
                'evacuation_status' => $evacuee->evacuation_status,
                'evacuation_area' => $evacuee->evacuation_area,
                'room_number' => $evacuee->room_number,
                'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-'
            ];
        });
        
        // Get available facilities for evacuation areas
        $facilities = Facility::where('status', 'available')->orderBy('name')->get();
        
        return view('Program.EvacueeProgram', [
            'totalEvacuees' => $totalEvacuees,
            'totalShelters' => $totalShelters,
            'evacuees' => $evacuees,
            'facilities' => $facilities
        ]);
    }

    /**
     * Store new evacuees
     */
    public function storeEvacuees(Request $request)
    {
        try {
            // Handle both JSON and form data
            if ($request->isJson()) {
                $data = $request->validate([
                    'purok' => 'required|string',
                    'status' => 'required|string|in:Evacuated,Relocated,Returned',
                    'area' => 'required|string',
                    'room' => 'nullable|string',
                    'evacuation_date' => 'required|date',
                    'residents' => 'required|array'
                ]);
                $residents = $data['residents'];
            } else {
                $data = $request->validate([
                    'purok' => 'required|string',
                    'status' => 'required|string|in:Evacuated,Relocated,Returned',
                    'area' => 'required|string',
                    'room' => 'nullable|string',
                    'evacuation_date' => 'required|date',
                    'residents_data' => 'required|json'
                ]);
                $residents = json_decode($data['residents_data'], true);
            }
            
            if (empty($residents)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No residents selected'
                ], 400);
            }

            foreach ($residents as $resident) {
                // Skip if already evacuated and not released
                if (Evacuee::where('resident_id', $resident['id'])
                    ->where('evacuation_status', '!=', 'Released')
                    ->exists()) {
                    continue;
                }
                
                Evacuee::create([
                    'resident_id' => $resident['id'],
                    'purok' => $data['purok'],
                    'evacuation_status' => $data['status'],
                    'evacuation_area' => $data['area'],
                    'room_number' => $data['room'],
                    'evacuation_date' => $data['evacuation_date'],
                    'notes' => null
                ]);
            }

            // Log evacuee addition activity
            $this->logActivity(
                'Evacuees Added', 
                count($residents) . ' residents evacuated to ' . $data['area'] . ' from ' . $data['purok'], 
                'System'
            );

            return response()->json([
                'success' => true,
                'message' => count($residents) . ' evacuee(s) added successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding evacuees: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export evacuees data to CSV
     */
    public function exportEvacuees()
    {
        try {
            // Get all evacuees with their resident data (excluding released)
            $evacuees = Evacuee::with('resident')
                ->where('evacuation_status', '!=', 'Released')
                ->get()
                ->map(function($evacuee) {
                return [
                    'ID' => str_pad($evacuee->id, 4, '0', STR_PAD_LEFT),
                    'Fullname' => $evacuee->resident->name . ' ' . $evacuee->resident->qty,
                    'Age' => $evacuee->resident->price,
                    'Gender' => $evacuee->resident->gender,
                    'Evacuation Status' => $evacuee->evacuation_status,
                    'Evacuation Area' => $evacuee->evacuation_area,
                    'Room Number' => $evacuee->room_number ?? '-',
                    'Evacuation Date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-'
                ];
            });

            // Log export activity
            $this->logActivity(
                'Evacuees Data Exported',
                'Exported ' . $evacuees->count() . ' evacuee records to CSV',
                'System'
            );

            // Generate CSV filename with timestamp
            $filename = 'evacuees_export_' . date('Y-m-d_H-i-s') . '.csv';
            
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
            return redirect()->back()->with('error', 'Error exporting evacuees data: ' . $e->getMessage());
        }
    }

    /**
     * Get evacuees statistics for export preview
     */
    public function getEvacueesStatistics()
    {
        try {
            $totalEvacuees = Evacuee::where('evacuation_status', '!=', 'Released')->count();
            $totalShelters = Evacuee::where('evacuation_status', '!=', 'Released')->distinct('evacuation_area')->count('evacuation_area');

            return response()->json([
                'totalEvacuees' => $totalEvacuees,
                'totalShelters' => $totalShelters
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'totalEvacuees' => 0,
                'totalShelters' => 0
            ], 500);
        }
    }

    /**
     * Get facility capacity and current occupancy
     */
    public function getFacilityCapacity($facility)
    {
        try {
            // Find the facility by name
            $facilityModel = Facility::where('name', $facility)->first();
            
            if (!$facilityModel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Facility not found'
                ], 404);
            }

            // Count current active evacuees in this facility (excluding released ones)
            $currentOccupancy = Evacuee::where('evacuation_area', $facility)
                ->where('evacuation_status', '!=', 'Released')
                ->count();
            
            return response()->json([
                'success' => true,
                'facility' => [
                    'name' => $facilityModel->name,
                    'capacity' => $facilityModel->capacity,
                    'current_occupancy' => $currentOccupancy,
                    'available_spaces' => $facilityModel->capacity ? $facilityModel->capacity - $currentOccupancy : null,
                    'occupancy_percentage' => $facilityModel->capacity ? round(($currentOccupancy / $facilityModel->capacity) * 100, 1) : null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching facility data'
            ], 500);
        }
    }

    /**
     * Release evacuee from evacuation area
     */
    public function releaseEvacuee($evacueeId, Request $request)
    {
        try {
            $evacuee = Evacuee::findOrFail($evacueeId);
            
            // Update evacuation status to 'Released'
            $evacuee->evacuation_status = 'Released';
            $evacuee->released_at = now();
            $evacuee->release_time = $request->input('release_time');
            $evacuee->save();

            // Log the release activity
            $this->logActivity(
                'Evacuee Released',
                "Evacuee '{$evacuee->resident->name}' was released from evacuation area",
                'System'
            );

            return response()->json([
                'success' => true,
                'message' => 'Evacuee successfully released from evacuation area'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Evacuee not found'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Release evacuee error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error releasing evacuee. Please try again.'
            ], 500);
        }
    }
}
