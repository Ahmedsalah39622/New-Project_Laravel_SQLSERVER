<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'ds',
        'heart_failure',
        'stemi',
        'acs',
        'anaemia',
        'chest_infection',
    ];
}
