<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    // Specify the table if different from the model name
    // protected $table = 'doctors';

    // Define fillable properties for mass assignment
    protected $fillable = [
        'name', 'specialty', 'email', // add other fields as necessary
    ];
}

