<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portaria;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function welcomeShow()
    {   
        $portaria = Portaria::paginate(10);

        return view('home')->with('portarias', $portaria);
    }
}
