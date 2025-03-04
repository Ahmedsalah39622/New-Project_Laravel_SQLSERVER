<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments'; // Ensure it matches your table name

    protected $fillable = [
        'doctor_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
    ];

    // Define the relationship with the Doctor model
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
