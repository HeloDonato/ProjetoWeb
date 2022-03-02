<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Servidor;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::where('usuario_id', 'not like', '1')->orderBy('alunos.nome')->paginate(10);
        return view('alunos.show',['alunos'=> $alunos]);
    }

    public  function search(Request $request, User $aluno){
        $aluno = new Aluno();
        $search = $request->except('_token');
        $alunos = $aluno->search($request->except('_token'));

        //dd($portarias);
        return view('alunos.show', [
            'alunos' => $alunos,
            'filters' => $search,
        ]);
    }

    public function create(){
        return view('alunos.create');
    }

    public function store(Request $request){
        
        $user = new User;

        try{
            $user->email = $request->email;
            $user->password = Hash::make(preg_replace("/\D+/", "",$request->cpf));
            $user->tipoGrupo = 'padrao';  
            $aluno = new Aluno;
            $aluno->nome = $request->nome;
            $aluno->matricula = $request->matricula;

            $aluno->cpf = preg_replace("/\D+/", "",$request->cpf);
            if (strlen($aluno->cpf ) != 11) {
                return redirect()
                    ->back()    
                    ->withInput()
                    ->with('msgE','Não foi possível registrar o aluno! Cpf inválido!');
            }

            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $aluno->cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($aluno->cpf[$c] != $d) {
                    return redirect()->back()->with('msgE','Não foi possível registrar o aluno! Cpf inválido!');;
                }
            }
                
            //$aluno->curso = $request->curso;
            //$aluno->turma = $request->turma;
            $user->alter_password = 0;
            
            $registros = Aluno::all();

            //Retornando mensagem de erro caso o número de matrícula já exista no banco     
            foreach($registros as $registro){
                if($registro->matricula == $aluno->matricula){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar o aluno! Número da matricula já registrado!');
                }
           
                else if($registro->cpf == $aluno->cpf){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar o aluno! Número de cpf já registrado!');
                }

                else if($registro->email == $user->email){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar o aluno! E-mail já registrado!');
                }
            }
            $user->save();
            $aluno->usuario_id = $user->id;
            $aluno->save();

            return redirect('/aluno/show')->with('msg','Aluno adicionado com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao cadastrar aluno!');
        }
    }

    public function destroy($id){
        $aluno = User::find($id);

        try{
            $aluno->delete();
            return redirect()->back()->with('msg','Aluno excluído com sucesso!!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao excluir!');
        }
    }

    public function edit($id){

        $aluno = User::join('servidores', 'users.id', '=', 'servidores.usuario_id')->findOrFail($id);
        //dd($portaria->id);

        return view('servidores.edit',['servidor' => $aluno]);

    }
    
    public function editProfile($id){

        $aluno = User::findOrFail($id);
        //dd($portaria->id);

        return view('servidores.editProfile',['servidor' => $aluno]);

    }

    public function update(Request $request){
        try{
            $user =  User::findOrFail($request->id);
                $user->email = $request->email;
            $aluno = Servidor::findOrFail($request->id);
                $aluno->nome = $request->nome;
                $aluno->cpf = $request->cpf;
                $aluno->matricula = $request->matricula;
                $aluno->cargo = $request->cargo;
                $aluno->funcao = $request->funcao;
            $user->update();
            $aluno->update();
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
    
    
    public function alterarGrupo(Request $request){
        $aluno = User::findOrFail($request->id);

        try{
            $aluno->tipoGrupo = $request->tipoGrupo;
            $aluno->save();
            return redirect('/servidor/show')->with('msg','Servidor editado com sucesso!');
        }catch(QueryException $e){
            return redirect('/servidor/show')->with('msgE','Erro ao editar servidor!');
        }
    }

}
