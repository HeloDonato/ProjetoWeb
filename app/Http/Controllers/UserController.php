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
        $servidor = User::findOrFail($request->id);

        try{
            $servidor->tipoGrupo = $request->tipoGrupo;
            $servidor->save();
            return redirect('/servidor/show')->with('msg','Nível de usuário alterado com sucesso!');
        }catch(QueryException $e){
            return redirect('/servidor/show')->with('msgE','Erro ao tentar executar mudanças!');
        }
    }

}
