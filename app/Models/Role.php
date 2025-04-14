<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // Define the relationship with the User model
    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // Ensure 'role_id' matches your database column
    }
}
