<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Servidor;
use App\Models\ServidorPortaria;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {   
        $user = Servidor::all();
        return view('relatorios.options')->with( 'users', $user);
    }

    public function servidorIndividual(Request $request){
        $id = $request->id_servidor;
        $servidor = Servidor::find($id);
        $portaria = new ServidorPortaria;
        //dd($servidor);
        return view('relatorios.individual')
               ->with( 'servidor', $servidor)
               ->with('portaria', $portaria);
    }

    public function rankingServidores(){
        $servidores = Servidor::orderBy('servidores.nome', 'asc')->get();
        $portaria = new ServidorPortaria;
        return view('relatorios.ranking')
            ->with('servidores', $servidores)
            ->with('portaria', $portaria);
    }

    public function relatorioGeral(){
        
        $dataAtual = date('Y-m-d');

        $total = DB::select("SELECT COUNT(id) AS quantidade FROM portarias");
        $temporarias = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE tipo = 0");
        $permanentes = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE tipo = 1");
        $ativas = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE ((tipo = 0 AND dataFinal >= '$dataAtual') OR (tipo = 1 AND permaStatus = 0))");
        $inativas = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE ((tipo = 0 AND dataFinal < '$dataAtual') OR (tipo = 1 AND permaStatus = 1))");
        $campus = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE origem = 'Campus'");
        $reitoria = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE origem = 'Reitoria'");
        $sigilosas = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE sigilo = 1");
        $publicas = DB::select("SELECT COUNT(id) AS quantidade FROM portarias WHERE sigilo = 0");

        if($total[0]->quantidade == 0){
            $porcentTemp = 0;
            $porcentPerm = 0;
            $porcentAtivas = 0;
            $porcentInativas = 0;
            $porcentReitoria = 0;
            $porcentCampus = 0;
            $porcentSigilosas = 0;
            $porcentPublicas = 0;
        }else{
            $porcentTemp = $temporarias[0]->quantidade/$total[0]->quantidade*100;
            $porcentPerm = $permanentes[0]->quantidade/$total[0]->quantidade*100;
            $porcentAtivas = $ativas[0]->quantidade/$total[0]->quantidade*100;
            $porcentInativas = $inativas[0]->quantidade/$total[0]->quantidade*100;
            $porcentReitoria = $reitoria[0]->quantidade/$total[0]->quantidade*100;
            $porcentCampus = $campus[0]->quantidade/$total[0]->quantidade*100;
            $porcentSigilosas = $sigilosas[0]->quantidade/$total[0]->quantidade*100;
            $porcentPublicas = $publicas[0]->quantidade/$total[0]->quantidade*100;
        }

        $porcentagem = array(
            "porcentTemp" => number_format($porcentTemp, 2, '.', ''),
            "porcentPerm" =>  number_format($porcentPerm, 2, '.', ''),
            "porcentAtivas" =>  number_format($porcentAtivas, 2, '.', ''),
            "porcentInativas" =>  number_format($porcentInativas, 2, '.', ''),
            "porcentCampus" =>  number_format($porcentCampus, 2, '.', ''),
            "porcentReitoria" =>  number_format($porcentReitoria, 2, '.', ''),
            "porcentSigilosas" =>  number_format($porcentSigilosas, 2, '.', ''),
            "porcentPublicas" =>  number_format($porcentPublicas, 2, '.', ''),
        );


          
        //dd($total);
        return view('relatorios.relatorioGeral')
            ->with('total', $total)
            ->with('temporarias', $temporarias)
            ->with('permanentes', $permanentes)
            ->with('ativas', $ativas)
            ->with('inativas', $inativas)
            ->with('campus', $campus)
            ->with('reitoria', $reitoria)
            ->with('sigilosas', $sigilosas)
            ->with('publicas', $publicas)
            ->with('porcentagem', $porcentagem);
    }
}
