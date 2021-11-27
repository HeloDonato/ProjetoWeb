<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {   
        return view('relatorios.options');
    }

    public function showrelatorio(){
        $user = User::find(2);
        $relatorios = $user->portariaServidors(2);
        $ccount = $user->portariaServidors(2)->count();
    //dd($relatorios);
        return view('servidores.showrelatorio')->with('relatorios', $relatorios)->with( 'user', $user)->with('count', $ccount);
    }

    public function rankingServidores(){
        $servidores = User::all();

        return view('relatorios.ranking')
            ->with('servidores', $servidores);
    }
}
