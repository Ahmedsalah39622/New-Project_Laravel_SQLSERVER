<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'specialization'
    ];

    // Define the relationship with appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
