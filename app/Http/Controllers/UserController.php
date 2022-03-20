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


class UserController extends Controller
{
    public function alterarGrupo(Request $request){
        $usuario = User::findOrFail($request->id);
        try{
            $usuario->tipoGrupo = $request->tipoGrupo;
            $usuario->save();
            return redirect()->back()->with('msg','Nível de usuário alterado com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao tentar executar mudanças!');
        }
    }

    public function editProfile($id){

        $usuario = User::findOrFail($id);
        //dd($portaria->id);

        return view('editProfile',['usuario' => $usuario]);

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
