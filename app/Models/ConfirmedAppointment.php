<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmedAppointment extends Model
{
    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'patient_name',
        'patient_email',
        'appointment_date',
        'start_time',
        'status',
        'confirmed_at',
        'confirmed_by'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime',
        'confirmed_at' => 'datetime'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function originalAppointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function confirmedByUser()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
