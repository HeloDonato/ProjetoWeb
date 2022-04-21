<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Portaria;
use App\Models\ServidorPortaria;
use App\Models\Servidor;
use App\Models\AlunoPortaria;
use App\Models\Aluno;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\New_;
use File;
use Exception;

class PortariaController extends Controller
{
    public function index()
    {
        if(auth()->user() == null || auth()->user()->tipoGrupo == 'padrao' )
        {
            $portarias = Portaria::where('sigilo', '=', '0')->orderBy('created_at','desc')->paginate(10);//ordenando a ultima criada 
        }else if(auth()->user()->tipoGrupo != 'padrao')
        {
            $portarias = Portaria::orderBy('created_at','desc')->paginate(10);//ordenando a ultima criada 
        }   
        return view('welcome',['portarias'=> $portarias,'search']);
    }

    public  function search(Request $request, Portaria $portaria){
        $portaria = new Portaria();
        $search = $request->except('_token');

        $portarias = $portaria->search($request->except('_token'));

        //dd($portarias);
        return view('welcome', [
            'portarias' => $portarias,
            'filters' => $search,
        ]);
    }

    public function create(){
        $servidores = DB::table('servidores')->where('servidores.usuario_id', 'not like', '1')->get();
        $alunos = DB::table('alunos')->get();

        return view('portarias.create')->with('servidores', $servidores)->with('alunos', $alunos);
    }

    public function store(Request $request){
        //dd($request->all());
        $portaria = new Portaria;
        //dd($request->id_servidor);
        try{
            $portaria->numPortaria = $request->numPortaria;
            $portaria->titulo = $request->titulo;
            $portaria->descricao = $request->descricao;
            $portaria->dataInicial = $request->dataInicial;
            $portaria->dataFinal = $request->dataFinal;
            $portaria->tipo = $request->tipo;
            $portaria->origem = $request->origem;
            $portaria->sigilo = $request->sigilo;
            if($portaria->tipo == 1)
                $portaria->permaStatus = false;
            elseif($portaria->tipo == 0)
                $portaria->permaStatus = null;

            $registros = Portaria::all();

            //Retornando mensagem de erro caso o número da portaria já exista no banco     
            foreach($registros as $registro){
                if($registro->numPortaria == $portaria->numPortaria){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar a portaria! Número da portaria já registrado!');
                }
            }

            //Retornando mensagem de erro caso a data fianl seja nula para portarias temporárias
            if($portaria->tipo == '0'){
                if($portaria->dataFinal == null){
                    return redirect()
                            ->back()
                            ->withInput()
                            ->with('msgE','Não foi possível registrar a portaria! Data final obrigatória para portarias temporárias!');
                }
            }
            
            //upload do doc

            $portaria_data = $request->all();
            $portaria_data['doc'] = 'false';
            
            $portaria = Portaria::create($portaria_data);
            
            // UPLOAD DOS ARQUIVOS
            if($request->file('doc') != null) {
                $path_controle_frequencia = $request->file('doc')
                                                ->storeAs("portaria/$portaria->id/pdfs","doc.pdf");
                $portaria_data['doc'] = 'true';
            }else{
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('msgE','Não foi possível registrar a portaria! Problemas com o processamento do arquivo!');
            }

            $portaria->update($portaria_data);

            try{
                $ultima_portaria = Portaria::max('id');
                $id_portaria = $ultima_portaria;

                $servidores = Servidor::all();
                $alunos = Aluno::all();
                $id_servidores = $request->id_servidor;
                $id_alunos = $request->id_aluno;

                if(!empty($id_servidores)){
                    foreach($servidores as $servidor){
                        foreach($id_servidores as $id_servidor){
                            if($id_servidor == $servidor->id){
                                $portaria_servidor = new ServidorPortaria;
                                $portaria_servidor->portaria_id= $id_portaria;
                                $portaria_servidor->servidor_id = $id_servidor;
                                $portaria_servidor->save();
                            }
                        }
                    }
                }

                if(!empty($id_alunos)){
                    foreach($alunos as $aluno){
                        foreach($id_alunos as $id_aluno){
                            if($id_aluno == $aluno->id){
                                $portaria_aluno = new AlunoPortaria;
                                $portaria_aluno->portaria_id= $id_portaria;
                                $portaria_aluno->aluno_id = $id_aluno;
                                $portaria_aluno->save();
                            }
                        }
                    }
                }

            }catch(QueryException $e){
                return redirect()->back()->with('msgE','Portaria criada com sucesso, mas não foi possível identificar os servidores e/ou alunos!');
            }
        return redirect('/')->with('msg','Portaria criada com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao criar a portaria!');
        }
    }

