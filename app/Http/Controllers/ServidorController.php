<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Servidor;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ServidorController extends Controller
{
    public function index()
    {
        $servidores = Servidor::where('usuario_id', 'not like', '1')->orderBy('servidores.nome')->paginate(10);
        return view('servidores.show',['servidores'=> $servidores]);
    }

    public  function search(Request $request, User $servidor){
        $servidor = new Servidor();
        $search = $request->except('_token');
        $servidores = $servidor->searchServidores($request->except('_token'));

        //dd($portarias);
        return view('servidores.show', [
            'servidores' => $servidores,
            'filters' => $search,
        ]);
    }

    public function create(){
        return view('servidores.create');
    }

    public function store(Request $request){
        
        $user = new User;

        try{
            $user->email = $request->email;
            $user->password = Hash::make(preg_replace("/\D+/", "",$request->cpf));
            $user->tipoGrupo = 'padrao';  
            $servidor = new Servidor;
            $servidor->nome = $request->nome;
            $servidor->matricula = $request->matricula;

            $servidor->cpf = preg_replace("/\D+/", "",$request->cpf);
            if (strlen($servidor->cpf ) != 11) {
                return redirect()
                    ->back()    
                    ->withInput()
                    ->with('msgE','Não foi possível registrar o servidor! Cpf inválido!');
            }

            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $servidor->cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($servidor->cpf[$c] != $d) {
                    return redirect()->back()->with('msgE','Não foi possível registrar o servidor! Cpf inválido!');;
                }
            }
                
            $servidor->cargo = $request->cargo;
            $servidor->funcao = $request->funcao;
            $user->alter_password = 0;


            
            $registros = Servidor::all();

            //Retornando mensagem de erro caso o número da portaria já exista no banco     
            foreach($registros as $registro){
                if($registro->matricula == $servidor->matricula){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar o servidor! Número da matricula já registrado!');
                }
           
                else if($registro->cpf == $servidor->cpf){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar o servidor! Número de cpf já registrado!');
                }

                else if($registro->email == $user->email){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar o servidor! E-mail já registrado!');
                }
            }
            $user->save();
            $servidor->usuario_id = $user->id;
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
        $servidor = User::join('servidores', 'users.id', '=', 'servidores.usuario_id')->findOrFail($id);
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
            $servidor = Servidor::findOrFail($request->id);
                $servidor->nome = $request->nome;
                $servidor->cpf = $request->cpf;
                $servidor->matricula = $request->matricula;
                $servidor->cargo = $request->cargo;
                $servidor->funcao = $request->funcao;
            $user =  User::findOrFail($servidor->usuario_id);
                $user->email = $request->email;
            $user->update();
            $servidor->update();
        return redirect('/servidor/show')->with('msg','Servidor editado com sucesso!');
        }catch(QueryException $e){
        return redirect('/servidor/show')->with('msgE','Erro ao editar servidor!');
        }
    }

    public function updateProfile(Request $request){
        // The passwords matches
            $input = $request->all();

            if (! Hash::check($input['senhaAntiga'],auth()->user()->password)){
                return redirect()->back()->with('msgE','Senha antiga não corresponde');
            }
            
            $msg = [
                'same'    => 'Senhas precisam ser iguais',
                'different'    => 'Senha atual igual à antiga',
            ];
            
            $user = User::findOrFail($request->id);
            $validator = Validator::make($request->all(),[
                'senhaAntiga' => ['required', 'different:newPassword'],
                'newPassword' => ['required', 'min:8', 'different   :senhaAntiga'],
                'confirmaSenha' => ['required', 'same:newPassword']
            ], $msg);

            if($validator->fails()){
                #
                return redirect()->back()->with('msgE','Erro ao editar senha!');
            }else{
                try{
                    $user_id = $request->id;
                    $user->password =  Hash::make($request->newPassword);
                    $user->alter_password = 1;
                    $user->save();
                    return redirect()->back()->with("msg","Senha alterada com suucesso!");
                   
                }catch(QueryException $e){
                    return redirect()->back()->with('msgE','Erro ao editar senha!');
                } 
            }   
        }
}
