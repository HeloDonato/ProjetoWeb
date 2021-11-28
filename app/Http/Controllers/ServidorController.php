<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ServidorController extends Controller
{
    public function index()
    {
        /*$search = request('search');//buscar
        if($search){
            $servidores = User::where([
                ['nome', 'like', '%'.$search.'%']
            ])->get();  
        }else{
            $servidores = User::orderBy('created_at','desc')->get();//ordenando a ultima criada 

        }*/
        $servidores = DB::table('users')->where('users.id', 'not like', '1')->paginate(10);
        return view('servidores.show',['servidores'=> $servidores]);

        //$servidores = Servidor::paginate(10);

        //return view('servidores.show',['servidores'=> $servidores]);

        //return view('servidores.show')->with('servidor', $servidores);
    }

    public function create(){
        return view('servidores.create');
    }

    public function store(Request $request){
        
        $servidor = new User;
        

        try{
            $servidor->email = $request->email;
            $servidor->password = Hash::make(preg_replace("/\D+/", "",$request->cpf));
            $servidor->tipoGrupo = 'padrao';  
            $servidor->nome = $request->nome;
            $servidor->sobrenome = $request->sobrenome;
            $servidor->matricula = $request->matricula;
            $servidor->cpf = preg_replace("/\D+/", "",$request->cpf);
            $servidor->cargo = $request->cargo;
            $servidor->funcao = $request->funcao;
            $servidor->save();


            return redirect('/servidor/show')->with('msg','Servidor adicionado com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao criar servidor!');
        }
    }

    public function destroy($id){
        $servidor = User::find($id);
        try{
            $servidor->delete();
            return redirect()->back()->with('msg','Servidor excluído com sucesso!!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao excluir!');
        }
    }

    public function edit($id){

        $servidor = User::findOrFail($id);
        //dd($portaria->id);

        return view('servidores.edit',['servidor' => $servidor]);

    }
    
    public function editProfile($id){

        $servidor = User::findOrFail($id);
        //dd($portaria->id);

        return view('servidores.editProfile',['servidor' => $servidor]);

    }

    public function update(Request $request){
        try{
            User::findOrFail($request->id)->update($request->all());
        return redirect('/servidor/show')->with('msg','Servidor editado com sucesso!');
        }catch(QueryException $e){
        return redirect('/servidor/show')->with('msgE','Erro ao editar servidor!');
        }
    }

    public function updateProfile(Request $request){
        // The passwords matches
            $validator = Validator::make($request->all(),[
                'newPassword' => ['required', 'min:8'],
                'confirmaSenha' => ['required', 'same:newPassword']
            ]);

            if($validator->fails()){
                return redirect()->back()->with('msgE','Erro ao editar senha!');
            }else{
                try{
                    $user_id = $request->id;
                    $user = User::findOrFail($request->id);
                    $user->password =  Hash::make($request->newPassword);
                    $user->save();
                    return redirect()->back()->with("msg","Senha alterada com suucesso!");
                }catch(QueryException $e){
                    return redirect()->back()->with('msgE','Erro ao editar senha!');
                } 
            }   
        }
    
    
    public function alterarGrupo(Request $request){
        $servidor = User::findOrFail($request->id);

        try{
            $servidor->tipoGrupo = $request->tipoGrupo;
            $servidor->save();
            return redirect('/servidor/show')->with('msg','Servidor editado com sucesso!');
        }catch(QueryException $e){
            return redirect('/servidor/show')->with('msgE','Erro ao editar servidor!');
        }
    }

}
