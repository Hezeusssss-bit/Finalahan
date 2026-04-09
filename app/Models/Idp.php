<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idp extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name', 
        'middle_name', 
        'last_name', 
        'suffix', 
        'age', 
        'gender', 
        'birth_date', 
        'contact_number', 
        'original_address', 
        'displacement_date', 
        'facility', 
        'occupation', 
        'education_level', 
        'has_special_needs', 
        'special_needs_details',
        'return_date',
        'relocation_address',
    ];
    
    protected $casts = [
        'birth_date' => 'date',
        'displacement_date' => 'date',
        'return_date' => 'datetime',
        'has_special_needs' => 'boolean',
    ];
    
        
        
    public function getFullNameAttribute()
    {
        $name = $this->first_name . ' ' . $this->last_name;
        
        if ($this->middle_name) {
            $name = $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
        }
        
        if ($this->suffix) {
            $name .= ' ' . $this->suffix;
        }
        
        return $name;
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeByFacility($query, $facilityId)
    {
        return $query->where('facility_id', $facilityId);
    }
}
