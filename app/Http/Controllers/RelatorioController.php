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

    public function servidorEscolha(){
        $user = User::all();
        //dd($relatorios);
        return view('relatorios.escolha')->with( 'users', $user);
    }

    public function servidorIndividual($id){
        $user = User::find($id);
        //dd($relatorios);
        return view('relatorios.escolha')->with( 'users', $user);
    }

    public function rankingServidores(){
        $servidores = User::all();

        return view('relatorios.ranking')
            ->with('servidores', $servidores);
    }
}
