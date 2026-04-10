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
    
    // Get total evacuees (excluding released)
    $totalEvacuees = Evacuee::where('evacuation_status', '!=', 'Released')->count();

    // Recent Activities - Get real activities from database
    $recentActivities = $this->getRecentActivities();
    
    // Get upcoming programs and calculate assistance requirements
    $upcomingPrograms = \App\Models\Program::upcoming()->orderBy('start_date', 'asc')->get();
    $assistanceRequirements = $this->calculateDashboardAssistanceRequirements($upcomingPrograms);

    return view('products.index', [
        'residents' => $residents,
        'totalResidents' => $totalResidents,
        'newThisMonth' => $newThisMonth,
        'totalEvacuees' => $totalEvacuees,
        'recentActivities' => $recentActivities,
        'assistanceRequirements' => $assistanceRequirements
    ]);
}


    // 📌 CREATE page
    public function create()
    {
        return view('products.create');
    }

    // ð STORE new product
    public function store(Request $request)
    {
        $data = $request->validate([
            'family_head_fullname' => 'required|string|max:255',
            'family_head_age' => 'nullable|integer|min:0|max:120',
            'family_head_birthdate' => 'nullable|date',
            'family_head_pwd' => 'nullable|boolean',
            'wife_fullname' => 'nullable|string|max:255',
            'wife_age' => 'nullable|integer|min:0|max:120',
            'wife_birthdate' => 'nullable|date',
            'wife_pregnant' => 'nullable|boolean',
            'wife_pwd' => 'nullable|boolean',
            'pwd_in_family' => 'nullable|in:Yes,No',
            'son_fullname' => 'nullable|string|max:255',
            'son_age' => 'nullable|integer|min:0|max:120',
            'son_birthdate' => 'nullable|date',
            'son_pwd' => 'nullable|boolean',
            'daughter_fullname' => 'nullable|string|max:255',
            'daughter_age' => 'nullable|integer|min:0|max:120',
            'daughter_birthdate' => 'nullable|date',
            'daughter_pwd' => 'nullable|boolean',
            'grandmother_fullname' => 'nullable|string|max:255',
            'grandmother_age' => 'nullable|integer|min:0|max:120',
            'grandmother_birthdate' => 'nullable|date',
            'grandmother_pwd' => 'nullable|boolean',
            'grandfather_fullname' => 'nullable|string|max:255',
            'grandfather_age' => 'nullable|integer|min:0|max:120',
            'grandfather_birthdate' => 'nullable|date',
            'grandfather_pwd' => 'nullable|boolean',
            'description' => 'nullable|string', // Purok/Address
            'contact_number' => 'nullable|string|max:20'
        ]);

        // Set the name field to family head fullname for backward compatibility
        $data['name'] = $data['family_head_fullname'];
        
        // Set other required fields for backward compatibility
        $data['qty'] = ''; // Empty lastname since we're using fullnames
        $data['price'] = $data['family_head_age'] ?? 0; // Use family head age for backward compatibility
        $data['gender'] = 'Male'; // Default gender

        $resident = Resident::create($data);
        
        // Log activity
        $this->logActivity('family_added', "New family '{$resident->family_head_fullname}' added to the system");

        return redirect(route('home'))->with('Success', 'Family Head Created Successfully');
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
            'family_head_fullname' => $resident->family_head_fullname,
            'family_head_age' => $resident->family_head_age,
            'family_head_birthdate' => $resident->family_head_birthdate ? $resident->family_head_birthdate->format('Y-m-d') : null,
            'wife_fullname' => $resident->wife_fullname,
            'wife_age' => $resident->wife_age,
            'wife_birthdate' => $resident->wife_birthdate ? $resident->wife_birthdate->format('Y-m-d') : null,
            'son_fullname' => $resident->son_fullname,
            'son_age' => $resident->son_age,
            'son_birthdate' => $resident->son_birthdate ? $resident->son_birthdate->format('Y-m-d') : null,
            'daughter_fullname' => $resident->daughter_fullname,
            'daughter_age' => $resident->daughter_age,
            'daughter_birthdate' => $resident->daughter_birthdate ? $resident->daughter_birthdate->format('Y-m-d') : null,
            'grandmother_fullname' => $resident->grandmother_fullname,
            'grandmother_age' => $resident->grandmother_age,
            'grandmother_birthdate' => $resident->grandmother_birthdate ? $resident->grandmother_birthdate->format('Y-m-d') : null,
            'grandfather_fullname' => $resident->grandfather_fullname,
            'grandfather_age' => $resident->grandfather_age,
            'grandfather_birthdate' => $resident->grandfather_birthdate ? $resident->grandfather_birthdate->format('Y-m-d') : null,
            'contact_number' => $resident->contact_number,
            'created_at' => $resident->created_at->format('M d, Y h:i A'),
            'updated_at' => $resident->updated_at->format('M d, Y h:i A')
        ]);
    }

    // 📌 EDIT page
    public function edit(Resident $resident)
    {
        return view('products.edit', ['product' => $resident]);
    }

    // ð UPDATE product
    public function update(Resident $resident, Request $request)
    {
        $data = $request->validate([
            'family_head_fullname' => 'required|string|max:255',
            'family_head_age' => 'nullable|integer|min:0|max:120',
            'family_head_birthdate' => 'nullable|date',
            'family_head_pwd' => 'nullable|boolean',
            'wife_fullname' => 'nullable|string|max:255',
            'wife_age' => 'nullable|integer|min:0|max:120',
            'wife_birthdate' => 'nullable|date',
            'wife_pregnant' => 'nullable|boolean',
            'wife_pwd' => 'nullable|boolean',
            'pwd_in_family' => 'nullable|in:Yes,No',
            'son_fullname' => 'nullable|string|max:255',
            'son_age' => 'nullable|integer|min:0|max:120',
            'son_birthdate' => 'nullable|date',
            'son_pwd' => 'nullable|boolean',
            'daughter_fullname' => 'nullable|string|max:255',
            'daughter_age' => 'nullable|integer|min:0|max:120',
            'daughter_birthdate' => 'nullable|date',
            'daughter_pwd' => 'nullable|boolean',
            'grandmother_fullname' => 'nullable|string|max:255',
            'grandmother_age' => 'nullable|integer|min:0|max:120',
            'grandmother_birthdate' => 'nullable|date',
            'grandmother_pwd' => 'nullable|boolean',
            'grandfather_fullname' => 'nullable|string|max:255',
            'grandfather_age' => 'nullable|integer|min:0|max:120',
            'grandfather_birthdate' => 'nullable|date',
            'grandfather_pwd' => 'nullable|boolean',
            'description' => 'nullable|string', // Purok/Address
            'contact_number' => 'nullable|string|max:20'
        ]);

        // Set the name field to family head fullname for backward compatibility
        $data['name'] = $data['family_head_fullname'];
        
        // Set other required fields for backward compatibility
        $data['qty'] = ''; // Empty lastname since we're using fullnames
        $data['price'] = $data['family_head_age'] ?? 0; // Use family head age for backward compatibility
        $data['gender'] = 'Male'; // Default gender

        $resident->update($data);
        
        // Log activity
        $this->logActivity('family_updated', "Family '{$resident->family_head_fullname}' information updated");
        
        return redirect(route('home'))->with('Success', 'Family Head Updated Successfully');
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
     * Calculate assistance requirements for dashboard display
     */
    private function calculateDashboardAssistanceRequirements($programs)
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
                'start_date' => $program->start_date->format('M d, Y'),
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
                    'medical_supplies_needed' => $pwdCount * 2,
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
                    'rice_kilos_needed' => $totalResidents * 5,
                    'canned_goods_needed' => $totalResidents * 3,
                    'drinking_water_liters' => $totalResidents * 10
                ];
            }
            
            $requirements[] = $programRequirements;
        }
        
        return $requirements;
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
        
        // Get available facilities for evacuation areas with capacity info
        $facilities = Facility::where('status', 'available')->orderBy('name')->get()->map(function($facility) {
            // Get current occupancy for this facility
            $currentOccupancy = Evacuee::where('evacuation_area', $facility->name)
                ->where('evacuation_status', '!=', 'Released')
                ->count();
            
            $availableSpaces = $facility->capacity - $currentOccupancy;
            
            return [
                'id' => $facility->id,
                'name' => $facility->name,
                'capacity' => $facility->capacity,
                'current_occupancy' => $currentOccupancy,
                'available_spaces' => $availableSpaces,
                'occupancy_percentage' => $facility->capacity > 0 ? ($currentOccupancy / $facility->capacity) * 100 : 0
            ];
        });
        
        // === DSS ENHANCED STATISTICS ===
        
        // Calculate vulnerable groups based on actual evacuee data
        $evacueeDetails = Evacuee::with('resident')
            ->where('evacuation_status', '!=', 'Released')
            ->get();
        
        $seniorCount = 0;
        $childCount = 0;
        $child0_5Count = 0;
        $child6_12Count = 0;
        $child13_17Count = 0;
        $maleCount = 0;
        $femaleCount = 0;
        $totalCapacity = 0;
        $totalOccupancy = 0;
        
        foreach ($evacueeDetails as $evacuee) {
            $age = (int) $evacuee->resident->price;
            
            if ($age >= 60) {
                $seniorCount++;
            } elseif ($age < 18) {
                $childCount++;
                // Categorize children by specific age groups
                if ($age <= 5) {
                    $child0_5Count++;
                } elseif ($age >= 6 && $age <= 12) {
                    $child6_12Count++;
                } elseif ($age >= 13 && $age <= 17) {
                    $child13_17Count++;
                }
            }
            
            if (strtolower($evacuee->resident->gender) === 'male') {
                $maleCount++;
            } else {
                $femaleCount++;
            }
        }
        
        // Calculate facility statistics
        foreach ($facilities as $facility) {
            $totalCapacity += $facility['capacity'];
            $totalOccupancy += $facility['current_occupancy'];
        }
        
        // Calculate age-appropriate meal requirements
        $dailyMealsNeeded = 0;
        foreach ($evacueeDetails as $evacuee) {
            $age = (int) $evacuee->resident->price;
            
            if ($age <= 2) {
                $dailyMealsNeeded += 6; // Infants: 6 small meals per day
            } elseif ($age <= 12) {
                $dailyMealsNeeded += 5; // Children: 3 meals + 2 snacks
            } elseif ($age <= 17) {
                $dailyMealsNeeded += 3; // Teens: 3 meals per day
            } else {
                $dailyMealsNeeded += 3; // Adults: 3 meals per day
            }
        }
        
        // Calculate DSS metrics based on real data
        $dssMetrics = [
            // Food calculations (age-appropriate meals)
            'daily_meals_needed' => $dailyMealsNeeded,
            'weekly_food_requirement' => $dailyMealsNeeded * 7,
            
            // Meal breakdown by age group
            'infant_daily_meals' => $child0_5Count * 6,
            'child_daily_meals' => ($child6_12Count * 5) + ($child13_17Count * 3),
            'teen_daily_meals' => $child13_17Count * 3,
            'adult_daily_meals' => ($totalEvacuees - $childCount - $seniorCount) * 3 + $seniorCount * 3,
            
            // Water calculations (4 liters per person per day)
            'daily_water_requirement' => $totalEvacuees * 4,
            'weekly_water_requirement' => $totalEvacuees * 28,
            
            // Shelter calculations
            'total_capacity' => $totalCapacity,
            'total_occupied' => $totalOccupancy,
            'available_spaces' => $totalCapacity - $totalOccupancy,
            'occupancy_rate' => $totalCapacity > 0 ? ($totalOccupancy / $totalCapacity) * 100 : 0,
            
            // Vulnerable groups
            'senior_count' => $seniorCount,
            'child_count' => $childCount,
            'child_0_5_count' => $child0_5Count,
            'child_6_12_count' => $child6_12Count,
            'child_13_17_count' => $child13_17Count,
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            
            // Aid requirements
            'hygiene_kits_needed' => (int) ($totalEvacuees * 0.8), // 80% of evacuees
            'blankets_needed' => (int) ($totalEvacuees * 0.7), // 70% of evacuees
            'first_aid_kits_needed' => (int) ceil($totalEvacuees / 10), // 1 kit per 10 people
            
            // Medical requirements
            'chronic_medication_patients' => (int) ($totalEvacuees * 0.15), // 15% estimate
            'mental_health_sessions_needed' => (int) ($totalEvacuees * 0.2), // 20% estimate
            'pregnant_women_count' => (int) ($totalEvacuees * 0.08), // 8% estimate
            'disabled_persons_count' => (int) ($totalEvacuees * 0.12), // 12% estimate
            
            // Supply levels (simulated based on occupancy rate)
            'food_supply_coverage' => max(30, 100 - ($totalOccupancy / $totalCapacity) * 40), // Inverse relationship
            'medical_supply_level' => max(25, 95 - ($totalOccupancy / $totalCapacity) * 35), // Inverse relationship
            'clothing_inventory_adult' => (int) ($totalEvacuees * 0.6),
            'clothing_inventory_children_0_5' => $child0_5Count,
            'clothing_inventory_children_6_12' => $child6_12Count,
            'clothing_inventory_children_13_17' => $child13_17Count,
            'clothing_inventory_children_total' => $childCount,
        ];
        
        return view('Program.EvacueeProgram', [
            'totalEvacuees' => $totalEvacuees,
            'totalShelters' => $totalShelters,
            'evacuees' => $evacuees,
            'facilities' => $facilities,
            'dssMetrics' => $dssMetrics
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

    /**
     * Show evacuee details
     */
    public function showEvacuee($evacueeId)
    {
        try {
            $evacuee = Evacuee::with('resident')->findOrFail($evacueeId);
            
            // For simplicity, we'll return a JSON response with evacuee details
            // In a full implementation, you might want to return a view
            return response()->json([
                'success' => true,
                'evacuee' => [
                    'id' => str_pad($evacuee->id, 4, '0', STR_PAD_LEFT),
                    'name' => $evacuee->resident->name ?? 'N/A',
                    'age' => $evacuee->resident->price ?? 'N/A',
                    'gender' => $evacuee->resident->gender ?? 'N/A',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number ?? 'N/A',
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : 'N/A',
                    'released_at' => $evacuee->released_at ? $evacuee->released_at->format('Y-m-d H:i:s') : 'N/A'
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Evacuee not found'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Show evacuee error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving evacuee details.'
            ], 500);
        }
    }

    // Analytics Data API
    public function getAnalyticsData(Request $request)
    {
        try {
            // Get residents data for analytics
            $residents = Resident::all();
            
            // Calculate statistics from actual family data (same logic as home.blade.php)
            $totalFamilies = $residents->count();
            $totalMale = 0;
            $totalFemale = 0;
            $seniorMale = 0;
            $seniorFemale = 0;
            $childMale = 0;
            $childFemale = 0;
            $totalMembers = 0;
            $totalSeniors = 0;
            $totalChildren = 0;
            $pregnantCount = 0;
            $pwdCount = 0;
            $totalAge = 0;
            $ageCount = 0;
            
            // Calculate purok distribution
            $purokData = [
                'Purok I' => 0,
                'Purok II' => 0,
                'Purok III' => 0,
                'Purok IV' => 0,
                'Purok V' => 0
            ];
            
            foreach($residents as $resident) {
                // Count family head
                if($resident->family_head_fullname) {
                    $totalMembers++;
                    $age = $resident->family_head_age ?? 0;
                    $totalAge += $age;
                    if($age > 0) $ageCount++;
                    
                    if($age >= 60) {
                        $totalSeniors++;
                        if(strtolower($resident->gender) === 'male') {
                            $seniorMale++;
                            $totalMale++;
                        } else {
                            $seniorFemale++;
                            $totalFemale++;
                        }
                    } elseif($age < 18) {
                        $totalChildren++;
                        if(strtolower($resident->gender) === 'male') {
                            $childMale++;
                            $totalMale++;
                        } else {
                            $childFemale++;
                            $totalFemale++;
                        }
                    } else {
                        if(strtolower($resident->gender) === 'male') {
                            $totalMale++;
                        } else {
                            $totalFemale++;
                        }
                    }
                }
                
                // Count wife
                if($resident->wife_fullname) {
                    $totalMembers++;
                    $age = $resident->wife_age ?? 0;
                    $totalAge += $age;
                    if($age > 0) $ageCount++;
                    
                    if($age >= 60) {
                        $totalSeniors++;
                        $seniorFemale++;
                        $totalFemale++;
                    } elseif($age < 18) {
                        $totalChildren++;
                        $childFemale++;
                        $totalFemale++;
                    } else {
                        $totalFemale++;
                    }
                    
                    // Count pregnant wives
                    if($resident->wife_pregnant) {
                        $pregnantCount++;
                    }
                }
                
                // Count son
                if($resident->son_fullname) {
                    $totalMembers++;
                    $age = $resident->son_age ?? 0;
                    $totalAge += $age;
                    if($age > 0) $ageCount++;
                    
                    if($age >= 60) {
                        $totalSeniors++;
                        $seniorMale++;
                        $totalMale++;
                    } elseif($age < 18) {
                        $totalChildren++;
                        $childMale++;
                        $totalMale++;
                    } else {
                        $totalMale++;
                    }
                }
                
                // Count daughter
                if($resident->daughter_fullname) {
                    $totalMembers++;
                    $age = $resident->daughter_age ?? 0;
                    $totalAge += $age;
                    if($age > 0) $ageCount++;
                    
                    if($age >= 60) {
                        $totalSeniors++;
                        $seniorFemale++;
                        $totalFemale++;
                    } elseif($age < 18) {
                        $totalChildren++;
                        $childFemale++;
                        $totalFemale++;
                    } else {
                        $totalFemale++;
                    }
                }
                
                // Count grandmother
                if($resident->grandmother_fullname) {
                    $totalMembers++;
                    $age = $resident->grandmother_age ?? 0;
                    $totalAge += $age;
                    if($age > 0) $ageCount++;
                    
                    if($age >= 60) {
                        $totalSeniors++;
                        $seniorFemale++;
                        $totalFemale++;
                    } elseif($age < 18) {
                        $totalChildren++;
                        $childFemale++;
                        $totalFemale++;
                    } else {
                        $totalFemale++;
                    }
                }
                
                // Count grandfather
                if($resident->grandfather_fullname) {
                    $totalMembers++;
                    $age = $resident->grandfather_age ?? 0;
                    $totalAge += $age;
                    if($age > 0) $ageCount++;
                    
                    if($age >= 60) {
                        $totalSeniors++;
                        $seniorMale++;
                        $totalMale++;
                    } elseif($age < 18) {
                        $totalChildren++;
                        $childMale++;
                        $totalMale++;
                    } else {
                        $totalMale++;
                    }
                }
                
                // Count PWD (actual individual PWD fields)
                if($resident->family_head_pwd) $pwdCount++;
                if($resident->wife_pwd) $pwdCount++;
                if($resident->son_pwd) $pwdCount++;
                if($resident->daughter_pwd) $pwdCount++;
                if($resident->grandmother_pwd) $pwdCount++;
                if($resident->grandfather_pwd) $pwdCount++;
                
                // Purok distribution
                $purok = $resident->description ?? 'Unknown';
                if (array_key_exists($purok, $purokData)) {
                    $purokData[$purok]++;
                }
            }
            
            // Calculate adults (non-senior, non-child)
            $adultMale = $totalMale - $seniorMale - $childMale;
            $adultFemale = $totalFemale - $seniorFemale - $childFemale;
            
            // Calculate readiness metrics
            $contactCoverage = $totalFamilies > 0 ? round(($residents->where('contact_number', '!=', null)->count() / $totalFamilies) * 100) : 0;
            $vulnerabilityRate = $totalMembers > 0 ? round((($totalSeniors + $totalChildren + $pregnantCount + $pwdCount) / $totalMembers) * 100) : 0;
            $readinessScore = round(($contactCoverage + (100 - $vulnerabilityRate) + 50) / 3);
            
            // Calculate average age
            $avgAge = $ageCount > 0 ? round($totalAge / $ageCount) : 0;
            
            // Calculate gender ratio (adults only)
            $totalAdults = $adultMale + $adultFemale;
            $genderRatio = $adultFemale > 0 ? round(($adultMale / $adultFemale) * 100) : 100;
            
            // Calculate dependency ratio
            $workingAge = $totalMembers - $totalSeniors - $totalChildren;
            $dependencyRatio = $workingAge > 0 ? round((($totalSeniors + $totalChildren) / $workingAge) * 100) : 0;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'demographics' => [
                        'seniorMale' => $seniorMale,
                        'seniorFemale' => $seniorFemale,
                        'adultMale' => $adultMale,
                        'adultFemale' => $adultFemale,
                        'childMale' => $childMale,
                        'childFemale' => $childFemale,
                        'avgAge' => $avgAge,
                        'genderRatio' => $genderRatio,
                        'dependencyRatio' => $dependencyRatio
                    ],
                    'vulnerability' => [
                        'seniors' => $totalSeniors,
                        'children' => $totalChildren,
                        'pregnant' => $pregnantCount,
                        'pwd' => $pwdCount,
                        'vulnerabilityRate' => $vulnerabilityRate,
                        'highRiskGroups' => $totalSeniors + $totalChildren + $pregnantCount + $pwdCount,
                        'specialNeeds' => $pregnantCount + $pwdCount
                    ],
                    'readiness' => [
                        'contactCoverage' => $contactCoverage,
                        'readinessScore' => $readinessScore,
                        'responseTime' => $readinessScore >= 80 ? 'Fast' : ($readinessScore >= 60 ? 'Moderate' : 'Slow')
                    ],
                    'purok' => [
                        'distribution' => $purokData,
                        'maxPurok' => max($purokData),
                        'maxPurokName' => array_search(max($purokData), $purokData),
                        'coveredAreas' => count(array_filter($purokData)),
                        'avgPerPurok' => count(array_filter($purokData)) > 0 ? round($totalMembers / count(array_filter($purokData))) : 0
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Analytics data error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving analytics data.'
            ], 500);
        }
    }
}
