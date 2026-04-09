<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idp;
use App\Models\Facility;
use Carbon\Carbon;

class IdpController extends Controller
{
    public function index()
    {
        $idps = Idp::all();
        $totalIdps = Idp::count();
        $thisMonthIdps = Idp::whereMonth('displacement_date', Carbon::now()->month)
                            ->whereYear('displacement_date', Carbon::now()->year)
                            ->count();
        
        return view('products.idp', compact('idps', 'totalIdps', 'thisMonthIdps'));
    }
    
    public function create()
    {
        $facilities = Facility::all();
        return view('products.idp-create', compact('facilities'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'nullable|date',
            'contact_number' => 'nullable|string|max:20',
            'original_address' => 'required|string',
            'displacement_date' => 'required|date',
            'facility' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'has_special_needs' => 'boolean',
            'special_needs_details' => 'nullable|string',
        ]);
        
        $idp = Idp::create($validated);
        
        // Return JSON for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'IDP record created successfully!',
                'idp' => $idp
            ]);
        }
        
        return redirect()->route('idps')->with('success', 'IDP record created successfully!');
    }
    
    public function edit(Idp $idp)
    {
        $facilities = Facility::all();
        return view('products.idp-edit', compact('idp', 'facilities'));
    }
    
    public function update(Request $request, Idp $idp)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'nullable|date',
            'contact_number' => 'nullable|string|max:20',
            'original_address' => 'required|string',
            'displacement_date' => 'required|date',
            'facility' => 'nullable|string|max:255',
            'return_date' => 'nullable|date',
            'relocation_address' => 'nullable|string',
            'occupation' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'has_special_needs' => 'boolean',
            'special_needs_details' => 'nullable|string',
        ]);
        
        $idp->update($validated);
        
        // Return JSON for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'IDP record updated successfully!',
                'idp' => $idp
            ]);
        }
        
        return redirect()->route('idps')->with('success', 'IDP record updated successfully!');
    }
    
    public function destroy(Idp $idp)
    {
        $idp->delete();
        
        // Always return JSON for DELETE requests (AJAX)
        return response()->json([
            'success' => true,
            'message' => 'IDP record released successfully!'
        ]);
    }
    
    public function show(Idp $idp)
    {
        try {
            // Always return JSON with success flag for AJAX requests
            return response()->json([
                'success' => true,
                'data' => $idp
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'IDP not found or error loading data: ' . $e->getMessage()
            ], 404);
        }
    }
    
    public function updateStatus(Request $request, Idp $idp)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,relocated,returned,rehabilitated',
            'return_date' => 'nullable|date|required_if:status,returned',
            'relocation_address' => 'nullable|string|required_if:status,relocated',
        ]);
        
        $idp->update($validated);
        
        return redirect()->route('idps')->with('success', 'IDP status updated successfully!');
    }
}
