<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortariaController extends Controller
{
    public function index()
    {
        return view('portaria');
    }
}
