<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'action',
        'description',
        'module',
        'performed_by',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get recent activity logs
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
    
    /**
     * Get activity logs by module
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }
    
    /**
     * Get activity logs by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
