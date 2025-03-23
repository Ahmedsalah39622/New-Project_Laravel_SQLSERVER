<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments'; // Ensure it matches your table name

    protected $fillable = [
        'doctor_id',
        'doctor_name',
        'patient_name',
        'patient_email',
        'patient_phone',
        'appointment_date',
        'start_time',
        'status',
        'selected_symptoms',
    ];

    // Define the relationship with the Doctor model
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function booted()
    {
        static::creating(function ($appointment) {
            $doctor = Doctor::find($appointment->doctor_id);
            $appointment->doctor_name = $doctor->name;
        });
    }
}
