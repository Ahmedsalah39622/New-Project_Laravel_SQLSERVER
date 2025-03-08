<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SomeController extends Controller
{
    public function someMethod(Request $request)
    {
        // ...existing code...

        if ($request->user()->hasAnyRole(['admin', 'doctor', 'patient'])) {
            // Do something for users with any of the specified roles
        }

        // ...existing code...
    }
}
