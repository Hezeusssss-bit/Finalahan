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
        'qty', // Lastname
        'price', // Age
        'description', // Address
        'gender',
        'contact_number'
    ];
}
