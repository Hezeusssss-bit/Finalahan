<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display the program management page
     */
    public function index()
    {
        // Get programs by status
        $upcomingPrograms = Program::upcoming()->orderBy('start_date', 'asc')->get();
        $ongoingPrograms = Program::ongoing()->orderBy('start_date', 'asc')->get();
        $completedPrograms = Program::completed()->orderBy('end_date', 'desc')->get();
        
        return view('Program.program', compact('upcomingPrograms', 'ongoingPrograms', 'completedPrograms'));
    }
    
    /**
     * Store a new program
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);
        
        // Status will be automatically set by the model
        $program = Program::create($validated);
        
        return redirect()->route('program.index')->with('Success', 'Program added successfully!');
    }
    
    /**
     * Update a program
     */
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);
        
        $program->update($validated);
        
        return redirect()->route('program.index')->with('Success', 'Program updated successfully!');
    }
    
    /**
     * Delete a program
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();
        
        return redirect()->route('program.index')->with('Success', 'Program deleted successfully!');
    }
    
    /**
     * Get program data for AJAX requests
     */
    public function getProgram($id)
    {
        $program = Program::findOrFail($id);
        return response()->json($program);
    }
    
    /**
     * Update all program statuses (can be called via cron job or scheduled task)
     */
    public function updateAllStatuses()
    {
        $programs = Program::all();
        
        foreach ($programs as $program) {
            $program->updateStatusAutomatically();
            $program->save();
        }
        
        return response()->json(['message' => 'All program statuses updated successfully']);
    }
}