    public function myportarias(){
        $user = auth()->user();
        $userId = $user->id;
        $portaria = new Portaria();

        if(!empty(Servidor::find($userId)))
            $portarias = $portaria->minhasPortarias($userId);
        else    
            $portarias = $portaria->minhasPortariasAlunos($userId);

        return view('portarias.myportarias')->with('portarias', $portarias);
    }

    public function portariasServidor($id){
        $user = Servidor::find($id);
        $portaria = new Portaria(); 
        $portarias = $portaria->portariaServidor($user->id);
        //dd($portarias);
        return view('portarias.servidoresPortarias')->with('portarias', $portarias)->with('servidor', $user);
    }
    
    public function portariasAlunos($id){
        $user = Aluno::find($id);
        $portaria = new Portaria(); 
        $portarias = $portaria->portariaAluno($user->id);
        //dd($portarias);
        return view('portarias.alunosPortarias')->with('portarias', $portarias)->with('servidor', $user);
    }


    public function destroy($id){
        $portaria = Portaria::find($id);
        try{
            $portaria->delete();
            return redirect()->back()->with('msg','Portaria excluída com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao excluir!');
        }
    }
    
    public function edit($id){

        $portaria = Portaria::findOrFail($id);
        $participantes = DB::select(DB::raw("select portaria_id, servidor_id, nome FROM servidores_portarias as s 
        INNER JOIN servidores as sv ON s.servidor_id = sv.id where portaria_id = $id;"));
        $participantesA = DB::select(DB::raw("select portaria_id, aluno_id, nome FROM alunos_portarias as a 
        INNER JOIN alunos as al ON a.aluno_id = al.id where portaria_id = $id;"));
        $servidores = User::join('servidores', 'users.id', '=', 'servidores.usuario_id')->where('users.id', 'not like', '1')->get();
        $alunos = User::join('alunos', 'users.id', '=', 'alunos.usuario_id')->where('users.id', 'not like', '1')->get();
        //dd($portaria->id);

        return view('portarias.edit',['portaria' => $portaria, 'participantes'=>$participantes, 
        'servidores'=>$servidores, 'participantesA'=>$participantesA, 'alunos'=>$alunos]);

    }
    
    public function update(Request $request){
        try{
            $portaria = new Portaria;
            Portaria::findOrFail($request->id)->update($request->all());
            $portaria_data = $request->all();
            
        
            // UPLOAD DOS ARQUIVOS
            //dd($request->all());
            if($request->file('doc')) {
                $file = storage_path('portarias'.$request->id."/pdfs"."/doc.pdf");
                File::delete($file);
                /* $path_controle_frequencia = $request->file('doc')
                     ->storeAs("portaria/$portaria->id/pdfs","doc.pdf");*/
                $path =  $request->file('doc')->storeAs($request->id."/pdfs", '/doc.pdf', 'portarias');
                $portaria_data['doc'] = 'true';
            }

            $portaria->update($portaria_data);

            try{
                $portaria = Portaria::findOrFail($request->id);
                $id_portaria = $portaria->id;

                $servidores = Servidor::all();
                $id_servidores = $request->id_servidor;
                
                $alunos = Aluno::all();
                $id_alunos = $request->id_aluno;

                
                if($request->id_servidor != null){

                    DB::table('servidores_portarias')->where('portaria_id', '=', $id_portaria)->delete();
                    DB::table('alunos_portarias')->where('portaria_id', '=', $id_portaria)->delete();

                    foreach($servidores as $servidor){
                        foreach($id_servidores as $id_servidor){
                            if($id_servidor == $servidor->id){
                                $portaria_servidor = new ServidorPortaria;
                                $portaria_servidor->portaria_id = $id_portaria;
                                $portaria_servidor->servidor_id  = $id_servidor;
                                $portaria_servidor->save();
                            }
                        }
                    }

                    if(!empty($id_alunos)){
                        foreach($alunos as $aluno){
                            foreach($id_alunos as $id_aluno){
                                if($id_aluno == $aluno->id){
                                    $portaria_aluno = new AlunoPortaria;
                                    $portaria_aluno->portaria_id= $id_portaria;
                                    $portaria_aluno->aluno_id = $id_aluno;
                                    $portaria_aluno->save();
                                }
                            }
                        }
                    }

                }
            }catch(QueryException $e){
                    return redirect()->back()->with('msgE','Portaria criada com sucesso, mas não foi possível identificar os servidores!');
            }

            return redirect('/')->with('msg','Portaria editada com sucesso!');
        }catch(\Exception $e){
            return redirect('/')->with('msgE','Erro ao editar portaria!');
        }

    }

    public function download(Request $request,$id){

        return response()->download(storage_path('app/portaria/'.$id.'/pdfs/doc.pdf'));    

    }

    public function view(Request $request,$id){

        $portaria = $request->all();

        $docFile = "portaria/$id/pdfs/doc.pdf";

        return response()->file(storage_path("app/$docFile"));


    }

}



