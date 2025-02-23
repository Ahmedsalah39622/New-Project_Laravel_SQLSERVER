<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatedAppointment extends Model
{
    use HasFactory;

    protected $table = 'created_appointments'; // تحديد اسم الجدول

    protected $fillable = [
        'doctor_id',
        'date',
        'time',
        'patient_name',
        'patient_email',
        'patient_phone',
        'is_available',
        'status'
    ];

    // العلاقة مع الطبيب
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
