<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display the activity logs page
     */
    public function index()
    {
        $recentLogs = ActivityLog::recent(30)->orderBy('created_at', 'desc')->get();
        $programLogs = ActivityLog::byModule('Programs')->orderBy('created_at', 'desc')->get();
        $employeeLogs = ActivityLog::byModule('Employee')->orderBy('created_at', 'desc')->get();
        $systemLogs = ActivityLog::byModule('System')->orderBy('created_at', 'desc')->get();
        
        return view('Activity Logs.activity_logs', compact(
            'recentLogs', 
            'programLogs', 
            'employeeLogs', 
            'systemLogs'
        ));
    }
    
    /**
     * Store a new activity log
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'module' => 'required|string|max:100',
            'performed_by' => 'required|string|max:255',
        ]);
        
        ActivityLog::create($validated);
        
        return response()->json(['message' => 'Activity log created successfully']);
    }
    
    /**
     * Get activity logs by module
     */
    public function getByModule($module)
    {
        $logs = ActivityLog::byModule($module)->orderBy('created_at', 'desc')->get();
        return response()->json($logs);
    }
    
    /**
     * Get all activity logs for real-time updates
     */
    public function getAllLogs()
    {
        $recentLogs = ActivityLog::recent(30)->orderBy('created_at', 'desc')->get();
        $programLogs = ActivityLog::byModule('Programs')->orderBy('created_at', 'desc')->get();
        $employeeLogs = ActivityLog::byModule('Employee')->orderBy('created_at', 'desc')->get();
        $systemLogs = ActivityLog::byModule('System')->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'recentLogs' => $recentLogs,
            'programLogs' => $programLogs,
            'employeeLogs' => $employeeLogs,
            'systemLogs' => $systemLogs
        ]);
    }
    
    /**
     * Clear old activity logs
     */
    public function clearOldLogs($days = 90)
    {
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();
        
        return response()->json([
            'message' => "Cleared {$deleted} old activity logs older than {$days} days"
        ]);
    }
}
