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

    // Get facilities for evacuation area analytics
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

    return view('products.index', [
        'residents' => $residents,
        'totalResidents' => $totalResidents,
        'newThisMonth' => $newThisMonth,
        'totalEvacuees' => $totalEvacuees,
        'recentActivities' => $recentActivities,
        'assistanceRequirements' => $assistanceRequirements,
        'facilities' => $facilities,
        'evacuees' => $evacuees
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
        // Get all request data first
        $allData = $request->all();
        
        // Handle checkboxes - convert to boolean properly
        $checkboxFields = [
            'family_head_pwd', 'wife_pregnant', 'wife_pwd', 'son_pwd', 
            'daughter_pwd', 'grandmother_pwd', 'grandfather_pwd'
        ];
        
        foreach ($checkboxFields as $field) {
            $allData[$field] = isset($allData[$field]) ? true : false;
        }
        
        $data = $request->validate([
            'family_head_fullname' => 'required|string|max:255',
            'family_head_age' => 'nullable|integer|min:0|max:120',
            'family_head_birthdate' => 'nullable|date',
            'family_head_pwd' => 'boolean',
            'wife_fullname' => 'nullable|string|max:255',
            'wife_age' => 'nullable|integer|min:0|max:120',
            'wife_birthdate' => 'nullable|date',
            'wife_pregnant' => 'boolean',
            'wife_pwd' => 'boolean',
            'pwd_in_family' => 'nullable|in:Yes,No',
            'son_fullname' => 'nullable|string|max:255',
            'son_age' => 'nullable|integer|min:0|max:120',
            'son_birthdate' => 'nullable|date',
            'son_pwd' => 'boolean',
            'daughter_fullname' => 'nullable|string|max:255',
            'daughter_age' => 'nullable|integer|min:0|max:120',
            'daughter_birthdate' => 'nullable|date',
            'daughter_pwd' => 'boolean',
            'grandmother_fullname' => 'nullable|string|max:255',
            'grandmother_age' => 'nullable|integer|min:0|max:120',
            'grandmother_birthdate' => 'nullable|date',
            'grandmother_pwd' => 'boolean',
            'grandfather_fullname' => 'nullable|string|max:255',
            'grandfather_age' => 'nullable|integer|min:0|max:120',
            'grandfather_birthdate' => 'nullable|date',
            'grandfather_pwd' => 'boolean',
            'description' => 'nullable|string', // Purok/Address
            'contact_number' => 'nullable|string|max:20'
        ]);

        // Merge the processed checkbox values with validated data
        $data = array_merge($data, array_intersect_key($allData, array_flip($checkboxFields)));

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
        // Get all request data first
        $allData = $request->all();
        
        // Handle checkboxes - convert to boolean properly
        $checkboxFields = [
            'family_head_pwd', 'wife_pregnant', 'wife_pwd', 'son_pwd', 
            'daughter_pwd', 'grandmother_pwd', 'grandfather_pwd'
        ];
        
        foreach ($checkboxFields as $field) {
            $allData[$field] = isset($allData[$field]) ? true : false;
        }
        
        $data = $request->validate([
            'family_head_fullname' => 'required|string|max:255',
            'family_head_age' => 'nullable|integer|min:0|max:120',
            'family_head_birthdate' => 'nullable|date',
            'family_head_pwd' => 'boolean',
            'wife_fullname' => 'nullable|string|max:255',
            'wife_age' => 'nullable|integer|min:0|max:120',
            'wife_birthdate' => 'nullable|date',
            'wife_pregnant' => 'boolean',
            'wife_pwd' => 'boolean',
            'pwd_in_family' => 'nullable|in:Yes,No',
            'son_fullname' => 'nullable|string|max:255',
            'son_age' => 'nullable|integer|min:0|max:120',
            'son_birthdate' => 'nullable|date',
            'son_pwd' => 'boolean',
            'daughter_fullname' => 'nullable|string|max:255',
            'daughter_age' => 'nullable|integer|min:0|max:120',
            'daughter_birthdate' => 'nullable|date',
            'daughter_pwd' => 'boolean',
            'grandmother_fullname' => 'nullable|string|max:255',
            'grandmother_age' => 'nullable|integer|min:0|max:120',
            'grandmother_birthdate' => 'nullable|date',
            'grandmother_pwd' => 'boolean',
            'grandfather_fullname' => 'nullable|string|max:255',
            'grandfather_age' => 'nullable|integer|min:0|max:120',
            'grandfather_birthdate' => 'nullable|date',
            'grandfather_pwd' => 'boolean',
            'description' => 'nullable|string', // Purok/Address
            'contact_number' => 'nullable|string|max:20'
        ]);

        // Merge the processed checkbox values with validated data
        $data = array_merge($data, array_intersect_key($allData, array_flip($checkboxFields)));

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
            $facilities = Facility::select('id', 'name', 'capacity', 'status')->orderBy('name')->get();
            
            return response()->json($facilities);

        } catch (\Exception $e) {
            \Log::error('Get facilities API error: ' . $e->getMessage());
            return response()->json([], 500);
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
            
            $residents = Resident::where('description', $requestedPurok)
                ->get()
                ->map(function($resident) {
                    // Check if resident is already evacuated and not released
                    $evacuee = \App\Models\Evacuee::where('resident_id', $resident->id)
                        ->where('evacuation_status', '!=', 'Released')
                        ->first();
                    $isEvacuated = $evacuee ? true : false;
                    $evacuationStatus = $evacuee ? $evacuee->evacuation_status : null;
                    
                    // Build family members array
                    $familyMembers = [];
                    $totalMembers = 0;
                    $aidNeeds = $this->calculateFamilyAidNeeds($resident);
                    
                    // Add family head
                    if ($resident->family_head_fullname) {
                        $familyMembers[] = [
                            'type' => 'Family Head',
                            'name' => $resident->family_head_fullname,
                            'age' => $resident->family_head_age,
                            'gender' => $resident->gender ?? 'Male',
                            'pwd' => $resident->family_head_pwd,
                            'pregnant' => false
                        ];
                        $totalMembers++;
                    }
                    
                    // Add wife
                    if ($resident->wife_fullname) {
                        $familyMembers[] = [
                            'type' => 'Wife',
                            'name' => $resident->wife_fullname,
                            'age' => $resident->wife_age,
                            'gender' => 'Female',
                            'pwd' => $resident->wife_pwd,
                            'pregnant' => $resident->wife_pregnant
                        ];
                        $totalMembers++;
                    }
                    
                    // Add son
                    if ($resident->son_fullname) {
                        $familyMembers[] = [
                            'type' => 'Son',
                            'name' => $resident->son_fullname,
                            'age' => $resident->son_age,
                            'gender' => 'Male',
                            'pwd' => $resident->son_pwd,
                            'pregnant' => false
                        ];
                        $totalMembers++;
                    }
                    
                    // Add daughter
                    if ($resident->daughter_fullname) {
                        $familyMembers[] = [
                            'type' => 'Daughter',
                            'name' => $resident->daughter_fullname,
                            'age' => $resident->daughter_age,
                            'gender' => 'Female',
                            'pwd' => $resident->daughter_pwd,
                            'pregnant' => false
                        ];
                        $totalMembers++;
                    }
                    
                    // Add grandmother
                    if ($resident->grandmother_fullname) {
                        $familyMembers[] = [
                            'type' => 'Grandmother',
                            'name' => $resident->grandmother_fullname,
                            'age' => $resident->grandmother_age,
                            'gender' => 'Female',
                            'pwd' => $resident->grandmother_pwd,
                            'pregnant' => false
                        ];
                        $totalMembers++;
                    }
                    
                    // Add grandfather
                    if ($resident->grandfather_fullname) {
                        $familyMembers[] = [
                            'type' => 'Grandfather',
                            'name' => $resident->grandfather_fullname,
                            'age' => $resident->grandfather_age,
                            'gender' => 'Male',
                            'pwd' => $resident->grandfather_pwd,
                            'pregnant' => false
                        ];
                        $totalMembers++;
                    }
                    
                    return [
                        'id' => $resident->id,
                        'family_head_name' => $resident->family_head_fullname ?: $resident->name . ' ' . $resident->qty,
                        'name' => $resident->name,
                        'qty' => $resident->qty,
                        'price' => $resident->price,
                        'age' => $resident->family_head_age ?: $resident->price,
                        'gender' => $resident->gender,
                        'description' => $resident->description,
                        'contact_number' => $resident->contact_number,
                        'evacuation_status' => $evacuationStatus,
                        'is_evacuated' => $isEvacuated,
                        'family_members' => $familyMembers,
                        'total_members' => $totalMembers,
                        'aid_needs' => $aidNeeds
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
     * Calculate aid distribution needs for a family
     */
    private function calculateFamilyAidNeeds($resident)
    {
        $needs = [
            'daily_meals' => 0,
            'water_liters' => 0,
            'hygiene_kits' => 0,
            'blankets' => 0,
            'clothing' => [
                'adult_clothes' => 0,
                'children_0_5' => 0,
                'children_6_12' => 0,
                'children_13_17' => 0,
                'senior_clothes' => 0
            ],
            'medical_supplies' => 0,
            'special_needs' => []
        ];
        
        $totalMembers = 0;
        $seniorCount = 0;
        $childCount = 0;
        $pregnantCount = 0;
        $pwdCount = 0;
        
        // Count family members and calculate needs
        $members = [
            ['age' => $resident->family_head_age, 'pwd' => $resident->family_head_pwd, 'pregnant' => false],
            ['age' => $resident->wife_age, 'pwd' => $resident->wife_pwd, 'pregnant' => $resident->wife_pregnant],
            ['age' => $resident->son_age, 'pwd' => $resident->son_pwd, 'pregnant' => false],
            ['age' => $resident->daughter_age, 'pwd' => $resident->daughter_pwd, 'pregnant' => false],
            ['age' => $resident->grandmother_age, 'pwd' => $resident->grandmother_pwd, 'pregnant' => false],
            ['age' => $resident->grandfather_age, 'pwd' => $resident->grandfather_pwd, 'pregnant' => false]
        ];
        
        foreach ($members as $member) {
            if ($member['age']) {
                $totalMembers++;
                
                // Calculate meals based on age
                if ($member['age'] <= 2) {
                    $needs['daily_meals'] += 6; // Infants: 6 small meals
                } elseif ($member['age'] <= 12) {
                    $needs['daily_meals'] += 5; // Children: 3 meals + 2 snacks
                } elseif ($member['age'] <= 17) {
                    $needs['daily_meals'] += 3; // Teens: 3 meals
                } else {
                    $needs['daily_meals'] += 3; // Adults: 3 meals
                }
                
                // Water: 4 liters per person per day
                $needs['water_liters'] += 4;
                
                // Hygiene kits (1 per person, but every 2 people share 1 kit minimum)
                $needs['hygiene_kits'] = max(1, ceil($totalMembers * 0.8));
                
                // Blankets (1 per person, but every 3 people share 2 blankets minimum)
                $needs['blankets'] = max(2, ceil($totalMembers * 0.7));
                
                // Clothing needs by age group
                if ($member['age'] >= 60) {
                    $needs['clothing']['senior_clothes']++;
                    $seniorCount++;
                } elseif ($member['age'] < 18) {
                    if ($member['age'] <= 5) {
                        $needs['clothing']['children_0_5']++;
                    } elseif ($member['age'] <= 12) {
                        $needs['clothing']['children_6_12']++;
                    } else {
                        $needs['clothing']['children_13_17']++;
                    }
                    $childCount++;
                } else {
                    $needs['clothing']['adult_clothes']++;
                }
                
                // Medical supplies (basic first aid per family, plus additional for vulnerable)
                $needs['medical_supplies'] = 1; // Base first aid kit
                
                // Count special needs
                if ($member['pwd']) {
                    $pwdCount++;
                    $needs['special_needs'][] = 'PWD assistance required';
                    $needs['medical_supplies'] += 0.5; // Additional medical supplies
                }
                
                if ($member['pregnant']) {
                    $pregnantCount++;
                    $needs['special_needs'][] = 'Prenatal care items';
                    $needs['medical_supplies'] += 0.3; // Additional medical supplies
                }
            }
        }
        
        // Adjust medical supplies based on family composition
        if ($seniorCount > 0) {
            $needs['medical_supplies'] += $seniorCount * 0.4; // Additional medical for seniors
            $needs['special_needs'][] = 'Senior medical support';
        }
        
        if ($childCount > 0) {
            $needs['medical_supplies'] += $childCount * 0.2; // Additional medical for children
            $needs['special_needs'][] = 'Pediatric care items';
        }
        
        // Round medical supplies to reasonable number
        $needs['medical_supplies'] = ceil($needs['medical_supplies']);
        
        // Set hygiene kits and blankets based on total members
        $needs['hygiene_kits'] = max(1, ceil($totalMembers * 0.8));
        $needs['blankets'] = max(2, ceil($totalMembers * 0.7));
        
        // Remove duplicate special needs
        $needs['special_needs'] = array_unique($needs['special_needs']);
        
        return $needs;
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
    private function logActivity($action, $description, $module = 'Residents')
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
                
                $pwdCount = 0;
                $seniorCount = 0;
                $pregnantCount = 0;
                $childCount = 0;
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
                    
                    // Count Children (under 18 years) - comprehensive counting like home.blade.php
                    if ($resident->family_head_age < 18 && $resident->family_head_fullname) $childCount++;
                    if ($resident->wife_age < 18 && $resident->wife_fullname) $childCount++;
                    if ($resident->son_age < 18 && $resident->son_fullname) $childCount++;
                    if ($resident->daughter_age < 18 && $resident->daughter_fullname) $childCount++;
                }
                
                $programRequirements = [
                    'purok' => $purok,
                    'program_title' => $program->title,
                    'start_date' => $program->start_date->format('M d, Y'),
                    'total_residents' => $totalResidents,
                    'pwd_count' => $pwdCount,
                    'senior_count' => $seniorCount,
                    'pregnant_count' => $pregnantCount,
                    'child_count' => $childCount,
                ];
                
                // Specific assistance needs based on program type
                if (strpos($programType, 'educational') !== false || strpos($programType, 'education') !== false || strpos($programType, 'school') !== false) {
                    $programRequirements['assistance_type'] = 'Educational Assistance';
                    $programRequirements['specific_needs'] = [
                        'school_supplies_needed' => $totalResidents,
                        'educational_materials' => max(1, floor($totalResidents * 0.8)),
                        'backpacks_needed' => max(1, floor($totalResidents * 0.6)),
                        'uniform_assistance' => max(1, floor($totalResidents * 0.4))
                    ];
                }
                elseif (strpos($programType, 'pwd') !== false || (strpos($programType, 'assistance') !== false && strpos($programType, 'educational') === false && strpos($programType, 'education') === false)) {
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
                    $medicalNeeds = [
                        'basic_medicine_kits' => $totalResidents,
                        'vitamin_supplements' => $totalResidents,
                        'first_aid_kits' => max(1, floor($totalResidents * 0.3)),
                        'medical_consultations' => $totalResidents
                    ];
                    
                    // Add senior-specific medical equipment if seniors are present
                    if ($seniorCount > 0) {
                        $medicalNeeds['blood_pressure_monitors'] = max(1, floor($seniorCount * 0.6)); // 60% of seniors
                        $medicalNeeds['reading_glasses_needed'] = max(1, floor($seniorCount * 0.8)); // 80% of seniors
                        $medicalNeeds['medicine_kits_needed'] = $seniorCount; // 1 per senior
                    }
                    
                    // Add PWD-specific medical equipment if PWD are present
                    if ($pwdCount > 0) {
                        $medicalNeeds['wheelchairs_needed'] = max(1, floor($pwdCount * 0.5)); // 50% of PWD
                        $medicalNeeds['walking_aids_needed'] = max(1, floor($pwdCount * 0.7)); // 70% of PWD
                    }
                    
                    $programRequirements['specific_needs'] = $medicalNeeds;
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
        // Get total evacuees count will be calculated below after expanding family members
        
        // Get unique shelters count (excluding released)
        $totalShelters = Evacuee::where('evacuation_status', '!=', 'Released')->distinct('evacuation_area')->count('evacuation_area');
        
        // Get all evacuees with their resident data (excluding released) and group by family head
        $evacueesData = Evacuee::with('resident')
            ->where('evacuation_status', '!=', 'Released')
            ->get();
        
        $evacuees = collect();
        $seniorCount = 0;
        $childCount = 0;
        $child0_5Count = 0;
        $child6_12Count = 0;
        $child13_17Count = 0;
        $maleCount = 0;
        $femaleCount = 0;
        
        foreach ($evacueesData as $evacuee) {
            $resident = $evacuee->resident;
            
            // Build family members array and group by family head
            $familyMembers = [];
            $familyHeadName = $resident->family_head_fullname ?: ($resident->name . ' ' . $resident->qty);
            $totalFamilyMembers = 0;
            $hasPregnant = false;
            $hasPWD = false;
            
            // Count pregnant women and PWD members for this family
            $familyPregnantCount = 0;
            $familyPWDCount = 0;
            
            // Add family head
            if ($resident->family_head_fullname) {
                $familyMembers[] = [
                    'evacuee_id' => $evacuee->id,
                    'fullname' => $resident->family_head_fullname,
                    'age' => $resident->family_head_age,
                    'gender' => $resident->gender ?? 'Male',
                    'relationship' => 'Family Head',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                    'family_head_name' => $familyHeadName,
                    'pwd' => $resident->family_head_pwd,
                    'pregnant' => false
                ];
                $totalFamilyMembers++;
                if ($resident->family_head_pwd) {
                    $hasPWD = true;
                    $familyPWDCount++;
                }
            }
            
            // Add wife
            if ($resident->wife_fullname) {
                $familyMembers[] = [
                    'evacuee_id' => $evacuee->id,
                    'fullname' => $resident->wife_fullname,
                    'age' => $resident->wife_age,
                    'gender' => 'Female',
                    'relationship' => 'Wife',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                    'family_head_name' => $familyHeadName,
                    'pwd' => $resident->wife_pwd,
                    'pregnant' => $resident->wife_pregnant
                ];
                $totalFamilyMembers++;
                if ($resident->wife_pwd) {
                    $hasPWD = true;
                    $familyPWDCount++;
                }
                if ($resident->wife_pregnant) {
                    $hasPregnant = true;
                    $familyPregnantCount++;
                }
            }
            
            // Add son
            if ($resident->son_fullname) {
                $familyMembers[] = [
                    'evacuee_id' => $evacuee->id,
                    'fullname' => $resident->son_fullname,
                    'age' => $resident->son_age,
                    'gender' => 'Male',
                    'relationship' => 'Son',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                    'family_head_name' => $familyHeadName,
                    'pwd' => $resident->son_pwd,
                    'pregnant' => false
                ];
                $totalFamilyMembers++;
                if ($resident->son_pwd) {
                    $hasPWD = true;
                    $familyPWDCount++;
                }
            }
            
            // Add daughter
            if ($resident->daughter_fullname) {
                $familyMembers[] = [
                    'evacuee_id' => $evacuee->id,
                    'fullname' => $resident->daughter_fullname,
                    'age' => $resident->daughter_age,
                    'gender' => 'Female',
                    'relationship' => 'Daughter',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                    'family_head_name' => $familyHeadName,
                    'pwd' => $resident->daughter_pwd,
                    'pregnant' => false
                ];
                $totalFamilyMembers++;
                if ($resident->daughter_pwd) {
                    $hasPWD = true;
                    $familyPWDCount++;
                }
            }
            
            // Add grandmother
            if ($resident->grandmother_fullname) {
                $familyMembers[] = [
                    'evacuee_id' => $evacuee->id,
                    'fullname' => $resident->grandmother_fullname,
                    'age' => $resident->grandmother_age,
                    'gender' => 'Female',
                    'relationship' => 'Grandmother',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                    'family_head_name' => $familyHeadName,
                    'pwd' => $resident->grandmother_pwd,
                    'pregnant' => false
                ];
                $totalFamilyMembers++;
                if ($resident->grandmother_pwd) {
                    $hasPWD = true;
                    $familyPWDCount++;
                }
            }
            
            // Add grandfather
            if ($resident->grandfather_fullname) {
                $familyMembers[] = [
                    'evacuee_id' => $evacuee->id,
                    'fullname' => $resident->grandfather_fullname,
                    'age' => $resident->grandfather_age,
                    'gender' => 'Male',
                    'relationship' => 'Grandfather',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                    'family_head_name' => $familyHeadName,
                    'pwd' => $resident->grandfather_pwd,
                    'pregnant' => false
                ];
                $totalFamilyMembers++;
                if ($resident->grandfather_pwd) {
                    $hasPWD = true;
                    $familyPWDCount++;
                }
            }
            
            // Add family head entry to evacuees collection
            if ($resident->family_head_fullname) {
                $evacuees->push([
                    'id' => $evacuee->id,
                    'family_head_name' => $familyHeadName,
                    'age' => $resident->family_head_age ?: $resident->price,
                    'gender' => $resident->gender ?? 'Male',
                    'evacuation_status' => $evacuee->evacuation_status,
                    'evacuation_area' => $evacuee->evacuation_area,
                    'room_number' => $evacuee->room_number,
                    'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                    'contact_number' => $resident->contact_number,
                    'purok' => $resident->description,
                    'total_members' => $totalFamilyMembers,
                    'dependent_count' => max(0, $totalFamilyMembers - 1),
                    'has_pregnant' => $hasPregnant,
                    'has_pwd' => $hasPWD,
                    'pregnant_count' => $familyPregnantCount,
                    'pwd_count' => $familyPWDCount,
                    'family_members' => $familyMembers
                ]);
                
                // Update statistics
                foreach ($familyMembers as $member) {
                    $age = (int) $member['age'];
                    if ($age >= 60) {
                        $seniorCount++;
                    } elseif ($age < 18) {
                        $childCount++;
                        if ($age <= 5) {
                            $child0_5Count++;
                        } elseif ($age >= 6 && $age <= 12) {
                            $child6_12Count++;
                        } elseif ($age >= 13 && $age <= 17) {
                            $child13_17Count++;
                        }
                    }
                    
                    if (strtolower($member['gender']) === 'male') {
                        $maleCount++;
                    } else {
                        $femaleCount++;
                    }
                }
            }
        }
        
        // Calculate total evacuees (actual number of individuals)
        $totalEvacuees = $evacuees->count();
        
        // Calculate total family members (including all family members of each evacuee)
        $totalFamilyMembers = $evacuees->sum(function($e) {
            return is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
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
        // Statistics are already calculated above from expanded family members
        $totalCapacity = 0;
        $totalOccupancy = 0;
        
        // Calculate facility statistics
        foreach ($facilities as $facility) {
            $totalCapacity += $facility['capacity'];
            $totalOccupancy += $facility['current_occupancy'];
        }
        
        // Calculate age-appropriate meal requirements using expanded family members
        $dailyMealsNeeded = 0;
        foreach ($evacuees as $evacuee) {
            $age = (int) $evacuee['age'];
            
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
            // Population counts
            'evacuee_count' => $totalEvacuees,
            'total_family_members' => $totalFamilyMembers,
            
            // Food calculations (age-appropriate meals)
            'daily_meals_needed' => $dailyMealsNeeded,
            'weekly_food_requirement' => $dailyMealsNeeded * 7,
            
            // Meal breakdown by age group
            'infant_daily_meals' => $child0_5Count * 6,
            'child_daily_meals' => ($child6_12Count * 5) + ($child13_17Count * 3),
            'teen_daily_meals' => $child13_17Count * 3,
            'adult_daily_meals' => ($totalEvacuees - $childCount - $seniorCount) * 3 + $seniorCount * 3,
            
            // Water calculations (4 liters per person per day)
            'daily_water_requirement' => $totalFamilyMembers * 4,
            'weekly_water_requirement' => $totalFamilyMembers * 28,
            
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
            'hygiene_kits_needed' => max(1, (int) ceil($totalFamilyMembers * 0.8)), // 80% of family members, minimum 1
            'blankets_needed' => max(2, (int) ceil($totalFamilyMembers * 0.7)), // 70% of family members, minimum 2
            'first_aid_kits_needed' => (int) ceil($totalFamilyMembers / 10), // 1 kit per 10 people
            
            // Medical requirements
            'chronic_medication_patients' => (int) ($totalEvacuees * 0.15), // 15% estimate
            'mental_health_sessions_needed' => (int) ($totalEvacuees * 0.2), // 20% estimate
            'pregnant_women_count' => (int) ($totalEvacuees * 0.08), // 8% estimate
            'disabled_persons_count' => (int) ($totalEvacuees * 0.12), // 12% estimate
            
            // Supply levels (simulated based on occupancy rate)
            'food_supply_coverage' => max(30, 100 - ($totalOccupancy / $totalCapacity) * 40), // Inverse relationship
            'medical_supply_level' => max(25, 95 - ($totalOccupancy / $totalCapacity) * 35), // Inverse relationship
            'clothing_inventory_adult' => (int) ($totalFamilyMembers * 0.6),
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

    // Analytics Data API - Updated for Evacuee Analytics
    public function getAnalyticsData(Request $request)
    {
        try {
            // Get unique shelters count (excluding released)
            $totalShelters = Evacuee::where('evacuation_status', '!=', 'Released')->distinct('evacuation_area')->count('evacuation_area');
            
            // Get all evacuees with their resident data (excluding released) and group by family head
            $evacueesData = Evacuee::with('resident')
                ->where('evacuation_status', '!=', 'Released')
                ->get();
            
            $evacuees = collect();
            $seniorCount = 0;
            $childCount = 0;
            $child0_5Count = 0;
            $child6_12Count = 0;
            $child13_17Count = 0;
            $maleCount = 0;
            $femaleCount = 0;
            
            foreach ($evacueesData as $evacuee) {
                $resident = $evacuee->resident;
                
                // Build family members array and group by family head
                $familyMembers = [];
                $familyHeadName = $resident->family_head_fullname ?: ($resident->name . ' ' . $resident->qty);
                $totalFamilyMembers = 0;
                $hasPregnant = false;
                $hasPWD = false;
                
                // Count pregnant women and PWD members for this family
                $familyPregnantCount = 0;
                $familyPWDCount = 0;
                
                // Add family head
                if ($resident->family_head_fullname) {
                    $familyMembers[] = [
                        'evacuee_id' => $evacuee->id,
                        'fullname' => $resident->family_head_fullname,
                        'age' => $resident->family_head_age,
                        'gender' => $resident->gender ?? 'Male',
                        'relationship' => 'Family Head',
                        'evacuation_status' => $evacuee->evacuation_status,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                        'family_head_name' => $familyHeadName,
                        'pwd' => $resident->family_head_pwd,
                        'pregnant' => false
                    ];
                    $totalFamilyMembers++;
                    if ($resident->family_head_pwd) {
                        $hasPWD = true;
                        $familyPWDCount++;
                    }
                }
                
                // Add wife
                if ($resident->wife_fullname) {
                    $familyMembers[] = [
                        'evacuee_id' => $evacuee->id,
                        'fullname' => $resident->wife_fullname,
                        'age' => $resident->wife_age,
                        'gender' => 'Female',
                        'relationship' => 'Wife',
                        'evacuation_status' => $evacuee->evacuation_status,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                        'family_head_name' => $familyHeadName,
                        'pwd' => $resident->wife_pwd,
                        'pregnant' => $resident->wife_pregnant
                    ];
                    $totalFamilyMembers++;
                    if ($resident->wife_pwd) {
                        $hasPWD = true;
                        $familyPWDCount++;
                    }
                    if ($resident->wife_pregnant) {
                        $hasPregnant = true;
                        $familyPregnantCount++;
                    }
                }
                
                // Add son
                if ($resident->son_fullname) {
                    $familyMembers[] = [
                        'evacuee_id' => $evacuee->id,
                        'fullname' => $resident->son_fullname,
                        'age' => $resident->son_age,
                        'gender' => 'Male',
                        'relationship' => 'Son',
                        'evacuation_status' => $evacuee->evacuation_status,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                        'family_head_name' => $familyHeadName,
                        'pwd' => $resident->son_pwd,
                        'pregnant' => false
                    ];
                    $totalFamilyMembers++;
                    if ($resident->son_pwd) {
                        $hasPWD = true;
                        $familyPWDCount++;
                    }
                }
                
                // Add daughter
                if ($resident->daughter_fullname) {
                    $familyMembers[] = [
                        'evacuee_id' => $evacuee->id,
                        'fullname' => $resident->daughter_fullname,
                        'age' => $resident->daughter_age,
                        'gender' => 'Female',
                        'relationship' => 'Daughter',
                        'evacuation_status' => $evacuee->evacuation_status,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                        'family_head_name' => $familyHeadName,
                        'pwd' => $resident->daughter_pwd,
                        'pregnant' => false
                    ];
                    $totalFamilyMembers++;
                    if ($resident->daughter_pwd) {
                        $hasPWD = true;
                        $familyPWDCount++;
                    }
                }
                
                // Add grandmother
                if ($resident->grandmother_fullname) {
                    $familyMembers[] = [
                        'evacuee_id' => $evacuee->id,
                        'fullname' => $resident->grandmother_fullname,
                        'age' => $resident->grandmother_age,
                        'gender' => 'Female',
                        'relationship' => 'Grandmother',
                        'evacuation_status' => $evacuee->evacuation_status,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                        'family_head_name' => $familyHeadName,
                        'pwd' => $resident->grandmother_pwd,
                        'pregnant' => false
                    ];
                    $totalFamilyMembers++;
                    if ($resident->grandmother_pwd) {
                        $hasPWD = true;
                        $familyPWDCount++;
                    }
                }
                
                // Add grandfather
                if ($resident->grandfather_fullname) {
                    $familyMembers[] = [
                        'evacuee_id' => $evacuee->id,
                        'fullname' => $resident->grandfather_fullname,
                        'age' => $resident->grandfather_age,
                        'gender' => 'Male',
                        'relationship' => 'Grandfather',
                        'evacuation_status' => $evacuee->evacuation_status,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                        'family_head_name' => $familyHeadName,
                        'pwd' => $resident->grandfather_pwd,
                        'pregnant' => false
                    ];
                    $totalFamilyMembers++;
                    if ($resident->grandfather_pwd) {
                        $hasPWD = true;
                        $familyPWDCount++;
                    }
                }
                
                // Add family head entry to evacuees collection
                if ($resident->family_head_fullname) {
                    $evacuees->push([
                        'id' => $evacuee->id,
                        'family_head_name' => $familyHeadName,
                        'age' => $resident->family_head_age ?: $resident->price,
                        'gender' => $resident->gender ?? 'Male',
                        'evacuation_status' => $evacuee->evacuation_status,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_date' => $evacuee->evacuation_date ? $evacuee->evacuation_date->format('Y-m-d') : '-',
                        'contact_number' => $resident->contact_number,
                        'purok' => $resident->description,
                        'total_members' => $totalFamilyMembers,
                        'dependent_count' => max(0, $totalFamilyMembers - 1),
                        'has_pregnant' => $hasPregnant,
                        'has_pwd' => $hasPWD,
                        'pregnant_count' => $familyPregnantCount,
                        'pwd_count' => $familyPWDCount,
                        'family_members' => $familyMembers
                    ]);
                    
                    // Update statistics
                    foreach ($familyMembers as $member) {
                        $age = (int) $member['age'];
                        if ($age >= 60) {
                            $seniorCount++;
                        } elseif ($age < 18) {
                            $childCount++;
                            if ($age <= 5) {
                                $child0_5Count++;
                            } elseif ($age >= 6 && $age <= 12) {
                                $child6_12Count++;
                            } elseif ($age >= 13 && $age <= 17) {
                                $child13_17Count++;
                            }
                        }
                        
                        if (strtolower($member['gender']) === 'male') {
                            $maleCount++;
                        } else {
                            $femaleCount++;
                        }
                    }
                }
            }
            
            // Calculate total evacuees (actual number of individuals)
            $totalEvacuees = $evacuees->count();
            
            // Calculate total family members (including all family members of each evacuee)
            $totalFamilyMembers = $evacuees->sum(function($e) {
                return is_array($e) ? ($e['total_members'] ?? 1) : ($e->total_members ?? 1);
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
            // Statistics are already calculated above from expanded family members
            $totalCapacity = 0;
            $totalOccupancy = 0;
            
            // Calculate facility statistics
            foreach ($facilities as $facility) {
                $totalCapacity += $facility['capacity'];
                $totalOccupancy += $facility['current_occupancy'];
            }
            
            // Calculate age-appropriate meal requirements using expanded family members
            $dailyMealsNeeded = 0;
            foreach ($evacuees as $evacuee) {
                $age = (int) $evacuee['age'];
                
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
                // Population counts
                'evacuee_count' => $totalEvacuees,
                'total_family_members' => $totalFamilyMembers,
                
                // Food calculations (age-appropriate meals)
                'daily_meals_needed' => $dailyMealsNeeded,
                'weekly_food_requirement' => $dailyMealsNeeded * 7,
                
                // Meal breakdown by age group
                'infant_daily_meals' => $child0_5Count * 6,
                'child_daily_meals' => ($child6_12Count * 5) + ($child13_17Count * 3),
                'teen_daily_meals' => $child13_17Count * 3,
                'adult_daily_meals' => ($totalEvacuees - $childCount - $seniorCount) * 3 + $seniorCount * 3,
                
                // Water calculations (4 liters per person per day)
                'daily_water_requirement' => $totalFamilyMembers * 4,
                'weekly_water_requirement' => $totalFamilyMembers * 28,
                
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
                'hygiene_kits_needed' => max(1, (int) ceil($totalFamilyMembers * 0.8)), // 80% of family members, minimum 1
                'blankets_needed' => max(2, (int) ceil($totalFamilyMembers * 0.7)), // 70% of family members, minimum 2
                'first_aid_kits_needed' => (int) ceil($totalFamilyMembers / 10), // 1 kit per 10 people
                
                // Medical requirements
                'chronic_medication_patients' => (int) ($totalEvacuees * 0.15), // 15% estimate
                'mental_health_sessions_needed' => (int) ($totalEvacuees * 0.2), // 20% estimate
                'pregnant_women_count' => (int) ($totalEvacuees * 0.08), // 8% estimate
                'disabled_persons_count' => (int) ($totalEvacuees * 0.12), // 12% estimate
                
                // Supply levels (simulated based on occupancy rate)
                'food_supply_coverage' => max(30, 100 - ($totalOccupancy / $totalCapacity) * 40), // Inverse relationship
                'medical_supply_level' => max(25, 95 - ($totalOccupancy / $totalCapacity) * 35), // Inverse relationship
                'clothing_inventory_adult' => (int) ($totalFamilyMembers * 0.6),
                'clothing_inventory_children_0_5' => $child0_5Count,
                'clothing_inventory_children_6_12' => $child6_12Count,
                'clothing_inventory_children_13_17' => $child13_17Count,
                'clothing_inventory_children_total' => $childCount,
            ];
            
            return response()->json([
                'success' => true,
                'evacuees' => $evacuees,
                'facilities' => $facilities,
                'dssMetrics' => $dssMetrics,
                'totalEvacuees' => $totalEvacuees,
                'totalShelters' => $totalShelters
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Analytics data error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving analytics data.'
            ], 500);
        }
    }
    
    /**
     * Get evacuees with contact numbers for SMS distribution
     */
    public function getEvacueesForSMS(Request $request)
    {
        try {
            $evacuationArea = $request->input('evacuation_area');
            
            // Get evacuees data with resident relationships
            $evacueesQuery = Evacuee::with('resident')
                ->where('evacuation_status', '!=', 'Released');
            
            // Filter by evacuation area if provided
            if ($evacuationArea) {
                $evacueesQuery->where('evacuation_area', $evacuationArea);
            }
            
            $evacueesData = $evacueesQuery->get();
            
            $evacuees = [];
            
            foreach ($evacueesData as $evacuee) {
                $resident = $evacuee->resident;
                
                if ($resident && !empty($resident->contact_number)) {
                    $evacuees[] = [
                        'id' => $evacuee->id,
                        'family_head_name' => $resident->family_head_fullname ?? 'Unknown',
                        'contact_number' => $resident->contact_number,
                        'evacuation_area' => $evacuee->evacuation_area,
                        'room_number' => $evacuee->room_number,
                        'evacuation_status' => $evacuee->evacuation_status,
                        'total_members' => $this->calculateTotalFamilyMembers($resident),
                        'purok' => $resident->description ?? '',
                        'has_pregnant' => $resident->wife_pregnant ?? false,
                        'has_pwd' => $this->hasPWDInFamily($resident)
                    ];
                }
            }
            
            // Get unique evacuation areas for dropdown
            $evacuationAreas = Evacuee::where('evacuation_status', '!=', 'Released')
                ->whereNotNull('evacuation_area')
                ->distinct()
                ->pluck('evacuation_area')
                ->sort()
                ->values();
            
            return response()->json([
                'success' => true,
                'evacuees' => $evacuees,
                'evacuation_areas' => $evacuationAreas,
                'total_count' => count($evacuees)
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Get evacuees for SMS error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving evacuee data.'
            ], 500);
        }
    }
}
