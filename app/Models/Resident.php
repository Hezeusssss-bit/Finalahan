<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $table = 'residents';

    protected $fillable = [
        'name',
        'qty', // Lastname (for backward compatibility)
        'price', // Age (for backward compatibility)
        'description', // Address/Purok
        'gender',
        'contact_number',
        'family_head_fullname',
        'family_head_age',
        'family_head_birthdate',
        'family_head_pwd',
        'wife_fullname',
        'wife_age',
        'wife_birthdate',
        'wife_pregnant',
        'wife_pwd',
        'pwd_in_family',
        'son_fullname',
        'son_age',
        'son_birthdate',
        'son_pwd',
        'daughter_fullname',
        'daughter_age',
        'daughter_birthdate',
        'daughter_pwd',
        'grandmother_fullname',
        'grandmother_age',
        'grandmother_birthdate',
        'grandmother_pwd',
        'grandfather_fullname',
        'grandfather_age',
        'grandfather_birthdate',
        'grandfather_pwd'
    ];

    protected $casts = [
        'wife_pregnant' => 'boolean',
        'family_head_pwd' => 'boolean',
        'wife_pwd' => 'boolean',
        'son_pwd' => 'boolean',
        'daughter_pwd' => 'boolean',
        'grandmother_pwd' => 'boolean',
        'grandfather_pwd' => 'boolean',
        'family_head_birthdate' => 'date',
        'wife_birthdate' => 'date',
        'son_birthdate' => 'date',
        'daughter_birthdate' => 'date',
        'grandmother_birthdate' => 'date',
        'grandfather_birthdate' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
