<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Portaria;
use Illuminate\Support\Facades\DB;

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
            $portaria = Portaria::orderBy('created_at','desc')->get();//ordenando a ultima criada 

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



        //relação ony to many
        $user = auth()->user();
        $portaria->user_id = $user->id;

        $portaria->save();
        return redirect('/')->with('msg','Portaria criada com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->withErrors('Não foi possivel criar a Portaria!');
        }
    }
    public function myportarias(){
        $user = auth()->user();
        $portaria = $user->portarias;

        return view('portarias.myportarias',['portaria' => $portaria]);
    }

    public function destroy($id){
        $portaria = Portaria::find($id);
        try{
            $portaria->delete();
            return redirect()->back()->with('msg','Portaria excluída com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->withErrors('Não foi possivel deletar a portaria!');
        }
    }
    
    public function edit($id){

        $portaria = Portaria::findOrFail($id);
        //dd($portaria->id);

        return view('portarias.edit',['portaria' => $portaria]);

    }
    
    public function update(Request $request){

        try{
            Portaria::findOrFail($request->id)->update($request->all());
            return redirect('/portaria/myportarias')->with('msg','Portaria editada com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->withErrors('Não foi possível editar a portaria!');
        }

    }
}



