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
        $user = User::all();
        return view('relatorios.options')->with( 'users', $user);
    }

    public function servidorIndividual(Request $request){
        $id = $request->id_servidor;
        $servidor = User::find($id);
        //dd($servidor);
        return view('relatorios.individual')->with( 'servidor', $servidor);
    }

    public function rankingServidores(){
        $servidores = User::orderBy('nome', 'asc')->get();

        return view('relatorios.ranking')
            ->with('servidores', $servidores);
    }

    public function relatorioGeral(){
        
        $dataAtual = date('Y-m-d');

        $total = DB::select("SELECT COUNT(id) AS quantidade FROM portarias");
        $temporarias = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE tipo = 0");
        $permanentes = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE tipo = 1");
        $ativas = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE ((tipo = 0 AND dataFinal >= '$dataAtual') OR (tipo = 1 AND permaStatus = 0))");
        $inativas = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE ((tipo = 0 AND dataFinal < '$dataAtual') OR (tipo = 1 AND permaStatus = 1))");
        $porcentTemp = $temporarias[0]->quantidade/$total[0]->quantidade*100;
        $porcentPerm = $permanentes[0]->quantidade/$total[0]->quantidade*100;
        $porcentAtivas = $ativas[0]->quantidade/$total[0]->quantidade*100;
        $porcentInativas = $inativas[0]->quantidade/$total[0]->quantidade*100;
          
        //dd($total);
        return view('relatorios.relatorioGeral')
            ->with('total', $total)
            ->with('temporarias', $temporarias)
            ->with('permanentes', $permanentes)
            ->with('ativas', $ativas)
            ->with('inativas', $inativas)
            ->with('porcentT', $porcentTemp)
            ->with('porcentP', $porcentPerm)
            ->with('porcentA', $porcentAtivas)
            ->with('porcentI', $porcentInativas);
    }
}
