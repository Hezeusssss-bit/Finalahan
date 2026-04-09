<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Official;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $officials = Official::query()
            ->orderByRaw("CASE 
                WHEN position = 'Captain' THEN 1 
                WHEN position = 'Secretary' THEN 2 
                WHEN position = 'Treasurer' THEN 3 
                WHEN position LIKE 'Kagawad%' THEN 4 
                ELSE 5 
            END")
            ->orderBy('position')
            ->orderBy('purok')
            ->get();
            
        // Separate officials by position
        $captains = $officials->filter(function($official) {
            return str_contains($official->position, 'Captain');
        });
        $kagawads = $officials->filter(function($official) {
            return str_contains($official->position, 'Kagawad');
        });
        $otherOfficials = $officials->filter(function($official) {
            return !str_contains($official->position, 'Captain') && !str_contains($official->position, 'Kagawad');
        });
        
        // Get current counts for validation display
        $currentCaptainsCount = $captains->count();
        $currentKagawadsCount = $kagawads->count();
        
        return view('Services.services', compact(
            'officials', 
            'captains', 
            'kagawads', 
            'otherOfficials',
            'currentCaptainsCount',
            'currentKagawadsCount'
        ));
    }

    public function storeOfficial(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'term_start' => 'required|date',
            'term_end' => 'required|date|after:term_start',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        // Check limits
        if ($request->position === 'Captain') {
            $existingCaptains = Official::where('position', 'Captain')->whereNull('deleted_at')->count();
            if ($existingCaptains >= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only 1 Barangay Captain is allowed. There is already an active captain.'
                ], 422);
            }
        }

        if ($request->position === 'Kagawad') {
            $existingKagawads = Official::where('position', 'Kagawad')->whereNull('deleted_at')->count();
            if ($existingKagawads >= 7) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only 7 Kagawad officials are allowed. Maximum limit reached.'
                ], 422);
            }
        }

        $official = Official::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'position' => $request->position,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'term_start' => $request->term_start,
            'term_end' => $request->term_end,
            'is_active' => $request->has('is_active'),
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Official added successfully!',
            'official' => $official
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'schedule' => 'nullable|array',
            'requirements' => 'nullable|array'
        ]);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
            'schedule' => $request->schedule,
            'requirements' => $request->requirements
        ]);

        return redirect()->route('services')
            ->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully!'
        ]);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        
        $services = Service::query()
            ->when($query, function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($category, function($q) use ($category) {
                $q->where('category', $category);
            })
            ->latest()
            ->get();

        return response()->json([
            'services' => $services
        ]);
    }

    public function updateOfficial(Request $request, Official $official)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'term_start' => 'required|date',
            'term_end' => 'required|date|after:term_start',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        // Check limits for position changes
        if ($request->position !== $official->position) {
            if ($request->position === 'Captain') {
                $existingCaptains = Official::where('position', 'Captain')
                    ->where('id', '!=', $official->id)
                    ->whereNull('deleted_at')
                    ->count();
                if ($existingCaptains >= 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only 1 Barangay Captain is allowed. There is already an active captain.'
                    ], 422);
                }
            }

            if ($request->position === 'Kagawad') {
                $existingKagawads = Official::where('position', 'Kagawad')
                    ->where('id', '!=', $official->id)
                    ->whereNull('deleted_at')
                    ->count();
                if ($existingKagawads >= 7) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only 7 Kagawad officials are allowed. Maximum limit reached.'
                    ], 422);
                }
            }
        }

        $official->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'position' => $request->position,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'term_start' => $request->term_start,
            'term_end' => $request->term_end,
            'is_active' => $request->has('is_active'),
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Official updated successfully!',
            'official' => $official
        ]);
    }

    public function deleteOfficial(Official $official)
    {
        $official->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Official deleted successfully!'
        ]);
    }

    public function getOfficial(Official $official)
    {
        return response()->json($official);
    }
}
