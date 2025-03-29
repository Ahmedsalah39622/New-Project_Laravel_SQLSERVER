<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedPrescription extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural of the model name
    protected $table = 'completed_prescriptions';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'drugs',
        'dosage',
        'notes',
        'date_issued',
        'due_date',
    ];

    // Define relationships if needed

    /**
     * Get the patient associated with the prescription.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get the doctor associated with the prescription.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
