<?php

namespace App\Http\Controllers;

use App\Models\Official;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officials = Official::withTrashed()
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
            
        return view('Officials.officials', compact('officials', 'captains', 'kagawads', 'otherOfficials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'purok' => 'nullable|string|max:100',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'term_start' => 'required|date',
            'term_end' => 'required|date|after_or_equal:term_start',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // 2MB max
        ]);

        $data = $request->except('photo');
        $data['is_active'] = $request->has('is_active');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('officials', 'public');
            $data['photo_path'] = $path;
        }

        $official = Official::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Official added successfully',
            'data' => $official
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $official = Official::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'purok' => 'nullable|string|max:100',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'term_start' => 'required|date',
            'term_end' => 'required|date|after_or_equal:term_start',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');
        $data['is_active'] = $request->has('is_active');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($official->photo_path) {
                Storage::disk('public')->delete($official->photo_path);
            }
            $path = $request->file('photo')->store('officials', 'public');
            $data['photo_path'] = $path;
        }

        $official->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Official updated successfully',
            'data' => $official
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $official = Official::withTrashed()->findOrFail($id);
        
        if ($official->trashed()) {
            // Permanently delete if already soft-deleted
            if ($official->photo_path) {
                Storage::disk('public')->delete($official->photo_path);
            }
            $official->forceDelete();
            $message = 'Official permanently deleted successfully';
        } else {
            // Soft delete
            $official->delete();
            $message = 'Official archived successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
    
    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $official = Official::withTrashed()->findOrFail($id);
        $official->restore();
        
        return response()->json([
            'success' => true,
            'message' => 'Official restored successfully',
            'data' => $official
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $official = Official::withTrashed()->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $official
        ]);
    }
    
    /**
     * Get the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'formData' => [
                'positions' => [
                    'Captain',
                    'Kagawad',
                    'Secretary',
                    'Treasurer',
                    'SK Chairman',
                    'SK Kagawad'
                ],
                'puroks' => [
                    'Purok I', 'Purok II', 'Purok III', 'Purok IV', 'Purok V',
                    'Purok VI', 'Purok VII', 'Purok VIII', 'Purok IX', 'Purok X'
                ]
            ]
        ]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $official = Official::withTrashed()->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $official
        ]);
    }
}
