<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Official extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'position',
        'purok',
        'contact_number',
        'email',
        'term_start',
        'term_end',
        'is_active',
        'notes',
        'photo_path'
    ];

    protected $dates = [
        'term_start',
        'term_end',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'term_start' => 'date:Y-m-d',
        'term_end' => 'date:Y-m-d',
    ];

    public function getFullNameAttribute()
    {
        return trim("$this->first_name " . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name);
    }
}
