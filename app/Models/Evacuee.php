<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evacuee extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'resident_id',
        'purok',
        'evacuation_status',
        'evacuation_area',
        'room_number',
        'program_received',
        'evacuation_date',
        'return_date',
        'notes'
    ];
    
    protected $casts = [
        'program_received' => 'boolean',
        'evacuation_date' => 'date',
        'return_date' => 'date',
    ];
    
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
