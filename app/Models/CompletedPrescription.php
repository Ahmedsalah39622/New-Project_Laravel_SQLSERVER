<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedPrescription extends Model
{
    use HasFactory;

    protected $table = 'completed_prescriptions';

    protected $fillable = [
        'appointment_id',
        'drugs',
        'dosage',
        'notes',
    ];
}
