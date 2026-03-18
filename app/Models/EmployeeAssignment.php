<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssignment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'employee_id',
        'evacuation_center',
        'status',
        'responsibilities',
        'notes'
    ];
    
    protected $casts = [
        'status' => 'string',
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 'active':
                return 'Active';
            case 'completed':
                return 'Completed';
            case 'cancelled':
                return 'Cancelled';
            default:
                return 'Unknown';
        }
    }
    
    public function getStatusColor()
    {
        switch ($this->status) {
            case 'active':
                return '#16a34a'; // green
            case 'completed':
                return '#6b7280'; // gray
            case 'cancelled':
                return '#dc2626'; // red
            default:
                return '#6b7280'; // gray
        }
    }
    
    public function getShiftLabel()
    {
        switch ($this->shift) {
            case 'morning':
                return 'Morning (6AM - 2PM)';
            case 'afternoon':
                return 'Afternoon (2PM - 10PM)';
            case 'night':
                return 'Night (10PM - 6AM)';
            default:
                return ucfirst($this->shift);
        }
    }
}
