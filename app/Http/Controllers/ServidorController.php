<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Servidor;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;

class ServidorController extends Controller
{
    public function index()
    {
        $servidores = Servidor::paginate(10);

        return view('servidores.show')->with('servidor', $servidores);
    }

    public function create(){
        return view('servidores.create');
    }

    public function store(Request $request){
        $servidor = new Servidor;

        try{
            $servidor->nome = $request->nome;
            $servidor->sobrenome = $request->sobrenome;
            $servidor->email = $request->email;
            $servidor->cargo = $request->cargo;

            //uploard do doc
            $servidor->save();
            return redirect('/')->with('msg','Servidor adicionado com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao criar servidor!');
        }
    }

    public function destroy($id){
        $servidor = Servidor::find($id);
        try{
            $servidor->delete();
            return redirect()->back()->with('msg','Servidor excluído com sucesso!!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao excluir!');
        }
    }

    public function edit($id){

        $servidor = Servidor::findOrFail($id);
        //dd($portaria->id);

        return view('servidores.edit',['servidor' => $servidor]);

    }
    
    public function update(Request $request){
        try{
        Servidor::findOrFail($request->id)->update($request->all());
        return redirect('/servidor/show')->with('msg','Servidor editado com sucesso!');
        }catch(QueryException $e){
        return redirect('/servidor/show')->with('msgE','Erro ao editar servidor!');
        }
    }

}
