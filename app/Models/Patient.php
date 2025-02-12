<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient'; // Ensure it matches your database table name

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'age',
        'gender',
        'blood_type',
        'insurance_provider'
    ];
}
