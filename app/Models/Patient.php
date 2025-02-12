<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'patients';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'user_id', // Foreign key linking the user
        'name',
        'email',
        'age',
        'gender',
        'blood_type',
        'insurance_provider',
    ];
}
