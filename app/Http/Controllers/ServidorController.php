<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;

class ServidorController extends Controller
{
    public function index()
    {
        $search = request('search');//buscar
        if($search){
            $servidores = Servidor::where([
                ['nome', 'like', '%'.$search.'%']
            ])->get();  
        }else{
            $servidores = Servidor::orderBy('created_at','desc')->get();//ordenando a ultima criada 

        }
        return view('servidores.show',['servidores'=> $servidores,'search' => $search]);

        //$servidores = Servidor::paginate(10);

        //return view('servidores.show',['servidores'=> $servidores]);

        //return view('servidores.show')->with('servidor', $servidores);
    }

    public function create(){
        return view('servidores.create');
    }

    public function store(Request $request){
        $servidor = new Servidor;

        try{
            $servidor->nome = $request->nome;
            $servidor->sobrenome = $request->sobrenome;
            $servidor->matricula = $request->matricula;
            $servidor->cpf = preg_replace("/\D+/", "",$request->cpf);
            $servidor->email = $request->email;
            $servidor->cargo = $request->cargo;
            $servidor->funcao = $request->funcao;
            $servidor->save();
            try{
                $usuario = new User;
                $id_servidor = Servidor::max('id');

                $usuario->name = $request->nome;
                $usuario->sobrenome = $request->sobrenome;
                $usuario->email = $request->email;
                $usuario->password = Hash::make(preg_replace("/\D+/", "",$request->cpf));
                $usuario->tipoGrupo = 'padrao';
                $usuario->id_servidor = $id_servidor;
                $usuario->save();
            }catch(QueryException $e){
                return redirect()->back()->with('msgE','Erro ao criar usuario!');
            } 

            return redirect('/servidor/show')->with('msg','Servidor adicionado com sucesso!');
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
    
    public function alterarGrupo(Request $request){
        $servidor = Servidor::findOrFail($request->id);
        $usuarios = User::all();

        try{
            foreach($usuarios as $usuario){
                if($servidor->id == $usuario->id_servidor){
                    $usuario->tipoGrupo = $request->tipoGrupo;
                    $usuario->save();
                }
            }    
        return redirect('/servidor/show')->with('msg','Servidor editado com sucesso!');
        }catch(QueryException $e){
        return redirect('/servidor/show')->with('msgE','Erro ao editar servidor!');
        }
    }

}
