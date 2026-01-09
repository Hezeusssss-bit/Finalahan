<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
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
        // You can add facilities data here in the future
        $totalFacilities = 0; // Placeholder for now
        return view('Facility.facilities', compact('totalFacilities'));
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
     * Log system activity
     */
    private function logActivity($type, $description)
    {
        // Store activity in session for now (you can later move to database)
        $activities = session('system_activities', []);
        
        $activity = [
            'type' => $type,
            'description' => $description,
            'timestamp' => now(),
            'time_ago' => 'just now'
        ];
        
        // Add to beginning of array
        array_unshift($activities, $activity);
        
        // Keep only last 20 activities
        $activities = array_slice($activities, 0, 20);
        
        session(['system_activities' => $activities]);
    }

    /**
     * Get recent activities for dashboard
     */
    private function getRecentActivities()
    {
        $activities = session('system_activities', []);
        
        // If no activities, return some default ones
        if (empty($activities)) {
            return [
                [
                    'type' => 'system',
                    'description' => 'System backup completed',
                    'time_ago' => '1 day ago',
                    'color' => '#17a2b8'
                ],
                [
                    'type' => 'system',
                    'description' => 'Database maintenance',
                    'time_ago' => '3 days ago',
                    'color' => '#6c757d'
                ]
            ];
        }
        
        // Add time formatting to activities
        foreach ($activities as &$activity) {
            $activity['time_ago'] = $this->formatTimeAgo($activity['timestamp']);
            $activity['color'] = $this->getActivityColor($activity['type']);
        }
        
        return $activities;
    }

    /**
     * Format timestamp to human readable time ago
     */
    private function formatTimeAgo($timestamp)
    {
        $now = now();
        $diff = $now->diffInMinutes($timestamp);
        
        if ($diff < 1) {
            return 'just now';
        } elseif ($diff < 60) {
            return $diff . ' minutes ago';
        } elseif ($diff < 1440) {
            return floor($diff / 60) . ' hours ago';
        } else {
            return floor($diff / 1440) . ' days ago';
        }
    }

    /**
     * Get color for activity type
     */
    private function getActivityColor($type)
    {
        $colors = [
            'resident_added' => '#28a745',
            'resident_updated' => '#ffc107',
            'resident_deleted' => '#dc3545',
            'system' => '#17a2b8',
            'login' => '#6c757d'
        ];
        
        return $colors[$type] ?? '#6c757d';
    }
}
