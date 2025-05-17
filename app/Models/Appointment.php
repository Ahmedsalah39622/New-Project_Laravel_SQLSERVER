<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments'; // Ensure it matches your table name

    protected $fillable = [
        'patient_id',
       'date',
       'time',
        'status',
        'doctor_name',
        'doctor_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'appointment_date',
        'start_time',
       'end_time',
       'paid_status',
        'selected_symptoms',
        'patient_id',
        'blood_type',
        'email',
    ];

    // Define the relationship with the Doctor model
public function doctor()
{
    return $this->belongsTo(Doctor::class);
}

public function patient()
{
    return $this->belongsTo(\App\Models\Patient::class, 'email', 'email');
}


}
