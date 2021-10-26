<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Portaria;

class PortariaController extends Controller
{
    public function index()
    {
        $search = request('search');//buscar
        if($search){
            $portaria = Portaria::where([
                ['titulo', 'like', '%'.$search.'%']
            ])->get();
        }else{
            $portaria = Portaria::all();
        }
        return view('welcome',['portaria'=> $portaria,'search' => $search]);
    }

    public function create(){
        return view('portarias.create');
    }

    public function store(Request $request){
        $portaria = new Portaria;

        try{
        $portaria->numPortaria = $request->numPortaria;
        $portaria->titulo = $request->titulo;
        $portaria->descricao = $request->descricao;
        $portaria->dataInicial = $request->dataInicial;
        $portaria->dataFinal = $request->dataFinal;
        $portaria->tipo = $request->tipo;

        $portaria->save();
        return redirect(route('home'));
        }catch(QueryException $e){
            return redirect()->back();
        }
    }
}
