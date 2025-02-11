<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class login extends Controller
{
  public function index()
  {
    return view('auth.login');
  }
}
