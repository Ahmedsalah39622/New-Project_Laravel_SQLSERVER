<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients'; // Ensure it matches your database table name

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address', // Add relevant fields
    ];

    // Define relationships if necessary
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
