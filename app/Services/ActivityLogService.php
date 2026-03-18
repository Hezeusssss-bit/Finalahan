<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    /**
     * Log an activity
     *
     * @param string $action
     * @param string $description
     * @param string $module
     * @param string $performedBy
     * @return ActivityLog
     */
    public function log($action, $description, $module, $performedBy = 'System')
    {
        return ActivityLog::create([
            'action' => $action,
            'description' => $description,
            'module' => $module,
            'performed_by' => $performedBy,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Log a program-related activity
     *
     * @param string $action
     * @param string $description
     * @param string $performedBy
     * @return ActivityLog
     */
    public function logProgramActivity($action, $description, $performedBy = 'System')
    {
        return $this->log($action, $description, 'Programs', $performedBy);
    }

    /**
     * Log an employee-related activity
     *
     * @param string $action
     * @param string $description
     * @param string $performedBy
     * @return ActivityLog
     */
    public function logEmployeeActivity($action, $description, $performedBy = 'System')
    {
        return $this->log($action, $description, 'Employee', $performedBy);
    }

    /**
     * Log a system-related activity
     *
     * @param string $action
     * @param string $description
     * @param string $performedBy
     * @return ActivityLog
     */
    public function logSystemActivity($action, $description, $performedBy = 'System')
    {
        return $this->log($action, $description, 'System', $performedBy);
    }

    /**
     * Get recent activity logs
     *
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentLogs($days = 7)
    {
        return ActivityLog::recent($days)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get activity logs by module
     *
     * @param string $module
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLogsByModule($module)
    {
        return ActivityLog::byModule($module)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Clear old activity logs
     *
     * @param int $days
     * @return int Number of deleted records
     */
    public function clearOldLogs($days = 90)
    {
        return ActivityLog::where('created_at', '<', now()->subDays($days))->delete();
    }
}
