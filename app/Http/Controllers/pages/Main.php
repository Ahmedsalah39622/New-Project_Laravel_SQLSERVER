<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Main extends Controller
{
  public function index()
  {
    return view('content.main.pages-lifeline');
  }
}
