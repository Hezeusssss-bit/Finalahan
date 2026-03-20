<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'status',
        'capacity',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the status label with proper formatting
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Get the status color for display
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => '#d4edda',
            'maintenance' => '#fff3cd',
            'unavailable' => '#f8d7da',
            default => '#e9ecef',
        };
    }

    /**
     * Get the text color for the status
     */
    public function getStatusTextColorAttribute()
    {
        return match($this->status) {
            'available' => '#155724',
            'maintenance' => '#856404',
            'unavailable' => '#721c24',
            default => '#495057',
        };
    }
}
