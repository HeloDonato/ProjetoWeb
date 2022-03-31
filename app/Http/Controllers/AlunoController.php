<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Servidor;
use App\Models\Curso;
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
        $cursos = DB::table('cursos')->get();
        return view('alunos.create')->with('cursos', $cursos);
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
                
            $aluno->curso_id = $request->curso;
            $aluno->turma = $request->turma;
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
            dd($e);
            return redirect()->back()->with('msgE','Erro ao excluir!');
        }
    }

    public function edit($id){
        $aluno = User::join('alunos', 'users.id', '=', 'alunos.usuario_id')->findOrFail($id);
        $cursos = DB::table('cursos')->get();
        //dd($portaria->id);

        return view('alunos.edit',['aluno' => $aluno, 'cursos' => $cursos]);

    }

    public function adicionarCurso(Request $request){
        $curso = new Curso;

        try{
            $curso->nome = $request->nome;
            $curso->descricao = $request->descricao;
            $curso->save();
            return redirect()->back()->with('msg','Curso adicionado com sucesso!!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao adicionar!');
        }

        //dd($portaria->id);
    }
    public function update(Request $request){       
        try{
            $aluno = ALuno::findOrFail($request->id);
                $aluno->nome = $request->nome;
                $aluno->cpf = $request->cpf;
                $aluno->matricula = $request->matricula;
                $aluno->curso_id = $request->curso;
                $aluno->turma = $request->turma;
            $user =  User::findOrFail($aluno->usuario_id);
                $user->email = $request->email;
            $user->update();
            $aluno->update();
        return redirect('/aluno/show')->with('msg','Aluno editado com sucesso!');
        }catch(QueryException $e){
            return redirect('/aluno/show')->with('msgE','Erro ao editar aluno!');
        }
    }
}
