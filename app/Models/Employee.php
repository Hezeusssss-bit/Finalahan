<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'department',
        'contact_number',
        'address',
        'status',
        'hire_date',
    ];
    
    protected $dates = [
        'hire_date',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'hire_date' => 'date',
    ];
    
    /**
     * Get status label for display
     */
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 'active':
                return 'Active';
            case 'inactive':
                return 'Inactive';
            case 'on_leave':
                return 'On Leave';
            default:
                return 'Unknown';
        }
    }
    
    /**
     * Get status color for display
     */
    public function getStatusColor()
    {
        switch ($this->status) {
            case 'active':
                return '#16a34a'; // green
            case 'inactive':
                return '#6b7280'; // gray
            case 'on_leave':
                return '#d97706'; // amber
            default:
                return '#6b7280'; // gray
        }
    }
}
